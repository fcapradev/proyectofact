<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(0);

require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');

//////////// BUSCO LOS DATOS
$var = $_POST["var"];

if($var == 1){
	$SQL_2 = "SELECT TOP 1 ID FROM ITOMINVC ORDER BY ID DESC";
	$ARTICULOS2 = mssql_query($SQL_2) or die("Error SQL");
	rollback($ARTICULOS2);		
	while ($RART2=mssql_fetch_array($ARTICULOS2)){
		$num_inv = $RART2['ID'];
	}
}
mssql_free_result($ARTICULOS2);

$SQL_1 = "SELECT * FROM ITOMINVC WHERE ID = $num_inv";
$ARTICULOS1 = mssql_query($SQL_1) or die("Error SQL");
rollback($ARTICULOS1);		
while ($RART1=mssql_fetch_array($ARTICULOS1)){
	$inv = $RART1['ID'];
	$detalle = $RART1['DET'];
	$dep = $RART1['DEP'];
	$rubmay = $RART1['DRM'];
	$rub = $RART1['DRU'];
	$numrub = $RART1['RUB'];
	$ope = $RART1['OPE'];
	$fet = $RART1['FET'];
}
mssql_free_result($ARTICULOS1);

$date1 = new DateTime($fet);
$fet = $date1->format('d-m-Y H:m:i');

if($dep == 1){
	$dep = "DEPOSITO";
}else{
	$dep = "VENTAS";
}	
$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVD WHERE INV = $num_inv"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_array($R1TB)){
$sec = $ATU['SEC'];
}
mssql_free_result($R1TB);

$_SESSION['ParSQL'] = "SELECT * FROM sectores WHERE id = $sec";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_row($R1TB)){
$nomsec = $ATU[1];
}
mssql_free_result($R1TB);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Debo Retail');
$pdf->SetTitle('Toma de Inventario');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, 'Toma de Inventario '.date('Y-m-d H:i'), 'Foca Software');

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
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Detalle de Inventario Nº: '.$inv.'', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

$tbl = '
<table width="640" height="16" cellpadding="0" border="0" cellspacing="0">
	  <tr>
		<td colspan="2">&nbsp;<b>Descripci&oacute;n: </b>'.$detalle.'</td>
	  </tr>
	  <tr>
		<td width="75">&nbsp;<b>Sector:</b> </td>
		<td width="245">&nbsp;'.$nomsec.'</td>
		<td width="58">&nbsp;<b>Operario:</b> </td>
		<td width="206">&nbsp;'.$ope.'</td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro Mayor:</b> </td>
		<td>&nbsp;'.$rubmay.'</td>
		<td>&nbsp;<b>Tipo:</b></td>
		<td>&nbsp;'.$dep.'</td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro:</b> </td>
		<td>&nbsp;'.$rub.'</td>
		<td>&nbsp;<b>Tomado:</b></td>
		<td>&nbsp;'.$fet.'</td>
	  </tr>		
</table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVD WHERE INV = $num_inv ORDER BY INV DESC"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
$c = 0;

while ($ATU=mssql_fetch_row($R1TB)){

	$_SESSION1['ParSQL'] = "SELECT * FROM CODBAR WHERE CodSec = $sec AND CodArt= $ATU[2]"; 
	$R1TB1A = mssql_query($_SESSION1['ParSQL']) or die("Error SQL");
	rollback($R1TB1A);

	$codbar="";

	while ($ATU1=mssql_fetch_row($R1TB1A)){
		$codbar = $ATU1[2];
	}
	mssql_free_result($R1TB1A);
	
	$ATU[1]=format($ATU[1],2,'0',STR_PAD_LEFT);
	$ATU[2]=format($ATU[2],4,'0',STR_PAD_LEFT);

$c++;
if($c == 1){
$lista = '<table width="640" border="0" cellpadding="0" cellspacing="0">
			<tr bordercolor="#999999" bgcolor="#999999">
				<td width="120" align="center">C&oacute;digo</td>
				<td width="50" align="center">Rubro</td>
				<td width="270" align="center">Detalles</td>
				<td width="101" align="center">C&oacute;digo de Barras</td>
				<td width="100" align="center">Existencia</td>
			</tr>
			<tr bordercolor="#999999">
				<td width="120" align="center">&nbsp;</td>
				<td width="50" align="center">&nbsp;</td>
				<td width="270" align="center">&nbsp;</td>
				<td width="101" align="center">&nbsp;</td>
				<td width="100" align="center">&nbsp;</td>
			</tr>
		</table>';
$pdf->writeHTML($lista, true, false, false, false, '');
}

$lista = '<table width="640" border="0" cellpadding="-10" cellspacing="0">
			<tr>
				<td width="120" align="center">'.$ATU[1].'-'.$ATU[2].'</td>
				<td width="50" align="center">'.$ATU[4].'</td>
				<td width="270" align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$ATU[5].'</td>
				<td width="85" align="right">'.$codbar.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="100" align="right">____________&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>';
$pdf->writeHTML($lista, true, false, false, false, '');
}
mssql_free_result($R1TB);

$tbl = '
	<table  width="640">
	  <tr>
	  	<td width="473" border="0">&nbsp;</td>
		<td align="center" width="105" border="1" bgcolor="#999999" bordercolor="#666666">Cantidad de Articulos:</td>
		<td align="center" width="60" border="1" bordercolor="#666666">'.$c.'</td>
	  </tr>
	</table>
';
$pdf->writeHTML($tbl, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);




$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];
}
mssql_free_result($APAREMP);

//Close and output PDF document
$p = "Pdf/TomaInventario/Tom_Inv_".$numEmp.".pdf";
$pdf->Output($p, 'F');

//============================================================+
// END OF FILE                                                
//============================================================+


mssql_query("commit transaction") or die("Error SQL commit");
?>
<script>
	SoloBlock('ImpresionPdfDiv');
	SoloNone("LetTer, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon, DivImp");
	
	document.getElementById('msj').innerHTML =" ";
	
	window.open("<?=$p?>",'ImpresionPdf');
	
	document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolTom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
	
	$('#Bloquear').fadeOut(500);
</script>
<?

//set_time_limit(60);

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;
}