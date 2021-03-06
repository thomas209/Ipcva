<?
$debug=0;
//require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$detalles_trimestres=$_GET['detalle_trimestre_id'];
$sql="SELECT
			u.nombre||' '||u.apellido as empleados, t.nombre as trimestres, dt.detalle_trimestre_id, ch.nombre as cuentas_haberes, dt.detalle_trimestre_id, cs.nombre as cargas_sociales, porcentaje 
		FROM
			detalles_trimestres dt, usuarios u, trimestres t, cuentas_haberes ch, cuentas_cargas_sociales cs
		WHERE dt.usuario_id=u.usuario_id AND dt.trimestre_id=t.trimestre_id AND dt.detalle_trimestre_id=$detalle_trimestre_id";
$rs=pg_query($sql);
$detalle_trimestre_id=pg_fetch_result($rs, 0, 'detalle_trimestre_id');
$empleados=pg_fetch_result($rs, 0, 'empleados');
$trimestres=pg_fetch_result($rs, 0, 'trimestres');
$porcentaje=pg_fetch_result($rs, 0, 'porcentaje');
$cargas_sociales=pg_fetch_result($rs, 0, 'cargas_sociales');
$cuentas_haberes=pg_fetch_result($rs, 0, 'cuentas_haberes');

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
                        <h1 class="page-header">Detalles del Trimestre</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-md-7">
						<h3 class="mt-15">Datos del Trimestre:</h3>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td>Empleado</td>
										<td><?=$empleados?></td>
									</tr>
									<tr>
										<td>Trimestres</td>
										<td><?=$trimestres?></td>
									</tr>
									<tr>
										<td>Porcentaje</td>
										<td><?=$porcentaje?></td>
									</tr>
									<tr>
										<td>Cargas Sociales</td>
										<td><?=$cargas_sociales?></td>
									</tr>
									<tr>
										<td>Cuentas Haberes</td>
										<td><?=$cuentas_haberes?></td>
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