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

$perfil_id=(isset($_POST['perfil_id']) && $_POST['perfil_id'] != '' ) ? $_POST['perfil_id'] : 'NULL';
$nombre=(isset($_POST['nombre']) && $_POST['nombre'] != '' ) ? "'".$_POST['nombre']."'" : 'NULL';
$descripcion=(isset($_POST['descripcion']) && $_POST['descripcion'] != '' ) ? "'".$_POST['descripcion']."'" : 'NULL';

$sql="update perfiles set nombre=$nombre, descripcion=$descripcion where perfil_id=$perfil_id";
if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: perfiles.php?error=2&descripcion=clientes');
	die();
}
else{
	if($debug!=1)header('location: perfiles.php');
}
include('../conexiones/cierre.php');
?>