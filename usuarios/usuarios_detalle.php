<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($perfil_id_logueado==1){
	$usuario_id=(isset($_GET['usuario_id']) && $_GET['usuario_id'] != '' ) ? intval($_GET['usuario_id']) : 'NULL';
}
else{
	$usuario_id=$usuario_id_logueado;
}



$sql="SELECT
			u.usuario_id, s.nombre as sector, p.nombre as perfil, u.nombre, u.apellido, u.habilitado
		FROM
			usuarios u, sectores s, perfiles p
		WHERE 
			u.sector_id=s.sector_id AND u.perfil_id=p.perfil_id AND u.usuario_id=$usuario_id";
$rs=pg_query($sql);
$usuario_id=pg_fetch_result($rs, 0, 'usuario_id');
$nombre=pg_fetch_result($rs, 0, 'nombre');
$apellido=pg_fetch_result($rs, 0, 'apellido');
$sector=pg_fetch_result($rs, 0, 'sector');
$perfil=pg_fetch_result($rs, 0, 'perfil');
$habilitado=pg_fetch_result($rs, 0, 'habilitado');
pg_free_result($rs);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?=$title?></title>
	<!-- Bootstrap Core CSS -->
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- MetisMenu CSS -->
	<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="../styles.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div id="wrapper">
		<?include('../includes/menu.php');?>
        <!-- Page Content -->
        <div id="page-wrapper" class="distribuidores">
            <div class="container-fluid">
                <div class="row">
                   <div class="col-md-9">
                        <h1 class="page-header">Detalles del Usuario</h1>
                    </div>
                    <?
                    if($perfil_id==1){
                    ?>
	                    <div class="col-md-3 text-right">
							<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
	                    </div>
	                <?
	            	}
	            	else{
	            	?>
	            		<div class="col-md-3 text-right">
							<a href="usuarios_editar.php?usuario_id=<?=$usuario_id?>" class="btn btn-success btn-agregar"> Editar</a>
                    	</div>
                    <?
                	}
                	?>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-md-7">
						<h3 class="mt-15">Datos del Usuario:</h3>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td>Nombre</td>
										<td><?=$nombre?></td>
									</tr>
									<tr>
										<td>Apellido</td>
										<td><?=$apellido?></td>
									</tr>
									<tr>
										<td>Sector</td>
										<td><?=$sector?></td>
									</tr>
									<tr>
										<td>Perfil</td>
										<td><?=$perfil?></td>
									</tr>
									<tr>
										<td>Habilitado</td>
										<td><?if ($habilitado ='t'){echo 'SI';} else {echo 'NO';}?></td>
									</tr>
								</tbody>
							</table>
						</div>
             		</div>
             	</div>
        	</div>
        </div>
    </div>
    <!-- /#wrapper -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script type="text/javascript">
		function checkForm(){

		}

    </script>
</body>
</html>
<? 
if(isset($_GET['error'])){
	if($error==0){
		echo '<script language="javascript">';
		echo '$("#alertSuccess").show();';
		echo '</script>';
	}elseif($error==1){
		echo '<script language="javascript">';
		echo '$("#alertDanger").show();';
		echo '</script>';
	}
}
include('../conexiones/cierre.php');
?>