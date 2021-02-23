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

$remuneracion_id=(isset($_POST['remuneracion_id']) && $_POST['remuneracion_id'] != '' ) ? $_POST['remuneracion_id'] : '';
$usuario_id=isset($_POST['usuario_id']) && $_POST['usuario_id'] ? $_POST['usuario_id'] : '';
$trimestre_id=isset($_POST['trimestre_id']) && $_POST['trimestre_id'] ? $_POST['trimestre_id'] : '';
$sueldo=isset($_POST['sueldo']) && $_POST['sueldo'] ? "'".$_POST['sueldo']."'" : 'null';
$cargas_sociales=isset($_POST['cargas_sociales']) && $_POST['cargas_sociales'] ? "'".$_POST['cargas_sociales']."'" : 'null';


$sql="UPDATE remuneraciones set usuario_id=$usuario_id, trimestre_id=$trimestre_id, sueldo=$sueldo, cargas_sociales=$cargas_sociales WHERE remuneracion_id=$remuneracion_id";
if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: index.php?error=2&descripcion=usuarios');
	die();
}
else{
	if($debug!=1)header('location: index.php');
}
include('../conexiones/cierre.php');
?>