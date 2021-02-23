<?
include('../conexiones/conexion.php');
$debug=0;
if($debug==1){
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
}
$trimestre_id=(isset($_GET['id']) && $_GET['id'] != '' ) ? $_GET['id'] : '';
if($trimestre_id!=''){
	pg_query('begin');
	$sql="update trimestres set habilitado_carga=false where trimestre_id=$trimestre_id";
	pg_query($sql);
	pg_query('commit');
}
if($debug!=1)header('location: trimestres.php');
include('../conexiones/cierre.php');
?>