<?php
//require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$centro_costos_id=$_GET["centro_costos_id"];
if ($centro_costos_id != ''){
	$sql="SELECT centro_costos_id, nombre, descripcion from centros_costos where centro_costos_id_padre=$centro_costos_id order by nombre";
	$rs=pg_query($sql);
	$retorno = '<option value="">Seleccionar</option>';
	while( $row = pg_fetch_assoc($rs) ){
		$retorno = $retorno . '<option value="'.$row['centro_costos_id'].'">('.htmlentities($row['nombre'], ENT_QUOTES, "UTF8").') '.htmlentities($row['descripcion'], ENT_QUOTES, "UTF8").'</option>';
	}
	//echo ($sql);
	pg_free_result($rs);
	echo $retorno;
}
 include("../conexiones/cierre.php");
?>