<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$TAR = $_REQUEST['tar'];
$NCU = $_REQUEST['ncu'];
$NLO = $_REQUEST['nlo'];


$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
}

$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$NOM = $_SESSION['idsusun'];

///////////////////////////TRAIGO LOS DATOS COMPLETOS DE LA TARJETA ///////////////////////

$_SESSION['ParSQL'] = "SELECT * FROM ACUPONES WHERE TAR = ".$TAR." AND NCU = ".$NCU." AND NLO = ".$NLO."";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$PAU = $reg['PAU']; //PRESENTACION
	$FEC = $reg['FEC']; //FECHA
	$SUC = $reg['SUC']; //SUCURSAL
	$NTE = $reg['NTE']; //TERMINAL
	$NCU = $reg['NCU']; //CUPON
	$IMP = $reg['IMP']; //IMPORTE
	$CCU = $reg['CCU']; //CUOTAS
}

///////////////// BUSCA EL NOMBRE DE LA TARJETA ///////////////
$_SESSION['ParSQL'] = "SELECT * FROM ATARJETAS WHERE ID = ".$TAR."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

while ($r1=mssql_fetch_array($RSBTABLA)){

	$TARNOM=$r1['NOM'];
}

if($PAU == "S"){
	$tipo="AUTOMATICA";
}else{
	$tipo="MANUAL";
}

$fecha = $FEC;
$date = new DateTime($fecha);
$fecha = $date->format('d-m-Y H:i');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultar Tarjetas</title>

<style>
.items-tarcon{
font-family: "TPro";
font-size:12px;
text-align:center;
position:absolute;
color:#FFFFFF;
height:16px;

}
</style>


</head>

<body>


	<div class="items-tarcon" style=" top:36px; left:145px; width:30px;" ><? echo $TAR; ?></div>

	<div class="items-tarcon" style=" top:36px; left:182px; width:161px; " ><? echo $TARNOM; ?></div>	
	
	<div class="items-tarcon" style="top:60px; left:145px; width:195px;" > <? echo $tipo; ?></div>
	
	<div class="items-tarcon" style="top:82px; left:145px; width:195px; height:16px;" > <? echo $fecha; ?></div>
	
	<div class="items-tarcon" style="top:107px; left:145px; width:195px; height:16px;" > <? echo $SUC; ?></div>
	
	<div class="items-tarcon" style="top:130px; left:145px; width:195px; height:16px;" > <? echo $NTE; ?></div>
	
	<div class="items-tarcon" style="top:152px; left:145px; width:195px; height:16px;" > <? echo $NCU; ?></div>
	
	<div class="items-tarcon" style="top:176px; left:145px; width:195px; height:16px;" > <? echo dec($IMP,2); ?></div>			
	
	<div class="items-tarcon" style="top:200px; left:145px; width:195px; height:16px;"> <? echo $CCU; ?></div>				



</body>
</html>


<?
$tipo = "";
mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		setTimeout("document.getElementById('controldepaso').value = 0;",1000);
	</script>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>