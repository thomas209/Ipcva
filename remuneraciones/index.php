<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$error=isset($_REQUEST['error']) && $_REQUEST['error']? $_REQUEST['error'] : '';
$ordenar_por=(isset($_REQUEST['ordenar_por']) && $_REQUEST['ordenar_por'] != '' ) ? $_REQUEST['ordenar_por'] : 'r.remuneracion_id';
$ordenar_direccion=(isset($_REQUEST['ordenar_direccion']) && $_REQUEST['ordenar_direccion'] != '' ) ? $_REQUEST['ordenar_direccion'] : 'asc';

$sql = "SELECT
			r.remuneracion_id, u.nombre||' '|| u.apellido as usuario, t.nombre as trimestre, r.sueldo, r.cargas_sociales
		FROM
			remuneraciones r, usuarios u, trimestres t
		WHERE 
			r.usuario_id=u.usuario_id AND r.trimestre_id=t.trimestre_id
		ORDER BY $ordenar_por $ordenar_direccion"; 
if($debug==1)echo $sql;
$rs=pg_query($sql);
$remuneraciones=pg_fetch_all($rs);
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($remuneraciones);
	echo '</pre>';
}
if($ordenar_direccion=='desc'){
	$ordenar_direccion='asc';
}
else{
	$ordenar_direccion='desc';
}
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
                   <div class="col-md-8">
                        <h1 class="page-header">Remuneración</h1>
                    </div>
                    
                    <!-- /.col-lg-12 -->
                </div>
                 <div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger alert-dismissable display-n" id="alertDanger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<p><b>Error.</b> Intente de nuevo.</p>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<form name="formulario">
								<thead>
									<tr>
										<th>ID <a href="index.php?ordenar_por=r.remuneracion_id&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a> </th>
										<th>Trimestre<a href="index.php?ordenar_por=trimestre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Empleado<a href="index.php?ordenar_por=usuario&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Sueldo<a href="index.php?ordenar_por=sueldo&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Carga Social<a href="index.php?ordenar_por=cargas_sociales&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Total</th>
										<th></th>
									</tr>
								</thead>
								</form>
								<tbody>
									<?
									foreach ($remuneraciones as $remuneracion){
									?>
									<tr>
										<td><?=$remuneracion['remuneracion_id']?></td>
										<td><?=$remuneracion['trimestre']?></td>
										<td><?=$remuneracion['usuario']?></td>
										<td><?=$remuneracion['sueldo']?></td>
										<td><?=$remuneracion['cargas_sociales']?></td>
										<td><?=$remuneracion['sueldo'] + $remuneracion['cargas_sociales']?></td>
										<td>
											<button type="button" class="btn btn-default btn-opciones" data-toggle="collapse" data-target="#opcion_<?=$remuneracion['remuneracion_id']?>"><i class="fa fa-ellipsis-h"></i></button>
											<div class="collapse opciones" id="opcion_<?=$remuneracion['remuneracion_id']?>">
				                            <a href="remuneraciones_editar.php?remuneracion_id=<?=$remuneracion['remuneracion_id']?>" title="Editar">Editar</a>
											<a href="remuneraciones_detalle.php?remuneracion_id=<?=$remuneracion['remuneracion_id']?>" title="Detalle">Ver</a>
											<a href="remuneraciones_eliminar.php?remuneracion_id=<?=$remuneracion['remuneracion_id']?>" title="Eliminar" onclick="areYouSure()">Eliminar</a>
											</div>
										</td>
									</tr>
									<?
									}
									?>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

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
    	$( document ).ready(function() {
			$('#side-menu > li:nth-child(11) > a').css('background', '#15a857').css('color', '#fff');
			$('#side-menu > li:nth-child(11) > ul > li:nth-child(9) > a').css('background', '#50cb84').css('color', '#fff');
		});

		function areYouSure(){
			var txt;
			var r = confirm('Está seguro de que quiere realizar esta acción?');
			if (r == false) {
				event.preventDefault();
			}
		}
		function check_alta(aform){
			a = aform.nombre;
			if (a.value==""){
				alert ("Debe indicar el nombre de la cultivo");
				a.focus();
				return false;
			}
			return true;
		}

    </script>

</body>
</html>
<? 
if(isset($_REQUEST['error'])){
	if($error==1){
		echo '<script language="javascript">';
		echo '$("#alertDanger").show();';
		echo '</script>';
	}
}
unset($canales);
include('../conexiones/cierre.php');
?>