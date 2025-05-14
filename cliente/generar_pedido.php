<?php
include('../includes/conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['id_cotizacion'])) {
    die("ID de cotización no proporcionado.");
}

$id_cotizacion = intval($_GET['id_cotizacion']);

// 1. Obtener datos de la cotización
$sql_cotizacion = "SELECT * FROM cotizaciones WHERE id_cotizacion = ?";
$stmt = $conexion->prepare($sql_cotizacion);
$stmt->bind_param("i", $id_cotizacion);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Cotización no encontrada.");
}

$cotizacion = $resultado->fetch_assoc();
$stmt->close();

// 2. Insertar nuevo pedido
$sql_insert_pedido = "INSERT INTO pedidos (nombre_cliente, correo_cliente, telefono_cliente) VALUES (?, ?, ?)";
$stmt_pedido = $conexion->prepare($sql_insert_pedido);
$stmt_pedido->bind_param("sss", $cotizacion['nombre_cliente'], $cotizacion['correo_cliente'], $cotizacion['telefono_cliente']);
$stmt_pedido->execute();
$id_pedido = $stmt_pedido->insert_id;
$stmt_pedido->close();

// 3. Obtener productos de la cotización
$sql_detalles = "SELECT id_producto, cantidad FROM detalle_cotizacion WHERE id_cotizacion = ?";
$stmt_detalle = $conexion->prepare($sql_detalles);
$stmt_detalle->bind_param("i", $id_cotizacion);
$stmt_detalle->execute();
$resultado_detalles = $stmt_detalle->get_result();

// 4. Insertar productos en detalle_pedido
$sql_insert_detalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)";
$stmt_insert_detalle = $conexion->prepare($sql_insert_detalle);

while ($producto = $resultado_detalles->fetch_assoc()) {
    $stmt_insert_detalle->bind_param("iii", $id_pedido, $producto['id_producto'], $producto['cantidad']);
    $stmt_insert_detalle->execute();
}

$stmt_insert_detalle->close();
$stmt_detalle->close();

// 5. Redireccionar o confirmar
header("Location: ver_pedidos.php?exito=1");
exit;
?>
