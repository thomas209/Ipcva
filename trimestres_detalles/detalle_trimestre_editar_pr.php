<?
$debug=0;
//require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($debug==1)echo '<pre>';
if($debug==1)print_r($_POST);
if($debug==1)echo '</pre>';
if($debug==1)echo '<pre>';
if($debug==1)print_r($_SERVER);
if($debug==1)echo '</pre>';
//empresa
$detalle_trimestres_id=(isset($_POST['detalle_trimestres_id']) && $_POST['detalle_trimestres_id'] != '' ) ? $_POST['detalle_trimestres_id'] : 'NULL';
$empleados=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? "'".$_POST['usuario_id']."'" : 'NULL';
$trimestres=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? "'".$_POST['trimestre_id']."'" : 'NULL';
$centro_costos=(isset($_POST['centro_costos_id']) && $_POST['centro_costos_id'] != '' ) ? $_POST['centro_costos_id'] : 'NULL';
$porcentaje=(isset($_POST['porcentaje']) && $_POST['porcentaje'] != '' ) ? $_POST['porcentaje'] : 'NULL';


$sql="UPDATE detalles_trimestres 
		set empleados=$empleados, trimestres_id=$trimestres_id, centro_costos_id=$centro_costos_id, porcentaje=$porcentaje where detalle_trimestre_id=$detalle_trimestre_id";
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