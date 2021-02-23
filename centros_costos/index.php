<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$error=isset($_REQUEST['error']) && $_REQUEST['error']? $_REQUEST['error'] : '';
$ordenar_por=(isset($_REQUEST['ordenar_por']) && $_REQUEST['ordenar_por'] != '' ) ? $_REQUEST['ordenar_por'] : 'cc.centro_costos_id';
$ordenar_direccion=(isset($_REQUEST['ordenar_direccion']) && $_REQUEST['ordenar_direccion'] != '' ) ? $_REQUEST['ordenar_direccion'] : 'asc';
$habilitado=(isset($_REQUEST['habilitado']) && $_REQUEST['habilitado'] != '' ) ? $_REQUEST['habilitado'] : '';
$nombres=(isset($_REQUEST['centro_costos_id']) && $_REQUEST['centro_costos_id'] != '' ) ? $_REQUEST['centro_costos_id'] : '';
$nombre_descripcion=(isset($_REQUEST['nombre_descripcion']) && $_REQUEST['nombre_descripcion'] != '' ) ? $_REQUEST['nombre_descripcion'] : '';


$sql = "SELECT
			cc.centro_costos_id, ch.nombre as cuenta_haberes, cs.nombre as carga_sociales, cc.nombre, cc.descripcion, cc.habilitado
		FROM
			centros_costos cc
		LEFT JOIN
			cuentas_haberes ch
		ON
			cc.cuenta_haberes_id=ch.cuenta_haberes_id
		LEFT JOIN
			cuentas_cargas_sociales cs
		ON 
			cc.cuenta_carga_social_id=cs.cuenta_carga_social_id
		WHERE 1=1 ";

if($habilitado!=''){
	$sql.=" and cc.habilitado=$habilitado";
}
if($nombres!=''){
	$sql.=" and cc.centro_costos_id=$nombres";
}
if($nombre_descripcion!=''){
	$sql.=" and cc.descripcion ilike '%$nombre_descripcion%'";
}
	$sql.="	ORDER BY $ordenar_por $ordenar_direccion"; 
if($debug==1)echo $sql;
$rs=pg_query($sql);
$centro_costos=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT centro_costos_id, nombre FROM centros_costos order by nombre";
$rs=pg_query($sql);
$costo_nombre=pg_fetch_all($rs);
pg_free_result($rs);

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
                        <h1 class="page-header">Centros de Costos</h1>
                    </div>
                    <?
                    if($perfil_id_logueado==1 || $perfil_id_logueado==4){
                    ?>
	                    <div class="col-md-4 text-right">
							<a href="centro_costos_alta.php" class="btn btn-success btn-agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Centro de Costos</a>
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
									 <form name="filtros_listado" method="post" id="filtros_listado" method="post" action="index.php">
										<input type="hidden" name="orden" value="<?=$orden?>">
										<input type="hidden" name="direccion" value="<?=$direccion?>">
										<th>ID <a href="index.php?ordenar_por=cc.centro_costos_id&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre=<?=$nombre?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a> </th>
										<th>Nombre<a href="index.php?ordenar_por=cc.nombre&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a>
											<select class="form-control" name="centro_costos_id" id="centro_costos_id" onchange="this.form.submit();">
												<option value="">Todos</option>
												<?
												foreach ($costo_nombre as $nombre) {
													if($nombres==$nombre['centro_costos_id']){
														$selected='selected';															
													}
													else{
														$selected='';
														}
														echo "<option value=\"{$nombre['centro_costos_id']}\" $selected>{$nombre['nombre']}</option>";
												}
												?>
											</select>
										</th>
										<th>
											Descripcion<a href="index.php?ordenar_por=cc.descripcion&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre=<?=$nombre?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a><br>

											<input type="text" name="nombre_descripcion" id="nombre_descripcion" value="<?=$nombre_descripcion?>"><button type="submit" form="filtros_listado" value="Submit">Buscar</button><input type="button" onclick="location.href='index.php';" value="Limpiar" />
										</th>
										<th>Haberes<a href="index.php?ordenar_por=cuenta_haberes&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre=<?=$nombre?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Cargas Sociales<a href="index.php?ordenar_por=carga_sociales&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre=<?=$nombre?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Habilitado<a href="index.php?ordenar_por=cc.habilitado&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>&nombre=<?=$nombre?>&nombre_descripcion=<?=$nombre_descripcion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a>
											<select class="form-control" name="habilitado" id="habilitado" onchange="this.form.submit();">
													<option value="" <?if($habilitado=='')echo 'selected';?>>Todos</option>
													<option value="true" <?if($habilitado=='true')echo 'selected';?>>Si</option>
													<option value="false" <?if($habilitado=='false')echo 'selected';?>>No</option>
													
											</select>
										</th>
										<?
										if($perfil_id_logueado==1 || $perfil_id_logueado==4){
										?>
											<th></th>
										<?
										}
										?>
									</form>
									</tr>
								</thead>
								<tbody>
									<?
									foreach ($centro_costos as $centro_costo){
									?>
									<tr>
										<td><?=$centro_costo['centro_costos_id']?></td>
										<td><?=$centro_costo['nombre']?></td>
										<td><?=$centro_costo['descripcion']?></td>
										<td><?=$centro_costo['cuenta_haberes']?></td>
										<td><?=$centro_costo['carga_sociales']?></td>
										<td><?if($centro_costo['habilitado']=='t'){echo 'SI';} else{echo 'NO';}?></td>
										<?
										 if($perfil_id_logueado==1 || $perfil_id_logueado==4){
										?>
										  <td>
											<button type="button" class="btn btn-default btn-opciones" data-toggle="collapse" data-target="#opcion_<?=$centro_costo['centro_costos_id']?>"><i class="fa fa-ellipsis-h"></i></button>
											<div class="collapse opciones" id="opcion_<?=$centro_costo['centro_costos_id']?>">
				                            	<a href="centro_costos_editar.php?centro_costos_id=<?=$centro_costo['centro_costos_id']?>" title="Editar">Editar</a>
												<a href="centro_costos_eliminar.php?centro_costos_id=<?=$centro_costo['centro_costos_id']?>" title="Eliminar" onclick="areYouSure()">Eliminar</a>
											</div>
										  </td>
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