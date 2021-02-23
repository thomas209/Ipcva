<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($debug==1)echo '<pre>';
if($debug==1)print_r($_POST);
if($debug==1)echo '</pre>';
if($debug==1)echo '<pre>';
if($debug==1)print_r($_SERVER);
if($debug==1)echo '</pre>';

$sector_id=(isset($_POST['sector_id']) && $_POST['sector_id'] != '' ) ? $_POST['sector_id'] : 'NULL';
$nombre=(isset($_POST['nombre']) && $_POST['nombre'] != '' ) ? "'".$_POST['nombre']."'" : 'NULL';
$descripcion=(isset($_POST['descripcion']) && $_POST['descripcion'] != '' ) ? "'".$_POST['descripcion']."'" : 'NULL';

$sql="update sectores set nombre=$nombre, descripcion=$descripcion where sector_id=$sector_id";
if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: sectores.php?error');
	die();
}
else{
	if($debug!=1)header('location: sectores.php');
}
include('../conexiones/cierre.php');
?>