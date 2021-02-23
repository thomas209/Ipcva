<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$cuenta_haberes_id=$_GET['cuenta_haberes_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM cuentas_haberes WHERE cuenta_haberes_id=$cuenta_haberes_id";
if($debug==1)echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	if($debug!=1)header('location:cuentas_haberes.php');
}
else{
	if($debug!=1)header('location:cuentas_haberes.php?error=1');
}


include('../conexiones/cierre.php');
?>