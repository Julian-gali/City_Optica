<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

$idProducto = isset($_GET["id"]) ? $_GET["id"] : 0;
$producto = null;

if($idProducto > 0){
  $resultado = $objLogica->detalleProducto($idProducto);
  if($resultado){
    $producto = $resultado[0];
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $producto ? $producto['nombre'] : "Producto"; ?> - City Óptica</title>
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
<div class="container seccion" style="padding: 60px 0;">
  <?php if($producto): ?>
    <div class="row" style="gap: 0;">
      <div style="flex: 0 0 45%; max-width: 45%;">
        <div style="display: flex; align-items: center; justify-content: center; aspect-ratio: 1 / 1; min-height: 550px;">
          <img src="img/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" style="width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.1));">
        </div>
      </div>
      
      <div style="flex: 0 0 55%; max-width: 55%; padding-left: 50px;">
        <!-- CÓDIGO Y DISPONIBILIDAD (ARRIBA) -->
        <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
          <span style="background: #f0f7ff; color: #1a759f; padding: 6px 14px; border-radius: 5px; font-size: 0.85rem; font-weight: 600;">
            <i class="fa fa-barcode"></i> PRD-<?php echo $producto['idProducto']; ?>
          </span>
          <span style="background: #e8f5e9; color: #28a745; padding: 6px 14px; border-radius: 5px; font-size: 0.85rem; font-weight: 600;">
            <i class="fa fa-check-circle"></i> En stock
          </span>
        </div>

        <!-- TÍTULO -->
        <h1 style="color: #1a759f; font-weight: 700; font-size: 2.8rem; margin: 10px 0 25px 0; line-height: 1.15;">
          <?php echo $producto['nombre']; ?>
        </h1>

        <!-- PRECIO -->
        <div style="margin-bottom: 35px;">
          <p style="color: #999; font-size: 0.9rem; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Precio especial</p>
          <h2 style="color: #1a759f; font-size: 3.5rem; font-weight: 700; margin: 0; line-height: 1;">
            $<?php echo number_format($producto['precio'], 2); ?>
          </h2>
        </div>

        <!-- DESCRIPCIÓN -->
        <p style="color: #666; font-size: 1rem; line-height: 1.7; margin-bottom: 35px;">
          <?php echo $producto['descripcion']; ?>
        </p>

        <!-- INFORMACIÓN DE CALIDAD -->
        <div style="background: linear-gradient(135deg, #e8f4f8 0%, #f0f8fb 100%); padding: 18px 20px; border-radius: 8px; border-left: 4px solid #1a759f; margin-bottom: 35px;">
          <p style="margin: 0; color: #0b5563; font-size: 0.95rem; line-height: 1.5;">
            <i class="fa fa-shield" style="color: #1a759f; margin-right: 10px; font-weight: 600;"></i>
            <strong>Garantía de calidad:</strong> Este producto incluye garantía de 1 año en lentes y monturas.
          </p>
        </div>

        <!-- SELECTOR DE CANTIDAD -->
        <div style="margin-bottom: 30px; padding: 30px 0; border-bottom: 1px solid #f0f0f0; border-top: 1px solid #f0f0f0;">
          <label style="display: block; font-weight: 600; color: #333; margin-bottom: 15px; font-size: 1rem;">
            <i class="fa fa-cube" style="color: #1a759f;"></i> Cantidad
          </label>
          <div style="display: flex; align-items: center; gap: 12px;">
            <button class="btn btn-outline-secondary" onclick="restarCantidad()" style="width: 48px; height: 48px; padding: 0; font-size: 1.3rem; border-radius: 6px; border-width: 2px;">−</button>
            <input type="number" id="cantidad" value="1" min="1" class="form-control" style="width: 90px; text-align: center; height: 48px; font-weight: 600; font-size: 1.2rem; border-radius: 6px; border-width: 2px;">
            <button class="btn btn-outline-secondary" onclick="sumarCantidad()" style="width: 48px; height: 48px; padding: 0; font-size: 1.3rem; border-radius: 6px; border-width: 2px;">+</button>
          </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 15px;">
          <button class="btn btn-primary btn-lg" onclick="agregarAlCarrito(<?php echo $producto['idProducto']; ?>, '<?php echo $producto['nombre']; ?>')" style="border-radius: 8px; font-weight: 600; font-size: 1.1rem; padding: 16px 24px; height: auto; min-height: 50px;">
            <i class="fa fa-shopping-cart"></i> Agregar al carrito
          </button>
          <a href="catalogo.php" class="btn btn-outline-primary btn-lg" style="border-radius: 8px; font-weight: 600; font-size: 1.1rem; padding: 16px 24px; border: 2px solid #1a759f; height: auto; min-height: 50px; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-arrow-left"></i> Volver
          </a>
        </div>
      </div>
    </div>

    <!-- PRODUCTOS RELACIONADOS -->
    <div style="margin-top: 100px; padding-top: 50px; border-top: 2px solid #f0f0f0;">
      <h3 style="color: #1a759f; font-weight: 700; margin-bottom: 40px; font-size: 1.8rem;">
        <i class="fa fa-link" style="color: #1a759f; margin-right: 8px;"></i> Productos relacionados
      </h3>
      <div class="row">
        <?php 
          $productosRelacionados = $objLogica->listarProductosXCategoria($producto['idCategoria']);
          if($productosRelacionados){
            $cont = 0;
            foreach($productosRelacionados as $prod):
              if($prod['idProducto'] != $producto['idProducto'] && $cont < 3):
        ?>
        <div class="col-md-4 mb-4">
          <div class="card" style="border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.08); border-radius: 10px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; height: 100%;">
            <div style="height: 240px; overflow: hidden; background: #f0f0f0;">
              <img src="img/<?php echo $prod['imagen']; ?>" class="card-img-top" alt="<?php echo $prod['nombre']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="card-body" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <h5 class="card-title" style="color: #1a759f; font-weight: 600; margin-bottom: 10px;">
                  <?php echo substr($prod['nombre'], 0, 30) . "..."; ?>
                </h5>
              </div>
              <div>
                <p style="font-size: 1.4rem; color: #1a759f; font-weight: 700; margin-bottom: 15px;">
                  $<?php echo number_format($prod['precio'], 2); ?>
                </p>
                <a href="detalle.php?id=<?php echo $prod['idProducto']; ?>" class="btn btn-primary btn-sm btn-block" style="border-radius: 6px; font-weight: 600;">
                  <i class="fa fa-eye"></i> Ver detalle
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php 
                $cont++;
              endif;
            endforeach;
          }
        ?>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-warning text-center">
      <i class="fa fa-exclamation-triangle"></i> Producto no encontrado
    </div>
    <div class="text-center">
      <a href="catalogo.php" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Volver al catálogo
      </a>
    </div>
  <?php endif; ?>
</div>

<!-- FOOTER -->
<footer class="footer" style="background-color: #1a759f; color: white; padding: 30px 0; margin-top: 50px;">
  <div class="text-center">
    <p>City Óptica © 2026 | Todos los derechos reservados</p>
  </div>
</footer>

<script src="logica.js"></script>
<script>
function sumarCantidad(){
  var cantidad = document.getElementById("cantidad");
  cantidad.value = parseInt(cantidad.value) + 1;
}

function restarCantidad(){
  var cantidad = document.getElementById("cantidad");
  if(parseInt(cantidad.value) > 1){
    cantidad.value = parseInt(cantidad.value) - 1;
  }
}

function agregarAlCarrito(idProducto, nombre){
  var cantidad = document.getElementById("cantidad").value;
  var fd = new FormData();
  fd.append('accion', 'agregar');
  fd.append('idProducto', idProducto);
  fd.append('cantidad', cantidad);
  fetch('carrito_ajax.php', { method: 'POST', body: fd })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if(data.status == 'ok'){
        mostrarNotificacionCarrito(data.message);
        document.getElementById("cantidad").value = 1;
      } else {
        mostrarNotificacion(data.message, 'error');
      }
    })
    .catch(function(){ mostrarNotificacion('Error al conectar con el servidor', 'error'); });
}
</script>
</body>
</html>
