<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($debug==1)echo '<pre>';
if($debug==1)print_r($_POST);
if($debug==1)echo '</pre>';
if($debug==1)echo '<pre>';
if($debug==1)print_r($_SERVER);
if($debug==1)echo '</pre>';
if($perfil_id_logueado==1){
	$usuario_id=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? intval($_POST['usuario_id']) : 'NULL';
}
else{
	$usuario_id=$usuario_id_logueado;
}
$nombre=isset($_POST['nombre']) && $_POST['nombre'] ? "'".$_POST['nombre']."'" : 'null';
$apellido=isset($_POST['apellido']) && $_POST['apellido'] ? "'".$_POST['apellido']."'" : 'null';
$email=isset($_POST['email']) && $_POST['email'] ? "'".$_POST['email']."'" : 'null';
$clave=isset($_POST['clave']) && $_POST['clave'] ? "'".$_POST['clave']."'" : 'null';
$habilitado=isset($_POST['habilitado']) && $_POST['habilitado'] ? $_POST['habilitado']: 'null';
$sector_id=isset($_POST['sector_id']) && $_POST['sector_id'] ? $_POST['sector_id'] : 'null';
$perfil_id=isset($_POST['perfil_id']) && $_POST['perfil_id'] ? $_POST['perfil_id'] : 'null';

$sql="UPDATE usuarios set nombre=$nombre, apellido=$apellido, email=$email, habilitado=$habilitado, perfil_id=$perfil_id, sector_id=$sector_id, clave=$clave WHERE usuario_id=$usuario_id";

if($debug==1)echo $sql.'<br>';
if(!pg_query($sql)){
	if($debug!=1)header('location: index.php?error=2&descripcion=usuarios');
	die();
}
elseif($perfil_id_logueado==5){
	if($debug!=1)header("location: usuarios_detalle.php?usuario_id=".$usuario_id_logueado);
}
else{
	if($debug!=1)header('location: index.php');	
}
include('../conexiones/cierre.php');
?>