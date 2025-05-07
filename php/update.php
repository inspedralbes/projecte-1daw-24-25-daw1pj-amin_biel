<?php
require "connexio.php"; 

if (!isset($_GET["id"])) {
    die("Error: No s'ha proporcionat cap ID.");
}

$id_incidencia = $_GET["id"];

// Carregar dades de la incidència
$sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, I.ID_TECNIC,
               D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.NOM_TECNIC 
        FROM INCIDENCIES I
        JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
        JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
        JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
        WHERE I.ID_INCIDENCIA = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_incidencia);
$stmt->execute();
$result = $stmt->get_result();
$incidencia = $result->fetch_assoc();

if (!$incidencia) {
    die("Error: La incidència no existeix.");
}

// Si s'envia el formulari, actualitzar la incidència
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nou_estat = $_POST["id_estat"];
    $nou_tecnic = $_POST["id_tecnic"];

    $sql_update = "UPDATE INCIDENCIES SET ID_ESTAT = ?, ID_TECNIC = ? WHERE ID_INCIDENCIA = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $nou_estat, $nou_tecnic, $id_incidencia);

    if ($stmt_update->execute()) {
        header("Location: llistat.php");
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
    <title>Editar Incidència</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h1>Editar Incidència</h1>

    <form method="POST">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Data Inici</th>
                <th>Descripció</th>
                <th>Departament</th>
                <th>Ordinador</th>
                <th>Estat</th>
                <th>Tècnic</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($incidencia["ID_INCIDENCIA"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DATA_INICI"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DESCRIPCIO"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_DEPARTAMENT"]) ?></td>
                <td><?= htmlspecialchars($incidencia["ORDINADOR"]) ?></td>
                <td>
                    <select name="id_estat">
                        <option value="1" <?= $incidencia["ID_ESTAT"] == 1 ? "selected" : "" ?>>Sense Assignar</option>
                        <option value="2" <?= $incidencia["ID_ESTAT"] == 2 ? "selected" : "" ?>>En Procés</option>
                        <option value="3" <?= $incidencia["ID_ESTAT"] == 3 ? "selected" : "" ?>>Acabada</option>
                    </select>
                </td>
                <td>
                    <select name="id_tecnic">
                        <option value="1" <?= $incidencia["ID_TECNIC"] == 1 ? "selected" : "" ?>>Miquel Garcia</option>
                        <option value="2" <?= $incidencia["ID_TECNIC"] == 2 ? "selected" : "" ?>>Laura Torres</option>
                        <option value="3" <?= $incidencia["ID_TECNIC"] == 3 ? "selected" : "" ?>>Jordi Puig</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>
        <button type="submit">Guardar Canvis</button>
    </form>
    
    <br>
    <a href="llistat.php">Tornar al llistat</a>
</body>
</html>
