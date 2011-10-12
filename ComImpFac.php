<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');


//SESSION
$LUG = $_SESSION['ParLUG'];
$TER = $_SESSION['ParPOS'];

//REQUEST
$r_tip = $_REQUEST['tip'];
$r_tco = $_REQUEST['tco'];
$r_suc = $_REQUEST['suc'];
$r_nco = $_REQUEST['nco'];
$r_cod = $_REQUEST['cod'];

$FAC = $r_tip." - ".$r_tco." - ".format($r_suc,4,'0',STR_PAD_LEFT)." - ".format($r_nco,8,'0',STR_PAD_LEFT);

$_SESSION['ParSQL'] = "SELECT NOM, OPE, FPA, FEC, FEV, NET, NEE, RGA, IRI, IRS, RIB, PIV, RIV, IMI, CNG, CNG2, DTO, PER, TOT FROM PMAEFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND COD = ".$r_cod;
$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($PMAEFACT);
while ($PMA_R = mssql_fetch_array($PMAEFACT)){
	
	$NOM = $PMA_R['NOM'];
	$OPE = $PMA_R['OPE'];	
	$FPA = $PMA_R['FPA'];
	
	$FEC = $PMA_R['FEC'];
	$FEV = $PMA_R['FEV'];

	$NET = dec($PMA_R['NET'],2);
	$NEE = dec($PMA_R['NEE'],2);
	$RGA = dec($PMA_R['RGA'],2);
	$IRI = dec($PMA_R['IRI'],2);
	$IRS = dec($PMA_R['IRS'],2);
	$RIB = dec($PMA_R['RIB'],2);
	$PIV = dec($PMA_R['PIV'],2);

	$RIV = dec($PMA_R['RIV'],2);
	$IMI = dec($PMA_R['IMI'],2);
	$CNG = dec($PMA_R['CNG'],2);
	$CNG2 = dec($PMA_R['CNG2'],2);
	$DTO = $PMA_R['DTO'];
	$PER = dec($PMA_R['PER'],2);
	$TOT = dec($PMA_R['TOT'],2);
	
}
mssql_free_result($PMAEFACT);


$date = new DateTime($FEC);
$FEC = $date->format('d/m/Y');

$date = new DateTime($FEV);
$FEV = $date->format('d/m/Y');


$NomVen = "SIN OPERARIO";
$_SESSION['ParSQL'] = "SELECT NomVen FROM VENDEDORES WHERE CodVen = ".$OPE;
$VENDEDORES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($VENDEDORES);
while ($VEN_R = mssql_fetch_array($VENDEDORES)){
	$NomVen = $VEN_R['NomVen'];
}
mssql_free_result($VENDEDORES);


$FORMADEPAGO = "SIN FORMA DE PAGO";
$_SESSION['ParSQL'] = "SELECT NOMBRE FROM FDPAGO WHERE ID = ".$FPA;
$FDPAGO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($FDPAGO);
while ($FDP_R = mssql_fetch_array($FDPAGO)){
	$FORMADEPAGO = $FDP_R['NOMBRE'];
}
mssql_free_result($FDPAGO);








// create new PDF document

$pdf = new TCPDF("p", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Debo Retail');
$pdf->SetTitle('Factura de Compra');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, '', 'Copia de factura de compra '.date('Y-m-d H:i'));

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

$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$titulos = '
	<table width="640" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td align="right">'.$NomVen.'</td>
		<td rowspan="4" style="font-size:100px" align="center" valign="middle">'.$r_tip.'</td>
		<td>'.$FAC.'</td>
	  </tr>
	  <tr>
		<td align="right">&nbsp;</td>
		<td>Fecha de Factura: '.$FEC.'</td>
	  </tr>
	  <tr>
		<td align="right">'.$NOM.'</td>
		<td>Fecha de Carga: '.$FEV.'</td>
	  </tr>
	  <tr>
		<td align="right">'.$FORMADEPAGO.'</td>
		<td>Asiento: 0</td>
	  </tr>
	</table>
	';
	
$pdf->writeHTML($titulos, true, false, false, false, '');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$c = 0;
$html = '<table width="640" border="0" cellpadding="0" cellspacing="0">';
	
	$_SESSION['ParSQL'] = "SELECT COD, ART, CAN, TIO, PUN FROM 
	PMOVFACT WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod;
	$PMOVFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT);
	$total = 0;
	while ($PMOV_R = mssql_fetch_array($PMOVFACT)){
		
		$CODIGO = format($PMOV_R['COD'],2,'0',STR_PAD_LEFT).'-'.format($PMOV_R['ART'],4,'0',STR_PAD_LEFT);
		$CAN = $PMOV_R['CAN'];
		$TIO = $PMOV_R['TIO'];
		$PUN = $PMOV_R['PUN'];
		$IMP = $CAN * $PUN;
		$IMP = dec($IMP,2);
		
		$total = $total + $IMP;
		
		++$c;
		
		if($c == 1){
			$html = $html.'
			<tr>
				<td bgcolor="#999999" width="55" align="center" >C&oacute;digo</td>
				<td bgcolor="#999999" width="125" align="center">Cantidad</td>
				<td bgcolor="#999999" width="210">Detalle</td>
				<td bgcolor="#999999" width="125" align="center">Precio</td>
				<td bgcolor="#999999" width="125" align="center">Importe</td>
			</tr>
			<tr>
				<td width="55" >&nbsp;</td>
				<td width="125">&nbsp;</td>
				<td width="210">&nbsp;</td>
				<td width="125">&nbsp;</td>
				<td width="125">&nbsp;</td>
			</tr>
			';
		}

		$html = $html.'
		<tr>
			<td width="55" align="center">'.$CODIGO.'</td>
			<td width="125" align="center">'.$CAN.'</td>
			<td width="210">'.$TIO.'</td>
			<td width="125" align="center">'.dec($PUN,2).'</td>
			<td width="125" align="center">'.$IMP.'</td>
		</tr>
		';

	}

$html = $html."</table>";

$pdf->writeHTML($html, true, false, true, false, '');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$copy = '
	<table width="640" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				Solo a efecto de control comprobate no valido como factura.
			</td>
		</tr>
		<tr>
			<td align="center">
				Copia de comprobante de compra.
			</td>
		</tr>
	</table>
';

$pdf->writeHTML($copy, true, false, true, false, '');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$htotal = '
	<table width="640" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Total Items: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$total.'</td>
		</tr>
		<tr>
			<td width="380">&nbsp;</td><td width="130">&nbsp;</td><td width="130">&nbsp;</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Neto Gravado: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$NET.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Neto Exento: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$NEE.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Retencion Ganancias: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$RGA.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">IVA Responsable: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$IRI.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Iva Otros: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$IRS.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Retencion Ingresos Brutos: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$RIB.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Percepcion IVA: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$PIV.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Retencion IVA: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$RIV.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Impuesto Interno: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$IMI.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Conceptos no Grabados: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$CNG.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Conceptos no Grabados2: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$CNG2.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Conceptos no Grabados2: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$CNG2.'</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Descuento: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$DTO.' %</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Percepcion Ingresos Brutos: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$PER.'</td>
		</tr>
		<tr>
			<td width="380">&nbsp;</td><td width="130">&nbsp;</td><td width="130">&nbsp;</td>
		</tr>
		<tr>
			<td width="380" align="right">&nbsp;</td>
			<td width="130" align="right" style="border:solid 1px #000;">Total: &nbsp;</td>
			<td width="130" align="left" style="border:solid 1px #000;">&nbsp;'.$TOT.'</td>
		</tr>
		
	</table>
';

$pdf->writeHTML($htotal, true, false, true, false, '');


$js = 'print(true);';
$pdf->IncludeJS($js);


//============================================================+
// END OF FILE                                                
//============================================================+

$p = "Pdf/Compras/Compras".$TER.".pdf";
$pdf->Output($p, 'F');


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		
		SoloBlock('ImpresionPdfDiv');
		
		window.open("<? echo $p; ?>",'ImpresionPdf');

		document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
		
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