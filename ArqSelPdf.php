<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selecciona PDF</title>
<style>
#Anterior_SigOpdf{
position:absolute;
top:32px;
left:430px;
}
#Siguiente_SigOpdf{
position:absolute;
top:230px;
left:430px;
}

A:link {text-decoration:none;color:#FFFFFF;} 
A:visited {text-decoration:none;color:#FFFFFF;} 
A:hover {text-decoration:underline;color:#DD7927;} 
</style>
<script language="javascript" type="text/javascript">

function movpag_a_arqselpdf(p){
	
	np = p - 1;
	document.getElementById("capa_arqselpdf"+np).style.display="block";
	document.getElementById("capa_arqselpdf"+p).style.display="none";

return false;
}

function movpag_b_arqselpdf(p){

	np = p + 1;	
	document.getElementById("capa_arqselpdf"+np).style.display="block";
	document.getElementById("capa_arqselpdf"+p).style.display="none";
	
return false;
}

function ver(a){
	$('#Bloquear').fadeIn(500);
	SoloNone("sal_arq");
	SoloNone("imprimirarq");
	SoloNone("SobreFoca");
	SoloBlock('ImpresionPdfDiv');
	SoloNone("LetTer");
	SoloNone("NumVolPADiv");
	SoloNone('fondotranspletras');
	SoloNone('TecladoLet');
	SoloNone('fondotranspnumeros');
	SoloNone('TecladoNum');
	SoloNone('CarAyuda');
	SoloNone('CarAyudaFon');

	window.open("a",'ImpresionPdf');
	
	document.getElementById('ImpPdfDivVol').innerHTML = '<button class="StyBoton" onclick="ImpreVolArq();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolfacCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolfacCom"/></button>';

	document.getElementById("fondopidetipo").style.display = "none";
	document.getElementById("descpidetipo").style.display = "none";
	document.getElementById("fondogeneral").style.display = "none";
	document.getElementById("Arq_BotVer").style.display = "none";
	document.getElementById("cruzpdf").style.display = "none";	
	$('#Bloquear').fadeOut(500);
}
</script>

</head>
<body>
<div id="detalletipospdf" style="position:absolute; top:40px; left:-146px;">

<table width="450" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="middle">
	<table>
	<tr>
		<td width="100">
			<div align="center">
				<img src="ArqueoCaja/fondo gris.png"/>
				<div style="position:absolute;top:5px; left:22px; color:#CCCCCC;">Planillas Disponibles</div>
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

<?

$directorio=opendir("Pdf/Arqueos/"); 

$c = 0;
$cc = 0;
$s = 1;



while ($archivo= readdir($directorio)){
	if($archivo=='.' or $archivo=='..'){ 
		 echo "";
	}else{

$pla_arc = explode("_", $archivo);

if($pla_arc[0] == $PLA){

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_arqselpdf".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_SigOpdf">
			
			<button class="StyBoton" onClick="return movpag_a_arqselpdf(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Sig<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Sig<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}
	?>
                
    <div  >

	<table width="435px" cellpadding="0" cellspacing="1" >
        <tr> 
            <td class="fon_itm" width="45"><div align="left"><a href='Pdf/Arqueos/<? echo $archivo; ?>' target='ImpresionPdf' style='text-decoration:none; cursor:pointer;' onclick='ver("<? echo $archivo; ?>");'> &nbsp; &nbsp;<? echo $archivo; ?></a><br></div></td>	
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 8){

		?>
		
        <div id="Siguiente_SigOpdf">
		
        <button class="StyBoton" onClick="return  movpag_b_arqselpdf(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Sig<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Sig<?php echo $s; ?>"/></button>
		
        </div>
        
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
		}
	}
	}
}


if ($cc == 8){
	?>
	<script>
		$("#Siguiente_Sig<?php echo $s-1; ?>").fadeOut('fast');
    </script>
	<?
}

closedir($directorio); 
?>

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