<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$carga_trimestre_id = (isset($_GET['carga_trimestre_id']) && $_GET['carga_trimestre_id'] != '' ) ? $_GET['carga_trimestre_id'] : '';

$sql="SELECT
			 ct.carga_trimestre_id, u.nombre||' '||u.apellido as empleado, t.nombre as trimestre, (select sum(porcentaje) from cargas_trimestres_detalles where carga_trimestre_id=ct.carga_trimestre_id) as porcentaje
		from
			cargas_trimestres ct
		join
			 usuarios u
		on
			ct.usuario_id=u.usuario_id
		join
			 trimestres t
		on 
			ct.trimestre_id=t.trimestre_id
		WHERE
			ct.carga_trimestre_id=$carga_trimestre_id";
if($perfil_id_logueado!=1)$sql.=" and u.usuario_id=$usuario_id_logueado";


$rs=pg_query($sql);
$carga_trimestre_id=pg_fetch_result($rs, 0, 'carga_trimestre_id');
$empleado=pg_fetch_result($rs, 0, 'empleado');
$trimestre=pg_fetch_result($rs, 0, 'trimestre');
$porcentaje=pg_fetch_result($rs, 0, 'porcentaje');
pg_free_result($rs);
///////////////////////////////////
$sql="select ctd.*, '('||cc.nombre||') '||cc.descripcion as centro_costos_nombre, porcentaje from cargas_trimestres_detalles ctd, cargas_trimestres ct, centros_costos cc where ctd.carga_trimestre_id=ct.carga_trimestre_id and ctd.centro_costos_id=cc.centro_costos_id and ctd.carga_trimestre_id=$carga_trimestre_id";
	if($perfil_id_logueado!=1)$sql.=" and ct.usuario_id=$usuario_id_logueado";
	if($debug==1)echo $sql.'<br>';
	$rs=pg_query($sql);
	$contador=pg_num_rows($rs);
	$cargas_trimestres_detalles=pg_fetch_all($rs);
	pg_free_result($rs);


//$sql="SELECT 
//		sum(porcentaje) as porcentajes
//	  FROM 
//	  	cargas_trimestres_detalles
//	  WHERE
//	  	carga_trimestre_detalle_id=$carga_trimestre_detalle_id";
//$rs=pg_query($sql);
//$porcentajes=pg_fetch_result($rs, 0, 'porcentajes');
//pg_free_result($rs);


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
                        <h1 class="page-header">Detalle Carga Trimestre</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-md-6">
						<h3 class="mt-15">Datos:</h3>
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr>
										<td>ID</td>
										<td><?=$carga_trimestre_id?></td>
									</tr>
									<tr>
										<td>Empleado</td>
										<td><?=$empleado?></td>
									</tr>
									<tr>
										<td>Trimestre</td>
										<td><?=$trimestre?></td>
									</tr>
									<tr>
										<td>Porcentaje</td>
										<td><?=$porcentaje?>%</td>
									</tr>
	
									
									
								</tbody>
							</table>
						</div>
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
            </div>
        </div>
    </div>
            <!-- /.container-fluid --> 
   <!-- /#page-wrapper -->

    <!-- Modal -->
	<div class="modal fade" id="modal_nota" tabindex="-1" role="dialog" aria-labelledby="modalNota" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<input type="hidden" name="nota_pedido_id" id="nota_pedido_id" value="<?=$pedido_id?>">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">NOTA</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nota</label>
						<textarea class="form-control" name="nota_texto" id="nota_texto" required rows="8"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" onclick="javascript: guardar_nota();">Guardar</button>
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