<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$carga_trimestre_id=(isset($_GET['id']) && $_GET['id'] != '' ) ? intval($_GET['id']) : '';

if($carga_trimestre_id!=''){
	$sql="SELECT * from cargas_trimestres where carga_trimestre_id=$carga_trimestre_id";
	if($perfil_id_logueado==5)$sql.=" and usuario_id=$usuario_id_logueado";
	$rs=pg_query($sql);
	$usuario_id=pg_fetch_result($rs, 0, 'usuario_id');
	$carga_trimestre=pg_fetch_assoc($rs);
	pg_free_result($rs);
	
	$sql="select ctd.* from cargas_trimestres_detalles ctd where ctd.carga_trimestre_id=ct.carga_trimestre_id and ctd.carga_trimestre_id=$carga_trimestre_id";
	if($perfil_id_logueado==5)$sql.=" and ct.usuario_id=$usuario_id_logueado";
	$rs=pg_query($sql);
	$contador=pg_num_rows($rs);
	$cargas_trimestres_detalles=pg_fetch_all($rs);
	pg_free_result($rs);
}

$sql="SELECT usuario_id, nombre||' '|| apellido as empleado from usuarios WHERE usuario_id=$usuario_id order by empleado";
$rs=pg_query($sql);
$usuario=pg_fetch_result($rs, 0, 'empleado');
pg_free_result($rs);

$sql="SELECT centro_costos_id, nombre, descripcion FROM centros_costos WHERE habilitado=true AND centro_costos_id_padre is NULL ORDER BY nombre";
$rs=pg_query($sql);
$centros_costos=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT trimestre_id, nombre FROM trimestres WHERE habilitado_carga=true order by trimestre_id desc limit 1";
$rs=pg_query($sql);
$trimestre_id=pg_fetch_result($rs, 0, 'trimestre_id');
$trimestre=pg_fetch_result($rs, 0, 'nombre');
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
                        <h1 class="page-header">Edición de cargas de trabajo</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
              <form name="editartrimestre" id="editartrimestre" method="POST" action="carga_trimestre_editar_pr.php" onsubmit="return checkForm();">
				<div class="row no-mar">
					<div class="col-md-12">
						<input type="hidden" name="contador" id="contador" value="<?=$contador?>">
						<input type="hidden" name="accion" value="insertar">
						<h3 class="mt-15">Datos</h3>

					 <div class="form-group col-md-4">
						<label>empleado</label>
							<input type="text" class="form-control" name="usuario_id" id="usuario_id" value="<?=$usuario_id?>">	
					 </div>
						
						<div class="form-group col-md-6">
							<label>Usted esta cargando datos para el Trimestre:</label>
							<input type="text" class="form-control" name="trimestre" id="trimestre" value="<?=$trimestre?>" readonly>
							<input type="hidden" name="trimestre_id" id="trimestre_id" value="<?=$trimestre_id?>">
						</div>
					</div>
				</div>
				<div class="row no-mar">
					<div class="col-md-12">						
						<h3 class="mt-15">Agregar Centro de Costos</h3>
						<div class="row">
							<div class="col-md-3">
								<select class="form-control" name="centro_costos_id_1" id="centro_costos_id_1">
									<option value="">Seleccione una opción de la lista</option>
									<?
									foreach ($centros_costos as $centro_costos) {
										echo "<option value=\"{$centro_costos['centro_costos_id']}\">({$centro_costos['nombre']}) {$centro_costos['descripcion']}</option>";
									}	
									?>
								</select>
							</div>
							<div class="col-md-4">
								<select class="form-control" name="centro_costos_id_2" id="centro_costos_id_2">
									<option value="">Seleccione una opción de la lista</option>
								</select>
							</div>
							<div class="col-md-4">
								<select class="form-control" name="centro_costos_id_3" id="centro_costos_id_3">
									<option value="">Seleccione una opción de la lista</option>
								</select>
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-primary" id="agregar"><i class="glyphicon glyphicon-plus" style="width: 20px;"></i> Agregar</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row no-mar">
					<div class="col-md-12">
						<h3 class="mt-15">Detalles</h3>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th width="80%">Centro de Costos</th>
										<th width="10%">Porcentaje Trabajado</th>
										<th width="10%"></th>
									</tr>
								</thead>
								<tbody id="tablebody">
									<?
									$i=1;
									foreach ($cargas_trimestres_detalles as $carga_trimestre_detalle) {
									?>
										<tr id="fila_<?=$i?>">
											<td>
												<input type="hidden" name="centro_costos_id_fila_<?=$i?>" id="centro_costos_id_fila_<?=$i?>" value="" readonly>
												<input type="text" class="form-control" name="descripcion_<?=$i?>" id="descripcion_<?=$i?>" readonly value=""+texto+"">
											</td>
											<td>
												<input type="text" class="form-control" value="<?=$carga_trimestre_detalle['porcentaje']?>" name="porcentaje_<?=$i?>" id="porcentaje_<?=$i?>" style="text-align: right;" onkeyup="javascript: sumar_porcentajes();" tabindex="<?=$i?>">
											</td>
											<td>
												<button type="button" class="btn btn-danger" onclick="javascript: quitar(<?=$i?>)"><i class="glyphicon glyphicon-minus"></i></button>
											</td>
										</tr>
									<?
										$i++;
									}
									?>
								</tbody>
								<tfoot>
									<td><b>Total</b></td>
									<td><input type="text" name="porcentaje_total" id="porcentaje_total" class="form-control" readonly style="text-align: right;"></td>
									<td></td>
									<!--<td><input type="submit" class="btn btn-success mt-15 btn-lg" value="Continuar"></td>-->
								</tfoot>
							</table>
						</div>
					</div>
				</div>


				<div class="row no-mar text-center mb-50">
					<div class="col-md-12">	
						<input type="submit" class="btn btn-success mt-15 btn-lg" value="Continuar">
					</div>
				</div>
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
		$( "#centro_costos_id_1" ).change(function() {
			var getImpact = "load_centros_costos.php?centro_costos_id=" + $("#centro_costos_id_1").val();
			$.get( getImpact , function(response){
				$("#centro_costos_id_2").empty();
				$("#centro_costos_id_2").html(response);
			});
		});
		$( "#centro_costos_id_2" ).change(function() {
			var getImpact = "load_centros_costos.php?centro_costos_id=" + $("#centro_costos_id_2").val();
			$.get( getImpact , function(response){
				$("#centro_costos_id_3").empty();
				$("#centro_costos_id_3").html(response);
			});
		});
		$("#agregar").click(function() {
			var existe=0;
			var centro_costos_id_3=$("#centro_costos_id_3").val();
			if(centro_costos_id_3 != ''){
				contador=parseInt($("#contador").val());
				if(contador>=1){
					for(x=1;x<=contador;x++){
						if($('#fila_'+x).length > 0){
							if($("#centro_costos_id_3").val()==$("#centro_costos_id_fila_"+x).val()){
								existe++;
							}
						}
					}
				}
				if(existe!=1){
					var fila=parseInt($("#contador").val());
					fila++;
					var texto=$("#centro_costos_id_3 option:selected" ).text();
					$("#tablebody").append("<tr id=\"fila_"+fila+"\"><td><input type=\"hidden\" name=\"centro_costos_id_fila_"+fila+"\" id=\"centro_costos_id_fila_"+fila+"\" value=\""+centro_costos_id_3+"\" readonly><input type=\"text\" class=\"form-control\" name=\"descripcion_"+fila+"\" id=\"descripcion_"+fila+"\" readonly value=\""+texto+"\"></td><td><input type=\"text\" class=\"form-control\" value=\"\" name=\"porcentaje_"+fila+"\" id=\"porcentaje_"+fila+"\" style=\"text-align: right;\" onkeyup=\"javascript: sumar_porcentajes();\" tabindex=\""+fila+"\"></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"javascript: quitar("+fila+")\"><i class=\"glyphicon glyphicon-minus\"></i></button></td></tr>");
					//$("#centro_costos_id_"+fila).empty();
					//$("#centro_costos_id_"+fila).html(centros_costos);
					$("#contador").val(fila);
					$("#centro_costos_id_1").val('');
					$("#centro_costos_id_2").empty();
					$("#centro_costos_id_2").html('<option value=\"\">Seleccione una opción de la lista</option>');
					$("#centro_costos_id_3").empty();
					$("#centro_costos_id_3").html('<option value=\"\">Seleccione una opción de la lista</option>');
				}
				else{
					alert('Ya existe');
				}
			}
			else{
				alert('Debe seleccionar un trabajo realizado para poder continuar');
				$("#centro_costos_id").focus();
			}
		});

		function quitar(fila){
			$( "#fila_"+fila ).remove();
			sumar_porcentajes();
		}
		
		function sumar_porcentajes(){
			var porcentaje_total=0;
			contador=$("#contador").val();
			for(x=1;x<=contador;x++){
				if($('#porcentaje_'+x).length > 0 && $('#centro_costos_id_fila_'+x).val()!='' && $('#porcentaje_'+x).val()!=''){
					validar_numeros(document.getElementById("porcentaje_"+x));
					porcentaje=parseFloat($('#porcentaje_'+x).val());
					porcentaje_total=porcentaje_total+porcentaje;
				}
			}
			if(porcentaje_total>100){
				alert('La suma de los importes indicados no debe sumar mas de 100%');
				$(':focus').val('');
				$("#porcentaje_total").val('');
			}
			else{
				$("#porcentaje_total").val(porcentaje_total);
			}
		}

		function validar_numeros(objeto){
			if(isNaN(objeto.value)){
				objeto.focus();
				$(objeto).css("background-color", "red");
				alert('Debe ingresar solo numeros para indicar los porcentajes');
				objeto.value='';
				$(objeto).css("background-color", "white");
				return false;
			}
			else if(objeto.value<0){
				alert('Debe ingresar solo numeros positivos para indicar los porcentajes');
				objeto.value='';
				return false;
			}
			else{
				return true;
			}
		}

		function checkForm(){
			var cantidad_real_filas=0;
			if($("#usuario_id").val()==''){
				alert('Debe seleccionar un usuario para poder continuar');
				$("#usuario_id").focus();
				return false;
			}
			var cantidad_filas=parseInt($("#contador").val());
			if(cantidad_filas==0){
				alert('Debe indicar al menos un centro de costos para poder guardar la planilla.');
				$("#centro_costos_id_1").focus();
				return false;
			}
			else{
				for (var i = 1; i <= cantidad_filas; i++) {
					if($('#centro_costos_id_fila_'+i).length > 0){
						cantidad_real_filas++;
					}
				}
				if(cantidad_real_filas==0){
					alert('Debe indicar al menos un centro de costos para poder guardar la planilla.');
					$("#centro_costos_id_1").focus();
					return false;
				}
			}
			if($("#porcentaje_total").val()<100){
				if(confirm('ATENCIÓN. La sumatoria de los porcentajes indicados es menor a 100. Los datos se guardaran pero deberá completarlos mas tarde. Confirma que desea guardar los datos?')){
					return true;
				}
				else{
					return false;
				}
			}
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