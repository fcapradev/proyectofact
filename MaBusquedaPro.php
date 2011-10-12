<?
require("config/cnx.php");
?>

<script language="javascript" type="text/javascript">

SoloNone('MaClientesFac, MaBotonesParaO, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaCotizacion');

function def(){ return false; }

function MamovPag_ab2(p){

	np = p - 1;
	document.getElementById('Macapa_bus'+p).style.display="none";
	document.getElementById('Macapa_bus'+np).style.display="block";

return false;

}
function MamovPag_ar2(p){

	np = p + 1;
	document.getElementById('Macapa_bus'+p).style.display="none";
	document.getElementById('Macapa_bus'+np).style.display="block";

return false;

}

</script>

<?
	
if(isset($_REQUEST['cs'])){

$cs = $_REQUEST['cs'];
$ca = $_REQUEST['ca'];


$_SESSION['ParSQL'] = "SELECT DetArt FROM ARTICULOS WHERE FPP = 1 AND CodSec = ".$cs." AND CodArt = ".$ca."";
$ARTICULOS_FPP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");	

while ($ART_FPP_R=mssql_fetch_array($ARTICULOS_FPP)){

	$det = $ART_FPP_R['DetArt'];
	
}

mssql_free_result($ARTICULOS_FPP);

?>

<div id="Matoda_la_bus">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<div align="left"><img src="producto/sugpro.png" /></div>
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

$SQL = "
SELECT B.CodSec AS sec, b.CodArt as art, B.DetArt as det FROM AARTPRO AS A 
INNER JOIN ARTICULOS AS B ON A.SECP = B.CodSec AND A.CODP = B.CodArt
WHERE A.SECA = ".$cs." AND A.CODA = ".$ca." AND B.NHA = 0
";
$registros = mssql_query($SQL) or die("Error SQL");	



$c = 0;
$cc = 0;
$s = 1;
	
$co = mssql_num_rows($registros); 

if($co == 0){


$SQL = "UPDATE ARTICULOS SET FPP = 0 WHERE CodSec = ".$cs." AND CodArt = ".$ca;
mssql_query($SQL) or die("Error SQL");

	?>
    <script>
		MaFX2(<? echo $cs; ?>, <? echo $ca; ?>);	
	</script>
	<?
	exit;

}


while ($reg=mssql_fetch_array($registros)){
	
	?>
    <script>
		$("#Mamicapa1").fadeOut(500);
    </script>
	<?

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_bu".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_Pro">
			
			<button class="StyBoton" onClick="return MamovPag_ab2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}

	?>
    <div onclick="MaFX1(<? echo $reg['sec']; ?>, <? echo $reg['art']; ?>);" style="font-family:'TPro'; cursor:pointer; color:#FFF; z-index:3;">
	<table width="415px" cellpadding="0" cellspacing="1" >
        <tr> 
        	<td class="fon_itm" width="32"><div align="center"><? echo format($reg['sec'],2,'0',STR_PAD_LEFT); ?></div></td>	
        	<td class="fon_itm" width="50"><div align="center"><? echo format($reg['art'],4,'0',STR_PAD_LEFT); ?></div></td>
            <td class="fon_itm" width="349">&nbsp;<? echo htmlentities(substr($reg['det'], 0, 30)); ?></td>
        </tr>
	</table>  
    </div>
	<?
	
	if ($c == 6){

		?>
		
        <div id="Siguiente_Pro">
		
        <button class="StyBoton" onClick="return MamovPag_ar2(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
		
        </div>
        
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}

mssql_close($conexion);
}

if ($cc == 6){
	?>
	<script>
		$("#Siguiente_Pro").fadeOut('fast');
    </script>
	<?
}

?>
</div>
<script>
	EnvAyuda("Busqueda: <? echo htmlentities(substr(trim($det), 0, 30)); ?>");
	document.getElementById("MaLoading").style.display="none";	
</script>