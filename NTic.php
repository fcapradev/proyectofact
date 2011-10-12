<?
require('config/cnx.php');

$_SESSION['ParSQL'] = "SELECT MAX(NCO) + 1 AS NCO FROM AMAEFACT WHERE TIP = 'B' AND TCO = 'TI' AND SUC = ".$_SESSION['ParPV']."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);
while ($reg=mssql_fetch_array($registros)){
	if($reg['NCO'] == NULL){
		$NCO = 1;
	}else{
		$NCO = $reg['NCO'];
	}
}
?>
<script>
	document.getElementById('NCO').value = "<?=$NCO?>";
</script>