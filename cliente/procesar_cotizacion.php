<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST['nombre_cliente'];
    $correo_cliente = $_POST['correo_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $fecha = $_POST['fecha'];

    $productos = $_POST['productos'] ?? [];
    $cantidades = $_POST['cantidades'];

    // Insertar en la tabla cotizaciones
    $sql = "INSERT INTO cotizaciones (nombre_cliente, correo_cliente, telefono_cliente, fecha) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error en prepare (cotizaciones): " . $conexion->error);
    }

    $stmt->bind_param("ssss", $nombre_cliente, $correo_cliente, $telefono_cliente, $fecha);
    $stmt->execute();
    $id_cotizacion = $stmt->insert_id;
    $stmt->close();

    // Insertar los detalles de la cotización
    $sql_detalle = "INSERT INTO detalle_cotizacion (id_cotizacion, id_producto, cantidad) VALUES (?, ?, ?)";
    $stmt_detalle = $conexion->prepare($sql_detalle);

    if (!$stmt_detalle) {
        die("Error en prepare (detalle_cotizacion): " . $conexion->error);
    }

    foreach ($productos as $id_producto) {
        $cantidad = isset($cantidades[$id_producto]) ? (int)$cantidades[$id_producto] : 0;

        if ($cantidad > 0) {
            $stmt_detalle->bind_param("iii", $id_cotizacion, $id_producto, $cantidad);
            $stmt_detalle->execute();
        }
    }

    $stmt_detalle->close();

    // Redirigir al usuario
    header("Location: ver_cotizacion.php");
    exit();
} else {
    echo "Acceso no permitido.";
}
?>
