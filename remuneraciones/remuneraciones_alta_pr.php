<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($debug==1)echo '<pre>';
if($debug==1)print_r($_POST);
if($debug==1)echo '</pre>';
if($debug==1)echo '<pre>';
if($debug==2)print_r($_SERVER);
if($debug==1)echo '</pre>';
//empresa
pg_query('begin');

$trimestre_id=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? $_POST['trimestre_id'] : '';
$contador=(isset($_POST['contador']) && $_POST['contador'] != '' ) ? $_POST['contador'] : 'NULL';

if($contador!=''){
	for($i=1; $i<=$contador; $i++){
		$usuario_id=(isset($_POST['usuario_id_'.$i]) && $_POST['usuario_id_'.$i] != '') ? $_POST['usuario_id_'.$i] : '';
		$sueldo=(isset($_POST['sueldo_'.$i]) && $_POST['sueldo_'.$i] != '') ? $_POST['sueldo_'.$i] : '';
		$cargas_sociales=(isset($_POST['cargas_sociales_'.$i]) && $_POST['cargas_sociales_'.$i] != '') ? $_POST['cargas_sociales_'.$i] : '';
		if($sueldo!=''){
			$sql="INSERT into remuneraciones (trimestre_id, usuario_id, sueldo, cargas_sociales) values ($trimestre_id, $usuario_id, $sueldo, $cargas_sociales)";
			if($debug==1)echo $sql.'<br>';
			pg_query($sql);
		}
	}
}

pg_query('commit');
if($debug!=1)header('location: index.php');
include('../conexiones/cierre.php');
?>