<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
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

.novlinea1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro";
	height:28px;
}

.novlinea2{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	height:28px;
}

</style>
<script language="javascript" type="text/javascript">

var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;
/*
document.onkeydown = function(){

	if(window.event){
		
		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#listanov'+contador).removeClass("novlinea2").addClass("novlinea1");
					}	
					
				}
				
				contador = contador - 1;	
				contador_cappp = contador_cappp - 1;
			}

			if(document.getElementById('listanov'+contador).className == 'novlinea1'){
				$('#listanov'+contador).removeClass("novlinea1").addClass("novlinea2");
			}
			
			if(contador_cappp == -1){
				if(contador_capss != 0){
					contador_cappp = 8;
					movpag_a_novsel(contador_capss);
					contador_capss = contador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
			if(contador < contador_total || contador == 0){

				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#listanov'+contador).removeClass("novlinea2").addClass("novlinea1");
					}	
					
				}

				contador = contador + 1;
				contador_cappp = contador_cappp + 1;

				if(document.getElementById('listanov'+contador).className == 'novlinea1'){
					$('#listanov'+contador).removeClass("novlinea1").addClass("novlinea2");
				}

				if(contador_cappp == 9){
					if(contador_capss != 0){
						contador_cappp = 0;
						movpag_b_novsel(contador_capss);
						contador_capss = contador_capss + 1;
					}
				}
			
			}
						
		}
		
		if(document.getElementById("TituloTipo").style.display == "block"){	
			if(window.event.keyCode == 13){
				if(contador != 0){
					document.getElementById('listanov'+contador).onclick();

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

function envia_tip(id,des){
	document.getElementById('tipo').value = des;
	document.getElementById('idtipo').value = id;
	document.getElementById('des').value = '<SELECCIONE UNA DESCRIPCION>';
	document.getElementById('iddesc').value = '';
	document.getElementById("fondopidetipo").style.display = "none";
	document.getElementById("descpidetipo").style.display = "none";
	document.getElementById("fondogeneral").style.display = "none";

	$("#tipodiv").css("border-color", "transparent");
	$("#desdiv").css("border-color", "#F90");
	
	$("#tipo").removeAttr("onclick");
	$('#des').attr('onclick', 'buscades();');
	
	$('#des').focus();
	controlarcadainputche("des");
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button id="LetVolNov" onclick="volver_nov1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolNov\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolNov"/></button>';
	
	EnvAyuda("Presione Enter para buscar una Descripci&oacute;n.");
}

</script>

</head>
<body>
<div id="detalletipos">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="middle">
	<table>
	<tr>
		<td>
			<div id="TituloTipo" align="center" style="display:block;">
				<img src="Novedades/novtipo.png" /> 
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

$SQL = "SELECT * FROM TIPO_NOVEDADES ORDER BY ID";
$PARATIPOS = mssql_query($SQL) or die("Error SQL");
rollback($PARATIPOS);
if(mssql_num_rows($PARATIPOS) == 0){	
	?>
	<script>
		jAlert('No hay tipos en este momento.', 'Debo Retail - Global Business Solution');
	</script>    
	<?
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

    <div id="listanov<?php echo $cc; ?>" class="novlinea1" style="cursor:pointer;" onclick="envia_tip(<? echo $ID; ?>,'<? echo $DES; ?>');">
	<table width="415px" cellpadding="0" cellspacing="1" style="cursor:pointer;">
        <tr> 
        	<td style="font-family:'TPro'; font-size:17px;" width="29"><div align="center"><? echo $ID; ?></div></td>	
            <td style="font-family:'TPro'; font-size:17px;" width="349">&nbsp;<? echo $DES; ?></td>
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 9){

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


if ($cc == 9){
	?>
	<script>
		$("#Siguiente_SigN").fadeOut('fast');
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