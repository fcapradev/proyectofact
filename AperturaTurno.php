<?

$xaptur = 1;

require("config/cnx.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Apertura de Turno</title>
</head>
<body>
<?

$co = $_REQUEST['co'];

?>

<script>

$("#at_efe").css("border-color", "#F90");

$(document).ready(function(){
	$('#Ape_Tur').submit(function(){
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

function salir_a(){

	document.getElementById("LetTer").style.display="none";
	
	SoloNone('CarAyudaFon, CarAyuda');
	
	Mos_Ocu('BotonesPri');
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros');
	Mos_Ocu('TecladoNum');
	Mos_Ocu('AperturaTurno');
	
}

function enviar_tur(){ 
	
	$('#Bloquear').fadeIn(500);
	$('#Ape_Tur').submit();

}

function enviarho(){

	var ap = document.getElementById("LetTex").value;
	$("#archivos").load("RHor.php?ap="+ap);
	document.getElementById("LetTex").value = "";
	
}

function efectivo(){

	var c = document.getElementById('AT_efe_rec').value.length;
	var cc =  document.getElementById('AT_efe_rec').value;

	if (!/^([0-9+\,+\.])*$/.test(cc)){
		
		document.getElementById('AT_efe_rec').value = "";
		jAlert('Debe ingresar solo números.', 'Debo Retail - Global Business Solution');
	
	}else{
		
		if(cc != 0){
			if(c != 0){
				
				var valAT_efe_rec =  dec(document.getElementById('AT_efe_rec').value);
				document.getElementById('AT_efe_rec').value = valAT_efe_rec;
				
				EnvAyuda('Ingrese la observacion.');
				
				$("#at_obs").css("border-color", "#F90");
				$("#at_efe").css("border-color", "transparent");
				
				document.getElementById("DondeE").value = "AT_obs";
				document.getElementById("CantiE").value = "250";
				document.getElementById("QuePoE").value = "0";
				
				document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" class="StyBoton" onclick="obsdeturno();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
				
				document.getElementById('NumVol').innerHTML = '	<button class="StyBoton" onclick="Vol_Efe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
				
				$("#AT_obs").focus();
				
			}
			
		}else{
			
			document.getElementById('AT_efe_rec').value = "";
			jAlert('Cantidad no valida.', 'Debo Retail - Global Business Solution');
			
		}
	}
}
	
function obsdeturno(){

	var c = document.getElementById('AT_obs').value.length;

	if(c != 0){
	
		EnvAyuda('Presione abrir para confirmar apertura de turno.');
		
		$("#at_obs").css("border-color", "transparent");
		
		Mos_Ocu('LetTer');
	
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetAbr" class="StyBoton" onclick="enviar_tur();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetAbr\',\'\',\'botones/abr-over.png\',0)"><img src="botones/abr-up.png" name="Abrir" title="Abrir" border="0" id="LetAbr"/></button>';
	
		document.getElementById('LetTer').innerHTML = '<button id="BotLetCan" onclick="salir_a();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCan\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar" border="0" id="LetCan"/></button>';
	
		document.getElementById('NumVol').innerHTML = '	<button class="StyBoton" onclick="Vol_Obs();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
		
		$("#LetEnt").focus();
		
	}
	
}

function Vol_Hor(){

	$("#AperturaTurno").load("AperturaTurno.php?co=1");
	
	EnvAyuda('Selecione horario para el turno.');
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" onclick="enviarhorario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	$("#LetTex").focus();

}

function Vol_Efe(){
	
	EnvAyuda('Ingrese el efectivo recibido.');
	
	$("#at_efe").css("border-color", "#F90");
	$("#at_obs").css("border-color", "transparent");	
	
	document.getElementById("AT_efe_rec").value = "";
	document.getElementById("AT_obs").value = "";
	
	document.getElementById("DondeE").value = "AT_efe_rec";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" onclick="efectivo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	document.getElementById('NumVol').innerHTML = '	<button class="StyBoton" onclick="Vol_Hor();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';

	$("#AT_efe_rec").focus();

}

function Vol_Obs(){
	
	document.getElementById("DondeE").value = "AT_obs";
	document.getElementById("CantiE").value = "250";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById("AT_obs").value = "";
	document.getElementById("LetTex").value = "";
	
	EnvAyuda('Ingrese la observacion.');
	
	$("#at_obs").css("border-color", "#F90");
	$("#at_efe").css("border-color", "transparent");

	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" class="StyBoton" onclick="obsdeturno();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	Mos_Ocu('LetTer');
			
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_Efe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
	
	$("#AT_obs").focus();
	
}

function enviarhopor(idd){

	$("#archivos").load("RHor.php?ap="+idd);

}

function enviodehorario(){

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		enviarho();
		return false;
	}

}

function ControlAT_efe_rec(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		efectivo();
		return false;
	}
	
}

function ControlAT_obs(){

	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		obsdeturno();
		return false;
	}

}

function ControlAT_efe_recVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		obsdeturno();
	}

}

function ControlAT_obsVol(){

	var k = window.event.keyCode;
	if(k == 27){
		if(document.getElementById('at_obs').style.borderColor == "transparent"){
			Vol_Obs();
		}else{
			Vol_Efe();
		}
	}

}

$("#LetTex").focus();

</script>

<link href="Estilo.css" rel="stylesheet" type="text/css" />

<?

if($co == 0){

?>
<script>

	EnvAyuda('Ingrese el efectivo recibido.');
	
	document.getElementById('NumVol').innerHTML = '	<button class="StyBoton" onclick="Vol_Hor();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
		
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" onclick="efectivo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt3"/></button>';
	
	document.getElementById("DondeE").value = "AT_efe_rec";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";

	$("#AT_efe_rec").focus();
	
</script>

<div id="Apertura_Fon2" style="position:absolute; z-index:1; width:639px; height:235px; top:125px; left:81px;"><img src="Apertura/aperturadecaja.png" /></div>

<div id="Apertura2" style="position:absolute; z-index:2; width:639px; height:235px; top:125px; left:81px;">

<form name="Ape_Tur" id="Ape_Tur" action="NTur.php">

	<?		
	$ap = $_REQUEST['ap'];
	
	$SQL = "SELECT TOP 1 PLA FROM ATURNOSO ORDER BY PLA DESC";
	$registros = mssql_query($SQL) or die("Error SQL");
		
	if(mssql_num_rows($registros) == 0){ $pla = 1; }
	
	while ($reg=mssql_fetch_row($registros)){ $pla = $reg[0] + 1; }
	
	mssql_free_result($registros);
	
	$SQL = "SELECT * FROM ATURNOSH where MTN = ".$ap."";
	$registros = mssql_query($SQL) or die("Error SQL");
		
		if(mssql_num_rows($registros) == 0){
			?>
			<script>
				jAlert('Mal Configurado', 'Debo Retail - Global Business Solution');
			</script>    
			<?
			exit;
		}
	
	while ($reg=mssql_fetch_row($registros)){

		$h = $reg[0];
		$hn = $reg[1];
		$ini = $reg[2];
		$fin = $reg[3];
		
	}
	mssql_free_result($registros);

	?>
	
	<div style="position:absolute; z-index:2; left:91px; top:63px; color:#FFFFFF;">
		<samp style="font-family:'TPro'; font-size:12px; font-weight:bold;"><? echo format($pla,5,'0',STR_PAD_LEFT); ?></samp>
	</div>
	
	<input type="hidden" name="horario" id="horario" value="<? echo $h; ?>" />
	<input type="hidden" name="planilla" id="planilla" value="<? echo $pla; ?>" />
	
	<div style="position:absolute; z-index:2; left:86px; top:83px;">
	<table width="214" border="0">
		<tr style="color:#FFFFFF;">
			<td width="214">
			<samp style="font-family:'TPro'; font-size:12px; font-weight:bold;">
				<? echo format($h,2,'0',STR_PAD_LEFT); ?> - <? echo $hn; ?> - De <? echo $ini; ?> a <? echo $fin; ?>
			</samp>
			</td>
		</tr>
	</table>
	</div>
	
	<div style="position:absolute; z-index:2; left:91px; top:110px; color:#FFFFFF;">
		<samp style="font-family:'TPro'; font-size:12px; font-weight:bold;"><? echo $_SESSION['idsusun']; ?></samp></samp>
	</div>

	<div id="at_efe" class="div-redondo" style="position:absolute; z-index:2; left:86px; top:161px; height:24px; width:143px;">
	<input type="text" id="AT_efe_rec" name="AT_efe_rec" style="outline-style:none; border-style:none; font-family:'TPro'; font-size:16px; width:138px; text-align:right;" maxlength="11" onKeyPress="return ControlAT_efe_rec();" onKeyDown="return ControlAT_efe_recVol();" />
	</div>
	
	<div id="at_obs" class="div-redondo" style="position:absolute; z-index:2; left:336px; top:56px; height:132px; width:279px;">
	<textarea id="AT_obs" name="AT_obs" maxlength="250" style="resize:none; outline-style:none; border-style:none; font-family:'TPro'; font-size:12px; font-weight:bold; width:262px; height:130px; text-transform:uppercase;" onKeyPress="return ControlAT_obs();" onKeyDown="return ControlAT_obsVol();" />
	</div>

</form>

</div>

<?

}else{

?>

<div id="Apertura_Fon1" style="position:absolute; z-index:1; width:299px; height:144px; top:125px; left:250px;"><img src="Apertura/turnos.png" /></div>

<div id="Apertura1" style="position:absolute; z-index:2; width:299px; height:144px; top:125px; left:250px;">

	<table width="299" cellpadding="0" cellspacing="0" align="center" border="0">
	<?
		
	$SQL = "SELECT * FROM ATURNOSH";
	$registros = mssql_query($SQL) or die("Error SQL");

		if(mssql_num_rows($registros) == 0){
			?>
			<script>
				jAlert('Mal Configurado no hay registros en la tabla ATURNOSH', 'Debo Retail - Global Business Solution');
			</script>
			<?
		}
		
	while ($reg=mssql_fetch_row($registros)){
	
	echo "
	<tr>
	<td style=\"font-size:4px\">&nbsp;</td>
	</tr>
	<tr>
	<td style=\"color:#FFFFFF; cursor:pointer; \" onclick=\"apertur(".$reg[0].");\">
		<table width=\"299\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
		<tr>
		<td width=\"35\"><b>&nbsp;</b></td>
		<td width=\"35\"><samp style=\"font-family:'TPro'; font-size:12px;\"><b>".format($reg[0],2,'0',STR_PAD_LEFT)."</b></samp></td>
		<td width=\"90\"><samp style=\"font-family:'TPro'; font-size:12px;\"><b>".$reg[1]."</b></samp></td>
		<td width=\"139\"><samp style=\"font-family:'TPro'; font-size:12px;\"><b>De ".$reg[2]." a ".$reg[3]."</b></samp></td>
		</tr>
		</table>
	</td>
	</tr>";

	}
	mssql_free_result($registros);
	
	?>
	</table>

</div>

<?
}
?>
</body>
</html>