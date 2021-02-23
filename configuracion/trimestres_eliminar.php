<?
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$trimestre_id=$_GET['trimestre_id'];
$rs=pg_query($sql);
$sql = "DELETE FROM trimestres WHERE trimestre_id=$trimestre_id";
echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	header('location:trimestres.php');
}
else{
	header('location:trimestres.php?error=1');
}


include('../../conexiones/cierre.php');
?>