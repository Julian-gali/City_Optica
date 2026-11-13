<?php
class sql
{
private $cnn;
private $_datosRegistros;
private $_registros;
private $GLOBAL_servidor;
private $GLOBAL_basededatos;
private $GLOBAL_userBD;
private $GLOBAL_claveuserBD;

public function __construct()
{
 $this->GLOBAL_servidor     = "localhost";
 $this->GLOBAL_basededatos  = "cityoptica";
 $this->GLOBAL_userBD       = "root";
 $this->GLOBAL_claveuserBD  = "";

 $this->cnn = new mysqli(
   $this->GLOBAL_servidor,
   $this->GLOBAL_userBD,
   $this->GLOBAL_claveuserBD,
   $this->GLOBAL_basededatos
 );

 if($this->cnn->connect_error){
   http_response_code(500);
   echo json_encode(array('status' => 'error', 'message' => 'Error de conexion a la base de datos', 'data' => null));
   exit();
 }

 $this->cnn->set_charset("utf8");
}

function consultar($sql)
{
  $result = $this->cnn->query($sql);
  $this->_registros = $result->num_rows;
  if($this->_registros > 0){
    $x = 0;
    $num_fields = mysqli_num_fields($result);
    $this->_datosRegistros = array();
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
      for($j = 0; $j < $num_fields; $j++){
        $name = mysqli_fetch_field_direct($result, $j)->name;
        $this->_datosRegistros[$x][$name] = $row[$j];
      }
      $x++;
    }
  } else {
    $this->_datosRegistros = array();
  }
  return $this->_datosRegistros;
}

function sentencia($sql)
{
  return $this->cnn->query($sql);
}

function getUltimoID()
{
  return $this->cnn->insert_id;
}

function getConexion()
{
  return $this->cnn;
}

}
?>
