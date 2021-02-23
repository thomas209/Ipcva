<?php
$debug=0;
require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$usuario_id=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? $_POST['usuario_id'] : '';
$trimestre_id=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? $_POST['trimestre_id'] : '';
$contador=(isset($_POST['contador']) && $_POST['contador'] != '' ) ? $_POST['contador'] : 'NULL';
pg_query('begin');
$sql="insert into cargas_trimestres (usuario_id, trimestre_id) values ($usuario_id, $trimestre_id)";
if($debug==1)echo $sql.'<br>';
pg_query($sql);
if($debug==1){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}
for($i=1;$i<=$contador;$i++){
	$centro_costos_id=(isset($_POST['centro_costos_id_fila_'.$i]) && $_POST['centro_costos_id_fila_'.$i] != '' ) ? $_POST['centro_costos_id_fila_'.$i] : '';
	$porcentaje=(isset($_POST['porcentaje_'.$i]) && $_POST['porcentaje_'.$i] != '' ) ? $_POST['porcentaje_'.$i] : '';
	if($centro_costos_id!=''){
		$sql="insert into cargas_trimestres_detalles (carga_trimestre_id, centro_costos_id, porcentaje) values (currval('carga_trimestres_carga_trimestre_id_seq'), $centro_costos_id, $porcentaje)";
		if($debug==1)echo $sql.'<br>';
		pg_query($sql);
	}
}
pg_query('commit');
if($debug!=1)header('location: index.php');
include("../conexiones/cierre.php");
?>