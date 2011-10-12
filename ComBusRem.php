<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION
$LUG = $_SESSION['ParLUG'];

//REQUEST
$cp = $_REQUEST['cp'];


	$c = 0;
	$s = 1;
	$t = 0;
			
	$_SESSION['ParSQL'] = "SELECT TIP, TCO, SUC, NCO, FEC FROM PMAEFACT WHERE TIP = 'R' AND TCO = 'RE' AND COD = ".$cp." AND REC = 0";
	$PMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PMAEFACT);
	
	if(mssql_num_rows($PMAEFACT)==0){

		?>
		<script>
			SoloNone("BusquedaRemito, LetTer");
			SoloBlock("Encabezado, EncabezadoDat, LetEnt");

			$("#EncDat15").css("border-color", "transparent");
			
			document.getElementById('EDat15').value = "Sin Remitos";
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="Remitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volverderemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
			
			Empresa();
			
			$('#Bloquear').fadeOut(500);
		</script>
		<?
		exit;
		
	}
	
	
	?>
    <table width="443" height="20" border="0" cellpadding="0" cellspacing="1">
    <tr>
  		<td background="Compras/barra.png" style="background-repeat:no-repeat" align="center">
        <samp style="font-family: 'TPro'; font-size:14px">
       		Consulta de remitos
        </samp>
        </td>
    </tr>
    </table>
	<?
	
	$ti = mssql_num_rows($PMAEFACT);
	
	while ($PMOV_R = mssql_fetch_array($PMAEFACT)){

		$TIP = $PMOV_R['TIP'];
		$TCO = $PMOV_R['TCO'];
		$SUC = format($PMOV_R['SUC'],4,'0',STR_PAD_LEFT);
		$NCO = format($PMOV_R['NCO'],8,'0',STR_PAD_LEFT);
		$FEC = $PMOV_R['FEC'];	
		
		$date = new DateTime($FEC);
		$Fecha = $date->format('d / m / Y H:i');
		
		$FAC = $TIP."-".$TCO."-".$SUC."-".$NCO;
		
	++$c;

	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"CapFacComB".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div style="position:absolute; top:36px; left:440px;">
				<button class="StyBoton" onclick="mov_ant_bus_rem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AntFacComC','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AntFacComC"/></button>
			</div>
	
			<?
	
		}
	
	}

	?>
	<div onClick="enviar_remito(<? echo $ti; ?>, <? echo $c; ?>);">
		<table width="440" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td style="cursor:pointer;" width="40">
            	<div class="ComSinTil" id="cadatilde<? echo $c; ?>">
               		<input type="hidden" id="valorcadatilde<? echo $c; ?>" name="valorcadatilde<? echo $c; ?>" value="<? echo $FAC; ?>" />
                </div>
            </td>
            <td class="CCom" width="40"><div align="center"><? echo $TIP; ?></div></td>
			<td class="CCom" width="40"><div align="center"><? echo $TCO; ?></div></td>
			<td class="CCom" width="80"><div align="center"><? echo $SUC; ?></div></td>
            <td class="CCom" width="90"><div align="center"><? echo $NCO; ?></div></td>
            <td class="CCom" width="140"><div align="center"><? echo $Fecha; ?></div></td>
		</tr>
	  </table>
	</div>
	<?php
	
    $t = $c;
	if ($c == 8){
	
		?>
	
		<div id="SigFacComCBid<?php echo $s; ?>" style="position:absolute; top:171px; left:440px;">
			<button class="StyBoton" onclick="mov_sig_bus_rem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SigFacComC','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SigFacComC"/></button>
		</div>
		
		</div>
		
		<?php
		
		$c = 0;
		$s = $s + 1;

	}
			
}
mssql_free_result($PMAEFACT);

if($t == 8){
	?>
    <script>
		SoloNone('SigFacComCBid<?php echo $s - 1; ?>');
	</script>
    <?
}

mssql_query("commit transaction") or die("Error SQL commit");

	?>
	<script>
		SoloBlock("BusquedaRemito");
		SoloNone("ComBotEncDiv, Encabezado, EncabezadoDat, LetEnt, LetTer");

		document.getElementById('NumVol').innerHTML = '<button onclick="volverderemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
		
		$('#Bloquear').fadeOut(500);
	</script>
	<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
echo $e;
exit;

}

?>