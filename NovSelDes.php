<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

	$DESC = $_REQUEST['d'];
	
	if($DESC == ""){
	
	?>
	<script>
		jAlert('Seleccione un tipo previamente');
		document.getElementById("fondopidetipo").style.display = "none";
		document.getElementById("descpidetipo").style.display = "none";
		document.getElementById("fondogeneral").style.display = "none";
	</script>
	<?
	exit();
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Tipo Novedad</title>
<style>
#Siguiente_SigN{
position:absolute;
top:200px;
left:415px;
}

#Anterior_SigN{
position:absolute;
top:30px;
left:415px;
}

.novlinea1a{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro";
	height:28px;
}

.novlinea2a{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	height:28px;
}
</style>
<script language="javascript" type="text/javascript">


var contador1 = 0;
var contador1_cappp = 0;
var contador1_capss = 1;
var contador1_total = 0;
/*
document.onkeydown = function(){

	if(window.event){
		
		if(window.event.keyCode == 38){
			
			var concontador1 = contador1 - 1;
			
			if(concontador1 <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=contador1_total; i++){
				
					if(i != contador1){
						$('#listanovA'+contador1).removeClass("novlinea2a").addClass("novlinea1a");
					}	
					
				}
				
				contador1 = contador1 - 1;	
				contador1_cappp = contador1_cappp - 1;
			}

			if(document.getElementById('listanovA'+contador1).className == 'novlinea1a'){
				$('#listanovA'+contador1).removeClass("novlinea1a").addClass("novlinea2a");
			}
			
			if(contador1_cappp == -1){
				if(contador1_capss != 0){
					contador1_cappp = 8;
					movpag_a_novsel(contador1_capss);
					contador1_capss = contador1_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
			if(contador1 < contador1_total || contador1 == 0){

				for (i=1; i<=contador1_total; i++){
				
					if(i != contador1){
						$('#listanovA'+contador1).removeClass("novlinea2a").addClass("novlinea1a");
					}	
					
				}

				contador1 = contador1 + 1;
				contador1_cappp = contador1_cappp + 1;

				if(document.getElementById('listanovA'+contador1).className == 'novlinea1a'){
					$('#listanovA'+contador1).removeClass("novlinea1a").addClass("novlinea2a");
				}

				if(contador1_cappp == 9){
					if(contador1_capss != 0){
						contador1_cappp = 0;
						movpag_b_novsel(contador1_capss);
						contador1_capss = contador1_capss + 1;
					}
				}
			
			}
						
		}
		
		if(document.getElementById("TituloDesc").style.display == "block"){	
			if(window.event.keyCode == 13){
				if(contador1 != 0){
					document.getElementById('listanovA'+contador1).onclick();

					return false;					
				}
			}
		}
	}
}
*/
function movpag_a_novsel(p){
	
	np = p - 1;
	document.getElementById("capa_novsel"+np).style.display="block";
	document.getElementById("capa_novsel"+p).style.display="none";

return false;
}

function movpag_b_novsel(p){

	np = p + 1;	
	document.getElementById("capa_novsel"+np).style.display="block";
	document.getElementById("capa_novsel"+p).style.display="none";
	
return false;
}

function envia_des(id,des){
	document.getElementById('des').value = des;
	document.getElementById('iddesc').value = id;
	
	document.getElementById("fondopidetipo").style.display = "none";
	document.getElementById("descpidetipo").style.display = "none";
	document.getElementById("fondogeneral").style.display = "none";
	
	$("#texto").css("border-color", "#F90");
	$("#desdiv").css("border-color", "transparent");
	
	$("#des").removeAttr("onclick");
	
	$("#obs").focus();
	controlarcadainputche("obs");
	
	EnvAyuda("Ingrese una Observaci&oacute;n y presione ENTER");
	
	document.getElementById("DondeE").value = "obs";
	document.getElementById("CantiE").value = "60";
	document.getElementById("QuePoE").value = "0";

	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';

}
</script>

</head>
<body>
<div id="detalletipos">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table>
	<tr>
		<td align="center">
			<div id="TituloDesc" align="center" style="display:block; top:220px;">
				<img src="Novedades/novdes.png" /> 
			</div>
		</td>
		<td>
			<div style="font: 'TPro'; font-size:16px; color:#FFFFFF; font-weight:bold;">
				
			</div>
		</td>
	</tr>
	</table>
</td>

<td>

	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	</td>
	</tr>
	</table>

</td>
</tr>
</table>

<?php

$SQL = "SELECT * FROM DESC_TIPO_NOVEDADES WHERE ID_TIPO_NOVEDAD = ".$DESC."";
$PARATIPOS = mssql_query($SQL) or die("Error SQL");
rollback($PARATIPOS);
if(mssql_num_rows($PARATIPOS) == 0){	
	?>
	<script>
		alert("No hay tipos en este momento.");
	</script>    
	<?
	exit;
}else{
	$total = mssql_num_rows($PARATIPOS);
}

$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($PARATIPOS)){

$ID = $reg['ID'];
$DES = $reg['DESC'];

if($ID == -1){ $ID = 0; }


	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_novsel".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_SigN">
			
			<button class="StyBoton" onClick="return movpag_a_novsel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Sig<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Sig<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}
	?>
                
    <div  id="listanovA<?php echo $cc; ?>" class="novlinea1a" onClick="envia_des(<? echo $ID; ?>,'<? echo $DES; ?>');">
	<table width="415px" cellpadding="0" cellspacing="1" style="cursor:pointer;">
        <tr> 
        	<td style="font-family:'TPro'; font-size:17px;" width="29"><div align="center"><? echo $ID; ?></div></td>	
            <td style="font-family:'TPro'; font-size:17px;" width="349">&nbsp;<? echo $DES; ?></td>
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 7){
		?>
        <div id="Siguiente_SigN">
	        <button class="StyBoton" onClick="return  movpag_b_novsel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Sig<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Sig<?php echo $s; ?>"/></button>
        </div>
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}
//mssql_free_result($PARATIPOS);
//mssql_close($conexion);


if ($cc == 8){
	?>
	<script>
		$("#Siguiente_SigN").fadeOut('fast');
    </script>
	<?
}


?>

</div>
	<script>
		contador1_total = <?=$total?>;
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