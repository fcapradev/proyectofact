<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$itemm = $_REQUEST['itemm'];
$cc = $_REQUEST['cc'];

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


	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO FROM TMAEFACT_T WHERE TER = ".$TER."";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	while ($TMA_INT=mssql_fetch_array($TMAEFACT_T)){

		$TIP = $TMA_INT['TIP'];
		$TCO = $TMA_INT['TCO'];
		$SUC = $TMA_INT['SUC'];
		$NCO = $TMA_INT['NCO'];
		
	}


/********************************************************************************/
/********************************************************************************/

$_SESSION['ParSQL'] = "UPDATE TMOVFACT_T SET CAN = ".$cc." WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER." AND ORD = ".$itemm."";	
$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMOVFACT);


/********************************************************************************/
	require("Rcal.php");
/********************************************************************************/


mssql_query("commit transaction") or die("Error SQL commit");


///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){
	?>
	<script>
		document.getElementById("CAN<? echo $itemm; ?>").innerHTML = "<? echo $cc; ?>";
		
		var pun = parseFloat(document.getElementById("PUN<? echo $itemm; ?>").innerHTML);
		var can = parseFloat(document.getElementById("CAN<? echo $itemm; ?>").innerHTML);
		
		var subtotal =  can * pun;
			
			var subtotal = parseFloat(subtotal)
			var subtotal = Math.round(subtotal*100)/100
			var subtotal = subtotal.toFixed(2)	
		
		document.getElementById("SUB<? echo $itemm; ?>").innerHTML = subtotal;
		
		document.getElementById("total").value = "<? echo $TOT_TOT; ?>";
		
		SoloBlock("MonedasFon, Monedas");	
		$("#Monedas").load("MMon.php?tot=<? echo $TOT_TOT; ?>");
		
	</script>
	<?
}
if($_SESSION['ParFacSec'] == 2){
	?>
	<script>
		document.getElementById("MaCAN<? echo $itemm; ?>").innerHTML = "<? echo $cc; ?>";
		
		var pun = parseFloat(document.getElementById("MaPUN<? echo $itemm; ?>").innerHTML);
		var can = parseFloat(document.getElementById("MaCAN<? echo $itemm; ?>").innerHTML);
		
		var subtotal =  can * pun;
			
			var subtotal = parseFloat(subtotal)
			var subtotal = Math.round(subtotal*100)/100
			var subtotal = subtotal.toFixed(2)	
		
		document.getElementById("MaSUB<? echo $itemm; ?>").innerHTML = subtotal;
		
		document.getElementById("Matotal").value = "<? echo $TOT_TOT; ?>";	

		SoloBlock("MaMonedasFon, MaMonedas");
		$("#MaMonedas").load("MMon.php?tot=<? echo $TOT_TOT; ?>");
		
    </script>
	<?
	
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>