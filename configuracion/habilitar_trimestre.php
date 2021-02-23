<?
include('../conexiones/conexion.php');
$debug=0;
if($debug==1){
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
}
$trimestre_id=(isset($_GET['id']) && $_GET['id'] != '' ) ? $_GET['id'] : '';
if($trimestre_id!=''){
	pg_query('begin');
	$sql="update trimestres set habilitado_carga=false where habilitado_carga=true";
	if($debug==1)echo $sql.'<br>';
	pg_query($sql);
	$sql="update trimestres set habilitado_carga=true where trimestre_id=$trimestre_id";
	if($debug==1)echo $sql.'<br>';
	if(pg_query($sql)){
		$mandar_email=1;
	}






	if($mandar_email==1){
		//Mando email avisando que ya se puede cargar el trimestre
		$sql="SELECT
					email
				FROM 
					usuarios 
				WHERE
					perfil_id=5";
		if($debug==1) echo $sql;
		$rs=pg_query($sql);
		$email_usuario=pg_fetch_result($rs, 0, 'email');
		pg_free_result($rs);

		$sql="SELECT
					trimestre_id, nombre
			  From
			  		trimestres
			  WHERE 
			  		trimestre_id=$trimestre_id";
		if($debug==1) echo $sql;
		$rs=pg_query($sql);
		$nombre_trimestre=pg_fetch_result($rs, 0, "nombre");

		$emails_administradores="$email_usuario";
		$asunto="Habilitado la carga de trimestre (".$nombre_trimestre.")";

		if($emails_administradores != ''){
		//Email al administrador del sitio
		$headers = "From: SIGV IPCVA\nReply-To: $emails_administradores\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$to=$emails_administradores;
		$asunto=$asunto;
		$cuerpo = "
		<p style='font-family: Arial, Verdana, sans-serif; color: #333'>Estimados: </p>
		<p style='font-family: Arial, Verdana, sans-serif; color: #333'>Ya esta habilitada la carga correspondiente al ".$nombre_trimestre." .</p>
		<p style='font-family: Arial, Verdana, sans-serif; color: #333'>Recuerde de realizar la carga antes del cierre del trimestre.</p>
		<p><a style='font-family: Arial, Verdana, sans-serif; color: #19499e' href='http://www.ipcva.com.ar/sigt/cargas_trimestres/carga_trimestre_alta.php'>Cargar datos</a></p>";
		mail($to, $asunto, $cuerpo, $headers);
		}
	}
	pg_query('commit');
}
if($debug!=1)header('location: trimestres.php');
include('../conexiones/cierre.php');
?>