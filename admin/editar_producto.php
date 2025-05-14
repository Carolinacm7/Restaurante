<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/conexion.php');

// Verificamos si llegó el ID del producto
if (!isset($_GET['id'])) {
    die('ID de producto no especificado.');
}

$id = $_GET['id'];

// Obtener las categorías
$sql_categorias = "SELECT id_categoria, nombre FROM categorias";
$resultado_categorias = $conexion->query($sql_categorias);

// Obtener datos del producto actual
$sql_producto = "SELECT * FROM productos WHERE id_producto = $id";
$resultado_producto = $conexion->query($sql_producto);
$producto = $resultado_producto->fetch_assoc();

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $id_categoria = $_POST['id_categoria'];

    $sql_update = "UPDATE productos 
                   SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen', id_categoria='$id_categoria' 
                   WHERE id_producto=$id";

    if ($conexion->query($sql_update) === TRUE) {
        header("Location: listar_productos.php");
        exit();
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}
?>

<?php include('../includes/header.php'); ?>



<main>
    <h1>Editar Producto</h1>
    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required><br><br>

        <label>Imagen (ruta):</label><br>
        <input type="text" name="imagen" value="<?php echo $producto['imagen']; ?>" required><br><br>

        <label>Categoría:</label><br>
        <select name="id_categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php while($cat = $resultado_categorias->fetch_assoc()) { ?>
                <option value="<?php echo $cat['id_categoria']; ?>" <?php if($cat['id_categoria'] == $producto['id_categoria']) echo 'selected'; ?>>
                    <?php echo $cat['nombre']; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Actualizar">
    </form>
</main>

<?php include('../includes/footer.php'); ?>
