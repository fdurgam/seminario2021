<?php
$host = "ec2-52-3-130-181.compute-1.amazonaws.com";
$user = "uyvfnnuuhfsrrx";
$password = "3500d56bc9d1e33ba8945d79060e8c6a9e2b7069b871e2db42ff6ba4ffbbbdc5";
$dbname = "dd3pq672l8kf2o";
$port = "5432";

try{
  //Set DSN data source name
    $dsn = "pgsql:host=" . $host . ";port=" . $port .";dbname=" . $dbname . ";user=" . $user . ";password=" . $password . ";";


  //create a pdo instance
  
  $pdo = new PDO($dsn, $user, $password);
 
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
echo 'Connection failed: ' . $e->getMessage();
}
 ?>