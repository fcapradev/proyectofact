<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$TER = $_SESSION['ParPOS'];

//REQUEST
$xd = $_REQUEST['xd'];

if ($xd == 1){
	
//REQUEST
$cb = $_REQUEST['cb'];


if(strlen($cb) == 0){ 
	exit; 
}

	$_SESSION['ParSQL'] = "SELECT b.codbar, a.codsec, a.codart, a.detart, a.ExiDep, a.ExiVta, a.MinDep, a.MaxDep, a.MinPVE, a.MaxPVE, a.costo, a.FecCos, a.UltAct, a.PreNet, a.PreVen, a.CLA, a.NHA FROM ARTICULOS AS A INNER JOIN CODBAR AS B on b.codsec = a.codsec AND b.codart = a.codart WHERE b.codbar = '$cb'";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);

}

if($xd == 2){

//REQUEST
if(isset($_REQUEST['cs'])){
	$cs = $_REQUEST['cs'];
}else{
	$cs = 0;
}	
if(isset($_REQUEST['ca'])){
	$ca = $_REQUEST['ca'];
}else{
	$ca = 0;
}


if($cs == 0 && $ca == 0){

	$cn = $_REQUEST['cn'];

	$_SESSION['ParSQL'] = "SELECT TIO, PUN FROM PMOVFACT_T WHERE ORD = ".$cn." AND TER = ".$TER;
	$PMOVFACT_T = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMOVFACT_T);
	while ($PMOV_R=mssql_fetch_array($PMOVFACT_T)){
		$TIO = $PMOV_R['TIO'];
		$PUN = $PMOV_R['PUN'];
	}
	mssql_free_result($PMOVFACT_T);
	
	?>
	<script>
		SoloNone("botonesdebusqueda");
		SoloBlock("ComBotEncDiv, ComBotCueDiv, LetEnt, CuerpoProdu5, CuerpoProduTxt");
		
		SoloNone("CueDat1");
		SoloBlock("CueDat2, CueDat3, CueDat5");
		
		$("#CueDat5").css("border-color", "#F90");
		
		EnvAyuda("Ingrese detalle del articulo.");
		
		document.getElementById("CDat2").value = "0";
		document.getElementById("CDat3").value = "0";
		document.getElementById("CDat5").value = "1";
		
		document.getElementById("CDat6").value = "<? echo $TIO; ?>";
		document.getElementById("CDat8").value = "<? echo $PUN; ?>";
		document.getElementById("CDat10").value = "<? echo $PUN; ?>";
		
		document.getElementById("DondeE").value = "CDat6";
		document.getElementById("CantiE").value = "25";
		document.getElementById("QuePoE").value = "0";
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviardetalle();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		$('#Bloquear').fadeOut(500);
    </script>
	<?

	exit;
	
}

	$_SESSION['ParSQL'] = "SELECT codsec, codart, detart, ExiDep, ExiVta, MinDep, MaxDep, MinPVE, MaxPVE, costo, FecCos, UltAct, PreNet, PreVen, CLA, NHA FROM ARTICULOS WHERE codsec = ".$cs." AND codart = ".$ca."";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);

}

if($xd == 3){

//REQUEST
$co = $_REQUEST['co'];
$cp = $_REQUEST['cp'];

	$_SESSION['ParSQL'] = "SELECT SEC, ART FROM A_COD_ORI WHERE PRV = ".$cp." AND COO = '".$co."'";
	$A_COD_ORI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($A_COD_ORI);
	$cs = 0;
	$ca = 0;
	while ($ACODR = mssql_fetch_array($A_COD_ORI)){
		$cs = $ACODR['SEC'];
		$ca = $ACODR['ART'];
	}
	
	$_SESSION['ParSQL'] = "SELECT codsec, codart, detart, ExiDep, ExiVta, MinDep, MaxDep, MinPVE, MaxPVE, costo, FecCos, UltAct, PreNet, PreVen, CLA, NHA FROM ARTICULOS WHERE codsec = ".$cs." AND codart = ".$ca."";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);

}


	if(mssql_num_rows($PMAEFACT)==0){
		
		if($xd == 1){
			?>
			<script>
				document.getElementById("CDat1").value = "";
				jAlert('El codigo de barras ingresado no es correcto.', 'Debo Retail - Global Business Solution');
				controlarcadainputcom("CDat1");
			</script>
			<?
		}
		if($xd == 2){
			?>
			<script>
				document.getElementById("CDat1").value = "";			
				jAlert('El codigo ingresado no es correcto.', 'Debo Retail - Global Business Solution');
				controlarcadainputcom("CDat3");
			</script>
			<?
		}
		if($xd == 3){
			?>
			<script>
				document.getElementById("CDat1").value = "";
				jAlert('El codigo de origen ingresado no es correcto.', 'Debo Retail - Global Business Solution');
				controlarcadainputcom("CDat1");
			</script>
			<?
		}
		exit;
		
	}else{
		
		while ($reg=mssql_fetch_array($PMAEFACT)){ 
			
			$codsec = $reg['codsec'];
			$codart = $reg['codart'];
			$detart = $reg['detart'];
			
				$ExiDep = $reg['ExiDep'];
				$ExiVta = $reg['ExiVta'];				
				$MinDep = $reg['MinDep'];
				$MaxDep = $reg['MaxDep'];
				$MinPVE = $reg['MinPVE'];
				$MaxPVE = $reg['MaxPVE'];				

			$costo = dec($reg['costo'],4);
			$costo2 = $costo;
			$FecCos = $reg['FecCos'];
			$UltAct = $reg['UltAct'];
			$PreNet = $reg['PreNet'];
			$PreVen = $reg['PreVen'];
			
			$CLA = $reg['CLA'];
			$NHA = $reg['NHA'];

		}
		mssql_free_result($PMAEFACT);
		
		if($CLA == 2 || $CLA == 4 || $CLA == 7){
			?>
			<script>
				jAlert('Los productos receta, combos o servicios no se pueden ingresar.', 'Debo Retail - Global Business Solution');
				document.getElementById("CDat1").value = "";
			</script>
			<?
			exit;
		}
		
		if($NHA == 1){
			?>
			<script>
				jAlert('El producto no se encuentra habilitado.', 'Debo Retail - Global Business Solution');
				document.getElementById("CDat1").value = "";
			</script>
			<?
			exit;
		}
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($xd != 2){
		$_SESSION['ParSQL'] = "SELECT COD FROM PMOVFACT_T WHERE COD = ".$codsec." AND ART = ".$codart."";
		$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_TT);
		if(mssql_num_rows($PMAEFACT_TT)>=1){
			?>
            <script>
				jAlert('El producto ya se encuentra cargado.', 'Debo Retail - Global Business Solution');
				document.getElementById("CDat1").value = "";
				
				controlarcadainputcom("CDat1");
			</script>
			<?
            exit;
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$_SESSION['ParSQL'] = "SELECT TOP 1 COD FROM PMAEFACT_T WHERE TER = ".$TER."";
		$PMAEFACT_TT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PMAEFACT_TT);
		while ($reg=mssql_fetch_array($PMAEFACT_TT)){ 
				$COD = $reg['COD'];
		}
		mssql_free_result($PMAEFACT_TT);
		
		$_SESSION['ParSQL'] = "SELECT costo FROM PLANILLA_COSTO WHERE SEC = ".$codsec." AND COD = ".$codart."";
		$PLANILLA_COSTO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($PLANILLA_COSTO);
		while ($reg=mssql_fetch_array($PLANILLA_COSTO)){ 
			$costo2 = dec($reg['costo'],4);
		}
		mssql_free_result($PLANILLA_COSTO);
		
		$_SESSION['ParSQL'] = "SELECT COO FROM A_COD_ORI WHERE SEC = ".$codsec." AND ART = ".$codart." AND PRV = ".$COD."";
		$A_COD_ORI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($A_COD_ORI);
		if(mssql_num_rows($A_COD_ORI)==0){
			$COO = "";
		}else{
			while ($reg=mssql_fetch_array($A_COD_ORI)){ 
				$COO = $reg['COO'];
			}
		}
		mssql_free_result($A_COD_ORI);
		
		$SQL_ARTICULOS = "SELECT Costo, DepSN FROM ARTICULOS WHERE CodSec = ".$codsec." AND CodArt = ".$codart."";
		$ARTICULOS = mssql_query($SQL_ARTICULOS) or die("Error SQL");
		rollback($ARTICULOS);
		while ($ART_R = mssql_fetch_array($ARTICULOS)){
			$DepSN = $ART_R['DepSN'];
		}
		mssql_free_result($ARTICULOS);
		
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////// GRAFICO DE VENTAS /////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if($MaxPVE == 0){
			$Por = ($ExiVta / 1) * 100;
		}else{
			$Por = ($ExiVta / $MaxPVE) * 100;
		}
		
		$msj_vta = " ";
		if($ExiVta < $MinPVE){
			$msj_vta = "<samp class='ClaStockMin'>!Atencion¡ Por debajo del minimo configurado.</samp>";
		}
		
		$gra_vta = "<img src='Compras/grafico/0.png'>";
		if($Por <= 0){
			$gra_vta = "<img src='Compras/grafico/0.png'>";
		}else if($Por > 0 && $Por < 10){
			$gra_vta = "<img src='Compras/grafico/1.png'>";
		}else if($Por >= 10 && $Por < 20){	
			$gra_vta = "<img src='Compras/grafico/2.png'>";
		}else if($Por >= 20 && $Por < 30){
			$gra_vta = "<img src='Compras/grafico/3.png'>";
		}else if($Por >= 30 && $Por < 40){
			$gra_vta = "<img src='Compras/grafico/4.png'>";		
		}else if($Por >= 40 && $Por < 50){
			$gra_vta = "<img src='Compras/grafico/5.png'>";	
		}else if($Por >= 50 && $Por < 60){
			$gra_vta = "<img src='Compras/grafico/6.png'>";
		}else if($Por >= 60 && $Por < 70){
			$gra_vta = "<img src='Compras/grafico/7.png'>";
		}else if($Por >= 70 && $Por < 80){
			$gra_vta = "<img src='Compras/grafico/8.png'>";
		}else if($Por >= 80 && $Por < 90){
			$gra_vta = "<img src='Compras/grafico/9.png'>";
		}else if($Por >= 90 && $Por <= 100){
			$gra_vta = "<img src='Compras/grafico/10.png'>";
		}else if($Por > 100){
			$gra_vta = "<img src='Compras/grafico/11.png'>";
			$msj_vta = "<samp class='ClaStockMax'>!Atencion¡ Supera el maximo configurado.</samp>";
		}
		
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$msj_dep = " ";
		$gra_dep = "<img src='Compras/grafico/0.png'>";
		
		if($DepSN == 1){
			$DepSN = 'SI';
			
			/*
			PARA CUANDO TIENE DEPOSITO
			*/
			?>
			<script>
				SoloBlock("StockCriticoBot");
			</script>
			<?
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////// GRAFICO DE DEPOSITO ///////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					if($MaxDep == 0){
						$Por = ($ExiDep / 1) * 100;
					}else{
						$Por = ($ExiDep / $MaxDep) * 100;
					}
					
					if($ExiDep < $MinDep){
						$msj_dep = "<samp class='ClaStockMin'>!Atencion¡ Por debajo del minimo configurado.</samp>";
					}

					if($Por <= 0){
						$gra_dep = "<img src='Compras/grafico/0.png'>";
						$msj_dep = "<samp class='ClaStockMin'>!Atencion¡ Por debajo del minimo configurado.</samp>";
					}else if($Por >= 0 && $Por < 10){
						$gra_dep = "<img src='Compras/grafico/1.png'>";
					}else if($Por >= 10 && $Por < 20){	
						$gra_dep = "<img src='Compras/grafico/2.png'>";
					}else if($Por >= 20 && $Por < 30){
						$gra_dep = "<img src='Compras/grafico/3.png'>";
					}else if($Por >= 30 && $Por < 40){
						$gra_dep = "<img src='Compras/grafico/4.png'>";		
					}else if($Por >= 40 && $Por < 50){
						$gra_dep = "<img src='Compras/grafico/5.png'>";	
					}else if($Por >= 50 && $Por < 60){
						$gra_dep = "<img src='Compras/grafico/6.png'>";
					}else if($Por >= 60 && $Por < 70){
						$gra_dep = "<img src='Compras/grafico/7.png'>";
					}else if($Por >= 70 && $Por < 80){
						$gra_dep = "<img src='Compras/grafico/8.png'>";
					}else if($Por >= 80 && $Por < 90){
						$gra_dep = "<img src='Compras/grafico/9.png'>";
					}else if($Por >= 90 && $Por < 100){
						$gra_dep = "<img src='Compras/grafico/10.png'>";
					}else if($Por >= 100){
						$gra_dep = "<img src='Compras/grafico/11.png'>";
						$msj_dep = "<samp class='ClaStockMax'>!Atencion¡ Supera el maximo configurado.</samp>";
					}
					
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		}else{
			?>
			<script>
				SoloNone("StockCriticoBot");
			</script>
			<?
			$DepSN = 'NO';
		}
			
		$date = new DateTime($FecCos);
		$FecCos = $date->format('d/m/Y');
	
		$date = new DateTime($UltAct);
		$UltAct = $date->format('d/m/Y');
		
		?>
		<script>

			document.getElementById('CueDatInf1').innerHTML = '<? echo $detart; ?>';
			document.getElementById('CueDatInf2').innerHTML = '<? echo $FecCos; ?>';
			document.getElementById('CueDatInf3').innerHTML = '<? echo $UltAct; ?>';
			document.getElementById('CueDatInf4').innerHTML = '<? echo $costo; ?>';
			document.getElementById('CueDatInf5').innerHTML = '<? echo $PreNet; ?>';
			document.getElementById('CueDatInf6').innerHTML = '<? echo $PreVen; ?>';

			document.getElementById("CDat2").value = "<? echo $codsec; ?>";
			document.getElementById("CDat3").value = "<? echo $codart; ?>";
			document.getElementById("CDat4").value = "<? echo $COO; ?>";
			document.getElementById("CDat6").value = "<? echo $detart; ?>";			
			document.getElementById("CDat7").value = "<? echo $ExiVta; ?>";
			document.getElementById("CDat8").value = "<? echo $costo2; ?>";
			
			document.getElementById("CDat8-2").value = "<? echo $costo2; ?>";
			document.getElementById("CDat11-2").value = "<? echo $DepSN; ?>";


			document.getElementById("StockCriticoVta1").innerHTML = "<? echo $gra_vta; ?>";
			document.getElementById("StockCriticoVta2").innerHTML = "<? echo $ExiVta; ?>";
			document.getElementById("StockCriticoVta3").innerHTML = "<? echo $MaxPVE; ?>";
			document.getElementById("StockCriticoVta4").innerHTML = "<? echo $MinPVE; ?>";
			document.getElementById("StockCriticoVta5").innerHTML = "<? echo $msj_vta; ?>";
			
			document.getElementById("StockCriticoDep1").innerHTML = "<? echo $gra_dep; ?>";
			document.getElementById("StockCriticoDep2").innerHTML = "<? echo $ExiDep; ?>";
			document.getElementById("StockCriticoDep3").innerHTML = "<? echo $MaxDep; ?>";
			document.getElementById("StockCriticoDep4").innerHTML = "<? echo $MinDep; ?>";
			document.getElementById("StockCriticoDep5").innerHTML = "<? echo $msj_dep; ?>";

			$("#CueDat1").css("border-color", "transparent");
			$("#CueDat3").css("border-color", "transparent");
			
			EnvAyuda("Ingrese código de origen.");
			
			document.getElementById("DondeE").value = "CDat4";
			document.getElementById("CantiE").value = "5";
			document.getElementById("QuePoE").value = "1";

			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarCodO();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="EnvCuerpo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
			
			SoloNone('CueDat1, CuerpoLista, CuerpoProdu, NumVol, CuerpoProdu, CuerpoProdu3, CuerpoProdu4, ComBotBusDiv, BusquedaCodOrigen, LetTer, BusquedaCodDebo');
			SoloBlock('CueDat2, CueDat3, CueDat4, CueDat4-2, CueDat5, CuerpoLista2, CuerpoProdu2');
			
			controlarcadainputcom("CDat4");			
			
			$('#Bloquear').fadeOut(500);
			
		</script>
        
		<?

	}


mssql_query("commit transaction") or die("Error SQL commit");


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //

	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}