<?
$debug=0;
include('includes/isvalidated.php');
include('conexiones/conexion.php');

$ordenar_por=(isset($_REQUEST['orden']) && $_REQUEST['orden'] != '' ) ? $_REQUEST['orden'] : 'trimestre_usado'; 'ct.carga_trimestre_id';
$ordenar_direccion=(isset($_REQUEST['direccion']) && $_REQUEST['direccion'] != '' ) ? $_REQUEST['direccion'] : 'DESC';
/////Trimestre Habilitado/////
$sql="SELECT trimestre_id, nombre, habilitado_carga 
	  FROM 
	  		trimestres 
 	  WHERE 
 	  		habilitado_carga=true";
$rs=pg_query($sql);
$trimestre_activo=pg_fetch_result($rs, 0, 'trimestre_id');
$trimestre_habilitado=pg_fetch_result($rs, 0, 'nombre');
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($trimestre_habilitado);
	echo '</pre>';
}
////////////Cargas////
$sql ="SELECT
			extract(epoch from ct.tstamp) as fecha_unix, ct.carga_trimestre_id, u.nombre||' '||u.apellido as nombre, t.nombre as trimestre, (select sum(porcentaje) from cargas_trimestres_detalles where carga_trimestre_id=ct.carga_trimestre_id) as porcentaje, ct.trimestre_id as trimestre_usado
		from
			cargas_trimestres ct
		JOIN 
			usuarios u
		ON 
			ct.usuario_id=u.usuario_id
		JOIN 
			trimestres t
		ON
			ct.trimestre_id=t.trimestre_id
		where 1=1 ";	
	  if($perfil_id_logueado==5){
		$sql.=" and ct.usuario_id=$usuario_id_logueado order by trimestre_usado desc limit 1 ";
		}
	  if($perfil_id_logueado!=5){
		$sql.=" and ct.trimestre_id=$trimestre_activo order by 
			$ordenar_por $ordenar_direccion";
		}
if($debug==1)echo $sql;
$rs=pg_query($sql);
$detalles_trimestres=pg_fetch_all($rs);
$carga_trimestre_id=pg_fetch_result($rs, 0, 'carga_trimestre_id');
$trimestre_usado=pg_fetch_result($rs, 0, 'trimestre_usado');
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($detalles_trimestres);
	echo '</pre>';
}
//////////////////Detalle de la Carga//////////
if($perfil_id_logueado==5){
	$sql="SELECT ctd.*, '('||cc.nombre||') '||cc.descripcion as centro_costos_nombre, porcentaje from cargas_trimestres_detalles ctd, cargas_trimestres ct, centros_costos cc where ctd.carga_trimestre_id=ct.carga_trimestre_id and ctd.centro_costos_id=cc.centro_costos_id and ctd.carga_trimestre_id=$carga_trimestre_id";
		if($perfil_id_logueado==5)$sql.=" and ct.usuario_id=$usuario_id_logueado";
		if($debug==1)echo $sql.'<br>';
		$rs=pg_query($sql);
		$contador=pg_num_rows($rs);
		$cargas_trimestres_detalles=pg_fetch_all($rs);
		pg_free_result($rs);
}

if($direccion=='desc'){
	$direccion='asc';
}
else{
	$direccion='desc';
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
		<?include('includes/menu.php');?>
        <!-- Page Content -->
        <div id="page-wrapper" class="no-pad">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Inicio</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                    	<?
                    	if($perfil_id_logueado!=5){
                    	?>
                        	<h1 class="page-header">Estado de la carga del <?=$trimestre_habilitado?></h1>
                        <?
                    	}
                    	else{
                    	?>
                    		<h1 class="page-header">Ultimo trimestre cargado</h1>
                    	<?
                    	}
                    	?>
                    </div>
                    <?	
	                    if($perfil_id_logueado==5 && $trimestre_activo!=$trimestre_usado){
	                ?>
	                    <div class="col-md-4 text-right">
							<a href="/sigt/cargas_trimestres/carga_trimestre_alta.php" class="btn btn-success btn-agregar"><i class="fa fa-plus" aria-hidden="true"></i> Carga Trabajos del Trimestre</a>
	                    </div>
                    <?
                    	}
                	?>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
					<div class="col-md-12">
						<div class="alert alert-success alert-dismissable" id="alertSuccess">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<p>Los cambios han sido exitosamente realizados.</p>
						</div>
						<div class="alert alert-danger alert-dismissable" id="alertDanger">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<p><b>Error.</b> <?=$mensaje?></p>
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
										<th class="col-md-4 text-center">Empleado<a href="index.php?ordenar_por=nombre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th class="col-md-4 text-center">Trimestre<a href="index.php?ordenar_por=trimestre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th class="col-md-3 text-center">Porcentaje<a href="index.php?ordenar_por=porcentaje&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<?
										if($perfil_id_logueado==5){
										?>
											<th class="col-md-1 text-center"></th>
										<?
										}
										?>
									</tr>
								</thead>
								<tbody>
								<?
								foreach ($detalles_trimestres as $detalle_trimestre) {
								?>
									<tr>
										<td class="text-center"><?=$detalle_trimestre['nombre']?></td>
										<td class="text-center"><?=$detalle_trimestre['trimestre']?></td>
										<td class="text-center"
										  <?
										  if($detalle_trimestre['porcentaje']!=100){
										  	echo 'style="background-color: red; color: black;"';
										  }
										  ?>
										 ><?=$detalle_trimestre['porcentaje']?>%</td>
										<?
										if($perfil_id_logueado==5 && $detalle_trimestre['trimestre_usado']==$trimestre_activo){
										?>
											<td class="text-center">
												<a href="/sigt/cargas_trimestres/carga_trimestre_editar.php?carga_trimestre_id=<?=$detalle_trimestre['carga_trimestre_id']?>" class="btn btn-success"><i class="sort-btn text-center" aria-hidden="true"></i> Modificar</a>
											</td>
										<?
										}
										elseif($perfil_id_logueado==5){
										?>
											<td></td>
										<?
										}
										?>
									</tr>
								<?
								}
								?>
								</tbody>
							</table>	
						</div>
					</div>
				</div>



			<?
			if($perfil_id_logueado==5){
			?>
				<div class="row">
					<div class="col-md-12">
						<h3 class="mt-15">Detalle:</h3>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thread>
									    <tr>	
										    <th aling="center">Nombre Centro de Costos</th>				    
										    <th aling="center">Porcentaje</th>
									    </tr>
								</thread>
								<tbody>
									<?
									foreach ($cargas_trimestres_detalles as $carga_trimestre_detalle) {
									?>
									<tr>
										<td align="left"><?=$carga_trimestre_detalle['centro_costos_nombre']?></td>
										<td align="center"><?=$carga_trimestre_detalle['porcentaje']?>%</td>
									</tr>
									<?
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?
			}
			?>

                <!-- /.row -->
            </div>
	        <!-- /.row -->
	    </div>
	    <!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->

	</div>
    <!-- /#wrapper -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
	<script src="dist/js/sb-admin-2.js"></script>
	<script src="/js/funciones.js"></script>
</body>
</html>
<? include('conexiones/cierre.php');?>