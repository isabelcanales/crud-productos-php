<?php
require 'db.php';
$producto_borrar = null;

// 1. Mostrar detalles del artículo elegido
if (isset($_POST['codigo_elegido']) && !empty($_POST['codigo_elegido'])) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE CÓDIGOARTÍCULO = ?");
    $stmt->execute([$_POST['codigo_elegido']]);
    $producto_borrar = $stmt->fetch();
}

// 2. Ejecutar borrado tras confirmación
if (isset($_POST['confirmar_borrado'])) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE CÓDIGOARTÍCULO = ?");
    $stmt->execute([$_POST['codigo']]);
    header("Location: leer.php");
    exit;
}

$stmt_list = $pdo->query("SELECT CÓDIGOARTÍCULO, NOMBREARTÍCULO FROM productos");
$lista = $stmt_list->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Borrar Producto</title>
</head>
<body>
    <div class="container">
        <h2>Borrar Producto</h2>

        <form method="POST">
            <label>Selecciona Producto:</label>
            <select name="codigo_elegido" onchange="this.form.submit()">
                <option value="">-- Seleccione para borrar --</option>
                <?php foreach ($lista as $item): ?>
                    <option value="<?= $item['CÓDIGOARTÍCULO'] ?>">
                        <?= $item['CÓDIGOARTÍCULO'] ?> - <?= $item['NOMBREARTÍCULO'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($producto_borrar): ?>
            <div style="background:#fff3f3; padding:15px; border:1px solid red; margin-top:20px;">
                <p><strong>¿Estás seguro de que quieres borrar este artículo?</strong></p>
                <p>
                    Nombre: <?= $producto_borrar['NOMBREARTÍCULO'] ?><br>
                    Código: <?= $producto_borrar['CÓDIGOARTÍCULO'] ?><br>
                    Precio: <?= $producto_borrar['PRECIO'] ?>
                </p>

                <form method="POST">
                    <input type="hidden" name="codigo" value="<?= $producto_borrar['CÓDIGOARTÍCULO'] ?>">
                    <button type="submit" name="confirmar_borrado" class="btn btn-red">SÍ, BORRAR DEFINITIVAMENTE</button>
                    <a href="borrar.php" class="btn btn-back">Cancelar</a>
                </form>
            </div>
        <?php endif; ?>

        <br><a href="index.php" class="btn btn-back">Volver al Inicio</a>
    </div>
</body>
</html>