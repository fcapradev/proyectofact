<?
require("config/cnx.php");
/////////////////////////////// COMPRAS


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//SESSION - REQUEST
if(isset($_REQUEST['ord'])){
	$_SESSION['ORD'] = $_REQUEST['ord'];
}
if(isset($_REQUEST['tor'])){
	$_SESSION['TOR'] = $_REQUEST['tor'];
}
if(isset($_REQUEST['abc'])){
	$_SESSION['ABC'] = $_REQUEST['abc'];
}
/////////////////////////////////////////////////////////////////////////
if(isset($_REQUEST['lik'])){
	$_SESSION['LIK'] = $_REQUEST['lik'];
}else{
	$_SESSION['LIK'] = "";
}
/////////////////////////////////////////////////////////////////////////
if($_SESSION['TOR'] == 1){
	$_SESSION['TOR'] = "ASC";
}
if($_SESSION['TOR'] == 2){
	$_SESSION['TOR'] = "DESC";
}
if($_SESSION['ABC'] == 1){
	$_SESSION['ABC'] = " ";
}
if($_SESSION['ABC'] == 2){
	$_SESSION['ABC'] = " AND FPA = 2 ";
}
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////

$_SESSION['LIK'] = str_replace("*","-",$_SESSION['LIK']);

/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
if($_SESSION['ORD'] == 1){
	$_SESSION['LIK'] = " AND NOM LIKE '%".$_SESSION['LIK']."%' ";
}
if($_SESSION['ORD'] == 2){
	$_SESSION['LIK'] = " AND DOM LIKE '%".$_SESSION['LIK']."%' ";
}
if($_SESSION['ORD'] == 3){
	$_SESSION['LIK'] = " AND CUIT LIKE '%".$_SESSION['LIK']."%' ";
}
if($_SESSION['ORD'] == 4){
	$_SESSION['LIK'] = " AND CON LIKE '%".$_SESSION['LIK']."%' ";
}
/////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
<script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/javascript" src="../PRUEBA/Ejemplos/busquedarapida.js"></script> 
-->
<title>ComboPro</title>
<style>

.CadaComboCom{ 
	background:url(producto/Bus_Item.png);
	background-repeat:repeat-x; 
	text-align:center;
	font-family: "TPro"; 
	font-size:12px;
	cursor:pointer;
	color:#FFF;
	height:28px;
}

.lineaProve:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0;
	-webkit-box-shadow:0px 1px 0;
}

.TituloComPro{
	font-weight:bold;
	font-size:16px;
	color:#FFF; 
	height:28px; 
}

#Anterior_Com{ 
	position:absolute; 
	left:617px; 
	top:-4px;
}

#Siguiente_Com{
	position:absolute; 
	left:617px; 
	top:147px;
}

</style>

<script>

document.getElementById("DondeE").value = "LetTex";
document.getElementById("CantiE").value = "50";
document.getElementById("QuePoE").value = "0";

controlarcadainputcom("LetTex");

$("#LetAre").addClass("Sombra8");

SoloBlock("NumVol");

document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolCompras();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';


function IncProvee(id,pro,fpa,tip){
	
	var cod = str_pad(id, 5, '0', 'STR_PAD_LEFT');	
	document.getElementById("EDat3").value = cod;
	document.getElementById("EDat4").value = pro;
	document.getElementById('EncLatI-2').value = cod;
	document.getElementById("EDat5").value = fpa;
	document.getElementById("EDat7_2_T").value = tip;
	
	SoloNone('EncabezadoLat, EncabezadoDLat, Proveedores, ProveedoresDat');
	SoloBlock('ComprasDfon, Encabezado, EncabezadoDat, ComBotEncDiv');
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosFpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	SoloBlock('NumVol, LetTer');
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="listadocomcom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConsul\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConsul"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolProv()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';

	document.getElementById('LetTex').value = "";

	controlarcadainputcom("EDat5");

	$("#EncDat3").css("border-color", "transparent");
	$("#EncDat5").css("border-color", "#F90");

	EnvAyuda('Ingrese forma de pago. Enter para buscar.');
	
	document.getElementById("DondeE").value = "EDat5";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";
	
}

function movpaga_com(p){

	np = p - 1;
	document.getElementById('capa_com'+p).style.display="none";	
	document.getElementById('capa_com'+np).style.display="block";

}

function movpag_com(p){

	np = p + 1;
	document.getElementById('capa_com'+p).style.display="none";	
	document.getElementById('capa_com'+np).style.display="block";

}

function EnvProvee(){

	var lik = document.getElementById('LetTex').value;
	if(lik != 0){
		if(lik.length != 0){
			document.getElementById('LetTex').value = "";
			lik = ReplaceAll(lik," ","+");
			$("#ComDatos").load("CombPro.php?lik="+lik);
		}
	}
}

document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="EnvProvee();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

/*
$(function(){
	$('input#id_search').quicksearch('table#table_example tbody tr');
});
*/
</script>

</head>
<body>

<!--
		<form action="#"> 
			<fieldset> 
				<input type="text" name="search" value="" id="id_search" placeholder="Search" autofocus style="position:absolute; top:-54px; left:10px;"> 
			</fieldset> 
		</form> 
-->
<div style="position:absolute; top:0px; left:0px; ">

<?

	if($_SESSION['ORD'] == 1){
		$_SESSION['ParSQL'] = "SELECT COD, NOM, DOM, TIP, FPA, CUIT  FROM PROVEED WHERE COD <> 0 ".$_SESSION['ABC']."".$_SESSION['LIK']." ORDER BY NOM ".$_SESSION['TOR']."";
		$XA = 0;
	}

	if($_SESSION['ORD'] == 2){
		$_SESSION['ParSQL'] = "SELECT COD, NOM, DOM, TIP, FPA, CUIT  FROM PROVEED WHERE COD <> 0 ".$_SESSION['ABC']."".$_SESSION['LIK']." ORDER BY DOM ".$_SESSION['TOR']."";
		$XA = 0;
	}
	if($_SESSION['ORD'] == 3){
		$_SESSION['ParSQL'] = "SELECT COD, NOM, DOM, TIP, FPA, CUIT  FROM PROVEED WHERE COD <> 0 ".$_SESSION['ABC']."".$_SESSION['LIK']." ORDER BY CUIT ".$_SESSION['TOR']."";
		$XA = 0;
	}
	if($_SESSION['ORD'] == 4){
		$_SESSION['ParSQL'] = "SELECT COD, CON, NOM, DOM, TIP, FPA, CUIT  FROM PROVEED WHERE COD <> 0 ".$_SESSION['ABC']."".$_SESSION['LIK']." ORDER BY CON ".$_SESSION['TOR']."";
		$XA = 1;
	}
	$_SESSION['LIK'] = "";
	
	$PROVEED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($PROVEED);
	
	$c = 0;
	$cc = 0;
	$s = 1;
	
	while ($reg=mssql_fetch_array($PROVEED)){
		
	$COD = $reg['COD'];
	$NOM = trim(htmlentities($reg['NOM']));
	
	if(strlen($NOM) == 0 or strlen($NOM) == 1){ $NOM = "SIN NOMBRE"; }
	
	if($XA == 1){
		$NOMM = htmlentities($reg['CON']);
		if(strlen($NOMM) == 0 or strlen($NOMM) == 1){ $NOMM = "SIN ALIAS"; }
	}else{
		$NOMM = htmlentities($reg['NOM']);
		if(strlen($NOMM) == 0 or strlen($NOMM) == 1){ $NOMM = "SIN NOMBRE"; }
	}
	
	$DOM = trim(htmlentities($reg['DOM']));
	
	if(strlen($DOM) == 0 or strlen($DOM) == 0){ $DOM = "SIN DIRECCION"; }
	
	$TIP = $reg['TIP'];
	$FPA = $reg['FPA'];
	$CUI = $reg['CUIT'];

		$c = $c + 1;
		$cc = $cc + 1;

		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"capa_com".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
				<div id="Anterior_Com">
					<button class="StyBoton" onClick="movpaga_com(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
				</div>
				<?
			}

		}
	
		?>
		<div class="lineaProve" onClick="IncProvee(<? echo $COD; ?>, '<? echo $NOM; ?>',<? echo $FPA; ?>,'<? echo $TIP; ?>')">
        <table id="table_example" width="621" cellpadding="0" cellspacing="1" align="center">
        	<tbody>
            <tr>
                <td class="CadaComboCom" width="55" ><div><? echo format($COD,5,'0',STR_PAD_LEFT); ?></div></td>
                <td class="CadaComboCom" width="183"><div align="left"><? echo substr($NOMM,0,25); ?></div></td>
                <td class="CadaComboCom" width="183"><div align="left"><? echo substr($DOM,0,25); ?></div></td>
                <td class="CadaComboCom" width="50" ><div><? echo $TIP; ?></div></td>                
                <td class="CadaComboCom" width="50" ><div><? echo $FPA; ?></div></td>
                <td class="CadaComboCom" width="100"><div><? echo $CUI; ?></div></td>
            </tr>
            </tbody>
        </table>
		</div>
		<?
	
		if ($c == 6){
	
			?>
			
			<div id="Siguiente_Com">
				<button class="StyBoton" onClick="movpag_com(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
			</div>

			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	}
	
	mssql_close($conexion);
	
	if ($cc == 6){
		?>
		<script>
			$("#Siguiente_Com").fadeOut('fast');
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


mssql_free_result($PROVEED);

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}