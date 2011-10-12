<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$PLA = $_REQUEST['pla'];
$BCO = $_REQUEST['bco'];
$NUM = $_REQUEST['num'];
$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];
$NOM = $_SESSION['idsusun'];

///////////////BUSCO TODOS LOS DATOS DEL CHEQUE ////////////////////

$_SESSION['ParSQL'] = "SELECT * FROM TVALOR WHERE PLA = ".$PLA." AND BCO = ".$BCO." AND NUM = ".$NUM."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$IMP = $reg['IMP'];
	$LIB = $reg['LIB'];
	$PCI = $reg['PCI'];
	$LUG = $reg['LUG'];
	$FEE1 = $reg['FEE'];
	$FEP1 = $reg['FEP'];

}

//////////////BUSCO EL BANCO /////////////////

$_SESSION['ParSQL'] = "SELECT desbco FROM BANCOS WHERE ID = ".$BCO;
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);
while ($r1=mssql_fetch_array($RSBTABLA)){

	$BCOSEL = $r1['desbco'];
}

///////////CONVERTIR LA FECHA////////////////

$date1 = new DateTime($FEE1);
$FEE1 = $date1->format('d-m-Y');
$date2 = new DateTime($FEP1);
$FEP1 = $date2->format('d-m-Y');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cheque Detalle</title>
<style>
.items-checon{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}
</style>
</head>
<body>

	<div class="items-checon" style="top:41px; left:19px; width:51px; text-align:center;"><? echo $OPE;?> </div>
	<div class="items-checon" style="top:42px; left:88px; width:200px;"><? echo $NOM;?> </div>		
	<div class="items-checon" style="top:64px; left:82px; width:51px; text-align:center;"><? echo $PLA;?> </div>
	<div class="items-checon" style="top:102px; left:150px; width:25px; text-align:center;"><? echo $BCO;?>	</div>
	<div class="items-checon" style="top:102px; left:187px; width:189px; background-color:#DD7927; text-align:center;"><? echo substr($BCOSEL,0,28);?></div>
	<div class="items-checon" style="top:125px; left:149px; width:96px; text-align:center;" ><? echo $NUM;?></div>
	<div class="items-checon" style="top:147px; left:150px; width:226px; text-align:center;"><? echo $LIB;?></div>
	<div class="items-checon" style="top:170px; left:149px; width:25px; text-align:center;"><? echo $PCI;?></div>
	<div class="items-checon" style="top:170px; left:187px; width:189px; background-color:#DD7927; text-align:center;"><? echo $LUG;?></div>
	<div class="items-checon" style="top:194px; left:149px; width:96px; text-align:center;"><? echo dec($IMP,2);?></div>
	<div class="items-checon" style="top:217px; left:149px; width:96px; text-align:center;"><? echo $FEE1; ?></div>
	<div class="items-checon" style="top:240px; left:149px; width:96px; text-align:center;" ><? echo $FEP1;?></div>

</body>
</html>
<?

	?>
	<script>
		setTimeout("document.getElementById('controldepasoche').value = 0;",1000);
	</script>
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