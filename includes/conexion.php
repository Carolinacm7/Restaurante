<?php
$host = "localhost";
$usuario = "root"; 
$contrasena = "Annie"; 
$basedatos = "restaurante"; 

$conexion = mysqli_connect($host, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
