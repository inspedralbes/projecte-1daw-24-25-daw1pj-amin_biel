<?php
require "../connexio.php"; 

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
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>
<body>
    <div class="centrar">
        <form id="formulari-llistat"method="POST">
            <h1>Editar Incidència</h1>
            <table>
                <tr>
                    <th>INCIDENCIA</th><th>TECNIC</th><th>ID_TECNIC</th><th>DEPARTAMENT</th><th>ORDINADOR</th><th>DATA_INICI</th><th>DESCRIPCIO</th><th>ESTAT</th><th>PRIORITAT</th><th>TIPUS</th>
                </tr>
                <tr>
                    <td><?= htmlspecialchars($incidencia["ID_INCIDENCIA"]) ?></td>
                    <td><?= htmlspecialchars($incidencia["NOM_TECNIC"]) ?></td>
                    <td>
                        <div class="grup-input">
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
                        </div>    
                    </td>
                    <td><?= htmlspecialchars($incidencia["NOM_DEPARTAMENT"]) ?></td>
                    <td><?= htmlspecialchars($incidencia["ORDINADOR"]) ?></td>
                    <td><?= htmlspecialchars($incidencia["DATA_INICI"]) ?></td>
                    <td><?= htmlspecialchars($incidencia["DESCRIPCIO"]) ?></td>
                    <td><?= isset($incidencia["NOM_ESTAT"]) ? htmlspecialchars($incidencia["NOM_ESTAT"]) : "" ?></td>
                    <td>
                        <div class="grup-input">
                            <select name="id_prioritat">
                                <option value="1" <?= $incidencia["ID_PRIORITAT"] == 1 ? "selected" : "" ?>>Cap</option>
                                <option value="2" <?= $incidencia["ID_PRIORITAT"] == 2 ? "selected" : "" ?>>Baixa</option>
                                <option value="3" <?= $incidencia["ID_PRIORITAT"] == 3 ? "selected" : "" ?>>Mitjana</option>
                                <option value="4" <?= $incidencia["ID_PRIORITAT"] == 4 ? "selected" : "" ?>>Alta</option>
                                <option value="5" <?= $incidencia["ID_PRIORITAT"] == 5 ? "selected" : "" ?>>Crítica</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="grup-input">
                            <select name="id_tipus">
                                <option value="1" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 1 ? "selected" : "" ?>>Sense Assignar</option>
                                <option value="2" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 2 ? "selected" : "" ?>>Xarxa</option>
                                <option value="3" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 3 ? "selected" : "" ?>>Ratolí</option>
                                <option value="4" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 4 ? "selected" : "" ?>>Teclat</option>
                                <option value="5" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 5 ? "selected" : "" ?>>Connexió a Internet</option>
                                <option value="6" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 6 ? "selected" : "" ?>>Pantalla</option>
                                <option value="7" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 7 ? "selected" : "" ?>>Software</option>
                                <option value="8" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 8 ? "selected" : "" ?>>Servidor</option>
                                <option value="9" <?= $incidencia["ID_TIPUS_INCIDENCIA"] == 9 ? "selected" : "" ?>>Correu Electrònic</option>
                            </select>
                        </div>
                    </td>

                </tr>
            </table>
            <div class="botons-update">
                <a class="enrera"href="./llistat.php">Tornar</a>
                <button type="submit">Guardar Canvis</button>
            </div>
        </form>
    </div>
</body>
</html>
