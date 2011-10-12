<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


	$OPE = $_SESSION['idsusua'];
	$LUG = $_SESSION['ParLUG'];
	$POS = $_SESSION['ParPOS'];
	
	$_SESSION['ParSQL'] = "
	SELECT C.NplVen AS PLA, A.MTN FROM ATURNOSH AS A 
	INNER JOIN APARPOS AS B ON B.ID = '".$POS."'
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
		$TUR = $reg['MTN'];		
		
	}

	//buscar el proximo numero disponible
	$_SESSION['ParSQL'] = "SELECT ISNULL(MAX(NCO) + 1,1) AS NCO FROM PMAEFACT WHERE CG = 'G' AND PFH = 'N' AND TCO ='CI' AND TIP='B' AND SUC=".$_SESSION['ParPV'].""; 
	$R1TB1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB1);		
	while ($R31=mssql_fetch_array($R1TB1)){
		$SIG_PMAEFACT = $R31['NCO'];
	}
	
	$_SESSION['ParSQL'] = "SELECT ISNULL(MAX(NCO) + 1,1) AS NCO FROM PMOVFACT WHERE TCO ='CI' AND TIP='B' AND SUC=".$_SESSION['ParPV'].""; 
	$R1TB1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB1);		
	while ($R31=mssql_fetch_array($R1TB1)){
		$SIG_PMOVFACT = $R31['NCO'];
	}
	
	if($SIG_PMAEFACT >= $SIG_PMOVFACT){
		$lNum_Gastos = $SIG_PMAEFACT;
	}else{
		$lNum_Gastos = $SIG_PMOVFACT;
	}

	
	$lFEC = date("Ymd H:i:s");

	$OBS = $_POST['obs'];
	$detGas = $_POST['idtipogas'];
	$importe = $_POST['totalgas'];
	
	$importe = str_replace(",",".",$importe);

	$_SESSION['ParSQL'] = "SELECT ID, DESCRIPCION FROM DESC_GASTOS WHERE ID='".$detGas."'"; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);	
	while ($reg=mssql_fetch_array($R1TB)){
	
		$detGas = $reg['DESCRIPCION'];
		}
	  
	    //ENCABEZADO Y PIE
	$_SESSION['ParSQL'] = "INSERT PMAEFACT (CG,PFH,TIP, TCO, SUC, NCO, Fec, Cod, NOM, Cui, TIV, pdt, TCA, DTO, NET, NEE, IRI, IRS, RGA, RIB, PIV, RIV, IMI, CNG, CNG2, PER, TOT, FPA, ZON, fev, OPE, REC, Fep, NPE, CPA, ENV, REm, anu, TUR, Pla, Lug, ATO, CCO, CAI, FECCAI, CHO, CTR, ImA, cca8, cca7, cca6, cca5, cca4, cca3, cca2, cca1, cca9, CCA0, OBS, FecVen)  VALUES ('G','N','B','CI',".$_SESSION['ParPV'].",".$lNum_Gastos.",'".$lFEC."',0,'".$detGas."','',1,0,1,0,".$importe.",0,0,0,0,0,0,0,0,0,0,0,".$importe.",1,1,'". $lFEC."',".$OPE.",0,'". $lFEC."',0,0,0,0,' ',".$TUR.",".$PLA.",".$LUG.",0,0,'','". $lFEC."',1,'',0,0,0,0,0,0,0,0,0,0,0,'".$OBS."','".$lFEC."')";

	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);

	//DETALLE DE LOS MOVIMIENTOS --> CUERPO
	$_SESSION['ParSQL'] = "INSERT PMOVFACT (PRO, TIP, TCO, SUC, NCO, Ord, Cod, Art, Rub, TIO, LI0, CAN, IMI, LEG, CMF, PUN, Tan, iva, TUR, Pla, Lug, CCO, DTO) VALUES (1,'B','CI',".$_SESSION['ParPV'].",".$lNum_Gastos.",1,0,0,1,'Articulo de Gastos por Detalle','',1,0,0,".$OPE.",".$importe.",0,0,".$TUR.",".$PLA.",".$LUG.",0,0)";

	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);

	$_SESSION['ParSQL'] = "UPDATE ATURNOSO SET RGA= RGA + ".$importe." WHERE PLA = ".$PLA." AND LUG = ".$LUG."";
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);

?>
<script>
	jAlert('Gasto Cargado.', 'Debo Retail - Global Business Solution');
	salir_gas();
</script>

<?


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
