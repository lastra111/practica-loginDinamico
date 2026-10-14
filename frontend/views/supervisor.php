<?php
session_start();

//control de accesso para supervisor
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Supervisor'){
   //si no es supervisor, lo expulsamos al formulario de login
   header('Location: index.html');
   exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Supervisor</title>
    
   <link rel="stylesheet" href="../css/supervisor.css">
  
</head>
<body>
  <div class="container">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
    <h3>Rol Actual:  <?php echo $_SESSION['rol']; ?>(Permiso de lectura y Control)</h3>
    <p> Area exclusiva para la supervision de operaciones del sistema</p>
    <hr>
    <a href="../../backend/api/logout.php">Cerrar Sesión de manera segura...</a>
    </div>
</body>
</html>