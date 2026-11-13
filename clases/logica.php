<?php
include("clases/sql.php");

//clase logica
class Logica
{

  private $objetoSQL;

  public function __construct()
  {
    $this->objetoSQL = new sql();
  }

  // ===== AUTENTICACIÓN =====
  public function validarAcceso($login, $clave)
  {
    $sql = "SELECT * FROM usuario WHERE login='" . $login . "' AND clave='" . $clave . "' AND activo=1";
    return $this->objetoSQL->consultar($sql);
  }

  // ===== CLIENTES =====
  public function guardarCliente($nombre, $documento, $telefono, $email, $tipoLente)
  {
    $sql = "INSERT INTO cliente (nombre, documento, telefono, email, tipoLente) 
            VALUES ('" . $nombre . "', '" . $documento . "', '" . $telefono . "', '" . $email . "', '" . $tipoLente . "')";
    return $this->objetoSQL->sentencia($sql);
  }

  public function validarClienteExiste($email)
  {
    $sql = "SELECT * FROM cliente WHERE email='" . $email . "'";
    return $this->objetoSQL->validarConsulta($sql);
  }

  public function listarClientes()
  {
    $sql = "SELECT * FROM cliente ORDER BY nombre";
    return $this->objetoSQL->consultar($sql);
  }

  public function obtenerClientePorEmail($email)
  {
    $sql = "SELECT * FROM cliente WHERE email='" . $email . "'";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado ? $resultado[0] : null;
  }

  public function obtenerCliente($idCliente)
  {
    $sql = "SELECT * FROM cliente WHERE idCliente=" . $idCliente;
    return $this->objetoSQL->consultar($sql);
  }

  public function actualizarCliente($idCliente, $nombre, $documento, $telefono, $email, $tipoLente)
  {
    $sql = "UPDATE cliente SET nombre='" . $nombre . "', documento='" . $documento . "', 
            telefono='" . $telefono . "', email='" . $email . "', tipoLente='" . $tipoLente . "' 
            WHERE idCliente=" . $idCliente;
    return $this->objetoSQL->sentencia($sql);
  }

  public function eliminarCliente($idCliente)
  {
    $sql = "DELETE FROM cliente WHERE idCliente=" . $idCliente;
    return $this->objetoSQL->sentencia($sql);
  }

  // ===== CATEGORÍAS =====
  public function listarCategorias()
  {
    $sql = "SELECT * FROM categoria WHERE activo=1 ORDER BY nombre";
    return $this->objetoSQL->consultar($sql);
  }

  public function crearCategoria($nombre, $descripcion = '', $activo = 1)
  {
    $sql = "INSERT INTO categoria (nombre, descripcion, activo) VALUES ('" . $nombre . "', '" . $descripcion . "', " . $activo . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function obtenerCategoria($idCategoria)
  {
    $sql = "SELECT * FROM categoria WHERE idCategoria=" . $idCategoria;
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado ? $resultado[0] : null;
  }

  public function actualizarCategoria($idCategoria, $nombre, $descripcion = '')
  {
    $sql = "UPDATE categoria SET nombre='" . $nombre . "', descripcion='" . $descripcion . "' WHERE idCategoria=" . $idCategoria;
    return $this->objetoSQL->sentencia($sql);
  }

  public function eliminarCategoria($idCategoria)
  {
    $sql = "UPDATE categoria SET activo=0 WHERE idCategoria=" . $idCategoria;
    return $this->objetoSQL->sentencia($sql);
  }

  // ===== PRODUCTOS =====
  public function listarProductos()
  {
    $sql = "SELECT * FROM producto WHERE activo=1 ORDER BY nombre";
    return $this->objetoSQL->consultar($sql);
  }

  public function listarProductosXCategoria($idCategoria)
  {
    $sql = "SELECT * FROM producto WHERE idCategoria=" . $idCategoria . " AND activo=1 ORDER BY nombre";
    return $this->objetoSQL->consultar($sql);
  }

  public function detalleProducto($idProducto)
  {
    $sql = "SELECT * FROM producto WHERE idProducto=" . $idProducto;
    return $this->objetoSQL->consultar($sql);
  }

  public function obtenerProducto($idProducto)
  {
    $sql = "SELECT * FROM producto WHERE idProducto=" . $idProducto;
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado ? $resultado[0] : null;
  }

  // ===== CARRITO =====
  public function guardarCarrito($idCliente, $idProducto, $cantidad)
  {
    $sql = "INSERT INTO carrito (idCliente, idProducto, cantidad) 
            VALUES (" . $idCliente . ", " . $idProducto . ", " . $cantidad . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function obtenerCarrito($idCliente)
  {
    $sql = "SELECT c.*, p.nombre, p.precio, p.imagen 
            FROM carrito c 
            JOIN producto p ON c.idProducto = p.idProducto 
            WHERE c.idCliente = " . $idCliente;
    return $this->objetoSQL->consultar($sql);
  }

  // ===== ADMINISTRACIÓN - USUARIOS =====
  public function crearUsuario($login, $clave, $nombre, $activo = 1)
  {
    $sql = "INSERT INTO usuario (login, clave, nombre, activo) 
            VALUES ('" . $login . "', '" . $clave . "', '" . $nombre . "', " . $activo . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function listarUsuarios()
  {
    $sql = "SELECT * FROM usuario ORDER BY nombre";
    return $this->objetoSQL->consultar($sql);
  }

  public function obtenerUsuario($idUsuario)
  {
    $sql = "SELECT * FROM usuario WHERE idUsuario=" . $idUsuario;
    return $this->objetoSQL->consultar($sql);
  }

  public function actualizarUsuario($idUsuario, $login, $clave, $nombre)
  {
    $sql = "UPDATE usuario SET login='" . $login . "', clave='" . $clave . "', nombre='" . $nombre . "' WHERE idUsuario=" . $idUsuario;
    return $this->objetoSQL->sentencia($sql);
  }

  public function eliminarUsuario($idUsuario)
  {
    $sql = "UPDATE usuario SET activo=0 WHERE idUsuario=" . $idUsuario;
    return $this->objetoSQL->sentencia($sql);
  }

  // ===== ADMINISTRACIÓN - PRODUCTOS =====
  public function crearProducto($nombre, $descripcion, $precio, $idCategoria, $imagen, $activo = 1)
  {
    $sql = "INSERT INTO producto (nombre, descripcion, precio, idCategoria, imagen, activo) 
            VALUES ('" . $nombre . "', '" . $descripcion . "', " . $precio . ", " . $idCategoria . ", '" . $imagen . "', " . $activo . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function actualizarProducto($idProducto, $nombre, $descripcion, $precio, $idCategoria, $imagen)
  {
    $sql = "UPDATE producto SET nombre='" . $nombre . "', descripcion='" . $descripcion . "', 
            precio=" . $precio . ", idCategoria=" . $idCategoria . ", imagen='" . $imagen . "' 
            WHERE idProducto=" . $idProducto;
    return $this->objetoSQL->sentencia($sql);
  }

  public function eliminarProducto($idProducto)
  {
    $sql = "UPDATE producto SET activo=0 WHERE idProducto=" . $idProducto;
    return $this->objetoSQL->sentencia($sql);
  }

  // ===== CONTADORES =====
  public function contarProductos()
  {
    $sql = "SELECT COUNT(*) as total FROM producto WHERE activo=1";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado[0]['total'] ?? 0;
  }

  public function contarUsuarios()
  {
    $sql = "SELECT COUNT(*) as total FROM usuario WHERE activo=1";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado[0]['total'] ?? 0;
  }

  public function contarClientes()
  {
    $sql = "SELECT COUNT(*) as total FROM cliente";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado[0]['total'] ?? 0;
  }

  public function contarCategorias()
  {
    $sql = "SELECT COUNT(*) as total FROM categoria WHERE activo=1";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado[0]['total'] ?? 0;
  }

  // ===== PEDIDOS =====
  public function crearPedido($idCliente, $montoTotal, $estado = 'pendiente')
  {
    $fecha = date('Y-m-d H:i:s');
    $sql = "INSERT INTO pedido (idCliente, fecha, monto, estado) 
            VALUES (" . $idCliente . ", '" . $fecha . "', " . $montoTotal . ", '" . $estado . "')";
    return $this->objetoSQL->sentencia($sql);
  }

  public function obtenerUltimoPedido($idCliente)
  {
    $sql = "SELECT * FROM pedido WHERE idCliente=" . $idCliente . " ORDER BY idPedido DESC LIMIT 1";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado ? $resultado[0] : null;
  }

  public function crearDetallePedido($idPedido, $idProducto, $cantidad, $precio)
  {
    $sql = "INSERT INTO detallePedido (idPedido, idProducto, cantidad, precio) 
            VALUES (" . $idPedido . ", " . $idProducto . ", " . $cantidad . ", " . $precio . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function listarPedidos()
  {
    $sql = "SELECT p.*, c.nombre, c.email FROM pedido p
            JOIN cliente c ON p.idCliente = c.idCliente
            ORDER BY p.fecha DESC";
    return $this->objetoSQL->consultar($sql);
  }

  // ===== ESTADÍSTICAS DE VENTAS =====
  public function totalVentas()
  {
    $sql = "SELECT COALESCE(SUM(monto), 0) as total FROM pedido WHERE estado != 'cancelado'";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado ? $resultado[0]['total'] : 0;
  }

  public function contarPedidos()
  {
    $sql = "SELECT COUNT(*) as total FROM pedido";
    $resultado = $this->objetoSQL->consultar($sql);
    return $resultado[0]['total'] ?? 0;
  }

  public function productosTopVendidos()
  {
    $sql = "SELECT p.nombre, SUM(dp.cantidad) as totalVendido,
                   SUM(dp.cantidad * dp.precio) as totalFacturado
            FROM detallePedido dp
            JOIN producto p ON dp.idProducto = p.idProducto
            GROUP BY dp.idProducto, p.nombre
            ORDER BY totalVendido DESC
            LIMIT 5";
    return $this->objetoSQL->consultar($sql);
  }

  public function pedidosRecientes($limite)
  {
    $sql = "SELECT p.idPedido, p.fecha, p.monto, p.estado, c.nombre, c.email
            FROM pedido p
            JOIN cliente c ON p.idCliente = c.idCliente
            ORDER BY p.fecha DESC
            LIMIT " . intval($limite);
    return $this->objetoSQL->consultar($sql);
  }

  public function listarPedidosTodos()
  {
    $sql = "SELECT p.idPedido, p.fecha, p.monto, p.estado, c.nombre, c.email
            FROM pedido p
            JOIN cliente c ON p.idCliente = c.idCliente
            ORDER BY p.fecha DESC";
    return $this->objetoSQL->consultar($sql);
  }

  public function cambiarEstadoPedido($idPedido, $estado)
  {
    $validos = array('pendiente', 'en proceso', 'completado', 'cancelado');
    if(!in_array($estado, $validos)) return false;
    $sql = "UPDATE pedido SET estado='" . $estado . "' WHERE idPedido=" . intval($idPedido);
    return $this->objetoSQL->sentencia($sql);
  }

  // ===== RESEÑAS =====
  public function listarTodosComentarios()
  {
    $sql = "SELECT c.idComentario, c.autor, c.texto, c.fecha, c.activo, p.nombre as producto
            FROM comentario c
            JOIN producto p ON c.idProducto = p.idProducto
            ORDER BY c.fecha DESC";
    return $this->objetoSQL->consultar($sql);
  }

  public function listarTodasCalificaciones()
  {
    $sql = "SELECT cal.idCalificacion, cal.autor, cal.puntaje, cal.fecha, p.nombre as producto
            FROM calificacion cal
            JOIN producto p ON cal.idProducto = p.idProducto
            ORDER BY cal.fecha DESC";
    return $this->objetoSQL->consultar($sql);
  }

  public function eliminarComentario($idComentario)
  {
    $sql = "DELETE FROM comentario WHERE idComentario=" . intval($idComentario);
    return $this->objetoSQL->sentencia($sql);
  }

  public function toggleEstadoComentario($idComentario, $activo)
  {
    $sql = "UPDATE comentario SET activo=" . intval($activo) . " WHERE idComentario=" . intval($idComentario);
    return $this->objetoSQL->sentencia($sql);
  }

  public function listarComentariosActivos($limite = 3)
  {
    $sql = "SELECT c.autor, c.texto, c.fecha, p.nombre as producto, 
                   COALESCE(cal.puntaje, 5) as puntaje
            FROM comentario c
            JOIN producto p ON c.idProducto = p.idProducto
            LEFT JOIN calificacion cal ON c.idProducto = cal.idProducto AND c.autor = cal.autor
            WHERE c.activo = 1
            ORDER BY c.fecha DESC
            LIMIT " . intval($limite);
    return $this->objetoSQL->consultar($sql);
  }

}

