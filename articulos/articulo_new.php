<?php
  //echo 'This is Index Page';
include ('config/db.php');
include ('config/config.php');
$nombre=$_POST['nombre'];
$modelo=$_POST['modelo'];
$presentacion=$_POST['presentacion'];

  $sql = "INSERT INTO public.articulos(
	nombre, modelo, presentacion)
	VALUES ('".$nombre."','".$modelo."','".$presentacion."');";
echo $sql;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  #$rowCount = $stmt->rowCount();
  #$details = $stmt->fetch();
  
  while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $datos []= $fila;
    print_r($fila);
    echo "<br>";
  }
  echo $rowCount;
?>