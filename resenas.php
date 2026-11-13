<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();
$productos = $objLogica->listarProductos();
?>
<!DOCTYPE html>
<html>
<head>
<title>Reseñas - City Óptica</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="estilos.css">
<style>
.estrella { font-size: 1.6rem; cursor: pointer; color: #ccc; transition: color 0.2s; }
.estrella.activa, .estrella:hover { color: #ffc107; }
.tarjeta-resena {
  background: white;
  border-radius: 8px;
  padding: 15px 20px;
  margin-bottom: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  border-left: 4px solid #1a759f;
}
.estrellas-display { color: #ffc107; font-size: 1rem; }
</style>
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
        <li class="nav-item"><a class="nav-link enlace-menu active" href="resenas.php">Reseñas</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="registro.php">Registro</a></li>
        <li class="nav-item"><a class="nav-link enlace-menu" href="login.php">
          <?php if(isset($_SESSION["Login"]) && $_SESSION["Login"] != ""){ echo "Panel"; } else { echo "Acceso"; } ?>
        </a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ENCABEZADO -->
<div style="background: linear-gradient(135deg, #1a759f 0%, #0b4f6c 100%); color: white; padding: 50px 0; text-align: center;">
  <div class="container">
    <h2 style="font-weight: bold; font-size: 2.5rem;">
      <i class="fa fa-star"></i> Reseñas de Productos
    </h2>
    <p style="font-size: 1.1rem; opacity: 0.85; margin: 0;">
      Compartí tu experiencia y ayudá a otros clientes
    </p>
  </div>
</div>

<!-- CONTENIDO -->
<div class="container" style="padding: 50px 0;">
  <div class="row">

    <!-- FORMULARIO IZQUIERDA -->
    <div class="col-md-5 mb-4">
      <div class="formulario-box" style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h4 style="color: #1a759f; font-weight: bold; margin-bottom: 25px;">
          <i class="fa fa-edit"></i> Dejá tu reseña
        </h4>

        <div id="alertaExito" class="alert alert-success" style="display:none;">
          <i class="fa fa-check-circle"></i> ¡Gracias! Tu reseña fue enviada correctamente.
        </div>
        <div id="alertaError" class="alert alert-danger" style="display:none;"></div>

        <div class="form-group">
          <label style="font-weight: bold; color: #1a759f;">
            <i class="fa fa-shopping-bag"></i> Producto *
          </label>
          <select id="selectProducto" class="form-control" style="height: 50px; font-size: 1rem;"
            onchange="cargarResenas(this.value)">
            <option value="">Seleccioná un producto</option>
            <?php if($productos): foreach($productos as $p): ?>
            <option value="<?php echo $p['idProducto']; ?>">
              <?php echo $p['nombre']; ?>
            </option>
            <?php endforeach; endif; ?>
          </select>
        </div>

        <div class="form-group">
          <label style="font-weight: bold; color: #1a759f;">
            <i class="fa fa-user"></i> Tu nombre *
          </label>
          <input type="text" id="inputNombre" class="form-control" placeholder="Ej: Juan Pérez">
        </div>

        <div class="form-group">
          <label style="font-weight: bold; color: #1a759f;">
            <i class="fa fa-star"></i> Calificación *
          </label>
          <div id="estrellas" style="margin-bottom: 5px;">
            <span class="estrella" data-valor="1" onclick="seleccionarEstrella(1)">&#9733;</span>
            <span class="estrella" data-valor="2" onclick="seleccionarEstrella(2)">&#9733;</span>
            <span class="estrella" data-valor="3" onclick="seleccionarEstrella(3)">&#9733;</span>
            <span class="estrella" data-valor="4" onclick="seleccionarEstrella(4)">&#9733;</span>
            <span class="estrella" data-valor="5" onclick="seleccionarEstrella(5)">&#9733;</span>
          </div>
          <small class="text-muted" id="labelEstrella">Sin calificación</small>
          <input type="hidden" id="puntajeSeleccionado" value="0">
        </div>

        <div class="form-group">
          <label style="font-weight: bold; color: #1a759f;">
            <i class="fa fa-comment"></i> Comentario *
          </label>
          <textarea id="inputComentario" class="form-control" rows="4"
            placeholder="Contanos tu experiencia con el producto..."></textarea>
        </div>

        <button class="btn btn-primary btn-block btn-lg" onclick="enviarResena()"
          style="background-color: #1a759f; border-color: #1a759f;">
          <i class="fa fa-paper-plane"></i> Enviar reseña
        </button>
      </div>
    </div>

    <!-- RESEÑAS DERECHA -->
    <div class="col-md-7">
      <div id="panelResenas" style="display:none;">
        <h4 style="color: #1a759f; font-weight: bold; margin-bottom: 20px;">
          <i class="fa fa-comments"></i> Reseñas de <span id="nombreProductoSeleccionado"></span>
        </h4>

        <!-- PROMEDIO -->
        <div id="promedioBox" style="background: #f0f7ff; padding: 20px; border-radius: 8px; margin-bottom: 25px; text-align: center; border: 2px solid #1a759f;">
          <span id="promedioNumero" style="font-size: 3rem; font-weight: bold; color: #1a759f;"></span>
          <div id="promedioEstrellas" style="font-size: 1.5rem; color: #ffc107; margin: 5px 0;"></div>
          <small class="text-muted" id="promedioTotal"></small>
        </div>

        <!-- LISTA DE COMENTARIOS -->
        <div id="listaComentarios"></div>

        <div id="sinResenas" class="text-center text-muted py-4" style="display:none;">
          <i class="fa fa-comment-o" style="font-size: 2rem;"></i>
          <p style="margin-top: 10px;">Este producto aún no tiene reseñas. ¡Sé el primero!</p>
        </div>
      </div>

      <div id="mensajeInicial" class="text-center text-muted" style="padding: 80px 0;">
        <i class="fa fa-hand-o-left" style="font-size: 2.5rem; color: #ccc;"></i>
        <p style="margin-top: 15px; font-size: 1.1rem;">Seleccioná un producto para ver sus reseñas</p>
      </div>
    </div>

  </div>
</div>

<!-- FOOTER -->
<footer style="background-color: #1a759f; color: white; padding: 30px 0; margin-top: 50px; text-align: center;">
  <p style="margin: 0;">City Óptica © 2026 | Todos los derechos reservados</p>
</footer>

<script>
var puntaje = 0;
var API_BASE = window.location.origin + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')) + '/Proyecto-api/';
var etiquetas = ['', 'Muy malo', 'Malo', 'Regular', 'Bueno', 'Excelente'];

function seleccionarEstrella(valor) {
  puntaje = valor;
  document.getElementById('puntajeSeleccionado').value = valor;
  document.getElementById('labelEstrella').textContent = etiquetas[valor];
  var estrellas = document.querySelectorAll('.estrella');
  estrellas.forEach(function(e) {
    e.classList.toggle('activa', parseInt(e.getAttribute('data-valor')) <= valor);
  });
}

function cargarResenas(idProducto) {
  var panel = document.getElementById('panelResenas');
  var inicial = document.getElementById('mensajeInicial');

  if(!idProducto) {
    panel.style.display = 'none';
    inicial.style.display = 'block';
    return;
  }

  var nombreOpt = document.getElementById('selectProducto');
  document.getElementById('nombreProductoSeleccionado').textContent =
    nombreOpt.options[nombreOpt.selectedIndex].text;

  panel.style.display = 'block';
  inicial.style.display = 'none';

  // Cargar promedio
  fetch(API_BASE + 'calificaciones.php?idProducto=' + idProducto)
    .then(function(r){ return r.json(); })
    .then(function(resp){
      if(resp.status == 'ok' && resp.data.total > 0){
        var p = parseFloat(resp.data.promedio);
        document.getElementById('promedioNumero').textContent = p.toFixed(1);
        document.getElementById('promedioEstrellas').innerHTML = generarEstrellas(p);
        document.getElementById('promedioTotal').textContent =
          resp.data.total + ' calificacion' + (resp.data.total != 1 ? 'es' : '');
      } else {
        document.getElementById('promedioNumero').textContent = '-';
        document.getElementById('promedioEstrellas').innerHTML = '';
        document.getElementById('promedioTotal').textContent = 'Sin calificaciones aún';
      }
    });

  // Cargar comentarios
  fetch(API_BASE + 'comentarios.php?idProducto=' + idProducto)
    .then(function(r){ return r.json(); })
    .then(function(resp){
      var lista = document.getElementById('listaComentarios');
      var sinRes = document.getElementById('sinResenas');
      lista.innerHTML = '';

      if(resp.status == 'ok' && resp.data.length > 0){
        sinRes.style.display = 'none';
        resp.data.forEach(function(c){
          var fecha = new Date(c.fecha).toLocaleDateString('es-CO', {day:'2-digit',month:'short',year:'numeric'});
          lista.innerHTML += '<div class="tarjeta-resena">' +
            '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">' +
            '<strong style="color:#1a759f;"><i class="fa fa-user-circle"></i> ' + c.autor + '</strong>' +
            '<small class="text-muted"><i class="fa fa-clock-o"></i> ' + fecha + '</small>' +
            '</div>' +
            '<p style="color:#555; margin:0; line-height:1.6;">' + c.texto + '</p>' +
            '</div>';
        });
      } else {
        sinRes.style.display = 'block';
      }
    });
}

function generarEstrellas(promedio) {
  var html = '';
  for(var i = 1; i <= 5; i++){
    if(i <= Math.floor(promedio)) html += '&#9733;';
    else if(i - promedio < 1 && i - promedio > 0) html += '&#9734;';
    else html += '<span style="color:#ccc;">&#9733;</span>';
  }
  return html;
}

function enviarResena() {
  var idProducto = document.getElementById('selectProducto').value;
  var nombre     = document.getElementById('inputNombre').value.trim();
  var texto      = document.getElementById('inputComentario').value.trim();
  var puntajeVal = parseInt(document.getElementById('puntajeSeleccionado').value);

  document.getElementById('alertaExito').style.display = 'none';
  document.getElementById('alertaError').style.display = 'none';

  if(!idProducto || !nombre || !texto || puntajeVal < 1){
    document.getElementById('alertaError').style.display = 'block';
    document.getElementById('alertaError').textContent =
      'Completá todos los campos y seleccioná una calificación.';
    return;
  }

  // Enviar calificación
  var fdCal = new FormData();
  fdCal.append('idProducto', idProducto);
  fdCal.append('autor', nombre);
  fdCal.append('puntaje', puntajeVal);

  fetch(API_BASE + 'calificaciones.php', { method: 'POST', body: fdCal })
    .then(function(r){ return r.json(); })
    .then(function(respCal){
      // Enviar comentario
      var fdCom = new FormData();
      fdCom.append('idProducto', idProducto);
      fdCom.append('autor', nombre);
      fdCom.append('texto', texto);

      return fetch(API_BASE + 'comentarios.php', { method: 'POST', body: fdCom });
    })
    .then(function(r){ return r.json(); })
    .then(function(respCom){
      if(respCom.status == 'ok'){
        document.getElementById('alertaExito').style.display = 'block';
        document.getElementById('inputNombre').value = '';
        document.getElementById('inputComentario').value = '';
        seleccionarEstrella(0);
        puntaje = 0;
        document.getElementById('puntajeSeleccionado').value = 0;
        document.querySelectorAll('.estrella').forEach(function(e){ e.classList.remove('activa'); });
        document.getElementById('labelEstrella').textContent = 'Sin calificación';
        cargarResenas(idProducto);
      }
    })
    .catch(function(){
      document.getElementById('alertaError').style.display = 'block';
      document.getElementById('alertaError').textContent =
        'Error de conexión con la API. Verificá que XAMPP esté activo.';
    });
}
</script>
</body>
</html>
