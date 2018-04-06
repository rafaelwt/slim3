<?php


/* Los headers permiten acceso desde otro dominio (CORS) a nuestro REST API o desde un cliente remoto via HTTP
 * Removiendo las lineas header() limitamos el acceso a nuestro RESTfull API a el mismo dominio
 * Nótese los métodos permitidos en Access-Control-Allow-Methods. Esto nos permite limitar los métodos de consulta a nuestro RESTfull API
 * Mas información: https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 **/
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 

//include_once '../include/Config.php';
include '../dal/Config.php';
include '../dal/Database.php';


if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Define app routes
$app->get('/getpersonas/{name}', function ($request, $response, $args) {
	 
	 $db = new Database();
     $db->query("SELECT cod,nombre ,app FROM persona");
     //$db->bind(":fIdReleases", $release);
	 
     $rows = $db->resultset();

   
     $result = array();
    $result["error"] = false;
    $result["datos"] = $rows;

   if($rows) {
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($result));
		} 
	else { throw new PDOException('No records found');}
});

function obtenerPersonas($response) {
	
	try{
    $db = new Database();
    $db->query("SELECT cod,nombre ,app FROM persona");
     //$db->bind(":fIdReleases", $release);
	 
     $rows = $db->resultset();

   
    $result = array();
    $result["error"] = false;
    $result["datos"] = $rows;

	return json_encode($result);
	} catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}





// Run app
$app->run();
