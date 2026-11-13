<?php
session_start();

if(!isset($_SESSION['pedido_procesado']) || $_SESSION['pedido_procesado'] !== true){
  header("Location: carrito.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Confirmación de Pedido - City Óptica</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<!-- BARRA DE NAVEGACIÓN -->
<nav class="navbar navbar-expand-lg navbar-dark barra-superior">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" style="padding: 0; margin-right: 50px;">
      <span class="logo-optica">City Óptica</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link enlace-menu" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="catalogo.php">Catálogo</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="carrito.php">Carrito</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="registro.php">Registro</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="login.php">
          <?php if(isset($_SESSION["Login"]) && $_SESSION["Login"] != ""){ echo "Panel"; } else { echo "Acceso"; } ?>
        </a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container seccion" style="padding: 100px 0; min-height: 500px; text-align: center;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div style="background: white; padding: 50px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 30px;">
          <i class="fa fa-check-circle" style="font-size: 4rem; color: #28a745;"></i>
        </div>

        <h2 style="color: #1a759f; margin-bottom: 20px; font-weight: bold;">
          ¡Pedido Realizado!
        </h2>

        <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">
          <?php echo isset($_SESSION['mensaje_pedido']) ? $_SESSION['mensaje_pedido'] : 'Tu pedido ha sido procesado exitosamente.'; ?>
        </p>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: left; margin-bottom: 30px;">
          <h5 style="color: #1a759f; margin-bottom: 15px; font-weight: bold;">
            Detalles del cliente:
          </h5>
          <p style="margin: 8px 0;">
            <strong>Nombre:</strong> <?php echo isset($_SESSION['cliente_nombre']) ? $_SESSION['cliente_nombre'] : 'N/A'; ?>
          </p>
          <p style="margin: 8px 0;">
            <strong>Email:</strong> <?php echo isset($_SESSION['cliente_email']) ? $_SESSION['cliente_email'] : 'N/A'; ?>
          </p>
        </div>

        <div style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px;">
          <p style="color: #666; margin: 0;">
            Te enviaremos un email de confirmación con los detalles de tu pedido.
          </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <a href="catalogo.php" class="btn btn-primary btn-lg">
            <i class="fa fa-shopping-bag"></i> Seguir comprando
          </a>
          <a href="index.php" class="btn btn-outline-primary btn-lg">
            <i class="fa fa-home"></i> Ir al inicio
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<div style="background-color: #1a759f; color: white; padding: 30px; margin-top: 50px; text-align: center;">
  <p style="margin: 0;">© 2026 City Óptica. Todos los derechos reservados.</p>
</div>

<script>
// Limpiar sesión después de mostrar la confirmación
setTimeout(function() {
  <?php 
    unset($_SESSION['pedido_procesado']);
    unset($_SESSION['cliente_id']);
    unset($_SESSION['cliente_nombre']);
    unset($_SESSION['cliente_email']);
    unset($_SESSION['mensaje_pedido']);
  ?>
}, 3000);
</script>
</body>
</html>
