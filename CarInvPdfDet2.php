<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(1200);

require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');

$imp = 0;
$val = 0;
//////////// BUSCO LOS DATOS
$num_inv = $_POST["var"];
if(isset($_POST['impsel'])){
	$imp = $_POST['impsel'];
}
if(isset($_POST['valsel'])){
	$val = $_POST['valsel'];
}

$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];
}	

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
	$fec = $RART1['FEC'];
}
$date1 = new DateTime($fec);
$fec = $date1->format('d-m-Y H:m:i');
$date2 = new DateTime($fet);
$fet = $date2->format('d-m-Y H:m:i');

if($dep == 1){
	$dep = "DEPOSITO";
}else{
	$dep = "VENTAS";
}	

$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVD WHERE INV = $num_inv"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_row($R1TB)){
$sec = $ATU[1];
}
$_SESSION['ParSQL'] = "SELECT * FROM sectores WHERE id = $sec"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
while ($ATU=mssql_fetch_row($R1TB)){
$nomsec = $ATU[1];
}


// create new PDF document

$pdf = new TCPDF("l", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Aukon - Retail');
$pdf->SetTitle('Carga de Inventario');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, 'Carga de Inventario '.date('Y-m-d H:i'), 'Empresa Nº: '.$numEmp.'. Detallado Por Precio de Venta');

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
<table width="955" height="16" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="2">&nbsp;<b>Descripci&oacute;n:</b> '.$detalle.'</td>
		<td width="58">&nbsp;<b>Operario:</b> </td>
		<td>&nbsp;'.$ope.'</td>
	  </tr>
	  <tr>
		<td width="75">&nbsp;<b>Sector:</b> </td>
		<td width="403">&nbsp;'.$nomsec.'</td>
		<td>&nbsp;<b>Tipo:</b></td>
		<td>&nbsp;'.$dep.'</td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro Mayor:</b> </td>
		<td>&nbsp;'.$rubmay.'</td>
		<td>&nbsp;<b>Tomado:</b></td>
		<td>&nbsp;'.$fet.'</td>
	  </tr>
	  <tr>
		<td>&nbsp;<b>Rubro:</b> </td>
		<td>&nbsp;'.$rub.'</td>
		<td>&nbsp;<b>Grabado:</b></td>
		<td>&nbsp;'.$fec.'</td>
	  </tr>		
</table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

//**ITEMS A MOSTRAR
$_SESSION['ParSQL'] = "SELECT *,round(PRE,4,1) PRE,round(COS,4,1) COS,round(CAR,4,1) CAR,round(AJU,4,1) AJU,round(REA,4,1) REA,round(DIF,4,1) DIF,round(CON,4,1) FROM ITOMINVD WHERE INV = $num_inv ORDER BY INV DESC"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
$total = 0;
$total2 = 0;
$c = 0;
while ($ATU=mssql_fetch_array($R1TB)){
	$SEC=format($ATU['SEC'],2,'0',STR_PAD_LEFT);
	$ART=format($ATU['ART'],4,'0',STR_PAD_LEFT);
	$SVC = $ATU['REA'] * $ATU['COS'];
	$SVC = dec($SVC,2);			//STOCK VAL COS
	$DF = $ATU['DIF'] * $ATU['PRE'];
	$t = dec($DF,2);				//DIF VALORIZADA
	$total = $total + $t;
	$total = dec($total,2);
	$total2 = $total2 + $SVC;
	$total2 = dec($total2,2);

$c++;
if($c == 1){
$lista = '<table border="0" width="955" cellpadding="0" cellspacing="0">
			<tr bordercolor="#999999" bgcolor="#999999">
				<td width="55" align="center">C&oacute;digo</td>
				<td width="305" align="center">Producto</td>
				<td width="65" align="center">Stock a la Toma</td>
				<td width="65" align="center">Stock Inventario</td>
				<td width="65" align="center">Stock a la Carga</td>
				<td width="65" align="center">Ajuste de Stock</td>
				<td width="65" align="center">Stock Real</td>
				<td width="65" align="center">Diferencia de Stock</td>
				<td width="65" align="center">Precio Unitario</td>
				<td width="65" align="center">Diferencia Valorizada</td>
				<td width="65" align="center">Stock Val. Costo</td>
			</tr>
			<tr bordercolor="#999999">
				<td width="55" >&nbsp;</td>
				<td width="305">&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
				<td width="65" >&nbsp;</td>
			</tr>
		</table>';	
		
$pdf->writeHTML($lista, true, false, false, false, '');
}

$lista = '<table border="0" width="955" cellpadding="-10" cellspacing="0">
			<tr>
				<td width="55" align="center">'.$SEC.'-'.$ART.'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="305" align="left">&nbsp;&nbsp;&nbsp;&nbsp;'.$ATU['DET'].'</td>
				<td width="65" align="right">'.dec($ATU['TOM'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['CON'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['CAR'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['AJU'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['REA'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['DIF'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.dec($ATU['PRE'],2).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.$t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td width="65" align="right">'.$SVC.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
		</table>';
$pdf->writeHTML($lista, true, false, false, false, '');
}

$tbl = '
<hr>
<br>
	<table width="995" border="0" >
		<tr >
			<td width="730" >&nbsp;</td>
			<td width="65" align="center" border="1" bgcolor="#999999" bordercolor="#666666">&nbsp;Dif.Pr.Ven</td>
			<td width="65" align="center" border="1" bgcolor="#999999" bordercolor="#666666">&nbsp;Dif.Pr.Cos</td>
			<td width="85" align="center" border="1" bgcolor="#999999" bordercolor="#666666">&nbsp;Valor Pre. Costo</td>
		</tr>
		<tr >
			<td width="730" >&nbsp;</td>
			<td colspan="2" align="center" border="1" bordercolor="#666666">&nbsp;TOTALES: '.$total.'</td>
			<td width="85" align="center" border="1" bordercolor="#666666">&nbsp;'.$total2.'</td>
		</tr>
	</table>	
	
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//Close and output PDF document
$p = "Pdf/CargaInventario/Car_Inv_Ven_".$numEmp.".pdf";
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

	document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
	
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