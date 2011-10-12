<?
require("config/cnx.php");

try {////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Compras Autom&aacute;ticas</title>

<style>

#DetallesCompraAuto{
 	position:absolute;
	width:591px; 
	height:237px;
	left:54px; 
	top:81px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
}


.lineaCom{
	background-image:url(Compras/comaut/fondogris.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	
	margin-top:2px;
}

.lineaCom:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}


.lineaComNar{
	background-image:url(Compras/comaut/fondonar.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	margin-top:2px;
}


</style>

<script>

document.getElementById('pantallacompra').value = 1;
EnvAyuda2("Seleccione el Comprobante que desea Aceptar o Rechazar.");

function comprasautovuelve(){
	
	$('#ComAut').fadeOut(500);

		SoloBlock("Teclado_Completo, BotMins2, CarAyuda, CarAyudaFon, NumAre, NumTexDiv");
		SoloNone("CarAyudaFon2, CarAyuda2");
	
	$('#Compras').fadeIn(500);	
	
}

function movpag_a_nov(p){
	
	np = p - 1;
	document.getElementById("capa_nov"+np).style.display="block";
	document.getElementById("capa_nov"+p).style.display="none";

return false;
}

function movpag_b_nov(p){

	np = p + 1;	
	document.getElementById("capa_nov"+np).style.display="block";
	document.getElementById("capa_nov"+p).style.display="none";
	
return false;
}

function select_nov(t,mp,ti,tc,su,nc){

	document.getElementById('BotComAce').innerHTML = '<button class="StyBoton" onclick="compacepta(\''+ti+'\',\''+tc+'\',\''+su+'\',\''+nc+'\');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAcepta\',\'\',\'botones/ace-over.png\',0)"><img src="botones/ace-up.png" name="Aceptar" title="Aceptar" border="0" id="BotAcepta"/></button>';

	for (i=1; i<=t; i++){
	
		if(i == mp){
			
			$("#linea"+mp).removeClass("lineaCom").addClass("lineaComNar");
		
		}else{
		
			$("#linea"+i).removeClass("lineaComNar").addClass("lineaCom");
	
		}	
	}
}

function compacepta(ti,tc,su,nc){

	$('#ComAut').fadeOut(500);
	
	$("#ComAut").load("ComAutAce.php?ti="+ti+"&tc="+tc+"&su="+su+"&nc="+nc+"");
	
	$('#ComAut').fadeIn(500);

}

</script>
</head>
<body>

<!-- BOTON PARA INGRESAR A COMPRAS AUTOMATICAS - FRANCO -->

<div id="botonComprasS" style="position:absolute; top:416px; left:32px; display:block; z-index:2;">
    <button class="StyBoton" onClick="comprasautovuelve();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotComAutV','','botones/com-vol-over.png',0)" title="Volver a Compras">
    <img src="botones/com-vol-up.png" border="0" id="BotComAutV"/></button>
</div>

<div id="BotComAce" style=" position:absolute; top:416px; left:520px; z-index:4;"></div>



<div id="FondoComprasAut" style="position:absolute; top:0px; left:26px;">
	<img src="Compras/comaut/busqueda de compras automáticas.png" />
</div>

<div id="DetallesCompraAuto">

    <div id="DetalleParaBotones">
    
    
		<?

	$_SESSION['ParSQL'] = "SELECT a.zon AS emp,a.tip AS tip,a.tco AS tco,a.suc AS suc,a.nco AS nco,a.pro AS pro,a.fec AS fec,a.nom AS nom,a.estado AS estado FROM PMAEFACT_AUTO a INNER JOIN PMOVFACT_AUTO b ON a.tip=b.tip AND a.tco=b.tco AND a.suc=b.suc AND a.nco=b.nco WHERE estado = 10 and a.emp = 59
GROUP BY a.zon,a.tip,a.tco,a.suc,a.nco,a.pro ,a.fec ,a.nom ,a.estado ORDER BY fec,a.tip,a.tco,a.suc,a.nco"; 
	
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	if(!mssql_num_rows($R1TB) == 0){
		$total = mssql_num_rows($R1TB);
	}

	$c = 0;
	$cc = 0;
	$s = 1;
	
	while ($ATU=mssql_fetch_row($R1TB)){
		$c = $c + 1;
		$cc = $cc + 1;
		$ti = $ATU[1];
		$tc = $ATU[2];
		$su = $ATU[3];
		$nc = $ATU[4];
		$comprobante = $ATU[2]."  ".$ATU[1]."  ".format($ATU[3],4,'0',STR_PAD_LEFT)." - ".$ATU[4];
		$proveedor = format($ATU[5],5,'0',STR_PAD_LEFT)." - ".$ATU[7];
		$date = new DateTime($ATU[6]);
		$fec = $date->format('d-m-Y');

		if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_nov".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="AnteriorNov" style=" position:absolute; top:0px; left:599px;">
					<button class="StyBoton" onclick="movpag_a_nov(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorNov<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorNov<?php echo $s; ?>"/></button>
</div>
	
				<?
	
			}
	
			}
	
			?>
		<div class="lineaCom" id="linea<? echo $cc; ?>" >
				<table width="591" height="26" border="0" cellpadding="0" cellspacing="0" onclick="select_nov(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $ATU[1]; ?>','<? echo $ATU[2]; ?>',<? echo $ATU[3];?>,<? echo $ATU[4];?>);" style="cursor:pointer;">
						<tr>

							<td width="209" align="center"><? echo $comprobante; ?></td>
							<td width="280" align="center"><? echo $proveedor; ?></td>
							<td width="94" align="center"><? echo $fec; ?></td>

						</tr>
				</table>
		</div>
			<?
			
			if($c == 11){
			
			?>
			<div id="SiguienteNov" style="position:absolute; top:288px;  left:599px;">
				<button class="StyBoton" onclick="return movpag_b_nov(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteNov<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteNov<?php echo $s; ?>"/></button>
</div>
		
</div>
			<?php
		  
			$c = 0;
			$s = $s + 1;
	}
}
if ($cc == 11){
	?>
	<script>
		$("#SiguienteNov<?php echo $s-1; ?>").fadeOut('fast');
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
?>