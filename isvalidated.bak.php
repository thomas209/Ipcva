<?
$retorno=isset($_GET['retorno']) && $_GET['retorno'] ? $_GET['email'] : 'index.php';
$validated=$_SESSION['validated'];
$usuario_id_logueado=$_SESSION['usuario_id'];
$perfil_id_logueado=$_SESSION['perfil_id'];
$perfil_nombre_logueado=$_SESSION['perfil'];
$nombre_logueado=$_SESSION['nombre'];
$trimestre_id_activa=$_SESSION['trimestre_id'];
$trimestre_nombre_actual=$_SESSION['trimestre_nombre'];
/*
echo 'Validated: '.$_SESSION['validated'].'<br>';
echo 'usuario_id: '.$_SESSION['usuario_id'].'<br>';
echo 'perfil_id: '.$_SESSION['perfil_id'].'<br>';
echo 'nombre: '.$_SESSION['nombre'].'<br>';
echo 'apellido: '.$_SESSION['apellido'].'<br>';
echo 'zona_id: '.$_SESSION['zona_id'].'<br>';
*/

if($validated!=1 || $usuario_id_logueado=='' || $perfil_id_logueado=='' || $nombre_logueado=='' || $zona_id_logueado==''){
	session_destroy();
	header('location: ../sigt/login.php?retorno='.$retorno);
	exit;
}
?>
