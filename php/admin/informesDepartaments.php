<?php
require "../connexio.php"; 
include "../funcioMongo.php";

$Usuari = 'Admin';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Informes Departaments';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes Dept - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>
<body>
    <?php
    $sql = "SELECT D.DESCRIPCIO AS NOM_DEPARTAMENT, COUNT(I.ID_INCIDENCIA) AS NUM_INCIDENCIES
            FROM DEPARTAMENTS D
            LEFT JOIN INCIDENCIES I ON D.ID_DEPARTAMENT = I.ID_DEPARTAMENT
            GROUP BY D.DESCRIPCIO
            ORDER BY NUM_INCIDENCIES DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
            <div id="formulari-llistat">
            <h1>Incidències dels Departaments</h1>
            <table id="taula-llistat">
            <thead>
                <tr>
                    <th>Departament</th>
                    <th>Nº Incidències</th>
                </tr>
            </thead>
            </div>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NUM_INCIDENCIES"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hi ha registres d'incidències per mostrar.</p>";
    }

    $conn->close();
    ?>

    <div class="boto-llistat">
        <a class="enrera" href="./PaginaAdministrador.php">Enrere</a>        
    </div>
</body>
</html>
