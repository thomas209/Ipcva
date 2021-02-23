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

$trimestre_id=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? $_POST['trimestre_id'] : 'NULL';
$nombre=(isset($_POST['nombre']) && $_POST['nombre'] != '' ) ? "'".$_POST['nombre']."'" : 'NULL';
$habilitado_carga=(isset($_POST['habilitado_carga']) && $_POST['habilitado_carga'] != '' ) ? "'".$_POST['habilitado_carga']."'" : 'NULL';

$sql="update trimestres set nombre=$nombre, habilitado_carga=$habilitado_carga where trimestre_id=$trimestre_id";
if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: trimestres.php?error=2&descripcion=clientes');
	die();
}
else{
	if($debug!=1)header('location: trimestres.php');
}
include('../conexiones/cierre.php');
?>