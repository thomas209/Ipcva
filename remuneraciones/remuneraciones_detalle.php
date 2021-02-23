<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$remuneracion_id=$_GET['remuneracion_id'];
$sql="SELECT
			r.remuneracion_id, u.nombre||' '|| u.apellido as usuario, t.nombre as trimestre, r.sueldo, r.cargas_sociales
		FROM
			remuneraciones r, usuarios u, trimestres t
		WHERE 
			r.usuario_id=u.usuario_id AND r.trimestre_id=t.trimestre_id AND r.remuneracion_id=$remuneracion_id";
$rs=pg_query($sql);
$remuneracion_id=pg_fetch_result($rs, 0, 'remuneracion_id');
$usuario=pg_fetch_result($rs, 0, 'usuario');
$trimestre=pg_fetch_result($rs, 0, 'trimestre');
$sueldo=pg_fetch_result($rs, 0, 'sueldo');
$cargas_sociales=pg_fetch_result($rs, 0, 'cargas_sociales');
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
                        <h1 class="page-header">Detalle de la Remuneración</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-md-7">
						<h3 class="mt-15">Datos</h3>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td>Empleado</td>
										<td><?=$usuario?></td>
									</tr>
									<tr>
										<td>Sueldo</td>
										<td><?=$sueldo?></td>
									</tr>
									<tr>
										<td>Cargas Sociales</td>
										<td><?=$cargas_sociales?></td>
									</tr>
									<tr>
										<td>Total</td>
										<td><?=$sueldo + $cargas_sociales?></td>
									</tr>
									<tr>
										<td>Trimestre</td>
										<td><?=$trimestre?></td>
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