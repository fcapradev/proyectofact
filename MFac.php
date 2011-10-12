<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	/////////////////////////////////////////////////////// CUIDADO CON ABRIR OTRO SISTEMA DESDE OTRA PESTAÑA
	///////////////////////////////////////////////////////
	///////// PARA FAC MANUAL /////////////////////////////
	///////////////////////////////////////////////////////
	//SESSION
	if($_SESSION['ParFacSec'] == 1){
		$TER = $_SESSION['ParPOS'];
	}
	if($_SESSION['ParFacSec'] == 2){
		$TER = $_SESSION['ParPOSMa'];
	}
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////
	///////////////////////////////////////////////////////


	$_SESSION['ParSQL'] = "
	SELECT A.TIP, A.TCO, A.SUC, A.NCO, A.FEC, A.CLI, A.CUI, A.NOM, A.FPA, B.NOMBRE AS FPAN FROM TMAEFACT_T AS A 
	INNER JOIN FDPAGO AS B ON A.FPA = B.ID WHERE TER = ".$TER."
	";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	while ($TMAE_T=mssql_fetch_array($TMAEFACT_T)){

		$TIP = $TMAE_T['TIP'];
		$TCO = $TMAE_T['TCO'];
		$SUC = $TMAE_T['SUC'];
		$NCO = $TMAE_T['NCO'];
		$FEC = $TMAE_T['FEC'];
		$CLI = $TMAE_T['CLI'];
		$NOM = $TMAE_T['NOM'];		
		$FPA = $TMAE_T['FPA'];
		$FPAN = $TMAE_T['FPAN'];
		
	}
	unset($TMAE_T);
	mssql_free_result($TMAEFACT_T);
	
	if($CLI == 0){
		$CLI = -1;
	}
	
	$_SESSION['ParSQL'] = "SELECT A.CUIT, B.NOMBRE AS IVAN FROM CLIENTES AS A INNER JOIN IVA AS B ON A.IVA = B.ID WHERE COD = ".$CLI."";
	$IVACLI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($IVACLI);
	while ($IVAC=mssql_fetch_array($IVACLI)){
		$CUIT = $IVAC['CUIT'];
		$IVAN = $IVAC['IVAN'];
	}
	unset($IVAC);
	mssql_free_result($IVACLI);


$date = date_create($FEC);
$FECHA = date_format($date, 'd/m/Y');
$HORA = date_format($date, 'H:i');


/********************************************************************************/
require("Rcal.php");
/********************************************************************************/


mssql_query("commit transaction") or die("Error SQL commit");

if($FPA == 2){
	?>
	<script>
		document.getElementById('PAG').value = "<? echo $TOT_TOT; ?>";
		document.getElementById('VUL').value = "0.00";
	</script>
	<?
}

if($CLI == -1){
	$CLI = 0;
}
$CLI = format($CLI,5,'0',STR_PAD_LEFT);


?>
<script>
	document.getElementById('cliente_fac').innerHTML = "<? echo $CLI." - ".$NOM; ?>";
	document.getElementById('cliente_fac_cui').innerHTML = "<? echo $CUIT; ?>";
	document.getElementById('cliente_fac_iva').innerHTML = "<? echo $IVAN; ?>";
	
	document.getElementById('condicion_fac').innerHTML = "<? echo $FPAN; ?>";
	
	document.getElementById('neto_fac').innerHTML = "<? echo $TOT_NET; ?>";
	document.getElementById('netoexnto_fac').innerHTML = "<? echo $TOT_NEX ; ?>";
	document.getElementById('iva_fac').innerHTML = "<? echo $TOT_IRI; ?>";
	document.getElementById('ivasserv_fac').innerHTML = "<? echo $TOT_IRIS; ?>";
	
	document.getElementById('persep_fac').innerHTML = "0.00";
	document.getElementById('inpuestos1_fac').innerHTML = "<? echo $TOT_IMI; ?>";
	document.getElementById('inpuestos2_fac').innerHTML = "<? echo $TOT_IMI2; ?>";
	document.getElementById('descuentos_fac').innerHTML = "0.00";	
</script>
<?

//esccom("TOTAL","$ ".$TOT_TOT);

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}