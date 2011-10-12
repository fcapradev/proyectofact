<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<style>
.MaClaCli{
	background-image:url(producto/Bus_Item.png);
	font-family: "TPro";
	cursor:pointer;
	margin-top:2px;
	width:415px; 
	height:28px; 
	color:#FFF; 
}
.MaClaCli2{
	background-image: url(producto/FonSel.png);
	font-family: "TPro";
	margin-top:2px;
	width:415px; 
	height:28px; 
	color:#FFF;
}
</style>

<script>

function MaOrden_Cli(co){

	$("#Mamostrar").load("MaMCli.php?co="+co);

	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt2Fac" onclick="MaBusqueda_Cli('+co+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';

	 document.getElementById('NumVol').innerHTML = '<button id="BotLetTerFac" onclick="MaBusqueda_Cli('+co+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac2"/></button>';

return false;
}

function MaBusqueda_Cli(co){
	
	var control = document.getElementById('LetTex').value.length;
	if (control == 0){ return false; }
	var da = document.getElementById('LetTex').value;
	$("#Mamostrar").load("MaMCli.php?co="+co+"&da="+da);
	
return false;
}

function MaInc_Cli(Macliente){
	
	var Maactual = document.getElementById('MaCLI').value;
	if(Maactual != Macliente){

		$('#Bloquear').fadeIn(500);

		MaCacelar_Pro();
		document.getElementById('MaCLI').value = Macliente;
		$("#archivos").load("RCli.php?cli="+Macliente);
	
	}
	
}

function MaCliente_Eve(){
	
	$("#Mamostrar").load("NCli.php?co="+co+"&da="+da);
	
}

function Mamovpaga_cli(p){

	np = p - 1;
	document.getElementById('Macapa_cli'+p).style.display="none";	
	document.getElementById('Macapa_cli'+np).style.display="block";

return false;
}

function Mamovpag_cli(p){

	np = p + 1;
	document.getElementById('capa_cli'+p).style.display="none";	
	document.getElementById('capa_cli'+np).style.display="block";

return false;
}

</script>
<?

if(isset($_REQUEST['co'])){

	$co = $_REQUEST['co'];
	
	if(isset($_REQUEST['da'])){

		$da = $_REQUEST['da'];
		switch($co){
	
		case 1:
			$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND NOM LIKE '%".$da."%' ORDER BY NOM ASC";
			$como = "alf";
		break;
		
		case 2:
			$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND COD = ".$da." ORDER BY COD ASC";
			$como = "cod"; 
		break;
		
		case 3:
			$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND NOM LIKE '%".$da."%' AND FPA = 2 ORDER BY COD ASC";
			$como = "cta";
		break;
		
		default:
			$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND NOM LIKE '%".$da."%' ORDER BY NOM ASC";
			$como = "alf";
		break;
		
		}
	
	}else{

		switch($co){
		
			case 1:
				$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 ORDER BY NOM ASC";
				$como = "alf";
			break;
			
			case 2:
				$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 ORDER BY COD ASC";
				$como = "cod"; 
			break;
			
			case 3:
				$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND FPA = 2 ORDER BY COD ASC";
				$como = "cta";
			break;
			
		default:
			$SQL = "SELECT COD, NOM FROM, CONVERT(INT,MOD) AS MOD CLIENTES WHERE NHA <> 1 ORDER BY NOM ASC";
			$como = "alf";
		break;
		}
	
	}

}else{
	$SQL = "SELECT COD, NOM, CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 ORDER BY NOM ASC";
	$como = "alf";
}

?>

<script language="javascript" type="text/javascript">

function def(){ return false; }

</script>

<div id="Matoda_la_busC">

<table width="420" border="0" cellpadding="0" cellspacing="0">
<tr>
<td valign="middle" headers="30"><img src="Clientes/tit.png" /><img src="Clientes/<? echo $como; ?>.png" /></td>
<td>
<table align="right" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>

<?php

$PARACLIENTES = mssql_query($SQL) or die("Error SQL");

rollback($PARACLIENTES);

if(mssql_num_rows($PARACLIENTES) == 0){	
	?>
	<script>
		alert("No hay clientes con la busqueda realizada.");
	</script>    
	<?
	exit;
}


$c = 0;
$cc = 0;
$s = 1;
while ($reg=mssql_fetch_array($PARACLIENTES)){

$COD = $reg['COD'];
$MOD = $reg['MOD'];

if($COD < 0){ 
	$CODM = 0; 
}else{
	$CODM = $COD;
}


	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"Macapa_cli".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
        
    	    <div id="Anterior_ProC">
			<button class="StyBoton" onClick="return Mamovpaga_cli(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
			</div>

			<?

		}

	}
	?>

    <div class="MaClaCli" id="MaCadCli<? echo $COD; ?>" onClick="MaInc_Cli(<? echo $COD; ?>)">    
	<table width="415px" cellpadding="0" cellspacing="1">
        <tr> 
        	<td width="57"><div align="center"><? echo format($CODM,5,'0',STR_PAD_LEFT); ?></div></td>	
            <td width="339">&nbsp;<? echo substr($reg['NOM'], 0, 35); ?></td>
        </tr>
	</table>  
    </div>
	
	<?

	if ($c == 7){

		?>
		
        <div id="Siguiente_ProC">
        <button class="StyBoton" onClick="return Mamovpag_cli(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
        </div>
        
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}
mssql_free_result($PARACLIENTES);
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

<?


mssql_query("commit transaction") or die("Error SQL commit");


?>
<script>
	document.getElementById("MaLoading").style.display="none";	
	var cliente = document.getElementById('MaCLI').value;
	$("#MaCadCli"+cliente).removeClass("MaClaCli").addClass("MaClaCli2");
</script>
<?


}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>