<?php
include("includes/conexion.php");
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - My Delights</title>
  <link rel="stylesheet" href="/mi_restaurante/public/css/style.css">
</head>
<body>

<?php include("includes/header.php"); ?>

<div class="container">
  <nav>
    <ul>
      <h1>Menú</h1>
      <li><a href="index.php">Inicio</a></li>
      <?php
      // Cargar categorías en el menú
      $categorias = mysqli_query($conexion, "SELECT id_categoria, nombre FROM categorias");
      while ($cat = mysqli_fetch_assoc($categorias)) {
          echo '<li><a href="productos.php?id_categoria=' . $cat['id_categoria'] . '">' . htmlspecialchars($cat['nombre']) . '</a></li>';
      }
      ?>
    </ul>
  </nav>

  <main>
    <div class="menu-section" style="display:block;">
      <?php
      if (isset($_GET['id_categoria'])) {
          $id_categoria = intval($_GET['id_categoria']);

          // Obtener nombre de la categoría
          $consulta_categoria = mysqli_query($conexion, "SELECT nombre FROM categorias WHERE id_categoria = $id_categoria");
          $categoria = mysqli_fetch_assoc($consulta_categoria);
          echo "<h2>" . htmlspecialchars($categoria['nombre']) . "</h2>";

          // Obtener productos de esa categoría
          $consulta = "SELECT * FROM productos WHERE id_categoria = $id_categoria";
          $resultado = mysqli_query($conexion, $consulta);

          if ($resultado && mysqli_num_rows($resultado) > 0) {
              while ($fila = mysqli_fetch_assoc($resultado)) {
                  echo "<div class='dish'>";
                  echo "<img src='" . htmlspecialchars($fila['imagen']) . "' alt='" . htmlspecialchars($fila['nombre']) . "'>";
                  echo "<div>";
                  echo "<p><strong>" . htmlspecialchars($fila['nombre']) . "</strong></p>";
                  echo "<p>" . htmlspecialchars($fila['descripcion']) . "</p>";
                  echo "<p>Precio: $" . number_format($fila['precio'], 0, ',', '.') . "</p>";
                  echo "</div></div>";
              }
          } else {
              echo "<p>No hay productos en esta categoría.</p>";
          }
      } else {
          echo "<h2> ⬅ Selecciona una categoría del menú en la izquierda</h2>";
      }
      ?>
    </div>
  </main>

  <?php include("includes/aside.php"); ?>
</div>

<?php include("includes/footer.php"); ?>
<script src="/mi_restaurante/public/script.js"></script>
</body>
</html>
