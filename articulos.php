<?php include ('config/db.php')?>
<?php include ('config/config.php')?>

<html>
<head>
  <title>ARTICULOS A LA VENTA</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="<?php echo ROOT_URL; ?>">Articulos de Negocio</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>">Inicio</a>
      </li>
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>about">Nosotros</a>
      </li>
      <li>
        <a class="nav-link" href="<?php echo ROOT_URL; ?>contact">Contactos</a>
      </li>
    </ul>
      </div>
</nav>

<?php
  //echo 'This is Index Page';

  $sql = 'SELECT * FROM articulos';
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

</body>
</html>