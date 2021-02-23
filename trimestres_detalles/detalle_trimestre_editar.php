<?
$debug=0;
//require('../includes/isvalidated.php');
include('../conexiones/conexion.php');

$detalle_trimestres=$_GET['detalle_trimestre_id'];
$sql="SELECT detalle_trimeste_id, trimestre_id, usuario_id, porcentaje, centro_costos_id, from detalles_trimestres where detalle_trimestre_id=$detalle_trimestre_id order by detalle_trimestre_id";
$rs=pg_query($sql);
$empleados=pg_fetch_result($rs, 0, 'usuario_id');
$trimestres=pg_fetch_result($rs, 0, 'trimestre_id');
$centros_costos=pg_fetch_result($rs, 0, 'centro_costos_id');
$porcentaje=pg_fetch_result($rs, 0, 'porcentaje');
$nombre=pg_fetch_result($rs, 0, 'nombre');
$descripcion=pg_fetch_result($rs, 0, 'descripcion');
$habilitado=pg_fetch_result($rs, 0, 'habilitado');
pg_free_result($rs);
////////////////////
$sql="SELECT usuario_id, nombre FROM usuarios order by usuario_id";
$rs=pg_query($sql);
$empleados=pg_fetch_all($rs);
pg_free_result($rs);
////////////////////
$sql="SELECT trimestre_id, nombre FROM trimestres order by trimestre_id";
$rs=pg_query($sql);
$trimestres=pg_fetch_all($rs);
pg_free_result($rs);
////////////////////
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
                        <h1 class="page-header">Editar Detalles Trimestre</h1>
                    </div>
                    <div class="col-md-3 text-right">
						<a href="index.php" class="btn btn-default btn-agregar"> Volver</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<form name="altadetallestrimestres" id="altadetallestrimestres" method="POST" action="detalle_trimestre_editar_pr.php" onsubmit="checkForm()">
	               <input type="hidden" name="detalle_trimestre_id" value="<?=$detalle_trimestre_id?>">
	                <div class="row no-mar">
						<div class="col-md-12">
							<h3 class="mt-15">Detalle</h3>
							<div class="form-group col-md-4">
							 <label>Empleado</label>
								  <select name="centro_costos_id_padre" class="form-control">
										<option value="">Seleccionar</option>
										<?
										$sql="SELECT usuario_id, nombre from usuarios order by nombre";
										$rs=pg_query($sql);
										$empleados=pg_fetch_all($rs);
										pg_free_result($rs);

										foreach ($empleados as $empleado) {
											if($empleado['usuario_id']==$usuario_id){
												$selected='selected';
											}
											else{
												$selected='';
											}
											echo "<option value=\"{$usuario['usuario_id']}\" $selected>{$usuario['nombre']}</option>";
										}
										?>
								  </select>
							</div>
							<div class="form-group col-md-4">
								<label>Trimestre</label>
									<select class="form-control" name="cuenta_haberes_id">
										<option value="" selected>Seleccione</option>
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
							<div class="form-group col-md-2">
								<label>Porcentaje</label>
								<input type="text" class="form-control" name="porcentaje" id="porcentaje" value="<?=$porcentaje?>" style="text-align: left">
							</div>
							<div class="form-group col-md-2">
								<label>Centro de Costos</label>
								<input type="text" class="form-control" name="centro_costos_id" id="centro_costos_id" value="<?=$centros_costos?>" style="text-align: left">
							</div>
							</div>
							</div>

							<div class="row no-mar text-center mb-50">
						 <input type="submit" class="btn btn-success mt-15 btn-lg" value="Continuar">
					   </div>
				</form>
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
		var productos='<option value="">Seleccione</option><?
		foreach ($productos as $producto) {
			echo "<option value=\"{$producto['producto_id']}\" $selected>{$producto['nombre']}</option>";
		}
		?>';

		$( "#usuario_id" ).change(function() {
			//alert($("#usuario_id").val());
			//console.log("entro");
			var getImpact = "load_clientes.php?_value=" + $("#usuario_id").val();
			$.get( getImpact , function(response){
				$("#cliente_id").empty();
				$("#canal").val('');
				$("#linea_credito").val('');
				$("#deuda_no_vencida").val('');
				$("#deuda_vencida").val('');
				$("#credito_disponible").val('');
				$("#cliente_id").html(response);
			});
		});

		$( "#cliente_id" ).change(function() {
			$("#linea_credito").val(43435);
			$("#deuda_no_vencida").val(123465);
			$("#deuda_vencida").val(2336);
			$("#credito_disponible").val(655423);
			var getImpact = "load_canal.php?_value=" + $("#cliente_id").val();
			$.getJSON( getImpact, function( data ) {
				$("#canal").empty();
				$("#canal").val(data.nombre);
				$("#canal_id").val(data.canal_id);
			});
		});

		$( "#forma_pago_id" ).change(function() {
			filas=parseInt($("#contador").val());
			var forma_pago_id=$("#forma_pago_id").val();
			var canal_id=$("#canal_id").val();
			var deposito_id=$("#deposito_id").val();
			if(filas>1){
				for (contador = 1; contador <= filas; contador++) {
					if( $("#precio_lista_"+contador).length && $("#producto_id_"+contador).val()!=''){
						var producto_id=$("#producto_id_"+contador).val();
						var myUrl = "load_datos_producto.php?producto_id="+producto_id+"&forma_pago_id="+forma_pago_id+"&canal_id="+canal_id+"&deposito_id="+deposito_id;
						$.ajax({
							url: myUrl,
							dataType: 'json',
							async: false,
							success: function(data) {
								$("#precio_lista_"+contador).empty();
								$("#precio_lista_"+contador).val(data.precio_lista);
								$("#precio_"+contador).empty();
								$("#precio_"+contador).val(data.precio_lista);
								$("#subtotal_"+contador).val('');
							}
						});
					}
				}
				calcular_subtotales();
			}
			//calcular_subtotales();
			/*			
			var getImpact = "load_precio.php?producto_id=" + $("#producto_id_").val();
			$.get( getImpact, function( data ) {
				productos=data;
				$("#producto_id_1").empty();
				$("#producto_id_1").html(data);
				$("#contador").val(1);
				$("#codigo_bejerman_1").val('');
				$("#disponible_1").val('');
				$("#cantidad_1").val('');
				$("#precio_lista_1").val('');
				$("#precio_1").val('');
				$("#porcentaje_descuento_1").val('');
				$("#comision_1").val('');
				$("#provision_1").val('');
				$("#subtotal_1").val('');
				$("#puntos_1").val('');
			});
			*/
		});


		$( "#deposito_id" ).change(function() {
			productos='';
			filas=parseInt($("#contador").val());
			if(filas>1){
				for (i = 2; i <= filas; i++) {
					$("#fila_"+i ).remove();
				}
			}			
			var getImpact = "load_productos.php?deposito_id=" + $("#deposito_id").val();
			$.get( getImpact, function( data ) {
				productos=data;
				$("#producto_id_1").empty();
				$("#producto_id_1").html(data);
				$("#contador").val(1);
				$("#codigo_bejerman_1").val('');
				$("#disponible_1").val('');
				$("#cantidad_1").val('');
				$("#precio_lista_1").val('');
				$("#precio_1").val('');
				$("#porcentaje_descuento_1").val('');
				$("#comision_1").val('');
				$("#provision_1").val('');
				$("#subtotal_1").val('');
				$("#puntos_1").val('');
			});
		});

		$( "#agregar_producto" ).click(function() {
			var deposito_id=$("#deposito_id").val();
			if(deposito_id != ''){
				if($("#origen_mercaderia").val()!=''){
					fila=parseInt($("#contador").val());
					fila++;
					$("#tablebody").append("<tr id=\"fila_"+fila+"\"><td><select class=\"form-control\" name=\"producto_id_"+fila+"\" id=\"producto_id_"+fila+"\" onchange=\"javascript: cargar_datos_producto("+fila+", this.value)\"><option>Seleccione</option></select></td><td><input type=\"text\" class=\"form-control\" name=\"codigo_bejerman_"+fila+"\" id=\"codigo_bejerman_"+fila+"\" style=\"text-align: right; width: 60px;\" readonly></td><td><input type=\"text\" class=\"form-control\" name=\"disponible_"+fila+"\" id=\"disponible_"+fila+"\" style=\"text-align: right; width: 60px;\" readonly></td><td><input type=\"text\" class=\"form-control\" name=\"cantidad_"+fila+"\" id=\"cantidad_"+fila+"\" style=\"text-align: right; width: 60px;\" onkeyup=\"calcular_subtotales();\"></td><td><input type=\"text\" class=\"form-control\" name=\"precio_lista_"+fila+"\" id=\"precio_lista_"+fila+"\" style=\"text-align: right; width: 60px;\" readonly></td><td><input type=\"text\" class=\"form-control\" name=\"precio_"+fila+"\" id=\"precio_"+fila+"\" style=\"text-align: right; width: 60px;\" onkeyup=\"calcular_subtotales();\"></td><input type=\"hidden\" name=\"iibb_"+fila+"\" id=\"iibb_"+fila+"\"><input type=\"hidden\" name=\"iva_"+fila+"\" id=\"iva_"+fila+"\"><td><input type=\"text\" class=\"form-control\" name=\"porcentaje_descuento_"+fila+"\" id=\"porcentaje_descuento_"+fila+"\" style=\"text-align: right; width: 60px;\" readonly></td><td><input type=\"text\" class=\"form-control\" name=\"comision_"+fila+"\" id=\"comision_"+fila+"\" style=\"text-align: right; width: 60px;\" onkeyup=\"calcular_subtotales();\"></td><td><input type=\"text\" class=\"form-control\" name=\"provision_"+fila+"\" id=\"provision_"+fila+"\" style=\"text-align: right; width: 60px;\" onkeyup=\"calcular_subtotales();\"></td><td><input type=\"hidden\" name=\"subtotal_lista_"+fila+"\" id=\"subtotal_lista_"+fila+"\"><input type=\"text\" class=\"form-control\" name=\"subtotal_"+fila+"\" id=\"subtotal_"+fila+"\" readonly style=\"text-align: right; width: 60px;\"></td><td><input type=\"text\" class=\"form-control\" name=\"puntos_"+fila+"\" id=\"puntos_"+fila+"\" readonly style=\"text-align: right; width: 60px;\"></td><td><button type=\"button\" class=\"btn btn-danger\" onclick=\"javascript: quitar_producto("+fila+")\"><i class=\"glyphicon glyphicon-minus\"></i></button></td></tr>");
					$("#producto_id_"+fila).empty();
					$("#producto_id_"+fila).html(productos);
					$("#contador").val(fila);
				}
				else{
					alert('Debe seleccionar el origen de la mercaderia para poder continuar');
					$("#origen_mercaderia").focus();
				}
			}
			else{
				alert('Debe seleccionar un depósito para poder continuar');
				$("#deposito_id").focus();
			}
		});

		function quitar_producto(fila){
			$( "#fila_"+fila ).remove();
			sumar_subtotales();
		}


		function cargar_datos_producto(fila, producto_id){
			var forma_pago_id=$("#forma_pago_id").val();
			var canal_id=$("#canal_id").val();
			var deposito_id=$("#deposito_id").val();
			if(forma_pago_id=='' || canal_id==''){
				alert('Debe seleccionar Cliente y Forma de Pago para poder continuar');
				//$("#producto_id_1").val('');
			}
			else{
				var getImpact = "load_datos_producto.php?producto_id="+producto_id+"&forma_pago_id="+forma_pago_id+"&canal_id="+canal_id+"&deposito_id="+deposito_id;
				$.getJSON(getImpact, function(data){
					$("#codigo_bejerman_"+fila).empty();
					$("#codigo_bejerman_"+fila).val(data.codigo_bejerman);
					$("#disponible_"+fila).empty();
					$("#disponible_"+fila).val(data.disponible);
					$("#precio_lista_"+fila).empty();
					$("#precio_lista_"+fila).val(data.precio_lista);
					$("#precio_"+fila).empty();
					$("#precio_"+fila).val(data.precio_lista);
					$("#lista_precios_id").empty();
					$("#lista_precios_id").val(data.lista_precios_id);
					$("#cantidad_"+fila).val('');
					$("#subtotal_"+fila).val('');
					//$("#canal").val(data.nombre);
					//$("#canal_id").val(data.canal_id);
				});
				calcular_subtotales();
			}
		}

		function calcular_subtotales(){
			contador=$("#contador").val();
			//alert(contador);
			for(x=1;x<=contador;x++){
				if($('#fila_'+x).length){
					validar_numeros(document.getElementById("cantidad_"+x));
					validar_numeros(document.getElementById("precio_"+x));
					if($('#precio_'+x).length > 0 && $('#cantidad_'+x).val()!='' && $('#precio_'+x).val()!=''){
						var cantidad=parseInt($('#cantidad_'+x).val());
						var precio=parseFloat($('#precio_'+x).val());
						var precio_lista=parseFloat($('#precio_lista_'+x).val());
						var stock=parseInt($('#disponible_'+x).val());
						if(cantidad>stock){
							alert("La cantidad solicitada no puede superar al stock disponible");
							$('#cantidad_'+x).val('');
							$('#subtotal_'+x).val('');
						}
						var subtotal=cantidad*precio;
						var subtotal_lista=cantidad*precio_lista;
						var descuento=Math.round((1-(precio/precio_lista))*100*100)/100;
						$('#subtotal_'+x).val(subtotal);
						$('#porcentaje_descuento_'+x).val(descuento);
						$('#subtotal_lista_'+x).val(subtotal_lista);
						//alert(precio);
					}
				}
			}
			sumar_subtotales();
		}

		function validar_numeros(objeto){
			if(isNaN(objeto.value)){
				objeto.focus();
				$(objeto).css("background-color", "red");
				alert('Debe ingresar solo numeros y utilizar el "." para indicar decimales');
				objeto.value='';
				$(objeto).css("background-color", "white");
				return false;
			}
			else{
				return true;
			}
		}
		
		function sumar_subtotales(){
			contador=$("#contador").val();
			var total=0;
			var total_lista=0;
			var total_comision=0;
			var total_provision=0;
			for(x=1;x<=contador;x++){
				if($('#subtotal_'+x).length > 0 && $('#subtotal_'+x).val()!=''){
					subtotal=parseFloat($('#subtotal_'+x).val());
					total=total+subtotal;
					//alert(precio);
				}
				if($('#subtotal_lista_'+x).length > 0 && $('#subtotal_lista_'+x).val()!=''){
					subtotal_lista=parseFloat($('#subtotal_lista_'+x).val());
					total_lista=total_lista+subtotal_lista;
					//alert(precio);
				}
				if($('#comision_'+x).length > 0 && $('#comision_'+x).val()!=''){
					subtotal_comision=parseFloat($('#comision_'+x).val());
					total_comision=total_comision+subtotal_comision;
					//alert(precio);
				}
				if($('#provision_'+x).length > 0 && $('#provision_'+x).val()!=''){
					subtotal_provision=parseFloat($('#provision_'+x).val());
					total_provision=total_provision+subtotal_provision;
					//alert(precio);
				}
			}
			$('#total').val(total);
			$('#total_lista').val(total_lista);
			$('#total_comision').val(total_comision);
			$('#total_provision').val(total_provision);
			var total_descuento=Math.round((1-(total/total_lista))*100*100)/100;
			$('#total_descuento').val(total_descuento);

		}
/*


		function cargar_productos(fila, cultivo_id){
			plazo=$( "#plazo" ).val();
			if(plazo==''){
				alert('Debe seleccionar Forma de Pago y Plazo para poder continuar');
				$("#cultivo_id_1").val('');
			}
			else{
				//alert(fila);
				//alert(cultivo);
				usuario_id=$('#usuario_id').val();
				origen_mercaderia=$('#origen_mercaderia').val();
				var getImpact = "load_productos.php?cultivo_id="+cultivo_id+"&usuario_id="+usuario_id+"&origen_mercaderia="+origen_mercaderia;
				$.get( getImpact , function(response){
					$("#producto_id_"+fila).empty();
					$("#precio_"+fila).val('');
					$("#precio_lista_"+fila).val('');
					$("#precio_base_"+fila).val('');
					$("#producto_id_"+fila).html(response);
				});
			}
		}

		function cargar_precios(fila, producto_id){			
			$.getJSON( "load_precios.php", { "id" : producto_id, "plazo" : $("#plazo").val()} )
			.done(function( data, textStatus, jqXHR ) {
				document.getElementById("precio_"+fila).value=data.precio;
				document.getElementById("precio_lista_"+fila).value=data.precio;
				document.getElementById("precio_base_"+fila).value=Math.round((data.precio*0.85)*100)/100;
				if(data.precio==0){
					alert('No hay precio para ese producto en ese plazo');
					$('#cantidad_'+fila).prop('readonly', true);
					$('#precio_'+fila).prop('readonly', true);
				}
				else{
					$('#cantidad_'+fila).prop('readonly', false);
					$('#precio_'+fila).prop('readonly', false);
				}
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				if ( console && console.log ) {
					console.log( "Algo ha fallado: " +  textStatus);
				}
			});
		}


		$("#origen_mercaderia").change(function() {
			//Si la cambia pongo todo en cero
			contador=$("#contador").val();
			for(x=1;x<=contador;x++){
				if($('#producto_id_'+x).length > 0 && $('#producto_id_'+x).val()!=''){
					$("#cultivo_id_"+x).empty();
					$("#cultivo_id_"+x).html(cultivos);
					$("#producto_id_"+x).empty();
					$("#producto_id_"+x).html('<option value="" selected>Seleccionar</option>');
					$("#deposito_id_"+x).empty();
					$("#deposito_id_"+x).html('<option value="" selected>Seleccionar</option>');		
					$('#disponible_'+x).val('');
					$('#disponible_'+x).val('');
					$('#cantidad_'+x).val('');
					$('#precio_'+x).val('');
					$('#precio_lista_'+x).val('');
					$('#precio_base_'+x).val('');
					$('#subtotal_comision_'+x).val('');
					$('#subtotal_'+x).val('');
				}
			}
			$('#total_comision'+x).val('');
			$('#total'+x).val('');
			origen_mercaderia=$("#origen_mercaderia").val();
			if(origen_mercaderia=='directo' || origen_mercaderia==''){
				$('#tipo_facturacion').val('A').change();
				$('#tipo_facturacion').attr('disabled', true);
			}
			else{
				$('#tipo_facturacion').val('D').change();
				$('#tipo_facturacion').attr('disabled', false);
			}
		});




		function cargar_stock(fila, deposito_id){	
			origen_mercaderia=$('#origen_mercaderia').val();
			usuario_id=$('#usuario_id').val();
			producto_id=$('#producto_id_'+fila).val();
			//alert(producto_id+' '+origen_mercaderia);
			$.getJSON( "load_stock.php", { "producto_id" : producto_id, "deposito_id" : deposito_id, "usuario_id" : usuario_id, "origen_mercaderia" : origen_mercaderia} )
			.done(function( data, textStatus, jqXHR ) {
				document.getElementById("disponible_"+fila).value=data.cantidad;
			})
			.fail(function( jqXHR, textStatus, errorThrown ) {
				if ( console && console.log ) {
					console.log( "Algo ha fallado: " +  textStatus);
				}
			});
		}



		function cargar_depositos(fila){	
			//Tambien cargo los depositos segun el origen de mercaderia
			origen_mercaderia=$("#origen_mercaderia").val();
			//alert(origen_mercaderia);
			usuario_id=$("#usuario_id").val();			
			var getImpact = "load_depositos.php?origen_mercaderia="+origen_mercaderia+"&usuario_id="+usuario_id;
			$.get( getImpact , function(response){
				$("#deposito_id_"+fila).empty();
				$("#deposito_id_"+fila).html(response);
			});
			$('#disponible_'+fila).val('');
		}

		$( "#forma_pago_id" ).change(function() {
			var getImpact = "load_plazos.php?id="+$( "#forma_pago_id" ).val();
			$.get( getImpact , function(response){
				$("#plazo").empty();
				$("#plazo").html(response);
			});
		});


		$( "#plazo" ).change(function() {
			contador=$("#contador").val();
			for(x=1;x<=contador;x++){
				if($('#producto_id_'+x).length > 0 && $('#producto_id_'+x).val()!=''){
					cargar_precios(x, $('#producto_id_'+x).val());
					calcular_sbtotales=1;
				}
				else{
					calcular_sbtotales=0;
				}
			}
			if(calcular_sbtotales==1){
				calcular_subtotales();
				sumar_subtotales();
			}
		});





		function areYouSure(){
			var txt;
			var r = confirm('Está seguro de que quiere realizar esta acción?');
			if (r == false) {
				event.preventDefault();
			}
		}

		function bs_input_file() {
			$(".input-file").before(
				function() {
					if ( ! $(this).prev().hasClass('input-ghost') ) {
						var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
						element.attr("name",$(this).attr("name"));
						element.change(function(){
							element.next(element).find('input').val((element.val()).split('\\').pop());
						});
						$(this).find("button.btn-choose").click(function(){
							element.click();
						});
						$(this).find("button.btn-reset").click(function(){
							element.val(null);
							$(this).parents(".input-file").find('input').val('');
						});
						$(this).find('input').css("cursor","pointer");
						$(this).find('input').mousedown(function() {
							$(this).parents('.input-file').prev().click();
							return false;
						});
						return element;
					}
				}
			);
		}
		$(function() {
			bs_input_file();
		});

		function checkForm(){
			$('#tipo_facturacion').attr('disabled', false);
			$('#pedido_estado_id').attr('disabled', false);
			var estval = $('#establecimiento_id').val();
			if(estval == '' || estval == null || estval == undefined){
				alert('No puede cargar un pedido sin seleccionar un Establecimiento.');
				event.preventDefault();
			}
			var contacto = $('#contacto_id').val();
			if(contacto == '' || contacto == null || contacto == undefined){
				alert('No puede cargar un pedido sin seleccionar un Contacto.');
				event.preventDefault();
			}
		}
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