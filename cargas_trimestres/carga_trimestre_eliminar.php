<?php
$debug=0;
require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$carga_trimestre_id=(isset($_GET['carga_trimestre_id']) && $_GET['carga_trimestre_id'] != '' ) ? $_GET['carga_trimestre_id'] : '';
pg_query('begin');
$sql="delete from cargas_trimestres_detalles where carga_trimestre_id=$carga_trimestre_id";
if($debug==1)echo $sql.'<br>';
pg_query($sql);
if($perfil_id_logueado==5){
	$sql="delete from cargas_trimestres where carga_trimestre_id=$carga_trimestre_id and usuario_id=$usuario_id_logueado";
	if($debug==1)echo $sql.'<br>';
}
else{
	$sql="delete from cargas_trimestres where carga_trimestre_id=$carga_trimestre_id";
	if($debug==1)echo $sql.'<br>';	
}
pg_query($sql);
pg_query('commit');
if($debug!=1)header('location: index.php');
include("../conexiones/cierre.php");
?>
