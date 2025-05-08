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
    <?php
    $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, T.NOM_TECNIC,T.ID_TECNIC,
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.NOM_TECNIC 
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
            ORDER BY I.ID_INCIDENCIA ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <div id="formulari-llistat">
            <h1>Llistat d'incidències</h1>
            <table id="taula-llistat">
            <thead>
              <tr>
                  <th>ID_INCIDENCIA</th>
                  <th>NOM_TECNIC</th>
                  <th>ID_TECNIC</th>
                  <th>DEPARTAMENT</th>
                  <th>ORDINADOR</th>
                  <th>DATA_INICI</th>
                  <th>DESCRIPCIO</th>
                  <th>ESTAT</th>
                  <th>ACCIONS</th>
              </tr>
            </thead>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ID_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ORDINADOR"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
            echo "<td>
                    <a href='esborrar.php?id=" . $row["ID_INCIDENCIA"] . "' class='links-update'>Esborrar</a> | 
                    <a href='update.php?id=" . $row["ID_INCIDENCIA"] . "' class = 'links-update'>Editar</a>
                  </td>";
            echo "</tr>";
        }
        ?> 
        </table>
            <div class="boto-llistat">
              <a class="enrera"  href="PaginaAdministrador.html">Enrera</a>
            </div>
        </div>
        <?php
    } else {
        echo "<p>No hi ha incidències registrades.</p>";
    }

    $conn->close();
    ?>

</body>

</html>
