<?php
include('../includes/conexion.php');
include('../includes/header.php');
?>
<link rel="stylesheet" href="../public/css/cotizacion.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>
    <h1><i class="fas fa-truck icon"></i> Pedidos Generados</h1>

    <?php
    $sql = "SELECT * FROM pedidos ORDER BY id_pedido ASC";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($pedido = $resultado->fetch_assoc()) {
            $id_pedido = $pedido['id_pedido'];
            echo "<div class='cotizacion'>";
            echo "<h2><i class='fas fa-box icon'></i> Pedido #{$id_pedido}</h2>";
            echo "<p><i class='fas fa-user icon'></i><strong>Cliente:</strong> " . htmlspecialchars($pedido['nombre_cliente']) . "</p>";
            echo "<p><i class='fas fa-envelope icon'></i><strong>Correo:</strong> " . htmlspecialchars($pedido['correo_cliente']) . "</p>";
            echo "<p><i class='fas fa-phone icon'></i><strong>Teléfono:</strong> " . htmlspecialchars($pedido['telefono_cliente']) . "</p>";
            echo "<p><i class='fas fa-calendar-alt icon'></i><strong>Fecha:</strong> " . htmlspecialchars($pedido['fecha']) . "</p>";

            // Detalle del pedido
            $sql_detalle = "SELECT p.nombre, p.precio, d.cantidad 
                            FROM detalle_pedido d
                            INNER JOIN productos p ON d.id_producto = p.id_producto
                            WHERE d.id_pedido = ?";
            $stmt = $conexion->prepare($sql_detalle);
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();
            $resultado_detalle = $stmt->get_result();
            $total = 0;

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
                echo "<p><i class='fas fa-exclamation-circle icon'></i> No hay productos en este pedido.</p>";
            }

            $stmt->close();

            echo "<div class='total'><i class='fas fa-dollar-sign icon'></i>Total: $" . number_format($total, 2) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay pedidos registrados.</p>";
    }
    ?>
</main>

<?php include('../includes/footer.php'); ?>
