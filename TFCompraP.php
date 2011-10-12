<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

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

//SESSION
$LUG = $_SESSION['ParLUG'];


//REQUEST
if(isset($_REQUEST['tip'])){
	$r_tip = $_REQUEST['tip'];
}else{
	$r_tip = "";
}
if(isset($_REQUEST['tco'])){
	$r_tco = $_REQUEST['tco'];
}else{
	$r_tco = "";
}
if(isset($_REQUEST['suc'])){
	$r_suc = (int)$_REQUEST['suc'];
}else{
	$r_suc = "";
}
if(isset($_REQUEST['cod'])){
	$r_cod = (int)$_REQUEST['cod'];
}else{
	$r_cod = "";
}

if($r_suc == 0){ $r_suc = ""; }
if($r_cod == 0){ $r_cod = ""; }


$NOM = "SIN NOMBRE";
$DOM = "SIN DOMICILIO";


	$_SESSION['ParSQL'] = "SELECT NOM, CON, DOM FROM PROVEED where COD = ".$r_cod."";
	$PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PROVEED);
	while ($PR_R = mssql_fetch_array($PROVEED)){
		$NOM = $PR_R['NOM'];
		$DOM = $PR_R['DOM'];
	}
	mssql_free_result($PROVEED);
	
	?>
    <style>
		.ItemLis{
			background-image: url(Compras/Bus_Item.png);
			background-repeat:repeat-x;
			cursor:pointer;
			height:28px; 
			z-index:4;
		}
		
		.ItemLis3{
			background-image: url(RetiroCaja/FonSel.png);
			background-repeat:repeat-x;
			cursor:pointer;
			height:28px; 
			z-index:4;
		}
		
		
		.ItemLis:active{ 
			position:relative;
			left:1px;
			top:1px;
			
			-moz-box-shadow:0px 1px 0;
			-webkit-box-shadow:0px 1px 0;
		}
	</style>
	<script>
	
		$('#LisFacComDat').fadeOut(500);
		document.getElementById('LisNom').innerHTML = '<? echo utf8_encode($NOM); ?>';
		document.getElementById('LisDom').innerHTML = '<? echo $DOM; ?>';

		function mov_ant_fac(p){

			np = p - 1;	
			document.getElementById("CapFacCom"+np).style.display="block";
			document.getElementById("CapFacCom"+p).style.display="none";
			
		return false;
		}
		function mov_sig_fac(p){
			
			np = p + 1;	
			document.getElementById("CapFacCom"+np).style.display="block";
			document.getElementById("CapFacCom"+p).style.display="none";
			
		return false;
		}

		function HabFacCom(tip, tco, suc, nco, cod, fila, cant){
			
			$('#LisFacComDat').fadeIn(500);
			
			for (i=1; i<=cant; i++){

				if(i == fila){
					
					$("#ItemLis"+fila).removeClass("ItemLis").addClass("ItemLis3");
				
				}else{
				
					$("#ItemLis"+i).removeClass("ItemLis3").addClass("ItemLis");
			
				}	
				
			}
			
			$("#LisFacComDatMed").load("TFCompraC.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
			
			document.getElementById('BotonesLisTarMod').innerHTML = '<button class="StyBoton" onclick="ModLisCom(\''+tip+'\', \''+tco+'\', '+suc+', '+nco+', '+cod+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLisConMod\',\'\',\'botones/mod-over.png\',0)"><img src="botones/mod-up.png" name="Modificar" title="Modificar" border="0" id="BotLisConMod"/></button>';
			
			document.getElementById('BotonesLisTarEli').innerHTML = '<button class="StyBoton" onclick="EliLisCom(\''+tip+'\', \''+tco+'\', '+suc+', '+nco+', '+cod+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLisConEli\',\'\',\'botones/eli-over.png\',0)"><img src="botones/eli-up.png" name="Eliminar" title="Eliminar" border="0" id="BotLisConEli"/></button>';
		
			document.getElementById('BotonesLisTarImp').innerHTML = '<button class="StyBoton" onclick="ImpLisCom(\''+tip+'\', \''+tco+'\', '+suc+', '+nco+', '+cod+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLisConImp\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotLisConImp"/></button>';
		
		}
		
		function ModLisCom(tip, tco, suc, nco, cod){
			
			$('#Bloquear').fadeIn(500);
			SalLisCom();
			
			SoloBlock("LetEnt");
			
			document.getElementById("EDat7_2").value = tip;
			document.getElementById("EDat7_3").value = tco;
			document.getElementById("EDat7_1").value = suc;
			document.getElementById("EDat7_4").value = nco;
			document.getElementById("EDat3").value = cod;
	
			$("#archivos").load("TFCompra.php?tar=1&tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
						
			document.getElementById("HabFunModCom").value = 1;
			document.getElementById("Modifica").value = 1;
			
		}
		
		function EliLisCom(tip, tco, suc, nco, cod){
			
			var fac = tip+" - "+tco+" - "+suc+" - "+nco;

			jConfirm("¿Est\u00e1 seguro que desea eliminar la factura "+fac+"?", "Debo Retail - Global Business Solution", function(r){	
				if(r == true ){
				
					$('#Bloquear').fadeIn(500);
					
					$("#archivos").load("EFCompra.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
					
					$("#LisFacComLis").load("TFCompraP.php?cod="+cod);
					
					SoloNone("CarAyudaFon, CarAyuda");
				}
			});
			
		}
		
		function ImpLisCom(tip, tco, suc, nco, cod){
			
			$('#Bloquear').fadeIn(500);
			$("#archivos").load("ComImpFac.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);

		}
		
	</script>
       
	<?


	$c = 0;
	$cc = 0;
	$s = 1;
	$t = 0;
	
	$_SESSION['ParSQL'] = "
	SELECT TIP, TCO, SUC, NCO, COD, ANU FROM PMAEFACT 
	WHERE TIP LIKE '%$r_tip%' AND TCO LIKE '%$r_tco%' AND SUC LIKE '%$r_suc%' AND COD = $r_cod AND CG = 'C'
	ORDER BY FEC DESC";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	
	if(mssql_num_rows($PMAEFACT) == 0){
		?>
		<script>
			
			jAlert('El Proveedor seleccionado no contiene facturas de compras', 'Debo Retail - Global Business Solution');
			
			SoloNone('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis');
			SoloBlock('LetTer, ComprasFondo, ComprasDatos, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon, BotMins2');
			$('#Bloquear').fadeOut(500);
        </script>
		<?
		exit;
	}

	$cant = mssql_num_rows($PMAEFACT);
	
	while($PMA_R = mssql_fetch_array($PMAEFACT)){
		
		$TIP = $PMA_R['TIP'];
		$TCO = $PMA_R['TCO'];
		$SUC = $PMA_R['SUC'];
		$NCO = $PMA_R['NCO'];
		$COD = $PMA_R['COD'];
		$ANU = $PMA_R['ANU'];
		
		if($ANU != " "){
		
			$ANU = "[".$ANU."]";	
			
		}
		
	++$c;
	++$cc;
	
	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"CapFacCom".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div style="position:absolute; top:298px; left:225px;">
				<button class="StyBoton" onclick="mov_ant_fac(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Fac_ComP','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Fac_ComP"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="ItemLis" id="ItemLis<? echo $cc; ?>" onClick="HabFacCom('<? echo $TIP; ?>', '<? echo $TCO; ?>', <? echo $SUC; ?>, <? echo $NCO; ?>, <? echo $COD; ?>, <? echo $cc; ?>, <? echo $cant; ?>)">
		<table width="267" height="28" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td width="60"><? echo $TIP; ?></td>
			<td width="60"><? echo $TCO; ?></td>
			<td width="65"><? echo $SUC; ?></td>
			<td width="75"><? echo $NCO; ?><samp style="color:#F00; font-weight:bold;"><b><? echo $ANU; ?></b></samp></td>
		</tr>
	  </table>
	</div>
	<?
	$t = $c;
	if ($c == 10){
	
		?>
	
		<div id="Siguiente_Fac_ComPid<?php echo $s; ?>" style="position:absolute; top:298px;  left:190px;">
			<button class="StyBoton" onclick="mov_sig_fac(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Fac_ComP','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Fac_ComP"/></button>
		</div>
		
		</div>
		
		<?php
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMAEFACT);


	if($t == 10){
		?>
		<script>
			SoloNone('Siguiente_Fac_ComPid<? echo $s-1; ?>');
		</script>
		<?
	}


mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
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