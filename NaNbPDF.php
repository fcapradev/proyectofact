<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(1200);

require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');

////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////


$TCO = $_POST['TCO'];
$NCO = $_POST['NCO'];
$TIM = $_POST['TIM'];
/*
$TCO = 'NA';
$NCO = 68;
$TIM = 14;
*/
switch($TIM){
	case '13':
		$MSJ = "Movimiento de Stock por Ajuste en Compras Automáticas.";
		break;
	case '14':
		$MSJ = "Movimiento de Stock de Depósito a Ventas.";
		break;
	case '15':
		$MSJ = "Movimiento de Stock de Ventas a Ventas.";
		break;
	case '16':
		$MSJ = "Movimiento de Stock de Otros Locales a Ventas.";
		break;
	case '17':
		$MSJ = "Movimiento de Stock de Otros Locales a Depósito.";
		break;

}

if($TIM == 17 || $TIM == 13 ){
	$TIM = 16;
}
if($TIM == 15 ){
	$TIM = 14;
}


//$REP = array(1,2,1,4,1,1);		//$_POST['REP'];		--> ES LO QUE SE INGRESA


////  COMENTARIOS  ////
/*
$VAR1 = 0;
$VAR2 = 0;
$VAR3 = 0;
$VAR4 = 0;
$VAR5 = 0;
$VAR6 = 0;

if(isset($_POST['TEXT01'])){
	$TEXT01 = "TEXTO NUMERO UNO";	//$_POST['TEXT01'];
	$VAR1 = 1;
}
if(isset($_POST['TEXT02'])){
	$TEXT02 = "TEXTO NUMERO DOS";	//$_POST['TEXT02'];
	$VAR2 = 1;	
}
if(isset($_POST['TEXT03'])){
	$TEXT03 = "TEXTO NUMERO TRES";	//$_POST['TEXT03'];
	$VAR3 = 1;
}
if(isset($_POST['TEXT04'])){
	$TEXT04 = "TEXTO NUMERO CUATRO";	//$_POST['TEXT04'];
	$VAR4 = 1;	
}
if(isset($_POST['TEXT05'])){
	$TEXT05 = "TEXTO NUMERO CINCO"; //$_POST['TEXT05'];
	$VAR5 = 1;	
}
if(isset($_POST['TEXT06'])){
	$TEXT06 = "TEXTO NUMERO SEIS";	//$_POST['TEXT06'];
	$VAR6 = 1;	
}
*/

// create new PDF document

$pdf = new TCPDF("p", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);

header('Content-Type: application/pdf'); 
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream', false);
header('Content-Type: application/download', false);
header('Content-Type: application/pdf', false);



$pdf->SetAuthor('Debo - Retail');
$pdf->SetTitle('Nota de Alta y Baja');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, 'Movimientos de Stock ', 'Fecha: '.date('Y-m-d H:i').'');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 15);

// add a page
$pdf->AddPage();

$pdf->Write(0, $MSJ, '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------
$tbl = '
<table width="640" height="16" cellpadding="0" border="0" cellspacing="0">
	  <tr>
		<td width="175">&nbsp;<b>'.$_SESSION['EMP01'].'</b></td>
		<td width="175">&nbsp;<b>'.$_SESSION['EMP02'].'</b></td>
	  </tr>
</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = '
<table width="640" height="16" cellpadding="0" border="0" cellspacing="0">
	  <tr>
		<td width="175">&nbsp;<b>Comprobantes:&nbsp; </b> '.$TCO.' '.$_SESSION['ParEMP'].' - '.$NCO.'</td>
	  </tr>
	  <tr>
		<td width="175">&nbsp;<b>Fecha: </b> '.date('Y-m-d H:i:s').'</td>
	  </tr>
	  <tr>
		<td width="175">&nbsp;<b>Operario: </b> '.$_SESSION['idsusua'].' </td>
	  </tr>
</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$c = 0;
$cuerpo = '<table width="640" border="0" cellpadding="0" cellspacing="0">';
	$c++;
	
	if($c == 1){
	
		$titulo = '
		<table width="640" border="1" cellpadding="0" cellspacing="0">
			<tr bordercolor="#999999" bgcolor="#999999" align="center">
				<td colspan="6" width="213"> ORIGEN </td>
				<td colspan="6" width="232"> DESTINO </td>
				<td colspan="7" width="213"> CANDIDATOS </td>
			</tr>
	
			<tr bordercolor="#999999" bgcolor="#CCCCCC">
				<td colspan="6" width="213" align="left"> Codigo de Producto </td>
				<td colspan="4" width="186" align="left"> Codigo de Producto </td>
				<td colspan="2" width="46" align="center" > Costo </td>
	
				<td align="center" width="53"> Exi.Ant </td>
				<td align="center" width="53"> Repos.</td>
				<td align="center" width="53"> Exi.Fin</td>
				<td align="center" width="53"> Total</td>
	
			</tr>
		</table>
		';	
		$pdf->writeHTML($titulo, true, false, false, false, '');
	}


//**	ITEMS A MOSTRAR

switch ($TIM){
	case '14':

$_SESSION['ParSQL'] = "
		SELECT A.SEC AS SEC_I, A.ART AS ART_I, A.FEC AS FEC_I, A.CYV AS CYV_I, A.TIP AS TIP_I, A.TCO AS TCO_I, A.PVE AS PVE_I, A.NCO AS NCO_I, A.ORD ORD_I, A.CAN, A.PUN AS PUN_I, A.COD AS COD_I, A.DTO AS DTO_I, A.PLA AS PLA_I, A.TIM AS TIM_I, A.OPE AS OPE_I, A.E_HD2 AS E_HD2, B.SEC AS SEC_D, B.ART AS ART_D, B.FEC AS FEC_D, B.CYV AS CYV_D, B.TIP AS TIP_D, B.TCO AS TCO_D, B.PVE AS PVE_D, B.NCO AS NCO_D, B.ORD AS ORD_D, B.PUN AS PUN_D, B.COD AS COD_D, B.DTO AS DTO_D, B.PLA AS PLA_D, B.TIM AS TIM_D, B.OPE AS OPE_D 
		FROM AMOVSTOC A 
		INNER JOIN AMOVSTOC B ON A.TIP = B.TIP AND A.TCO = B.TCO AND A.PVE = B.PVE AND A.NCO = B.NCO AND B.CYV = 'C'  AND A.ORD = B.ORD
		WHERE A.TIP = 'B' AND A.TCO = '".$TCO."' AND A.PVE = ".$_SESSION['ParEMP']." AND A.NCO = ".$NCO."  AND A.CYV = 'V' 
		ORDER BY A.FEC DESC";
		
		break;

	case '16':

	$_SESSION['ParSQL'] = "
		SELECT *
		FROM AMOVSTOC  
		WHERE TIP = 'B' AND TCO = '".$TCO."' AND PVE = ".$_SESSION['ParEMP']." AND NCO = ".$NCO."  AND CYV = 'C' 
		ORDER BY FEC DESC";
		
		break;	
		
	default:
	$_SESSION['ParSQL'] = "
		SELECT *
		FROM AMOVSTOC  
		WHERE TIP = 'B' AND TCO = '".$TCO."' AND PVE = ".$_SESSION['ParEMP']." AND NCO = ".$NCO."  AND CYV = 'C' 
		ORDER BY FEC DESC";	
}

debug($_SESSION['ParSQL']);


/*
$_SESSION['ParSQL'] = "SELECT * FROM AMOVSTOC WHERE TIP = 'B' AND TCO = '".$TCO."' AND PVE = ".$_SESSION['ParEMP']." AND NCO = ".$NCO." ORDER BY FEC DESC";
*/


$ARTICULOS2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ARTICULOS2);		

$FILAS = mssql_num_rows($ARTICULOS2);
$titulo = "";
$REP_TOT = 0;
$TOTAL = 0;

	
while ($RART2 = mssql_fetch_array($ARTICULOS2)){
	
	switch ($TIM){
		case '14':
			$SEC_I = $RART2['SEC_I'];
			$ART_I = $RART2['ART_I'];
			$PUN_I = $RART2['PUN_I'];
	
			$SEC_D = $RART2['SEC_D'];
			$ART_D = $RART2['ART_D'];
			$PUN_D = $RART2['PUN_D'];
			$ORD_D = $RART2['ORD_D'];
	
			$CAN = $RART2['CAN'];
		
			$SEC_IN = format($RART2['SEC_I'],2,'0',STR_PAD_LEFT);
			$ART_IN = format($RART2['ART_I'],4,'0',STR_PAD_LEFT);
			
			$SEC_DN = format($RART2['SEC_D'],2,'0',STR_PAD_LEFT);
			$ART_DN = format($RART2['ART_D'],4,'0',STR_PAD_LEFT);		
			
			$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec = ".$RART2['SEC_I']." AND CodArt = ".$RART2['ART_I']."";
			$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS1);
		
			while ($RART1 = mssql_fetch_array($ARTICULOS1)){
				$DETART_I = $RART1['DetArt'];
				$ExiVta_I = $RART1['ExiVta'];
				$DETART_I = $RART1['DetArt'];
				
			}

			$TOTAL = $CAN * $PUN_I;
			$REP_TOT = $REP_TOT + $TOTAL;
		
			$ARTICULO_I = $SEC_IN.'-'.$ART_IN.' '.$DETART_I;
			$ARTICULO_CORT_I = substr( $ARTICULO_I,0,30);
	
			$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec = ".$RART2['SEC_D']." AND CodArt = ".$RART2['ART_D']."";
			$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS1);
		
			while ($RART1 = mssql_fetch_array($ARTICULOS1)){
				$DETART_D = $RART1['DetArt'];
				$ExiVta_D = $RART1['ExiVta'];
				$DETART_D = $RART1['DetArt'];
			}
	
			$EXI_ANT_I = $ExiVta_D - $CAN;
			
			$ARTICULO_D = $SEC_DN.'-'.$ART_DN.' '.$DETART_D;
			$ARTICULO_CORT_D = substr( $ARTICULO_D,0,26);
			break;
		
		case '16':
			$SEC_I = $RART2['SEC'];
			$ART_I = $RART2['ART'];
			$PUN_I = $RART2['PUN'];
			$COD_I = $RART2['COD'];

			$CAN = $RART2['CAN'];
			$E_HD2 = $RART2['E_HD2'];
		
			$SEC_IN = format($RART2['SEC'],2,'0',STR_PAD_LEFT);
			$ART_IN = format($RART2['ART'],4,'0',STR_PAD_LEFT);
			
			$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec = ".$RART2['SEC']." AND CodArt = ".$RART2['ART']."";
			$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS1);
		
			while ($RART1 = mssql_fetch_array($ARTICULOS1)){
				$DETART_I = $RART1['DetArt'];
				$ExiVta_I = $RART1['ExiVta'];
			}
		
	
			$TOTAL = $CAN * $PUN_I;
			$REP_TOT = $REP_TOT + $TOTAL;
		
			$ARTICULO_I = $SEC_IN.'-'.$ART_IN.' '.$DETART_I;
			$ARTICULO_CORT_D = substr( $ARTICULO_I,0,30);
	
			$EXI_ANT_I = $ExiVta_I - $CAN;
			
			if(isset($_SESSION['Producto'])){
				$producto = $_SESSION['Producto'];
			}else{
				$producto['sec'][1] = 2;
				$producto['art'][1] = 20;
			}
			
			$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec = ".$producto['sec'][1]." AND CodArt = ".$producto['art'][1]."";
			$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS1);
		
			while ($RART1 = mssql_fetch_array($ARTICULOS1)){
				$DETART_D = $RART1['DetArt'];
				$ExiVta_D = $RART1['ExiVta'];
			}
				
			$EXI_ANT_I = $ExiVta_D - $CAN;
			
			$ARTICULO_D = $producto['sec'][1].'-'.$producto['art'][1].' '.$DETART_D;
			$ARTICULO_CORT_I = substr( $ARTICULO_D,0,26);			
			
			break;
			
	}

	$cuerpo = $cuerpo. '
		<tr>
			<td colspan="6" width="213" align="left" >'.$ARTICULO_CORT_I.'</td>
			<td colspan="4" width="186" align="left">'.$ARTICULO_CORT_D.'</td>
			<td colspan="2" width="46" align="right">'.dec($PUN_I,2).'&nbsp;&nbsp;</td>

			<td align="center" width="53">'.$EXI_ANT_I.'&nbsp;&nbsp;</td>
			<td align="center" width="53">'.$CAN.'&nbsp;&nbsp;</td>
			<td align="center" width="53">'.$ExiVta_D.'&nbsp;&nbsp;</td>
			<td align="right" width="53">'.dec($TOTAL,2).'&nbsp;&nbsp;</td>
		</tr>';

$TOTAL = 0;
}	
$cuerpo = $cuerpo."</table>";

$pdf->writeHTML($cuerpo, true, false, false, false, '');
	
	$tbl = '
	
		<table>
		  <tr>
			<td width="473" border="0">&nbsp;</td>
			<td align="center" width="100" border="1" bgcolor="#999999" bordercolor="#666666">TOTAL:</td>
			<td align="center" width="60" border="1" bordercolor="#666666">'.dec($REP_TOT,2).'</td>
		  </tr>
		</table>
	
		';
	
	$pdf->writeHTML($tbl, true, false, false, false, '');

	if($TIM == 16){
		if($COD_I != ""){

			$_SESSION['ParSQL'] = "SELECT * FROM T_EMPRESA WHERE EMP = ".$COD_I."";
			$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS1);
		
			while ($RART1 = mssql_fetch_array($ARTICULOS1)){
				$DOM = $RART1['DOM'];
				$COD = $RART1['COD'];
			}
			
			$tbl = '
				<table>
				  <tr>
					<td align="left" width="300" border="0" bordercolor="#666666">Importación desde Local ('.$COD.') '.$DOM.'</td>
				  </tr>
				  <tr>
					<td align="left" width="200" border="0" bordercolor="#666666">Comprobante NB de Origen Nº '.$E_HD2.'</td>
				  </tr>
				</table>
				';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}
	}
	
/*	
	$cant = $VAR1 + $VAR2 + $VAR3 + $VAR4 + $VAR5 + $VAR6; 
	
	if($cant != 0){
		$tbl = '
			<table width="500" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="213" align="right">&nbsp;</td>
					<td width="213" align="center" style="border:solid 1px #000; background-color:#CCC;"><b>Detalle del Movimiento</b></td>
				</tr>';
		
		
		
		$TEX = "TEXT";
		
			for($i=1;$i<=$cant;$i++){
				$tbl = $tbl.'		
					<tr>
						<td width="213" align="right">&nbsp;</td>
						<td width="213" align="center" style="border:solid 1px #000;">'.$TEX.$i.'</td>
					</tr>';
			
			}
		
		$tbl = $tbl.'</table>';
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
	}
*/


// reset pointer to the last page
$pdf->lastPage();

$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);


mssql_free_result($ARTICULOS2);

//Close and output PDF document
$p = "Pdf/NaNb/Movimientos_".$NCO.".pdf";
$pdf->Output($p, 'F');

//============================================================+
// END OF FILE                                                
//============================================================+

//mssql_free_result($R1TB);

mssql_query("commit transaction") or die("Error SQL commit");

?>
<script>

	SoloBlock('ImpresionPdfDiv');
	SoloNone("LetTer, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon");
		
	window.open("<?=$p?>",'ImpresionPdf');
	
	document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolNaNb();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
	
	$('#Bloquear').fadeOut(500);
	
</script>
<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR - Debe cerrar el archivo PDF antes de generar uno nuevo.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}