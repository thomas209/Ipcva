<?php
$debug=0;
//require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
if($debug==1){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}
$contador=(isset($_POST['contador']) && $_POST['contador'] != '' ) ? $_POST['contador'] : 'NULL';
for($i=1;$i<=$contador;$i++){
	$centro_costos_id=(isset($_POST['centro_costos_id_fila_'.$i]) && $_POST['centro_costos_id_fila_'.$i] != '' ) ? $_POST['centro_costos_id_fila_'.$i] : '';
	$usuario_id=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? $_POST['usuario_id'] : '';
	$trimestre_id=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? $_POST['trimestre_id'] : '';
	$porcentaje=(isset($_POST['porcentaje_'.$i]) && $_POST['porcentaje_'.$i] != '' ) ? $_POST['porcentaje_'.$i] : '';
	if($centro_costos_id!=''){
		$sql="INSERT into detalles_trimestres (centro_costos_id, usuario_id, trimestre_id, porcentaje) 
			  VALUES
				($centro_costos_id, $usuario_id, $trimestre_id, $porcentaje)";
		if($debug==1)echo $sql.'<br>';
		pg_query($sql);
	}
}
if($debug!=1)header('location: index.php');

include("../conexiones/cierre.php");
?>