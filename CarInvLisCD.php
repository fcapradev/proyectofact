<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$orden = 1;
if(isset($_REQUEST['i'])){
	$num_inv = $_REQUEST['i'];
}

$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVC WHERE ID = ".$num_inv."";
$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ITOMINVC);
$est = "";
while ($RINV=mssql_fetch_array($ITOMINVC)){
			$est = $RINV['EST'];
}
if($est == "F"){
	?>		
	<script>
	jAlert('El Inventario N\xba: <? echo $num_inv; ?> esta marcado como FALLIDO.', 'Debo Retail - Global Business Solution');
	$("#CargaInv").load("CargaInv.php");
	</script>
	<?	
	exit();
}
//****************************************

$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];
}
//**	HACE UN UPDATE A DONDE DEBERÍA APUNTAR EL COLECTOR DE DATOS		**//
$_SESSION['ParSQL'] = "UPDATE COMMAND SET RUTA_COLECTOR_DATOS = '".getcwd()."\Colector\'";
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
	$sRutaPalm = $sRutaPalm."\\";
}
//****	BUSCA EN LA CARPETA CORRESPONDIENTE LOS ARCHIVOS	****//
$nomdir = format($numEmp,4,'0',STR_PAD_LEFT)."_".format($num_inv,4,'0',STR_PAD_LEFT);
$sRutaPalm = $sRutaPalm.$nomdir;


//** VERIFICO SI EXISTEN ARCHIVOS DEL INVENTARIO SELECCIONADO

if(!file_exists($sRutaPalm."\\auditorias_bodies.txt")){
	?>
	<script>
	$('#Bloquear').fadeOut(500);
	createCookie('jAlertT','13000',1);
	jConfirm("No existen los archivos para importar.<br> &iquest;Desea marcar el inventario como Fallido ?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			jAlert('El Inventario n&uacute;mero "<? echo $num_inv; ?>" fue marcado como Fallido.', 'Debo Retail - Global Business Solution');
			$("#archivos").load("CarInvPro.php?inv=+<? echo $num_inv; ?>+");
		}
		$("#CargaInv").load("CargaInv.php");
		SoloNone("BotonesPri, Marca, LetTer, NumVol, SobreFoca");
		SoloBlock("CargaInv, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt");

		EnvAyuda("Ingrese el Inventario que desea cargar o importar desde Palm");
		document.getElementById("DondeE").value = "inv";
		document.getElementById("CantiE").value = "6";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_carga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetImpCarInv\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Terminar" title="Terminar" border="0" id="LetImpCarInv"/></button>';
	});
	</script>
	<?
exit();	
}


//** TRAIGO LA CABECERA DEL TXT Y SI NO EXISTE EN DB, INSERTO LOS DATOS
$ban = 0;
$handle = fopen($sRutaPalm."\auditorias_headers.txt","r");
if($handle){
	if(!feof($handle)){
		$cReg = @fgets($handle, filesize($sRutaPalm."\\auditorias_headers.txt")); 
		$num_inv = substr($cReg,5,10);
		$num_inv = (int)$num_inv;
			$dia = substr($cReg,15,2);
			$mes = substr($cReg,17,2);
			$anio = substr($cReg,19,4);
		$Fecha_Inv2 = $anio.$mes.$dia." 00:00:00";	//	ARMO FECHA PARA INSERTAR EN ITOMINVC 
		$Fecha_Inv = $anio."-".$mes."-".$dia." 00:00:00";	//	ARMO FECHA PARA INSERTAR EN INV_PALM_REA
		$sbMarcaInvPalmAzar = substr($cReg, strlen($cReg)-1, 1); //Val(Right(cReg, 2)) = 1 Then bMarcaInvPalmAzar = True
	}
}
fclose($handle);

if($num_inv == 0) {
	$_SESSION['ParSQL'] = "SELECT TOP 1 * FROM INV_PALM_REA WHERE INV_REA=0";
}else{
	$_SESSION['ParSQL'] = "SELECT TOP 1 * FROM INV_PALM_REA WHERE NUM_INV=".$num_inv."";
}
$INV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($INV_PALM_REA);
if(mssql_num_rows($INV_PALM_REA)==0){
	$num_inv_db = 0;
	$RealizadoPorPalm = 0;
}else{
	while($RINV = mssql_fetch_array($INV_PALM_REA)){ /////////////////// OJO
		$num_inv_db = $RINV['NUM_INV'];
		$RealizadoPorPalm = 1;
	}
}

$DB = 0;
if($RealizadoPorPalm == 1){	//** TRAE LOS DATOS DE LA DB
	$DB = 1;
	$_SESSION['ParSQL'] = "SELECT ID, DET, CONVERT(char(10), FET, 103)as FECHA, DEP, EST, OPE FROM ITOMINVC WHERE ID = ".$num_inv_db." ORDER BY RUB";
	$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ITOMINVC);
	while ($RITO=mssql_fetch_array($ITOMINVC)){
		$num_inv_db = $RITO['ID'];
		$teDET = trim($RITO['DET']);
		$teFEC = $RITO['FECHA'];
		$teOPEt = $RITO['OPE'];
		$est = $RITO['EST'];
		if($RITO['DEP'] == true){
			$teTIP = "DEPOSITO";
		}else{
			$teTIP = "VENTAS";
		}
	}
}else{					//** GUARDA POR DEFECTO LOS DATOS PARA SER INGRESADOS A LA DB
	$DB = 1;
	$num_inv_db = $num_inv;
	$est = "T";
	$teDET = "Inv.Colector de Datos - Empresa:".$numEmp;
	$teFEC = $anio."-".$mes."-".$dia;
	$teOPEt = 0;
	$teTIP = "DEPOSITO";
}

//**	VERIFICA SI YA HA SIDO CARGADO EL INVENTARIO
if ($est == "C"){
	?>		
	<script>
		$('#Bloquear').fadeOut(500);
		jAlert("El Inventario ha sido cargado y est&aacute; listo para ser impreso.", "Debo Retail - Global Business Solution");

		SoloNone('grabar_car, importar_car, LetEnt, cancelar, orden, notomado_car');
		SoloBlock("LetTer, impresion, descpidetitulo, cancelar");

		document.getElementById("DondeE").value = "";
		document.getElementById("CantiE").value = "";
		document.getElementById("QuePoE").value = "";

		EnvAyuda("Seleccione el tipo de Impresi&oacute;n y presione Imprimir");
	</script>
	<?
}else{
	?>
	<script>
		SoloNone("LetEnt, LetTer");
		SoloBlock("grabar_car, cancelar, descpidetitulo");
	</script>
	<?
}
	?>
<script>
	$('#Bloquear').fadeOut(500);
</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Toma de Inventario Por Colector de Datos</title>
<style>
#detalletiposCD{
	position:absolute;
	top:-692px;
	left:75px;
	z-index:3;
	font-size:12px;
	color:#FFF;
	display:block;
}

.fon_lista{ 
	background-image:url(InventarioToma/fon-item-suc.png); 
	height:19px; 
	font-family: "TPro";
	width:229px;

}

.lineaTomLis{
	background-image:url(InventarioCarga/fondo_linea.png);
	font-family: "TPro";
	font-weight:100;
	height:16px;
	width:544px;
	margin-top:2px;
}

#datos {
	background-color:#D07417;
	border:0; 
	height:16px;
	font-family: "TPro";
	position:absolute;
	text-align:center;
}

</style>
<script>

$(document).ready(function(){
	$('#formcargracd').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
            }
        })
        return false;
    });
	$('#pdfresCD').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
            }
        })
        return false;
    });
	$('#pdfdet1CD').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
            }
        })
        return false;
    });
	$('#pdfdet2CD').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#archivos').html(data);
            }
        })
        return false;
    });
})

document.getElementById('archivos').style.display = "block";

function movpag_a_invlis(p){
	np = p - 1;
	document.getElementById("capa_invlis"+np).style.display="block";
	document.getElementById("capa_invlis"+p).style.display="none";
	return false;
}

function movpag_b_invlis(p){
	np = p + 1;	
	document.getElementById("capa_invlis"+np).style.display="block";
	document.getElementById("capa_invlis"+p).style.display="none";
	return false;
}
</script>

</head>
<body>
<!-- FORMULARIOS PARA CREAR LA IMPRESION Y LOS PDF´S -->
<form action="CarInvPdfRes.php" method="post" name="pdfresCD" id="pdfresCD">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />	
</form>
<form action="CarInvPdfDet1.php" method="post" name="pdfdet1CD" id="pdfdet1CD">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />
    <input type="hidden" name="impsel" id="impsel" value="0" />
    <input type="hidden" name="valsel" id="valsel" value="0" />
</form>
<form action="CarInvPdfDet2.php" method="post" name="pdfdet2CD" id="pdfdet2CD">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />
    <input type="hidden" name="impsel" id="impsel" value="0" />
    <input type="hidden" name="valsel" id="valsel" value="0" />
</form>

<form method="post" name="formcargracd" id="formcargracd" action="CarInvGraCD.php">
	<input type="hidden" name="gracol" id="gracol" value="1" />




<div id="detalletiposCD">
<?
if($DB == 1){
	?>
	<script>
		SoloNone("invent");
	</script>
	<div id="inventa" class="fon-car" style="position:absolute; top:-47px; left:78px; width:63px;" align="center"><? echo $num_inv_db;?></div>
	<?	
}else{
?>	
	<div id="inventa" class="fon-car" style="position:absolute; top:-47px; left:78px; width:63px;" align="center"><? echo $num_inv;?></div>
<?
}
?>
	 <div id="detalle" class="fon-car2" style="position:absolute; top:-47px; left:150px; width:180px; display:block;" align="center"><? echo $teDET; ?></div>
		
		<div id="fecha" class="fon-car1" style="position:absolute; top:-45px; left:335px; width:74px; display:block;" align="center"><? echo $teFEC; ?></div>
		
		<div id="tipo" class="fon-car" style="position:absolute; top:-47px; left:410px; width:63px; display:block;" align="center"><? echo $teTIP; ?></div>
		
		<div id="opegen" class="fon-car" style="position:absolute; top:-47px; left:480px; width:63px; display:block;" align="center"><? echo $teOPEt; ?></div>

<?

//*** TRAIGO LOS DATOS DEL TXT BODIES Y COMPLETO LA LISTA DE ITEMS
$handle = fopen($sRutaPalm."\auditorias_bodies.txt", "r");
if($handle){
$total = count(file($sRutaPalm."\auditorias_bodies.txt"));
$c = 0;
$cc = 0;
$s = 1;
$n = 0;
$i=0;
while(!feof($handle)) {

	$bPaso_Azar = true; 
	$cReg = fgets($handle, filesize($sRutaPalm."\auditorias_bodies.txt")); 
	$marca1 = substr($cReg, 28, 2);
	$ultblanco = strlen($cReg);
	if($ultblanco > 0){		//**	CONTROLA QUE LA ÚLTIMA LINEA NO SEA UN ESPACIO EN BLANCO
		if ($marca1 <> "-1") {
			if ($i==0){
				$producto = substr($cReg, 12, 8);
				$sinv = substr($cReg, 0, 10);
			}else{
				$producto = $producto.substr($cReg, 12, 8);
			}
			$i=0;
		}
		$ART = substr($cReg, 12, 8);
		$SEC = substr($cReg, 10, 2);
		if ($marca1 != "-1") {
			$marca1=0;
			$fechatoma = substr($cReg, 30, 16);
			$contado = substr($cReg, 21, 9);
		}else{
			$contado=0;
			$fechatoma=Null;
		}
	///		COLOCAR LOS DATOS
		$contado = (int)$contado;
		$ART = (int)$ART;
		$SEC = (int)$SEC;
		$COD=format($SEC,2,'0',STR_PAD_LEFT)."-".format($ART,4,'0',STR_PAD_LEFT);
	
		$_SESSION['ParSQL'] = "SELECT DetArt,CodRub,DepSN FROM ARTICULOS WHERE CodSec = ".$SEC." AND CodArt = ".$ART."";
		$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($ARTICULOS);
	
		
		while ($RART=mssql_fetch_array($ARTICULOS)){
			$ARTNOM = $RART['DetArt'];
			$RUB = $RART['CodRub'];
			$DepSN = $RART['DepSN'];
		}
		if($DepSN == 1){
			$teTIP = "DEPOSITO";
		}
			
		$c = $c + 1;
		$cc = $cc + 1;
		$n = $n + 1;
		if ($c == 1){
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
			echo "<div id=\"capa_invlis".$s."\" style=\"display:".$e."\">";
			if($s <> 1){
			?>
				<div id="Anterior_Lista" style=" position:absolute; top:-20px; left:580px;">
					<button class="StyBoton" onClick="return movpag_a_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Lista<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Lista<?php echo $s; ?>"/></button>
				</div>
			<?
			}
		}
		?>
		<div class="lineaTomLis" id="linea<? echo $cc; ?>">
			<table width="545" height="17" border="0" cellpadding="-2" cellspacing="0" >
				<tr>
					<td width="64" align="center" valign="middle">
						<input style="background-color:#D07417; width:61px; height:10px; font-family: 'TPro'; border:0px; text-align:center;	" type="text" readonly="readonly" value="<? echo $COD; ?>"/>
					</td>
					
					<td  width="64" class="datos" align="center">
						<input style="background-color:#D07417; width:50px; height:12px; font-family: 'TPro'; border:0px; text-align:center;	" type="text" name="rubro" id="rubro" readonly="readonly" value="<? echo $RUB; ?>" />
					</td>
					
					<td  width="251" align="center">
						<input style="background-color:#D07417; width:250px; height:11px; left:10px; font-family: 'TPro'; border:0px; text-align:center;" type="text" name="detalle" id="detalle" readonly="readonly" value="<? echo $ARTNOM; ?>"/>
					</td>
				
					<td  width="96" align="center">
						<?
						if($marca1 == "-1"){
						?>
						<input type="text" name="valores[<? echo $ART;?>]" id="items<? echo $n; ?>" autocomplete="off" style="width:125px; height:13px; font-family: 'TPro'; border:0px; text-align:center; left:20px; background-color:#F3F3F3;" readonly="readonly" value="NO TOMADO"/>
						<? } else{ ?>
	
						<input type="text" name="valores[<? echo $ART;?>]" id="items<? echo $n; ?>" autocomplete="off" style="width:125px; height:13px; font-family: 'TPro'; border:0px; text-align:center; left:20px; background-color:#F3F3F3;" readonly="readonly" value="<? echo $contado; ?>"/>
						<? } ?>
						<input type="hidden" name="codi" id="codi" value="<? echo $ART; ?>" />
						<input type="hidden" name="n" id="n" value="<? echo $n; ?>" />
						<input type="hidden" name="t" id="t" value="<? echo $total; ?>" />
						<input type="hidden" name="nume" id="nume" value="<? echo $num_inv; ?>" />
						<input type="hidden" name="tipo" id="tipo" value="<? echo $teTIP; ?>" />
						<input type="hidden" name="marca1" id="marca1" value="<? echo $marca1; ?>" />
					</td>
				</tr>
			</table>
	
		</div>
		<?
		$t = $c;
		if ($c == 11){
		?>
			<div id="Siguiente_Lista<?php echo $s; ?>" style="position:absolute; top:163px;  left:580px;">
				<button class="StyBoton" onClick="return movpag_b_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Lista<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Lista<?php echo $s; ?>"/></button>
			</div>
		</div>
	
	<?
		$c = 0; 
		$s = $s + 1;  
		}
	}//**	FIN IF (BLANCO)
}//**	FIN WHILE
if ($t == 11){
	?>
	<script>
		SoloNone("Siguiente_Lista<?php echo $s-1; ?>");
    </script>
	<?
}
}


?>
</div>
	<input type="hidden" name="RealizadoPorPalm" id="RealizadoPorPalm" value="<? echo $RealizadoPorPalm; ?>" />
	<input type="hidden" name="num_inv_db" id="num_inv_db" value="<? echo $num_inv_db; ?>" />
    <input type="hidden" name="teDET" id="teDET" value="<? echo $teDET; ?>" />
    <input type="hidden" name="Fecha_Inv" id="Fecha_Inv" value="<? echo $Fecha_Inv; ?>" />
    <input type="hidden" name="Fecha_Inv2" id="Fecha_Inv2" value="<? echo $Fecha_Inv2; ?>" />
    <input type="hidden" name="teOPEt" id="teOPEt" value="<? echo $teOPEt; ?>" />
    <input type="hidden" name="teTIP" id="teTIP" value="<? echo $teTIP; ?>" />
    <input type="hidden" name="sec" id="sec" value="<? echo $SEC; ?>" />
    <input type="hidden" name="rub" id="rub" value="<? echo $RUB; ?>" />

</form>
</body>
</html>
<?
mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){/////////////////////////////////////////////////// FIN DE TRY //
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit();
}

?>