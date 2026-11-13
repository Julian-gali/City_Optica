<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();
$_SESSION["Login"]="";

$error = "";

if( isset($_POST["procesoAutenticacion"]) )
 {
   $usuario = $_POST["valorUsuario"];
   $clave = $_POST["valorClave"];
   
   $resultado =  $objLogica->validarAcceso($usuario, $clave);    
   if( $resultado != "" && count($resultado) > 0 )
    {
      foreach($resultado as $row => $col)
       {
           $_SESSION["NombreCompleto"] = $col["nombre"];
           $_SESSION["Login"] = $col["login"];
           $_SESSION["IdUsuario"] = $col["idUsuario"];
           header("Location: panel.php");
           exit();
       }
    }
    else {
      $error = "Usuario o contraseña incorrectos";
    }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Acceso - City Óptica</title>
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
        <li class="nav-item"><a class="nav-link enlace-menu" href="resenas.php">Reseñas</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="registro.php">Registro</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="login.php">
          <?php if(isset($_SESSION["Login"]) && $_SESSION["Login"] != ""){ echo "Panel"; } else { echo "Acceso"; } ?>
        </a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container seccion" style="min-height: 600px; padding: 50px 0;">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        
        <h2 style="text-align: center; color: #1a759f; margin-bottom: 10px; font-weight: bold;">
          <i class="fa fa-eye"></i> City Óptica
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 40px;">
          Panel de administración
        </p>

        <?php if($error != ""): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
            <button type="button" class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <form name="formularioAcceso" action="login.php" method="POST" onsubmit="return validarFormulario();">
          <input type="hidden" name="procesoAutenticacion" value="1">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-user"></i> Usuario
            </label>
            <input type="text" name="valorUsuario" id="valorUsuario" class="form-control" placeholder="Tu usuario" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-lock"></i> Contraseña
            </label>
            <input type="password" name="valorClave" id="valorClave" class="form-control" placeholder="Tu contraseña" required>
          </div>

          <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin: 30px 0 20px 0;">
            <i class="fa fa-sign-in"></i> Ingresar
          </button>
        </form>

        <div style="text-align: center; color: #666; font-size: 0.9rem;">
          <p>¿No tienes cuenta? <a href="registro.php" style="color: #1a759f; font-weight: bold;">Regístrate aquí</a></p>
          <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
            <a href="index.php" style="color: #1a759f; text-decoration: none;">
              <i class="fa fa-arrow-left"></i> Volver al inicio
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function validarFormulario(){
  var usuario = document.getElementById("valorUsuario").value.trim();
  var clave = document.getElementById("valorClave").value.trim();

  if(usuario == "" || clave == ""){
    alert("Por favor completa todos los campos");
    return false;
  }

  return true;
}
</script>

<!-- FOOTER -->
<footer class="footer" style="background-color: #1a759f; color: white; padding: 30px 0; margin-top: 50px;">
  <div class="text-center">
    <p>City Óptica © 2026 | Todos los derechos reservados</p>
  </div>
</footer>

</body>
</html>
