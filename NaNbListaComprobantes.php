<?
require("config/cnx.php");

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
if(isset($_REQUEST['num'])){
	$r_num = (int)$_REQUEST['num'];
}else{
	$r_num = "";
}

if($r_suc == 0){ $r_suc = ""; }
if($r_num == 0){ $r_num = ""; }


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
		document.getElementById("Lista_Art").innerHTML = "";	
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
			
			$("#LisFacComDatMed").load("NaNbListaCompDet.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
			
			SoloBlock("BotonesLisTarMod");
			document.getElementById('BotonesLisTarMod').innerHTML = '<button class="StyBoton" onclick="AceptarItem(\''+tip+'\', \''+tco+'\', '+suc+', '+nco+', '+cod+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLisConMod\',\'\',\'botones/ace-over.png\',0)"><img src="botones/ace-up.png" name="Aceptar" title="Aceptar" border="0" id="BotLisConMod"/></button>';
	
		}
		
		function AceptarItem(tip, tco, suc, nco, cod){
			
			SoloBlock("Comprobante_Items, Lista_Items");
			SoloNone("LetEnt");
			
			document.getElementById("Sucursal").value = suc;
			document.getElementById("Tipo").value = tip;
			document.getElementById("Tco").value = tco;
			document.getElementById("Numero").value = nco;
			document.getElementById("ProveedorId").value = document.getElementById("tit4").innerHTML;
			document.getElementById("Proveedor").value = document.getElementById("tit3").innerHTML;
			
			var can_art = document.getElementById("cantidad_art").innerHTML;
			var i = 0;
			var top = 93;
			for( i = 1 ; i <= can_art ; i++){
				var cod = document.getElementById("cod"+i).innerHTML;
				var can = document.getElementById("can"+i).innerHTML;
				var det = document.getElementById("detart"+i).innerHTML;
				var pre = document.getElementById("pre"+i).innerHTML;
				
////	LISTA DE ARTICULOS    ////
				if(i <= 8 ){
					$('#Lista_Art').append('<tr><td><div style="background:url(NaNb/compr_art.png); width:592px; height:17px; position:absolute; left:17px; top:'+top+'px;"><div id="CodigoItem'+i+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:-2px; width:44px; cursor:pointer; text-align:center;">'+i+'</div><div id="CodigoDestino'+i+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:47px; width:64px; cursor:pointer; text-align:center;">'+cod+'</div><div id="DetalleDestino'+i+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:125px; width:334px; cursor:pointer;">'+det+'</div><div id="CantDestinoCom'+i+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:468px; width:37px; cursor:pointer; text-align:center;">'+can+'</div><div id="CostoDestino'+i+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:540px; width:35px; cursor:pointer; text-align:center;">'+dec(pre,2)+'</div></div></td></tr>');
					top = top + 17;
				}

			}
			SalLisComprobantes();
			
			SoloBlock("LetTer");
			
			document.getElementById('LetTer').innerHTML = '<button onclick="ConfirmaCompr();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntNaNbTer\',\'\',\'botones/ace-over.png\',0)"><img src="botones/ace-up.png" name="Aceptar" title="Aceptar" border="0" id="LetEntNaNbTer"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="VolNumero();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
			
			$("div").css("border-color", "transparent");
			Ir_a("ConfirmaC",0,1);
			
			EnvAyuda("Presione Aceptar para confirmar el comprobante.");
		}
		
		
	</script>
       
	<?


	$c = 0;
	$cc = 0;
	$s = 1;
	$t = 0;
	
	$_SESSION['ParSQL'] = "
	SELECT TIP, TCO, SUC, NCO, COD, ANU FROM PMAEFACT 
	WHERE TIP LIKE '%$r_tip%' AND TCO LIKE '%$r_tco%' AND SUC LIKE '%$r_suc%' AND CG = 'C' AND PLA = ".$PLA." AND ZON = ".$_SESSION['ParEMP']."
	ORDER BY SUC ASC";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	
	if(mssql_num_rows($PMAEFACT) == 0){
		?>
		<script>
			
			jAlert('El Proveedor ingresado no contiene datos', 'Debo Retail - Global Business Solution');
			
			SoloBlock('NotaCuerpo, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon');
			SoloNone('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis, LisFacComDat');

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