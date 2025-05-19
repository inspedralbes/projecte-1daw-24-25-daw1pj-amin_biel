<?php
require "../connexio.php"; 
include "../funcioMongo.php";

$Usuari = 'Tecnics';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Llistar Assignacions';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat Tècnics - Amin&Biel/title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>

<body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_tecnic"])) {
            $id_tecnic = $_GET['id_tecnic'];

            // Afegim l'ordre perquè les incidències de "Crítica" apareguin primer
            $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, I.ID_TIPUS_INCIDENCIA,
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.NOM_TECNIC, T.ID_TECNIC, P.DESCRIPCIO AS NOM_PRIORITAT, TIP.DESCRIPCIO AS NOM_TIPUS
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
            JOIN PRIORITAT P ON I.ID_PRIORITAT = P.ID_PRIORITAT
            JOIN TIPUS_INCIDENCIA TIP ON I.ID_TIPUS_INCIDENCIA = TIP.ID_TIPUS
            WHERE I.ID_TECNIC = ?
            ORDER BY I.ID_PRIORITAT DESC, I.DATA_INICI ASC"; // Ordenem per prioritat de Crítica a Cap
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_tecnic);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                ?>
                <div id="formulari-llistat">
                  <h1>INCIDÈNCIES ASSIGNADES Al TECNIC</h1>
                    <table id="taula-llistat">
                      <thead>
                        <tr>
                            <th>INCIDENCIA</th>
                            <th>TECNIC</th>
                            <th>ID_TECNIC</th>
                            <th>DEPARTAMENT</th>
                            <th>ORDINADOR</th>
                            <th>DATA_INICI</th>
                            <th>DESCRIPCIÓ</th>
                            <th>ESTAT</th>
                            <th>PRIORITAT</th>
                            <th>TIPUS</th>
                            <th>ACCIONS</th>
                        </tr>
                      </thead>
                <?php
                while ($row = $result->fetch_assoc()) { 
                    // Assignem la classe CSS per als colors de prioritat
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
                            <a href='./updateTecnics.php?id_incidencia=" . $row["ID_INCIDENCIA"] . "' class='links-update'>Editar</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
                    </table>
                        <div class="botons-update">
                            <a class="enrera"  href="./PaginaTecnic.php">Enrere</a>
                            <a class="enrera"  href="./llistatTecnics.php">Buscar més</a>
                        </div>
                </div>
                <?php
            } else {
                ?>
                <div class="centrar">
                    <div id="formulari-llistat">
                        <h1>NO TENS CAP ASSIGNACIÓ</h1>
                        <div class="botons">
                                <a class="enrera"  href="./PaginaTecnic.php">Enrere</a>
                                <a class="enrera"  href="./llistatTecnics.php">Buscar més</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        
            $conn->close();
        } else {
            ?>
        
    <div class="centrar">
        <form id="formulari" action="./llistatTecnics.php" method="get">
            <h1>INTRODUEIX EL TEU ID DE TÈCNIC</h1>
            <div class="descripcio">            
                <div class="grup-input">
                    <label for="id_tecnic" class="input-label">ID Tècnic</label>
                    <input type="number" name="id_tecnic" id="id_tecnic" class="input-dintre" placeholder="Numero Tècnic " min="1" max="10">
                </div>
            </div>
            <div class="botons">
                <a href="./PaginaTecnic.php" class="enrera">Enrere</a>
                <input type="submit" value="Envia">
            </div>
        </form>
    </div>
    <?php
        
    } ?>
</body>
</html>