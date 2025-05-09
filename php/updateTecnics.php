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
    <title>Editar Estat de la Incidència</title>
</head>
<body>
    <h1>Editar Estat de la Incidència</h1>

    <form method="POST">
        <table border="1">
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
        <button type="submit">Guardar Canvis</button>
    </form>

    <a href="llistatTecnics.php">Tornar al llistat</a>
</body>
</html>
