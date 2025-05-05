<?php
$servername = "localhost";
$username = "a24biedommar_AminBiel";
$password = "qZ68U+X#gsQqc7a9";
$dbname = "a24biedommar_ProjecteFinal_MySql";
?>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function clear_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function guardarIncidencia($conn, $idDepartament, $idUsuari, $descripcio, $ordinador)
{ 
    // Inserció d'una nova incidència
    $sql = "INSERT INTO INCIDENCIES (ID_DEPARTAMENT, ID_USUARI, DATA_INICI, DESCRIPCIO, ORDINADOR) 
            VALUES (?, ?, SYSDATE(), ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparant la consulta: " . $conn->error);
    }

    // Vinculem les dades per a la inserció
    $stmt->bind_param("iisi", $idDepartament, $idUsuari, $descripcio, $ordinador);

    // Executem la consulta
    if (!$stmt->execute()) {
        die("Error executant la consulta d'inserció: " . $stmt->error);
    }
}
function obtenirIdUsuari($conn, $email, $nom, $cognom, $curs){
    $idUsuari = null; 

    // Comprovem si l'usuari ja existeix
    $sql = "SELECT ID_USUARI FROM USUARIS WHERE EMAIL = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparant la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($idUsuari);
    
    if ($stmt->fetch()) { //comprovem si el usuari ja ha estat inserit
        // Usuari trobat, retornem el seu ID
        $stmt->close();
        return $idUsuari;
    }
    $stmt->close();

    // Usuari no trobat, l'inserim
    $sqlInsert = "INSERT INTO USUARIS (EMAIL, NOM_USUARI, COGNOM_USUARI, CURS_USUARI)
                  VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if ($stmtInsert === false) {
        die("Error preparant la inserció: " . $conn->error);
    }

    $stmtInsert->bind_param("ssss", $email, $nom, $cognom, $curs); //inserim el usuari a la base de dades
    if (!$stmtInsert->execute()) {
        die("Error executant la inserció de l'usuari: " . $stmtInsert->error);
    }

    $nouId = $stmtInsert->insert_id;
    $stmtInsert->close();

    return $nouId;
}


$errors = -1; 
$id = ""; 

$nom = "";
$nomErr = "";

$email = "";
$emailErr = "";

$cicles = "";
$ciclesErr = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = 0;

    if (empty($_POST['nom'])) {
        $nomErr = " ERROR: Cal introduir el nom! ";
        $errors++;
    } else {
        $nom = clear_input($_POST['nom']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $nom)) {
            $nomErr = " * Només es permeten lletres i espais en blanc ";
            $errors++;
        }
    }

    if (empty($_POST['email'])) {
        $emailErr = " ERROR: Cal introduir el correu! ";
        $errors++;
    } else {
        $email = clear_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = " El correu no està en un format vàlid ";
            $errors++;
        }
    }


    if (isset($_POST['cicles']) && count($_POST['cicles']) > 0) {
        //Si s'ha seleccionat algun cicle, els guardem en una cadena separada per comes
        $cicles = implode(", ", $_POST['cicles']);
    } else {
        //Si no s'ha seleccionat cap cicle, prepraem el missatge d'error
        $errors++;
        $ciclesErr = "Com a mínim s'han de seleccionar uns estudis";
    }

    if (isset($_POST['id'])) {
        
        $id = $_POST['id'];
    }

} else {
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error en la connexió amb la base de dades: " . $conn->connect_error);
        }

        $sql = "SELECT nom, email, cicles FROM PERSONES WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("i", $_GET['id']);

        if (!$stmt->execute()) {
            die("Error executing statement: " . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si hem obtingut algun registre...
            $row = $result->fetch_assoc();
            $id = $_GET['id']; //Guardem l'id per poder-lo afegir al formulari en un camp ocult
            //Les variables nom, email i cicles, quan venim per POST s'omplen amb les dades rebudes
            //però quan venim per GET, les omplim amb les dades de la base de dades
            $nom = $row["nom"];
            $email = $row["email"];
            $cicles = $row["cicles"];
        } else {
            //Si no hi ha cap registre amb aquest id, preparem un missatge d'error
            $errors = 1;
            $nomErr = "No s'ha trobat cap persona amb l'id $_GET[id]";
        }
        $conn->close();
    }
}


?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat d'inscrits</title>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="estils.css">
</head>

<body>


    <?php
    if ($errors == 0) {
        //S'ha enviat el form i no hi ha cap error
        //Guardem les dades a la base de dades
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            //Si no es pot connectar, mostrem un missatge d'error i abortem el php
            // no té sentit continuar sense connexió
            die("Error en la connexió amb la base de dades: " . $conn->connect_error);
        }

        guardarPersona($conn, $id, $nom, $email, $cicles);

        echo "<div id='formulari'><h1>Dades guardades $cicles</h1>";
        echo "<p><strong>$nom</strong>, moltes gràcies per inscriure't. El teu correu és: $email</p>";
        echo "<p>Has seleccionat els estudis de: $cicles</p>";
        echo "<p><a href='./'>Tornar a la pàgina principal</a></p>";
        echo "</div>";

    } else {
        ?>
        <form id="formulari" action="./index.php" method="post">

            <h1>Institut Pedralbes</h1>
            <?php
            if ($errors > 0) {
                echo "<div class='error'>ATENCIÓ: Hi ha $errors errors en el formulari </div>";
            }
            ?>
            <div class="item">
                <label for="idNom">* Nom: <span class="error"> <?php echo $nomErr; ?> </span>
                </label>
                <input type="text" placeholder="El teu nom" id="idNom" name="nom" value="<?php echo $nom; ?>">
            </div>
            <div class="item">
                <label for="idEmail">* Correu electrònic: <span class="error"> <?php echo $emailErr; ?> </span>
                </label>
                <input type="text" placeholder="correu@servidor..." id="idEmail" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="error"><?php echo $ciclesErr; ?></div>
            <fieldset class="item" id="cicles">
                <legend>Estudis:</legend>
                <input type="checkbox" id="idDaw" name="cicles[]" value="DAW" <?php if (isset($_POST['cicles']) && in_array("DAW", $_POST['cicles']))
                    echo "checked"; ?>>
                <label for="idDaw">DAW</label>

                <input type="checkbox" id="idDam" name="cicles[]" value="DAM" <?php if (isset($_POST['cicles']) && in_array("DAM", $_POST['cicles']))
                    echo "checked"; ?>>
                <label for="idDam">DAM</label>

                <input type="checkbox" id="idAsix" name="cicles[]" value="ASIX" <?php if (isset($_POST['cicles']) && in_array("ASIX", $_POST['cicles']))
                    echo "checked"; ?>>
                <label for="idAsix">ASIX</label>

                <input type="checkbox" id="idSmx" name="cicles[]" value="SMX" <?php if (isset($_POST['cicles']) && in_array("SMX", $_POST['cicles']))
                    echo "checked"; ?>>
                <label for="idSmx">SMX</label>

                <input type="checkbox" id="idPfi" name="cicles[]" value="PFI" <?php if (isset($_POST['cicles']) && in_array("PFI", $_POST['cicles']))
                    echo "checked"; ?>>
                <label for="idPfi">PFI</label>

            </fieldset>
            <button type="submit" class="item">Enviar</button>

            <input type="hidden" name="id" value="<?php echo $id; ?>">


            <a href="llistat.php">Panell de controll</a>
        </form>

        <?php
    }
    ?>


</body>

</html>