<?php
// Activamos las sesiones para el funcionamiento de flash['']
@session_start();

require 'Slim/Slim.php';

// El framework Slim tiene definido un namespace llamado Slim
// Por eso aparece \Slim\ antes del nombre de la clase.
\Slim\Slim::registerAutoloader();

// Creamos la aplicación.
$app = new \Slim\Slim();

// Configuramos la aplicación. http://docs.slimframework.com/#Configuration-Overview
// Se puede hacer en la línea anterior con:
// $app = new \Slim\Slim(array('templates.path' => 'vistas'));
// O bien con $app->config();
$app->config(array(
    'templates.path' => 'vistas',
));

// Indicamos el tipo de contenido y condificación que devolvemos desde el framework Slim.
$app->contentType('text/html; charset=utf-8');

// Definimos conexion de la base de datos.
// Lo haremos utilizando PDO con el driver mysql.

include '../includes/config.php';
$host = "ec2-52-3-130-181.compute-1.amazonaws.com";
$user = "uyvfnnuuhfsrrx";
$password = "3500d56bc9d1e33ba8945d79060e8c6a9e2b7069b871e2db42ff6ba4ffbbbdc5";
$dbname = "dd3pq672l8kf2o";
$port = "5432";
$dsn = "pgsql:host=" . $host . ";port=" . $port .";dbname=" . $dbname . ";user=" . $user . ";password=" . $password . ";";
$db = new PDO($dsn, $user, $password);


// Hacemos la conexión a la base de datos con PDO.
// Para activar las collations en UTF8 podemos hacerlo al crear la conexión por PDO
// o bien una vez hecha la conexión con
// $db->exec("set names utf8");
//$db = new PDO('pgsql:host=' . BD_SERVIDOR . ';dbname=' . BD_NOMBRE, BD_USUARIO, BD_PASSWORD);

//$db = new PDO('mysql:host=' . BD_SERVIDOR . ';dbname=' . BD_NOMBRE . ';charset=utf8', BD_USUARIO, BD_PASSWORD);
//$db = new PDO("pgsql:host=localhost;dbname=seminario", 'postgres', 'postgres');

//$conn = new PDO("pgsql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);
////////////////////////////////////////////
// Definición de rutas en la aplicación:
// Ruta por defecto de la aplicación /
////////////////////////////////////////////
//echo getcwd() . "\n";
$app->get('/', function() {
            echo "Pagina de gestión API REST de mi aplicación.";
           // echo "<a href='".$ _SERVER ['DOCUMENT_ROOT']."/index.php/usuarios'>Usuarios</a>";
           // echo "<a href='http://localhost/seminarioV2/seminario/usuarios.html'>Nuevo usuario</a>";
        });



// Cuando accedamos por get a la ruta /usuarios ejecutará lo siguiente:
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
      echo $datosform->post('nombre');
      echo $datosform->post('email');
    if ($estado)
        echo json_encode(array('estado'=>true,'mensaje'=>'Datos insertados correctamente.'));
    else
        echo json_encode(array('estado'=>false,'mensaje'=>'Error al insertar datos en la tabla.'));
});

// Programamos la ruta de borrado en la API REST (DELETE)
$app->delete('/usuarios/:idusuario',function($id) use($db)
{
   $consulta=$db->prepare("delete from soporte_usuarios where id=:id");
   
   $consulta->execute(array(':id'=>$id));
   
if ($consulta->rowCount() == 1)
   echo json_encode(array('estado'=>true,'mensaje'=>'El usuario '.$id.' ha sido borrado correctamente.'));
 else
   echo json_encode(array('estado'=>false,'mensaje'=>'ERROR: ese registro no se ha encontrado en la tabla.'.$idusuario));
    
});

$app->put('/usuarios/:id',function($id) use($db,$app) {
    // Para acceder a los datos recibidos del formulario
    $datosform=$app->request;
    
    // Los datos serán accesibles de esta forma:
    // $datosform->post('apellidos')
    
    // Preparamos la consulta de update.
    $consulta=$db->prepare("update soporte_usuarios set nombre=:nombre, apellido=:apellido, email=:email 
							where id=:id");
    
    $estado=$consulta->execute(
            array(
                ':id'=>$id,
                ':nombre'=> $datosform->post('nombre'),
                ':apellido'=> $datosform->post('apellido'),
                ':email'=> $datosform->post('email')
                )
            );
    
    // Si se han modificado datos...
    if ($consulta->rowCount()==1)
      echo json_encode(array('estado'=>true,'mensaje'=>'Datos actualizados correctamente.'));
    else
      echo json_encode(array('estado'=>false,'mensaje'=>'Error al actualizar datos, datos 
						no modificados o registro no encontrado.'));
});
		


$app->run();
?>

