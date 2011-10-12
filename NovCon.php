<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['id']) ){
	$id = $_REQUEST['id'];
	$pla = $_REQUEST['pla'];

}else{
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultar Novedades</title>
<style>
#DetallesConsultas{
	font-family: "TPro";
}


</style>


<script>



function volver_nov_con(){
	
	$("#Novedades").fadeOut(500);
	
	$("#Novedades").load("Novedades.php");
	
	$("#Novedades").fadeIn(500);
	
}

</script>


</head>

<body>

<div id="NovCon" style="position:absolute; left:70px; top:40px;">
	<img src="Novedades/consulta.png" />
</div>

<div id="FondoAgregarNegro" style="position:absolute; left:66px; top:40px; z-index:-2;">
	<img src="Novedades/fondo negro.png" />
</div>


<?
$OPE = $_SESSION['idsusua'];
$NOM = $_SESSION['idsusun'];


$_SESSION['ParSQL'] = "SELECT * FROM NOVEDADES WHERE PLA =".$pla." AND ID=".$id.""; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($R1=mssql_fetch_array($R1TB)){
	$tipo = $R1['TIPO'];
	$desc = $R1['DESC'];		
	$obs = $R1['OBS'];
	$idcant = $R1['ID'];	
}

////////BUSCO EL TIPO DE NOVEDAD//////////
$_SESSION['ParSQL'] = "SELECT * FROM TIPO_NOVEDADES WHERE id=".$tipo."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);	
while ($RB=mssql_fetch_array($RSBTABLA)){
	$tiponom = $RB['DESC'];
}

////////BUSCO LA DESCRIPCI�N DE LA NOVEDAD//////////
$_SESSION['ParSQL'] = "SELECT * FROM DESC_TIPO_NOVEDADES WHERE ID_TIPO_NOVEDAD=".$tipo." AND ID = ".$desc."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);	
while ($RB=mssql_fetch_array($RSBTABLA)){
	$descnom = $RB['DESC'];
}


?>
<div id="DetallesConsultas">
		<div style="position:absolute; left:222px; top:82px; width: 143px; height: 18px;" align="center"><? echo $pla;?></div>
	
		<div style="position:absolute; left:221px; top:104px; width: 143px; height: 18px;" align="center"><? echo $OPE;?></div>
		
		<div style="position:absolute; left:511px; top:82px; width: 143px; height: 18px;" align="center"><? echo $idcant;?></div>

		<div style="position:absolute; left:511px; top:104px; width: 143px; height: 18px;" align="center"><? echo $tiponom;?></div>

		<div style="position:absolute; left:220px; top:126px; width: 434px; height: 18px;"><? echo $descnom;?></div>

		<div style="position:absolute; left:80px; top:167px; width:584px; height: 85px; text-transform:uppercase;"><? echo $obs?></div>
</div>

<div style="position:absolute; left:318px; top:316px;">
	<button class="StyBoton" onclick="volver_nov_con();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetVolNov2','','botones/vol-over.png',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov2"/></button>
</div>


</body>
</html>
<?

mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>