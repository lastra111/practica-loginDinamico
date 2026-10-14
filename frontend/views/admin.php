<?php
session_start();

// Control de acceso estricto a nivel de servidor
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador' ){
    // si no esta logueado o no pertenece aqui, es expulsado al login  inmediatamente.
    header('Location: index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- htmlspecialchars previene ataques XSS al renderizar datos del usuario. -->
    <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
    <h3>Rol Actual:  <?php echo $_SESSION['rol']; ?>(Acesso Total)</h3>
    <p> Area exclusiva de administracion</p>
    <<a href="../../backend/api/logout.php">Cerrar Sesión de manera segura...</a>
</body>
</html>
