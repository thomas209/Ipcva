<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$usuario_id=$_GET['usuario_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM usuarios WHERE usuario_id=$usuario_id";
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