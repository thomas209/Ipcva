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
//empresa
$nombre=(isset($_POST['nombre']) && $_POST['nombre'] != '' ) ? "'".$_POST['nombre']."'" : 'NULL';
$descripcion=(isset($_POST['descripcion']) && $_POST['descripcion'] != '' ) ? "'".$_POST['descripcion']."'" : 'NULL';
$centro_costos_id_padre=(isset($_POST['centro_costos_id_padre']) && $_POST['centro_costos_id_padre'] != '' ) ? $_POST['centro_costos_id_padre'] : 'NULL';
$cuenta_haberes_id=(isset($_POST['cuenta_haberes_id']) && $_POST['cuenta_haberes_id'] != '' ) ? $_POST['cuenta_haberes_id'] : 'NULL';
$cuenta_carga_social_id=(isset($_POST['cuenta_carga_social_id']) && $_POST['cuenta_carga_social_id'] != '' ) ? $_POST['cuenta_carga_social_id'] : 'NULL';
$habilitado=(isset($_POST['habilitado']) && $_POST['habilitado'] != '' ) ? $_POST['habilitado'] : '';

$sql="INSERT into centros_costos 
		(nombre, descripcion, centro_costos_id_padre, cuenta_haberes_id, cuenta_carga_social_id, habilitado)
	values
		($nombre, $descripcion, $centro_costos_id_padre, $cuenta_haberes_id, $cuenta_carga_social_id, $habilitado)";
if($debug==1)echo $sql.'<br>';

if(!pg_query($sql)){
	if($debug!=1)header('location: index.php?error=2&descripcion=clientes');
	die();
}
else{
	if($debug!=1)header('location: index.php');
}
include('../conexiones/cierre.php');
?>