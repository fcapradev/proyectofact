<?
require("config/cnx.php");
//fabian vallejo // 16/08/2011 17:19


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

$se = "a";

if(isset($_POST['aPorFacCheques'])){
	$se = "a";
}
if(isset($_POST['bPorFacCheques'])){
	$se = "b";
}
if(isset($_POST['cPorFacCheques'])){
	$se = "c";
}
if(isset($_POST['dPorFacCheques'])){
	$se = "d";
}
if(isset($_POST['ePorFacCheques'])){
	$se = "e";
}

if(isset($_POST[$se.'numcheque'])){

	$NUM_CHEQUE = $_POST[$se.'numcheque'];
	$FEP1 = $_POST[$se.'fecpresenta'];
	$FEE1 = $_POST[$se.'fecemision'];
	$IMP = $_POST[$se.'importeChe'];
	$LIB = $_POST[$se.'nomlibra'];
	$LIB = mb_strtoupper($LIB);
	$BCO = $_POST[$se.'banco'];
	$PROV = $_POST[$se.'lugar'];

}else{
	exit;
}

////////// confirmar de que el cheque no existe ////////////////
// fabian vallejo
$_SESSION['ParSQL'] = "SELECT BCO FROM TVALOR WHERE BCO = ".$BCO." AND NUM = ".$NUM_CHEQUE."";
$TVALOR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TVALOR);
	if(mssql_num_rows($TVALOR) > 0){
		?>
		<script>
			
			document.getElementById("<? echo $se; ?>numcheque").value = "";		
			jAlert('El numero del cheque ya se encuentra cargado en el sistema.', 'Debo Retail - Global Business Solution');
			<? echo $se; ?>siguiente_che();
			SoloBlock("LetEnt, NumVol");
			
		</script>	
		<?
		exit;
	}

//////////CONVERTIR LA FECHA////////////////
$fecha_p = explode("/", $FEP1); 
$FEP = $fecha_p[2].$fecha_p[1].$fecha_p[0];

$fecha_e = explode("/", $FEE1); 
$FEE = $fecha_e[2].$fecha_e[1].$fecha_e[0];

if($FEP < $FEE){
	
	?>
	<script>
		$("#Cheques").load("Cheques.php");
		jAlert('La Fecha de Emision no puede ser menor a la de Presentación.', 'Debo Retail - Global Business Solution');
	</script>
	<?
	}else{

		///////////BUSCA LA PROVINCIA//////////////
		$_SESSION['ParSQL'] = "SELECT ID, NOMBRE FROM ANOMPRO WHERE ID = '".$PROV."'";
		$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RSBTABLA);
		while ($r1=mssql_fetch_array($RSBTABLA)){			
			$LUGAR = $r1['NOMBRE'];
		}
		mssql_free_result($RSBTABLA);

		$_SESSION['ParSQL'] = "
		SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
		INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
		INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
		INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
		WHERE A.MTN = D.MTN";
		$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($registros);				
		while ($reg=mssql_fetch_array($registros)){		
			$PLA = $reg['PLA'];
		}
		mssql_free_result($registros);
					
		$LUG = $_SESSION['ParLUG'];
		$OPE = $_SESSION['idsusua'];
		$NOM = $_SESSION['idsusun'];
		
		$OBSE = "INGRESADO EN TIENDA PVE: ".$_SESSION['ParPV'];
		$DE1 = "";
		$NFA = "";
		
		if($se != "a"){
			
			// fabian vallejo
			///////////BUSCA EL BANCO//////////////
			//cFpa = Left("PAGO CHEQUE: " & Left(cfSEC, 8) & ", " & Mid(cfSEC, 10, 20), 39)
			//PAGO CHEQUE: 55555555, 006|GALICIA
			
			if(($se == "c") || ($se == "e")){
				$NFA = $TER;
			}
			
			$_SESSION['ParSQL'] = "SELECT desbco FROM BANCOS WHERE ID = ".$BCO;
			$BANCOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($BANCOS);
			while ($RR1=mssql_fetch_array($BANCOS)){
				$DESBCO = $RR1['desbco'];
			}
			mssql_free_result($BANCOS);
			
			$OBSE = "";
			$PA_DE1 = format($NUM_CHEQUE,8,'0',STR_PAD_LEFT);
			$PA_DE2 = format($BCO,3,'0',STR_PAD_LEFT);;
			$PA_DE3 = $DESBCO;
			$DE1 = "PAGO CHEQUE: ".$PA_DE1.", ".$PA_DE2."|".$PA_DE3;
			$DE1 = substr($DE1,0,39);
						
			$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 3, DE1 = '".$DE1."' WHERE TER = ".$TER;
			$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($TMAEFACT_T);

		}
		
	//////////////////////////////////////////////////////////////////////////
	/////////////////////////////INSERTAR DATOS///////////////////////////////		
	$_SESSION['ParSQL'] = "INSERT INTO TVALOR (CCLIE,VEN,PLA,NUM,FEP,FEE,LUG,IMP,LIB,EST,PCI,BCO,ORI,LUV,OBSE,NFA) 
	VALUES ('00',".$OPE.",".$PLA.",".$NUM_CHEQUE.",'".$FEP."','".$FEE."','".$LUGAR.
	"',".$IMP.",'".$LIB."','C',".$PROV.",'".$BCO."','VE',".$LUG.",'".$OBSE."', '".$NFA."')";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
		
}

		
		
mssql_query("commit transaction") or die("Error SQL commit");


	if($se == "a"){
		?>
		<script>
			jAlert('El cheque ha sido Cargado en el sistema.', 'Debo Retail - Global Business Solution');
			<? echo $se; ?>salir_che_car();
		</script>
		<?
    }
	if($se == "b"){	
		?>
		<script>
			SoloBlock("LetEnt");
			TerminarVul();
			confvuel();
		</script>
		<?
	}
	if($se == "c"){
		?>
		<script>
			SoloBlock("LetEnt");
			MaTerminarVul();
		</script>
		<?
	}
	if($se == "d"){

		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 3, DE1 = '".$DE1."' WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);

		?>
		<script>
			Ter_nuevocheque();
		</script>
		<?
	}
	if($se == "e"){

		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 3, DE1 = '".$DE1."' WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);

		?>
		<script>
			MaTer_nuevocheque();
		</script>
		<?
	}


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}
?>