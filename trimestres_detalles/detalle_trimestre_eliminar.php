<?
//require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$usuario_id=$_GET['usuarios'];
$rs=pg_query($sql);
$sql = "DELETE FROM detalles_trimestres WHERE usuario_id=$usuario_id";
echo $sql;

//Ejecuto el query y lo asigno a la variable $rs
if($rs=pg_query($sql)){
	header('location:index.php');
}
else{
	header('location:index.php?error=1');
}


include('../../conexiones/cierre.php');
?>