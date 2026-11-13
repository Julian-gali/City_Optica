<?php
session_start();
include("clases/logica.php");
$objLogica = new Logica();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nombre = $_POST['nombre'];
  $documento = $_POST['documento'];
  $telefono = $_POST['telefono'];
  $email = $_POST['email'];
  $tipoLente = $_POST['tipoLente'];
  $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

  if(count($carrito) == 0){
    header("Location: carrito.php");
    exit();
  }
  
  // Verificar si el cliente existe
  $clienteExiste = $objLogica->validarClienteExiste($email);
  $idCliente = 0;
  
  if(!$clienteExiste){
    // Guardar cliente nuevo
    $objLogica->guardarCliente($nombre, $documento, $telefono, $email, $tipoLente);
  }
  
  // Obtener ID del cliente
  $cliente = $objLogica->obtenerClientePorEmail($email);
  
  if($cliente){
    $idCliente = $cliente['idCliente'];
    
    // Calcular monto total
    $montoTotal = 0;
    foreach($carrito as $item){
      $montoTotal += $item['precio'] * $item['cantidad'];
    }
    
    // Crear el pedido
    $resultadoPedido = $objLogica->crearPedido($idCliente, $montoTotal, 'pendiente');
    
    if($resultadoPedido){
      // Obtener el ID del pedido creado
      $pedido = $objLogica->obtenerUltimoPedido($idCliente);
      
      if($pedido){
        $idPedido = $pedido['idPedido'];
        
        // Crear detalles del pedido para cada producto
        foreach($carrito as $item){
          $objLogica->crearDetallePedido($idPedido, $item['id'], $item['cantidad'], $item['precio']);
        }
      }
    }
    
    unset($_SESSION['carrito']);

    $_SESSION['cliente_id'] = $idCliente;
    $_SESSION['cliente_nombre'] = $nombre;
    $_SESSION['cliente_email'] = $email;
    $_SESSION['pedido_id'] = isset($idPedido) ? $idPedido : 0;
    $_SESSION['pedido_procesado'] = true;
    $_SESSION['mensaje_pedido'] = 'Pedido realizado exitosamente. Nos pondremos en contacto pronto en ' . $email;

    header("Location: confirmacion_pedido.php");
    exit();
  } else {
    header("Location: carrito.php?error=1");
    exit();
  }
} else {
  header("Location: carrito.php");
  exit();
}
?>
