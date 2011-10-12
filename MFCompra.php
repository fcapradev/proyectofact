<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$TER = $_SESSION['ParPOS'];

//REQUEST
$TIP = $_REQUEST['tip'];
$TCO = $_REQUEST['tco'];
$SUC = $_REQUEST['suc'];
$NCO = $_REQUEST['nco'];
$COD = $_REQUEST['cod'];



	$_SESSION['ParSQL'] = "
	INSERT INTO PMAEFACT_T SELECT *, ".$TER." FROM PMAEFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$COD;
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);

	$_SESSION['ParSQL'] = "
	INSERT INTO PMOVFACT_T SELECT *, ".$TER." FROM PMOVFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);

	$_SESSION['ParSQL'] = "DELETE PMAEFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND COD = ".$COD;
	$DEL_PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMAEFACT);

	$_SESSION['ParSQL'] = "DELETE PMOVFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;
	$DEL_PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMOVFACT);

	$_SESSION['ParSQL'] = "SELECT NCO FROM PMOVFACT_T WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO." AND PRO = ".$COD;
	$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T);
	$_SESSION['ParOrnC'] = mssql_num_rows($PMOVFACT_T);
		


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		document.getElementById('ComenzarCom').value = 2;
		document.getElementById('ComenzarComV2').value = "<? echo $_SESSION['ParOrnC']; ?>";
	</script>
	<?
	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
echo $e;
exit;

}