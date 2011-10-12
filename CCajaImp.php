<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


require_once('ImpPDF/tcpdf/config/lang/spa.php');
require_once('ImpPDF/tcpdf/tcpdf.php');


// create new PDF document
$pdf = new TCPDF("p", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Debo Retail');
$pdf->SetTitle('Confirmación de Caja');
$pdf->SetSubject('Foca Software');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('debo.jpg', 50, '', 'Confirmación de Caja - '.date('Y-m-d H:i'));

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

$pdf->SetFont('courier', '', 12);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_REQUEST['pla'])){

	$TER = $_SESSION['ParPOS'];
	$PLA = $_REQUEST['pla'];

	$_SESSION['ParSQL'] = "SELECT CER,PLC FROM ATURNOSO WHERE PLA = ".$PLA."";
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);
	while ($reg=mssql_fetch_array($registros)){
		$CER = $reg['CER'];
		$PLC = $reg['PLC'];
	}	

	$_SESSION['ParSQL'] = "SELECT DET FROM CONTROL_STOCK_IMPRE_HISTORICO WHERE inf = 1 and pos = ".$TER." and pla = ".$PLA." ORDER BY ORD";
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);
	
	if(mssql_num_rows($registros) == 0){
		?>
		<script>
	
			$('#Bloquear').fadeOut(500);
			
			jAlert('No se puede ReImprimir Planilla.', 'Debo Retail - Global Business Solution');
	
			$("#Confirmar").load("MCaja.php");
			
			SoloNone("LetEnt, LetTer");
			SoloBlock('LetSal, NumVol, NumVolPro, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CierreTurno');	
		</script>
		<?
		exit();
	}
	
	if(($CER == "C") && ($PLC == "S")){
	?>
	<script>
/*
		jConfirm("¿La Planilla se encuentra Cerrada, desea Reimprimirla?.", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				//CONTINIA
			}else{
				$('#Bloquear').fadeOut(500);
				$("#Confirmar").load("MCaja.php");
				SoloNone("LetEnt, LetTer");
				SoloBlock('LetSal, NumVol, NumVolPro, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CierreTurno');
			}
		});
*/
	</script>
	<?
	}else{
	?>
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert('La Planilla se encuentra Abierta.', 'Debo Retail - Global Business Solution');
		$("#Confirmar").load("MCaja.php");
		SoloNone("LetEnt, LetTer");
		SoloBlock('LetSal, NumVol, NumVolPro, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CierreTurno');

	</script>
	<?
	exit();
	}
	
}else{
	
	$TER = $_SESSION['ParPOS'];
	$_SESSION['ParSQL'] = "SELECT DET FROM CONTROL_STOCK_IMPRE WHERE inf = 1 and pos = ".$TER." ORDER BY ORD";
	$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($registros);
}





while ($reg=mssql_fetch_array($registros)){
	
	$DET = $reg['DET'];
	$DET = str_replace(" ", "&nbsp;", $DET);
		
	$html = '
		<table width="640" border="0" cellpadding="-3" cellspacing="-3">
		<tr>
			<td>'.$DET.'</td>
		</tr>
		</table>
	';

	$pdf->writeHTML($html, true, false, true, false, '');

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$js = 'print(true);';
$pdf->IncludeJS($js);


//============================================================+
// END OF FILE                                                
//============================================================+


$p = "Pdf/Cajas/Cajas".$TER."_".date("H")."-".date("i")."hs.pdf";
$pdf->Output($p, 'F');


mssql_query("commit transaction") or die("Error SQL commit");


	?>
	<script>

		$('#Bloquear').fadeOut(500);
		
		SoloBlock('ImpresionPdfDiv');
		
		window.open("<? echo $p; ?>",'ImpresionPdf');

		document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="SalirImpre();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';
		
		EnvAyuda("Ocultar");

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