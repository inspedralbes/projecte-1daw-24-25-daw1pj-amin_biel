<?php
require "../connexio.php"; 

if (!isset($_GET["id_incidencia"])) {
    die("Error: No s'ha proporcionat cap ID.");
}


$id_incidencia = $_GET["id_incidencia"];

$sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, T.ID_TECNIC,
               D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.NOM_TECNIC, P.DESCRIPCIO AS NOM_PRIORITAT, TIP.DESCRIPCIO AS NOM_TIPUS
        FROM INCIDENCIES I
        JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
        JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
        JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
        JOIN PRIORITAT P ON I.ID_PRIORITAT = P.ID_PRIORITAT
        JOIN TIPUS_INCIDENCIA TIP ON I.ID_TIPUS_INCIDENCIA = TIP.ID_TIPUS
        WHERE I.ID_INCIDENCIA = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_incidencia);
$stmt->execute();
$result = $stmt->get_result();
$incidencia = $result->fetch_assoc();

if (!$incidencia) {
    die("Error: La incidència no existeix.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*obtenim el id de la linia actuacio*/ 
    $select_actuacio = "SELECT IFNULL(MAX(LINIA_ACTUACIO), 0) + 1 AS seguent_linia  FROM ACTUACIO_INCIDENCIA WHERE ID_INCIDENCIA = ?";
    $stmt_linia = $conn->prepare($select_actuacio);
    $stmt_linia->bind_param("i", $id_incidencia);
    $stmt_linia->execute();
    $result = $stmt_linia->get_result();
    $linia_actuacio = $result->fetch_assoc();
    $linia_actuacio = $linia_actuacio['seguent_linia'];

    // Obtenim el temps invertit i la descripcio de l'actuacio
    $temps_invertit = $_POST["temps_invertit"];
    $descripcio_actuacio = $_POST["descripcio_actuacio"];

    //obtenim el valor del nou estat
    $nou_estat = intval($_POST["id_estat"]);

    //fem el update primer de tot
    $sql_update = "UPDATE INCIDENCIES SET ID_ESTAT = ? WHERE ID_INCIDENCIA = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $nou_estat, $id_incidencia);

        //executem el insert
    $sql_insert = "INSERT INTO ACTUACIO_INCIDENCIA (ID_INCIDENCIA, LINIA_ACTUACIO, DATA_ACTUACIO, ESTAT_INCIDENCIA, TEMPS_INVERTIT, DESCRIPCIO_ACTUACIO)
                   VALUES (?, ?, SYSDATE(), ?, ?, ?)";

    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiiss", $id_incidencia, $linia_actuacio, $nou_estat, $temps_invertit, $descripcio_actuacio);

    if ($stmt_update->execute()) {
        // Si l'UPDATE va bé, fem el INSERT
        $stmt_insert->execute();
        header("Location: llistatTecnics.php?id_tecnic=" . $incidencia['ID_TECNIC']);
        exit();
    } else {
        echo "<p>Error en actualitzar la incidència: " . $conn->error . "</p>";
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'incidències dels tècnics</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>
<body>
    <form id="formulari-llistat"method="POST">
        <h1>DESCRIPCIO ACTUACIÓ</h1>
        <div class="descripcio">
            <label for="descripcio" class="descripcio-label"></label>
            <textarea id="descripcio" class="descripcio-input" placeholder="La meva actuació ha sigut..." name="descripcio_actuacio"></textarea>
        </div>  
        <h1>TEMPS INVERTIT</h1>
        <div class="descripcio">
            <div class="grup-input">
                <label for="temps_invertit" class="input-label">Temps invertit (HH:MM):</label>
                <input type="time" id="temps_invertit" class="input-dintre" name="temps_invertit" required>
            </div>
        </div>    
        <h1>UPDATE ACTUACIO</h1>
        <div class="dades">
            <div class="grup-input">
                <select name="id_estat">
                    <option value="2" <?= $incidencia["ID_ESTAT"] == 2 ? "selected" : "" ?>>En Procés</option>
                    <option value="3" <?= $incidencia["ID_ESTAT"] == 3 ? "selected" : "" ?>>Acabada</option>
                </select>
            </div>    
        </div>    
        <div class="botons-update">
            <a class="enrera"href="llistatTecnics.php">Tornar</a>
            <button type='submit'>Guardar Canvis</button>

        </div>
    </form>
</body>
</html>
