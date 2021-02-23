<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$centro_costos_id=$_GET['centro_costos_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM centros_costos WHERE centro_costos_id=$centro_costos_id";
if($debug==1)echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	if($debug!=1)header('location:index.php');
}
else{
	if($debug!=1)header('location:index.php?error=1');
}


include('../conexiones/cierre.php');
?>