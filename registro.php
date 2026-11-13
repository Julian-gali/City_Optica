<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

$mensaje = "";
$tipo_mensaje = "";

if(isset($_POST["procesoRegistro"])){
  $nombre = $_POST["nombre"];
  $documento = $_POST["documento"];
  $telefono = $_POST["telefono"];
  $email = $_POST["email"];
  $tipoLente = $_POST["tipoLente"];

  // Validar que el email no exista
  $existe = $objLogica->validarClienteExiste($email);
  
  if($existe > 0){
    $mensaje = "Este email ya está registrado en nuestro sistema.";
    $tipo_mensaje = "danger";
  } else {
    // Guardar cliente
    $resultado = $objLogica->guardarCliente($nombre, $documento, $telefono, $email, $tipoLente);
    if($resultado){
      $mensaje = "¡Registro completado exitosamente! Bienvenido a City Óptica.";
      $tipo_mensaje = "success";
    } else {
      $mensaje = "Error al guardar el registro. Intenta de nuevo.";
      $tipo_mensaje = "danger";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Registro - City Óptica</title>
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
<div class="container seccion" style="min-height: 600px; padding: 50px 0 100px 0; margin-bottom: 50px;">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h3 class="titulo-seccion text-center mb-4" style="color: #1a759f; font-size: 2.2rem;">
        <i class="fa fa-user-plus"></i> Registro de clientes
      </h3>

      <?php if($mensaje != ""): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
          <i class="fa fa-<?php echo ($tipo_mensaje == "success" ? "check-circle" : "exclamation-circle"); ?>"></i>
          <?php echo $mensaje; ?>
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <div class="formulario-box" style="background: #f8f9fa; padding: 40px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <form method="POST" action="registro.php" onsubmit="return validarFormulario();">
          <input type="hidden" name="procesoRegistro" value="1">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-user"></i> Nombre completo <span style="color: red;">*</span>
            </label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Tu nombre completo" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-id-card"></i> Documento de identidad <span style="color: red;">*</span>
            </label>
            <input type="text" name="documento" class="form-control" id="documento" placeholder="Tu número de cédula" required>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label style="font-weight: bold; color: #1a759f;">
                <i class="fa fa-phone"></i> Teléfono <span style="color: red;">*</span>
              </label>
              <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="Tu teléfono" required>
            </div>

            <div class="form-group col-md-6">
              <label style="font-weight: bold; color: #1a759f;">
                <i class="fa fa-envelope"></i> Correo electrónico <span style="color: red;">*</span>
              </label>
              <input type="email" name="email" class="form-control" id="email" placeholder="tu@email.com" required>
            </div>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-glasses"></i> Tipo de lente <span style="color: red;">*</span>
            </label>
            <select name="tipoLente" class="form-control" id="tipoLente" required style="height: 50px; padding: 12px; font-size: 1rem;">
              <option value="">-- Selecciona el tipo de lente --</option>
              <option value="Monofocal">Monofocal</option>
              <option value="Bifocal">Bifocal</option>
              <option value="Progresivo">Progresivo</option>
              <option value="Antirreflejo">Antirreflejo</option>
              <option value="Fotocromático">Fotocromático</option>
              <option value="Polarizado">Polarizado</option>
            </select>
          </div>

          <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary btn-block" style="font-size: 1.1rem; padding: 12px;">
              <i class="fa fa-save"></i> Guardar registro
            </button>
          </div>

          <p style="text-align: center; color: #666; margin-top: 20px;">
            ¿Ya tienes cuenta? <a href="login.php" style="color: #1a759f; font-weight: bold;">Inicia sesión aquí</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="footer" style="background-color: #1a759f; color: white; padding: 30px 0; margin-top: 50px;">
  <div class="text-center">
    <p>City Óptica © 2026 | Todos los derechos reservados</p>
  </div>
</footer>

<script>
function validarFormulario(){
  var nombre = document.getElementById("nombre").value.trim();
  var documento = document.getElementById("documento").value.trim();
  var telefono = document.getElementById("telefono").value.trim();
  var email = document.getElementById("email").value.trim();
  var tipoLente = document.getElementById("tipoLente").value;

  if(nombre == "" || documento == "" || telefono == "" || email == "" || tipoLente == ""){
    alert("Por favor completa todos los campos requeridos");
    return false;
  }

  if(email.indexOf("@") == -1){
    alert("Por favor ingresa un email válido");
    return false;
  }

  return true;
}
</script>
</body>
</html>
