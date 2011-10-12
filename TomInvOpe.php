<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['ope'])){

	$ope = $_REQUEST['ope'];

	$_SESSION['ParSQL'] = "SELECT CodVen FROM vendedores WHERE CodVen not in(0) AND CodVen = ".$ope.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	if(mssql_num_rows($R1TB) == 0){	
		?>
		<script>
			jAlert('El Operario ingresado no existe.', 'Debo Retail - Global Business Solution');
			document.getElementById('opeinventario').value = "";
		
			document.getElementById("DondeE").value = "opeinventario";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";

			EnvAyuda("Ingrese un Operario o Presione Enter para listar");

			document.getElementById('LetEnt').innerHTML = '<button onclick="inv_colector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
		</script>    
		<?
		exit;
	}

	while ($reg=mssql_fetch_array($R1TB)){
		$ID = $reg['CodVen'];
	}
	?>
    <script>

		document.getElementById('opeinventario').value = "<? echo $ID; ?>";

		$("#sectores").css("border-color", "#F90");
		$("#opeinv").css("border-color", "transparent");

		SoloNone("BotSelTodRubOn");
		SoloBlock("BotSelTodRubOff");
		
	</script>
	<?
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
<title>Seleccionar un Operario</title>
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

</style>
<script language="javascript" type="text/javascript">

$("#sec").css("border-color", "transparent");
$("#rubmay").css("border-color", "transparent");
$("#rub").css("border-color", "transparent");

function movpag_a_novope(p){
	
	np = p - 1;
	document.getElementById("capa_novope"+np).style.display="block";
	document.getElementById("capa_novope"+p).style.display="none";

return false;
}

function movpag_b_novope(p){

	np = p + 1;	
	document.getElementById("capa_novope"+np).style.display="block";
	document.getElementById("capa_novope"+p).style.display="none";
	
return false;
}

function envia_ope(id){

	document.getElementById('opeinventario').value = id;
	document.getElementById("fondopideope").style.display = "none";
	document.getElementById("descpideope").style.display = "none";
	document.getElementById("fondoope").style.display = "none";
	
	document.getElementById("DondeE").value = "sectorid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#sectores").css("border-color", "#F90");
	$("#opeinv").css("border-color", "transparent");

	EnvAyuda("Ingrese un Sector o Presione Enter para listar");

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv0();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
	
}

</script>

</head>
<body>
<div id="detalletipos">


<?php
if($let == ''){
	$SQL = "SELECT CodVen,NomVen FROM vendedores WHERE CodVen not in(0)";
}else{
	if($tip == 2){
		$SQL = "SELECT CodVen,NomVen FROM vendedores WHERE NomVen LIKE '".$let."%' AND CodVen not in(0)";
	}else{
		$SQL = "SELECT CodVen,NomVen FROM vendedores WHERE NomVen LIKE '%".$let."%' AND CodVen not in(0)";
	}
}


//$SQL = "SELECT CodVen,NomVen FROM vendedores WHERE CodVen not in(0)";
$PARATIPOS = mssql_query($SQL) or die("Error SQL");
rollback($PARATIPOS);

$c = 0;
$cc = 0;
$s = 1;
$t=0;
while ($reg=mssql_fetch_array($PARATIPOS)){

$ID = $reg['CodVen'];
$DES = $reg['NomVen'];

if($ID == -1){ $ID = 0; }
	$c = $c + 1;
	$cc = $cc + 1;
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_novope".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
    	    <div id="Anterior_Ope" style="position:absolute; top:0px; left:235px;">
			<button class="StyBoton" onClick="return movpag_a_novope(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Ope<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Ope<?php echo $s; ?>"/></button>
			</div>
			<?
		}
	}
	?>
    <div style="cursor:pointer;" onClick="envia_ope(<? echo $ID; ?>);">
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
        <div id="Siguiente_Ope<?php echo $s; ?>" style="position:absolute; top:100px; left:235px;">
        <button class="StyBoton" onClick="return  movpag_b_novope(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Ope<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Ope<?php echo $s; ?>"/></button>
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
		SoloNone("Siguiente_Ope<?php echo $s-1; ?>");
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