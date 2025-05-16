<?php
require "../connexio.php"; 

$documents = $collection->find();
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat de Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Normalize.css">
    <link rel="stylesheet" href="../DissenyFormularis.css">
</head>

<body>
    <?php if ($documents): ?>
        <div id="formulari-llistat">
            <h1>Llistat de Logs</h1>
            <table id="taula-llistat">
                <thead>
                    <tr>
                        <th>Usuari</th>
                        <th>Data</th>
                        <th>Pàgina Visitada</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $document): ?>
                        <tr>
                            <td><?= htmlspecialchars($document['Usuari'] ?? 'Desconegut') ?></td>
                            <td><?= htmlspecialchars($document['Data'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($document['pagina visitada'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($document['ip_origen'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="boto-llistat">
                <a class="enrera" href="./PaginaAdministrador.html">Enrere</a>
            </div>
        </div>
    <?php else: ?>
        <div class="centrar">
            <div id="formulari-llistat">
                <h1>NO S'HAN TROBAT REGISTRES</h1>
                <div class="boto-llistat">
                    <a class="enrera" href="./PaginaAdministrador.html">Enrere</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>