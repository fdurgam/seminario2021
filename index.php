<?php
echo "Los Datos son: <br>";
$modelo=$_GET['modelo'];
$nombre=$_GET['nombre'];
$presentacion=$_GET['presentacion'];
echo "<label id=articulo>$modelo</label>";
echo "<div id=nombre>$nombre</div>";
echo "<div id=nombre>$presentacion</div>";
echo "<a href='articulos.php'>Articulos de Seminario</a>"
?>