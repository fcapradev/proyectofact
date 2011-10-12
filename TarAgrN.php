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


//Fabian Vallejo	
if(isset($_POST['aPorFacTarjetas'])){
	$se = "a";
}
if(isset($_POST['bPorFacTarjetas'])){
	$se = "b";
}
if(isset($_POST['cPorFacTarjetas'])){
	$se = "c";
}
if(isset($_POST['dPorFacTarjetas'])){
	$se = "d";
}
if(isset($_POST['ePorFacTarjetas'])){
	$se = "e";
}

if(isset($_POST[$se.'idtarjeta'])){

	$idtar = $_POST[$se.'idtarjeta'];
	$tarfec = date("Y-m-d");
	$tarsuc = $_POST[$se.'sucursal'];
	$tarter = $_POST[$se.'terminal'];
	$tarncu = $_POST[$se.'cupon'];
	$tarimp = $_POST[$se.'importe'];
	$tarimp = str_replace(",",".",$tarimp);	
	$tarcuo = $_POST[$se.'cuotas'];	

}else{
	exit;
}

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}

while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
}

$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];


//////////////////BUSCA EL PAU DE LA TARJETA ////////////////////////

$_SESSION['ParSQL'] = "SELECT * FROM ATARJETAS WHERE ID = ".$idtar."";
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

while ($r1=mssql_fetch_array($RSBTABLA)){

	$tarpau=$r1['PAU'];
}

/////////////////// PARA INSERTAR UNA TARJETA /////////////////////

if ($tarpau == "S"){
	$tarlot = $tarncu;
	$tarEst = "P";
	$tarFpr = "'".$tarfec."'";
}else{
	$tarpau = "N";
	$tarlot = 0;
	$tarEst = "";
	$tarFpr = "NULL";
}


/////////////////// CONTROLA SI YA SE HA CARGADO PREVIAMENTE  /////////////////////
$_SESSION['ParSQL'] = "SELECT * FROM ACUPONES WHERE TAR = ".$idtar." AND CONVERT(CHAR(10),FEC,111) = '".$tarfec."' AND NCU = ".$tarncu." AND LUG = ".$LUG." AND SUC = ".$tarsuc." AND NTE = ".$tarter;
$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($RSBTABLA);

$n = mssql_num_rows($RSBTABLA);	
if( $n > 0){

	$ban = 0;
	?>
	<script>
		jAlert('No puede ingresar más fechas, intente mañana.', 'Debo Retail - Global Business Solution');
	</script>
	<?
	
}else{
	$ban = 1;
}

if($ban == 1){

	if($se == "a"){
		$TarPorFacFor = "";
		$ATO = 0;	
	}else{
		$TarPorFacFor = $se;
		$ATO = -1;
	}

	$_SESSION['ParSQL'] = "INSERT INTO ACUPONES (PLA,LUG,TAR,FEC,NTE,SUC,IMP,CCU,NLI,PAU,NCU,NLO,EST,FPR,ICU,FCU,COD,NFA,ATO) VALUES (".$PLA.",".$LUG.",".$idtar.",getdate(),".$tarter.",".$tarsuc.",".$tarimp.",".$tarcuo.",0,'".$tarpau."',".$tarncu.",".$tarlot.",'".$tarEst."',".$tarFpr.",".$tarimp.",getdate(),".$OPE.", '".$TarPorFacFor."', ".$ATO.")";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);

}else{
	
	?>
	<script>
		jAlert('La Tarjeta no ha podido ser cargada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
	
}


	if($se == "a"){
		?>
		<script>
			jAlert('Tarjeta Agregada.', 'Debo Retail - Global Business Solution');
		</script>
		<?
	}
	if($se == "b"){
		
		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 4 WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);	
		
		?>
		<script>
			SoloBlock("LetEnt");
			TerminarVul();
			confvuel();
		</script>
		<?
	}
	if($se == "c"){

		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 4 WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);	
		
		?>
		<script>
			SoloBlock("LetEnt");
			MaTerminarVul();
		</script>
		<?
	}
	if($se == "d"){

		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 4 WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);	
		
		?>
		<script>
			Ter_nuevatarjeta();
		</script>
		<?	
	}
	if($se == "e"){

		$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET FPA = 4 WHERE TER = ".$TER;
		$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMAEFACT_T);	

		?>
		<script>
			MaTer_nuevatarjeta();
		</script>
		<?
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
?>