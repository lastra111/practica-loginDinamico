<?php
session_start();

// protegemos el servicio solo peteciones legitimas de sesion admin
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador' ){
    http_response_code(403);
    echo json_encode(["status " => "error", "message" => "No autorizado"]);
    exit();
}

header('Content-Type: application/json');
require '../config/conexion.php'; // Sube un nivel a backend/config/conexion.php 

try {
    //obtenemos el id y nombre de los roles para mapear el formulario
    $stmt = $pdo ->query("SELECT id, nombre FROM roles ORDER BY id ASC");
    $roles = $stmt->fetchAll();

    echo json_encode($roles);
}catch(\PDOException $e){
    http_response_code(500);
    echo json_encode(["status " => "error", "message" => "Error al consultar roles."]);
}

?>