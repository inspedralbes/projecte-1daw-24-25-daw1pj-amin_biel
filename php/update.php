<?php
require "connexio.php"; 

if (!isset($_GET["id"])) {
    die("Error: No s'ha proporcionat cap ID.");
}

$id_incidencia = $_GET["id"];

$sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_TECNIC, I.ID_PRIORITAT,
               D.DESCRIPCIO AS NOM_DEPARTAMENT, T.NOM_TECNIC, P.DESCRIPCIO AS NOM_PRIORITAT
        FROM INCIDENCIES I
        JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
        JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
        JOIN PRIORITAT P ON I.ID_PRIORITAT = P.ID_PRIORITAT
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
    $nou_tecnic = intval($_POST["id_tecnic"]);
    $nova_prioritat = intval($_POST["id_prioritat"]);

    $sql_update = "UPDATE INCIDENCIES SET ID_TECNIC = ?, ID_PRIORITAT = ? WHERE ID_INCIDENCIA = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $nou_tecnic, $nova_prioritat, $id_incidencia);

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
    <title>Editar Incidència</title>
</head>
<body>
    <h1>Editar Incidència</h1>

    <form method="POST">
        <table border="1">
            <tr>
                <th>ID_INCIDENCIA</th><th>NOM_TECNIC</th><th>ID_TECNIC</th><th>NOM_DEPARTAMENT</th><th>ORDINADOR</th><th>DATA_INICI</th><th>DESCRIPCIO</th><th>NOM_ESTAT</th><th>NOM_PRIORITAT</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($incidencia["ID_INCIDENCIA"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_TECNIC"]) ?></td>
                <td><?= htmlspecialchars($incidencia["ID_TECNIC"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_DEPARTAMENT"]) ?></td>
                <td><?= htmlspecialchars($incidencia["ORDINADOR"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DATA_INICI"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DESCRIPCIO"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_ESTAT"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_PRIORITAT"]) ?></td>




                <td>
                    <select name="id_tecnic">
                        <option value="1" <?= $incidencia["ID_TECNIC"] == 1 ? "selected" : "" ?>>Miquel Garcia</option>
                        <option value="2" <?= $incidencia["ID_TECNIC"] == 2 ? "selected" : "" ?>>Lautaro Garcia</option>
                    </select>
                </td>
                <td>
                    <select name="id_prioritat">
                        <option value="1">Cap</option>
                        <option value="2">Baixa</option>
                        <option value="3">Mitjana</option>
                        <option value="4">Alta</option>
                        <option value="5">Crítica</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">Guardar Canvis</button>
    </form>

    <a href="llistat.php">Tornar al llistat</a>
</body>
</html>
