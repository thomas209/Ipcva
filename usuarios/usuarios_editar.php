<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
if($perfil_id_logueado==1){
	$usuario_id=(isset($_GET['usuario_id']) && $_GET['usuario_id'] != '' ) ? intval($_GET['usuario_id']) : 'NULL';
}
else{
	$usuario_id=$usuario_id_logueado;
}

$sql="SELECT
		usuario_id, nombre, apellido, habilitado, sector_id, perfil_id, email, clave
	  FROM
	   	usuarios
	  WHERE
	   usuario_id=$usuario_id";
if($debug==1)echo $sql.'<br>';
$rs=pg_query($sql);
$usuario_id=pg_fetch_result($rs, 0, 'usuario_id');
$nombre=pg_fetch_result($rs, 0, 'nombre');
$apellido=pg_fetch_result($rs, 0, 'apellido');
$email=pg_fetch_result($rs, 0, 'email');
$habilitado=pg_fetch_result($rs, 0, 'habilitado');
$perfil_id=pg_fetch_result($rs, 0, 'perfil_id');
$sector_id=pg_fetch_result($rs, 0, 'sector_id');
$clave=pg_fetch_result($rs, 0, 'clave');
pg_free_result($rs);

$sql="SELECT perfil_id, nombre from perfiles order by nombre";
$rs=pg_query($sql);
$perfiles=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT sector_id, nombre from sectores order by nombre";
$rs=pg_query($sql);
$sectores=pg_fetch_all($rs);
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
                        <h1 class="page-header">Modificación de Usuarios</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<form name="usuariosmodificar" id="usuariosmodificar" method="POST" action="usuarios_editar_pr.php" onsubmit="this.submit()">
	                <input type="hidden" name="usuario_id" value="<?=$usuario_id?>">
	                <div class="row no-mar">
						<div class="col-md-12">
							<h3 class="mt-15">Modificar</h3>
							<div class="form-group col-md-4">
								<label>Nombre</label>
								<input type="text" class="form-control" name="nombre" id="nombre" value="<?=$nombre?>">	
							</div>
							<div class="form-group col-md-4">
								<label>Apellido</label>
								<input type="text" class="form-control" name="apellido" id="apellido" value="<?=$apellido?>">
							</div>
							<div class="form-group col-md-4">
								<label>Perfil</label>
									<select name="perfil_id" class="form-control">
										<option value="">Selecciona</option>
										<?
										foreach ($perfiles as $perfil) {
											if ($perfil['perfil_id']==$perfil_id){
												$selected='selected';
											}
											else{
												$selected='';
											}
											echo "<option value=\"{$perfil['perfil_id']}\" $selected>{$perfil['nombre']}</option>";
										}
										?>
									</select>
							</div>
							<div class="form-group col-md-4">
								<label>Sector</label>
								<select name="sector_id" class="form-control">
									<option value="">Selecciona</option>
									<?
									foreach ($sectores as $sector) {
										if($sector['sector_id']==$sector_id){
											$selected='selected';
										}
										else{
											$selected='';
										}
										echo "<option value=\"{$sector['sector_id']}\" $selected>{$sector['nombre']}</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label>Email:</label>
								<input type="text" class="form-control" name="email" id="email" value="<?=$email?>">
							</div>
							<div class="form-group col-md-4">
								<label>Clave:</label>
								<input type="text" class="form-control" name="clave" id="clave" value="<?=$clave?>">
							</div>
							<div class="form-group col-md-4">
								<label>Habilitado</label>
								<input type="radio" name="habilitado" value="true" <?if($habilitado=='t')echo 'checked'?>>Si  
								<input type="radio" name="habilitado" value="false" <?if($habilitado=='f')echo 'checked'?>>No
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
		

    </script>
<script TYPE="text/javascript">
    var formulario = document.getElementById("usuariosmodificar"),
    falta_dato = true;
 
formulario.addEventListener("submit", function(event){
    event.preventDefault();
 
    var elementos = this.elements;
    for (var i in elementos){
        if (!elementos[i].value.length){
            alert("Debe de completar el campo " + elementos[i].name);
            falta_dato = false;
            break;
            return falta_dato;
        }

    }

 
    if (falta_dato){
        this.submit();
    }
}, true);
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