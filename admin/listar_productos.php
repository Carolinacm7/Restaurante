<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../includes/conexion.php');

$sql = "SELECT productos.id_producto AS id, productos.nombre, productos.descripcion, productos.precio, productos.imagen, categorias.nombre AS categoria 
        FROM productos 
        INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria";

$resultado = $conexion->query($sql);
?>

<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../public/css/crud.css"> <!-- Estilos solo para CRUD -->

<main>
    <h1>Lista de Productos</h1>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
        <p class="mensaje-exito">✅ Producto eliminado correctamente.</p>
    <?php endif; ?>

    <a href="crear_producto.php" class="btn btn-crear">➕ Crear Nuevo Producto</a>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>

        <?php 
        if (!$resultado) {
            die("Error en la consulta: " . $conexion->error);
        }

        while($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['descripcion']; ?></td>
                <td>$<?php echo number_format($fila['precio'], 2); ?></td>
                <td><img src="<?php echo $fila['imagen']; ?>" alt="<?php echo $fila['nombre']; ?>" width="100"></td>
                <td><?php echo $fila['categoria']; ?></td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $fila['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                    <a href="eliminar_producto.php?id=<?php echo $fila['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este producto?');">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</main>

<?php include('../includes/footer.php'); ?>
