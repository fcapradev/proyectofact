<?
require("config/cnx.php");
?>
<style>
.paraitems{ 
	background-image:url(producto/Bus_Item.png); 
	background-repeat:repeat-x; 
	font-family: "TPro"; 
	font-size:14px;
	cursor:pointer; 
	height:28px;
	color:#FFF; 
}

#Anterior_ProRem{
	position:absolute;
	left:417px; 
	top:21px;
}

#Siguiente_ProRem{
	position:absolute;
	left:417px; 
	top:210px;
}

</style>

<script language="javascript" type="text/javascript">

document.getElementById("MaClientesFac").style.display="none";
function def(){ return false; }

function movpaga_ree(p){

	np = p - 1;
	document.getElementById('capa_ree'+p).style.display="none";	
	document.getElementById('capa_ree'+np).style.display="block";

return false;

}
function movpag_ree(p){

	np = p + 1;
	document.getElementById('capa_ree'+p).style.display="none";	
	document.getElementById('capa_ree'+np).style.display="block";

return false;

}

function reemitirci(suc,nco){
	jConfirm('Desea re emitir el comprobante seleccionado.', 'Debo Retail - Global Business Solution', function(r){
		if(r){
			$("#archivos").load("RECom.php?suc="+suc+"&nco="+nco);
		}
	});
}

</script>


<div id="toda_la_bus">


<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<div align="left">
		<img src="facturador/reemit.png">
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
	mssql_free_result($registros);

$c = 0;
$cc = 0;
$s = 1;

$SQL = "SELECT * FROM AMAEFACT WHERE PLA = ".$PLA." AND TCO = 'CI' AND ANU <> 'A' ORDER BY FEC DESC";		
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

		echo "<div id=\"capa_ree".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_ProRem">
			
			<button class="StyBoton" onClick="return movpaga_ree(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
			
			</div>

			<?

		}

	}

	$fecha = $reg['FEC'];
	$date = new DateTime($fecha);
	$fecha = $date->format('d-m-Y H:i');
			
	?>
    <div class="paraitems" onClick="reemitirci(<? echo $reg['SUC']; ?>,<? echo $reg['NCO']; ?>)">    
    <table width="420" cellpadding="0" cellspacing="1">
        <tr> 
        	<td width="17" height="28"><div align="center"><? echo $reg['TIP']; ?></div></td>	
			<td width="17" height="28"><div align="center"><? echo $reg['TCO']; ?></div></td>
           	<td width="80" height="28">&nbsp;<? echo format($reg['SUC'],4,'0',STR_PAD_LEFT); ?>-<? echo format($reg['NCO'],8,'0',STR_PAD_LEFT); ?></td>
            <td width="90" height="28"><div align="center"><? echo $fecha; ?></div></td>
            <td width="70" height="28"><div align="center"><? echo $reg['TOT']; ?></div></td>
        </tr>
	</table>
    </div>    
	<?

	if ($c == 8){

		?>
		
        <div id="Siguiente_ProRem">
		
        <button class="StyBoton" onClick="return  movpag_ree(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
		
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