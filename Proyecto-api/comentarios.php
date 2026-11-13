<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){ http_response_code(200); exit(); }

include("clases/logica_api.php");
$objApi = new ApiLogica();
$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){
  $idProducto = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;
  $autor      = isset($_POST['autor'])      ? trim($_POST['autor'])        : '';
  $texto      = isset($_POST['texto'])      ? trim($_POST['texto'])        : '';

  if($idProducto <= 0 || empty($autor) || empty($texto)){
    http_response_code(400);
    echo json_encode(array(
      'status'  => 'error',
      'message' => 'Campos requeridos: idProducto, autor, texto',
      'data'    => null
    ));
    exit();
  }

  $resultado = $objApi->guardarComentario($idProducto, $autor, $texto);
  if($resultado){
    http_response_code(201);
    echo json_encode(array('status' => 'ok', 'message' => 'Comentario guardado correctamente', 'data' => null));
  } else {
    http_response_code(500);
    echo json_encode(array('status' => 'error', 'message' => 'Error al guardar el comentario', 'data' => null));
  }

} elseif($method == 'GET'){
  $idProducto = isset($_GET['idProducto']) ? intval($_GET['idProducto']) : 0;
  if($idProducto <= 0){
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Se requiere idProducto', 'data' => null));
    exit();
  }
  $comentarios = $objApi->listarComentarios($idProducto);
  echo json_encode(array(
    'status'  => 'ok',
    'message' => 'OK',
    'data'    => $comentarios ? $comentarios : array()
  ));

} else {
  http_response_code(405);
  echo json_encode(array('status' => 'error', 'message' => 'Metodo no permitido', 'data' => null));
}
?>
