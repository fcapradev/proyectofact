<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$TER = $_SESSION['ParPOS'];

  
function BuscaTipoIVA($cod,$art){

	$POR = 21;
	$_SESSION['ParSQL'] = "SELECT B.POR FROM ARTICULOS A INNER JOIN ACODIVA B ON A.IvaCO = B.ID WHERE CODSEC= ".$cod." AND CODART= ".$art."";
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$POR = $RART['POR'];
	}	
	
return $POR;

}
  
  
//recibe de los datos a eliminar  
$comp_suc = $_GET['suc'];
$comp_nco = $_GET['nco'];

	
 	$_SESSION['ParSQL'] = "SELECT isnull(MAX(NCO)+1,1) AS ID FROM TMAEFACT WHERE SUC=".$comp_suc."";
	$TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT);
	while ($RTMA=mssql_fetch_array($TMAEFACT)){
    	$num_nuevo = $RTMA['ID'];
	}
  	$elTotal=0;
  
  	$_SESSION['ParSQL'] =  "SELECT * FROM AMAEFACT WHERE SUC=".$comp_suc." AND NCO=".$comp_nco." AND TIP='B' AND TCO='CI'";
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);
	
	while ($RAMA=mssql_fetch_array($AMAEFACT)){
	    
		if (isset($RAMA['TOT'])){
			$elTotal = $elTotal +  0; 
		}else{
			$elTotal = $elTotal + $RAMA['TOT'];
		}
      
	  $fechaGrabar = $RAMA['FEC']; // con el formato que corresponde
	  $date = new DateTime($fechaGrabar);
	  $fechaGrabar = $date->format('Ymd H:i:s');
	  
		$_SESSION['ParSQL'] =  "INSERT INTO TMAEFACT (TIP, TCO, SUC, NCO, FEC, CLI, CUI, TIV, FPA, TCA, NET, NEE, 
		IRI, IRS, IMI, TOT, TUR, ZON, OPE, PRO, NOM, DOM, DE1, DE2, PLA, LUG, LEG, CTA, DC1, DC2, TIF, NFI, TFI, 
		PER, VEN, PAG, URC, NPE, CPP, IMI2, DTO, COD_CONT1, COD_CONT2) 
		VALUES('B', 'TI', ".$comp_suc.", ".$num_nuevo.
		",'".$fechaGrabar."', ".$RAMA['COD'].", '".$RAMA['CUI']."', ".$RAMA['TIV'].", ".$RAMA['FPA'].
		", ".str_replace(",",".",$RAMA['TCA']).", ".str_replace(",",".",$RAMA['NET']).", ".
		str_replace(",",".",$RAMA['NEE']).", ".str_replace(",",".",$RAMA['IRI']).", ".
		str_replace(",",".",$RAMA['IRS']).", ".str_replace(",",".",$RAMA['IMI']).", ".
		str_replace(",",".",$RAMA['TOT']).", ".$RAMA['TUR'].", ".$RAMA['ZON'].", ".$RAMA['VEN'].", '".
		$RAMA['PRO']."', '".$RAMA['NOM']."', '', '', '',".$RAMA['PLA'].", ".$RAMA['LUG'].", '".
		$RAMA['LEG']."', ".$RAMA['CTA'].", '', '',0, '', 0".", ".
		str_replace(",",".",$RAMA['PER']).", ".$RAMA['VEN'].", 0, 0, 0, 0,".
		str_replace(",",".",$RAMA['IMI2']).", ".str_replace(",",".",$RAMA['DTO']).", 0, 0 )";
   		$TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
    	rollback($TMAEFACT);     
      
	}
  
  $_SESSION['ParSQL'] =  "UPDATE AMAEFACT SET NOM='CAMBIO TI',NET=0,NEE=0,IRI=0,IRS=0,IMI=0,TOT=0,IMI2=0,E_HD='',C_HD='', ANU='A' WHERE SUC = ".$comp_suc." AND NCO = ".$comp_nco." AND TIP='B' AND TCO='CI'";
  $TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
  rollback($TMAEFACT);      

  $_SESSION['ParSQL'] =  "SELECT * FROM AMOVFACT WHERE SUC=".$comp_suc." AND NCO=".$comp_nco." AND TIP='B' AND TCO='CI'";
	$AMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMOVFACT);
	$nOrden = 0;
	while ($RAMO=mssql_fetch_array($AMOVFACT)){
              
      $tmpTur = $RAMO['TUR'];
      $tmpLeg = $RAMO['LEG'];
      $nOrden = $nOrden + 1;
		
		$POR = BuscaTipoIVA($RAMO['COD'], $RAMO['ART']);
		
	   $_SESSION['ParSQL'] = "INSERT INTO TMOVFACT VALUES('B', 'TI', ".$comp_suc.", ".$num_nuevo.", ".
	   $RAMO['ORD'].", ".$RAMO['COD'].", ".$RAMO['ART'].", ".$RAMO['RUB'].", ".
	   $RAMO['CON'].", '".$RAMO['TIO']."', ".
	   str_replace(",",".",$RAMO['CAN']).", ".str_replace(",",".",$RAMO['PUN']).", ".
	   str_replace(",",".",$RAMO['NET']).", ".str_replace(",",".",$RAMO['NEX']).", ".
	   str_replace(",",".",$RAMO['IVA']).", ".str_replace(",",".",$RAMO['IVS']).", ".
	   str_replace(",",".",$RAMO['IMI']).", ".str_replace(",",".",$RAMO['PUT']).", ".
	   $RAMO['TUR'].", ".$RAMO['LEG'].", ".$RAMO['PLA'].", ".$RAMO['LUG'].", ".
	   "0, 0, 0, ".str_replace(",",".",$POR).",".str_replace(",",".",$RAMO['IMI2']).", 0,'', ".$TER.")";
       $TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	   rollback($TMOVFACT);             
               
  }
  
  
	$_SESSION['ParSQL'] =  "
	SELECT A.ORD,A.SEC AS  COD ,A.ART,A.PUN, A.PLA, A.LUG, A.CAN,A.PUN FROM AMOVSTOC AS A 
	WHERE NOT EXISTS (SELECT B.TIP,B.TCO,B.NCO,B.SUC,B.ORD,B.COD,B.ART  
	FROM AMOVFACT B WHERE A.TIP=B.TIP AND A.TCO=B.TCO AND A.NCO=B.NCO AND A.SEC=B.COD AND A.ART=B.ART 
	AND A.PVE=B.SUC AND A.CYV='V') 
	AND A.PVE=".$comp_suc." AND A.NCO=".$comp_nco." AND A.TIP='B' AND A.TCO='CI'";
	$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMOVSTOC);
	while ($RAMS=mssql_fetch_array($AMOVSTOC)){
	
      $tmRub = 0;
      $tmNET = 0;
      $tmNEX = 0;
      $tmIVA = 0;
      $tmIVS = 0;
      $tmIMI = 0;
      $tmIMI2 = 0;
      $tmDes = " No Encontrado ";   
      
		$_SESSION['ParSQL'] =  "SELECT CODRUB,DETART,PRENET,IMPIVA,IMPINT,IMPINT2 FROM 
		ARTICULOS WHERE CODSEC=".$RAMS['COD']." AND CODART= ".$RAMS['ART']."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);
		while ($RART=mssql_fetch_array($ARTICULOS)){
		
			$tmNET  = $RART['PRENET'];
			$tmNEX  = 0;
			$tmIVA  = $RART['IMPIVA'];
			$tmIVS  = 0;
			$tmIMI  = $RART['IMPINT'];
			$tmIMI2 = $RART['IMPINT2'];
			$tmDes  = $RART['DETART'];
			$tmRub  = $RART['CODRUB'];
		
		}
		
		$nOrden = $nOrden + 1;
		$_SESSION['ParSQL'] =
		"INSERT INTO TMOVFACT VALUES ('B', 'TI', ".$comp_suc.", ".$num_nuevo.", ".$nOrden.", "
		.$RAMS['COD'].", ".$RAMS['ART'].", ".$tmRub.",0,'".$tmDes."', ".
		str_replace(",",".",$RAMS['CAN']).", ".
		str_replace(",",".",$RAMS['PUN']).", ".
		str_replace(",",".",$tmNET).", ".str_replace(",",".",$tmNEX).", ".
		str_replace(",",".",$tmIVA).", ".str_replace(",",".",$tmIVS).", ".
		str_replace(",",".",$tmIMI).", ".str_replace(",",".",$RAMS['PUN']).", ".
		$tmpTur.", ".$tmpLeg.", ".$RAMS['PLA'].", ".$RAMS['LUG'].", ".
		"1, 0, 0, ".BuscaTipoIVA($RAMS['COD'], $RAMS['ART']).",".str_replace(",",".",$tmIMI2).", 0,'',".$TER.")";
		
		$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMOVFACT);          
		
  	} 
  
	$_SESSION['ParSQL'] = "UPDATE AMOVFACT SET TIO = 'CAMBIO A TI' , CAN = 0, PUN = 0, NET = 0, NEX = 0, IVA = 0, IVS = 0, IMI = 0, PUT = 0, IMI2 = 0, E_HD = '', C_HD = '', COSTO_LP = 0, COSTO_DP = 0 WHERE SUC = ".$comp_suc." AND NCO = ".$comp_nco." AND TIP = 'B' AND TCO = 'CI'";
	$AMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMOVFACT);     
	
	$_SESSION['ParSQL'] = "UPDATE AMOVSTOC SET CAN = 0, PUN = 0, IMI = 0, IMI2 = 0, E_HD = '', C_HD = '', ANU = 'A', JDJ = 'CAMBIO A TI' WHERE PVE=".$comp_suc." AND NCO = ".$comp_nco." AND TIP = 'B' AND TCO = 'CI' AND CYV = 'V'";
	$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMOVSTOC); 


mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>
	jAlert('El comprobante a sido enviado correctamente.', 'Debo Retail - Global Business Solution');
	$("#ReEmitirC").load("REmi.php");
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