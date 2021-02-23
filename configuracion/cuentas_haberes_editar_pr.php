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

$cuenta_haberes_id=(isset($_POST['cuenta_haberes_id']) && $_POST['cuenta_haberes_id'] != '' ) ? $_POST['cuenta_haberes_id'] : 'NULL';
$nombre=isset($_POST['nombre']) && $_POST['nombre'] ? "'".$_POST['nombre']."'" : 'null';
$descripcion=isset($_POST['descripcion']) && $_POST['descripcion'] ? "'".$_POST['descripcion']."'": 'null';
$habilitada=isset($_POST['habilitada']) && $_POST['habilitada'] ? $_POST['habilitada'] : '';

$sql="UPDATE cuentas_haberes set nombre=$nombre, descripcion=$descripcion, habilitada=$habilitada WHERE cuenta_haberes_id=$cuenta_haberes_id";

if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: cuentas_haberes.php?error=2&descripcion=cuentas_haberes');
	die();
}
else{
	if($debug!=1)header('location: cuentas_haberes.php');
}
include('../conexiones/cierre.php');
?>