<?php
require "connexio.php";
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulari</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="DissenyFormularis.css">
</head>

<body>


  <?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ?>
    <div id="formulari">
        <?php 
        echo "<h1>La descripció és: ".$_POST['descripcio']."</h1>"; 
        echo "<p>El departament és: ".$_POST['cicles']."</p>"; 

        
        ?>
    </div>
    
<?php


}else{
    ?>
<form id="formulari" action="./crear.php" method="post">
        <h1>DEPARTAMENTS</h1>
        <div class="departaments">
            <fieldset>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idMates" value="Matemàtiques">
                    <label for="idMates">Matemàtiques</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idCienciesN" value="Ciències Naturals">
                    <label for="idCienciesN">Ciències Naturals</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idTecno" value="Tecnologia">
                    <label for="idTecno">Tecnologia</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idLlengues" value="Llengües">
                    <label for="idLlengues">Llengües</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idCienciesS" value="Ciències Socials">
                    <label for="idCienciesS">Ciències Socials</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idED" value="Educació Física">
                    <label for="idED">Educació Física</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idArts" value="Arts Plàstiques">
                    <label for="idArts">Arts Plàstiques</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idMusica" value="Música">
                    <label for="idMusica">Música</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idInformatica" value="Informàtica">
                    <label for="idInformatica">Informàtica</label>
                </div>
                <div class="opcio">
                    <input type="radio" name="cicles" id="idBiblio" value="Biblioteca">
                    <label for="idBiblio">Biblioteca</label>
                </div>
            </fieldset>
        </div>  

        <h1>DESCRIPCIÓ INCIDÈNCIA</h1>
        <div class="descripcio">
            <label for="descripcio" class="descripcio-label"></label>
            <textarea name="descripcio" id="descripcio" class="descripcio-input" placeholder="El problema que tinc és..."></textarea>
        </div>
        
    <div class="botons">
        <a href="PaginaUsuari.html" class="enrera">Enrere</a>
        
        <input type="submit" value="Envia">
       
        
    </div>

</form>




<?php
}

  ?>
  
  


</body>

</html>

