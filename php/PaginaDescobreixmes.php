<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Pàgina Inicial - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="./img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="DissenyPaginesContingut.css">
</head>
<body>    
    <nav class="navbar fixed-top">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="my-0">Amin&Biel</h1>
        <div class="d-flex align-items-center ms-auto">
          <button type="button" class="btn btn-link ms-3" onclick="window.location.href='./LoginPage.html';">Log in</button>
        </div>
      </div>
    </nav>

    <main class="container">
      <div class="row">
        <div class="col-12">
          <section class="introduccio">
            <h1>Gestor d’Incidencies Informàtiques</h1>
            <h4>Pàgina creada per Amin i Biel per gestionar incidències informàtiques a l'Institut Pedralbes. Permet a usuaris i tècnics gestionar i seguir l'estat dels problemes informàtics.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='LoginPage.html';">Log in</button>
          </section>
        </div>
      </div>
    </main>

    <?php include_once './footer.php'; ?>



</body>
</html>