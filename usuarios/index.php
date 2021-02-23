<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$error=isset($_REQUEST['error']) && $_REQUEST['error']? $_REQUEST['error'] : '';
$ordenar_por=(isset($_REQUEST['ordenar_por']) && $_REQUEST['ordenar_por'] != '' ) ? $_REQUEST['ordenar_por'] : 'u.usuario_id';
$ordenar_direccion=(isset($_REQUEST['ordenar_direccion']) && $_REQUEST['ordenar_direccion'] != '' ) ? $_REQUEST['ordenar_direccion'] : 'asc';
$habilitado=(isset($_REQUEST['habilitado']) && $_REQUEST['habilitado'] != '' ) ? $_REQUEST['habilitado'] : '';

if($_POST['alta']){
	$nombre=isset($_POST['nombre']) && $_POST['nombre'] ? "'".$_POST['nombre']."'" : 'null';
	$apellido=isset($_POST['apellido']) && $_POST['apellido'] ? "'".$_POST['apellido']."'" : 'null';
	$sector_id=isset($_POST['sector_id']) && $_POST['sector_id'] ? $_POST['sector_id'] : 'null';
	$perfil_id=isset($_POST['perfil_id']) && $_POST['perfil_id'] ? $_POST['perfil_id'] : 'null';
	$email=isset($_POST['email']) && $_POST['email'] ? "'".$_POST['email']."'" : 'null';
	$clave=isset($_POST['clave']) && $_POST['clave'] ? "'".$_POST['clave']."'" : 'null';
	$habilitado=(isset($_POST['habilitado']) && $_POST['habilitado'] != '' ) ? $_POST['habilitado'] : '';
	$sql = "INSERT INTO usuarios (nombre, apellido, sector_id, perfil_id, email, clave, habilitado) VALUES ($nombre, $apellido, $sector_id, $perfil_id, $email, $clave, $habilitado)";
	if($debug==1)echo $sql;
	pg_query($sql);
}
$sql = "SELECT
			u.usuario_id, s.nombre as sector, p.nombre as perfil, u.nombre, u.apellido, u.email, u.habilitado
		FROM
			usuarios u
		LEFT join 
			sectores s
		ON 
			u.sector_id=s.sector_id
		JOIN
			perfiles p
		ON
			u.perfil_id=p.perfil_id
		WHERE 1=1 ";
if($habilitado!='')
	$sql.=" and u.habilitado=$habilitado ";
	$sql.= " ORDER BY $ordenar_por $ordenar_direccion"; 
if($debug==1)echo $sql;
$rs=pg_query($sql);
$usuarios=pg_fetch_all($rs);
pg_free_result($rs);
if($debug==1){
	echo '<pre>';
	print_r($usuarios);
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
                        <h1 class="page-header">Listado de Usuarios</h1>
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
										<th>ID <a href="index.php?ordenar_por=u.usuario_id&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a> </th>
										<th>Nombre<a href="index.php?ordenar_por=u.nombre&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Apellido<a href="index.php?ordenar_por=u.apellido&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Perfil<a href="index.php?ordenar_por=perfil&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Sector<a href="index.php?ordenar_por=sector&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Email<a href="index.php?ordenar_por=u.email&ordenar_direccion=<?=$ordenar_direccion?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a></th>
										<th>Habilitado<a href="index.php?ordenar_por=u.habilitado&ordenar_direccion=<?=$ordenar_direccion?>&habilitado=<?=$habilitado?>"class="sort-btn"><i class="fa fa-sort" aria-hidden="true"></i></a>
											<select class="form-control" name="habilitado" id="habilitado" onchange="this.form.submit();">
													<option value="" <?if($habilitado=='')echo 'selected';?>>Todos</option>
													<option value="true" <?if($habilitado=='true')echo 'selected';?>>Si</option>
													<option value="false" <?if($habilitado=='false')echo 'selected';?>>No</option>
													
											</select>
										</th>
										<th></th>
									</tr>
								</thead>
								</form>
								<tbody>
									<?
									foreach ($usuarios as $usuario){
									?>
									<tr>
										<td><?=$usuario['usuario_id']?></td>
										<td><?=$usuario['nombre']?></td>
										<td><?=$usuario['apellido']?></td>
										<td><?=$usuario['perfil']?></td>
										<td><?=$usuario['sector']?></td>
										<td><?=$usuario['email']?></td>
										<td><?if($usuario['habilitado']=='t'){echo 'SI';} else{echo 'NO';}?></td>
										<td>
											<button type="button" class="btn btn-default btn-opciones" data-toggle="collapse" data-target="#opcion_<?=$usuario['usuario_id']?>"><i class="fa fa-ellipsis-h"></i></button>
											<div class="collapse opciones" id="opcion_<?=$usuario['usuario_id']?>" style="z-index: 100;">
				                            <a href="usuarios_editar.php?usuario_id=<?=$usuario['usuario_id']?>" title="Editar">Editar</a>
											<a href="usuarios_detalle.php?usuario_id=<?=$usuario['usuario_id']?>" title="Detalle">Ver</a>
											<a href="usuarios_eliminar.php?usuario_id=<?=$usuario['usuario_id']?>" title="Eliminar" onclick="areYouSure()">Eliminar</a>
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
                <div class="row">
					<div class="col-md-12">
						<h3 class="page-header">Agregar Usuario</h3>
					</div>
					<div class="col-md-12">
                 		<form method="POST" name="aform" onsubmit="return check_alta(this);">
							<div class="form-group col-md-8">
								<label>Nombre (*):</label>
								<input type="text" class="form-control" name="nombre">
							</div>
							<div class="form-group col-md-8">
								<label>Apellido (*):</label>
								<input type="text" class="form-control" name="apellido">
							</div>
							<div class="form-group col-md-8">
								<label>Email:</label>
								<input type="text" class="form-control" name="email" required>
							</div>
							<div class="form-group col-md-8">
								<label>Clave:</label>
								<input type="text" class="form-control" name="clave" required>
							</div>
							<div class="form-group col-md-8">
								<label>Perfil (*):</label>
								<select name="perfil_id">
									<option value="" disabled>Seleccionar</option>
									<?
									$sql="select perfil_id, nombre from perfiles order by perfil_id";
									$rs=pg_query($sql);
									$perfiles=pg_fetch_all($rs);
									pg_free_result($rs);
									foreach ($perfiles as $perfil) {
									?>
									  <option value="<?=$perfil['perfil_id']?>"><?=$perfil['nombre']?></option>
									<?	
									}
									unset($perfiles);
									?>
								</select>
							</div>
							<div class="form-group col-md-8">
								<label>Sector (*):</label>
								<select name="sector_id">
									<option value="" disabled>Seleccionar</option>
									<?
									$sql="select sector_id, nombre from sectores order by sector_id";
									$rs=pg_query($sql);
									$sectores=pg_fetch_all($rs);
									pg_free_result($rs);
									foreach ($sectores as $sector) {
									?>
										<option value="<?=$sector['sector_id']?>"><?=$sector['nombre']?></option>
									<?	
									}
									unset($sector);
									?>
								</select>
							</div>
							<div class="form-group col-md-8">
								<label>Habilitado</label>
								<input type="radio" name="habilitado" value="true" checked>Si  
								<input type="radio" name="habilitado" value="false">No
							</div>
							<div class="form-group col-md-8">
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
			b = aform.apellido;
			c = aform.email;
			d = aform.clave;
			if (a.value==""){
				alert ("Debe indicar el nombre del Usuario");
				a.focus();
				return false;
			}
			if (b.value==""){
				alert ("Debe indicar el Apellido del Usuario");
				b.focus();
				return false;
			}
			if (c.value==""){
				alert ("Debe indicar el Email del Usuario");
				c.focus();
				return false;
			}
			if (d.value==""){
				alert ("Debe indicar la clave del Usuario");
				d.focus();
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