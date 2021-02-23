<?
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$perfil_id=$_GET['perfil_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM perfiles WHERE perfil_id=$perfil_id";
echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	header('location:perfiles.php');
}
else{
	header('location:perfiles.php?error=1');
}


include('../../conexiones/cierre.php');
?>