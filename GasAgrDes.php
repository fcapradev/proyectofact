<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Una Descripci&oacute;n de Gasto</title>
<style>
#detalletiposgas{
	position: absolute;
	width: 700px;
	height: 237px;
	left: -60px;
	top: -278px;
}

.fon_itmGas{ 
	background-image:url(producto/Bus_Item.png); 
	height:22px;
}
</style>
<script language="javascript" type="text/javascript">

var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

document.onkeydown = function(){

	if(window.event){
		
		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#listagasto'+contador).removeClass("gaslinea2").addClass("gaslinea1");
					}	
					
				}
				
				contador = contador - 1;
				contador_cappp = contador_cappp - 1;
			}

			if(document.getElementById('listagasto'+contador).className == 'gaslinea1'){
				$('#listagasto'+contador).removeClass("gaslinea1").addClass("gaslinea2");
			}
			
			if(contador_cappp == -1){
				if(contador_capss != 0){
					contador_cappp = 5;
					movpag_a_gassel(contador_capss);
					contador_capss = contador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
						
			if(contador < contador_total || contador == 0){

				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#listagasto'+contador).removeClass("gaslinea2").addClass("gaslinea1");
					}	
					
				}

				contador = contador + 1;
				contador_cappp = contador_cappp + 1;

				if(document.getElementById('listagasto'+contador).className == 'gaslinea1'){
					$('#listagasto'+contador).removeClass("gaslinea1").addClass("gaslinea2");
				}

				if(contador_cappp == 6){
					if(contador_capss != 0){
						contador_cappp = 0;
						movpag_b_gassel(contador_capss);
						contador_capss = contador_capss + 1;
					}
				}
			
			}
						
		}
		
		if(document.getElementById("descpidetipogas").style.display == "block"){	
			if(window.event.keyCode == 13){
				if(contador != 0){
					document.getElementById('listagasto'+contador).onclick();
					return false;					
				}
			}
		}
		
	}
	
}

function movpag_a_gassel(p){
	
	np = p - 1;
	document.getElementById("capa_gassel"+np).style.display="block";
	document.getElementById("capa_gassel"+p).style.display="none";

return false;
}

function movpag_b_gassel(p){

	np = p + 1;	
	document.getElementById("capa_gassel"+np).style.display="block";
	document.getElementById("capa_gassel"+p).style.display="none";
	
return false;
}

function envia_des(id,des){
	
	document.getElementById('tipogas').value = des;
	document.getElementById('idtipogas').value = id;

	SoloNone("fondodescgas, fondodescgasimg, descpidetipogas");

	$("#obsgas").css("border-color", "#F90");
	$("#des").css("border-color", "transparent");
		
	EnvAyuda("Ingrese una observaci&oacute;n");

	$("#tipogas").removeAttr("onclick");
	controlarcadainputche('obs');
	
	document.getElementById("DondeE").value = "obs";
	document.getElementById("CantiE").value = "60";
	document.getElementById("QuePoE").value = "0";
		
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	document.getElementById('NumVol').innerHTML = '<button id="LetVolGas" onclick="volver_gas1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolGas\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolGas"/></button>';
	
	$('#obs').focus();
	
}
</script>

<style>
.gaslinea1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro";
	height:28px;
}

.gaslinea2{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	height:28px;
}
</style>

</head>
<body>

<table width="292" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table>
	<tr>
		<td align="center"><div align="center" style="top:220px;"><img src="Novedades/novdes.png" /></div></td>
		<td><div style="font: 'TPro'; font-size:16px; color:#FFFFFF; font-weight:bold;"></div></td>
	</tr>
	</table>
</td>
<td>
	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr><td></td></tr>
    </table>
</td>
</tr>
</table>

<div style="top:35px; left:0px; position:absolute;">
<?php

$_SESSION['ParSQL'] = "SELECT ID, DESCRIPCION FROM DESC_GASTOS ORDER BY ID"; 
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
if(mssql_num_rows($R1TB) == 0){	
	?>
	<script>
		alert("No hay tipos en este momento.");
	</script>    
	<?
	exit;
}else{
	$total = mssql_num_rows($R1TB);
}

$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($R1TB)){

$ID = $reg['ID'];
$DES = $reg['DESCRIPCION'];;

if($ID == -1){ $ID = 0; }

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_gassel".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_SigG" style="	position:absolute; top:-2px; left:290px;">
			<button class="StyBoton" onClick="return movpag_a_gassel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Sig<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Sig<?php echo $s; ?>"/></button>
			</div>

			<?

		}

	}
	?>
                
    <div id="listagasto<?php echo $cc; ?>" class="gaslinea1" onClick="envia_des(<? echo $ID; ?>,'<? echo trim($DES); ?>');">
	<table width="293px" cellpadding="0" cellspacing="1" style="cursor:pointer;">
        <tr> 
        	<td style="font-family:'TPro'; font-size:17px;" width="29"><div align="center"><? echo $ID; ?></div></td>	
            <td style="font-family:'TPro'; font-size:17px;" width="264">&nbsp;&nbsp;&nbsp;<? echo $DES; ?></td>
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 5){
		
		?>
        
        <div id="Siguiente_SigG" style="position:absolute; top:128px; left:290px;">
	        <button class="StyBoton" onClick="return  movpag_b_gassel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Sig<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Sig<?php echo $s; ?>"/></button>
        </div>
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}

if ($cc == 5){
	?>
	<script>
		$("#Siguiente_SigG<?php echo $s-1; ?>").fadeOut('fast');
    </script>
	<?
}


?>

</div>
	<script>
		contador_total = <?=$total?>;
	</script>
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