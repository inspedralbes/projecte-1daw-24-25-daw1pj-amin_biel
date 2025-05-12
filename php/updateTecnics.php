<?php
require "connexio.php"; 

if (!isset($_GET["id"])) {
    die("Error: No s'ha proporcionat cap ID.");
}

$id_incidencia = $_GET["id"];

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
    $nou_estat = intval($_POST["id_estat"]);

    $sql_update = "UPDATE INCIDENCIES SET ID_ESTAT = ? WHERE ID_INCIDENCIA = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $nou_estat, $id_incidencia);

    if ($stmt_update->execute()) {
        header("Location: llistatTecnics.php");
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
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="DissenyFormularis.css">
</head>
<body>
    <div class="centrar">
        <form id="formulari-llistat"method="POST">
            <h1>Editar Incidència</h1>
                <table>
                    <tr>
                        <th>ID_INCIDENCIA</th>
                        <th>TECNIC</th>
                        <th>ID_TECNIC</th>
                        <th>DEPARTAMENT</th>
                        <th>ORDINADOR</th>
                        <th>DATA_INICI</th>
                        <th>DESCRIPCIÓ</th>
                        <th>ESTAT</th>
                        <th>PRIORITAT</th>
                        <th>TIPUS</th>
                    </tr>
                    <tr>
                        <td><?= htmlspecialchars($incidencia["ID_INCIDENCIA"]) ?></td>
                        <td><?= htmlspecialchars($incidencia["NOM_TECNIC"]) ?></td>
                        <td><?= isset($incidencia["ID_TECNIC"]) ? htmlspecialchars($incidencia["ID_TECNIC"]) : "" ?></td>
                        <td><?= htmlspecialchars($incidencia["NOM_DEPARTAMENT"]) ?></td>
                        <td><?= htmlspecialchars($incidencia["ORDINADOR"]) ?></td>
                        <td><?= htmlspecialchars($incidencia["DATA_INICI"]) ?></td>
                        <td><?= htmlspecialchars($incidencia["DESCRIPCIO"]) ?></td>
                        <td>
                            <select name="id_estat">
                                <option value="1" <?= $incidencia["ID_ESTAT"] == 1 ? "selected" : "" ?>>Assignada</option>
                                <option value="2" <?= $incidencia["ID_ESTAT"] == 2 ? "selected" : "" ?>>En Procés</option>
                                <option value="3" <?= $incidencia["ID_ESTAT"] == 3 ? "selected" : "" ?>>Acabada</option>
                            </select>
                        </td>
                        <td><?= htmlspecialchars($incidencia["NOM_PRIORITAT"]) ?></td>
                        <td><?= htmlspecialchars($incidencia["NOM_TIPUS"]) ?></td>
                    </tr>
                </table>
            <div class="botons-update">
                <a class="enrera"href="llistatTecnics.php">Tornar</a>

                <?php
                /*FA FALTA MODIFICAR EL CODI PERQUE QUAN LI DONIS A GUARDAR ET MOSTRI EL LLISTAT*/
                echo"<a href='llistatTecnics.php?id=" . $incidencia["ID_TECNIC"] . "' class='enrera'>";
                echo"<button type='submit'>Guardar Canvis</button>";
                echo "</a>";
                ?>
            </div>
        </form>
    </div>
</body>
</html>
