<?php

require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){

	$TER = $_SESSION['ParPOS'];

	$TAR = $_POST['CANTARJETAS'];
	$CHE = $_POST['CANCHEQUES'];
	$EFE = $_POST['CANEFECTIVO'];
	$ID_BON = $_POST['dID_BONO'];
	$BON = $_POST['CANBONO'];
	
	$oncli = "";
	
}
if($_SESSION['ParFacSec'] == 2){
	$TER = $_SESSION['ParPOSMa'];
	
	$TAR = $_POST['MaCANTARJETAS'];
	$CHE = $_POST['MaCANCHEQUES'];
	$EFE = $_POST['MaCANEFECTIVO'];
	$ID_BON = $_POST['eID_BONO'];
	$BON = $_POST['MaCANBONO'];

	$oncli = "Ma";

}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////


$ban = 0;
if($TAR == 0 && $CHE == 0 && $EFE != 0 && $BON == 0){ $ban = 1; }
if($TAR == 0 && $CHE != 0 && $EFE == 0 && $BON == 0){ $ban = 3; }
if($TAR != 0 && $CHE == 0 && $EFE == 0 && $BON == 0){ $ban = 4; }
if($TAR == 0 && $CHE == 0 && $EFE == 0 && $BON != 0){ $ban = 5; }


if(($ban == 0) || ($ban == 5)){
	
	$COT = 0;
	if($ID_BON != 0){
		
		////////////////////// BUSCA COTIZACION ACTUAL PARA EL BONO SELECCIONADO ////////////////////////
		$_SESSION['ParSQL'] = "SELECT [COT] FROM CPARBON WHERE ID = ".$ID_BON;
		$CPARBON = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($CPARBON);
		while ($CPARBON_REG=mssql_fetch_array($CPARBON)){
			$COT = $CPARBON_REG['COT'];
		}
		mssql_free_result($CPARBON);
		
	}
	
	////////////////////// BUSCA TOTAL DEL COMPROBANTE  /////////////////////////////////////////////
	$_SESSION['ParSQL'] = "SELECT TOT FROM TMAEFACT_T WHERE TER = ".$TER;
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	while ($TMAEFACT_T_REG=mssql_fetch_array($TMAEFACT_T)){
		$TOT = $TMAEFACT_T_REG['TOT'];
	}
	mssql_free_result($TMAEFACT_T);	

	////////////////////// INSERT EN LA TABLA ///////////////////////////////////////////////////////
	$_SESSION['ParSQL'] = "INSERT INTO AFPAFACT VALUES (".$TER.", '0', '0', 0, 0, ".$TOT.", ".$TAR.", ".$CHE.", ".$EFE.", ".$ID_BON.", ".$BON.", ".$COT.")";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);

	////////////////////// INSERT EN LA TABLA ///////////////////////////////////////////////////////
	$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 99 WHERE TER = ".$TER;
	$TMAEFACT_T_UP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T_UP);
	
	?>
    <script>
		document.getElementById("condicion_fac<? echo $oncli; ?>").innerHTML = "VARIOS";
	</script>
	<?

}


mssql_query("commit transaction") or die("Error SQL commit");
 

?>
<script>
	SoloBlock("<? echo $oncli; ?>bloquerfactur");
	
	EnvAyuda('Terminar para completar el comprobante.');

	document.getElementById("LetTer").innerHTML = '<button class="StyBoton" onclick="<? echo $oncli; ?>confvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';

	SoloBlock("LetTer");
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