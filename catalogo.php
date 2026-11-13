<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();


// Obtener categorías
$categorias = $objLogica->listarCategorias();

// Obtener productos
$idCategoria = isset($_GET["categoria"]) ? $_GET["categoria"] : 0;
if ($idCategoria > 0) {
  $productos = $objLogica->listarProductosXCategoria($idCategoria);
} else {
  $productos = $objLogica->listarProductos();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Catálogo - City Óptica</title>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
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
              <?php if (isset($_SESSION["Login"]) && $_SESSION["Login"] != "") {
                echo "Panel";
              } else {
                echo "Acceso";
              } ?>
            </a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="container seccion" style="padding: 50px 0;">
    <div class="row">
      <div class="col-md-3">
        <!-- FILTRO DE CATEGORÍAS -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
          <h5 style="font-weight: bold; color: #1a759f; margin-bottom: 20px;">
            <i class="fa fa-filter"></i> Categorías
          </h5>
          <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;">
              <a href="catalogo.php" style="text-decoration: none; color: #1a759f;">
                <i class="fa fa-list"></i> Todos los productos
              </a>
            </li>
            <?php if ($categorias):
              foreach ($categorias as $cat):
                ?>
                <li style="margin-bottom: 10px;">
                  <a href="catalogo.php?categoria=<?php echo $cat['idCategoria']; ?>"
                    style="text-decoration: none; color: <?php echo ($idCategoria == $cat['idCategoria'] ? '#1a759f' : '#666'); ?>; font-weight: <?php echo ($idCategoria == $cat['idCategoria'] ? 'bold' : 'normal'); ?>;">
                    <i class="fa fa-shopping-bag"></i> <?php echo $cat['nombre']; ?>
                  </a>
                </li>
              <?php
              endforeach;
            endif;
            ?>
          </ul>
        </div>

        <!-- FILTRO DE PRECIOS -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
          <h5 style="font-weight: bold; color: #1a759f; margin-bottom: 20px;">
            <i class="fa fa-dollar"></i> Rango de precios
          </h5>
          <div style="font-size: 0.9rem; color: #666;">
            <label>Min: <input type="number" id="minPrecio" class="form-control" placeholder="0"
                style="margin-bottom: 10px;"></label>
            <label>Max: <input type="number" id="maxPrecio" class="form-control" placeholder="1000000"
                style="margin-bottom: 10px;"></label>
            <button class="btn btn-primary btn-block" onclick="filtrarPorPrecio()">
              <i class="fa fa-filter"></i> Filtrar
            </button>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <h3 class="titulo-seccion" style="color: #1a759f; margin-bottom: 30px; font-size: 2rem;">
          <i class="fa fa-shopping-bag"></i> Catálogo de productos
        </h3>

        <?php if (isset($_SESSION["mensaje_carrito"])): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle"></i> <?php echo $_SESSION["mensaje_carrito"]; ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
          </div>
          <?php unset($_SESSION["mensaje_carrito"]); endif; ?>

        <div class="row" id="contenedorProductos">
          <?php
          if ($productos) {
            foreach ($productos as $producto):
              ?>
              <div class="col-md-6 col-lg-4 mb-4 producto-item" data-precio="<?php echo $producto['precio']; ?>">
                <div class="card"
                  style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; height: 100%; transition: transform 0.3s, box-shadow 0.3s;">
                  <div style="height: 250px; overflow: hidden; background-color: #f0f0f0;">
                    <img src="img/<?php echo $producto['imagen']; ?>" class="card-img-top"
                      alt="<?php echo $producto['nombre']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
                  <div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                      <h5 class="card-title" style="color: #1a759f; font-weight: bold; margin-bottom: 10px;">
                        <?php echo $producto['nombre']; ?>
                      </h5>
                      <p style="color: #666; font-size: 0.85rem; margin-bottom: 10px;">
                        <?php echo substr($producto['descripcion'], 0, 80) . "..."; ?>
                      </p>
                    </div>
                    <div>
                      <p style="font-size: 1.4rem; color: #1a759f; font-weight: bold; margin-bottom: 15px;">
                        $<?php echo number_format($producto['precio'], 2); ?>
                      </p>
                      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="detalle.php?id=<?php echo $producto['idProducto']; ?>"
                          class="btn btn-outline-primary btn-sm">
                          <i class="fa fa-eye"></i> Ver
                        </a>
                        <button class="btn btn-primary btn-sm"
                          onclick="agregarAlCarrito(<?php echo $producto['idProducto']; ?>, '<?php echo $producto['nombre']; ?>')">
                          <i class="fa fa-shopping-cart"></i> Carrito
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            endforeach;
          } else {
            ?>
            <div class="col-12">
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> No hay productos disponibles en esta categoría
              </div>
            </div>
          <?php } ?>
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

  <script src="logica.js"></script>
  <script>
    function agregarAlCarrito(idProducto, nombre) {
      var fd = new FormData();
      fd.append('accion', 'agregar');
      fd.append('idProducto', idProducto);
      fetch('carrito_ajax.php', { method: 'POST', body: fd })
        .then(function(r){ return r.json(); })
        .then(function(data){
          if(data.status == 'ok') mostrarNotificacionCarrito(data.message);
          else mostrarNotificacion(data.message, 'error');
        })
        .catch(function(){ mostrarNotificacion('Error al conectar con el servidor', 'error'); });
    }

    function filtrarPorPrecio() {
      var minPrecio = parseFloat(document.getElementById("minPrecio").value) || 0;
      var maxPrecio = parseFloat(document.getElementById("maxPrecio").value) || 999999999;

      var productos = document.querySelectorAll(".producto-item");
      var productosVisibles = 0;

      productos.forEach(function (producto) {
        var precio = parseFloat(producto.getAttribute("data-precio"));
        if (precio >= minPrecio && precio <= maxPrecio) {
          producto.style.display = "block";
          productosVisibles++;
        } else {
          producto.style.display = "none";
        }
      });

      if (productosVisibles === 0) {
        var contenedor = document.getElementById("contenedorProductos");
        if (!document.getElementById("mensajeSinResultados")) {
          var mensajeDiv = document.createElement("div");
          mensajeDiv.id = "mensajeSinResultados";
          mensajeDiv.className = "alert alert-info text-center";
          mensajeDiv.innerHTML = '<i class="fa fa-info-circle"></i> No hay productos en ese rango de precios';
          contenedor.parentElement.insertBefore(mensajeDiv, contenedor);
        }
      } else {
        var mensajeDiv = document.getElementById("mensajeSinResultados");
        if (mensajeDiv) {
          mensajeDiv.remove();
        }
      }
    }

    // Limpiar filtro al cambiar categoría
    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("minPrecio").value = "";
      document.getElementById("maxPrecio").value = "";
    });
  </script>
</body>

</html>