<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['p']) ){
	$p = $_REQUEST['p'];
	$n = $_REQUEST['n'];
	$ban = $_REQUEST['ban'];
}else{
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultar</title>
<style>

.fon-ret{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
	color:#FFFFFF;
}

#agregarretiro{ position:absolute;
top:120px;
left:120px;
width:560px;
height:201;

}

#agregarretirobac{
position:absolute;
top:120px;
left:120px;
width:560px;
height:201;
}
</style>

<script>

function salir_ret_con(){

	$("#RetiroEfectivo").load("RetEfe.php?ban=<? echo $ban; ?>");
	
}

</script>


</head>
<body>

<div id="agregarretiro" align="center" style="z-index:0; position:absolute;">
	<img src="RetiroCaja/consulta de caja.png" />
</div>



<div id="agregarretirobac" style="z-index:0; position:absolute; color:#CCCCCC; font:'Tekton Pro'; font-size:12px; font-weight:bold;">

<?
//SELECCIONAR 
$_SESSION['ParSQL'] = "SELECT * FROM ATURRPA WHERE NUM =".$n." AND PLA = ".$p.""; 
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);		
	
	if(mssql_num_rows($registros)==0){
		exit;
	}
	while ($reg=mssql_fetch_array($registros)){
	
		$PLA = $reg['PLA'];
		$OPE = $reg['OPE'];
		$NUM = $reg['NUM'];
		$FEC = $reg['FEC'];
		$OBS_RETIRO = $reg['OBS_RETIRO'];
		$OBS_ANTICIPO = $reg['OBS_ANTICIPO'];
		$EFE = $reg['EFE'];
		$ANT = $reg['ANT'];
		$ANU = $reg['ANU'];		
		
	}
$date1 = new DateTime($FEC);
$FEC = $date1->format('d-m-Y H:i:s');

	
?>
<form >
<div class="fon-ret" style="position:absolute; left:129px; top:11px; width:46px;" align="center"><? echo $OPE;?></div>

<div class="fon-ret" style="position:absolute; left:358px; top:10px; width:15px;" align="center"><? echo $NUM;?></div>

<div class="fon-ret" style="position:absolute; left:470px; top:10px; width:46px;" align="center"><? echo $PLA;?></div>

<div class="fon-ret" style="position:absolute; left:129px; top:31px; width:154px;" align="center"><? echo $_SESSION['idsusun'];?></div>

<div class="fon-ret" style="position:absolute; left:347px; top:24px; width:154px;" align="left"><? echo $FEC; ?></div>

<?
if($ANU == "1"){
?>
	<div style="position:absolute; left:110px; top:54px; width: 117px; height: 27px;">
		<img src="otros/anulado_chico.png" />	</div>
<? } ?>



<div style="position:absolute; left:310px; top:61px;">
	
	<input class="fon-ret" type="text" id="obsret" readonly="readonly" style="width:110px; height:12px; background-color:transparent; border:0;" value="<? echo $OBS_RETIRO; ?>" />
	
</div>

<div style="position:absolute; left:310px; top:132px;">
	
	<input class="fon-ret" type="text" id="obsant" readonly="readonly" style="width:110px; height:12px; background-color:transparent; border:0; "  value="<? echo $OBS_ANTICIPO; ?>"/>
</div>


<div style="position:absolute; left:161px; top:87px;">
	<input class="fon-ret" type="text" id="retiro" readonly="readonly" style="width:116px; height:12px; background-color:transparent; border:0; text-align:right;" value="<? echo dec($EFE,2);?>" />
</div>

<div style="position:absolute; left:161px; top:108px;">
	<input class="fon-ret" type="text" id="anticipo" readonly="readonly" style="width:116px; height:12px; background-color:transparent; border:0; text-align:right;" value="<? echo dec($ANT,2); ?>" />
</div>

<div class="fon-ret" style="position:absolute; left:161px; top:129px; text-align:right; width:116px;">0</div>

<div class="fon-ret" style="position:absolute; left:161px; top:151px; text-align:right; width:116px;">0</div>

<div class="fon-ret" style="position:absolute; left:161px; top:172px;">
	<input class="fon-ret" type="text" id="total" readonly="readonly" style="width:110px; height:12px; background-color:transparent; border:0; " value="<? $t= $EFE + $ANT; echo dec($t,2);?>" />
</div>

</form>

<div id="salirse" style="position:absolute; left:245px; top:270px;">
	<button class="StyBoton" onclick="salir_ret_con();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetVolRetiro','','botones/vol-over.png',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRetiro"/></button>
</div>

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