<?php
require "../connexio.php"; 
include "../funcioMongo.php";

$Usuari = 'Admin';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Informes Tècnics';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes Actuacions dels Tècnics</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>
<body>
    <?php
    $sql = "SELECT T.ID_TECNIC, T.NOM_TECNIC, A.ID_INCIDENCIA, A.LINIA_ACTUACIO, A.DATA_ACTUACIO, A.DESCRIPCIO_ACTUACIO, A.TEMPS_INVERTIT, E.DESCRIPCIO AS NOM_ESTAT
            FROM TECNICS T
            JOIN INCIDENCIES I ON T.ID_TECNIC = I.ID_TECNIC
            JOIN ACTUACIO_INCIDENCIA A ON I.ID_INCIDENCIA = A.ID_INCIDENCIA
            JOIN ESTAT E ON A.ESTAT_INCIDENCIA = E.ID_ESTAT
            ORDER BY A.DATA_ACTUACIO DESC, T.ID_TECNIC, A.ID_INCIDENCIA, A.LINIA_ACTUACIO ASC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
            <div id="formulari-llistat">
            <h1>Actuacions dels Tècnics</h1>
            <table id="taula-llistat">
            <thead>
                <tr>
                    <th>ID Tècnic</th>
                    <th>Nom del Tècnic</th>
                    <th>ID Incidència</th>
                    <th>Linia Actuació</th>
                    <th>Descripció</th>
                    <th>Estat</th>
                    <th>Data Actuació</th>
                    <th>Temps</th>
                </tr>
            </thead>
            </div>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["ID_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["LINIA_ACTUACIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO_ACTUACIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_ACTUACIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["TEMPS_INVERTIT"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hi ha registres d'actuacions per mostrar.</p>";
    }

    $conn->close();
    ?>

    <div class="boto-llistat">
        <a class="enrera" href="./PaginaAdministrador.html">Enrere</a>        
    </div>
</body>
</html>
