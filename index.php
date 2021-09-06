<?php
echo "Programación de Aplicaciones Web - Seminario Tecnico Profesional 2021 <br>";
echo "Los Datos son: <br>";
$modelo=$_GET['modelo'];
$nombre=$_GET['nombre'];
$presentacion=$_GET['presentacion'];
echo "<label id=articulo>$modelo</label>";
echo "<div id=nombre>$nombre</div>";
echo "<div id=nombre>$presentacion</div>";
echo "<a href='articulos.php'>Articulos</a>"
?>