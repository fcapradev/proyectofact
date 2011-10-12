<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//POST
$nombre_eve_f = $_POST['nombreevef'];
$direc_eve_f = $_POST['direcevef'];
$cuit_eve_f = $_POST['cuitevef'];
$respon_eve_f = $_POST['responevef'];

//SESSION
$TER = $_SESSION['ParPOS'];

$IDCLI = (int)$TER + 100;
$IDCLI = "-".$IDCLI;


$SQL = "SELECT TIP FROM IVA WHERE ID = ".$respon_eve_f."";
$IVATIP = mssql_query($SQL) or die("Error SQL");
rollback($IVATIP);
while ($IVAT=mssql_fetch_array($IVATIP)){
	$TIP = $IVAT['TIP'];
}


	$fecha = date("Ymd H:i:s");

	$SQL = "SELECT COD FROM CLIENTES WHERE COD = ".$IDCLI."";
	$IDCLIENTES = mssql_query($SQL) or die("Error SQL");
	rollback($IDCLIENTES);
	
	if(mssql_num_rows($IDCLIENTES) == 0){
		
		$SQL = "INSERT INTO CLIENTES VALUES (".$IDCLI.",'".$nombre_eve_f."','".$direc_eve_f."','','', '', '".$cuit_eve_f."', '', 1, '".$TIP."', 0, 0, 0, 0, 0, 0, 0, 'D', '', 0, ".$respon_eve_f.", 1,'FT',1,1,'','".$fecha."',0,0,0,0,0,0,'".$fecha."',0,0,0,'','',0,0,0,'','',0)";
		$IDCLIIN = mssql_query($SQL) or die("Error SQL");
		rollback($IDCLIIN);
		
	}else{
		
		$SQL = "UPDATE CLIENTES SET NOM = '".$nombre_eve_f."', DOM = '".$direc_eve_f."', CUIT = '".$cuit_eve_f."', IVA = ".$respon_eve_f.", TIP = '".$TIP."', TCO = 'FT' WHERE COD = ".$IDCLI."";
		$IDCLIUP = mssql_query($SQL) or die("Error SQL");
		rollback($IDCLIUP);		
		
	}


?>
<script>
	
	document.getElementById('CLI').value = "<? echo $IDCLI; ?>";
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button id="BotLetTerFac" onclick="TerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	SoloNone('LetTer');
	SoloBlock('LetEnt, NumVol');
	
	$("#mostrareventual").fadeOut(tim);
	
	$("#ClientesFa").fadeOut(tim);
	$("#BotonesParaO").fadeOut(tim);
	$("#toda_la_busC").fadeOut(tim);
	$("#mostrar").fadeOut(tim);
	$("#MiProd").fadeOut(tim);
	
	
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