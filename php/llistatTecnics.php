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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_tecnic"])) {
            $id_tecnic = $_POST['id_tecnic'];

            $sql = "SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DESCRIPCIO, I.ORDINADOR, 
                   D.DESCRIPCIO AS NOM_DEPARTAMENT, E.DESCRIPCIO AS NOM_ESTAT, T.ID_TECNIC 
            FROM INCIDENCIES I
            JOIN DEPARTAMENTS D ON I.ID_DEPARTAMENT = D.ID_DEPARTAMENT
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            JOIN TECNICS T ON I.ID_TECNIC = T.ID_TECNIC
            WHERE I.ID_TECNIC = ?
            ORDER BY I.ID_INCIDENCIA ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_tecnic);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                ?>
                
                <div id="formulari-llistat">
                  <h1>INCIDENCIES ASSIGNADES</h1>
                    <table id="taula-llistat">
                      <thead>
                        <tr>
                            <th>ID_INCIDENCIA</th>
                            <th>ID_TECNIC</th>
                            <th>DEPARTAMENT</th>
                            <th>ORDINADOR</th>
                            <th>DATA_INICI</th>
                            <th>DESCRIPCIO</th>
                            <th>ESTAT</th>
                        </tr>
                      </thead>
                <?php
                while ($row = $result->fetch_assoc()) { 
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["ID_INCIDENCIA"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID_TECNIC"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["NOM_DEPARTAMENT"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["ORDINADOR"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["DATA_INICI"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["DESCRIPCIO"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["NOM_ESTAT"]) . "</td>";
                    echo "</tr>";
                }
                ?>
                    </table>
                        <div class="botons">
                            <a class="enrera"  href="PaginaUsuari.html">Enrera</a>
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
                                <a class="enrera"  href="PaginaUsuari.html">Enrera</a>
                                <a class="enrera"  href="./llistatTecnics.php">Buscar més</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        
            $conn->close();
        }else{
            ?>
        
    <div class="centrar">
        <form id="formulari" action="./llistatTecnics.php" method="post">
            <h1>INTRODUEIX EL TEU ID DE TÈCNIC</h1>
            <div class="descripcio">            
                <div class="grup-input">
                    <label for="id_tecnic" class="input-label">ID Tècnic</label>
                    <input type="number" name="id_tecnic" id="id_tecnic" class="input-dintre" placeholder="Numero Tècnic " min="1" max="10">
                </div>
            </div>
            <div class="botons">
                <a href="PaginaUsuari.html" class="enrera">Enrere</a>
            
                <input type="submit" value="Envia">
        
            
            </div>

        </form>
    </div>
    <?php
        
    } ?>
</body>
</html>