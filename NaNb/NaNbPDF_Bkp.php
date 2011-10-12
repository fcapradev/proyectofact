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

switch($TIM){

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

//$REP = array(1,2,1,4,1,1);		//$_POST['REP'];		--> ES LO QUE SE INGRESA


////  COMENTARIOS  ////

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

//**	ITEMS A MOSTRAR

$_SESSION['ParSQL'] = "SELECT * FROM AMOVSTOC WHERE TIP = 'B' AND TCO = '".$TCO."' AND PVE = ".$_SESSION['ParEMP']." AND NCO = ".$NCO." ORDER BY FEC DESC";

$ARTICULOS2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ARTICULOS2);		

$total = 0;
$c = 0;
$titulo = "";
$REP_TOT = 0;
$i = 0;

$cuerpo = '<table width="640" border="0" cellpadding="0" cellspacing="0">';

while ($RART2 = mssql_fetch_array($ARTICULOS2)){
	 
	$ART = $RART2['ART'];
	$COSTO = $RART2['PUN'];
	$CAN = $RART2['CAN'];
	$ORD = $RART2['ORD'];

	$SEC_N = format($RART2['SEC'],2,'0',STR_PAD_LEFT);
	$ART_N = format($RART2['ART'],4,'0',STR_PAD_LEFT);
	
	
	$_SESSION['ParSQL'] = "SELECT * FROM ARTICULOS WHERE CodSec = ".$RART2['SEC']." AND CodArt = ".$RART2['ART']."";
	$ARTICULOS1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS1);

	while ($RART1 = mssql_fetch_array($ARTICULOS1)){
		$DETART = $RART1['DetArt'];
		$ExiVta = $RART1['ExiVta'];
		$DETART = $RART1['DetArt'];
		
	}

	$EXI_ANTD = $ExiVta - $CAN;
	$REP_TOT = $REP_TOT + ($CAN * $COSTO);

	$c++;
	
	if($c == 1){
	
		$titulo = '
		<table width="640" border="1" cellpadding="0" cellspacing="0">
			<tr bordercolor="#999999" bgcolor="#999999" align="center">
				<td colspan="6" width="240"> ORIGEN </td>
				<td colspan="6" width="240"> DESTINO </td>
				<td colspan="6" width="160"> CANDIDATOS </td>
			</tr>
	
			<tr bordercolor="#999999" bgcolor="#CCCCCC">
				<td colspan="6" width="240" align="left"> Codigo de Producto </td>
				<td colspan="4" width="186" align="left"> Codigo de Producto </td>
				<td colspan="2" width="54" align="center" > Costo </td>
	
				<td align="center" width="53"> Exi.Ant </td>
				<td align="center" width="53"> Repos.</td>
				<td align="center" width="54"> Exi.Fin</td>
	
			</tr>
		</table>
		';	
		$pdf->writeHTML($titulo, true, false, false, false, '');
	}

	$ARTICULO = $SEC_N.'-'.$ART_N.' '.$DETART;
	$ARTICULO_CORT_01 = substr( $ARTICULO,0,33);
	$ARTICULO_CORT_02 = substr( $ARTICULO,0,26);
	$cuerpo = $cuerpo. '
		<tr >
			<td colspan="6" width="240" align="left" >'.$ARTICULO_CORT_01.'</td>
			<td colspan="4" width="186" align="left">'.$ARTICULO_CORT_02.'</td>
			<td colspan="2" width="54" align="right">'.dec($COSTO,2).'&nbsp;&nbsp;</td>

			<td align="right" width="53">'.$EXI_ANTD.'&nbsp;&nbsp;</td>
			<td align="right" width="53">'.$CAN.'&nbsp;&nbsp;</td>
			<td align="right" width="54">'.$ExiVta.'&nbsp;&nbsp;</td>
		</tr>';
	$i++;	
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