<?

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

$TOT_NET  = 0;
$TOT_NEX  = 0;
$TOT_IRI  = 0;
$TOT_IRIS = 0;
$TOT_IMI  = 0;
$TOT_IMI2 = 0;

	$_SESSION['ParSQL'] = "SELECT * FROM TMOVFACT_T WHERE ESC = 0 AND TER = ".$TER."";
	$RCALTMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RCALTMOVFACT_T);
	while ($RECALTMOV_T=mssql_fetch_array($RCALTMOVFACT_T)){
		
		$CAN = $RECALTMOV_T['CAN'];
		$PRENET = $RECALTMOV_T['NET'];
		$PRENEX = $RECALTMOV_T['NEX'];
		$IMPIVA = $RECALTMOV_T['IVA'];
		$IMPIVAS = $RECALTMOV_T['IVS'];
		$IMPINT1 = $RECALTMOV_T['IMI'];
		$IMPINT2 = $RECALTMOV_T['IMI2'];		
		$TOT_NET = $TOT_NET   + ($PRENET * $CAN);
		$TOT_NEX = $TOT_NEX   + ($PRENEX * $CAN);
		$TOT_IRI = $TOT_IRI   + ($IMPIVA * $CAN);
		$TOT_IRIS = $TOT_IRIS + ($IMPIVAS * $CAN);
		$TOT_IMI = $TOT_IMI   + ($IMPINT1 * $CAN);
		$TOT_IMI2 = $TOT_IMI2 + ($IMPINT2 * $CAN);		

	} 
	mssql_free_result($RCALTMOVFACT_T);

$TOT_TOT = $TOT_NET + $TOT_NEX + $TOT_IRI + $TOT_IMI + $TOT_IMI2;

$TOT_TOT_G  = $TOT_TOT; 
$TOT_NET_G  = $TOT_NET;
$TOT_NEX_G  = $TOT_NEX;
$TOT_IRI_G  = $TOT_IRI;
$TOT_IRIS_G = $TOT_IRIS; 
$TOT_IMI_G  = $TOT_IMI;
$TOT_IMI2_G = $TOT_IMI2;

$TOT_TOT  = dec($TOT_TOT,2); 
$TOT_NET  = dec($TOT_NET,2);
$TOT_NEX  = dec($TOT_NEX,2);
$TOT_IRI  = dec($TOT_IRI,2);
$TOT_IRIS = dec($TOT_IRIS,2); 
$TOT_IMI  = dec($TOT_IMI,2);
$TOT_IMI2 = dec($TOT_IMI2,2);

?>