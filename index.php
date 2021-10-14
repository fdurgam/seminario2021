<?php
@session_start();
require 'model/Slim/Slim.php';
echo "app";
echo "app 14-10-2021";
\Slim\Slim::registerAutoloader();
echo $_POST["nombre"];
$app = new \Slim\Slim();


include './includes/config.php';
$host = "ec2-52-3-130-181.compute-1.amazonaws.com";
$user = "uyvfnnuuhfsrrx";
$password = "3500d56bc9d1e33ba8945d79060e8c6a9e2b7069b871e2db42ff6ba4ffbbbdc5";
$dbname = "dd3pq672l8kf2o";
$port = "5432";
$dsn = "pgsql:host=" . $host . ";port=" . $port .";dbname=" . $dbname . ";user=" . $user . ";password=" . $password . ";";
$db = new PDO($dsn, $user, $password);


$app->get('/usuarios', function() use($db) {

    // Si necesitamos acceder a alguna variable global en el framework
    // Tenemos que pasarla con use() en la cabecera de la función. Ejemplo: use($db)
    // Va a devolver un objeto JSON con los datos de usuarios.
    // Preparamos la consulta a la tabla.

    $consulta = $db->prepare("select * from soporte_usuarios");
    $consulta->execute();
    // Almacenamos los resultados en un array asociativo.
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
    // Devolvemos ese array asociativo como un string JSON.
    echo json_encode($resultados);
});


$app->get('/', function() {
    echo "Pagina de gestión API REST de mi aplicación.";
   // echo "<a href='".$ _SERVER ['DOCUMENT_ROOT']."/index.php/usuarios'>Usuarios</a>";
   // echo "<a href='http://localhost/seminarioV2/seminario/usuarios.html'>Nuevo usuario</a>";
});
$app->get('/test', function() {
    echo "Pagina de gestión API REST de mi aplicación en test.";
   // echo "<a href='".$ _SERVER ['DOCUMENT_ROOT']."/index.php/usuarios'>Usuarios</a>";
   // echo "<a href='http://localhost/seminarioV2/seminario/usuarios.html'>Nuevo usuario</a>";
});


$app->post('/usuarios/new',function() use($db,$app) {
    // Para acceder a los datos recibidos del formulario
    $datosform=$app->request;
    
    // Los datos serán accesibles de esta forma:
    // $datosform->post('apellidos')
    
    // Preparamos la consulta de insert.
    
    $consulta=$db->prepare("insert into soporte_usuarios(nombre,apellido,dni,usuario,contrasena,email) 
					values (:nombre,:apellido,:dni,:usuario,:contrasena,:email)");
    
    $estado=$consulta->execute(
            array(
                ':nombre'=> $datosform->post('nombre'),
                ':apellido'=> $datosform->post('apellido'),
                ':dni'=> $datosform->post('dni'),
                ':usuario'=> $datosform->post('usuario'),
                ':contrasena'=> $datosform->post('contrasena'),
                ':email'=> $datosform->post('email')
                )
            );
    if ($estado)
        echo json_encode(array('estado'=>true,'mensaje'=>'Datos insertados correctamente.'));
    else
        echo json_encode(array('estado'=>false,'mensaje'=>'Error al insertar datos en la tabla.'));
});

$app->run();
echo "app";
?>

