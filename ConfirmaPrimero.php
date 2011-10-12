<?php
require("config/cnx.php");


try {


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

//primero muestra las planillas disponibles para realizar las consultas:

  //PRIMERO BUSCAR LOS DATOS DEL TURNO para el encabezado.
     //conteos cargados
	 

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
$PLA = 682;	
  $LUG = $_SESSION['ParLUG'];
  $OPE = $_SESSION['idsusua'];

  
//encabezado
/*
Lugar de venta			$LUG  			detalle (SELECT LUG FROM ALUGVTA WHERE ID=".$LUG.";
Planilla				$PLA	
Operario				$OPE			nombre (SELECT NOMVEN FROM VENDERORES WHERE CODVEN=".$OPE.";
Supervisor				$SUP			nombre (SELECT NOMVEN FROM VENDERORES WHERE CODVEN=".$SUP.";

// detalle
0-EFECTIVO					$EFE
1-GASTOS					$GAS
2-CHEQUES					$CHE
3-ANTICIPOS					$ANT	
4-TARJETAS					$TAR
5-CAMBIO RECIBIDO			$CAR
6-cambio entregado			$CAE
7-Vuelto					$VUE
8 AL 12 BONO 1 AL 5			$BO1 AL $BO5

14 - CUENTAS CORRIENTES EN FT --> $FTCC
15 - CUENTAS CORRIENTES EN FT --> $RECC
16 - A RENDIR--> $ARE
17 - RENDIDO --> $TOT
18 - DIFERENCIA --> $DIF

*/	

function Cargaplanilla($PLA,$LUG){
	
	//VERIFICAR SI LA PLANILLA EXISTE Y NO TIENE CIERRE DEFINITIVO -- 
	$_SESSION['ParSQL'] = "SELECT DEF,PLC,FAP,FCT,CAR,OPE,TUR,MTN FROM ATURNOSO WHERE PLA = ".$PLA." AND LUG = ".$LUG."";
	$ATURNOSO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSO);		
	while ($RATU=mssql_fetch_array($ATURNOSO)){
		$DEF = $RATU['DEF'];
		$CER = $RATU['PLC'];
		$FAP = $RATU['FAP'];
		$FCT = $RATU['FCT'];
		$CAR = $RATU['CAR'];	//>>>> POS 5 CAMBIO RECIBIDO
		$CAE = $CAR;			//>>>> POS 6 CAMBIO ENTREGADO -- LO DEJA IGUAL HASTA QUE INGRESE ALGO DIFERENTE.
		$OPE = $RATU['OPE'];
		$TUR = $RATU['TUR'];
		$MTN = $RATU['MTN'];
	}
	
	if ($DEF==true){
		 $PlanillaCerrada = True;
		 /*
         bGrabar.Caption = "&Imprimir"
         bGrabar.ToolTipText = "Imprimir Planilla"
         bGrabar.Enabled = True
         bCerrar.Visible = False
         bValores.Enabled = False
         bCupones.Enabled = False
		 */
         $laInfPla = "  CIERRE DEFINITIVO  ";
	}else{
         $PlanillaCerrada = False;
         $laInfPla = "";
	}
	
	if ($CER=="S"){
         $cfMSG = "La Planilla Seleccionada Está Cerrada";
		 //DAR EL MENSAJE Y SALIR, NO DEBE CONTINUAR.
	}


	$laDES[0] = "Apertura: ".Format($FAP, "DD MMM YYYY HH:MM"); //DAR FORMATO
  
	if ($FCT == NULL) {
		$FCT = $FecSRV;// --> TOMAR FECHA DEL SERVIDOR
		$laDES[1] = "Cierre  : ".Format(FecSRV, "DD MMM YYYY HH:MM");
	}else{
		$laDES[1] = "Cierre  : ".Format($FCT, "DD MMM YYYY HH:MM");
	}


	$laOPE = "Operario: Sin Nombre";
	$_SESSION['ParSQL'] = "SELECT * FROM VENDEDORES WHERE CODVEN =".$OPE."";
	$VENDEDORES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VENDEDORES);		
	while ($RVEN=mssql_fetch_array($VENDEDORES)){
		 $laOPE = "Operario:".format($RVEN['CodVen'],5,'0',STR_PAD_LEFT)." ".trim($RVEN['NomVen']);
	}
   
    $laLUG = "NO DEFINIDO";
 	$_SESSION['ParSQL'] = "SELECT * FROM ALUGVTA WHERE ID =".$LUG."";
	$ALUGVTA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ALUGVTA);		
	while ($RLUG=mssql_fetch_array($ALUGVTA)){
		 $laLUG = "TURNO: ".$TUR.", ".trim($RLUG['Lug']);
	}  
	
	$laHOR = "NO DEFINIDO";
	
	$_SESSION['ParSQL'] = "SELECT * FROM ATURNOSH WHERE MTN = ".$MTN."";
	$ATURNOSH = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSH);		
	while ($RTOH=mssql_fetch_array($ATURNOSH)){
		 $laHOR = trim($RTOH['des']);
	}

}
	
	// GRABACION POR ULTIMO
	
function GrabarPlanilla	(){

	// pedir confirmacion de si se quiere grabar la planilla SI o NO
	
	
	//
	
	$_SESSION['ParSQL'] = "SELECT PDTGT, BCICS FROM APARSIS";
	$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($APARSIS);		
	while ($RAPA=mssql_fetch_array($APARSIS)){
		 $PDTGT = $RAPA['PDTGT'];// si $PDTGT = TRUE tiene gastos
		 $BCICS = $RAPA['BCICS'];// si elimina todos los comprobantes de la temaefcat
	}	


	if($PDTGT == true){
	   $DET0 = substr($Detalle_0, 0, 45);
	   $DET1 = substr($Detalle_1, 0, 45);
	   $DET2 = substr($Detalle_2, 0, 45);
	   $DET3 = substr($Detalle_3, 0, 45);
	   
	   if(strlen($DET0) > 0 || strlen($DET1) > 0 || strlen($DET2) > 0 || strlen($DET3) > 0) {
		  
			$_SESSION['ParSQL'] = "select * from ADETGAST where pla = ".$PLA." AND LUG = ".$LUG."";
			$ADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ADETGAST);
			if(mssql_num_rows($ADETGAST)<>0){
				$_SESSION['ParSQL'] = "UPDATE ADETGAST SET DET0='".$DET0."', DET1='".$DET1."',DET2='".$DET2."',DET3='".$DET3."' where pla = ".$PLA." AND LUG = ".$LUG."";
				$UADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($UADETGAST);	
			}else{
				
				$_SESSION['ParSQL'] = "INSERT ADETGAST (PLA,LUG,DET0,DET1,DET2,DET3) VALUES (".$PLA.",".$LUG.",'".$DET0."','".$DET1."','".$DET2."','".$DET3."')";
				$IADETGAST = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($IADETGAST);	
			}
	   }
	}
	
	if ($BCICS == true) {
		$_SESSION['ParSQL'] = "DELETE TMAEFACT WHERE TER=".$TER."";
		$DTMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($DTMAEFACT);			

		$_SESSION['ParSQL'] = "DELETE TMAEFACT_T WHERE TER=".$TER."";
		$DTMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($DTMAEFACT);			
		
	}
	
	
	//UPDATE DE LA ATURNOSO CON LOS DATOS CARGADOS

	$_SESSION['ParSQL'] = "SELECT DEF FROM COMMAND";
	$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($COMMAND);		
	while ($RCOM=mssql_fetch_array($COMMAND)){
		 $CierreEnTurno = $RCOM['DEF'];	 
	}
	
	$def = 0;
	if ($CierreEnTurno == true){
		$def = 1;	
	}
	
	$nTotCta=0;
	$nTotCtaR=0;
	$nTotEfe=0;
	
	$_SESSION['ParSQL'] = "SELECT TCO,FPA,NET,IVA,IMI,IMI2,PER FROM VTOTVTAPLF where pla = ".$PLA." AND LUG = ".$LUG."";
	$VTOTVTAPLF = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($VTOTVTAPLF);		
	while ($RVTA=mssql_fetch_array($VTOTVTAPLF)){
		if ($RVTA['TCO'] == "NC"){
			if ($RVTA['FPA'] <> 2){
				$nTotEfe = $nTotEfe - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
			}else{
				if ($RVTA['FPA'] == 2){
					$nTotCtaR = $nTotCtaR - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}else{
					$nTotCta = $nTotCta - ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}
			}	 
			
		}else{
		
				if ($RVTA['FPA'] <> 2){
				$nTotEfe = $nTotEfe + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
			}else{
				if ($RVTA['FPA'] == 2){
					$nTotCtaR = $nTotCtaR + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}else{
					$nTotCta = $nTotCta + ($RVTA['NET'] + $RVTA['IVA'] + $RVTA['IMI'] + $RVTA['IMI2'] + $RVTA['PER']);
				}
			}	
		}	 
	}
	
	$nTotVta = $nTotEfe + $nTotCta + $nTotCtaR;
	$nTotAre = $teTOT[0] + $teTOT[7] + $teTOT[8] + $teTOT[9] + $teTOT[10] + $teTOT[11] + $teTOT[1] + $teTOT[2] + $teTOT[3] + $teTOT[4] +$teTOT[6] - $teTOT[5] - $teTOT[12];
	$nDifCaj = ($nTotAre + $nTotCta + $nTotCtaR) - $nTotVta;
	
	$_SESSION['ParSQL'] = "UPDATE ATURNOSO SET REF=".$teTOT[0].",RGA=".$teTOT[1].",RVA=".$teTOT[2].",RAN=".$teTOT[3].",RTA=".$teTOT[4].",CAR=".$teTOT[5].",CAE=".$teTOT[6].",TCT=".$teTotRen.",REF1=".$teTOT[7].",REF2=".$teTOT[8].",REF3=".$teTOT[9].",REF4=".$teTOT[10].",REF5=".$teTOT[11].",CRL=".$teTOT[12].",DEF=".$def.",RCC=".$nTotCta.",RCR=".$nTotCtaR.", DCM=0, DIF=".$nDifCaj.",CER='C',PLC='S'";
	$ATURNOSO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSO);		


}


////////////////////////////////////////////////////////////
//LLeno Valores Enviados Por El Operario
////////////////////////////////////////////////////////////

$teREN[0] = 100;
$teREN[1] = 100;
$teREN[2] = 100;
$teREN[3] = 100;
$teREN[4] = 100;
$teREN[5] = 100;
$teREN[6] = 100;
$teREN[7] = 100;
$teREN[8] = 100;
$teREN[9] = 100;
$teREN[10] = 100;
$teREN[11] = 100;
$teREN[12] = 100;

////////////////////////////////////////////////////////////
//LLenoRendicionParcial($PLA,$LUG);
////////////////////////////////////////////////////////////

$tePAR[0] = 0;
$tePAR[1] = 0;
$tePAR[2] = 0;
$tePAR[3] = 0;
$tePAR[4] = 0;
$tePAR[5] = 0;
$tePAR[6] = 0;
$tePAR[7] = 0;
$tePAR[8] = 0;
$tePAR[9] = 0;
$tePAR[10] = 0;
$tePAR[11] = 0;
$tePAR[12] = 0;

$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(EFE),0) AS TEFE,ISNULL(SUM(REF1),0) AS REF1,ISNULL(SUM(REF2),0) AS REF2,ISNULL(SUM(REF3),0) AS REF3,ISNULL(SUM(REF4),0) AS REF4,ISNULL(SUM(REF5),0) AS REF5,ISNULL(SUM(GAS),0) AS TGAS,ISNULL(SUM(ANT),0) AS TANT,ISNULL(SUM(TAR),0) AS TTAR,ISNULL(SUM(CHE),0) AS TVAL FROM ATURRPA WHERE PLA = ".$PLA." AND LUG = ".$LUG."";
$ATURRPA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ATURRPA);		
while ($RPAR=mssql_fetch_array($ATURRPA)){
	if ($RPAR['TEFE']<>0){
		$tePAR[0] = dec($RPAR['TEFE'], 2);
	}
	if ($RPAR['TGAS']<>0){
		$tePAR[1] = dec($RPAR['TGAS'], 2);
	}	
	if ($RPAR['TVAL']<>0){
		$tePAR[2] = dec($RPAR['TVAL'], 2);
	}		
	
	if ($RPAR['TANT']<>0){
		$tePAR[3] = dec($RPAR['TANT'], 2);
	}		
			
	if ($RPAR['TTAR']<>0){
		$tePAR[4] = dec($RPAR['TTAR'], 2);
	}		

	$tePAR[5] = dec(0, 2);
	$tePAR[6] = dec(0, 2);

	if ($RPAR['REF1']<>0){
		$tePAR[7] = dec($RPAR['REF1'], 2);
	}	
	if ($RPAR['REF2']<>0){
		$tePAR[8] = dec($RPAR['REF2'], 2);
	}		
	
	if ($RPAR['REF3']<>0){
		$tePAR[9] = dec($RPAR['REF3'], 2);
	}			
	if ($RPAR['REF4']<>0){
		$tePAR[10] = dec($RPAR['REF4'], 2);
	}	
	if ($RPAR['REF5']<>0){
		$tePAR[11] = dec($RPAR['REF5'], 2);
	}						
}	
	
	
////////////////////////////////////////////////////////////
//LLenoTarjetas($PLA,$LUG);
////////////////////////////////////////////////////////////	

$teREN[4] =0;
$_SESSION['ParSQL'] = "SELECT isnull(SUM(IMP),0) AS TOT FROM ACUPONES WHERE REN = 0 AND PLA = ".$PLA." AND LUG = ".$LUG."";
$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACUPONES);		
while ($RACU=mssql_fetch_array($ACUPONES)){
	$teREN[4] = dec($RACU['TOT'], 2);
}

$_SESSION['ParSQL'] = "SELECT isnull(SUM(IMP),0) AS TOT FROM ACUPONESA WHERE PAU = 'S'  AND PLA = ".$PLA." AND LUG = ".$LUG."";
$ACUPONES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACUPONES);		
while ($RACU=mssql_fetch_array($ACUPONES)){
	 $nTarADM = dec($RACU['TOT'], 2);
}
$teREN[4] = dec($teREN[4] - $nTarADM,2);
	
	

////////////////////////////////////////////////////////////
//LLenoValores($PLA,$LUG);
////////////////////////////////////////////////////////////

$teREN[2] = 0;
$_SESSION['ParSQL'] = "SELECT isnull(SUM(IMP),0) AS TOT FROM TVALOR WHERE PLA = ".$PLA."";
$TVALOR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TVALOR);		
while ($RVAL=mssql_fetch_array($TVALOR)){
	$teREN[2] = dec($RVAL['TOT'], 2);
}



////////////////////////////////////////////////////////////
//CalculoSumas();
////////////////////////////////////////////////////////////

$teTOT[0] = 0;
$teTOT[1] = 0;
$teTOT[2] = 0;
$teTOT[3] = 0;
$teTOT[4] = 0;
$teTOT[5] = 0;
$teTOT[6] = 0;
$teTOT[7] = 0;
$teTOT[8] = 0;
$teTOT[9] = 0;
$teTOT[10] = 0;
$teTOT[11] = 0;
$teTOT[12] = 0;

$nTotRen = 0;
$nTotTot = 0;
for ($N1 = 0; $N1 <= 12; $N1++){
  $teTOT[$N1] = dec($teREN[$N1] + $tePAR[$N1], 2);
  
  if($N1==5 || $N1==12){
	$nTotRen = $nTotRen - $teREN[$N1];
	$nTotTot = $nTotTot - $teTOT[$N1];		  
  }else{
	$nTotRen = $nTotRen + $teREN[$N1];
	$nTotTot = $nTotTot + $teTOT[$N1];		  
	  
  }
  $teTotRen = dec($nTotRen,2);
}

      
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////


$_SESSION['ParSQL'] = "SELECT MTARSH,IASH FROM APARSIS";
$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APARSIS);		
while ($RAPA=mssql_fetch_array($APARSIS)){
	 $swMTR = $RAPA['MTARSH'];
	 $IASH = $RAPA['IASH'];
}

if ($swMTR == true) {
	//BuscoTotalARendir($PLA,$LUG);
	
	$teTotARen=0;
	$_SESSION['ParSQL'] = "SELECT isnull(SUM(TOT),0) AS TOT FROM AMAEFACT WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND ANU <> 'A' AND FPA <> 2 AND TCO <> 'NC'";
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);		
	while ($RAMA=mssql_fetch_array($AMAEFACT)){
		$teTotARen = dec($RAMA['TOT'], 2);
	}

	$_SESSION['ParSQL'] = "SELECT isnull(SUM(TOT),0) AS TOT FROM AMAEFACT WHERE PLA = ".$PLA." AND LUG = ".$LUG." AND ANU <> 'A' AND FPA <> 2 AND TCO = 'NC'";
	$AMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AMAEFACT);		
	while ($RAMA=mssql_fetch_array($AMAEFACT)){
		$teTotARen = $teTotARen - dec($RAMA['TOT'], 2);
	}
	
} 

//INVENTARIO ACTIVO --->>>> HAY QUE HACERLO COMPLETO.
if($IASH == true){
	// tiene que levantar y si o si hacer el inventario activo para continuar.
	// si no lo hace y sale sin confirmar no continua con el cierre.
	//frmObtOpePla.Show vbModal
}
	   
//LUEGO PASA A LA CARGA DE LOS DATOS

// cuando llega a gastos ver si pide o no detalle

$_SESSION['ParSQL'] = "SELECT PDTGT FROM APARSIS";
$APARSIS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APARSIS);		
while ($RAPA=mssql_fetch_array($APARSIS)){
	 $PDTGT = $RAPA['PDTGT'];
	 // si $PDTGT = TRUE pide gastos
}	





?>
<table>
<tr>
<td>
<?
foreach ($teREN as $k => $v){
	
    echo "<table width=\"100\" border=\"1\"><tr><td>".$v."</td></tr></table>";
	
}

?>
</td>
<td>
<?

foreach ($tePAR as $k => $v){
	
    echo "<table width=\"100\" border=\"1\"><tr><td>".$v."</td></tr></table>";
	
}

?>
</td>
<td>
<?

foreach ($teTOT as $k => $v){
	
    echo "<table width=\"100\" border=\"1\"><tr><td>".$v."</td></tr></table>";
	
}

?>
</td>
</tr>
</table>
<?






}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERORR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

echo $e;

exit;

}

           

?>



