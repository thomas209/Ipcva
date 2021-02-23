<?php
require('../includes/isvalidated.php');
include("../conexiones/conexion.php");
$trimestre_id=$_GET["_value"];
if ($trimestre_id != ''){
	$sql="SELECT usuario_id, nombre ||'  '|| apellido as empleado from usuarios where perfil_id=5 and usuario_id not in (select usuario_id from remuneraciones where trimestre_id=$trimestre_id)";
	$rs=pg_query($sql);
	$empleados=pg_fetch_all($rs);
	//echo ($sql);
	pg_free_result($rs);
	echo json_encode($empleados, JSON_UNESCAPED_UNICODE);
}
 include("../conexiones/cierre.php");
?>