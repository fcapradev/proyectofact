<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


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
//SESSION
$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];

//POST
$IDTAR = $_POST['NTarjeta'];
$IDCUP = $_POST['NCupon'];


	$_SESSION['ParSQL'] = "SELECT PAU FROM ATARJETAS WHERE ID = ".$IDTAR."";
	$ATARJETAS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATARJETAS);		
	while ($reg=mssql_fetch_array($ATARJETAS)){
		$PAU = $reg['PAU'];
	}
	mssql_free_result($ATARJETAS);


	$_SESSION['ParSQL'] = "SELECT SUC, NCO, CLI, OPE, PLA FROM TMAEFACT_T WHERE TER = ".$TER."";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);		
	while ($reg=mssql_fetch_array($TMAEFACT_T)){
		
		$SUC = $reg['SUC'];
		$NCO = $reg['NCO'];
		$CLI = $reg['CLI'];
		$OPE = $reg['OPE'];
		$PLA = $reg['PLA'];
		
	}
	mssql_free_result($TMAEFACT_T);

	
	$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 4 WHERE TER = ".$TER."";
	$UPTMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($UPTMAEFACT_T);


/********************************************************************************/
	require("Rcal.php");
/********************************************************************************/


$FEC = date("Ymd H:i:s");
$COM = format($SUC,4,'0',STR_PAD_LEFT)."-".format($NCO,8,'0',STR_PAD_LEFT);


if($CLI < 0){
	$CLI = 0;
}

if($PAU == "S"){
	$EST = "P";
	$NLO = $TOT_TOT_G;
}else{
	$EST = " ";
	$NLO = 0;
}

$_SESSION['ParSQL'] = "SELECT NTE FROM ACUPONES WHERE NTE = ".$TER." AND PLA = ".$PLA."";
$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACUPONES);

?>

<?
//if(mssql_num_rows($ACUPONES) == 0){

	$_SESSION['ParSQL'] = "INSERT INTO ACUPONES (PLA,LUG,TAR,FEC,NTE,SUC,IMP,CCU,NLI,PAU,NCU,NLO,EST,FPR,ICU,FCU,COD,NFA,CLI,ATO) VALUES (".$PLA.",".$LUG.",".$IDTAR.",'".$FEC."',".$TER.",".$SUC.",".$TOT_TOT_G.",1,0,'".$PAU."',".$IDCUP.",".$NLO.",'".$EST."','".$FEC."',".$TOT_TOT_G.",'".$FEC."',".$OPE.",'".$COM."',".$CLI.",-1)"; 
	$INACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($INACUPONES);
	
/*
}else{

	$_SESSION['ParSQL'] = "UPDATE ACUPONES SET PLA = ".$PLA.", LUG = ".$LUG.", TAR = ".$IDTAR.", FEC = '".$FEC."', SUC = ".$SUC.", IMP = ".$TOT_TOT_G.", PAU = '".$PAU."', NCU = ".$IDCUP.", NLO = ".$NLO.", EST = '".$EST."', FPR = '".$FEC."', ICU = ".$TOT_TOT_G.", FCU = '".$FEC."' , COD = ".$OPE.", NFA = ".$COM.", CLI = ".$CLI." WHERE NTE = ".$TER." AND ATO = -1"; 
	$UPACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($UPACUPONES);

}
*/

mssql_free_result($ACUPONES);

	
mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}