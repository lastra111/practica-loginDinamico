<?php
//configuracion estricta de cookies de sesion para  mitigar secuestros de sesion  (Session Hijacking)
session_start([
    'cookie_lifetime' => 0, //expira al cerrar el navegador
    'cookie_secure' => false, //cambiar a true si usan https en producion 
    'cookie_httponly' => true, //Java script no puede leer la cookie (Mitiga XSS)
    'cookie_samesite' => 'Strict' //No se envia la cookie en navegaciones externas
]); 

header('Content-Type: application/json');
require '../config/conexion.php';

// Capturar el flujo JSON crudo enviado desde javaScript 
$entrada = json_decode(file_get_contents('php://input'), true);

$userPost = $entrada['usuario'] ?? '';
$passPost = $entrada['password'] ?? '';

if (empty($userPost) || empty($passPost)) {
    echo json_encode(["status" => "error", "message" => "Campos invalidos."]);
    exit;
}

/*
1. Defensa ANTI-INYECCION SQL : Sentencia Prepara (Prepared Statement) .
   El marcador de posicion '?' le dice al motor de la BD que lo que vaya ahi estrictamente un TEXTO LITERAL, no codigo ejecutable
 */
$sql = "SELECT u.id, u.password, r.nombre AS rol_nombre FROM usuario u INNER JOIN roles r  ON u.rol_id = r.id WHERE u.usuario = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userPost]);
$usuarioDb = $stmt->fetch();

/*
2. Comprobacion de contraseña con BCRYPT HASH.
    password_verify() extrae automaticamente la sal y el costo del hash guardado en la BD y computa la contraseña ingresada para ver si coincide.
 */

if ($usuarioDb && password_verify($passPost, $usuarioDb['password'])){
    // Defensa critica: Cambia el id de la sesion para evitar Session Fixation
    session_regenerate_id(true);
    
    // Guardar informacion minima y necesaria en la sesion del servidor.
    $_SESSION['id_usuario'] = $usuarioDb['id'];
    $_SESSION['nombre_usuario'] = $userPost;
    $_SESSION['rol'] = $usuarioDb['rol_nombre'];

    //enrutamiento dinamico segun el rol recuperado de la base de datos.
    $redireccion = '../../frontend/views/cliente.php';
    if ($usuarioDb['rol_nombre'] === 'Administrador') $redireccion = '../../frontend/views/admin.php';
    if ($usuarioDb['rol_nombre'] === 'Supervisor') $redireccion = '../../frontend/views/supervisor.php';

    echo json_encode(["status" => "success", "redirect" => $redireccion]);
}else{
    //mensaje generico: No le digan al atacante si fallo el usuario o la contraseña
    echo json_encode(["status" => "error", "message"=> "Credenciales incorrectas."]);
}
