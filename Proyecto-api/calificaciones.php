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
  $puntaje    = isset($_POST['puntaje'])    ? intval($_POST['puntaje'])    : 0;

  if($idProducto <= 0 || empty($autor) || $puntaje < 1 || $puntaje > 5){
    http_response_code(400);
    echo json_encode(array(
      'status'  => 'error',
      'message' => 'Campos requeridos: idProducto, autor, puntaje (1-5)',
      'data'    => null
    ));
    exit();
  }

  $resultado = $objApi->guardarCalificacion($idProducto, $autor, $puntaje);
  if($resultado){
    http_response_code(201);
    echo json_encode(array('status' => 'ok', 'message' => 'Calificacion guardada', 'data' => null));
  } else {
    http_response_code(500);
    echo json_encode(array('status' => 'error', 'message' => 'Error al guardar calificacion', 'data' => null));
  }

} elseif($method == 'GET'){
  $idProducto = isset($_GET['idProducto']) ? intval($_GET['idProducto']) : 0;
  if($idProducto <= 0){
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Se requiere idProducto', 'data' => null));
    exit();
  }
  $data = $objApi->promedioCalificacion($idProducto);
  echo json_encode(array('status' => 'ok', 'message' => 'OK', 'data' => $data));

} else {
  http_response_code(405);
  echo json_encode(array('status' => 'error', 'message' => 'Metodo no permitido', 'data' => null));
}
?>
