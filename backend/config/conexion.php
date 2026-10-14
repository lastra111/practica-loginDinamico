<?php 

//configurar la conexion   de la BD con las credenciales
$host = '127.0.0.1';
$db ='sistema_roles_dinamicos';
$user ='root';
$pass ='';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

//opciones de seguridad de PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//reportar error como excepciones editables
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //retornar arreglos ASOCIATIVOS DE COLUMNAS
    PDO::ATTR_EMULATE_PREPARES => false,//desactivar emulacion para mitigar sql Injection de raiz
    
];
//header('Content-Type: application/json');
try{
    $pdo = new PDO ($dsn, $user, $pass, $options);
    /*echo json_encode([
        "status" => "success",
        "message" => "¡Conexion establecida correctamente con la base de datos!"
    ]);*/
}catch(\PDOException $e ){
    //no mostrar $e->getMesseg() en produccion, expone credenciales
    header('Content-Type: application/json');
    echo json_encode(["Status"=> "error","message" => "Error interno del servidor."]);
}

?>