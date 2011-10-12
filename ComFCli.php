<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Combo</title>
<style>

.CadaCombo{ 
	background:url(producto/Bus_Item.png);
	background-repeat:repeat-x;
	font-weight:bold;
	font-size:16px;
	font:'Tekton Pro'; 
	cursor:pointer;
	color:#FFF; 
	width:420px; 
	height:28px;
}

.titulores{
	background: url(producto/FonMar.png);
	background-repeat:repeat-x;
	font-weight:bold;
	font-size:16px;
	font:'Tekton Pro'; 
	color:#FFF; 
	height:28px; 
}

#Anterior_Re{ 
	position:absolute; 
	left:420px; 
	top:28px;
}

#Siguiente_Re{
	position:absolute; 
	left:420px; 
	top:224px;
}

</style>

<script>

function IncRespo(r,d){
	
	SoloNone('MostrarComboDiv');
	SoloBlock('LetTer');
	
	document.getElementById("responevef").value = r;
	document.getElementById("responevef_tx").value = d;
	
}

function movpaga_re(p){

	np = p - 1;
	document.getElementById('capa_re'+p).style.display="none";	
	document.getElementById('capa_re'+np).style.display="block";

return false;

}
function movpag_re(p){

	np = p + 1;
	document.getElementById('capa_re'+p).style.display="none";	
	document.getElementById('capa_re'+np).style.display="block";

return false;

}

</script>

</head>
<body>

<div style=" position:absolute; top:10px; left:10px; ">


<table width="420" border="0" cellpadding="1" cellspacing="1">
<tr>
<td>
	<div align="center" class="titulores">
		Seleccione resposabilidad
	</div>
</td>
</tr>
</table>

<?

	$SQL = "SELECT * FROM IVA WHERE NOMBRE <> 'NO USAR'";
	$registros = mssql_query($SQL) or die("Error SQL");
	rollback($registros);
	
	$c = 0;
	$cc = 0;
	$s = 1;
	while ($reg=mssql_fetch_array($registros)){
	
	$ID = $reg['ID'];
	$NOM = $reg['NOMBRE'];
	
		$c = $c + 1;
		$cc = $cc + 1;
		
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"capa_re".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
			
				<div id="Anterior_Re">
				
				<button class="StyBoton" onClick="return movpaga_re(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
				
				</div>
	
				<?
	
			}
	
		}
	
		?>
		<div class="CadaCombo" onClick="IncRespo(<? echo $ID; ?>,'<? echo $NOM; ?>')">
		<table width="415" cellpadding="0" cellspacing="1" align="center">
			<tr> 	
				<td align="left"><div align="left"><? echo $NOM; ?></div></td>
			</tr>
		</table>  
		</div>
		<?
	
		if ($c == 8){
	
			?>
			
			<div id="Siguiente_Re">
			
			<button class="StyBoton" onClick="return  movpag_re(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
			
			</div>
			
			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	}
	
	mssql_close($conexion);
	
	
	if ($cc == 8){
		?>
		<script>
			$("#Siguiente_Re").fadeOut('fast');
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
echo $e;
exit;

}