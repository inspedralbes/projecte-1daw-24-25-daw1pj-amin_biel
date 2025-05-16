<?php

// Configuració de la connexió a la base de dades
    $servername = "daw.inspedralbes.cat"; // Nom del servei definit al docker-compose.yaml
    $username = "a24biedommar_AminBiel"; // Usuari definit al docker-compose.yaml
    $password = "qZ68U+X#gsQqc7a9"; // Contrasenya definida al docker-compose.yaml
    $dbname = "a24biedommar_ProjecteFinal_MySql"; // Nom de la base de dades
    
    // Quan ja tingueu un codi una mica depurat, i vulgueu fer la gestió dels errors
    // vosaltres mateixos heu de desactivar el comportament predeterminat de mysqli 
    // que es molt agressiu i aborta el php en el moment de l'error, i per tant, 
    //  no arriba a l'if de comprovació.
    // Amb la següent línia, el codi en cas d'error de mysql ja no aboratarà i ho podreu
    // gestionar vosaltres mateixos.
    // mysqli_report(MYSQLI_REPORT_OFF);
    //prova de si funciona
    // Crear la connexió
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprovar la connexió
    if ($conn->connect_error) {
        echo "<p>Error de connexió: " . htmlspecialchars($conn->connect_error) . "</p>";
        die("Error de connexió: " . $conn->connect_error);
    }
    
    require 'vendor/autoload.php';

    $uri = "mongodb+srv://a24biedommar:d327418d@projecteaminbielmongo.q5prnml.mongodb.net/?retryWrites=true&w=majority&appName=ProjecteAminBielMongo";

    $client = new MongoDB\Client($uri);

    $collection = $client->demo->users;


    ?>