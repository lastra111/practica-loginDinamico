<?php
session_start();

//control de accesso para supervisor
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Cliente'){
   //si no es cliente, lo expulsamos al formulario de login
   header('Location: index.html');
   exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del cliente</title>
    <link rel="stylesheet" href="../css/cliente.css">
</head>
<body>
  <div class="container">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
    <h3>Rol Actual:  <?php echo $_SESSION['rol']; ?>(Permiso de lectura y control)</h3>
    <p> Area exclusiva del cliente</p>
    <hr>
   <a href="../../backend/api/logout.php">Cerrar Sesión de manera segura...</a>
    </div>
</body>
</html>