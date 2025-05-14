<?php
include('../includes/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: listar_productos.php?mensaje=eliminado");
        exit();
    } else {
        echo "❌ Error al eliminar el producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ ID no especificado.";
}

$conexion->close();
?>
