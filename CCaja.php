<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$PLA = $_REQUEST['pla'];
$LUG = $_SESSION['ParLUG'];


	$tit[0] = "Efectivo";
	$tit[1] = "Gastos";
	$tit[2] = "Cheques";
	$tit[3] = "Anticipos";
	$tit[4] = "Tarjetas";
	$tit[5] = "Efectivo Recibido";
	$tit[6] = "Efectivo Entregado";
	//$tit[7] = "Vuelto";


$SQL = "SELECT TOP 5 DES FROM CPARBON ORDER BY ID";
$CPARBON = mssql_query($SQL) or die("Error SQL");	
$c = 6;
while ($R_CPARBON=mssql_fetch_array($CPARBON)){
	
	$c = $c + 1;	
	$tit[$c] = $R_CPARBON['DES'];
	
}

$catits = $c;


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// LLeno Carga De Planilla ///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//VERIFICAR SI LA PLANILLA EXISTE Y NO TIENE CIERRE DEFINITIVO -- 
	$_SESSION['ParSQL'] = "SELECT DEF,PLC,FAP,FCT,CAR,OPE,TUR,MTN FROM ATURNOSO WHERE PLA = ".$PLA." AND LUG = ".$LUG."";
	$ATURNOSO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ATURNOSO);		
	while ($RATU=mssql_fetch_array($ATURNOSO)){
		$DEF = $RATU['DEF'];
		$CER = $RATU['PLC'];
		$FAP = $RATU['FAP'];
		$FCT = $RATU['FCT'];
		$CAR = $RATU['CAR'];	////// POS 5 CAMBIO RECIBIDO
		$CAE = $CAR;			////// POS 6 CAMBIO ENTREGADO -- LO DEJA IGUAL HASTA QUE INGRESE ALGO DIFERENTE.
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
	


$teREN[0] = 0.00;
$teREN[1] = 0.00;
$teREN[2] = 0.00;
$teREN[3] = 0.00;
$teREN[4] = 0.00;
$teREN[5] = dec($CAR,2);
$teREN[6] = dec($CAE,2);
$teREN[7] = 0.00;
$teREN[8] = 0.00;
$teREN[9] = 0.00;
$teREN[10] = 0.00;
$teREN[11] = 0.00;
$teREN[12] = 0.00;

////////////////////////////////////////////////////////////
//LLenoRendicionParcial($PLA,$LUG);
////////////////////////////////////////////////////////////

$tePAR[0] = 0.00;
$tePAR[1] = 0.00;
$tePAR[2] = 0.00;
$tePAR[3] = 0.00;
$tePAR[4] = 0.00;
$tePAR[5] = 0.00;
$tePAR[6] = 0.00;
$tePAR[7] = 0.00;
$tePAR[8] = 0.00;
$tePAR[9] = 0.00;
$tePAR[10] = 0.00;
$tePAR[11] = 0.00;
$tePAR[12] = 0.00;

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
	$tePAR[7] = dec(0, 2);

	if ($RPAR['REF1']<>0){
		$tePAR[8] = dec($RPAR['REF1'], 2);
	}	
	if ($RPAR['REF2']<>0){
		$tePAR[9] = dec($RPAR['REF2'], 2);
	}		
	
	if ($RPAR['REF3']<>0){
		$tePAR[10] = dec($RPAR['REF3'], 2);
	}			
	if ($RPAR['REF4']<>0){
		$tePAR[11] = dec($RPAR['REF4'], 2);
	}	
	if ($RPAR['REF5']<>0){
		$tePAR[12] = dec($RPAR['REF5'], 2);
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
if($teREN[2] == 0.00){
	$teREN[2] = 0;
}


////////////////////////////////////////////////////////////
//CalculoSumas();
////////////////////////////////////////////////////////////
$teTOT[0] = 0.00;
$teTOT[1] = 0.00;
$teTOT[2] = 0.00;
$teTOT[3] = 0.00;
$teTOT[4] = 0.00;
$teTOT[5] = 0.00;
$teTOT[6] = 0.00;
$teTOT[7] = 0.00;
$teTOT[8] = 0.00;
$teTOT[9] = 0.00;
$teTOT[10] = 0.00;
$teTOT[11] = 0.00;
$teTOT[12] = 0.00;

$nTotRen = 0.00;
$nTotTot = 0.00;

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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Confirmar Caja</title>

<script type="text/javascript" language="javascript" src="ConCaja/caja.js"></script>

<style>

#CCaja{
	position:absolute; 
	left:27px; 
	top:73px; 
	width:446px;
}

#CajaTex{
	position:absolute; 
	width:738px; 
	height:354px; 
	left:40px; 
	top:47px;
	z-index:2;
}

.cajaselst{
	position:absolute; 
	width:738px; 
	height:354px; 
	left:464px; 
	top:-50px;
	z-index:2;
}

.CajaSelI{
	position:absolute;
	font-family: "TPro"; 
	font-size:14px; 
	color:#FFF;
}

.cajatextarea{
	background-color:transparent;
	resize:none;
	border:0px; 
	width:207px; 
	height:168px;
	font-family: "TPro"; 
	font-size:12px; 
	color:#000;
}

#CajaFonCC{
	position:absolute; 
	width:738px; 
	height:354px; 
	left:464px; 
	top:-50px;
	z-index:2;
}

.texUC{
	font-family: "TPro"; 
	text-align:right;
	font-weight:bold;
	font-size:12px;	
	border:0px;
	width:87px; 
	height:13px;
}

.texUC2{
	background-color:#DD7713;
	font-family: "TPro"; 
	text-align:right;
	font-weight:bold;
	font-size:12px;	
	border:0px;
	width:87px; 
	height:13px;
}

.texPC{ 
	background-color:transparent; 
	font-family: "TPro"; 
	text-align:right;
	font-weight:bold;
	font-size:12px;
	border:0px;
	width:90px; 
	height:13px;
}

.texTC{ 
	background-color:transparent;
	font-family: "TPro"; 
	text-align:right;
	font-weight:bold;
	font-size:12px;
	border:0px;
	width:90px; 
	height:13px;
}

.titulosder{
	background-color:transparent;
	font-family: "TPro"; 
	font-size:12px; 
	color:#FFF;
}

.fonttpro{ 
	background-color:transparent;
	resize:none;
	border:0px; 
	width:207px; 
	height:168px;
	font-family: "TPro"; 
	font-size:12px; 
	color:#000;
}

.fonttpro2{ 
	position:absolute;
	left:470px; 
	top:95px;
}

#TitDesX{ 
	position:absolute; 
	text-align:center;			
	font-family: 'TPro'; 
	font-size:14px; 
	color:#FFF; 
	width:160px; 
	height:16px; 
	left:497px; 
	top:69px;
}

#Impresion{
	background-color:#FFF; 
	display:none; 
	overflow:visible;
	overflow:auto;
	position:absolute; 
	top:22px; 
	left:-28px; 
	width:782px; 
	height:493px; 
	z-index:3;
}

#ImpresionSal{
	position:absolute; 
	display:none; 
	top:525px; 
	left:252px; 
	z-index:3;
}

#ImpresionImp{
	position:absolute; 
	display:none; 
	top:525px; 
	left:458px; 
}

</style>
</head>
<body>


<div id="CCajaFon"><img src="ConCaja/CCaja.png" /></div>


<div id="CCaja">

<?
$_SESSION['ParSQL'] = "SELECT TOP 1 PLA, TUR, MTN, FAP, FCT, OPE, OBS_EFE_REC FROM ATURNOSO WHERE CER = 'C' AND PLC = 'N' AND PLA = ".$PLA." ORDER BY PLA DESC";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);
$cc = mssql_num_rows($registros);
$c = 0;
while ($reg=mssql_fetch_array($registros)){

$c = $c + 1;


	$PLA = $reg['PLA'];
	$FAP = $reg['FAP'];
	$FCT = $reg['FCT'];
	$MTN = $reg['MTN'];
	$OPE = $reg['OPE'];
	$DES = $reg['OBS_EFE_REC'];
	
	
$M_PLA = format($PLA,5,'0',STR_PAD_LEFT);
$M_MTN = format($MTN,2,'0',STR_PAD_LEFT);

if($FAP != NULL){
	$date = new DateTime($FAP);
	$M_FAP = $date->format('d-m-Y H:i');
}else{
	$M_FAP ="";
}
if($FCT != NULL){
	$date = new DateTime($FCT);
	$M_FCT = $date->format('d-m-Y H:i');
}else{
	$M_FCT = "";
}

?>

<form method="post" id="FormCCaja" name="FormCCaja" action="NCaja.php">

<input type="hidden" id="pla" name="pla" value="<? echo $PLA; ?>" />

	<div id="CajaTex<? echo $c; ?>" class="CajaFonCC">
    <table width="446" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="4">
        	<div style="width:446px; height:18px;"><img src="ConCaja/tit.png" /></div>
        </td>
    </tr>
    <tr>
    <td>
		<?
		$catitsd = 0;
        for($i=0; $i<$catits+1; $i++){	
		
		$teREN[0] = "";		
		
		if($i >= 8){
			$catitsd = $catitsd + 1;
		}
		
		$UrlB = "ConCaja/FonVar.png";
		$ClaB = "texUC";
		
		if($i == 1 or $i == 2 or $i == 4 or $i == 5){
			$UrlB = "ConCaja/FonVar2.png";
			$ClaB = "texUC2";
		}
		
        ?> 
        <script>
			$("#Div0").css("border-color", "#F90");
		</script>
        
        <div style="background-image:url(<? echo $UrlB; ?>); width:446px; height:16px; margin-top:2px;">
            <table width="446" border="0" cellpadding="0" cellspacing="0">
            <tr>

                <td width="142" valign="middle">
                    <div class="titulosder" align="center" ><? echo $tit[$i]; ?></div>
                </td>
                <td width="100">
                <div id="Div<? echo $i; ?>" class="div-redondo" style=" position:relative; width:96px; height:12px; top:-1px; left:-2px;">
                <div align="center">
                <input type="text" id="TexU<? echo $i; ?>" name="TexU<? echo $i; ?>" class="<? echo $ClaB; ?>" readonly="readonly" value="<? echo $teREN[$i]; ?>" style="height:14px; background-color:transparent; top:-2px; position:absolute;" />
                </div>
                </div>
                </td>
                <td width="100">
                <div align="center">
                <input type="text" id="TexP<? echo $i; ?>" name="TexP<? echo $i; ?>" class="texUC2" readonly="readonly" value="<? echo $tePAR[$i]; ?>" />
                </div>
                </td>
                <td width="100">
                <div align="center">
                <input type="text" id="TexT<? echo $i; ?>" name="TexT<? echo $i; ?>" class="texUC2" readonly="readonly" value="<? echo $teTOT[$i]; ?>" />
                </div>
                </td>
            </tr>
            </table>
        </div>
        <?
        }
        ?>
   	</td>   
    </tr>
    </table>
    </div>


<input type="hidden" id="TexCat" name="TexCat" value="<? echo $catitsd; ?>" />

    
<div id="TitDesX">Obs.</div>
    
<div id="DesEfeEntDiv" class="div-redondo" style="width:211px; height:178px; top:88px; left:467px;">
	<textarea readonly="readonly" class="cajatextarea" id="DesEfeEnt" name="DesEfeEnt" />
</div>

<div id="DesVueltoDiv" class="div-redondo" style="width:211px; height:178px; top:88px; left:467px;">
	<textarea readonly="readonly" class="cajatextarea" id="DesVuelto" name="DesVuelto" />
</div>   
    
    
</form>
    
    <div id="CajaSelC<? echo $c; ?>" class="cajaselst">
    
        <div class="CajaSelI" style="left:81px; top:7px;">
            <? echo $M_PLA; ?>
        </div>
        <div class="CajaSelI" style="left:81px; top:27px;">
            <? echo $M_MTN; ?>
        </div>
        <div class="CajaSelI" style="left:81px; top:45px;">
            <? echo $M_FAP; ?>
        </div>
        <div class="CajaSelI" style="left:81px; top:63px;">
            <? echo $M_FCT; ?>
        </div>
        <div class="CajaSelI" style="left:81px; top:81px;">
            <? echo $OPE; ?>
        </div>
    
    </div>

<?

}
mssql_free_result($registros);
?>


</div>


<!--

<div id="Impresion"></div>

<div id="ImpresionSal">
	<button onclick="SalirImp();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetVolCCs','','botones/sal-over.png',0)">
	<img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetVolCCs"/></button>
</div>

<div id="ImpresionImp">
	<button onclick="ImpreImp();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetVolCCi','','botones/imp-over.png',0)">
	<img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="LetVolCCi"/></button>
</div>

-->


</body>
</html>
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