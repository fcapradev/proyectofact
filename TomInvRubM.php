<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['rubm'])){

	$rubm = $_REQUEST['rubm'];

	if( $rubm != 0){
		
		$_SESSION['ParSQL'] = "SELECT * FROM RUBMAY WHERE CodRub = ".$rubm.""; 
		$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R1TB);
		if(mssql_num_rows($R1TB) == 0){	
			?>
			<script>
				jAlert('El Rubro Mayor ingresado no existe.', 'Debo Retail - Global Business Solution');
				document.getElementById('rubromid').value = "";
				document.getElementById('rubrom').value = "< RUBRO MAYOR >";
				
				document.getElementById("DondeE").value = "rubromid";
				document.getElementById("CantiE").value = "3";
				document.getElementById("QuePoE").value = "1";
				
				EnvAyuda("Ingrese un Rubro Mayor o Presione Enter para listar");
		
				document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
		
				document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';
	
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
	
			document.getElementById('rubrom').value = "<? echo trim($DES); ?>";
			document.getElementById('rubromid').value = "<? echo $ID; ?>";
			
			$("#rub").css("border-color", "#F90");
			$("#rubmay").css("border-color", "transparent");
	
			SoloBlock("BotSelTodOff");
			SoloNone("BotSelTodOn");
	
		</script>
		<?

	}
	
}else{



$let = '';
$tip = 0;
if(isset($_REQUEST['let'])){
	$let = $_REQUEST['let'];
	$tip = $_REQUEST['tip'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccionar Rubro Mayor</title>
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

#detallerubm{
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

$("#rub").css("border-color", "transparent");
$("#sec").css("border-color", "transparent");
$("#opeinv").css("border-color", "transparent");

function movpag_a_novrubm(p){
	np = p - 1;
	document.getElementById("capa_novrubm"+np).style.display="block";
	document.getElementById("capa_novrubm"+p).style.display="none";
	return false;
}

function movpag_b_novrubm(p){
	np = p + 1;	
	document.getElementById("capa_novrubm"+np).style.display="block";
	document.getElementById("capa_novrubm"+p).style.display="none";
	return false;
}

function envia_tip(id,des){

	document.getElementById('rubrom').value = des;
	document.getElementById('rubromid').value = id;

	document.getElementById("fondopiderubm").style.display = "none";
	document.getElementById("descpiderubm").style.display = "none";
	document.getElementById("fondorubm").style.display = "none";
	document.getElementById('botbus').style.display = "none";
	
	document.getElementById("rubmbus").value = 0;	
	
	document.getElementById("LetTex").value = "";
	document.getElementById("DondeE").value = "rubroid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#rub").css("border-color", "#F90");
	$("#rubmay").css("border-color", "transparent");
	
	EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';

}

// PRESIONA EL BOTON SI ESTA SELECCIONADO TODOS LOS RUBROS
var id = document.getElementById('rubromid').value;
if(id == 0){
	SoloBlock("BotSelTodOff");
	SoloNone("BotSelTodOn");
}


</script>
</head>
<body>


<div id="detallerubm">
<?php
if($let == ''){
	$SQL = "SELECT * FROM RUBMAY WHERE CodRub not in(0) ORDER BY CodRub asc";
}else{
	if($tip == 2){
		$SQL = "SELECT * FROM RUBMAY WHERE NomRub LIKE '".$let."%' AND CodRub not in(0)";
	}else{
		$SQL = "SELECT * FROM RUBMAY WHERE NomRub LIKE '%".$let."%' AND CodRub not in(0)";
	}
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
		echo "<div id=\"capa_novrubm".$s."\" style=\"display:".$e."\">";
		if($s <> 1){
			?>
    	    <div id="Anterior_Rubm<?php echo $s; ?>" style="position:absolute; top:0px; left:235px;">
			<button class="StyBoton" onClick="return movpag_a_novrubm(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Rubm<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Rubm<?php echo $s; ?>"/></button>
			</div>
			<?
		}
	}
	?>
    <div style="cursor:pointer;" onClick="envia_tip(<? echo $ID; ?>,'<? echo trim($DES); ?>');">
	<table width="231px" cellpadding="0" cellspacing="1">
        <tr> 
        	<td class="fon_sec" width="29"><div >&nbsp;&nbsp;&nbsp;&nbsp;<? echo str_pad($ID, 3, "0", STR_PAD_LEFT); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $DES; ?></div></td>	
        </tr>
	</table>  
    </div>
	<?
	$t = $c;
	if ($c == 7){
		?>
        <div id="Siguiente_Rubm<?php echo $s; ?>" style="position:absolute; top:100px; left:235px;">
        <button class="StyBoton" onClick="return movpag_b_novrubm(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Rubm<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Rubm<?php echo $s; ?>"/></button>
        </div>
        </div>
		<?php
		$c = 0; 
        $s = $s + 1;  
	}
}
if($t == 7){
	?>
	<script>
		SoloNone("Siguiente_Rubm<?php echo $s-1; ?>");
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