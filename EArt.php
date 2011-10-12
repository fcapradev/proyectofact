<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$itemm = $_REQUEST['itemm'];

if(isset($_REQUEST['pro'])){
	$pro = $_REQUEST['pro'];
}else{
	$pro = 0;
}


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


	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, CLI FROM TMAEFACT_T WHERE TER = ".$TER."";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	while ($TMA_INT=mssql_fetch_array($TMAEFACT_T)){

		$TIP = $TMA_INT['TIP'];
		$TCO = $TMA_INT['TCO'];
		$SUC = $TMA_INT['SUC'];
		$NCO = $TMA_INT['NCO'];
		$CodCli = $TMA_INT['CLI'];
				
	}
	

if($pro != 0){
	
	$_SESSION['ParSQL'] = "SELECT SEC, ART FROM TMOVFACT_T WHERE TER = ".$TER." AND COL = ".$itemm." AND ESC = 0";
	$TMOVFACTSEL = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMOVFACTSEL);
	while ($TMOVSEL=mssql_fetch_array($TMOVFACTSEL)){
					
		$CodSec = $TMOVSEL['SEC'];
		$CodArt = $TMOVSEL['ART'];
		
	}

}


$_SESSION['ParSQL'] = "DELETE FROM TMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER." AND COL = ".$itemm;	
$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMOVFACT);


/********************************************************************************/
require("Rcal.php");
/********************************************************************************/


$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET NET = ".$TOT_NET_G.", NEE = ".$TOT_NEX_G.", IRI = ".$TOT_IRI_G.", IMI = ".$TOT_IMI_G.", IMI2 = ".$TOT_IMI2_G.", TOT = ".$TOT_TOT_G." WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND TER = ".$TER."";
$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMAEFACT_T);


mssql_query("commit transaction") or die("Error SQL commit");


///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){
	?>
	<script>
		
		var t = document.getElementById('EliminarTic').value;
		document.getElementById('EliminarTic').value = parseFloat(t) + 1;
		document.getElementById('ComenzarTic').value = 2;
		document.getElementById("total").value = "<? echo $TOT_TOT; ?>";
		
		SoloNone("ElProd");

		SoloBlock("MonedasFon, Monedas");	
		$("#Monedas").load("MMon.php?tot=<? echo $TOT_TOT; ?>");
		
		cancel_mod();

	</script>
	<?
	
	if($CodCli == 0){
		$CodCli = -1;
	}
	
	if($pro != 0){
	?>
    <script>
    	$("#micapa1").load("Control.php?cb=0&cs=<? echo $CodSec; ?>&ca=<? echo $CodArt; ?>&cli=<? echo $CodCli; ?>&pro=1&mod=1");
	</script>
	<?
	}
	if((int)$TOT_TOT == 0){
		?>
		<script>
            SoloNone("LetTer");
        </script>
        <?
	}
}
if($_SESSION['ParFacSec'] == 2){
	?>
	<script>
		
		var t = document.getElementById('MaEliminarTic').value;
		document.getElementById('MaEliminarTic').value = parseFloat(t) + 1;
		document.getElementById('MaComenzarTic').value = 2;
		document.getElementById("Matotal").value = "<? echo $TOT_TOT; ?>";
		
		SoloNone("MaElProd");
		
		SoloBlock("MaMonedasFon, MaMonedas");
		$("#MaMonedas").load("MMon.php?tot=<? echo $TOT_TOT; ?>");
		
		Macancel_mod();
		
	</script>
	<?
	
	if($CodCli == 0){
		$CodCli = -1;
	}
	
	if($pro != 0){
	?>
    <script>
    	$("#Mamicapa1").load("MaControl.php?cb=0&cs=<? echo $CodSec; ?>&ca=<? echo $CodArt; ?>&cli=<? echo $CodCli; ?>&pro=1&mod=1");
	</script>
	<?
	}
	if((int)$TOT_TOT == 0){
		?>
		<script>
            SoloNone("LetTer");
        </script>
        <?
	}
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////

?>
<script>
	$('#Bloquear').fadeOut(500);
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