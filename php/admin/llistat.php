<?php
require "../connexio.php"; 
include "../funcioMongo.php";

$Usuari = 'Admin';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Llistar Incidencies';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>

<body>
    <?php
    $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_ESTAT, T.NOM_TECNIC, T.ID_TECNIC,
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, P.DESCRIPCIO AS NOM_PRIORITAT, TIP.DESCRIPCIO AS NOM_TIPUS
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
            JOIN PRIORITAT P ON I.ID_PRIORITAT = P.ID_PRIORITAT
            JOIN TIPUS_INCIDENCIA TIP ON I.ID_TIPUS_INCIDENCIA = TIP.ID_TIPUS
            ORDER BY I.ID_PRIORITAT DESC, I.DATA_INICI ASC"; 

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <div id="formulari-llistat">
            <h1>Llistat d'incidències</h1>
            <table id="taula-llistat">
            <thead>
              <tr>
                  <th>INCIDENCIA</th>
                  <th>TECNIC</th>
                  <th>ID_TECNIC</th>
                  <th>DEPARTAMENT</th>
                  <th>ORDINADOR</th>
                  <th>DATA_INICI</th>
                  <th>DESCRIPCIO</th>
                  <th>ESTAT</th>
                  <th>PRIORITAT</th>
                  <th>TIPUS</th>
                  <th>ACCIONS</th>
              </tr>
            </thead>
        <?php
        while ($row = $result->fetch_assoc()) {
            $classe_prioritat = "prioritat-" . str_replace(" ", "", $row["NOM_PRIORITAT"]); 
            
            echo "<tr class='$classe_prioritat'>";
            echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ID_TECNIC"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["ORDINADOR"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_PRIORITAT"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["NOM_TIPUS"]) . "</td>";

            echo "<td>
                    <a href='esborrar.php?id=" . $row["ID_INCIDENCIA"] . "' class='links-update'>Esborrar</a> 
                    <a href='./update.php?id=" . $row["ID_INCIDENCIA"] . "' class='links-update'>Editar</a>
                  </td>";
            echo "</tr>";
        }
        ?> 
        </table>
            <div class="boto-llistat">
              <a class="enrera" href="./PaginaAdministrador.html">Enrere</a>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="centrar">
            <div id="formulari-llistat">
                <h1>NO S'HA REGISTRAT CAP INCIDENCIA</h1>
                <div class="boto-llistat">
                <a class="enrera" href="./PaginaAdministrador.html">Enrere</a>
                </div>
            </div>
        </div>
        <?php
    }

    $conn->close();
    ?>
</body>
</html>
