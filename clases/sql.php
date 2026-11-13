<?php
class sql
{
//////////////////////////////////////////////////////////////////////////////////////////////
private $cnn;
private $_datosRegistros;
private $_registros;
private $GLOBAL_servidor;
private $GLOBAL_basededatos;
private $GLOBAL_userBD;
private $GLOBAL_claveuserBD;

//////////////////////////////////////////////////////////////////////////////////////////////
public function __construct()
{ 
 $this->GLOBAL_servidor="localhost";
 $this->GLOBAL_basededatos= "cityoptica"; 
 $this->GLOBAL_userBD= "root";
 $this->GLOBAL_claveuserBD="";
 
 
 $this->cnn = new mysqli($this->GLOBAL_servidor, $this->GLOBAL_userBD, $this->GLOBAL_claveuserBD, $this->GLOBAL_basededatos);
 
 // Verificar conexión
 if ($this->cnn->connect_error) {
     die("Conexión fallida: " . $this->cnn->connect_error);
 }
 
 $this->cnn->set_charset("utf8");
}

//////////////////////////////////////////////////////////////////////////////////////////////
// SELECT con retorno de datos
function consultar($sql)
{
$this->_datosRegistros = array();
$result = $this->cnn->query($sql);

$this->_registros = $result->num_rows;
$_SESSION["consultaTotalRegistrosSQL"]=$this->_registros;

if($this->_registros > 0)
 {
   $x = 0;
   $num_fields = mysqli_num_fields($result);
   $this->_datosRegistros = array();
   
   while($row = mysqli_fetch_array($result,MYSQLI_NUM))
    {
	  for($j = 0; $j < $num_fields; $j ++)
	   {
		$name = mysqli_fetch_field_direct($result, $j)->name;
		$this->_datosRegistros[$x][$name] = $row[$j];
	   }
	   
	  $x++;
	}
 }

return $this->_datosRegistros;
}

//////////////////////////////////////////////////////////////////////////////////////////////
// INSERT, DELETE, UPDATE
function sentencia($sql)
{ 
$result = $this->cnn->query($sql);
return $result;
}

//////////////////////////////////////////////////////////////////////////////////////////////
// SELECT que retorna objeto
function sentenciaRetorno($sql)
{ 
return $this->cnn->query($sql);
}

//////////////////////////////////////////////////////////////////////////////////////////////
// Validar cantidad de registros
function validarConsulta($sql)
{
$result = $this->cnn->query($sql);	
$this->_registros = $result->num_rows;
return $result->num_rows;
}

//////////////////////////////////////////////////////////////////////////////////////////////
// Obtener última inserción
function getUltimoID(){
return $this->cnn->insert_id;
}

//////////////////////////////////////////////////////////////////////////////////////////////
// Obtener conexión
function getConexion(){
return $this->cnn;
}

}

