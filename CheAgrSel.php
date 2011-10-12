<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


$se = $_REQUEST['se'];


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['ban'])){

	$num_banco = $_REQUEST['ban'];

	$_SESSION['ParSQL'] = "SELECT id,desbco FROM BANCOS WHERE ID = ".$num_banco.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	
	if(mssql_num_rows($R1TB) == 0){	
		?>
		<script>		
			jAlert('El n&uacute;mero de Banco no existe.', 'Debo Retail - Global Business Solution');
			document.getElementById('<? echo $se; ?>banco').value = "";
			document.getElementById('<? echo $se; ?>tipoban').value = "< ELEGIR UN BANCO >";
		</script>    
		<?
		exit;
	}

	while ($reg=mssql_fetch_array($R1TB)){
		$NOMBRE = $reg['desbco'];
		$ID = $reg['id'];
	}
	?>
    <script>
		
		document.getElementById('<? echo $se; ?>tipoban').value = "<? echo trim(htmlentities($NOMBRE)); ?>";
		document.getElementById('<? echo $se; ?>idtipoban').value = "<? echo $ID; ?>";
		
		$("#<? echo $se; ?>numche").css("border-color", "#0FF");
		$("#<? echo $se; ?>ban").css("border-color", "transparent");
		
		EnvAyuda("Ingrese el N&uacute;mero del cheque");

		$('#<? echo $se; ?>tipoban').removeAttr('onclick');
		
		document.getElementById("DondeE").value = "<? echo $se; ?>numcheque";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "6";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_che2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';
		
		document.getElementById("NumVol").innerHTML = '<button onclick="<? echo $se; ?>volver_che2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>numcheque').focus();
		
		controlarcadainputche('<? echo $se; ?>numcheque');
		
	</script>
	<?
	
}else{

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccion de Bancos y Provincias</title>
<style>

#<? echo $se; ?>detalletiposche{
	position: absolute;
	width: 700px;
	height: 237px;
	left: -60px;
	top: -278px;
}

.fon_itmChe{ 
	background-image:url(producto/Bus_Item.png); 
	height:22px;
}

.chelineare1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro";
	height:28px;
}

.chelineare2{
	background-image:url(RetiroCaja/FonSel.png); 
	background-repeat:repeat-x;
	cursor:pointer;
	font-family: "TPro";
	height:28px;
}

</style>
<script language="javascript" type="text/javascript">

var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

document.onkeydown = function(){

	if(window.event){

		if(window.event.keyCode == 38){
			
			var concontador = contador - 1;
			
			if(concontador <= 0){ 
				return false; 
			}else{
				
				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#<? echo $se; ?>litache'+contador).removeClass("chelineare2").addClass("chelineare1");
					}	
					
				}
				
				contador = contador - 1;
				contador_cappp = contador_cappp - 1;
			}

			if(document.getElementById('<? echo $se; ?>litache'+contador).className == 'chelineare1'){
				$('#<? echo $se; ?>litache'+contador).removeClass("chelineare1").addClass("chelineare2");
			}

			if(contador_cappp == 0){
				if(contador_capss > 0){
					contador_cappp = 5;
					movpag_a_chesel(contador_capss);
					contador_capss = contador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){

			if(contador < contador_total || contador == 0){
				
				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#<? echo $se; ?>litache'+contador).removeClass("chelineare2").addClass("chelineare1");
					}	
					
				}

				contador = contador + 1;
				contador_cappp = contador_cappp + 1;
				
				if(document.getElementById('<? echo $se; ?>litache'+contador).className == 'chelineare1'){
					$('#<? echo $se; ?>litache'+contador).removeClass("chelineare1").addClass("chelineare2");
				}
				
				if(contador_cappp == 6){ 
					if(contador_capss != 0){
						contador_cappp = 1;
						movpag_b_chesel(contador_capss);
						contador_capss = contador_capss + 1;
					}
				}
			
			}
						
		}
		
		if(document.getElementById("<? echo $se; ?>descpidetipoban").style.display == "block"){	
			if(window.event.keyCode == 13){
				if(contador != 0){
					document.getElementById('<? echo $se; ?>litache'+contador).onclick();
					return false;					
				}
			}
		}
		
	}
	
}

function movpag_a_chesel(p){
	
	np = p - 1;
	document.getElementById("capa_chesel"+np).style.display="block";
	document.getElementById("capa_chesel"+p).style.display="none";

return false;
}

function movpag_b_chesel(p){

	np = p + 1;	
	document.getElementById("capa_chesel"+np).style.display="block";
	document.getElementById("capa_chesel"+p).style.display="none";
	
return false;
}

function <? echo $se; ?>envia_ban(id,des){
	
	document.getElementById('<? echo $se; ?>tipoban').value = des;
	document.getElementById('<? echo $se; ?>banco').value = id;
	document.getElementById('<? echo $se; ?>idtipoban').value = id;
	
	SoloNone("<? echo $se; ?>fondodescban, <? echo $se; ?>fondodescbanimg, <? echo $se; ?>descpidetipoban");
	
	$("#<? echo $se; ?>numche").css("border-color", "#0FF");
	$("#<? echo $se; ?>ban").css("border-color", "transparent");

	EnvAyuda("Ingrese el N&uacute;mero del cheque");

	$('#<? echo $se; ?>tipoban').removeAttr('onclick');

	document.getElementById("DondeE").value = "<? echo $se; ?>numcheque";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "6";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>siguiente_che2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntChe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntChe"/></button>';

	document.getElementById("NumVol").innerHTML = '<button class="StyBoton" onclick="<? echo $se; ?>volver_che2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';

	$('#<? echo $se; ?>numcheque').focus();

	controlarcadainputche('<? echo $se; ?>numcheque');
	
}

</script>

</head>
<body>

<table width="292" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table>
	<tr>
	<td align="center">
        <div align="center" style="top:10px; left:3px; position:absolute;">
            <img src="ArqueoCaja/fondo gris.png" /> 
            <div style="position:absolute; top:-3px; left:0px; font-family:'TPro'; font-size:14px; color:#<? echo $se; ?>FFFFFF; font-weight:bold; width:136px;">
                BANCOS
            </div>
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

<div style="top:35px; left:0px; position:absolute;">
<?php
	
$_SESSION['ParSQL'] = "SELECT ID,desbco FROM BANCOS ORDER BY ID";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);

$total = mssql_num_rows($R1TB);

$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($R1TB)){

	$ID = $reg['ID'];
	$NOMBRE = $reg['desbco'];

if($ID == -1){ $ID = 0; }

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_chesel".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){

			?>
        
    	    <div id="<? echo $se; ?>Anterior_SigC" style="	position:absolute; top:-2px; left:290px;">
			
			<button class="StyBoton" onClick="return movpag_a_chesel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_SigC<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="<? echo $se; ?>Anterior_SigC<?php echo $s; ?>"/></button>
			
			</div>

			<?
		}

	}
	
	?>
	<div id="<? echo $se; ?>litache<? echo $cc; ?>" class="chelineare1" onClick="<? echo $se; ?>envia_ban(<? echo $ID; ?>,'<? echo trim($NOMBRE); ?>');">
	<table width="293px" cellpadding="0" cellspacing="1" style="cursor:pointer;">
        <tr> 
        	<td style="font-family:'TPro'; font-size:14px;" width="31"><div align="center"><? echo $ID; ?></div></td>	
            <td style="font-family:'TPro'; font-size:14px;" width="264">&nbsp;&nbsp;&nbsp;<? echo $NOMBRE; ?></td>
        </tr>
	</table>  
    </div>
	<?
	
	$t = $c;
	if ($c == 5){
		
		?>
        <div id="<? echo $se; ?>Siguiente_SigC<?php echo $s; ?>" style="position:absolute; top:108px; left:290px;">
	        <button class="StyBoton" onClick="return  movpag_b_chesel(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_SigC<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="<? echo $se; ?>Siguiente_SigC<?php echo $s; ?>"/></button>
        </div>
        </div>
        
		<?php
    	  
		$c = 0; 
        $s = $s + 1;  
		
	}

}

if ($t == 5){
	?>
	<script>
		SoloNone("<? echo $se; ?>Siguiente_SigC<?php echo $s-1; ?>");
    </script>
	<?
}


?>
</div>
	<script>
		contador_total = <?=$total?>
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