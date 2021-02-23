<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$error=isset($_GET['error']) && $_GET['error']? $_GET['error'] : '';
$ordenar_por=(isset($_GET['ordenar_por']) && $_GET['ordenar_por'] != '' ) ? $_GET['ordenar_por'] : 'sector_id';
$ordenar_direccion=(isset($_GET['ordenar_direccion']) && $_GET['ordenar_direccion'] != '' ) ? $_GET['ordenar_direccion'] : 'asc';
if($_POST['alta']){
	$nombre=isset($_POST['nombre']) && $_POST['nombre'] ? "'".$_POST['nombre']."'" : 'null';
	$descripcion=isset($_POST['descripcion']) && $_POST['descripcion'] ? "'".$_POST['descripcion']."'" : 'null';
	$sql = "INSERT INTO sectores (nombre, descripcion) VALUES ($nombre, $descripcion)";
	if($debug==1)echo $sql;
	pg_query($sql);
}
$sql = "SELECT * FROM sectores ORDER BY $ordenar_por $ordenar_direccion"; 
if($debug==1)echo $sql;
$rs=pg_query($sql);
$sectores=pg_fetch_all($rs);
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($perfiles);
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
                   <div class="col-md-12">
                        <h1 class="page-header">Listado de Sectores</h1>
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
								<thead>
									<tr>
										<input type="hidden" name="orden" value="<?=$orden?>">
										<input type="hidden" name="direccion" value="<?=$direccion?>">
										<th>ID<a href="sectores.php?ordenar_por=sector_id&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Nombre<a href="sectores.php?ordenar_por=nombre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Descripción<a href="sectores.php?ordenar_por=descripcion&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?
									foreach ($sectores as $sector){
									?>
									<tr>
										<td><?=$sector['sector_id']?></td>
										<td><?=$sector['nombre']?></td>
										<td><?=$sector['descripcion']?></td>
										<td>
											<a href="sectores_editar.php?sector_id=<?=$sector['sector_id']?>" title="Editar">Editar</a><span class="vertical-divider"> l </span>
											<a href="sectores_eliminar.php?sector_id=<?=$sector['sector_id']?>" title="Eliminar" onclick="areYouSure()">Eliminar</a>
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
                <div class="row">
					<div class="col-md-12">
						<h3 class="page-header">Agregar Sector</h3>
					</div>
					<div class="col-md-6">
                 		<form method="POST" name="aform" onsubmit="return check_alta(this);">
							<div class="form-group">
								<label>Nombre (*):</label>
								<input type="text" class="form-control" name="nombre">
							</div>
							<div class="form-group">
								<label>Descripción:</label>
								<input type="text" class="form-control" name="descripcion">
							</div>
							<div class="form-group">
								<input type="submit" value="Agregar" class="btn btn-success" name="alta">
							</div>
						</form>
					</div>
				</div>
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
if(isset($_GET['error'])){
	if($error==1){
		echo '<script language="javascript">';
		echo '$("#alertDanger").show();';
		echo '</script>';
	}
}
unset($sectores);
include('../conexiones/cierre.php');
?>