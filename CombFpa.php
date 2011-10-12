<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ComboPro</title>
<style>

.CadaComboCom{ 
	background:url(producto/Bus_Item.png);
	background-repeat:repeat-x;
	font-weight:bold;
	font-size:16px;
	cursor:pointer;
	color:#FFF; 
	width:280px; 
	height:28px;
}

.TituloComPro{
	font-weight:bold;
	font-size:16px;
	color:#FFF; 
	height:28px; 
}

#Anterior_Com{ 
	position:absolute; 
	left:617px; 
	top:-4px;
}

#Siguiente_Com{
	position:absolute; 
	left:617px; 
	top:136px;
}

</style>

<script>

function IncFdpago(id,fpa){

	document.getElementById("EDat5").value = id;
	document.getElementById("EDat6").value = fpa;
	SoloNone('FormaPago, FormaPagoFon');
	
	EnvAyuda('Ingrese sucursal del comprobante.');
	
	document.getElementById('LetTex').value = "";
	
	$("#EncDat5").css("border-color", "transparent");
	$("#EncDat7-1").css("border-color", "#F90");
	
	document.getElementById("DondeE").value = "EDat7_1";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('EncDat771').innerHTML = '<img src="Compras/suc.png" />';
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="Sucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolFdpago()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
	controlarcadainputcom("EDat7_1");
	
}

function movpaga_com(p){

	np = p - 1;
	document.getElementById('capa_com'+p).style.display="none";	
	document.getElementById('capa_com'+np).style.display="block";

}

function movpag_com(p){

	np = p + 1;
	document.getElementById('capa_com'+p).style.display="none";	
	document.getElementById('capa_com'+np).style.display="block";

}

</script>

</head>
<body>

<div style="position:absolute; top:28px; left:1px; ">

<?

	$SQL = "SELECT ID, NOMBRE FROM FDPAGO WHERE ID <> 4";
	$registros = mssql_query($SQL) or die("Error SQL");
	rollback($registros);
	
	$c = 0;
	$cc = 0;
	$s = 1;
	while ($reg=mssql_fetch_array($registros)){

	$ID = $reg['ID'];
	$NOM = htmlentities($reg['NOMBRE']);

		$c = $c + 1;
		$cc = $cc + 1;

		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"capa_com".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
				<div id="Anterior_Com">
					<button class="StyBoton" onClick="movpaga_com(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
				</div>
				<?
			}

		}
	
		?>
		<div class="CadaComboCom" onClick="IncFdpago(<? echo $ID; ?>, '<? echo $NOM; ?>')">
        <table width="280" cellpadding="0" cellspacing="1" align="center">
            <tr>
                <td align="left"><div align="left"><? echo $NOM; ?></div></td>
            </tr>
        </table>
		</div>
		<?
	
		if ($c == 6){
	
			?>
			
			<div id="Siguiente_Com">
				<button class="StyBoton" onClick="movpag_com(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
			</div>

			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	}
	
	mssql_close($conexion);
	
	if ($cc == 6){
		?>
		<script>
			$("#Siguiente_Com").fadeOut('fast');
		</script>
		<?
	}
	
	?>
	</div>


</div>

</body>
</html>
<?


mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}