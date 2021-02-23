<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$error=isset($_REQUEST['error']) && $_REQUEST['error']? $_REQUEST['error'] : '';
$ordenar_por=(isset($_REQUEST['ordenar_por']) && $_REQUEST['ordenar_por'] != '' ) ? $_REQUEST['ordenar_por'] : 'trimestre_usado'; 'ct.carga_trimestre_id';
$ordenar_direccion=(isset($_REQUEST['ordenar_direccion']) && $_REQUEST['ordenar_direccion'] != '' ) ? $_REQUEST['ordenar_direccion'] : 'desc';

$sql="SELECT trimestre_id, nombre, habilitado_carga 
	  FROM 
	  		trimestres 
 	  WHERE 
 	  		habilitado_carga=true";
$rs=pg_query($sql);
$trimestre_activo=pg_fetch_result($rs, 0, 'trimestre_id');
$habilitado_carga=pg_fetch_result($rs, 0, 'habilitado_carga');
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($habilitado_carga);
	echo '</pre>';
}


$sql = "SELECT
			extract(epoch from ct.tstamp) as fecha_unix, ct.carga_trimestre_id, u.nombre||' '||u.apellido as nombre, t.nombre as trimestre, (select sum(porcentaje) from cargas_trimestres_detalles where carga_trimestre_id=ct.carga_trimestre_id) as porcentaje, ct.trimestre_id as trimestre_usado
		from
			cargas_trimestres ct, usuarios u, trimestres t
		where 1=1 ";	
  if($perfil_id_logueado==5){
	$sql.=" and ct.usuario_id=$usuario_id_logueado";
	}
	$sql.=" and ct.usuario_id=u.usuario_id and ct.trimestre_id=t.trimestre_id
		order by 
			$ordenar_por $ordenar_direccion"; 
if($debug==1)echo $sql;
$rs=pg_query($sql);
$cargas_trimestres=pg_fetch_all($rs);
$trimestre_usado=pg_fetch_result($rs, 0, 'trimestre_usado');
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($cargas_trimestres);
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
                        <h1 class="page-header">Listado de Trimestres Cargados</h1>
                    </div>
                    <?	
	                    if($perfil_id_logueado==5 && $trimestre_activo!=$trimestre_usado){
	                ?>
	                    <div class="col-md-4 text-right">
							<a href="carga_trimestre_alta.php" class="btn btn-success btn-agregar"><i class="fa fa-plus" aria-hidden="true"></i> Cargar Datos del Trimestre</a>     
		            	</div>
		            <?
		        	}
		        	elseif($perfil_id_logueado!=5){
		        	?>
		        		<div class="col-md-4 text-right">
							<a href="carga_trimestre_alta.php" class="btn btn-success btn-agregar"><i class="fa fa-plus" aria-hidden="true"></i> Cargar Datos del Trimestre</a>     
		            	</div>
		            <?
		        	}
		        	?>
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
										<th>ID<a href="index.php?ordenar_por=ct.carga_trimestre_id&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Empleado<a href="index.php?ordenar_por=nombre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Trimestre<a href="index.php?ordenar_por=trimestre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Porcentaje<a href="index.php?ordenar_por=porcentaje&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Fecha Carga/Actualización<a href="index.php?ordenar_por=ct.tstamp&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?
									foreach ($cargas_trimestres as $carga_trimestre){
									?>
									<tr>
										<td><?=$carga_trimestre['carga_trimestre_id']?></td>
										<td><?=$carga_trimestre['nombre']?></td>
										<td><?=$carga_trimestre['trimestre']?></td>
										<td
										  <?
										  if($carga_trimestre['porcentaje']!=100){
										  	echo 'style="background-color: red; color: black;"';
										  }
										  ?>
										 ><?=$carga_trimestre['porcentaje']?>%</td>
										<td><?=date('Y-m-d H:i', $carga_trimestre['fecha_unix'])?></td>
										<td>
											<?
											if($perfil_id_logueado!=5){
											?>
												<a href="carga_trimestre_detalle.php?carga_trimestre_id=<?=$carga_trimestre['carga_trimestre_id']?>" title="Detalle">Ver</a><span class="vertical-divider"> l </span>
												<a href="carga_trimestre_editar.php?carga_trimestre_id=<?=$carga_trimestre['carga_trimestre_id']?>" title="Editar">Editar</a><span class="vertical-divider"> l </span>
												<a href="carga_trimestre_eliminar.php?carga_trimestre_id=<?=$carga_trimestre['carga_trimestre_id']?>" title="Eliminar" onclick="areYouSure()">Eliminar</a>
											<?
											}
											else{
											?>
												<a href="carga_trimestre_detalle.php?carga_trimestre_id=<?=$carga_trimestre['carga_trimestre_id']?>" title="Detalle">Ver</a>
											</div>
											<?
											}
											?>
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