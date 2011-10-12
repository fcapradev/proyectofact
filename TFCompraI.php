<?
require("config/cnx.php");
/////////////////////////////// COMPRAS
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$t = 0;

if(isset($_REQUEST['tar'])){
	
	//REQUEST
	$r_tar = $_REQUEST['tar'];
	$r_tip = $_REQUEST['tip'];
	$r_tco = $_REQUEST['tco'];
	$r_suc = $_REQUEST['suc'];
	$r_nco = $_REQUEST['nco'];
	$r_cod = $_REQUEST['cod'];
	
}else{

	exit;

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Items</title>
<style>
.CComSinP1{ 
	background: url(Compras/Bus_Item.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-size:12px;
	color:#FFF;
	height:26px;
	width:92px;
}

.CComSinP2{ 
	background: url(RetiroCaja/FonSel.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-size:12px;
	color:#FFF;
	height:26px;
	width:92px;
}

</style>
<script>
/*
function edita_item(fila,cant){

	var costo = document.getElementById("ModCosto"+fila).value;
	alert(costo);
	
	if(costo.length != 0){
	
		for (i=1; i<=cant; i++){
		
			if(i == fila){
				
				$("#celda"+fila).removeClass("CComSinP1").addClass("CComSinP2");
	
			}else{
			
				$("#celda"+i).removeClass("CComSinP2").addClass("CComSinP1");
		
			}	
		}
	}
}
*/

</script>

</head>
<body>

<?




	if($r_tar == 1){
		$SQL_PMOVFACT = "SELECT ORD, COD, ART, CAN, TIO, PUN FROM PMOVFACT 
		WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod."";
		$PMOVFACT = mssql_query($SQL_PMOVFACT) or die("Error SQL");
		rollback($PMOVFACT);
	}
	if($r_tar == 2 || $r_tar == 3){
		$SQL_PMOVFACT = "SELECT ORD, COD, ART, CAN, TIO, PUN FROM PMOVFACT_T 
		WHERE TIP = '".$r_tip."' AND TCO = '".$r_tco."' AND SUC = ".$r_suc." AND NCO = ".$r_nco." AND PRO = ".$r_cod."";
		$PMOVFACT = mssql_query($SQL_PMOVFACT) or die("Error SQL");
		rollback($PMOVFACT);
	}

	
	$c = 0;
	$cc = 0;
	$s = 1;
	
	$cant = mssql_num_rows($PMOVFACT);
	
	while ($PMOV_R=mssql_fetch_array($PMOVFACT)){
		
	$ITM = $PMOV_R['ORD'];	
	$COD = $PMOV_R['COD'];
	$ART = $PMOV_R['ART'];
	
		$Costo = 0;
		$SQL_ARTICULOS = "SELECT Costo, DepSN FROM ARTICULOS WHERE CodSec = ".$COD." AND CodArt = ".$ART."";
		$ARTICULOS = mssql_query($SQL_ARTICULOS) or die("Error SQL");
		rollback($ARTICULOS);
		while ($ART_R = mssql_fetch_array($ARTICULOS)){
			$Costo = $ART_R['Costo'];
			$DepSN = $ART_R['DepSN'];
		}
		mssql_free_result($ARTICULOS);
		
	$CAN = $PMOV_R['CAN'];
	$TIO = $PMOV_R['TIO'];
	$PUN = $PMOV_R['PUN'];
	
	$SUB = $PUN * $CAN;
	
	$DepSN = "NO";
	if($DepSN == 1){
		$DepSN = "SI";
	}
	
		$c = $c + 1;
		$cc = $cc + 1;
	
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"comcapasitems".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
				<div style="position:absolute; top:27px; left:642px;">
					<button class="StyBoton" onClick="return movant_com(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Com<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Com<?php echo $s; ?>"/></button>
				</div>
				<?
			}
	
		}
		

		
		?>
        <div id="itmesdecom<? echo $cc; ?>" class="itemslista" >      
        <?
		if($r_tar == 1 || $r_tar == 3){
			echo '<div style="cursor:pointer;" onClick="env_ite_c('.$COD.', '.$ART.', '.$cc.');">';
		}
		if($r_tar == 2){
			echo '<div>';
		}
		?>
            <table width="640" cellpadding="0" cellspacing="1" align="center">
                <tr>
                    <td class="CComSinP" width="21"><div align="center"><? echo $ITM; ?></div></td>
                    <td class="CComSinP" width="61"><div align="center"><? echo $COD." - ".$ART; ?></div></td>
                    <td class="CComSinP" width="65"><div align="center"><? echo $CAN; ?></div></td>
                    <td class="CComSinP" width="156"><div align="left"><? echo $TIO; ?></div></td>
                    <td class="CComSinP" width="92"><div align="center"><? echo dec($Costo,2); ?></div></td>
                    <td id="celda<? echo $cc; ?>" class="CComSinP1" width="92">
						<input type="text" class="ModCostoCla" readonly="readonly" id="ModCosto<? echo $cc; ?>" name="ModCosto<? echo $cc; ?>" value="<? echo dec($PUN,2); ?>" style="outline-style:none; border-style:none;" onkeypress="return ControlCosNue(<? echo $cc; ?>,<? echo $cant; ?>);" onkeydown="return ControlCosNueVol(<? echo $cc; ?>,<? echo $cant; ?>);" maxlength="5"/>
                    </td>
                    <td class="CComSinP" width="92"><div align="center"><? echo dec($SUB,2); ?></div></td>
                    <td class="CComSinP" width="38"><div align="center"><? echo $DepSN; ?></div></td>
                </tr>
            </table>
		</div>
		<?
		echo "</div>";
	
		$t = $c;
		if ($c == 6){
	
			?>
			
			<div id="Siguiente_IICom<?php echo $s; ?>" style="position:absolute; top:156px; left:642px;">
				<button class="StyBoton" onClick="return movaba_com(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Com<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Com<?php echo $s; ?>"/></button>
			</div>
	
			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	}

if($t == 6){
	?>
	<script>
		SoloNone('Siguiente_IICom<?php echo $s - 1; ?>');
	</script>
	<?
}	


mssql_query("commit transaction") or die("Error SQL commit");


mssql_free_result($PMOVFACT);


$_SESSION['ParOrnC'] = $cc;

	if($r_tar == 1){
	
		?>
		<script>
			$("#archivos").load("MFCompra.php?tip=<?=$r_tip?>&tco=<?=$r_tco?>&suc=<?=$r_suc?>&nco=<?=$r_nco?>&cod=<?=$r_cod?>");
		</script>    
		<?
	
	}
	if($r_tar == 2){
	
		?>
		<script>
			document.getElementById('ComenzarCom').value = 2;
			document.getElementById('ComenzarComV2').value = "<?=$cc?>";
		
			document.getElementById('permiso').value = 1;
			
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
			
			SoloNone('Encabezado, EncabezadoDat, ComprasDfon, CueDat2, CueDat3, CueDat4, CueDat4-2, CueDat5, LetTer');
			SoloBlock('EncabezadoLat, EncabezadoDLat, ComBotCueDiv, Cuerpo, CuerpoDat');
			
			$("#CueDat1").css("border-color", "transparent");
			
			$("#celda1").removeClass("CComSinP1").addClass("CComSinP2");
			
			EnvAyuda("Ingrese costo para el item 1.");
			
			controlarcadainputcom("ModCosto1");
			
			document.getElementById("DondeE").value = "ModCosto1";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
				
			SoloBlock('LetEnt');
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="envcosto(<? echo $cc; ?>,1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
			$('#Bloquear').fadeOut(500);
		</script>    
		<?
	}
	if($r_tar == 3){
		?>
		<script>
			document.getElementById('ComenzarCom').value = 2;
			document.getElementById('ComenzarComV2').value = "<? echo $cc; ?>";
			
			$('#Bloquear').fadeOut(500);
		</script>    
		<?
	}

?>

</body>
</html>

<?
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}