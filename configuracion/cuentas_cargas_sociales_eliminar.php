<?
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$cuenta_carga_social_id=$_GET['cuenta_carga_social_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM cuentas_cargas_sociales WHERE cuenta_carga_social_id=$cuenta_carga_social_id";
echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	header('location:cuentas_cargas_sociales.php');
}
else{
	header('location:cuentas_cargas_sociales.php?error=1');
}


include('../../conexiones/cierre.php');
?>