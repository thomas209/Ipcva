<?
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$sector_id=$_GET['sector_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM sectores WHERE sector_id=$sector_id";
echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	header('location:sectores.php');
}
else{
	header('location:sectores.php?error=1');
}


include('../../conexiones/cierre.php');
?>