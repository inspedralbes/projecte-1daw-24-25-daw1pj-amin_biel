<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Pàgina Administrador - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyPaginesContingut.css">
</head>
<body>
    <nav class="navbar fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          <h1 class="my-0">Admin</h1>
          <div class="d-flex align-items-center ms-auto">
            <ul class="navbar-nav d-none d-xl-flex flex-row mb-0">
              <li class="nav-item mx-2">
                <a class="nav-link" href="./llistat.php">Llistat Incidències</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="./informesTecnics.php">Informes Tècnics</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="./informesDepartaments.php">Informes Departaments</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="./llistatMongo.php">Informes dels Logs</a>
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
            <h1>Llistat d'Incidencies</h1>
            <h4>Aquí pots veure totes les incidències reportades per tots els usuaris.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='llistat.php';">Llistat d'Incidenciès</button>
          </section>
        </div>
        <hr>
        <div class="col-12">
          <section class="introduccio">
            <h1>Informes dels Tècnics</h1>
            <h4>Aquesta secció mostra els informes generats pels tècnics sobre les incidències resoltes.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='informesTecnics.php';">Informes dels Tècnics</button>
          </section>
        </div>
        <hr>
        <div class="col-12">
          <section class="introduccio">
            <h1>Informes dels Departaments</h1>
            <h4>Aquí pots veure les estadístiques i informes relacionats amb els departaments i les seves incidències.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='informesDepartaments.php';">Informes Departaments</button>
          </section>
        </div>
        <hr>
        <div class="col-12">
          <section class="introduccio">
            <h1>Informes dels Logs</h1>
            <h4>Consulta els registres del sistema per analitzar l'activitat,i fer seguiment dels esdeveniments.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='llistatMongo.php';">Informes dels Logs</button>
          </section>
        </div>
      </div>
    </main>
    
    <?php include_once '../footer.php'; ?>
</body>
</html>