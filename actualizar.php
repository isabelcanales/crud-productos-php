<?php
require 'db.php';
$producto_editar = null;

// 2. Procesar la actualización
if (isset($_POST['confirmar_update'])) {
    $sql = "UPDATE productos SET SECCIÓN=?, NOMBREARTÍCULO=?, PRECIO=?, FECHA=?, IMPORTADO=?, PAÍSDEORIGEN=? WHERE CÓDIGOARTÍCULO=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['seccion'], $_POST['nombre'], $_POST['precio'], $_POST['fecha'], $_POST['importado'], $_POST['pais'], $_POST['codigo']]);
    header("Location: leer.php");
}

// 1. Cargar datos del producto elegido en el desplegable
if (isset($_POST['codigo_elegido'])) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE CÓDIGOARTÍCULO = ?");
    $stmt->execute([$_POST['codigo_elegido']]);
    $producto_editar = $stmt->fetch();
}

$stmt_list = $pdo->query("SELECT CÓDIGOARTÍCULO, NOMBREARTÍCULO FROM productos");
$lista = $stmt_list->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Actualizar</title>
</head>
<body>
    <div class="container">
        <h2>Actualizar Producto</h2>
        
        <!-- Desplegable inicial -->
        <form method="POST">
            <label>Selecciona Producto:</label>
            <select name="codigo_elegido" onchange="this.form.submit()">
                <option value="">-- Seleccione uno --</option>
                <?php foreach($lista as $item): ?>
                    <option value="<?= $item['CÓDIGOARTÍCULO'] ?>" <?= (isset($producto_editar) && $producto_editar['CÓDIGOARTÍCULO'] == $item['CÓDIGOARTÍCULO']) ? 'selected' : '' ?>>
                        <?= $item['NOMBREARTÍCULO'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($producto_editar): ?>
            <hr>
            <form method="POST">
                <!-- El código se envía pero se muestra deshabilitado para cumplir la regla -->
                <input type="hidden" name="codigo" value="<?= $producto_editar['CÓDIGOARTÍCULO'] ?>">
                <label>Código (No editable):</label> <input type="text" value="<?= $producto_editar['CÓDIGOARTÍCULO'] ?>" disabled>
                
                <label>Sección:</label> <input type="text" name="seccion" value="<?= $producto_editar['SECCIÓN'] ?>">
                <label>Nombre:</label> <input type="text" name="nombre" value="<?= $producto_editar['NOMBREARTÍCULO'] ?>">
                <label>Precio:</label> <input type="text" name="precio" value="<?= $producto_editar['PRECIO'] ?>">
                <label>Fecha:</label> <input type="text" name="fecha" value="<?= $producto_editar['FECHA'] ?>">
                <label>Importado:</label>
                <select name="importado">
                    <option value="VERDADERO" <?= $producto_editar['IMPORTADO']=='VERDADERO'?'selected':'' ?>>VERDADERO</option>
                    <option value="FALSO" <?= $producto_editar['IMPORTADO']=='FALSO'?'selected':'' ?>>FALSO</option>
                </select>
                <label>País:</label> <input type="text" name="pais" value="<?= $producto_editar['PAÍSDEORIGEN'] ?>">
                
                <button type="submit" name="confirmar_update" class="btn">Actualizar</button>
            </form>
        <?php endif; ?>
        
        <br><a href="index.php" class="btn btn-back">Volver al Inicio</a>
    </div>
</body>
</html>