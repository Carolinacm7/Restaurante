<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/conexion.php');

// Obtener las categorías desde la base de datos
$sql_categorias = "SELECT id_categoria, nombre FROM categorias";
$resultado_categorias = $conexion->query($sql_categorias);

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen']; // más adelante puedes hacerlo con upload de archivos
    $id_categoria = $_POST['id_categoria'];

    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, id_categoria) 
            VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$id_categoria')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: listar_productos.php?mensaje=creado");
        exit();
    } else {
        echo "Error al insertar: " . $conexion->error;
    }
}
?>

<?php include('../includes/header.php'); ?>

<main>
    <h1>➕ Agregar Producto</h1>

    <div class="formulario-crear">
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="3" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" step="0.01" id="precio" required>

            <label for="imagen">Imagen (ruta):</label>
            <input type="text" name="imagen" id="imagen" required>

            <label for="id_categoria">Categoría:</label>
            <select name="id_categoria" id="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php while($cat = $resultado_categorias->fetch_assoc()) { ?>
                    <option value="<?php echo $cat['id_categoria']; ?>"><?php echo $cat['nombre']; ?></option>
                <?php } ?>
            </select>

            <input type="submit" value="Guardar Producto" class="btn">
        </form>
    </div>
</main>

<?php include('../includes/footer.php'); ?>
