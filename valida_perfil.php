<?
if(isset($perfiles_permitidos)){
	if(!in_array($perfil_id_logueado, $perfiles_permitidos)){
		header('location: /sinpermisos.php');
		exit;		
	}
}
?>