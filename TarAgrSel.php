<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


$se = $_REQUEST['se'];


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


if(isset($_REQUEST['tar'])){

	$num_tar = $_REQUEST['tar'];

	$_SESSION['ParSQL'] = "SELECT * FROM ATARJETAS WHERE ID = ".$num_tar.""; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	if(mssql_num_rows($R1TB) == 0){	
		?>
		<script>
		
			jAlert('El n&uacute;mero de Tarjeta no existe.', 'Debo Retail - Global Business Solution');
		
			document.getElementById('<? echo $se; ?>idtarjeta').value = "";
			document.getElementById('<? echo $se; ?>tipotar').value = "< BUSCAR UNA TARJETA >";
			
			$("#<? echo $se; ?>suc").css("border-color", "transparent");
			$("#<? echo $se; ?>idtar").css("border-color", "#F90");
			
		</script>    
		<?
		exit;
	}

	while ($reg=mssql_fetch_array($R1TB)){
		$NOMBRE=$reg['NOM'];
		$ID=$reg['ID'];
		$PAU=$reg['PAU'];
	}
	
	if($PAU == 'N'){
	?>
    <script>
		document.getElementById('<? echo $se; ?>tipo').value = "MANUAL";
	</script>
    <?
	}else{
	?>
    <script>
		document.getElementById('<? echo $se; ?>tipo').value = "AUTOMATICA";	
	</script>
    <?
	}
	?>
    <script>
	
		document.getElementById('<? echo $se; ?>tipotar').value = "<? echo $NOMBRE; ?>";
		document.getElementById('<? echo $se; ?>idtipotar').value = "<? echo $ID; ?>";
		
		$('#<? echo $se; ?>tipoTAR').removeAttr('onclick');
		
		EnvAyuda("Ingrese el n&uacute;mero de Sucursal o Enter para Continuar.");

		document.getElementById("DondeE").value = "<? echo $se; ?>sucursal";
		document.getElementById("CantiE").value = "4";
		document.getElementById("QuePoE").value = "1";

		document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

		document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';
		
		$('#<? echo $se; ?>sucursal').focus();
		
		controlarcadainput('<? echo $se; ?>sucursal');

	</script>
	<?


}else{

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seleccion Tarjetas</title>
<style>

#<? echo $se; ?>detalletipostar{
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

.tarlineare1{
	background-image:url(RetiroCaja/FonDef.png);
	background-repeat:repeat-x;
	cursor:pointer; 
	font-family: "TPro";
	height:28px;
}

.tarlineare2{
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
						$('#<? echo $se; ?>litatar'+contador).removeClass("tarlineare2").addClass("tarlineare1");
					}	
					
				}
				
				contador = contador - 1;
				contador_cappp = contador_cappp - 1;
			}

			if(document.getElementById('<? echo $se; ?>litatar'+contador).className == 'tarlineare1'){
				$('#<? echo $se; ?>litatar'+contador).removeClass("tarlineare1").addClass("tarlineare2");
			}
			
			if(contador_cappp == -1){
				if(contador_capss != 0){
					contador_cappp = 5;
					movpag_a_tarsel(contador_capss);
					contador_capss = contador_capss - 1;
				}
			}
		
		}
		if(window.event.keyCode == 40){
						
			if(contador < contador_total || contador == 0){

				for (i=1; i<=contador_total; i++){
				
					if(i != contador){
						$('#<? echo $se; ?>litatar'+contador).removeClass("tarlineare2").addClass("tarlineare1");
					}	
					
				}

				contador = contador + 1;
				contador_cappp = contador_cappp + 1;

				if(document.getElementById('<? echo $se; ?>litatar'+contador).className == 'tarlineare1'){
					$('#<? echo $se; ?>litatar'+contador).removeClass("tarlineare1").addClass("tarlineare2");
				}

				if(contador_cappp == 6){
					if(contador_capss != 0){
						contador_cappp = 0;
						movpag_b_tarsel(contador_capss);
						contador_capss = contador_capss + 1;
					}
				}
			
			}
						
		}
		
		if(document.getElementById("<? echo $se; ?>descpidetipotar").style.display == "block"){	
			if(window.event.keyCode == 13){
				if(contador != 0){
					document.getElementById('<? echo $se; ?>litatar'+contador).onclick();
					return false;					
				}
			}
		}
		
	}
	
}

function movpag_a_tarsel(p){

	np = p - 1;
	document.getElementById("capa_tarsel"+np).style.display="block";
	document.getElementById("capa_tarsel"+p).style.display="none";

return false;
}

function movpag_b_tarsel(p){

	np = p + 1;	
	document.getElementById("capa_tarsel"+np).style.display="block";
	document.getElementById("capa_tarsel"+p).style.display="none";
	
return false;
}

function <? echo $se; ?>envia_tar(id,des,pau){
	
	if(pau == 'N'){
		document.getElementById('<? echo $se; ?>tipo').value = "MANUAL";
	}else{
		document.getElementById('<? echo $se; ?>tipo').value = "AUTOMATICA";
	}
	
	$("#<? echo $se; ?>idtar").css("border-color", "transparent");
	$("#<? echo $se; ?>suc").css("border-color", "#F90");
	
	document.getElementById('<? echo $se; ?>tipotar').value = des;
	document.getElementById('<? echo $se; ?>idtipotar').value = id;
	document.getElementById('<? echo $se; ?>idtarjeta').value = id;
	
	SoloNone("<? echo $se; ?>fondodesctar, <? echo $se; ?>fondodesctarimg, <? echo $se; ?>descpidetipotar");

	$('#<? echo $se; ?>tipotar').removeAttr('onclick');

	EnvAyuda("Ingrese el n&uacute;mero de Sucursal o Enter para Continuar.");

	document.getElementById("DondeE").value = "<? echo $se; ?>sucursal";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="<? echo $se; ?>siguiente_tar4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetEntTar\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="<? echo $se; ?>LetEntTar"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="<? echo $se; ?>volver_tar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'<? echo $se; ?>LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="<? echo $se; ?>LetVolChe"/></button>';

	$('#<? echo $se; ?>sucursal').focus();

	controlarcadainput('<? echo $se; ?>sucursal');

	document.getElementById("<? echo $se; ?>descpidetipotar").innerHTML = "";

}

</script>

</head>
<body>


<table width="292" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table height="50">
	<tr>
		<td align="center">
			<div align="center" style="top:10px; left:3px; position:absolute;">
				<img src="ArqueoCaja/fondo gris.png" /> 
                <div style="position:absolute; top:-3px; left:0px; font-family:'TPro'; font-size:14px; color:#FFFFFF; font-weight:bold; width:136px;">
                    TARJETAS
                </div>
			</div>
		</td>
	</tr>
	</table>
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

<div style="top:45px; left:10px; position:absolute;">
<?php
	
$_SESSION['ParSQL'] = "SELECT * FROM ATARJETAS";
$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);
if(mssql_num_rows($R1TB) == 0){	
	?>
	<script>
		alert("No hay tipos en este momento.");
	</script>    
	<?
	exit;
}else{

	$total = mssql_num_rows($R1TB);
	
}

$c = 0;
$cc = 0;
$s = 1;

while ($reg=mssql_fetch_array($R1TB)){
	
	$NOMBRE=$reg['NOM'];
	$ID=$reg['ID'];
	$PAU=$reg['PAU'];

if($ID == -1){ $ID = 0; }


	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_tarsel".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){

			?>
        
    	    <div id="Anterior_SigC" style="	position:absolute; top:-2px; left:280px;">
			
			<button class="StyBoton" onClick="return movpag_a_tarsel(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_SigC<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_SigC<?php echo $s; ?>"/></button>
			
			</div>

			<?
		}

	}
	
	?>
	<div id="<? echo $se; ?>litatar<? echo $cc; ?>" class="tarlineare1" onClick="<? echo $se; ?>envia_tar(<? echo $ID; ?>,'<? echo trim($NOMBRE); ?>', '<? echo $PAU; ?>');" >
	<table width="283px" cellpadding="0" cellspacing="1" style="cursor:pointer;">
        <tr> 
        	<td style="font-family:'TPro'; font-size:14px; color:#FFF; font-weight:bold;" width="31"><div align="center"><? echo $ID; ?></div></td>	
            <td style="font-family:'TPro'; font-size:14px; color:#FFF; font-weight:bold;" width="264">&nbsp;&nbsp;&nbsp;<? echo $NOMBRE; ?></td>
        </tr>
	</table>  
    </div>
	
	<?
	$t = $c;
	if ($c == 5){
		?>
        
        <div id="Siguiente_SigC<?php echo $s; ?>" style="position:absolute; top:109px; left:280px;">
	        <button class="StyBoton" onClick="return  movpag_b_tarsel(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_SigC<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_SigC<?php echo $s; ?>"/></button>
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
		SoloNone("Siguiente_SigC<?php echo $s-1; ?>");
    </script>
	<?
}


?>

</div>
	<script>
		contador_total = <?=$total?>;
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