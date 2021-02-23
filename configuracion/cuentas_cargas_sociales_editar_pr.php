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

$cuenta_carga_social_id=(isset($_POST['cuenta_carga_social_id']) && $_POST['cuenta_carga_social_id'] != '' ) ? $_POST['cuenta_carga_social_id'] : 'NULL';
$nombre=(isset($_POST['nombre']) && $_POST['nombre'] != '' ) ? "'".$_POST['nombre']."'" : 'NULL';
$descripcion=(isset($_POST['descripcion']) && $_POST['descripcion'] != '' ) ? "'".$_POST['descripcion']."'" : 'NULL';
$habilitada=(isset($_POST['habilitada']) && $_POST['habilitada'] != '' ) ? $_POST['habilitada'] : '';

$sql="update cuentas_cargas_sociales set nombre=$nombre, habilitada=$habilitada, descripcion=$descripcion where cuenta_carga_social_id=$cuenta_carga_social_id";
if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: cuentas_cargas_sociales.php?error=2&descripcion=clientes');
	die();
}
else{
	if($debug!=1)header('location: cuentas_cargas_sociales.php');
}
include('../conexiones/cierre.php');
?>