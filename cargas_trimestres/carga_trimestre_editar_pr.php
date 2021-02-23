<?php
$debug=0;
require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$carga_trimestre_id=(isset($_POST['carga_trimestre_id']) && $_POST['carga_trimestre_id'] != '' ) ? $_POST['carga_trimestre_id'] : '';
if($perfil_id_logueado==5){
	$usuario_id=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? $_POST['usuario_id'] : '';
}
else{
	$usuario_id=$usuario_id_logueado;
}
$contador=(isset($_POST['contador']) && $_POST['contador'] != '' ) ? $_POST['contador'] : 'NULL';
pg_query('begin');
$sql="update cargas_trimestres set tstamp=now() where carga_trimestre_id=$carga_trimestre_id";
if($debug==1)echo $sql.'<br>';
pg_query($sql);
if($debug==1){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}

$sql="delete from cargas_trimestres_detalles where carga_trimestre_id=$carga_trimestre_id";
if($debug==1)echo $sql.'<br>';
pg_query($sql);

for($i=1;$i<=$contador;$i++){
	$centro_costos_id=(isset($_POST['centro_costos_id_fila_'.$i]) && $_POST['centro_costos_id_fila_'.$i] != '' ) ? $_POST['centro_costos_id_fila_'.$i] : '';
	$porcentaje=(isset($_POST['porcentaje_'.$i]) && $_POST['porcentaje_'.$i] != '' ) ? $_POST['porcentaje_'.$i] : '';
	if($centro_costos_id!=''){
		$sql="insert into cargas_trimestres_detalles (carga_trimestre_id, centro_costos_id, porcentaje) values ($carga_trimestre_id, $centro_costos_id, $porcentaje)";
		if($debug==1)echo $sql.'<br>';
		pg_query($sql);
	}
}
pg_query('commit');
if($debug!=1)header('location: index.php');
include("../conexiones/cierre.php");
?>