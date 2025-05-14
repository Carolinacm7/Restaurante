<?php
include("includes/conexion.php");
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - My Delights</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="container">
  <nav>
    <ul>
      <h1>Menú</h1>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="productos.php">Productos</a></li>
    </ul>
  </nav>

  <main>
    <div>
    
        <h2> <span>¡¡</span> Bienvenidos <span>!!</span></h2>
        
        <img src=".\imagenes\logo.png" alt="Delights" class="logo"> 
         <h2>un lugar donde la gastronomía se convierte en arte, <br>
         los ingredientes cuentan su propia historia y <br> 
         cada detalle está pensado para deleitar tus sentidos.</h2>
         <img src="https://www.emagister.com/blog/wp-content/uploads/2019/08/GettyImages-516329534-e1568708270617.jpg" alt="Delights" class="logo2"> 
    </div>
   
           
      </div>

    </div>

    <?php
    $query_categorias = "SELECT * FROM categorias";
    $resultado_categorias = mysqli_query($conexion, $query_categorias);

    if ($resultado_categorias && mysqli_num_rows($resultado_categorias) > 0) {
      while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
        echo "<section class='menu-section'>";
        echo "<h3>" . htmlspecialchars($categoria['nombre']) . "</h3>";

        $id_categoria = $categoria['id'];
        $query_productos = "SELECT * FROM productos WHERE id_categoria = $id_categoria";
        $resultado_productos = mysqli_query($conexion, $query_productos);

        if ($resultado_productos && mysqli_num_rows($resultado_productos) > 0) {
          while ($producto = mysqli_fetch_assoc($resultado_productos)) {
            echo "<div class='dish'>";
            echo "<img src='" . htmlspecialchars($producto['imagen']) . "' alt='" . htmlspecialchars($producto['nombre']) . "'>";
            echo "<div>";
            echo "<p><strong>" . htmlspecialchars($producto['nombre']) . "</strong></p>";
            echo "<p>" . htmlspecialchars($producto['descripcion']) . "</p>";
            echo "<p>Precio: $" . number_format($producto['precio'], 0, ',', '.') . "</p>";
            echo "</div></div>";
          }
        } else {
          echo "<p>No hay productos en esta categoría.</p>";
        }

        echo "</section>";
      }
    } else {
      echo "<p>No se encontraron categorías.</p>";
    }
    ?>
  </main>

  <?php include("aside.php"); ?>
</div>

<?php include('includes/footer.php'); ?>
<script src="script.js"></script>
</body>
</html>
