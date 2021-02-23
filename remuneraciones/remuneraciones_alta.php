<?
$debug=0;
require('../includes/isvalidated.php');
include('../conexiones/conexion.php');
$sql="SELECT
			r.remuneracion_id, u.nombre||' '|| u.apellido as usuario, t.nombre as trimestre, r.sueldo, r.cargas_sociales
		FROM
			remuneraciones r, usuarios u, trimestres t
		WHERE 
			r.usuario_id=u.usuario_id AND r.trimestre_id=t.trimestre_id";
$rs=pg_query($sql);
$remuneraciones=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT trimestre_id, nombre FROM trimestres order by trimestre_id";
$rs=pg_query($sql);
$trimestres=pg_fetch_all($rs);
pg_free_result($rs);

$sql="SELECT usuario_id, nombre ||' '|| apellido as empleado FROM usuarios order by empleado";
$rs=pg_query($sql);
$usuarios=pg_fetch_all($rs);
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
                        <h1 class="page-header">Alta de Remuneración</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<form name="altapedidos" id="altapedidos" method="POST" action="remuneraciones_alta_pr.php" onsubmit="traer()">
	                <div class="row no-mar">
						<div class="col-md-12">
							<input type="hidden" name="accion" value="insertar">
							<input type="hidden" name="contador" value="0" id="contador">
						</div>
					</div>
					<div class="row no-mar">
						<div class="form-group col-md-6">
							<label>Trimestre</label>
							<select class="form-control" name="trimestre_id" id="trimestre_id">
								<option value="" selected>Seleccione</option>
								<?
								foreach ($trimestres as $tri) {
									echo "<option value=\"{$tri['trimestre_id']}\">{$tri['nombre']}</option>";
								}
								?>
							</select>				
						</div>
					
		            <!-- /.tabla -->
	               
						<div class="col-md-12">
							<h3 class="mt-15"></h3>
							<div class="table-responsive">
								<table class="table" id="contenedor">
									<thead>
										<tr>
											<th scope="col" width="80%">Empleado</th>
											<th scope="col" width="10%">Sueldo</th>
											<th scope="col" width="10%">Carga Social</th>
										</tr>
									</thead>
									<tbody id="tablebody">
									</tbody>
								</table>
							</div>
						</div>
					</div>
						<!-- /.Boton Agregar -->
                	<div class="row no-mar">
						<div class="row no-mar text-center mb-50">
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




		$( "#trimestre_id" ).change(function() {
			$("#tablebody").html('');
			$.getJSON( "load_empleados.php", { "_value" : $("#trimestre_id").val()} )
			.done(function( data, textStatus, jqXHR ) {
				var fila=1;
				//alert(data.length);
				//$("#contador").val(data.length);

				$contador=parseInt($("#contador").val());
				  if(contador>=0){
				  	for(x=1;x<=contador;x++){
				  		
				  	}
				  }




				$.each(data, function(clave, valor){
					//alert(valor.usuario_id+': '+valor.empleado);
					$("#tablebody").append("<tr id=\"fila_"+fila+"\"><td><input type=\"text\" class=\"form-control\" value=\""+valor.empleado+"\" readonly><input type=\"hidden\" name=\"usuario_id_"+fila+"\" id=\"usuario_id_"+fila+"\" value=\""+valor.usuario_id+"\"></td><td><input type=\"text\" class=\"form-control\" name=\"sueldo_"+fila+"\" id=\"sueldo_"+fila+"\"  value=\"\" style=\"text-align: right; width: 80px;\"></td><td><input type=\"text\" class=\"form-control\" value=\"\" name=\"cargas_sociales_"+fila+"\" id=\"cargas_sociales_"+fila+"\" style=\"text-align: right; width: 80px;\"></td></tr>");

					//$("div").append(field + " ");
					fila=fila+1;
					$("#contador").val(fila);
				});
			})
			/*.fail(function( jqXHR, textStatus, errorThrown ) {
				if ( console && console.log ) {
					console.log( "Algo ha fallado: " +  textStatus);
				}
			*/
		});



    	/*
    	$( "#trimestre_id" ).change(function() {
			var getImpact = "load_empleados.php?_value=" + $("#trimestre_id").val();
			$.get( getImpact , function(response){
				$("#usuario_id_").empty();
			$("#tablebody").html(response);
			});
		
		

			var existe=0;
			var trimestre_id_=$("#usuario_id").val();
			alert("2");
			if(trimestre_id_ != ''){
				
				contador=parseInt($("#contador").val());
				if(contador>=1){
					for(x=1;x<=contador;x++){
						if($('#fila_'+x).length > 0){
							if($("#usuario_id_1").val()==$("#usuario_id_fila_"+x).val()){
								existe++;
							}
						}
					}
				}
				alert("3");
				
					var fila=parseInt($("#contador").val());
					fila++;
					$("#tablebody").append("<tr id=\"fila_"+fila+"\"><td><input type=\"hidden\" name=\"usuario_id_fila_"+fila+"\" id=\"usuario_id_"+fila+"\" value=\""+usuario_id+"\" readonly><input type=\"text\" class=\"form-control\" name=\"nombre_"+fila+"\" value=\""+nombre+"\" readonly><input type=\"text\" class=\"form-control\" name=\"sueldo_"+fila+"\" id=\"sueldo_"+fila+"\"  value=\""+texto+"\"></td><td><input type=\"text\" class=\"form-control\" value=\""+texto+"\" name=\"cargas_sociales_"+fila+"\" id=\"cargas_sociales_"+fila+"\" style=\"text-align: right;\"></td></tr>");
					alert("4");
					$("#usuario_id_"+fila).empty();
					$("#usuario_id_"+fila).html();
					$("#contador").val(fila);
					alert("5");
				
			}
			else{
				alert('Debe seleccionar un trabajo realizado para poder continuar');
				$("#trimestre_id").focus();
			}
		});
		*/





   


		
	

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