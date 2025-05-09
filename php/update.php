<?php
require "connexio.php"; 

if (!isset($_GET["id"])) {
    die("Error: No s'ha proporcionat cap ID.");
}

$id_incidencia = $_GET["id"];

$sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_TECNIC, I.ID_PRIORITAT, I.ID_TIPUS_INCIDENCIA,
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
    $nou_tecnic = intval($_POST["id_tecnic"]);
    $nova_prioritat = intval($_POST["id_prioritat"]);
    $nou_tipus = intval($_POST["id_tipus"]);

    $sql_update = "UPDATE INCIDENCIES SET ID_TECNIC = ?, ID_PRIORITAT = ?, ID_TIPUS_INCIDENCIA = ? WHERE ID_INCIDENCIA = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiii", $nou_tecnic, $nova_prioritat, $nou_tipus, $id_incidencia);

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
                <th>INCIDENCIA</th><th>TECNIC</th><th>ID_TECNIC</th><th>DEPARTAMENT</th><th>ORDINADOR</th><th>DATA_INICI</th><th>DESCRIPCIO</th><th>ESTAT</th><th>PRIORITAT</th><th>TIPUS</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($incidencia["ID_INCIDENCIA"]) ?></td>
                <td><?= htmlspecialchars($incidencia["NOM_TECNIC"]) ?></td>
                <td>
                    <select name="id_tecnic">
                        <option value="1" <?= $incidencia["ID_TECNIC"] == 1 ? "selected" : "" ?>>Miquel Garcia</option>
                        <option value="2" <?= $incidencia["ID_TECNIC"] == 2 ? "selected" : "" ?>>Lautaro Garcia</option>
                        <option value="3" <?= $incidencia["ID_TECNIC"] == 3 ? "selected" : "" ?>>Laura Torres</option>
                        <option value="4" <?= $incidencia["ID_TECNIC"] == 4 ? "selected" : "" ?>>Jordi Puig</option>
                        <option value="5" <?= $incidencia["ID_TECNIC"] == 5 ? "selected" : "" ?>>Anna Soler</option>
                        <option value="6" <?= $incidencia["ID_TECNIC"] == 6 ? "selected" : "" ?>>Pau Vidal</option>
                        <option value="7" <?= $incidencia["ID_TECNIC"] == 7 ? "selected" : "" ?>>Clara Riera</option>
                        <option value="8" <?= $incidencia["ID_TECNIC"] == 8 ? "selected" : "" ?>>Marc Ferrer</option>
                        <option value="9" <?= $incidencia["ID_TECNIC"] == 9 ? "selected" : "" ?>>Núria Pons</option>
                        <option value="10" <?= $incidencia["ID_TECNIC"] == 10 ? "selected" : "" ?>>Oriol Martí</option>
                    </select>
                </td>
                <td><?= htmlspecialchars($incidencia["NOM_DEPARTAMENT"]) ?></td>
                <td><?= htmlspecialchars($incidencia["ORDINADOR"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DATA_INICI"]) ?></td>
                <td><?= htmlspecialchars($incidencia["DESCRIPCIO"]) ?></td>
                <td><?= isset($incidencia["NOM_ESTAT"]) ? htmlspecialchars($incidencia["NOM_ESTAT"]) : "" ?></td>
                <td>
                    <select name="id_prioritat">
                        <option value="1">Cap</option>
                        <option value="2">Baixa</option>
                        <option value="3">Mitjana</option>
                        <option value="4">Alta</option>
                        <option value="5">Crítica</option>
                    </select>
                </td>
                <td>
                    <select name="id_tipus">
                        <option value="1">Sense Assignar</option>
                        <option value="2">Xarxa</option>
                        <option value="3">Ratolí</option>
                        <option value="4">Teclat</option>
                        <option value="5">Connexió a Internet</option>
                        <option value="6">Pantalla</option>
                        <option value="7">Software</option>
                        <option value="8">Servidor</option>
                        <option value="9">Correu Electrònic</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit">Guardar Canvis</button>
    </form>

    <a href="llistat.php">Tornar al llistat</a>
</body>
</html>
