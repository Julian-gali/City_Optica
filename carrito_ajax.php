<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();
header('Content-Type: application/json');

if(!isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = array();
}

$accion = isset($_POST['accion']) ? $_POST['accion'] : '';
$idProducto = isset($_POST['idProducto']) ? intval($_POST['idProducto']) : 0;

if($accion == 'agregar' && $idProducto > 0){
    $producto = $objLogica->obtenerProducto($idProducto);
    if($producto){
        $encontrado = false;
        for($i = 0; $i < count($_SESSION['carrito']); $i++){
            if($_SESSION['carrito'][$i]['id'] == $idProducto){
                $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
                $_SESSION['carrito'][$i]['cantidad'] += $cantidad;
                $encontrado = true;
                break;
            }
        }
        if(!$encontrado){
            $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
            $_SESSION['carrito'][] = array(
                'id'       => $idProducto,
                'nombre'   => $producto['nombre'],
                'precio'   => floatval($producto['precio']),
                'cantidad' => $cantidad
            );
        }
        echo json_encode(array(
            'status'      => 'ok',
            'message'     => $producto['nombre'] . ' agregado al carrito',
            'total_items' => count($_SESSION['carrito'])
        ));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Producto no encontrado'));
    }

} elseif($accion == 'eliminar' && $idProducto > 0){
    $nuevo = array();
    foreach($_SESSION['carrito'] as $item){
        if($item['id'] != $idProducto) $nuevo[] = $item;
    }
    $_SESSION['carrito'] = $nuevo;
    echo json_encode(array(
        'status'      => 'ok',
        'message'     => 'Producto eliminado',
        'total_items' => count($_SESSION['carrito'])
    ));

} elseif($accion == 'actualizar' && $idProducto > 0){
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
    if($cantidad < 1) $cantidad = 1;
    $subtotal = 0;
    $total    = 0;
    for($i = 0; $i < count($_SESSION['carrito']); $i++){
        if($_SESSION['carrito'][$i]['id'] == $idProducto){
            $_SESSION['carrito'][$i]['cantidad'] = $cantidad;
            $subtotal = $_SESSION['carrito'][$i]['precio'] * $cantidad;
        }
        $total += $_SESSION['carrito'][$i]['precio'] * $_SESSION['carrito'][$i]['cantidad'];
    }
    echo json_encode(array(
        'status'   => 'ok',
        'subtotal' => $subtotal,
        'total'    => $total
    ));

} elseif($accion == 'obtener'){
    echo json_encode(array(
        'status'      => 'ok',
        'carrito'     => $_SESSION['carrito'],
        'total_items' => count($_SESSION['carrito'])
    ));

} else {
    echo json_encode(array('status' => 'error', 'message' => 'Accion no valida'));
}
?>
