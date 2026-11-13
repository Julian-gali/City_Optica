<?php
include_once("clases/sql.php");

class ApiLogica
{
  private $objetoSQL;

  public function __construct()
  {
    $this->objetoSQL = new sql();
  }

  // ===== PRODUCTOS =====
  public function listarProductos()
  {
    $sql = "SELECT p.idProducto, p.nombre, p.descripcion, p.precio, p.imagen,
                   c.nombre as categoria
            FROM producto p
            LEFT JOIN categoria c ON p.idCategoria = c.idCategoria
            WHERE p.activo = 1
            ORDER BY p.nombre";
    return $this->objetoSQL->consultar($sql);
  }

  // ===== COMENTARIOS =====
  public function guardarComentario($idProducto, $autor, $texto)
  {
    $idProducto = intval($idProducto);
    $autor      = $this->objetoSQL->getConexion()->real_escape_string(trim($autor));
    $texto      = $this->objetoSQL->getConexion()->real_escape_string(trim($texto));
    $sql = "INSERT INTO comentario (idProducto, autor, texto)
            VALUES (" . $idProducto . ", '" . $autor . "', '" . $texto . "')";
    return $this->objetoSQL->sentencia($sql);
  }

  public function listarComentarios($idProducto)
  {
    $idProducto = intval($idProducto);
    $sql = "SELECT idComentario, autor, texto, fecha
            FROM comentario
            WHERE idProducto = " . $idProducto . " AND activo = 1
            ORDER BY fecha DESC";
    return $this->objetoSQL->consultar($sql);
  }

  // ===== CALIFICACIONES =====
  public function guardarCalificacion($idProducto, $autor, $puntaje)
  {
    $idProducto = intval($idProducto);
    $puntaje    = intval($puntaje);
    if($puntaje < 1 || $puntaje > 5) return false;
    $autor = $this->objetoSQL->getConexion()->real_escape_string(trim($autor));
    $sql = "INSERT INTO calificacion (idProducto, autor, puntaje)
            VALUES (" . $idProducto . ", '" . $autor . "', " . $puntaje . ")";
    return $this->objetoSQL->sentencia($sql);
  }

  public function promedioCalificacion($idProducto)
  {
    $idProducto = intval($idProducto);
    $sql = "SELECT ROUND(AVG(puntaje), 1) as promedio, COUNT(*) as total
            FROM calificacion
            WHERE idProducto = " . $idProducto;
    $resultado = $this->objetoSQL->consultar($sql);
    if($resultado){
      return array(
        'promedio' => $resultado[0]['promedio'] ? $resultado[0]['promedio'] : 0,
        'total'    => intval($resultado[0]['total'])
      );
    }
    return array('promedio' => 0, 'total' => 0);
  }
}
?>
