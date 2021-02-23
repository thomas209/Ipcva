<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$remuneracion_id=$_GET['remuneracion_id'];

$sql="SELECT
		remuneracion_id, usuario_id, trimestre_id, sueldo, cargas_sociales
	  FROM
	   	remuneraciones
	  WHERE
	   remuneracion_id=$remuneracion_id";

$rs=pg_query($sql);
$remuneracion_id=pg_fetch_result($rs, 0, 'remuneracion_id');
$usuario_id=pg_fetch_result($rs, 0, 'usuario_id');
$trimestre_id=pg_fetch_result($rs, 0, 'trimestre_id');
$sueldo=pg_fetch_result($rs, 0, 'sueldo');
$cargas_sociales=pg_fetch_result($rs, 0, 'cargas_sociales');
pg_free_result($rs);
if($debug==1) echo $sql;

$sql="SELECT usuario_id, nombre||' '|| apellido as empleado from usuarios order by empleado";
$rs=pg_query($sql);
$usuarios=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT trimestre_id, nombre from trimestres order by nombre";
$rs=pg_query($sql);
$trimestres=pg_fetch_all($rs);
pg_free_result($rs)
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
                        <h1 class="page-header">Remuneracion</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<form name="pedidosmodificar" id="pedidosmodificar" method="POST" action="remuneraciones_editar_pr.php" onsubmit="checkForm()">
	                <input type="hidden" name="remuneracion_id" value="<?=$remuneracion_id?>">
	                <div class="row no-mar">
						<div class="col-md-12">
							<h3 class="mt-15">Modificar</h3>
							<div class="form-group col-md-3">
								<label>Empleado</label>
									<select name="usuario_id" class="form-control" readonly>
										<option value="">Selecciona</option>
										<?
										foreach ($usuarios as $usuario) {
											if ($usuario['usuario_id']==$usuario_id){
												$selected='selected';
											}
											else{
												$selected='';
											}
											echo "<option value=\"{$usuario['usuario_id']}\" $selected>{$usuario['empleado']}</option>";
										}
										?>
									</select>
							</div>
							<div class="form-group col-md-3">
								<label>Trimestre</label>
								<select name="trimestre_id" class="form-control" readonly>
									<option value="">Selecciona</option>
									<?
									foreach ($trimestres as $trimestre) {
										if($trimestre['trimestre_id']==$trimestre_id){
											$selected='selected';
										}
										else{
											$selected='';
										}
										echo "<option value=\"{$trimestre['trimestre_id']}\" $selected>{$trimestre['nombre']}</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label>sueldo</label>
								<input type="text" class="form-control" name="sueldo" id="sueldo" value="<?=$sueldo?>">	
							</div>
							<div class="form-group col-md-3">
								<label>Carga Social</label>
								<input type="text" class="form-control" name="cargas_sociales" id="cargas_sociales" value="<?=$cargas_sociales?>">
							</div>
						</div>
						</div>
					</div>
					<div class="row no-mar">
						<div class="row no-mar text-center mb-50">
						<input type="submit" class="btn btn-success mt-15 btn-lg" value="Modificar">
						</div>
					</div>
               <!-- /.row -->
                </form>
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