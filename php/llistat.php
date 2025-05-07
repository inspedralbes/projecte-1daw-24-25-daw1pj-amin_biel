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
    $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, I.ID_TECNIC,
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.NOM_TECNIC 
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
            ORDER BY I.DATA_INICI DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Data Inici</th><th>Descripció</th><th>Departament</th><th>Estat</th><th>Ordinador</th><th>Tècnic</th><th>Accions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ORDINADOR"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_TECNIC"]) . "</td>";
            echo "<td>
                    <a href='esborrar.php?id=" . $row["ID_INCIDENCIA"] . "'>Esborrar</a> | 
                    <a href='update.php?id=" . $row["ID_INCIDENCIA"] . "'>Editar</a>
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
