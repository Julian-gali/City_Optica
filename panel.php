<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

//seguridad - verificar que el usuario esté autenticado
if( trim( $_SESSION["Login"] ) == "" )
 {
    header("Location: login.php");    
    exit();
 }

$seccion = isset($_GET["seccion"]) ? $_GET["seccion"] : "inicio";
$mensaje = "";
$tipo_mensaje = "";

// ===== PROCESAR ELIMINACIONES =====
if(isset($_POST["procesoEliminarProducto"])){
  $idProducto = $_POST["idProducto"];
  $resultado = $objLogica->eliminarProducto($idProducto);
  if($resultado){
    $mensaje = "Producto eliminado correctamente";
    $tipo_mensaje = "success";
    $seccion = "productos";
  }
}

if(isset($_POST["procesoEliminarUsuario"])){
  $idUsuario = $_POST["idUsuario"];
  $resultado = $objLogica->eliminarUsuario($idUsuario);
  if($resultado){
    $mensaje = "Usuario eliminado correctamente";
    $tipo_mensaje = "success";
    $seccion = "usuarios";
  }
}

if(isset($_POST["procesoEliminarCliente"])){
  $idCliente = $_POST["idCliente"];
  $resultado = $objLogica->eliminarCliente($idCliente);
  if($resultado){
    $mensaje = "Cliente eliminado correctamente";
    $tipo_mensaje = "success";
    $seccion = "clientes";
  }
}

// ===== PROCESAR EDICIONES =====
if(isset($_POST["procesoEditarProducto"])){
  $idProducto = $_POST["idProducto"];
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  $precio = $_POST["precio"];
  $categoria = $_POST["categoria"];
  $imagen = $_POST["imagen"];
  
  $resultado = $objLogica->actualizarProducto($idProducto, $nombre, $descripcion, $precio, $categoria, $imagen);
  if($resultado){
    $mensaje = "Producto actualizado exitosamente";
    $tipo_mensaje = "success";
    $seccion = "productos";
  }
}

if(isset($_POST["procesoEditarUsuario"])){
  $idUsuario = $_POST["idUsuario"];
  $login = $_POST["login"];
  $clave = $_POST["clave"];
  $nombre = $_POST["nombre"];
  
  $resultado = $objLogica->actualizarUsuario($idUsuario, $login, $clave, $nombre);
  if($resultado){
    $mensaje = "Usuario actualizado exitosamente";
    $tipo_mensaje = "success";
    $seccion = "usuarios";
  }
}

if(isset($_POST["procesoEditarCliente"])){
  $idCliente = $_POST["idCliente"];
  $nombre = $_POST["nombre"];
  $documento = $_POST["documento"];
  $telefono = $_POST["telefono"];
  $email = $_POST["email"];
  $tipoLente = $_POST["tipoLente"];
  
  $resultado = $objLogica->actualizarCliente($idCliente, $nombre, $documento, $telefono, $email, $tipoLente);
  if($resultado){
    $mensaje = "Cliente actualizado exitosamente";
    $tipo_mensaje = "success";
    $seccion = "clientes";
  }
}

// ===== PROCESAR CATEGORÍAS =====
if(isset($_POST["procesoCrearCategoria"])){
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  
  $resultado = $objLogica->crearCategoria($nombre, $descripcion);
  if($resultado){
    $mensaje = "Categoría creada exitosamente";
    $tipo_mensaje = "success";
    $seccion = "categorias";
    $categorias = $objLogica->listarCategorias();
  }
}

if(isset($_POST["procesoEditarCategoria"])){
  $idCategoria = $_POST["idCategoria"];
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  
  $resultado = $objLogica->actualizarCategoria($idCategoria, $nombre, $descripcion);
  if($resultado){
    $mensaje = "Categoría actualizada exitosamente";
    $tipo_mensaje = "success";
    $seccion = "categorias";
    $categorias = $objLogica->listarCategorias();
  }
}

if(isset($_POST["procesoEliminarCategoria"])){
  $idCategoria = $_POST["idCategoria"];
  $resultado = $objLogica->eliminarCategoria($idCategoria);
  if($resultado){
    $mensaje = "Categoría eliminada correctamente";
    $tipo_mensaje = "success";
    $seccion = "categorias";
    $categorias = $objLogica->listarCategorias();
  }
}

// ===== PROCESAR CREAR PRODUCTO =====
if(isset($_POST["procesoCrearProducto"])){
  $nombre = $_POST["nombre"];
  $descripcion = $_POST["descripcion"];
  $precio = $_POST["precio"];
  $categoria = $_POST["categoria"];
  $imagen = $_POST["imagen"];
  
  $resultado = $objLogica->crearProducto($nombre, $descripcion, $precio, $categoria, $imagen);
  if($resultado){
    $mensaje = "Producto creado exitosamente";
    $tipo_mensaje = "success";
  }
}

// PROCESAR CREAR USUARIO
if(isset($_POST["procesoCrearUsuario"])){
  $login = $_POST["login"];
  $clave = $_POST["clave"];
  $nombre = $_POST["nombre"];
  
  $resultado = $objLogica->crearUsuario($login, $clave, $nombre);
  if($resultado){
    $mensaje = "Usuario creado exitosamente";
    $tipo_mensaje = "success";
  }
}

// ===== ELIMINAR COMENTARIO =====
if(isset($_POST["procesoEliminarComentario"])){
  $idComentario = intval($_POST["idComentario"]);
  $objLogica->eliminarComentario($idComentario);
  $mensaje = "Comentario eliminado correctamente";
  $tipo_mensaje = "success";
  $seccion = "resenas";
}

// ===== ACTIVAR/DESACTIVAR COMENTARIO =====
if(isset($_POST["procesoToggleComentario"])){
  $idComentario = intval($_POST["idComentario"]);
  $activo = intval($_POST["activo"]);
  $objLogica->toggleEstadoComentario($idComentario, $activo);
  $mensaje = "Estado del comentario actualizado correctamente";
  $tipo_mensaje = "success";
  $seccion = "resenas";
}

// ===== CAMBIAR ESTADO DE PEDIDO =====
if(isset($_POST["procesoCambiarEstadoPedido"])){
  $idPedido = intval($_POST["idPedido"]);
  $estado = $_POST["estado"];
  $resultado = $objLogica->cambiarEstadoPedido($idPedido, $estado);
  if($resultado){
    $mensaje = "Estado del pedido actualizado correctamente";
    $tipo_mensaje = "success";
    $seccion = "pedidos";
  }
}

// OBTENER CATEGORÍAS
$categorias = $objLogica->listarCategorias();

// OBTENER CONTADORES REALES
$cantidadProductos = $objLogica->contarProductos();
$cantidadUsuarios = $objLogica->contarUsuarios();
$cantidadClientes = $objLogica->contarClientes();
$cantidadCategorias = $objLogica->contarCategorias();

// ESTADÍSTICAS DE VENTAS
$totalVentas = $objLogica->totalVentas();
$totalPedidos = $objLogica->contarPedidos();
$productosTop = $objLogica->productosTopVendidos();
$pedidosRecientes = $objLogica->pedidosRecientes(10);
?>
<!DOCTYPE html>
<html>
<head>
<title>Panel de Administración - City Óptica</title>
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

<!-- BARRA SUPERIOR -->
<div style="background-color: #1a759f; color: white; padding: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
  <div class="container-fluid">
    <div class="row align-items-center" style="gap: 0;">
      <div class="col-md-4">
        <h4 style="margin: 0; font-weight: bold; font-size: 1.2rem;">
          <i class="fa fa-eye"></i> City Óptica
        </h4>
        <small style="color: #dcefff;">Panel de Administración</small>
      </div>
      <div class="col-md-4" style="text-align: center;">
        <span style="font-size: 0.95rem;">
          <strong><?php echo $_SESSION["NombreCompleto"]; ?></strong>
        </span>
      </div>
      <div class="col-md-4" style="text-align: right;">
        <a href="cerrar_sesion.php" class="btn btn-light btn-sm" style="font-weight: 600;">
          <i class="fa fa-sign-out"></i> Cerrar sesión
        </a>
      </div>
    </div>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="container-fluid" style="padding-top: 20px; padding-bottom: 50px;">
  <div class="row">
    <!-- MENÚ LATERAL -->
    <div class="col-md-2" style="padding-right: 30px;">
      <div class="list-group" style="position: sticky; top: 20px;">
        <a href="panel.php?seccion=inicio" class="list-group-item list-group-item-action <?php echo ($seccion == "inicio" ? "active" : ""); ?>" style="<?php echo ($seccion == "inicio" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-home"></i> Inicio
        </a>
        <a href="panel.php?seccion=productos" class="list-group-item list-group-item-action <?php echo ($seccion == "productos" ? "active" : ""); ?>" style="<?php echo ($seccion == "productos" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-shopping-bag"></i> Gestionar productos
        </a>
        <a href="panel.php?seccion=usuarios" class="list-group-item list-group-item-action <?php echo ($seccion == "usuarios" ? "active" : ""); ?>" style="<?php echo ($seccion == "usuarios" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-users"></i> Gestionar usuarios
        </a>
        <a href="panel.php?seccion=categorias" class="list-group-item list-group-item-action <?php echo ($seccion == "categorias" ? "active" : ""); ?>" style="<?php echo ($seccion == "categorias" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-list"></i> Categorías
        </a>
        <a href="panel.php?seccion=clientes" class="list-group-item list-group-item-action <?php echo ($seccion == "clientes" ? "active" : ""); ?>" style="<?php echo ($seccion == "clientes" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-users"></i> Clientes registrados
        </a>
        <a href="panel.php?seccion=resenas" class="list-group-item list-group-item-action <?php echo ($seccion == "resenas" ? "active" : ""); ?>" style="<?php echo ($seccion == "resenas" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-star"></i> Reseñas y comentarios
        </a>
        <a href="panel.php?seccion=ventas" class="list-group-item list-group-item-action <?php echo ($seccion == "ventas" ? "active" : ""); ?>" style="<?php echo ($seccion == "ventas" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-bar-chart"></i> Estadísticas de ventas
        </a>
        <a href="panel.php?seccion=pedidos" class="list-group-item list-group-item-action <?php echo ($seccion == "pedidos" ? "active" : ""); ?>" style="<?php echo ($seccion == "pedidos" ? "background-color: #1a759f; color: white; border-color: #1a759f;" : ""); ?>">
          <i class="fa fa-shopping-cart"></i> Gestión de pedidos
        </a>
      </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="col-md-10">
      <?php if($mensaje != ""): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show">
          <i class="fa fa-<?php echo ($tipo_mensaje == "success" ? "check-circle" : "exclamation-circle"); ?>"></i> 
          <?php echo $mensaje; ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      <?php endif; ?>

      <!-- SECCIÓN INICIO -->
      <?php if($seccion == "inicio"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-dashboard"></i> Panel de Control
        </h2>
        <div class="row">
          <div class="col-md-3 mb-3">
            <div style="background: linear-gradient(135deg, #1a759f, #2a4b5e); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;"><?php echo $cantidadProductos; ?></p>
              <p style="margin: 5px 0;">Productos</p>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;"><?php echo $cantidadUsuarios; ?></p>
              <p style="margin: 5px 0;">Usuarios</p>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div style="background: linear-gradient(135deg, #ffc107, #fd7e14); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;"><?php echo $cantidadClientes; ?></p>
              <p style="margin: 5px 0;">Clientes</p>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div style="background: linear-gradient(135deg, #dc3545, #e74c3c); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;"><?php echo $cantidadCategorias; ?></p>
              <p style="margin: 5px 0;">Categorías</p>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #6f42c1, #e83e8c); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;">$<?php echo number_format($totalVentas, 2); ?></p>
              <p style="margin: 5px 0;"><i class="fa fa-dollar"></i> Total Facturado</p>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #17a2b8, #138496); color: white; padding: 25px; border-radius: 8px; text-align: center;">
              <p style="margin: 0; font-size: 2rem; font-weight: bold;"><?php echo $totalPedidos; ?></p>
              <p style="margin: 5px 0;"><i class="fa fa-shopping-cart"></i> Total Pedidos</p>
            </div>
          </div>
        </div>

        <h4 style="color: #1a759f; margin-top: 30px; margin-bottom: 15px; font-weight: bold;">
          <i class="fa fa-clock-o"></i> Pedidos recientes
        </h4>
        <table class="table table-hover">
          <thead style="background-color: #1a759f; color: white;">
            <tr>
              <th>#</th><th>Cliente</th><th>Total</th><th>Estado</th><th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php if($pedidosRecientes): foreach($pedidosRecientes as $p): ?>
            <tr>
              <td><?php echo $p['idPedido']; ?></td>
              <td><?php echo $p['nombre']; ?></td>
              <td>$<?php echo number_format($p['monto'], 2); ?></td>
              <td>
                <?php
                  $badgeColor = 'secondary';
                  if($p['estado'] == 'completado') $badgeColor = 'success';
                  elseif($p['estado'] == 'cancelado') $badgeColor = 'danger';
                  elseif($p['estado'] == 'en proceso') $badgeColor = 'warning';
                ?>
                <span class="badge badge-<?php echo $badgeColor; ?>">
                  <?php echo ucfirst($p['estado']); ?>
                </span>
              </td>
              <td><?php echo date('d/m/Y H:i', strtotime($p['fecha'])); ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">
                <i class="fa fa-inbox"></i> Sin pedidos registrados aún
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- SECCIÓN PRODUCTOS -->
      <?php elseif($seccion == "productos"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-shopping-bag"></i> Gestionar Productos
        </h2>

        <ul class="nav nav-tabs mb-4">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#crear-producto">
              <i class="fa fa-plus"></i> Crear nuevo producto
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#listar-productos">
              <i class="fa fa-list"></i> Listar productos
            </a>
          </li>
        </ul>

        <div class="tab-content">
          <!-- CREAR PRODUCTO -->
          <div id="crear-producto" class="tab-pane fade show active">
            <form method="POST" action="panel.php?seccion=productos">
              <input type="hidden" name="procesoCrearProducto" value="1">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label style="font-weight: bold; color: #1a759f;">
                      <i class="fa fa-tag"></i> Nombre del producto *
                    </label>
                    <input type="text" name="nombre" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label style="font-weight: bold; color: #1a759f;">
                      <i class="fa fa-dollar"></i> Precio *
                    </label>
                    <input type="number" name="precio" class="form-control" step="0.01" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-file-text"></i> Descripción *
                </label>
                <textarea name="descripcion" class="form-control" rows="4" required></textarea>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label style="font-weight: bold; color: #1a759f;">
                      <i class="fa fa-list"></i> Categoría *
                    </label>
                    <select name="categoria" class="form-control" required style="height: 50px; padding: 12px; font-size: 1rem;">
                      <option value="">Selecciona una categoría</option>
                      <?php if($categorias): 
                        foreach($categorias as $cat):
                      ?>
                      <option value="<?php echo $cat['idCategoria']; ?>">
                        <?php echo $cat['nombre']; ?>
                      </option>
                      <?php 
                        endforeach;
                      endif; 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label style="font-weight: bold; color: #1a759f;">
                      <i class="fa fa-image"></i> Nombre de imagen *
                    </label>
                    <input type="text" name="imagen" class="form-control" placeholder="ej: producto1.jpg" required>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Guardar producto
              </button>
            </form>
          </div>

          <!-- LISTAR PRODUCTOS -->
          <div id="listar-productos" class="tab-pane fade">
            <table class="table table-hover">
              <thead style="background-color: #1a759f; color: white;">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Categoría</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $productosLista = $objLogica->listarProductos();
                  if($productosLista){
                    foreach($productosLista as $prod):
                ?>
                <tr>
                  <td><?php echo $prod['idProducto']; ?></td>
                  <td><?php echo $prod['nombre']; ?></td>
                  <td>$<?php echo number_format($prod['precio'], 2); ?></td>
                  <td>
                    <?php 
                      // Obtener nombre de la categoría
                      foreach($categorias as $cat){
                        if($cat['idCategoria'] == $prod['idCategoria']){
                          echo $cat['nombre'];
                          break;
                        }
                      }
                    ?>
                  </td>
                  <td>
                    <form method="POST" style="display: inline;">
                      <input type="hidden" name="procesoEditarProducto" value="1">
                      <input type="hidden" name="idProducto" value="<?php echo $prod['idProducto']; ?>">
                      <input type="hidden" name="nombre" value="<?php echo $prod['nombre']; ?>">
                      <input type="hidden" name="descripcion" value="<?php echo $prod['descripcion']; ?>">
                      <input type="hidden" name="precio" value="<?php echo $prod['precio']; ?>">
                      <input type="hidden" name="categoria" value="<?php echo $prod['idCategoria']; ?>">
                      <input type="hidden" name="imagen" value="<?php echo $prod['imagen']; ?>">
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditarProducto<?php echo $prod['idProducto']; ?>" title="Editar">
                        <i class="fa fa-edit"></i>
                      </button>
                    </form>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar este producto?');">
                      <input type="hidden" name="procesoEliminarProducto" value="1">
                      <input type="hidden" name="idProducto" value="<?php echo $prod['idProducto']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php 
                    endforeach;
                  } else {
                ?>
                <tr>
                  <td colspan="5" style="text-align: center; color: #999;">
                    <i class="fa fa-inbox"></i> No hay productos registrados
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SECCIÓN USUARIOS -->
      <?php elseif($seccion == "usuarios"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-users"></i> Gestionar Usuarios
        </h2>

        <ul class="nav nav-tabs mb-4">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#crear-usuario">
              <i class="fa fa-plus"></i> Crear nuevo usuario
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#listar-usuarios">
              <i class="fa fa-list"></i> Listar usuarios
            </a>
          </li>
        </ul>

        <div class="tab-content">
          <!-- CREAR USUARIO -->
          <div id="crear-usuario" class="tab-pane fade show active">
            <form method="POST" action="panel.php?seccion=usuarios">
              <input type="hidden" name="procesoCrearUsuario" value="1">

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-user"></i> Nombre completo *
                </label>
                <input type="text" name="nombre" class="form-control" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-at"></i> Usuario (login) *
                </label>
                <input type="text" name="login" class="form-control" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-lock"></i> Contraseña *
                </label>
                <input type="password" name="clave" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Guardar usuario
              </button>
            </form>
          </div>

          <!-- LISTAR USUARIOS -->
          <div id="listar-usuarios" class="tab-pane fade">
            <table class="table table-hover">
              <thead style="background-color: #1a759f; color: white;">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Usuario</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $usuariosLista = $objLogica->listarUsuarios();
                  if($usuariosLista){
                    foreach($usuariosLista as $user):
                ?>
                <tr>
                  <td><?php echo $user['idUsuario']; ?></td>
                  <td><?php echo $user['nombre']; ?></td>
                  <td><?php echo $user['login']; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditarUsuario<?php echo $user['idUsuario']; ?>" title="Editar">
                      <i class="fa fa-edit"></i>
                    </button>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario?');">
                      <input type="hidden" name="procesoEliminarUsuario" value="1">
                      <input type="hidden" name="idUsuario" value="<?php echo $user['idUsuario']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php 
                    endforeach;
                  } else {
                ?>
                <tr>
                  <td colspan="4" style="text-align: center; color: #999;">
                    <i class="fa fa-inbox"></i> No hay usuarios registrados
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SECCIÓN CLIENTES -->
      <?php elseif($seccion == "clientes"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-users"></i> Clientes Registrados
        </h2>
        <table class="table table-hover">
          <thead style="background-color: #1a759f; color: white;">
            <tr>
              <th>Nombre</th>
              <th>Documento</th>
              <th>Email</th>
              <th>Teléfono</th>
              <th>Tipo de Lente</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $clientesLista = $objLogica->listarClientes();
              if($clientesLista){
                foreach($clientesLista as $cliente):
            ?>
            <tr>
              <td><?php echo $cliente['nombre']; ?></td>
              <td><?php echo $cliente['documento']; ?></td>
              <td><?php echo $cliente['email']; ?></td>
              <td><?php echo $cliente['telefono']; ?></td>
              <td><?php echo $cliente['tipoLente']; ?></td>
              <td>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditarCliente<?php echo $cliente['idCliente']; ?>" title="Editar">
                  <i class="fa fa-edit"></i>
                </button>
                <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar este cliente?');">
                  <input type="hidden" name="procesoEliminarCliente" value="1">
                  <input type="hidden" name="idCliente" value="<?php echo $cliente['idCliente']; ?>">
                  <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            <?php 
                endforeach;
              } else {
            ?>
            <tr>
              <td colspan="6" style="text-align: center; color: #999;">
                <i class="fa fa-inbox"></i> No hay clientes registrados
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- SECCIÓN CATEGORÍAS -->
      <?php elseif($seccion == "categorias"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-list"></i> Gestionar Categorías
        </h2>

        <ul class="nav nav-tabs mb-4">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#crear-categoria">
              <i class="fa fa-plus"></i> Crear nueva categoría
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#listar-categorias">
              <i class="fa fa-list"></i> Listar categorías
            </a>
          </li>
        </ul>

        <div class="tab-content">
          <!-- CREAR CATEGORÍA -->
          <div id="crear-categoria" class="tab-pane fade show active">
            <form method="POST" action="panel.php?seccion=categorias">
              <input type="hidden" name="procesoCrearCategoria" value="1">

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-tag"></i> Nombre de la categoría *
                </label>
                <input type="text" name="nombre" class="form-control" required>
              </div>

              <div class="form-group">
                <label style="font-weight: bold; color: #1a759f;">
                  <i class="fa fa-file-text"></i> Descripción
                </label>
                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción opcional de la categoría"></textarea>
              </div>

              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Crear categoría
              </button>
            </form>
          </div>

          <!-- LISTAR CATEGORÍAS -->
          <div id="listar-categorias" class="tab-pane fade">
            <table class="table table-hover">
              <thead style="background-color: #1a759f; color: white;">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if($categorias): 
                  foreach($categorias as $cat):
                ?>
                <tr>
                  <td><?php echo $cat['idCategoria']; ?></td>
                  <td><?php echo $cat['nombre']; ?></td>
                  <td><?php echo isset($cat['descripcion']) ? $cat['descripcion'] : ''; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditarCategoria<?php echo $cat['idCategoria']; ?>" title="Editar">
                      <i class="fa fa-edit"></i>
                    </button>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de que desea eliminar esta categoría?');">
                      <input type="hidden" name="procesoEliminarCategoria" value="1">
                      <input type="hidden" name="idCategoria" value="<?php echo $cat['idCategoria']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php 
                  endforeach;
                endif; 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SECCIÓN RESEÑAS -->
      <?php elseif($seccion == "resenas"):
        $todosComentarios   = $objLogica->listarTodosComentarios();
        $todasCalificaciones = $objLogica->listarTodasCalificaciones();
      ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-star"></i> Reseñas y Comentarios
        </h2>

        <ul class="nav nav-tabs mb-4">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-comentarios">
              <i class="fa fa-comments"></i> Comentarios
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab-calificaciones">
              <i class="fa fa-star"></i> Calificaciones
            </a>
          </li>
        </ul>

        <div class="tab-content">
          <!-- COMENTARIOS -->
          <div id="tab-comentarios" class="tab-pane fade show active">
            <table class="table table-hover">
              <thead style="background-color: #1a759f; color: white;">
                <tr>
                  <th>Autor</th>
                  <th>Producto</th>
                  <th>Comentario</th>
                  <th>Fecha</th>
                  <th style="text-align:center;">Estado</th>
                  <th style="text-align:center;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if($todosComentarios): foreach($todosComentarios as $c): ?>
                <tr>
                  <td><strong><?php echo $c['autor']; ?></strong></td>
                  <td><span class="badge badge-info"><?php echo $c['producto']; ?></span></td>
                  <td style="max-width: 300px;"><?php echo $c['texto']; ?></td>
                  <td><?php echo date('d/m/Y H:i', strtotime($c['fecha'])); ?></td>
                  <td style="text-align:center;">
                    <?php if(isset($c['activo']) && $c['activo'] == 1): ?>
                      <span class="badge badge-success" style="padding: 6px 12px; font-size: 0.85rem;"><i class="fa fa-check"></i> Activo</span>
                    <?php else: ?>
                      <span class="badge badge-secondary" style="padding: 6px 12px; font-size: 0.85rem;"><i class="fa fa-eye-slash"></i> Inactivo</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align:center;">
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="procesoToggleComentario" value="1">
                      <input type="hidden" name="idComentario" value="<?php echo $c['idComentario']; ?>">
                      <?php if(isset($c['activo']) && $c['activo'] == 1): ?>
                        <input type="hidden" name="activo" value="0">
                        <button type="submit" class="btn btn-warning btn-sm" title="Desactivar comentario" style="margin-right: 5px;">
                          <i class="fa fa-ban"></i> Desactivar
                        </button>
                      <?php else: ?>
                        <input type="hidden" name="activo" value="1">
                        <button type="submit" class="btn btn-success btn-sm" title="Activar comentario" style="margin-right: 5px;">
                          <i class="fa fa-check"></i> Activar
                        </button>
                      <?php endif; ?>
                    </form>
                    <form method="POST" style="display:inline;"
                      onsubmit="return confirm('¿Eliminar este comentario?');">
                      <input type="hidden" name="procesoEliminarComentario" value="1">
                      <input type="hidden" name="idComentario" value="<?php echo $c['idComentario']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm" title="Eliminar comentario">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">
                    <i class="fa fa-inbox"></i> Sin comentarios aún
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- CALIFICACIONES -->
          <div id="tab-calificaciones" class="tab-pane fade">
            <table class="table table-hover">
              <thead style="background-color: #1a759f; color: white;">
                <tr>
                  <th>Autor</th>
                  <th>Producto</th>
                  <th style="text-align:center;">Puntaje</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php if($todasCalificaciones): foreach($todasCalificaciones as $cal): ?>
                <tr>
                  <td><strong><?php echo $cal['autor']; ?></strong></td>
                  <td><span class="badge badge-info"><?php echo $cal['producto']; ?></span></td>
                  <td style="text-align:center;">
                    <?php
                      for($i = 1; $i <= 5; $i++){
                        echo $i <= $cal['puntaje']
                          ? '<span style="color:#ffc107;">&#9733;</span>'
                          : '<span style="color:#ccc;">&#9733;</span>';
                      }
                    ?>
                    <small class="text-muted">(<?php echo $cal['puntaje']; ?>/5)</small>
                  </td>
                  <td><?php echo date('d/m/Y H:i', strtotime($cal['fecha'])); ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">
                    <i class="fa fa-inbox"></i> Sin calificaciones aún
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- SECCIÓN ESTADÍSTICAS DE VENTAS -->
      <?php elseif($seccion == "ventas"): ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-bar-chart"></i> Estadísticas de Ventas
        </h2>

        <div class="row mb-4">
          <div class="col-md-4">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border-left: 4px solid #1a759f;">
              <h3 style="color: #1a759f; margin: 0;">$<?php echo number_format($totalVentas, 2); ?></h3>
              <p style="color: #666; margin: 5px 0 0 0;">Total Facturado</p>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border-left: 4px solid #28a745;">
              <h3 style="color: #28a745; margin: 0;"><?php echo $totalPedidos; ?></h3>
              <p style="color: #666; margin: 5px 0 0 0;">Total Pedidos</p>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; border-left: 4px solid #ffc107;">
              <h3 style="color: #ffc107; margin: 0;"><?php echo $cantidadClientes; ?></h3>
              <p style="color: #666; margin: 5px 0 0 0;">Clientes Registrados</p>
            </div>
          </div>
        </div>

        <h4 style="color: #1a759f; margin-bottom: 15px; font-weight: bold;">
          <i class="fa fa-trophy"></i> Productos más vendidos
        </h4>
        <table class="table table-hover">
          <thead style="background-color: #1a759f; color: white;">
            <tr>
              <th>#</th>
              <th>Producto</th>
              <th style="text-align: center;">Unidades vendidas</th>
              <th style="text-align: right;">Total facturado</th>
            </tr>
          </thead>
          <tbody>
            <?php if($productosTop): $rank = 1; foreach($productosTop as $p): ?>
            <tr>
              <td><strong><?php echo $rank++; ?></strong></td>
              <td><?php echo $p['nombre']; ?></td>
              <td style="text-align: center;"><?php echo $p['totalVendido']; ?></td>
              <td style="text-align: right;">$<?php echo number_format($p['totalFacturado'], 2); ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="4" class="text-center text-muted">
                <i class="fa fa-inbox"></i> Sin datos de ventas aún
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- SECCIÓN GESTIÓN DE PEDIDOS -->
      <?php elseif($seccion == "pedidos"):
        $todosPedidos = $objLogica->listarPedidosTodos();
      ?>
      <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #1a759f; margin-bottom: 30px;">
          <i class="fa fa-shopping-cart"></i> Gestión de Pedidos
        </h2>
        <table class="table table-hover">
          <thead style="background-color: #1a759f; color: white;">
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Email</th>
              <th style="text-align: right;">Total</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if($todosPedidos): foreach($todosPedidos as $p):
              $badgeColor = 'secondary';
              if($p['estado'] == 'completado') $badgeColor = 'success';
              elseif($p['estado'] == 'cancelado') $badgeColor = 'danger';
              elseif($p['estado'] == 'en proceso') $badgeColor = 'warning';
            ?>
            <tr>
              <td><?php echo $p['idPedido']; ?></td>
              <td><?php echo $p['nombre']; ?></td>
              <td><?php echo $p['email']; ?></td>
              <td style="text-align: right;">$<?php echo number_format($p['monto'], 2); ?></td>
              <td>
                <span class="badge badge-<?php echo $badgeColor; ?>">
                  <?php echo ucfirst($p['estado']); ?>
                </span>
              </td>
              <td><?php echo date('d/m/Y H:i', strtotime($p['fecha'])); ?></td>
              <td style="text-align: center;">
                <button class="btn btn-info btn-sm" data-toggle="modal"
                  data-target="#modalEstado<?php echo $p['idPedido']; ?>">
                  <i class="fa fa-edit"></i> Estado
                </button>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">
                <i class="fa fa-inbox"></i> Sin pedidos registrados
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <?php endif; ?>
    </div>
  </div>
</div>

<!-- ===== MODALES CAMBIAR ESTADO PEDIDO ===== -->
<?php if(isset($todosPedidos) && $todosPedidos): foreach($todosPedidos as $p): ?>
<div class="modal fade" id="modalEstado<?php echo $p['idPedido']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Cambiar Estado — Pedido #<?php echo $p['idPedido']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="panel.php?seccion=pedidos">
        <div class="modal-body">
          <input type="hidden" name="procesoCambiarEstadoPedido" value="1">
          <input type="hidden" name="idPedido" value="<?php echo $p['idPedido']; ?>">
          <p><strong>Cliente:</strong> <?php echo $p['nombre']; ?></p>
          <p><strong>Total:</strong> $<?php echo number_format($p['monto'], 2); ?></p>
          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-flag"></i> Nuevo estado</label>
            <select name="estado" class="form-control" style="height: 50px; padding: 12px; font-size: 1rem;">
              <option value="pendiente" <?php echo $p['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
              <option value="en proceso" <?php echo $p['estado'] == 'en proceso' ? 'selected' : ''; ?>>En Proceso</option>
              <option value="completado" <?php echo $p['estado'] == 'completado' ? 'selected' : ''; ?>>Completado</option>
              <option value="cancelado" <?php echo $p['estado'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endforeach; endif; ?>

<!-- ===== MODALES DE EDICIÓN ===== -->

<!-- MODALES PARA EDITAR PRODUCTOS -->
<?php 
  $productosLista = $objLogica->listarProductos();
  if($productosLista){
    foreach($productosLista as $prod):
?>
<div class="modal fade" id="modalEditarProducto<?php echo $prod['idProducto']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Editar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="panel.php?seccion=productos">
        <div class="modal-body">
          <input type="hidden" name="procesoEditarProducto" value="1">
          <input type="hidden" name="idProducto" value="<?php echo $prod['idProducto']; ?>">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-tag"></i> Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $prod['nombre']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-file-text"></i> Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required><?php echo $prod['descripcion']; ?></textarea>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-dollar"></i> Precio</label>
            <input type="number" name="precio" class="form-control" step="0.01" value="<?php echo $prod['precio']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-list"></i> Categoría</label>
            <select name="categoria" class="form-control" required style="height: 50px; padding: 12px; font-size: 1rem;">
              <?php if($categorias): 
                foreach($categorias as $cat):
              ?>
              <option value="<?php echo $cat['idCategoria']; ?>" <?php echo ($cat['idCategoria'] == $prod['idCategoria'] ? 'selected' : ''); ?>>
                <?php echo $cat['nombre']; ?>
              </option>
              <?php 
                endforeach;
              endif; 
              ?>
            </select>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-image"></i> Imagen (nombre archivo)</label>
            <input type="text" name="imagen" class="form-control" value="<?php echo $prod['imagen']; ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php 
    endforeach;
  }
?>

<!-- MODALES PARA EDITAR USUARIOS -->
<?php 
  $usuariosLista = $objLogica->listarUsuarios();
  if($usuariosLista){
    foreach($usuariosLista as $user):
?>
<div class="modal fade" id="modalEditarUsuario<?php echo $user['idUsuario']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="panel.php?seccion=usuarios">
        <div class="modal-body">
          <input type="hidden" name="procesoEditarUsuario" value="1">
          <input type="hidden" name="idUsuario" value="<?php echo $user['idUsuario']; ?>">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-user"></i> Nombre completo</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $user['nombre']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-at"></i> Usuario (login)</label>
            <input type="text" name="login" class="form-control" value="<?php echo $user['login']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-lock"></i> Contraseña</label>
            <input type="text" name="clave" class="form-control" value="<?php echo $user['clave']; ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php 
    endforeach;
  }
?>

<!-- MODALES PARA EDITAR CLIENTES -->
<?php 
  $clientesLista = $objLogica->listarClientes();
  if($clientesLista){
    foreach($clientesLista as $cliente):
?>
<div class="modal fade" id="modalEditarCliente<?php echo $cliente['idCliente']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Editar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="panel.php?seccion=clientes">
        <div class="modal-body">
          <input type="hidden" name="procesoEditarCliente" value="1">
          <input type="hidden" name="idCliente" value="<?php echo $cliente['idCliente']; ?>">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-user"></i> Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $cliente['nombre']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-id-card"></i> Documento</label>
            <input type="text" name="documento" class="form-control" value="<?php echo $cliente['documento']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-phone"></i> Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo $cliente['telefono']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $cliente['email']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-eye"></i> Tipo de Lente</label>
            <select name="tipoLente" class="form-control" required style="height: 50px; padding: 12px; font-size: 1rem;">
              <option value="Monofocal" <?php echo ($cliente['tipoLente'] == 'Monofocal' ? 'selected' : ''); ?>>Monofocal</option>
              <option value="Bifocal" <?php echo ($cliente['tipoLente'] == 'Bifocal' ? 'selected' : ''); ?>>Bifocal</option>
              <option value="Progresivo" <?php echo ($cliente['tipoLente'] == 'Progresivo' ? 'selected' : ''); ?>>Progresivo</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php 
    endforeach;
  }
?>

<!-- MODALES PARA EDITAR CATEGORÍAS -->
<?php 
  $categoriasLista = $objLogica->listarCategorias();
  if($categoriasLista){
    foreach($categoriasLista as $cat):
?>
<div class="modal fade" id="modalEditarCategoria<?php echo $cat['idCategoria']; ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #1a759f; color: white;">
        <h5 class="modal-title">Editar Categoría</h5>
        <button type="button" class="close" data-dismiss="modal" style="color: white;">
          <span>&times;</span>
        </button>
      </div>
      <form method="POST" action="panel.php?seccion=categorias">
        <div class="modal-body">
          <input type="hidden" name="procesoEditarCategoria" value="1">
          <input type="hidden" name="idCategoria" value="<?php echo $cat['idCategoria']; ?>">

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-tag"></i> Nombre de la categoría</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $cat['nombre']; ?>" required>
          </div>

          <div class="form-group">
            <label style="font-weight: bold; color: #1a759f;"><i class="fa fa-file-text"></i> Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?php echo isset($cat['descripcion']) ? $cat['descripcion'] : ''; ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php 
    endforeach;
  }
?>

<script src="logica.js"></script>
</body>
</html>
