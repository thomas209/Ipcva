<?php
$debug=0;
require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$tipo_cuenta=(isset($_POST['tipo_cuenta']) && $_POST['tipo_cuenta'] != '' ) ? $_POST['tipo_cuenta'] : '';
$centro_costos_id=(isset($_POST['centro_costos_id']) && $_POST['centro_costos_id'] != '' ) ? $_POST['centro_costos_id'] : '';
$usuario_id=(isset($_POST['usuario_id']) && $_POST['usuario_id'] != '' ) ? $_POST['usuario_id'] : '';
$trimestre_id=(isset($_POST['trimestre_id']) && $_POST['trimestre_id'] != '' ) ? $_POST['trimestre_id'] : '';

$sql="
	select 
		lc.centro_costos_id, lc.nombre_centro_costos, 
		lc.tipo_cuenta, lc.codigo_cuenta,
		sum((case
			when lc.tipo_cuenta='Haberes' then (sueldo*porcentaje/100)
			when lc.tipo_cuenta='Cargas Sociales' then (cargas_sociales*porcentaje/100)
			else 0
		end)) as neto
				
	from
		listado_cuentas lc,
		listado_porcentajes lp,
		remuneraciones r
		
	where
		lc.centro_costos_id=lp.centro_costos_id and
		lp.usuario_id=r.usuario_id and
		lp.trimestre_id=r.trimestre_id";
if($tipo_cuenta!='')$sql.=" and lc.tipo_cuenta='$tipo_cuenta'";
if($centro_costos_id!='')$sql.=" and lc.centro_costos_id=$centro_costos_id";
if($usuario_id!='')$sql.=" and lp.usuario_id=$usuario_id";
if($trimestre_id!='')$sql.=" and lp.trimestre_id=$trimestre_id";
$sql.="	group by lc.centro_costos_id, lc.nombre_centro_costos, lc.tipo_cuenta, lc.codigo_cuenta
		ORDER BY
		lc.codigo_cuenta, lc.nombre_centro_costos
	";
if($debug==1)echo $sql.'<br>';
$rs=pg_query($sql);
$cuentas=pg_fetch_all($rs);

$sql="select centro_costos_id, nombre from centros_costos where centro_costos_id_padre is not null order by nombre";
$rs=pg_query($sql);
$centros_costos=pg_fetch_all($rs);
pg_free_result($rs);

$sql="select usuario_id, nombre||' '||apellido as nombre from usuarios where perfil_id=5 order by nombre";
$rs=pg_query($sql);
$usuarios=pg_fetch_all($rs);
pg_free_result($rs);

$sql="select trimestre_id, nombre from trimestres order by trimestre_id desc";
$rs=pg_query($sql);
$trimestres=pg_fetch_all($rs);
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
                    <h1 class="page-header">Reportes</h1>
                </div>
                <!-- /.col-lg-12 -->
             </div>
			  <form name="filtros" method="post">
				<div class="row no-mar">
				 <div class="col-md-12">


				  <div class="form-group-md-6">
					<label>Usuario:</label>
					 <select name="usuario_id" id="usuario_id" onchange="this.form.submit();">
						<option value="">Todos</option>
						<?
						foreach ($usuarios as $usuario) {
							if($usuario_id==$usuario['usuario_id']){
								$selected='selected';
							}
							else{
								$selected='';
							}
							echo "<option value=\"{$usuario['usuario_id']}\" $selected>{$usuario['nombre']}</option>";
						}
						?>
					 </select>
				  </div><br>
				 <div class="form-group-md-6">
				   <label>Trimestre:</label>
					<select name="trimestre_id" id="trimestre_id" onchange="this.form.submit();">
						<option value="">Todos</option>
						<?
						foreach ($trimestres as $trimestre) {
							if($trimestre_id==$trimestre['trimestre_id']){
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
			   </div>
			  </div>
		    </form>
				<table width="900" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<td align="center"><strong>Cuenta</strong></td>
							<td align="center"><strong>Numero</strong></td>
							<td align="center"><strong>CC</strong></td>
							<td align="center"><strong>Debe</strong></td>
							<td align="center"><strong>Haber</strong></td>
						</tr>
					</thead>
					<tbody>
					<?
						$total_haberes=0;
						$total_cargas_sociales=0;
						$contador=1;
						$tipo_cuenta_anterior='';
						$codigo_cuenta_anterior='';
						$subtotal=0;
						foreach ($cuentas as $cuenta) {
						  $tipo_cuenta_actual=$cuenta['tipo_cuenta'];
						  $codigo_cuenta_actual=$cuenta['codigo_cuenta'];
							if($tipo_cuenta_actual==$tipo_cuenta_anterior){
								$tipo_cuenta_imprimir='';
							}
							else{
								$tipo_cuenta_imprimir=$tipo_cuenta_actual;
								if($subtotal!=0){
									echo '<tr><td></td><td></td><td></td><td style="border: inset;" align="right"><b>'.number_format($subtotal, 2, ',', '.').'</b></td><td></td></tr>';
									$subtotal=0;
								}
							}
							if($codigo_cuenta_actual==$codigo_cuenta_anterior){
								$codigo_cuenta_imprimir='';
							}
							else{
								$codigo_cuenta_imprimir=$codigo_cuenta_actual;
							}
							echo '<tr><td><strong>'.$tipo_cuenta_imprimir.'</strong></td><td align="center">'.$codigo_cuenta_imprimir.'</td><td align="center">'.$cuenta['nombre_centro_costos'].'</td><td  align="right">'.number_format($cuenta['neto'], 2, ',', '.').'</td><td></td></tr>';
							$tipo_cuenta_anterior=$tipo_cuenta_actual;
							$codigo_cuenta_anterior=$codigo_cuenta_actual;
							$subtotal=$subtotal+$cuenta['neto'];
							if($contador==count($cuentas)){
								echo '<tr><td></td><td></td><td></td><td style="border: inset;" align="right"><b>'.number_format($subtotal, 2, ',', '.').'</b></td><td></td></tr>';
								$subtotal=0;
							}
							$contador++;
							if($cuenta['tipo_cuenta']=='Haberes'){
								$total_haberes=$total_haberes+$cuenta['neto'];
							}
							if($cuenta['tipo_cuenta']=='Cargas Sociales'){
								$total_cargas_sociales=$total_cargas_sociales+$cuenta['neto'];
							}
							$total_general=$total_haberes+$total_cargas_sociales;
						}
						?>
						<tr>
							<td><b>Total Haberes</b></td>
							<td></td>
							<td></td>
							<td align="right"><b><?=number_format ($total_haberes, 2, ',', '.')?></b></td>
							<td></td>
						</tr>
						<tr>
							<td><b>Total Cargas Sociales</b></td>
							<td></td>
							<td></td>
							<td align="right"><b><?=number_format($total_cargas_sociales, 2, ',', '.')?></b></td>
							<td></td>
						</tr>
						<tr style="border: solid;">
							<td><b>Total General</b></td>
							<td></td>
							<td></td>
							<td align="right"><b><?=number_format($total_general, 2, ',', '.')?></b></td>
							<td></td>
						</tr>
				    </tbody>
				</table>


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

</body>
</html>
<?


pg_free_result($rs);
include("../conexiones/cierre.php");
?>