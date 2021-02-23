		<?
		/*
		Perfiles
		1	Administrador 
		20	Marketing
		30	Comercial
		40	Creditos
		50	Administracion de ventas
		100	Vendedor
		
		$permitidos_distribuidores=array(1,2,3);
		$permitidos_clientes=array(1,2,3,4,6,10);
		$permitidos_pedidos=array(1,2,3,4,5, 6,10);
		$permitidos_productos=array(1,2,3);
		$permitidos_usuarios=array(1,2,3);
		$permitidos_comisiones=array(1,2,3,10);
		$permitidos_comisiones_powerbales=array(1,2);
		$permitidos_facturas_comisiones=array(1,2,3);
		$permitidos_stock=array(1,2,3,10);
		$permitidos_consignaciones=array(1,2,3,10);
		$permitidos_documentos=array(1,2,3,10);
		$permitidos_configuracion=array(1,2);
		$permitidos_campanas = array(1,2,3,4,6,10); 
		*/
		?>
		<!-- Navigation -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/sigt/index.php"></a>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right hidden-xs">
				
				
				<!-- /.dropdown -->
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?=$nombre_logueado.' ('.$perfil_nombre_logueado.')'?>&nbsp;<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="/sigt/usuarios/usuarios_detalle.php?usuario_id=<?=$usuario_id_logueado?>">Mis Datos</a></li>
						<li class="divider"></li>
						<li><a href="/sigt/logout.php">Cerrar sesión</a></li>
					</ul>
				</li>
			</ul>
			<div class="navbar-default sidebar" role="navigation">
				<button id="btn_toggle_menu" class="btn btn-success" onclick="sideBar_show()"><i class="fa fa-caret-right fa-lg"></i></button>
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<?
						if($perfil_id_logueado!=4){
						?>
						<li>
							<a href="/sigt/index.php" id="a-inicio">Inicio</a>
						</li>
						<?
					    }
					    if($perfil_id_logueado!=4){
						?>
						<li>
							<a href="/sigt/cargas_trimestres" id="a-trimestres_detalles">Trimestres Cargados</a>
						</li>
						<?
				       	}
						?>
						<li>
							<a href="/sigt/centros_costos" id="a-remuneraciones">Centros de Costos</a>
						</li>
						<?
						if($perfil_id_logueado==1){	
						?>
							<li id="li-remuneraciones">
								<a href="#" id="a-remuneraciones">Remuneraciones<span class="fas fa-caret-down pull-right"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="/sigt/remuneraciones">Historial</a></li>
									<li><a href="/sigt/remuneraciones/remuneraciones_alta.php">Carga de Remuneración</a></li>
								</ul>
							</li>
						<?
						}
						if($perfil_id_logueado==1){
						?>
							<li>
								<a href="/sigt/usuarios" id="a-usuarios">Usuarios</a>
							</li>
						<?
						}
							else{
						?>
							<li>
								<a href="/sigt/usuarios/usuarios_detalle.php?usuario_id=<?=$usuario_id_logueado?>" id="a-usuarios">Datos del Usuario</a>
							</li>
						<?
							}
						?>

						<?
						if($perfil_id_logueado==1){
						?>
							<li id="li-configuracion">
								<a href="#" id="a-configuracion">Configuración<span class="fas fa-caret-down pull-right"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="/sigt/configuracion/trimestres.php">Trimestres</a></li>
									<li><a href="/sigt/configuracion/perfiles.php">Perfiles</a></li>
									<li><a href="/sigt/configuracion/sectores.php">Sectores</a></li>
									<li><a href="/sigt/configuracion/cuentas_haberes.php">Cuentas Haberes</a></li>
									<li><a href="/sigt/configuracion/cuentas_cargas_sociales.php">Cuentas Cargas Sociales</a></li>
								</ul>
							</li>
						<li >
							<a href="/sigt/reportes/reporte.php" id="a-reportes">Reporte</a>
						</li>
						<?
						}
						?>
						<li>
							<a href="#" id="esconder" onclick="sideBar_hide()">Ocultar barra lateral</a>
						</li>
						<li class="visible-xs">
							<a href="#" id="a-usuario"><i class="fa fa-user fa-fw"></i> Usuario <i class="fa fa-caret-down"></i></span></a>
							<ul class="nav nav-second-level">
								<li><a href="/distribuidores/distribuidor_detalle.php?usuario_id=<?=$usuario_id_logueado?>">Mis Datos</a></li>
								<li><a href="/logout.php">Cerrar sesión</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>