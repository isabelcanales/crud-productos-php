<?php
require 'db.php';
$mensaje = "";
$tipoMensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = trim($_POST['codigo']);
    $seccion = trim($_POST['seccion']);
    $nombre = trim($_POST['nombre']);
    $precio = trim($_POST['precio']);
    $fecha = trim($_POST['fecha']);
    $importado = $_POST['importado'];
    $pais = trim($_POST['pais']);

    // Comprobar si ya existe un producto con ese código
    $sql_check = "SELECT COUNT(*) FROM productos WHERE CÓDIGOARTÍCULO = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$codigo]);
    $existe = $stmt_check->fetchColumn();

    if ($existe > 0) {
        $mensaje = "Error: ya existe un producto con ese código.";
        $tipoMensaje = "error";
    } else {
        $sql = "INSERT INTO productos (CÓDIGOARTÍCULO, SECCIÓN, NOMBREARTÍCULO, PRECIO, FECHA, IMPORTADO, PAÍSDEORIGEN) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codigo, $seccion, $nombre, $precio, $fecha, $importado, $pais]);

        $mensaje = "Producto insertado correctamente.";
        $tipoMensaje = "ok";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Insertar Producto</title>
</head>
<body>
    <div class="container">
        <h2>Nuevo Producto</h2>

        <?php if ($mensaje): ?>
            <p style="color: <?= $tipoMensaje == 'error' ? 'red' : 'green' ?>;">
                <?= $mensaje ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label>Código:</label>
            <input type="text" name="codigo" required maxlength="4">

            <label>Sección:</label>
            <input type="text" name="seccion" required>

            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Precio:</label>
            <input type="text" name="precio" required>

            <label>Fecha:</label>
            <input type="text" name="fecha" placeholder="dd/mm/aaaa">

            <label>Importado:</label>
            <select name="importado">
                <option value="VERDADERO">VERDADERO</option>
                <option value="FALSO">FALSO</option>
            </select>

            <label>País:</label>
            <input type="text" name="pais">

            <button type="submit" class="btn">Guardar</button>
            <a href="index.php" class="btn btn-back">Volver</a>
        </form>
    </div>
</body>
</html>