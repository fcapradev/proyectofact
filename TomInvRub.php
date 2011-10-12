<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['rub'])){

	$rub = $_REQUEST['rub'];
	$sec = $_REQUEST['sec'];
	
	if($rub != 0){
	
		$_SESSION['ParSQL'] = "SELECT * FROM RUBROS WHERE CodSec = ".$sec." AND CodRub = ".$rub."";
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);
		if(mssql_num_rows($R1TB) == 0){	
			?>
			<script>
			
				jAlert('El Rubro ingresado no existe.', 'Debo Retail - Global Business Solution');
				document.getElementById('rubroid').value = "";
				document.getElementById('rubro').value = "< RUBRO >";
				
				document.getElementById("DondeE").value = "rubroid";
				document.getElementById("CantiE").value = "3";
				document.getElementById("QuePoE").value = "1";
				
				EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';

				SoloNone("BotSelTodRubOn");
				SoloBlock("BotSelTodRubOff");

			</script>    
			<?
			exit;
		}
	
		while ($reg=mssql_fetch_array($R1TB)){
			$ID = $reg['CodRub'];
			$DES = $reg['NomRub'];
		}
		?>
		<script>

			document.getElementById('rubro').value = "<? echo trim($DES); ?>";
			document.getElementById('rubroid').value = "<? echo $ID; ?>";
			
			$("#rub").css("border-color", "transparent");
	
			SoloNone("BotSelTodRubOn");
			SoloBlock("BotSelTodRubOff");
	
		</script>
		<?

	}else{
		?>
		<script>
	
			SoloNone("BotSelTodRubOn");
			SoloBlock("BotSelTodRubOff");
	
		</script>
		<?
	
		
	}

}else{




$let = '';
$tip = '';
if(isset($_REQUEST['b'])){
	$b = $_REQUEST['b'];
}
if(isset($_REQUEST['let'])){
	$let = $_REQUEST['let'];
	$tip = $_REQUEST['tip'];
}
$sector=0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar un Rubro</title>
<style>

.fon_sec{ 
	background-image:url(InventarioToma/fon-item-suc.png);
	height:19px; 
	font-family: "TPro";
	width:229px;
}

.fon_sec:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

#detalletiposrub{
	position:absolute;
	top:-422px;
	left:81px;
	z-index:3;
	font-size:12px;
	color:#FFF;
	display:block;
}
</style>
<script language="javascript" type="text/javascript">

$("#sec").css("border-color", "transparent");
$("#rubmay").css("border-color", "transparent");
$("#opeinv").css("border-color", "transparent");

function movpag_a_novrub(p){
	np = p - 1;
	document.getElementById("capa_novrub1"+np).style.display="block";
	document.getElementById("capa_novrub1"+p).style.display="none";
	return false;
}

function movpag_b_novrub(p){
	np = p + 1;	
	document.getElementById("capa_novrub1"+np).style.display="block";
	document.getElementById("capa_novrub1"+p).style.display="none";
	return false;
}

function envia_tip(id,des){

	document.getElementById('rubro').value = des;
	document.getElementById('rubroid').value = id;

	document.getElementById("fondopiderub").style.display = "none";
	document.getElementById("descpiderub").style.display = "none";
	document.getElementById("fondorub").style.display = "none";
	document.getElementById('botbusr').style.display = "none";

	document.getElementById("LetTex").value = "";
	
	$("#rub").css("border-color", "transparent");
	
	EnvAyuda("Presione Enter para Listar");

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv9\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv9"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';


}

</script>

</head>
<body>

<div id="detalletiposrub">
<?php
if($sector == 0){
	if($b == "T"){
		$SQL = "SELECT * FROM RUBROS WHERE CodRub not in(0)";
	}else{
		if($tip == 2){
			$SQL = "SELECT * FROM RUBROS WHERE CodSec = ".$b." AND NomRub LIKE '".$let."%' AND CodRub not in(0)";
			
		}else{
			$SQL = "SELECT * FROM RUBROS WHERE CodSec = ".$b." AND NomRub LIKE '%".$let."%' AND CodRub not in(0)";
		}
	}
}else{
	$SQL = "SELECT * FROM RUBROS WHERE CodSec = ".$sector." AND CodRub not in(0)";
}
$PARATIPOS = mssql_query($SQL) or die("Error SQL");
rollback($PARATIPOS);
if(mssql_num_rows($PARATIPOS) == 0){	
	?>
	<script>
		$('#Bloquear1').fadeOut(500);
		jAlert('No hay tipos en este momento.', 'Debo Retail - Global Business Solution');
	</script>    
	<?
	exit;
}
$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($PARATIPOS)){
	$ID = $reg['CodRub'];
	$DES = $reg['NomRub'];
if($ID == -1){ $ID = 0; }
	$c = $c + 1;
	$cc = $cc + 1;
	if ($c == 1){
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
		echo "<div id=\"capa_novrub1".$s."\" style=\"display:".$e."\">";
		if($s <> 1){
			?>
    	    <div id="Anterior_Rub1" style="position:absolute; top:0px; left:235px;">
			<button class="StyBoton" onClick="return movpag_a_novrub(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Rub1<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Rub1<?php echo $s; ?>"/></button>
			</div>
			<?
		}
	}
	?>

   	<div style="cursor:pointer;" onClick="envia_tip(<? echo $ID; ?>,'<? echo trim($DES); ?>');">

	<table width="231px" cellpadding="0" cellspacing="1">
        <tr> 
        	<td class="fon_sec" width="29"><div >&nbsp;&nbsp;&nbsp;&nbsp;<? echo str_pad($ID, 4, "0", STR_PAD_LEFT); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $DES; ?></div></td>	
        </tr>
	</table>
    </div>
	<?
	$t = $c;
	if ($c == 7){
		?>
        <div id="Siguiente_Rub1<?php echo $s; ?>" style="position:absolute; top:100px; left:235px;">
        <button class="StyBoton" onClick="return  movpag_b_novrub(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Rub1<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Rub1<?php echo $s; ?>"/></button>
        </div>
        </div>
		<?php
		$c = 0; 
        $s = $s + 1;  
	}
}
if ($t == 7){
	?>
	<script>
		SoloNone("Siguiente_Rub1<?php echo $s-1; ?>");
    </script>
	<?
}
?>
</div>

<script>
	$('#Bloquear1').fadeOut(500);
</script>

</body>
</html>
<?

}
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