<?php
$db["host"]="localhost";
$db["port"]="5432";
$db["user"]="postgres";
$db["pass"]="postgres";
$pdo = new PDO("pgsql:" . sprintf(
    "host=%s;port=%s;user=%s;password=%s;dbname=%s",
    $db["host"],
    $db["port"],
    $db["user"],
    $db["pass"],
    ltrim($db["path"], "/")
));

?>