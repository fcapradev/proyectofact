<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";	//NOMBRE DE LA EMPRESA
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];
}

//**	HACE UN UPDATE A DONDE DEBERÍA APUNTAR EL COLECTOR DE DATOS		**//
$_SESSION['ParSQL'] = "UPDATE COMMAND SET RUTA_COLECTOR_DATOS = '".getcwd()."/Colector/'";
$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($COMMAND);		

$_SESSION['ParSQL'] = "SELECT RUTA_COLECTOR_DATOS FROM COMMAND";
$COMMAND = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($COMMAND);		
while ($RCOM=mssql_fetch_array($COMMAND)){
	$sRutaPalm = $RCOM['RUTA_COLECTOR_DATOS'];
}

$sRutaPalm = $sRutaPalm.$numEmp; 
if(!is_dir($sRutaPalm)){ 
	@mkdir($sRutaPalm, 0700); //crea carpeta con nombre de la empresa
}  

$fin=substr($sRutaPalm,strlen($sRutaPalm)-2);
if ($fin <> '\\') {
	$dir = $sRutaPalm."\\";
	$sRutaPalm = $sRutaPalm."\\";
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Selecciona el Inventario por Colector</title>
<style>
#Anterior{
	position:absolute;
	top:40px;
	left:430px;
}
#detalletiposCDsel{
	position:absolute;
	top:2px;
	left:1px;
	z-index:3;
	font-size:12px;
	color:#FFF;
	display:block;
}
</style>

<script>
function movpag_a_invcd(p){
	np = p - 1;
	document.getElementById("capa_invsel"+np).style.display="block";
	document.getElementById("capa_invsel"+p).style.display="none";
	return false;
}

function movpag_b_invcd(p){
	np = p + 1;	
	document.getElementById("capa_invsel"+np).style.display="block";
	document.getElementById("capa_invsel"+p).style.display="none";
	return false;
}

function carga_inv(inv){

	SoloNone("importar_car, cruz, fondocolector, fondopidecol, descpideinv");

	$("#archivos").load("CarInvLisCD.php?i="+inv+"");
	
	EnvAyuda("Preparado para imprimir");
	
	document.getElementById("DondeE").value = "";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq6"/></button>';

}

</script>

</head>
<body>
<div id="detalletiposCDsel">
<table width="450" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="middle">
            <table>
                <tr>
                    <td width="100">
                        <div align="center">
                            <img src="InventarioCarga/inventarios disponibles.png" /> 
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

<?php
//******	BUSCA TODAS LAS CARPETAS DE LA MISMA EMPRESA ******//
$nomdir = format($numEmp,4,'0',STR_PAD_LEFT);
$archivo_buscar = $nomdir;
$t= 0;
if(is_dir($dir)){
	$c = 0;
	$cc = 0;
	$s = 1;
	$d=opendir($dir);
while($archivo = readdir($d)){				//	Lista el directorio y si la carpeta empieza con el nombre de la empresa, la lista
	if($archivo!="." AND $archivo!=".."){
		if(is_dir($dir.'/'.$archivo)){ 
			$exclude_array = explode("_", $archivo);
			if($exclude_array[0] == $archivo_buscar){
				$RealizadoPorPalm = true;
				$inv = (int)$exclude_array[1];
			$c = $c + 1;
			$cc = $cc + 1;
			if($c == 1){
				if($s == 1){
					$e = "block";
				}else{
					$e = "none";
				}
				echo "<div id=\"capa_invsel".$s."\" style=\"display:".$e."\">";
				if($s <> 1){
				?>
				<div id="Anterior">
					<button class="StyBoton" onClick="return movpag_a_invcd(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Inv<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Inv<?php echo $s; ?>"/></button>
				</div>
				<?
				}
			}
			?>
			<div style="cursor:pointer;" >
			<table width="435px" cellpadding="0" cellspacing="1" onclick="carga_inv(<? echo $inv; ?>);">
				<tr>
                
					<td class="fon_itm" style="font-family:'TPro'; font-size:12px;" width="29"><div align="center"><? echo $cc; ?></div></td>	
					<td class="fon_itm" style="font-family:'TPro'; font-size:12px;" width="116">&nbsp;EMPRESA Nº:&nbsp;&nbsp;<? echo $exclude_array[0]; ?></td>
					<td class="fon_itm" style="font-family:'TPro'; font-size:12px;" width="284">&nbsp;INVENTARIO Nº:&nbsp;&nbsp;<? echo $inv; ?></td>
                    
				</tr>
			</table>  
			</div>
			<?
			$t = $c;
			if($c == 8){
				?>
				<div id="Siguiente_InvSel" style="position:absolute; top:230px; left:430px;">
					<button class="StyBoton" onClick="return movpag_b_invcd(<?php echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_InvSel<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_InvSel<?php echo $s; ?>"/></button>
				</div>
				</div>
				<?php
				$c = 0;
				$s = $s + 1;
			}
				}	
			}	
		}
	}                   
	if ($t == 8){
		?>
		<script>
			SoloNone("Siguiente_InvSel<?php echo $s-1; ?>");
		</script>
		<?
	}   
}
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