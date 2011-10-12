<?php
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
	
}
if(isset($_POST['imp01'])){

	$Imp_Linea[0] = $_POST['imp00'];
	$Imp_Linea[1] = $_POST['imp01'];
	$Imp_Linea[2] = $_POST['imp02'];
	$Imp_Linea[3] = $_POST['imp03'];
	$Imp_Linea[4] = $_POST['imp04'];
	$Imp_Linea[5] = $_POST['imp05'];
	$Imp_Linea[6] = $_POST['imp06'];
	$Imp_Linea[7] = $_POST['imp07'];
	$Imp_Linea[8] = $_POST['imp08'];
	$Imp_Linea[9] = $_POST['imp09'];
	
	if(isset($_POST['imp10'])){
		$Imp_Linea[10] = $_POST['imp10'];
	}else{
		$Imp_Linea[10] = "";
	}
	if(isset($_POST['imp11'])){
		$Imp_Linea[11] = $_POST['imp11'];
	}else{
		$Imp_Linea[11] = "";
	}
	if(isset($_POST['imp12'])){
		$Imp_Linea[12] = $_POST['imp12'];
	}else{
		$Imp_Linea[12] = "";
	}
	if(isset($_POST['imp13'])){
		$Imp_Linea[13] = $_POST['imp13'];
	}else{
		$Imp_Linea[13] = "";
	}
	if(isset($_POST['imp14'])){
		$Imp_Linea[14] = $_POST['imp14'];
	}else{
		$Imp_Linea[14] = "";
	}
	if(isset($_POST['imp15'])){
		$Imp_Linea[15] = $_POST['imp15'];
	}else{
		$Imp_Linea[15] = "";
	}
	if(isset($_POST['imp16'])){
		$Imp_Linea[16] = $_POST['imp16'];
	}else{
		$Imp_Linea[16] = "";
	}
	
	if($_POST['imp17'] != "N"){
		$Imp_Linea[17] = $_POST['imp17'];
		$mon1 = $_POST['imp23'];
	}
	
	if($_POST['imp18'] != "N"){
		$Imp_Linea[18] = $_POST['imp18'];
		$mon2 = $_POST['imp24'];
	}

	if($_POST['imp19'] != "N"){
		$Imp_Linea[19] = $_POST['imp19'];
		$mon3 = $_POST['imp25'];
	}

	if($_POST['imp20'] != "N"){
		$Imp_Linea[20] = $_POST['imp20'];
		$mon4 = $_POST['imp26'];
	}

	if($_POST['imp21'] != "N"){
		$Imp_Linea[21] = $_POST['imp21'];
		$mon5 = $_POST['imp27'];
	}

	if(isset($_POST['imp22'])){
		$Imp_Linea[22] = $_POST['imp22'];
	}else{
		$Imp_Linea[22] = "";
	}
	
}else{
	exit;
}

require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aukon');
$pdf->SetTitle('Planillas de Arqueo');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, 'Foca Software', ' ');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
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

$pdf->Write(0, 'Planilla de Arqueo Nº: '.$Imp_Linea[0].'', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

$tbl = <<<EOD

<table width="710" height="16" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
		<tr>
			<td width="710" align="center">Detalles</td>
		</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

$tbl = '
<table width="309" border="0" cellpadding="0" cellspacing="0">

	<tr><td colspan="2" align="left">'.$Imp_Linea[1].'</td></tr>
	<tr><td colspan="2" align="left">'.$Imp_Linea[2].'</td></tr>
	<tr><td colspan="2" align="left">'.$Imp_Linea[3].'</td></tr>
	<tr><td colspan="2" align="left">'.$Imp_Linea[4].'</td></tr>
	<tr><td colspan="2" align="left">&nbsp;</td></tr>
	<tr><td colspan="2" align="left">'.$Imp_Linea[5].'</td></tr>
	<tr><td colspan="2" align="left">&nbsp;</td></tr>
	<tr>
		<td width="144" ><div align="right">TOTAL A RENDIR :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[6].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">TOTAL RENDIDO :</div></td>	
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[7].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">DIFERENCIA :</div></td>	
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[8].'</div></td>
	</tr>
	<tr>
		<td colspan="2" width="165" align="left"><div align="left"><br /></div></td>
	</tr>

	<tr>
		<td colspan="2" width="309" align="left">&nbsp;'.$Imp_Linea[9].'</td>
	</tr>

	<tr>
		<td colspan="2" width="165" align="left"><div align="left"><br /></div></td>
	</tr>

	<tr>
		<td width="144" ><div align="right">EFECTIVO :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[10].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">GASTOS :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[11].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">CHEQUES :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[12].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">ANTICIPOS :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[13].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">TARJETAS :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[14].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">CAMBIO RECIBIDO :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[15].'</div></td>
	</tr>
	<tr>
		<td width="144" ><div align="right">RETIRO EFECTIVO :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[16].'</div></td>
	</tr>
</table>';
$pdf->writeHTML($tbl, true, false, false, false, '');

/*

	if($_POST['imp17'] != "N"){
	$tbl = '
<table>
	<tr>
		<td width="144" ><div align="right">'.$mon1.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[17].'</div></td>
	</tr>
</table>	
	';
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	if($_POST['imp18'] != "N"){
	$tbl = '
<table>
	<tr>
		<td width="144" ><div align="right">'.$mon2.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[18].'</div></td>
	</tr>
</table>	';
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	if($_POST['imp19'] != "N"){
	$tbl = '
<table>
	<tr>
		<td width="144" ><div align="right">'.$mon3.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[19].'</div></td>
	</tr>
</table>		';
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	if($_POST['imp20'] != "N"){
	$tbl =  '
<table>
	<tr>
		<td width="144" ><div align="right">'.$mon4.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[20].'</div></td>
	</tr>
</table>		';
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	if($_POST['imp21'] != "N"){
	$tbl = '
<table>
	<tr>
		<td width="144" ><div align="right">'.$mon5.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[21].'</div></td>
	</tr>
</table>';
	$pdf->writeHTML($tbl, true, false, false, false, '');
	}
*/


	$tbl = '
<table>';
if($_POST['imp17'] != "N"){
$tbl.='
	<tr>
		<td width="144" ><div align="right">'.$mon1.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[17].'</div></td>
	</tr>
	';
}

if($_POST['imp18'] != "N"){
$tbl .= '
	<tr>
		<td width="144" ><div align="right">'.$mon2.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[18].'</div></td>
	</tr>
	';
}
	
if($_POST['imp19'] != "N"){
$tbl .= '
	<tr>
		<td width="144" ><div align="right">'.$mon3.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[19].'</div></td>
	</tr>
	';
}
	
if($_POST['imp20'] != "N"){
$tbl .=  '

	<tr>
		<td width="144" ><div align="right">'.$mon4.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[20].'</div></td>
	</tr>
	';
}
	
if($_POST['imp21'] != "N"){
$tbl .= '
	<tr>
		<td width="144" ><div align="right">'.$mon5.' :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[21].'</div></td>
	</tr>
	';
}
	
$tbl .= '
	<tr>
		<td width="144" ><div align="right">COMP. DE CONTADO :</div></td>
		<td width="165" align="left"><div align="left">&nbsp;'.$Imp_Linea[22].'</div></td>
	</tr>
</table>';
	$pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = '
<table width="400" height="16" cellpadding="0" border="0" cellspacing="0">
	<tr>
		<td colspan="3" >&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" >&nbsp;</td>
	</tr>
	<tr>
		<td >&nbsp;<div align="center"> ----------------------- </div></td>
		<td >&nbsp;<div align="center"> ----------------------- </div></td>
		<td >&nbsp;<div align="center"> ----------------------- </div></td>
	</tr>
	<tr>
		<td ><div align="center">Firma</div></td>
		<td ><div align="center">Aclaración</div></td>
		<td ><div align="center">Nº Legajo<b></b></div></td>
	</tr>
</table>
';
$pdf->writeHTML($tbl, true, false, false, false, '');


$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);

//Close and output PDF document
//Close and output PDF document
$p = "Pdf/Arqueos/".$PLA."_Arqueo_Planilla_".date('d-m-y H')."hs.pdf";
$pdf->Output($p, 'F');

//============================================================+
// END OF FILE                                                
//============================================================+

mssql_query("commit transaction") or die("Error SQL commit");
?>
<script>
	SoloBlock('ImpresionPdfDiv');
	SoloNone("LetTer");
	SoloNone('fondotranspletras');
	SoloNone('TecladoLet');
	SoloNone('fondotranspnumeros');
	SoloNone('TecladoNum');
	SoloNone('CarAyuda');
	SoloNone('CarAyudaFon');

	window.open("<?=$p?>",'ImpresionPdf');
	document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolArq();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
	
	$('#Bloquear').fadeOut(500);
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