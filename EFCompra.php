<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$r_tip = $_REQUEST['tip'];
$r_tco = $_REQUEST['tco'];
$r_suc = $_REQUEST['suc'];
$r_nco = $_REQUEST['nco'];
$r_cod = $_REQUEST['cod'];


	$_SESSION['ParSQL'] = "DELETE PMAEFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod."";
	$DEL_PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMAEFACT);


	$_SESSION['ParSQL'] = "DELETE PMOVFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod."";		
	$DEL_PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DEL_PMOVFACT);


//	LIBERO LOS REMITOS QUE TIENE ASOCIADOS A LA FAC
	$_SESSION['ParSQL'] = "UPDATE PMAEFACT SET REC = 0 WHERE TIP = 'R' AND TCO = 'RE' AND REC = ".$r_nco;
	$LIB_REM = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($LIB_REM);
	
	
mssql_query("commit transaction") or die("Error SQL commit");

$_SESSION['ParOrnC'] = 0;
	?>
	<script>
		ComenzarCompras(2);
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
?>