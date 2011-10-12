<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$CAN = $_REQUEST['cc'];
$SEC = $_REQUEST['cs'];
$ART = $_REQUEST['ca'];


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


$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO_T WHERE SECT = ".$SEC." AND ARTT = ".$ART." AND TER = ".$TER."";
$AARTPRO_TS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($AARTPRO_TS);

if(mssql_num_rows($AARTPRO_TS)==0){
	
	$_SESSION['ParSQL'] = "INSERT INTO AARTPRO_T VALUES (".$CAN.", ".$SEC.", ".$ART.",".$TER.")";
	$AARTPRO_TI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AARTPRO_TI);

}else{

	$_SESSION['ParSQL'] = "UPDATE AARTPRO_T SET CAN = CAN + ".$CAN." WHERE SECT = ".$SEC." AND ARTT = ".$ART." AND TER = ".$TER."";
	$AARTPRO_TU = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AARTPRO_TU);

}


mssql_query("commit transaction") or die("Error SQL commit");
	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}