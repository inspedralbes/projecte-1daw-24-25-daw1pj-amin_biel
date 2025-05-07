<?php
require "connexio.php"; 
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'incidències</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="DissenyFormularis.css">
</head>

<body>
    <h1>Llistat d'incidències</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_incidencia"])) {
        $id_incidencia = $_POST["id_incidencia"];
        $nova_descripcio = $_POST["nova_descripcio"];
        $nou_departament = $_POST["id_departament"];
        $nou_estat = $_POST["id_estat"];
        $nou_ordinador = $_POST["ordinador"];
        $nova_data_inici = $_POST["data_inici"];

        $sql_update = "UPDATE INCIDENCIES SET DESCRIPCIO = ?, ID_DEPARTAMENT = ?, ID_ESTAT = ?, ORDINADOR = ?, DATA_INICI = ? WHERE ID_INCIDENCIA = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("siiisi", $nova_descripcio, $nou_departament, $nou_estat, $nou_ordinador, $nova_data_inici, $id_incidencia);

        if ($stmt_update->execute()) {
            echo "<p style='color: green;'>Incidència actualitzada correctament!</p>";
        } else {
            echo "<p style='color: red;'>Error en actualitzar: " . $conn->error . "</p>";
        }

        $stmt_update->close();
    }

    $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, 
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT 
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            ORDER BY I.DATA_INICI DESC";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Data Inici</th><th>Descripció</th><th>Departament</th><th>Estat</th><th>Ordinador</th><th>Accions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ORDINADOR"]) . "</td>";
            echo "<td>
                    <form method='POST'>
                        <input type='hidden' name='id_incidencia' value='" . $row["ID_INCIDENCIA"] . "'>
                        <input type='text' name='nova_descripcio' value='" . htmlspecialchars($row["DESCRIPCIO"]) . "' required>
                        <input type='date' name='data_inici' value='" . $row["DATA_INICI"] . "' required>
                        <select name='id_departament'>
                            <option value='1'>Matemàtiques</option>
                            <option value='2'>Ciències Naturals</option>
                            <option value='3'>Tecnologia</option>
                            <option value='4'>Llengües</option>
                            <option value='5'>Informàtica</option>
                        </select>
                        <select name='id_estat'>
                            <option value='1'>Sense Assignar</option>
                            <option value='2'>En Procés</option>
                            <option value='3'>Acabada</option>
                        </select>
                        <input type='number' name='ordinador' value='" . htmlspecialchars($row["ORDINADOR"]) . "' required>
                        <button type='submit'>Guardar Canvis</button>
                    </form>
                    <a href='esborrar.php?id=" . $row["ID_INCIDENCIA"] . "'> Esborrar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hi ha incidències registrades.</p>";
    }

    $conn->close();
    ?>

    <div id="menu">
        <hr>
        <p><a href="index.php">Portada</a></p>
        <p><a href="crear.php">Crear</a></p>
    </div>

</body>

</html>
