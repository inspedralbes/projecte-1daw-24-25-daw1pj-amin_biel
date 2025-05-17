<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Pàgina Usuari - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyPaginesContingut.css">
</head>
<body>
    <nav class="navbar fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          <h1 class="my-0">Usuari</h1>
          <div class="d-flex align-items-center ms-auto">
            <ul class="navbar-nav d-none d-xl-flex flex-row mb-0">
              <li class="nav-item mx-2">
                <a class="nav-link " href="./crear.php">Introduir Incidencia</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="./llistatUsuari.php">Veure Estat Incidencies</a>
              </li>
            </ul>
            <button type="button" class="btn btn-link ms-3" onclick="window.location.href='../PaginaDescobreixmes.php';">Log out</button>
          </div>
        </div>
    </nav>

    <main class="container">
      <div class="row">
        <div class="col-12">
          <section class="introduccio">
            <h1>Introduir una Incidencia</h1>
            <h4>Aquí pots reportar qualsevol incidència informàtica que necessiti atenció.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='crear.php';">Introduir Incidencia</button>
          </section>
        </div>
        <hr>
        <div class="col-12">
          <section class="introduccio">
            <h1>Veure l'estat d'una Incidencia</h1>
            <h4>Consulta el estat de les teves incidències i segueix el seu progrés.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='llistatUsuari.php';">Veure Estat Incidencia</button>
          </section>
        </div>
      </div>
    </main>
    
    <?php include_once '../footer.php'; ?>
</body>
</html>