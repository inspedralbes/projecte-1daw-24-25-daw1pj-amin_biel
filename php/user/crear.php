<?php
require "../connexio.php";
include "../funcioMongo.php";

$Usuari = 'Usuari';
$data = date('Y-m-d H:i:s');
$ipUsuari = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$paginaUsuari = 'Crear Incidència';

insertLogs($collection, $Usuari, $data, $ipUsuari ,$paginaUsuari);

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
    <script>
        function validarFormulari() {
            var cicle = document.querySelector('input[name="cicles"]:checked');
            var descripcio = document.getElementById("descripcio").value.trim();
            var ordinador = document.getElementById("ordinador").value;

            if (!cicle || descripcio === "" || ordinador === "") {
                alert("Error: Has d'omplir tots els camps abans d'enviar.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo '<div id="formulari-llistat">';

    if (empty($_POST['cicles']) || empty($_POST['descripcio']) || empty($_POST['ordinador'])) {
        die("<p style='color: red;'>Error: Has d'omplir tots els camps abans d'enviar.</p><a href='crear.php'>Tornar</a>");
    }

    $cicle = trim($_POST['cicles']);
    $descripcio = trim($_POST['descripcio']);
    $descripcio = $conn->real_escape_string($descripcio);
    $ordinador = intval($_POST['ordinador']);

    $result = $conn->query("SELECT ID_DEPARTAMENT FROM DEPARTAMENTS WHERE DESCRIPCIO = '$cicle'");
    if ($result->num_rows === 0) {
        die("<p style='color: red;'>Error: El departament seleccionat no existeix.</p><a href='crear.php'>Tornar</a>");
    }
    $row = $result->fetch_assoc();
    $id_departament = $row['ID_DEPARTAMENT'];      

    $checkDuplicate = $conn->query("SELECT ID_INCIDENCIA FROM INCIDENCIES WHERE ID_DEPARTAMENT = '$id_departament' AND ORDINADOR = '$ordinador'");
   if ($checkDuplicate->num_rows > 0) { 
    ?>
    </div>
    <div class="centrar">
        <div id="formulari-llistat">
            <h1>JA HI HA UNA INCIDENCIA IGUAL REGISTRADA</h1>
            <div class="boto-llistat">
                <a class="enrera" href="./crear.php">Tornar</a>
            </div>
        </div>
    </div>
    <?php
    exit;
}

    $resultat = $conn->query("SELECT ID_TECNIC FROM TECNICS WHERE ID_DEPARTAMENT = '$id_departament'");
    if ($resultat->num_rows === 0) {
        die("<p style='color: red;'>Error: No hi ha cap tècnic assignat a aquest departament.</p><a href='crear.php'>Tornar</a>");
    }
    $row = $resultat->fetch_assoc();
    $id_tecnic = $row['ID_TECNIC'];  

    $sql = "INSERT INTO INCIDENCIES (ID_DEPARTAMENT, DATA_INICI, DESCRIPCIO, ORDINADOR, ID_TECNIC)
            VALUES ('$id_departament', SYSDATE(), '$descripcio', '$ordinador', '$id_tecnic')";

    if ($conn->query($sql)) {
        
        $id_incidencia = $conn->insert_id;
        echo "<h1>LA TEVA INCIDÈNCIA HA ESTAT REGISTRADA CORRECTAMENT!</h1>";
        echo "<p>El codi de la teva incidència és: <strong>$id_incidencia</strong></p>";
    } else {
        echo "<p>Error en registrar la incidència: " . $conn->error . "</p>";
    }

    echo '<div class="botons">';
    echo '<a href="./PaginaUsuari.php" class="enrera">Enrere</a>';
    echo '<a href="./crear.php" class="enrera">Inserir una altra</a>';
    echo '</div></div>';
} else {
?>
    <form id="formulari" action="./crear.php" method="post" onsubmit="return validarFormulari()">
        <h1>DEPARTAMENTS</h1>
        <div class="departaments">
            <fieldset >
                <div class="opcio"><input type="radio" name="cicles" id="mates" value="Matemàtiques"><label for="mates">Matemàtiques</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="ciencies" value="Ciències Naturals"><label for="ciencies">Ciències Naturals</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="tecnologia" value="Tecnologia"><label for="tecnologia">Tecnologia</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="llengues" value="Llengües"><label for="llengues">Llengües</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="socials" value="Ciències Socials"><label for="socials">Ciències Socials</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="edfisica" value="Educació Física"><label for="edfisica">Educació Física</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="arts" value="Arts Plàstiques"><label for="arts">Arts Plàstiques</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="musica" value="Música"><label for="musica">Música</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="informatica" value="Informàtica"><label for="informatica">Informàtica</label></div>
                <div class="opcio"><input type="radio" name="cicles" id="biblioteca" value="Biblioteca"><label for="biblioteca">Biblioteca</label></div>
            </fieldset>
        </div>

        <h1>DESCRIPCIÓ INCIDÈNCIA</h1>
        <div class="descripcio">
            <label for="descripcio">Escriu una breu descripció de la teva incidència</label>
            <textarea id="descripcio" name="descripcio" placeholder="El problema que tinc és..." required></textarea>
            <div class="grup-input">
                <label for="ordinador" class="input-label">Nº Ordinador</label>
                <input type="number" name ="ordinador"  id="ordinador" class="input-dintre" placeholder="Numero Ordinador " min="1" max="60">
            </div>
        </div>

        <div class="botons">
            <a href="./PaginaUsuari.php" class="enrera">Enrere</a>
            <input type="submit" value="Envia">
        </div>
    </form>
<?php
}
?>
</body>
</html>
