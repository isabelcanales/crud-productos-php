<?php
require 'db.php';
$stmt = $pdo->query("SELECT * FROM productos");
$productos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Listado</title>
</head>
<body>
    <h2>Listado de Productos</h2>
    <a href="index.php" class="btn btn-back">Volver al Inicio</a>
    <table>
        <tr>
            <th>Código</th><th>Sección</th><th>Nombre</th><th>Precio</th><th>País</th>
        </tr>
        <?php foreach ($productos as $p): ?>
        <tr>
            <td><?= $p['CÓDIGOARTÍCULO'] ?></td>
            <td><?= $p['SECCIÓN'] ?></td>
            <td><?= $p['NOMBREARTÍCULO'] ?></td>
            <td><?= $p['PRECIO'] ?></td>
            <td><?= $p['PAÍSDEORIGEN'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>