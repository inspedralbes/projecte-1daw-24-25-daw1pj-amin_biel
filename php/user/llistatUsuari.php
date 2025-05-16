<?php
require "../connexio.php"; 
include "../funcioMongo.php";

$Usuari = 'Usuari';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Llistar Incidencies';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_incidencia"])) {
    $id_incidencia = $_POST["id_incidencia"];

    $sql = "SELECT E.DESCRIPCIO AS NOM_ESTAT
            FROM INCIDENCIES I
            JOIN ESTAT E ON I.ID_ESTAT = E.ID_ESTAT
            WHERE I.ID_INCIDENCIA = ?
            ORDER BY ID_PRIORITAT DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_incidencia);
    $stmt->execute();
    $result = $stmt->get_result();
    $incidencia = $result->fetch_assoc();
    
    if ($incidencia) {
        ?>
        <!DOCTYPE html>
        <html lang="ca">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Llistat d'incidències dels tècnics</title>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../Normalize.css">
            <link rel="stylesheet" href="../DissenyFormularis.css">
        </head>
        <body>
            <div class="centrar">
                <div id="formulari-llistat">
                    <h1>Estat de la teva incidència</h1>
                    <p><strong>Estat:</strong> <?= htmlspecialchars($incidencia["NOM_ESTAT"]) ?></p>
                    <div class="botons">
                            <a class="enrera"  href="./PaginaUsuari.html">Enrere</a>
                            <a class="enrera"  href="./llistatUsuari.php">Buscar més</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="ca">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Llistat d'incidències dels tècnics</title>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="../Normalize.css">
            <link rel="stylesheet" href="../DissenyFormularis.css">
        </head>
        <body>
        <div class="centrar">
            <div id="formulari-llistat">
                <h1>No s'ha trobat cap incidència</h1>
                <div class="botons">
                        <a class="enrera"  href="./PaginaUsuari.html">Enrere</a>
                        <a class="enrera"  href="./llistatUsuari.php">Buscar més</a>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }

    $conn->close();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="ca">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Llistat d'incidències dels tècnics</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../Normalize.css">
        <link rel="stylesheet" href="../DissenyFormularis.css">
    </head>
    <body>
        <div class="centrar">
            <form id="formulari" action="./llistatUsuari.php" method="post">
                <h1>Consulta l'Estat d'una Incidència</h1> 
                <div class="descripcio">            
                    <div class="grup-input">
                        <label for="id_incidencia" class="input-label">Introdueix el teu codi d'incidència:</label>
                        <input type="number" name="id_incidencia" id="id_incidencia" class="input-dintre" required>
                    </div>
                </div>  
                <div class="botons">
                    <a href="./PaginaUsuari.html" class="enrera">Enrere</a>
                    <input type="submit" value="Consultar">
                </div>           
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
