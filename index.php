<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

// Obtener categorías para el menú
$categorias = $objLogica->listarCategorias();
?>
<!DOCTYPE html>
<html>
<head>
<title>City Óptica - Monturas modernas, lentes de calidad y atención personalizada</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="estilos.css?v=2">
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

<!-- CARRUSEL BANNER PRINCIPAL -->
<div id="carrusel-principal" class="carousel slide" data-ride="carousel" data-interval="5000">
  <!-- Indicadores -->
  <ol class="carousel-indicators">
    <li data-target="#carrusel-principal" data-slide-to="0" class="active"></li>
    <li data-target="#carrusel-principal" data-slide-to="1"></li>
    <li data-target="#carrusel-principal" data-slide-to="2"></li>
  </ol>

  <!-- Imágenes del carrusel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner_1.png" class="d-block w-100" alt="Banner 1" style="height: 650px; object-fit: cover;">
      <div class="carousel-overlay"></div>
      <div class="carousel-caption d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
          <h1 class="titulo-principal" style="font-size: 3.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            Cuida tu mirada, mejora tu estilo
          </h1>
          <p class="subtitulo-principal" style="font-size: 1.3rem; margin-top: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Monturas modernas, lentes de calidad y atención personalizada
          </p>
          <div style="margin-top: 30px;">
            <a href="catalogo.php" class="btn btn-light btn-lg" style="margin-right: 10px;">
              <i class="fa fa-shopping-bag"></i> Ver Catálogo
            </a>
            <a href="registro.php" class="btn btn-outline-light btn-lg">
              <i class="fa fa-user-plus"></i> Registrarse
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="carousel-item">
      <img src="img/banner_2.png" class="d-block w-100" alt="Banner 2" style="height: 650px; object-fit: cover;">
      <div class="carousel-overlay"></div>
      <div class="carousel-caption d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
          <h1 class="titulo-principal" style="font-size: 3.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            Cuida tu mirada, mejora tu estilo
          </h1>
          <p class="subtitulo-principal" style="font-size: 1.3rem; margin-top: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Monturas modernas, lentes de calidad y atención personalizada
          </p>
          <div style="margin-top: 30px;">
            <a href="catalogo.php" class="btn btn-light btn-lg" style="margin-right: 10px;">
              <i class="fa fa-shopping-bag"></i> Ver Catálogo
            </a>
            <a href="registro.php" class="btn btn-outline-light btn-lg">
              <i class="fa fa-user-plus"></i> Registrarse
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="carousel-item">
      <img src="img/banner_3.png" class="d-block w-100" alt="Banner 3" style="height: 650px; object-fit: cover;">
      <div class="carousel-overlay"></div>
      <div class="carousel-caption d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
          <h1 class="titulo-principal" style="font-size: 3.5rem; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            Cuida tu mirada, mejora tu estilo
          </h1>
          <p class="subtitulo-principal" style="font-size: 1.3rem; margin-top: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Monturas modernas, lentes de calidad y atención personalizada
          </p>
          <div style="margin-top: 30px;">
            <a href="catalogo.php" class="btn btn-light btn-lg" style="margin-right: 10px;">
              <i class="fa fa-shopping-bag"></i> Ver Catálogo
            </a>
            <a href="registro.php" class="btn btn-outline-light btn-lg">
              <i class="fa fa-user-plus"></i> Registrarse
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Controles de navegación -->
  <a class="carousel-control-prev" href="#carrusel-principal" data-target="#carrusel-principal" role="button" data-slide="prev" aria-label="Anterior">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Anterior</span>
  </a>
  <a class="carousel-control-next" href="#carrusel-principal" data-target="#carrusel-principal" role="button" data-slide="next" aria-label="Siguiente">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>

<!-- SERVICIOS PRINCIPALES -->
<div class="container seccion">
  <h3 class="titulo-seccion text-center" style="margin: 50px 0; font-size: 2.5rem; color: #1a759f;">
    Nuestros Servicios
  </h3>
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fa fa-eye" style="font-size:50px; color:#1a759f; margin-bottom: 15px;"></i>
        <h5 class="mt-3" style="font-weight: bold;">Examen visual</h5>
        <p style="color: #555;">Evaluación profesional para detectar y corregir problemas de visión con equipos de última tecnología.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fa fa-shopping-bag" style="font-size:50px; color:#1a759f; margin-bottom: 15px;"></i>
        <h5 class="mt-3" style="font-weight: bold;">Monturas y lentes</h5>
        <p style="color: #555;">Amplia variedad de estilos para niños, jóvenes y adultos con excelente calidad y diseño.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s;">
        <i class="fa fa-user-md" style="font-size:50px; color:#1a759f; margin-bottom: 15px;"></i>
        <h5 class="mt-3" style="font-weight: bold;">Asesoría especializada</h5>
        <p style="color: #555;">Te ayudamos a elegir la mejor opción según tu fórmula, presupuesto y estilo de vida.</p>
      </div>
    </div>
  </div>
</div>

<!-- PRODUCTOS DESTACADOS -->
<div style="background-color: #f8f9fa; padding: 50px 0; margin-top: 50px;">
  <div class="container">
    <h3 class="titulo-seccion text-center" style="margin-bottom: 40px; font-size: 2.5rem; color: #1a759f;">
      Productos Destacados
    </h3>
    <div class="row">
      <?php 
        $productos = $objLogica->listarProductos();
        if($productos){
          $cont = 0;
          foreach($productos as $producto){
            if($cont < 6){
      ?>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; transition: transform 0.3s;">
          <img src="img/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo $producto['nombre']; ?>" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title" style="color: #1a759f; font-weight: bold;"><?php echo $producto['nombre']; ?></h5>
            <p class="card-text" style="color: #666; font-size: 0.9rem;"><?php echo substr($producto['descripcion'], 0, 60) . "..."; ?></p>
            <p style="font-size: 1.3rem; color: #1a759f; font-weight: bold;">$<?php echo number_format($producto['precio'], 2); ?></p>
            <a href="detalle.php?id=<?php echo $producto['idProducto']; ?>" class="btn btn-primary btn-sm btn-block">
              <i class="fa fa-eye"></i> Ver detalle
            </a>
          </div>
        </div>
      </div>
      <?php
              $cont++;
            }
          }
        }
      ?>
    </div>
    <div class="text-center mt-4">
      <a href="catalogo.php" class="btn btn-primary btn-lg">
        <i class="fa fa-shopping-bag"></i> Ver todo el catálogo
      </a>
    </div>
  </div>
</div>

<!-- TESTIMONIOS -->
<div class="container seccion">
  <h3 class="titulo-seccion text-center" style="margin: 50px 0; font-size: 2.5rem; color: #1a759f;">
    Lo que dicen nuestros clientes
  </h3>
  <div class="row">
    <div class="col-md-4 mb-3">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <p style="color: #ffc107; margin-bottom: 10px;">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </p>
        <p style="color: #555;">"Excelente atención y monturas de muy buena calidad. Recomendado."</p>
        <p style="color: #1a759f; font-weight: bold;">- Juan Pérez</p>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <p style="color: #ffc107; margin-bottom: 10px;">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </p>
        <p style="color: #555;">"Muy buena variedad de estilos y precios competitivos."</p>
        <p style="color: #1a759f; font-weight: bold;">- María García</p>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="tarjeta-info text-center" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <p style="color: #ffc107; margin-bottom: 10px;">
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
          <i class="fa fa-star"></i>
        </p>
        <p style="color: #555;">"El examen visual fue muy detallado. Profesionales altamente capacitados."</p>
        <p style="color: #1a759f; font-weight: bold;">- Carlos López</p>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="footer" style="background-color: #1a759f; color: white; padding: 30px 0; margin-top: 50px;">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h5 style="font-weight: bold; margin-bottom: 15px;">
          <i class="fa fa-eye"></i> City Óptica
        </h5>
        <p>Monturas modernas, lentes de calidad y atención personalizada para toda la familia.</p>
      </div>
      <div class="col-md-4 mb-3">
        <h5 style="font-weight: bold; margin-bottom: 15px;">Enlaces rápidos</h5>
        <ul style="list-style: none; padding: 0;">
          <li><a href="index.php" style="color: #fff; text-decoration: none;">Inicio</a></li>
          <li><a href="catalogo.php" style="color: #fff; text-decoration: none;">Catálogo</a></li>
          <li><a href="registro.php" style="color: #fff; text-decoration: none;">Registro</a></li>
          <li><a href="login.php" style="color: #fff; text-decoration: none;">Acceso</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h5 style="font-weight: bold; margin-bottom: 15px;">Contacto</h5>
        <p><i class="fa fa-phone"></i> +57 (1) 123-4567</p>
        <p><i class="fa fa-envelope"></i> info@cityoptica.com</p>
        <p><i class="fa fa-map-marker"></i> Cra. 7 #45-89, Bogotá</p>
      </div>
    </div>
    <hr style="border-color: rgba(255,255,255,0.3);">
    <div class="text-center">
      <p style="margin: 0;">City Óptica © 2026 | Todos los derechos reservados</p>
    </div>
  </div>
</footer>

<script src="logica.js?v=2"></script>
</body>
</html>
