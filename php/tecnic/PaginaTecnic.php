<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pàgina Tècnic - Amin&Biel</title>
    <link rel="icon" type="image/x-icon" href="../img/LogoInsp.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyPaginesContingut.css">
</head>
<body>
  <nav class="navbar fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="my-0">Tècnic</h1>
      <div class="d-flex align-items-center ms-auto">
        <ul class="navbar-nav d-none d-xl-flex flex-row mb-0">
          <li class="nav-item mx-2">
            <a class="nav-link" href="./llistatTecnics.php">Llistat Incidències Assignades</a>
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
            <h1>Veure Assignacions</h1>
            <h4>Aquí pots consultar les incidències assignades, ordenades per prioritat.</h4>
            <button type="button" class="btn btn-link" onclick="window.location.href='llistatTecnics.php';">Llistat Incidències Assignades</button>
          </section>
        </div>
      </div>
    </main>
    
    
    <?php include_once '../footer.php'; ?>
</body>
</html>