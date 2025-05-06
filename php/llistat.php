<?php
require "connexio.php"; 
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'incidències</title>
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="estils.css">
</head>

<body>
    <h1>Llistat d'incidències</h1>
    <?php
    $sql = "SELECT ID_INCIDENCIA, DATA_INICI, DESCRIPCIO, NOM_DEPARTAMENT FROM INCIDENCIES";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Data Inici</th><th>Descripció</th><th>Accions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>
                    <a href='editar.php?id=" . $row["ID_INCIDENCIA"] . "'> Editar</a> |
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
