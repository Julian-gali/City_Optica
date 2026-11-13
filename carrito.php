<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
$totalCarrito = 0;
foreach($carrito as $item){
    $totalCarrito += $item['precio'] * $item['cantidad'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Carrito - City Óptica</title>
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
<div class="container seccion" style="padding: 50px 0; min-height: 500px;">
  <div class="row">
    <div class="col-md-8">
      <h2 style="color: #1a759f; margin-bottom: 30px; font-weight: bold;">
        <i class="fa fa-shopping-cart"></i> Mi Carrito
      </h2>

      <?php if(count($carrito) == 0): ?>
      <div style="text-align: center; padding: 50px;">
        <i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
        <p style="font-size: 1.2rem; color: #999;">Tu carrito está vacío</p>
        <a href="catalogo.php" class="btn btn-primary" style="margin-top: 20px;">
          <i class="fa fa-shopping-bag"></i> Seguir comprando
        </a>
      </div>
      <?php else: ?>
      <table class="table table-hover">
        <thead style="background-color: #1a759f; color: white;">
          <tr>
            <th>Producto</th>
            <th style="text-align: center;">Precio</th>
            <th style="text-align: center;">Cantidad</th>
            <th style="text-align: center;">Subtotal</th>
            <th style="text-align: center;">Acciones</th>
          </tr>
        </thead>
        <tbody id="bodyCarrito">
          <?php foreach($carrito as $item):
            $subtotalItem = $item['precio'] * $item['cantidad'];
          ?>
          <tr id="fila-<?php echo $item['id']; ?>">
            <td><?php echo $item['nombre']; ?></td>
            <td style="text-align: center;">$<?php echo number_format($item['precio'], 2); ?></td>
            <td style="text-align: center;">
              <input type="number" value="<?php echo $item['cantidad']; ?>" min="1"
                class="form-control" style="width: 70px; text-align: center; display: inline;"
                onchange="actualizarCantidad(<?php echo $item['id']; ?>, this.value, this)">
            </td>
            <td style="text-align: center;" id="subtotal-<?php echo $item['id']; ?>">
              $<?php echo number_format($subtotalItem, 2); ?>
            </td>
            <td style="text-align: center;">
              <button class="btn btn-danger btn-sm" onclick="eliminarItem(<?php echo $item['id']; ?>)">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>

    <div class="col-md-4">
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h4 style="color: #1a759f; margin-bottom: 20px; font-weight: bold;">
          <i class="fa fa-receipt"></i> Resumen del carrito
        </h4>

        <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span>Subtotal:</span>
            <span id="subtotal" style="font-weight: bold;">$<?php echo number_format($totalCarrito, 2); ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span>Total:</span>
            <span id="total" style="font-size: 1.3rem; font-weight: bold; color: #1a759f;">$<?php echo number_format($totalCarrito, 2); ?></span>
          </div>
        </div>

        <button class="btn btn-success btn-block btn-lg" id="btnPedido"
          style="margin-bottom: 10px;" <?php echo count($carrito) == 0 ? 'disabled' : ''; ?>>
          <i class="fa fa-check"></i> Realizar pedido
        </button>
        <a href="catalogo.php" class="btn btn-outline-primary btn-block">
          <i class="fa fa-arrow-left"></i> Seguir comprando
        </a>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA CONFIRMAR PEDIDO -->
<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Confirmar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="procesar_pedido.php">
        <div class="modal-body">
          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-user"></i> Nombre *
            </label>
            <input type="text" name="nombre" class="form-control" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-id-card"></i> Documento *
            </label>
            <input type="text" name="documento" class="form-control" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-phone"></i> Teléfono *
            </label>
            <input type="text" name="telefono" class="form-control" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-envelope"></i> Email *
            </label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;">
              <i class="fa fa-eye"></i> Tipo de Lente *
            </label>
            <select name="tipoLente" class="form-control" required style="height: 50px; padding: 12px; font-size: 1rem;">
              <option value="">Selecciona tipo de lente</option>
              <option value="Monofocal">Monofocal</option>
              <option value="Bifocal">Bifocal</option>
              <option value="Progresivo">Progresivo</option>
            </select>
          </div>

          <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <div style="display: flex; justify-content: space-between;">
              <span>Total a pagar:</span>
              <span style="font-size: 1.2rem; font-weight: bold; color: #1a759f;">
                $<?php echo number_format($totalCarrito, 2); ?>
              </span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-check"></i> Confirmar pedido
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- FOOTER -->
<div style="background-color: #1a759f; color: white; padding: 30px; margin-top: 50px; text-align: center;">
  <p style="margin: 0;">© 2026 City Óptica. Todos los derechos reservados.</p>
</div>

<script src="logica.js"></script>
<script>
function eliminarItem(idProducto) {
  var fd = new FormData();
  fd.append('accion', 'eliminar');
  fd.append('idProducto', idProducto);
  fetch('carrito_ajax.php', { method: 'POST', body: fd })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if(data.status == 'ok'){
        var fila = document.getElementById('fila-' + idProducto);
        if(fila) fila.remove();
        recalcularTotal();
        if(data.total_items == 0) location.reload();
      }
    });
}

function actualizarCantidad(idProducto, cantidad, inputEl) {
  var fd = new FormData();
  fd.append('accion', 'actualizar');
  fd.append('idProducto', idProducto);
  fd.append('cantidad', cantidad);
  fetch('carrito_ajax.php', { method: 'POST', body: fd })
    .then(function(r){ return r.json(); })
    .then(function(data){
      if(data.status == 'ok'){
        var celdaSubtotal = document.getElementById('subtotal-' + idProducto);
        if(celdaSubtotal){
          celdaSubtotal.textContent = '$' + parseFloat(data.subtotal).toFixed(2);
        }
        document.getElementById('subtotal').textContent = '$' + parseFloat(data.total).toFixed(2);
        document.getElementById('total').textContent = '$' + parseFloat(data.total).toFixed(2);
      }
    });
}

function recalcularTotal() {
  var filas = document.querySelectorAll('#bodyCarrito tr');
  var total = 0;
  filas.forEach(function(fila){
    var celda = fila.querySelector('td:nth-child(4)');
    if(celda){
      total += parseFloat(celda.textContent.replace('$','').replace(',','')) || 0;
    }
  });
  document.getElementById('subtotal').textContent = '$' + total.toFixed(2);
  document.getElementById('total').textContent = '$' + total.toFixed(2);
}

document.getElementById('btnPedido').addEventListener('click', function() {
  $('#modalPedido').modal('show');
});
</script>
</body>
</html>
