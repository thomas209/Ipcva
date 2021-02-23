<?
$debug=0;
require('conexiones/conexion.php');

$recuperaMensaje='';
$error=(isset($_GET['error']) && $_GET['error'] != '' ) ? $_GET['error'] : '';
$retorno=(isset($_GET['retorno']) && $_GET['retorno'] != '' ) ? $_GET['retorno'] : 'index.php';

if(isset($_POST['recupera'])){
	$email=(isset($_POST['email']) && $_POST['email'] != '' ) ? $_POST['email'] : '';
	
	if($email!=''){
		$sql="SELECT email, clave, nombre FROM usuarios where trim(lower(email))=trim(lower('$email')) LIMIT 1";
		//echo $sql.'<br>';
		$rs=pg_query($sql);
		if(pg_num_rows($rs)>0){
			//Valido Ok
			$nombre=pg_fetch_result($rs, 0, 'nombre');
			$clave=pg_fetch_result($rs, 0, 'clave');

			//Email al contacto
			$remitente = "From: www <ipcva@agrolinux3.ipcva.com.ar>\r\n";
			$remitente .= "Content-Type: text/html; charset=utf-8\r\n";
			$destinatario=$email;
			$asunto='Recupere su clave - IPCVA';
			$cuerpo="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><title>Recuperar contraseña</title></head><body><table cellpadding='10' align='center' style='border: 5px solid #ccc' width='600'><tr><td><p style='color:#333333; font-family:Verdana, Geneva, sans-serif; font-size:16px;text-decoration: underline'>Estimado/a $nombre:</p></td></tr><tr><td><p style='color:#333333; font-family:Verdana, Geneva, sans-serif; font-size:15px;'> Recibimos su solicitud de recuperación de clave. Le recordamos que la clave con la cual usted se registro en ipcva.com.ar/sigt es:</p></td></tr><tr><td align='center'> <p style='color:#014a99; font-family:Verdana, Geneva, sans-serif; font-size:15px;'><b>$clave</b></p></td></tr><tr><td align='right'><img src='http://ipcva.com/sigt/img/logo.png' width='100' style='/></td></tr></table></body></html>";
			mail($destinatario, $asunto, $cuerpo, $remitente);
		
			//Lo redirecciono al resultado
			$recuperaMensaje = "Hemos enviado por email la clave. Verifique su casilla de correo electrónico.";
		}
		else{
			echo pg_num_rows($rs);
			echo 'NO Valido<br>';
			//if($debug!=1) header("location: recuperar_clave.php?error=1");
		}
	}
	else{
		//Error no hay usuario
		echo 'No ingresó email';
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?=$title?></title>
	<!-- Bootstrap Core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- MetisMenu CSS -->
	<link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="styles.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div id="wrapper">
		

		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"></a>
			</div>
		</nav>

        <div class="container-fluid" id="login">
			<div class="row" id="divlogin">
            	<div class="col-sm-4 col-sm-offset-4 text-center">

					<form name="datos" action="login_pr.php" method="post">
						<input type="hidden" name="retorno" value="<?=$retorno?>">
						<div class="form-group">
							<label>Email: </label>
							<input type="text" name="email" class="form-control" >
						</div>
						<div class="form-group">
							<label>Clave: </label>
							<input type="password" name="clave" class="form-control" >
						</div>
						<?
						if($error!=''){
							if($error==1){
								$mensaje="<div class='alert alert-info'>Se produjo un error.</div>";
							}
							elseif($error==2){
								$mensaje="<div class='alert alert-info'>Usuario y/o Clave incorrectos</div>";
							}
							else{
								$mensaje="<div class='alert alert-info'>Se produjo un error.</div>";
							}				
							?>	
							<div class="form-group">
								<p class="login-error"><?=$mensaje?></p>
							</div>
						<?
						}
						?>
						<div class="form-group">
							<a role="button" onclick="showRecuperar()">¿Olvidaste tu contraseña?</a>
						</div>
						<div class="form-group">
							<input type="submit" value="Ingresar" name="B1" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
			<div class="row" id="divrecuperar">
				<div class="col-sm-4 col-sm-offset-4 text-center">
					<form name="formrecuperar" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
						<div class="form-group">
							<input type="hidden" name="recupera" value="recupera">
							<label>Ingrese su email: </label>
							<input type="text" name="email" class="form-control">
						</div>
						<div class="form-group">
							<input type="submit" value="Continuar" name="submitemail" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
			<?
			if($recuperaMensaje!==''){
			?>
			<div class="row" id="divEnviado">
				<div class="col-sm-4 col-sm-offset-4 text-center">
					<div class="alert alert-info">
						<p><?=$recuperaMensaje?></p>
					</div>
				</div>
			</div>
			<?
			}
			?>
		</div>

	</div>
	<!-- /#wrapper -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <script type="text/javascript">

    	function showRecuperar(){
    		$('#divlogin').hide();
    		$('#divrecuperar').show(1000);
    	}

    	function showMailSent(){
    		$('#divlogin').hide();
    		$('#divrecuperar').hide();
			$('#divEnviado').show(1000);
    	}

    	$( document ).ready(function() {
			$('#side-menu > li:first-child > a').css('background', '#15a857').css('color', '#fff');
			//valida el password
			$("#altacliente").validate();
			jQuery.extend(jQuery.validator.messages, {
				required: "Por favor complete este campo.",
				remote: "Please fix this field.",
				email: "Ingrese un email válido.",
				url: "Ingrese una URL válida.",
				date: "Ingrese una fecha válida.",
				dateISO: "Ingrese una fecha válida (ISO).",
				number: "Ingrese un número válido",
				digits: "Ingrese sólo dígitos",
				equalTo: "Ingrese nuevamente su email.",
				maxlength: jQuery.validator.format("Por favor ingrese {0} caracteres como máximo."),
				minlength: jQuery.validator.format("Por favor ingrese al menos {0} caracteres."),
				rangelength: jQuery.validator.format("Ingrese entre {0} y {1} caracteres."),
				range: jQuery.validator.format("Ingrese un valor entre {0} y {1}."),
				max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
				min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
			});
		});
    </script>

</body>
</html>
<? include('conexiones/cierre.php');?>