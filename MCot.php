<?
require("config/cnx.php");
?>

<style>
#CadaCoti{  
	font-family: "TPro";
	width:415px;
	color:#FFF;
}
</style>

<script language="javascript" type="text/javascript">

	function def(){ return false; }

function movpaga_cot(p){

	np = p - 1;
	document.getElementById('capa_cot'+p).style.display="none";	
	document.getElementById('capa_cot'+np).style.display="block";

return false;

}
function movpag_cot(p){

	np = p + 1;
	document.getElementById('capa_cot'+p).style.display="none";	
	document.getElementById('capa_cot'+np).style.display="block";

return false;

}

</script>
	

<div id="toda_la_busCO">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<div align="left">
		<img src="facturador/cot.png">
	</div>
</td>

<td>

	<table align="right" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>&nbsp;</td>
	</tr>
	</table>

</td>
</tr>
</table>

<?
$c = 0;
$cc = 0;
$s = 1;

$SQL = "SELECT ID, DES, COT, ABR FROM CPARBON ORDER BY ID";
$registros = mssql_query($SQL) or die("Error SQL");	
while ($reg=mssql_fetch_array($registros)){

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_cot".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_Pro">
			
			<button class="StyBoton" onClick="return movpaga_bu(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}

	?>
    <div id="CadaCoti" >
	<table width="415px" cellpadding="0" cellspacing="1">
        <tr> 
        	<td class="fon_itm" width="45" align="center">&nbsp;<? echo $reg['ID']; ?></td>	
            <td class="fon_itm" width="100">&nbsp;<? echo substr($reg['DES'], 0, 30);  ?></td>
            <td class="fon_itm" width="100">&nbsp;<? echo $reg['ABR']; ?></td>
            <td class="fon_itm" width="170">&nbsp;<? echo dec($reg['COT'],3); ?></td>
        </tr>
	</table>  
    </div>
	<?

	if ($c == 8){

		?>
		
        <div id="Siguiente_Pro">
		
        <button class="StyBoton" onClick="return  movpag_bu(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
		
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
		$("#Siguiente_Pro").fadeOut('fast');
    </script>
	<?
}

?>

</div>