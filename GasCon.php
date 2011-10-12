<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['p']) ){
	$p = $_REQUEST['p'];
	$n = $_REQUEST['n'];
}else{
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consultar un Gasto</title>
<style>
.fon-gas{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:16px;
	color:#FFFFFF;
}
</style>
<script>

function salir_gas_con(){

	$('#Gastos').fadeOut(500);
	
	$("#Gastos").load("Gastos.php");

	$('#Gastos').fadeIn(500);

}

</script>


</head>

<body>

<div id="agregargasto" style="position:absolute; left:90px; top:0px;">
	<img src="CargaGastos/consultar gastos.png" />
</div>

<div id="agregaritem" style="z-index:0; position:absolute; color:#CCCCCC; font:'Tekton Pro'; font-size:12px; font-weight:bold;">

<form method="post">	
	<?
	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
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
	
		$pla_ver = $reg['PLA'];
		
	}
	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO,FEC, OPE, PLA, NOM, TOT, OBS, ANU FROM PMAEFACT WHERE CG = 'G' AND PLA=".$pla_ver." AND NCO =".$n."  ORDER BY FEC"; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		
	while ($R3=mssql_fetch_array($R1TB)){
		$date = new DateTime($R3['FEC']);
		$FECHA = $date->format('d-m-Y H:i');
	?>
		<div class="fon-gas" style="position:absolute; left:178px; top:47px; width:30px;"><? echo $R3['OPE']; ?></div>
	
		<div class="fon-gas" style="position:absolute; left:178px; top:69px; width:200px;"><? echo $_SESSION['idsusun']; ?></div>
		
		<div class="fon-gas" style="position:absolute; left:185px; top:129px;"><? echo $R3['NCO'];?></div>	
	
		<div class="fon-gas" style="position:absolute; left:170px; top:150px; width:122px;" align="center"><? echo $FECHA;?></div>	
	
		<div class="fon-gas" style="position:absolute; left:315px; top:129px;"><? echo $R3['PLA'];?></div>	
		
		<div id="obsgasdiv" style="position:absolute; left:412px; top:73px; width:211px; height:177px;">
		<textarea class="fon-gas" id="obs2" name="obs2" readonly="readonly" style="outline-style:none; border-style:none; width:203px; height:175px; background-color:transparent; text-transform:uppercase;" maxlength="60" />
<div class="fon-gas">
<? 
echo substr($R3['OBS'], 0, 26); 
echo "<br>";
echo substr($R3['OBS'], 26, 34 ); 
?>
</div>
		</textarea>
        </div>
		<div class="fon-gas" style="position:absolute; left:120px; top:282px; width:250px;"><? echo $R3['NOM'];?></div>
		
		<div class="fon-gas" style="position:absolute; left:506px; top:282px; width:110px;" align="right"><? echo '$ '.dec($R3['TOT'],2);?></div>
		
		<?
		if($R3['ANU'] == "A"){
		?>
			<div style="position:absolute; left:180px; top:200px;">
				<img src="otros/anulado.png" />
			</div>
		<? } ?>
		
		
	<?
	}
	?>

</form>

<div style="position:absolute; left:323px; top:316px;">
	<button class="StyBoton" onclick="salir_gas_con();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetVolGastos','','botones/vol-over.png',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGastos"/></button>
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