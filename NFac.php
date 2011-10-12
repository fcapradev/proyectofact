<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function escrivirlog($e){/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$f = fopen('Log/ELog.log','a+');//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	fwrite($f,"".date('Y-m-d h:m:s')." | ".$e." \r\n");///////////////////////////////////////////////////////////////////////////////////////////////
	fclose($f);///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
$SUC = $_SESSION['ParPV'];

//REQUEST
$PAG = $_REQUEST['pag']; 

	$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET CLI = 0 WHERE CLI < 0";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);

	////////////////////////////////////
	////////  ORDENAR ITEMS  ///////////
	////////////////////////////////////
	$_SESSION['ParSQL'] = "SELECT ORD FROM TMOVFACT_T WHERE TER = ".$TER;
	$TMOVFACT_T_TI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMOVFACT_T_TI);
	$c = 0;
	while ($TMOV_TI = mssql_fetch_array($TMOVFACT_T_TI)){
		
		$ORD = $TMOV_TI['ORD'];
		
		$c = $c + 1;
		
		$_SESSION['ParSQL'] = "UPDATE TMOVFACT_T SET ORD = ".$c." WHERE ORD = ".$ORD." AND TER = ".$TER;
		$TMOVFACT_UP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($TMOVFACT_UP);
	
	}
	mssql_free_result($TMOVFACT_T_TI);
	////////////////////////////////////
	////////////////////////////////////
	////////////////////////////////////	


function A_TMAEFACT($PAG,$TER){
	
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
	
	$SUC = $_SESSION['ParPV'];
	
	$_SESSION['ParSQL'] = "SELECT MAX(NCO) + 1 AS NCO FROM TMAEFACT";
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);
	while ($AMAEFACTREG=mssql_fetch_array($AMAEFACT)){
		if($AMAEFACTREG['NCO'] == NULL){
			$NCO = 1;
		}else{
			$NCO = $AMAEFACTREG['NCO'];
		}
	}
	
	$NFA = format($SUC,4,'0',STR_PAD_LEFT)."-".format($NCO,8,'0',STR_PAD_LEFT);
	
	$_SESSION['ParSQL'] = "SELECT TIP, TCO FROM TMAEFACT_T WHERE TER = ".$TER;
	$TMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_TT);		
	while ($TT_REG = mssql_fetch_array($TMAEFACT_TT)){
		$TIPP = $TT_REG['TIP'];
		$TCOO = $TT_REG['TCO'];
	}
	mssql_free_result($TMAEFACT_TT);
	
	$_SESSION['ParSQL'] = "UPDATE TMAEFACT_T SET NCO = ".$NCO.", PAG = ".$PAG." WHERE TER = ".$TER."";
	$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT_T);
	
	$_SESSION['ParSQL'] = "UPDATE TMOVFACT_T SET NCO = ".$NCO." WHERE TER = ".$TER."";
	$TMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMOVFACT_T);
	
	$_SESSION['ParSQL'] = "INSERT INTO TMAEFACT SELECT TIP, TCO, SUC, NCO, FEC, CLI, CUI, TIV, FPA, TCA, NET, NEE, IRI, IRS, IMI, TOT, TUR, ZON, OPE, PRO, NOM, DOM, DE1, DE2, PLA, LUG, LEG, CTA, DC1, DC2, TIF, NFI, TFI, PER, VEN, PAG, URC, NPE, CPP, IMI2, DTO, COD_CONT1, COD_CONT2 FROM TMAEFACT_T WHERE TER = ".$TER;
	$TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT);
	
	$_SESSION['ParSQL'] = "INSERT INTO TMOVFACT SELECT TIP, TCO, SUC, NCO, ORD, SEC, ART, RUB, CON, DES, CAN, PUN, NET, NEX, IVA, IVS, IMI, PUT, TUR, LEG, PLA, LUG, ESC, SUR, CMF, TIVA, IMI2, COD_CONT1, SINO FROM TMOVFACT_T WHERE TER = ".$TER;
	$TMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMOVFACT);
	
	$_SESSION['ParSQL'] = "UPDATE TMAEFACT SET DC1 = ' ' WHERE NCO = ".$NCO."";
	$TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TMAEFACT);

	$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE TER = ".$TER;
	$DELTMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DELTMAEFACT_T);
	
	$_SESSION['ParSQL'] = "DELETE TMOVFACT_T WHERE TER = ".$TER;
	$DELTMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($DELTMOVFACT_T);

	$_SESSION['ParSQL'] = "UPDATE ACUPONES SET NFA = '".$NFA."', ATO = 0 WHERE NTE = ".$TER." AND ATO = -1";
	$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ACUPONES);

////////////////////////////////////////////////////////////////////////////////
////////// GRABAR FORMAS DE PAGO  EN AFPAFACT //////////////////////////////////
	$_SESSION['ParSQL'] = "UPDATE AFPAFACT SET TIP = '".$TIPP."', TCO = '".$TCOO."', SUC = ".$SUC.", NCO = ".$NCO." WHERE SUC = 0 AND NCO = 0 AND TER = ".$TER;
	$AFPAFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AFPAFACT);
////////////////////////////////////////////////////////////////////////////////

}



/* Marcelo Aielllo*/
/***********************************************************************************************************************************/
function A_AMAEFAC($t,$c,$s,$n){

    
    /////////////////////////////////////////////
    //AGREGADO FEDERICO CORDOBA
    $turno = 0;
    $planilla = 0;
    $lug = $_SESSION['ParLUG'];
    $legajo = $_SESSION['idsusua'];
    //////////////////////////////////////////////
    
// abrir la tamaefact_T y tmovfact_t
/// debe ir la rutina de busqueda de sucursal por si el comprobante ya se encuentra cargado.

$TER = $_SESSION['ParPOS'];

$NroPVE = $_SESSION['ParPV'];
$NumMFI = 0;



	$_SESSION['ParSQL'] = "SELECT isnull(MAX(NCO) + 1, 1) AS NCO FROM AMAEFACT WHERE TIP = 'B' AND TCO = 'CI'";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	while ($RB=mssql_fetch_array($RSBTABLA)){
		 $NUF = $RB['NCO'];
	}

	$NFA = format($s,4,'0',STR_PAD_LEFT)."-".format($NUF,8,'0',STR_PAD_LEFT);;

	$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT_T WHERE TIP = '".$t."' AND TCO = '".$c."' AND SUC = ".$s." AND NCO = ".$n; 
	$RATB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RATB);		
	while ($RA=mssql_fetch_array($RATB)){

		/// CLIENTE
		$CCLIE = $RA['CLI'];
		
		$Fecha_a_Grabar = $RA['FEC'];
		$date = new DateTime($Fecha_a_Grabar);
		$Fecha_a_Grabar = $date->format('Ymd H:i:s');

    		$_SESSION['ParSQL'] = "INSERT AMAEFACT                                                    
            (CYV,TIP,TCO,SUC,NCO,NMF,FEC,COD,CUI,TIV,FPA,TCA,PDT,DTO,NET,NEE,IRI,
            IRS,IMI,TOT,TUR,ZON,FEV,VEN,OPE,REC,REP,NPE,CPA,ENV,REM,PRO,ANU,NTA,
            NCU,CCU,NOM,PLA,LUG,LEG,CTA,FAR,CAI,FECCAI,CCO,PER,APR,IMI2) VALUES (
            'V','B','CI',".$NroPVE.",".$NUF.",".$NumMFI.",'".$Fecha_a_Grabar."',".$RA['CLI'].",'".$RA['CUI']."',"
            .$RA['TIV'].",".$RA['FPA'].",".$RA['TCA'].",0,"
            .str_replace(",", ".",$RA['DTO']).","
            .str_replace(",", ".",$RA['NET']).","
            .str_replace(",", ".",$RA['NEE']).","
            .str_replace(",", ".",$RA['IRI']).","
            .str_replace(",", ".",$RA['IRS']).","
            .str_replace(",", ".",$RA['IMI']).","
            .str_replace(",", ".",$RA['TOT']).",".$RA['TUR'].",".$RA['ZON'].",'".$Fecha_a_Grabar."',".$RA['OPE'].
            ",".$RA['VEN'].",0,0,0,0,0,0,'','',0,0,0,'".substr($RA['NOM'],0,20)."',".$RA['PLA'].",".$RA['LUG'].",'".$RA['LEG'].
            "',".$RA['TCA'].",0,'','".$Fecha_a_Grabar."',".$RA['COD_CONT1'].","
            .str_replace(",", ".",$RA['PER']).", 0,"
            .str_replace(",", ".",$RA['IMI2']).")";
            $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($RSBTABLA);
            
    		$_SESSION['ParSQL'] = "INSERT AMAEFACT2                                                     
            (CYV,TIP,TCO,SUC,NCO,NMF,FEC,COD,CUI,TIV,FPA,TCA,PDT,DTO,NET,NEE,IRI,
            IRS,IMI,TOT,TUR,ZON,FEV,VEN,OPE,REC,REP,NPE,CPA,ENV,REM,PRO,ANU,NTA,
            NCU,CCU,NOM,PLA,LUG,LEG,CTA,FAR,CAI,FECCAI,CCO,PER,APR,IMI2) VALUES (
            'V','B','CI',".$NroPVE.",".$NUF.",".$NumMFI.",'".$Fecha_a_Grabar."',".$RA['CLI'].",'".$RA['CUI']."',"
            .$RA['TIV'].",".$RA['FPA'].",".$RA['TCA'].",0,"
            .str_replace(",", ".",$RA['DTO']).","
            .str_replace(",", ".",$RA['NET']).","
            .str_replace(",", ".",$RA['NEE']).","
            .str_replace(",", ".",$RA['IRI']).","
            .str_replace(",", ".",$RA['IRS']).","
            .str_replace(",", ".",$RA['IMI']).","
            .str_replace(",", ".",$RA['TOT']).",".$RA['TUR'].",".$RA['ZON'].",'".$Fecha_a_Grabar."',".$RA['OPE'].
            ",".$RA['VEN'].",0,0,0,0,0,0,'','',0,0,0,'".substr($RA['NOM'],0,20)."',".$RA['PLA'].",".$RA['LUG'].",'".$RA['LEG'].
            "',".$RA['TCA'].",0,'','".$Fecha_a_Grabar."',".$RA['COD_CONT1'].","
            .str_replace(",", ".",$RA['PER']).", 0,"
            .str_replace(",", ".",$RA['IMI2']).")";
            $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($RSBTABLA);

  		
  		$_SESSION['ParSQL'] = "SELECT * FROM TMOVFACT_T WHERE TIP='".$RA['TIP']."' AND TCO='".$RA['TCO']."' AND SUC=".$RA['SUC'].
      " AND NCO=".$RA['NCO']."";
  		$R1DEL = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
  		rollback($R1DEL);
			
      while ($R1=mssql_fetch_array($R1DEL)){
		  
          if($R1['ESC']==0){
          
              $_SESSION['ParSQL'] = "INSERT AMOVFACT 
              (CYV,TIP,TCO,SUC,NCO,NMF,ORD,COD,ART,RUB,CON,TIO,LIO,CAN,PUN,IVA,IVS,
              NET,NEX,IMI,IMI2,PUT,TUR,LEG,CMF,PLA,LUG,ESC,CCO) VALUES ('V','B','CI',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].",".$R1['SEC'].
              ",".$R1['ART'].",".$R1['RUB'].",0,'".substr($R1['DES'], 0, 30)."','',"
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).","
              .str_replace(",", ".",$R1['IVA']).","
              .str_replace(",", ".",$R1['IVS']).","   
              .str_replace(",", ".",$R1['NET']).","
              .str_replace(",", ".",$R1['NEX']).","
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).","
              .str_replace(",", ".",$R1['PUT']).","
              .$R1['TUR'].", ".$R1['LEG'].",".$R1['CMF'].",".$R1['PLA'].",".$R1['LUG'].",0,".$R1['COD_CONT1'].")";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
  
              $_SESSION['ParSQL'] = "INSERT AMOVFACT2 
         (CYV,TIP,TCO,SUC,NCO,NMF,ORD,COD,ART,RUB,CON,TIO,LIO,CAN,PUN,IVA,IVS,
              NET,NEX,IMI,IMI2,PUT,TUR,LEG,CMF,PLA,LUG,ESC,CCO) VALUES ('V','B','CI',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].",".$R1['SEC'].",".$R1['ART'].",".$R1['RUB'].
              ",0,'".substr($R1['DES'], 0, 30)."','',"
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).","
              .str_replace(",", ".",$R1['IVA']).","
              .str_replace(",", ".",$R1['IVS']).","   
              .str_replace(",", ".",$R1['NET']).","
              .str_replace(",", ".",$R1['NEX']).","
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).","
              .str_replace(",", ".",$R1['PUT']).","
              .$R1['TUR'].",".$R1['LEG'].",".$R1['CMF'].",".$R1['PLA'].",".$R1['LUG'].",0,".$R1['COD_CONT1'].")";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
  
          }    
          // graba amovstoc si o si    
              $_SESSION['ParSQL'] = "INSERT AMOVSTOC 
              (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES("
              .$R1['SEC'].",".$R1['ART'].",'".$Fecha_a_Grabar."','V','B','CI',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].","
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).",".$RA['CLI'].",0,"
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).",".$R1['PLA'].",".$R1['LUG'].",'Ve')";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
			  
      }
    /////////////////////////////////////////////
    //AGREGADO FEDERICO CORDOBA      
      $turno = $RA['TUR'];
      $planilla = $RA['PLA'];
      $lug = $RA['LUG'];
      ////////////////////////////////////////

  }

$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE TER = ".$TER."";
$DELETETMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DELETETMAEFACT_T);

$_SESSION['ParSQL'] = "DELETE TMOVFACT_T WHERE TER = ".$TER."";
$DELETETMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DELETETMAEFACT_T);

$_SESSION['ParSQL'] = "UPDATE ACUPONES SET NFA = '".$NFA."', ATO = 0 WHERE NTE = ".$TER." AND ATO = -1";
$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACUPONES);

////////////////////////////////////////////////////////////////////////////////
////////// GRABAR CHEQUES COMPROBANTE A LA AMAEFACT ////////////////////////////
	if($CCLIE == -1){
		$CCLIE = 0;
	}
	
	$OBSE = "B CI ".format($NroPVE,4,'0',STR_PAD_LEFT)."-".format($NUF,8,'0',STR_PAD_LEFT)."";
	
	$_SESSION['ParSQL'] = "UPDATE TVALOR SET CCLIE = ".$CCLIE.", PVEC = ".$NroPVE.", NCOC = ".$NUF.", OBSE = '".$OBSE."', NFA = '' WHERE NFA = ".$TER;
	$TVALOR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TVALOR);
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
////////// GRABAR FORMAS DE PAGO  EN AFPAFACT //////////////////////////////////
	$_SESSION['ParSQL'] = "UPDATE AFPAFACT SET TIP = 'B', TCO = 'CI', SUC = ".$NroPVE.", NCO = ".$NUF." WHERE SUC = 0 AND NCO = 0 AND TER = ".$TER;
	$AFPAFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AFPAFACT);
////////////////////////////////////////////////////////////////////////////////
        
    

    /////////////////////////////////////////////
    //AGREGADO FEDERICO CORDOBA      
    $COMPROBANTE = $_REQUEST['comprobante']; 
    $MESA = $_REQUEST['mesa']; 
    $CIERRE = $_REQUEST['cierre']; 

  
    

    if ($MESA > 0){
        
        if ($CIERRE!='0'){
          
  
            $_SESSION['ParSQL'] = "UPDATE AMOVMESA SET FAC = 2, LEG = ".$legajo.", TUR = ".$turno.", PLA = ".$planilla.", LUG = ".$lug." WHERE NCO = ".$COMPROBANTE." AND MRT = ".$MESA;
            $AMOVMESA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($AMOVMESA);  
            
            $_SESSION['ParSQL'] = "UPDATE AMAEMESA SET FAC = 2, CER = 'S', TOT = ".$CIERRE.", TUR = ".$turno.", PLA = ".$planilla.", LUG = ".$lug." WHERE NCO = ".$COMPROBANTE." AND MRT = ".$MESA;
            $AMAEMESA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($AMAEMESA);  

            $_SESSION['ParSQL'] = "UPDATE AMESAS  SET EST = 'D' WHERE  MRT = ".$MESA;
            $AMAEMESA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($AMAEMESA);  

            $_SESSION['ParSQL'] = "UPDATE AMESAS  SET UNI = 0, EST = 'D' WHERE  UNI = ".$MESA;
            $AMAEMESA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($AMAEMESA);              
        }
        else{
            $_SESSION['ParSQL'] = "UPDATE AMOVMESA SET FAC = 2, LEG = ".$legajo.", TUR = ".$turno.", PLA = ".$planilla.", LUG = ".$lug." WHERE FAC = 1 AND NCO = ".$COMPROBANTE." AND MRT = ".$MESA;
            $AMOVMESA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($AMOVMESA);  
            
        }

    }   
}
/***********************************************************************************************************************************/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function A_AMAEFAC_MANUAL($t,$c,$s,$n){
	
// abrir la tamaefact_T y tmovfact_t
/// debe ir la rutina de busqueda de sucursal por si el comprobante ya se encuentra cargado.

///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
$TER = $_SESSION['ParPOSMa'];
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////


$NroPVE = $s;
$NUF = $n;
$NumMFI = 0;
$NFA = format($s,4,'0',STR_PAD_LEFT)."-".format($NUF,8,'0',STR_PAD_LEFT);;


	$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT_T WHERE TER = ".$TER."";
	$RATB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RATB);		
	while ($RA=mssql_fetch_array($RATB)){
		
		/// CLIENTE
		$CCLIE = $RA['CLI'];
		
		$Fecha_a_Grabar = $RA['FEC'];
		$date = new DateTime($Fecha_a_Grabar);
		$Fecha_a_Grabar = $date->format('Ymd H:i:s');

    		$_SESSION['ParSQL'] = "INSERT AMAEFACT                                                    
            (CYV,TIP,TCO,SUC,NCO,NMF,FEC,COD,CUI,TIV,FPA,TCA,PDT,DTO,NET,NEE,IRI,
            IRS,IMI,TOT,TUR,ZON,FEV,VEN,OPE,REC,REP,NPE,CPA,ENV,REM,PRO,ANU,NTA,
            NCU,CCU,NOM,PLA,LUG,LEG,CTA,FAR,CAI,FECCAI,CCO,PER,APR,IMI2) VALUES (
            'V','".$t."','".$c."',".$NroPVE.",".$NUF.",".$NumMFI.",'".$Fecha_a_Grabar."',".$RA['CLI'].",'".$RA['CUI']."',"
            .$RA['TIV'].",".$RA['FPA'].",".$RA['TCA'].",0,"
            .str_replace(",", ".",$RA['DTO']).","
            .str_replace(",", ".",$RA['NET']).","
            .str_replace(",", ".",$RA['NEE']).","
            .str_replace(",", ".",$RA['IRI']).","
            .str_replace(",", ".",$RA['IRS']).","
            .str_replace(",", ".",$RA['IMI']).","
            .str_replace(",", ".",$RA['TOT']).",".$RA['TUR'].",".$RA['ZON'].",'".$Fecha_a_Grabar."',".$RA['OPE'].
            ",".$RA['VEN'].",0,0,0,0,0,0,'','',0,0,0,'".substr($RA['NOM'],0,20)."',".$RA['PLA'].",".$RA['LUG'].",'".$RA['LEG'].
            "',".$RA['TCA'].",0,'','".$Fecha_a_Grabar."',".$RA['COD_CONT1'].","
            .str_replace(",", ".",$RA['PER']).", 0,"
            .str_replace(",", ".",$RA['IMI2']).")";
            $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($RSBTABLA);
            
    		$_SESSION['ParSQL'] = "INSERT AMAEFACT2                                                     
            (CYV,TIP,TCO,SUC,NCO,NMF,FEC,COD,CUI,TIV,FPA,TCA,PDT,DTO,NET,NEE,IRI,
            IRS,IMI,TOT,TUR,ZON,FEV,VEN,OPE,REC,REP,NPE,CPA,ENV,REM,PRO,ANU,NTA,
            NCU,CCU,NOM,PLA,LUG,LEG,CTA,FAR,CAI,FECCAI,CCO,PER,APR,IMI2) VALUES (
            'V','".$t."','".$c."',".$NroPVE.",".$NUF.",".$NumMFI.",'".$Fecha_a_Grabar."',".$RA['CLI'].",'".$RA['CUI']."',"
            .$RA['TIV'].",".$RA['FPA'].",".$RA['TCA'].",0,"
            .str_replace(",", ".",$RA['DTO']).","
            .str_replace(",", ".",$RA['NET']).","
            .str_replace(",", ".",$RA['NEE']).","
            .str_replace(",", ".",$RA['IRI']).","
            .str_replace(",", ".",$RA['IRS']).","
            .str_replace(",", ".",$RA['IMI']).","
            .str_replace(",", ".",$RA['TOT']).",".$RA['TUR'].",".$RA['ZON'].",'".$Fecha_a_Grabar."',".$RA['OPE'].
            ",".$RA['VEN'].",0,0,0,0,0,0,'','',0,0,0,'".substr($RA['NOM'],0,20)."',".$RA['PLA'].",".$RA['LUG'].",'".$RA['LEG'].
            "',".$RA['TCA'].",0,'','".$Fecha_a_Grabar."',".$RA['COD_CONT1'].","
            .str_replace(",", ".",$RA['PER']).", 0,"
            .str_replace(",", ".",$RA['IMI2']).")";
            $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
            rollback($RSBTABLA);

  		
  		$_SESSION['ParSQL'] = "SELECT * FROM TMOVFACT_T WHERE TER = ".$TER."";
  		$R1DEL = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
  		rollback($R1DEL);
			
      while ($R1=mssql_fetch_array($R1DEL)){
		  
          if($R1['ESC']==0){

          
              $_SESSION['ParSQL'] = "INSERT AMOVFACT 
              (CYV,TIP,TCO,SUC,NCO,NMF,ORD,COD,ART,RUB,CON,TIO,LIO,CAN,PUN,IVA,IVS,
              NET,NEX,IMI,IMI2,PUT,TUR,LEG,CMF,PLA,LUG,ESC,CCO) VALUES ('V','".$t."','".$c."',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].",".$R1['SEC'].
              ",".$R1['ART'].",".$R1['RUB'].",0,'".substr($R1['DES'], 0, 30)."','',"
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).","
              .str_replace(",", ".",$R1['IVA']).","
              .str_replace(",", ".",$R1['IVS']).","   
              .str_replace(",", ".",$R1['NET']).","
              .str_replace(",", ".",$R1['NEX']).","
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).","
              .str_replace(",", ".",$R1['PUT']).","
              .$R1['TUR'].", ".$R1['LEG'].",".$R1['CMF'].",".$R1['PLA'].",".$R1['LUG'].",0,".$R1['COD_CONT1'].")";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
  
              $_SESSION['ParSQL'] = "INSERT AMOVFACT2 
         (CYV,TIP,TCO,SUC,NCO,NMF,ORD,COD,ART,RUB,CON,TIO,LIO,CAN,PUN,IVA,IVS,
              NET,NEX,IMI,IMI2,PUT,TUR,LEG,CMF,PLA,LUG,ESC,CCO) VALUES ('V','".$t."','".$c."',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].",".$R1['SEC'].",".$R1['ART'].",".$R1['RUB'].
              ",0,'".substr($R1['DES'], 0, 30)."','',"
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).","
              .str_replace(",", ".",$R1['IVA']).","
              .str_replace(",", ".",$R1['IVS']).","   
              .str_replace(",", ".",$R1['NET']).","
              .str_replace(",", ".",$R1['NEX']).","
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).","
              .str_replace(",", ".",$R1['PUT']).","
              .$R1['TUR'].",".$R1['LEG'].",".$R1['CMF'].",".$R1['PLA'].",".$R1['LUG'].",0,".$R1['COD_CONT1'].")";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
  
          }    
          // graba amovstoc si o si    
              $_SESSION['ParSQL'] = "INSERT AMOVSTOC 
              (SEC,ART,FEC,CYV,TIP,TCO,PVE,NCO,NMF,ORD,CAN,PUN,COD,DTO,IMI,IMI2,PLA,LUG,TIM) VALUES("
              .$R1['SEC'].",".$R1['ART'].",'".$Fecha_a_Grabar."','V','".$t."','".$c."',"
              .$NroPVE.",".$NUF.",".$NumMFI.",".$R1['ORD'].","
              .str_replace(",", ".",$R1['CAN']).","
              .str_replace(",", ".",$R1['PUN']).",".$RA['CLI'].",0,"
              .str_replace(",", ".",$R1['IMI']).","
              .str_replace(",", ".",$R1['IMI2']).",".$R1['PLA'].",".$R1['LUG'].",'Ve')";
              $RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
              rollback($RSBTABLA);
			  
      }

  }

$com = $t."-".$c."-".$NroPVE."-".$NUF;

?>
<script>
	jAlert('El comprobante fue grabado como <? echo $com; ?>', 'Debo Retail - Global Business Solution');
</script>
<?

$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE TER = ".$TER."";
$DELETETMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DELETETMAEFACT_T);

$_SESSION['ParSQL'] = "DELETE TMOVFACT_T WHERE TER = ".$TER."";
$DELETETMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($DELETETMAEFACT_T);

////////////////////////////////////////////// mirar
$_SESSION['ParSQL'] = "UPDATE ACUPONES SET NFA = '".$NFA."', ATO = 0 WHERE NFA = 'e' AND ATO = -1";
$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACUPONES);


////////////////////////////////////////////////////////////////////////////////
////////// GRABAR CHEQUES COMPROBANTE A LA AMAEFACT ////////////////////////////
	if($CCLIE == -1){
		$CCLIE = 0;
	}
	
	$OBSE = $t." ".$c." ".$NFA;
	
	$_SESSION['ParSQL'] = "UPDATE TVALOR SET CCLIE = ".$CCLIE.", PVEC = ".$NroPVE.", NCOC = ".$NUF.", OBSE = '".$OBSE."', NFA = '' WHERE NFA = ".$TER;
	$TVALOR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($TVALOR);
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
////////// GRABAR FORMAS DE PAGO  EN AFPAFACT //////////////////////////////////
	$_SESSION['ParSQL'] = "UPDATE AFPAFACT SET TIP = '".$t."', TCO = '".$c."', SUC = ".$NroPVE.", NCO = ".$NUF." WHERE SUC = 0 AND NCO = 0 AND TER = ".$TER;
	$AFPAFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AFPAFACT);
////////////////////////////////////////////////////////////////////////////////

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function fPorDecision(){
	//RETORNA UN VALOR QUE ES UN PORCENTAJE DE FACTURACION.
	$porDecision = 75;
	//si es nulo por fefecto = 75
	$_SESSION['ParSQL'] = "SELECT POR FROM ACONFTICK WHERE SEC = -1";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		$porDecision = $RB['POR'];
	}
	return $porDecision;
}


function Comprobantes_Facturados($SumaActual,$PLA){

  $Comprobantes_Facturados = 0;

	$_SESSION['ParSQL'] = "SELECT TCO, isnull(SUM(TOT),1) AS CANT FROM AMAEFACT A WHERE PLA = ".$PLA." AND ANU<>'A' GROUP BY A.TCO";	
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	  $TOT_CI = 0;
      $TOT_FT = 0;
	  $TOT_TI = 0;
      $TOT_GRAL = 0;
	while ($RB=mssql_fetch_array($RSBTABLA)){
		
		//si es nulo por fefecto = 75
		//$porDecision = $RB['POR'];
		
        if ($RB['TCO'] == "CI") {$TOT_CI = $TOT_CI + $RB['CANT'];}
		if ($RB['TCO'] == "FT") {$TOT_FT = $TOT_FT + $RB['CANT'];}
		if ($RB['TCO'] == "TI") {$TOT_TI = $TOT_TI + $RB['CANT'];}
        $TOT_GRAL = $TOT_GRAL + $RB['CANT'];
		
	}

	//se agrega la suma parcial para determinar con este importe si corresponde o no hacer factura
	$TOT_FT = $TOT_FT + $SumaActual;
	
	if($TOT_GRAL <> 0) {
		$Comprobantes_Facturados = ($TOT_FT / $TOT_GRAL) * 100;
	}else{
		$Comprobantes_Facturados = ($TOT_FT) * 100;
	}
   
return $Comprobantes_Facturados;
   
}


/********************************************************************************/
	require("Rcal.php");
/********************************************************************************/

	$porDecision = fPorDecision();
	
// hay que ver que existen productos que si o si exigen que se emite el comprobante en CF = ejemplo cigarrillos
	$swImprimeTI_SioSI = false;
	$swImprimeCI_SioSI = false;
	
	$_SESSION['ParSQL'] = "
	SELECT B.POR FROM TMOVFACT_T AS A 
	INNER JOIN ACONFTICK AS B ON A.SEC = b.SEC AND A.RUB = B.RUB
	WHERE A.ESC = 0 AND TER = ".$TER." AND POR = 100";

	$ACONFTICK = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ACONFTICK);
	if(mssql_num_rows($ACONFTICK)==0){
		//$swImprimeTI_SioSI = false;
		$_SESSION['ParSQL'] = "
		SELECT B.POR FROM TMOVFACT_T AS A 
		INNER JOIN ACONFTICK AS B ON A.SEC = b.SEC AND A.RUB = B.RUB
		WHERE A.ESC = 0 AND TER = ".$TER." AND POR <> 100";
	
		$ACONFTICK = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ACONFTICK);
		if(mssql_num_rows($ACONFTICK)==0){
			$swImprimeTI_SioSI = false;
			$swImprimeCI_SioSI = true;
		}

	}else{
		$swImprimeTI_SioSI = true;

		/*
		while ($ACONF = mssql_fetch_array($ACONFTICK)){
			$POR = $ACONF['POR'];
		}
		if($POR == 0){
			$swImprimeTI_SioSI = false;
		}else{
			if($POR == -1){
				$swImprimeTI_SioSI = false;
			}
		}
		*/
	}
	//mssql_free_result($ACONFTICK);

    
$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, PLA, CLI, FPA FROM TMAEFACT_T WHERE TER = ".$TER."";
$TMAEFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMAEFACT_T);
while ($TMAT_T=mssql_fetch_array($TMAEFACT_T)){
	
	$TIP = trim($TMAT_T['TIP']);
	$TCO = trim($TMAT_T['TCO']);
	$SUC = $TMAT_T['SUC'];
	$NCO = $TMAT_T['NCO'];
	$PLA = $TMAT_T['PLA'];
	$CLI = $TMAT_T['CLI'];
	$FPA = $TMAT_T['FPA'];
		
}
//mssql_free_result($TMAEFACT_T);

$bImprime_Controlador = true;

	
if ($porDecision == 0){
	$bImprime_Controlador = false;
}else{
	if($swImprimeTI_SioSI != true){
		if($CLI > 0 or $FPA > 1 or ($TIP == 'A' and $TCO == 'FT')) {
			$bImprime_Controlador = true;
		}else{
			if($swImprimeCI_SioSI == true){

				$bImprime_Controlador = false;			

			}else{
				// se envia el total del comprobante actual --> $TeToT
				$bImprime_Controlador = false;
				if (Comprobantes_Facturados($TOT_TOT,$PLA) < $porDecision) { 
					$bImprime_Controlador = true;
	
				}
			}
		}
	}
}

///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
if($_SESSION['ParFacSec'] == 2){

	
	//$_POST
	$TIP = $_REQUEST['tip'];
	$TCO = $_REQUEST['tco'];
	$SUC = $_REQUEST['suc'];
	$NCO = $_REQUEST['nco'];

	
	$_SESSION['ParSQL'] = "SELECT TIP FROM AMAEFACT WHERE TIP = '".$TIP."' AND TCO = '".$TCO."' AND SUC = ".$SUC." AND NCO = ".$NCO;
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);
	if(mssql_num_rows($AMAEFACT) != 0){
		?>
		<script>
					
			jAlert('El comprobante ingresado ya se encuantra en el sistema. Reintente la operacion.', 'Debo Retail - Global Business Solution');
		
			document.getElementById("EDat7Ma1").value = "";
			document.getElementById("EDat7Ma2").value = "";
			document.getElementById("EDat7Ma3").value = "";
			document.getElementById("EDat7Ma4").value = "";
			
			EnvAyuda('Ingrese sucursal del comprobante.');
		
			document.getElementById("DondeE").value = "EDat7Ma1";
			document.getElementById("CantiE").value = "4";
			document.getElementById("QuePoE").value = "1";

			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntSucMa\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntSucMa"/></button>';

			$('#Bloquear').fadeOut(500);
		
		</script>
		<?		
	}
	mssql_free_result($AMAEFACT);


A_AMAEFAC_MANUAL($TIP,$TCO,$SUC,$NCO);

	
}else{

	if($bImprime_Controlador == true){
	
		//GRABA EN LA TMAEFACT PARA IMPRIMIR
		A_TMAEFACT($PAG,$TER);

	}else{
	
		//GRABA EN LA AMAEFACT PARA CI
		A_AMAEFAC($TIP,$TCO,$SUC,$NCO);

	}

}


mssql_query("commit transaction") or die("Error SQL commit");


///////////////////////////////////////////////////////
///////// PARA FAC MANUAL /////////////////////////////
///////////////////////////////////////////////////////
//SESSION
if($_SESSION['ParFacSec'] == 1){
	$_SESSION['ParOrn'] = 0;
	?>
	<script>
		ComenzarFac();
	</script>
	<?
}
if($_SESSION['ParFacSec'] == 2){
	$_SESSION['ParOrnMa'] = 0;
	?>
	<script>
		MaComenzarFac();
	</script>
	<?
}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////



}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		ComenzarFacError();
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}