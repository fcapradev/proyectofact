<?
if(!isset($_COOKIE['idsusua'])){
?>
<script>

function usuario(){
	
	var c = document.getElementById('usua').value.length;
	if(c != 0){

		$("#usuarioenform").css("border-color", "transparent");
		$("#contraenform").css("border-color", "#F90");
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="contra();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
		document.getElementById("NumVol").style.display="block";
		EnvAyuda("Ingrese contraseña.");
	
		document.getElementById('NumVol').innerHTML = '	<button class="StyBoton" onclick="Vol_Usu();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVol1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVol1"/></button>';
	
		document.getElementById("DondeE").value = "cont";
	
		$("#cont").focus();
		
	}
	
}

function contra(){

	var c = document.getElementById('cont').value.length;
	if(c >= 3){
		
		SoloNone("LetEnt, NumVol");
		$("#formulariousuario").submit();

	}
	
}

function Vol_Usu(){

	$("#usuarioenform").css("border-color", "#F90");
	$("#contraenform").css("border-color", "transparent");

	SoloNone("NumVol");
	SoloBlock("LetEnt")
	
	document.getElementById("DondeE").value = "usua";
	
	document.getElementById("usua").value = "";
	document.getElementById("cont").value = "";
	
	EnvAyuda("Ingrese usuario.");
		
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="usuario();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	$("#usua").focus();
	
}

function ControlDeEventosUsu(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		usuario();
	}
	
}

function ControlDeEventosCot(){
	
	var k = window.event.keyCode;
	if(k == 13){
		contra();
	}
	
}

function ControlDeEventosCotVol(){

	var k = window.event.keyCode;
	if(k == 27){
		Vol_Usu();
	}

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$("#ErrorConex").load("config/form_log.php");

document.getElementById("DondeE").value = "usua";

document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="usuario();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';

document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="javascript:close();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalconfg\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalconfg"/></button>';

EnvAyuda("Ingrese usuario.");

SoloNone("LetSal, LetTer, NumVol");

SoloBlock("ErrorConex, CarAyuda, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>

<?php
	
	exit;

}
?>