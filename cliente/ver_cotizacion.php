<?php
include('../includes/conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php include('../includes/header.php'); ?>
<link rel="stylesheet" href="../public/css/cotizacion.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>
    <h1><i class="fas fa-file-invoice-dollar icon"></i> Cotizaciones Generadas</h1>

    <?php
    $sql = "SELECT * FROM cotizaciones ORDER BY id_cotizacion ASC";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id_cotizacion = $fila['id_cotizacion'];
            echo "<div class='cotizacion'>";
            echo "<h2><i class='fas fa-receipt icon'></i> Cotización #{$id_cotizacion}</h2>";
            echo "<p><i class='fas fa-user icon'></i><strong>Cliente:</strong> " . htmlspecialchars($fila['nombre_cliente']) . "</p>";
            echo "<p><i class='fas fa-envelope icon'></i><strong>Correo:</strong> " . htmlspecialchars($fila['correo_cliente']) . "</p>";
            echo "<p><i class='fas fa-phone icon'></i><strong>Teléfono:</strong> " . htmlspecialchars($fila['telefono_cliente']) . "</p>";
            echo "<p><i class='fas fa-calendar-alt icon'></i><strong>Fecha:</strong> " . htmlspecialchars($fila['fecha']) . "</p>";

            // Detalles de productos
            $sql_detalle = "SELECT p.nombre, p.precio, d.cantidad 
                            FROM detalle_cotizacion d
                            INNER JOIN productos p ON d.id_producto = p.id_producto
                            WHERE d.id_cotizacion = ?";
            $stmt = $conexion->prepare($sql_detalle);
            $total = 0;

            if ($stmt) {
                $stmt->bind_param("i", $id_cotizacion);
                $stmt->execute();
                $resultado_detalle = $stmt->get_result();

                if ($resultado_detalle && $resultado_detalle->num_rows > 0) {
                    echo "<table class='producto-table'>";
                    echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead><tbody>";

                    while ($producto = $resultado_detalle->fetch_assoc()) {
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;

                        echo "<tr>
                                <td>" . htmlspecialchars($producto['nombre']) . "</td>
                                <td>" . $producto['cantidad'] . "</td>
                                <td>$" . number_format($producto['precio'], 2) . "</td>
                                <td>$" . number_format($subtotal, 2) . "</td>
                              </tr>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p><i class='fas fa-exclamation-circle icon'></i>No hay productos en esta cotización.</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Error al consultar productos: " . $conexion->error . "</p>";
            }

            echo "<div class='total'><i class='fas fa-dollar-sign icon'></i>Total: $" . number_format($total, 2) . "</div>";

            // Botón Generar Pedido
            echo "<a href='generar_pedido.php?id_cotizacion={$id_cotizacion}' class='boton-generar-pedido'>
                    <i class='fas fa-check-circle'></i> Generar Pedido
                  </a>";

            echo "</div>"; // Cierre de .cotizacion

        }
    } else {
        echo "<p>No hay cotizaciones registradas.</p>";
    }
    ?>
</main>

<?php include('../includes/footer.php'); ?>
