<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/conexion.php');

// Obtener los productos de la base de datos
$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>

<?php include('../includes/header.php'); ?>

<main>
    <h1>Crear Cotización</h1>
    <form action="procesar_cotizacion.php" method="POST">
        <label>Nombre del cliente:</label><br>
        <input type="text" name="nombre_cliente" required><br><br>
        
        <label for="correo_cliente">Correo Electrónico:</label><br>
        <input type="email" id="correo_cliente" name="correo_cliente" required><br><br>    

        <label for="telefono_cliente">Teléfono:</label><br> 
            <input type="text" id="telefono_cliente" name="telefono_cliente"><br><br> 
            

        <label>Fecha:</label><br>
            <input type="date" name="fecha" required><br><br>

        <h3>Selecciona los productos:</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while($producto = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><input type="checkbox" name="productos[]" value="<?php echo $producto['id_producto']; ?>"></td>
                        <td><img src="<?php echo $producto['imagen']; ?>" width="60" alt="<?php echo $producto['nombre']; ?>"></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td>
                            <button type="button" onclick="cambiarCantidad(<?php echo $producto['id_producto']; ?>, -1)">➖</button>
                            <input type="number" name="cantidades[<?php echo $producto['id_producto']; ?>]" id="cantidad_<?php echo $producto['id_producto']; ?>" min="0" value="0" style="width: 50px; text-align: center;">

                            <button type="button" onclick="cambiarCantidad(<?php echo $producto['id_producto']; ?>, 1)">➕</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><input type="submit" value="Generar Cotización">
    </form>
</main>

<script src="../public/js/cotizacion.js"></script>
<?php include('../includes/footer.php'); ?>
