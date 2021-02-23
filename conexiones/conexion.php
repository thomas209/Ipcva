<?
$conn_string = 'host=10.136.89.176 port=5432 dbname=ipcva_sigt user=ipcva password=LVMPE70';
$db=pg_connect($conn_string);
$title="IPCVA SIGT";
function anti_injection($sql, $formUse = true){
	$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	if(!$formUse || !get_magic_quotes_gpc())
	$sql = addslashes($sql);
	return $sql;
}
?>