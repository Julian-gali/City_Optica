<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){ http_response_code(200); exit(); }

include("clases/logica_api.php");
$objApi = new ApiLogica();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
  $productos = $objApi->listarProductos();
  echo json_encode(array(
    'status'  => 'ok',
    'message' => 'Productos listados correctamente',
    'data'    => $productos ? $productos : array()
  ));
} else {
  http_response_code(405);
  echo json_encode(array('status' => 'error', 'message' => 'Metodo no permitido', 'data' => null));
}
?>
