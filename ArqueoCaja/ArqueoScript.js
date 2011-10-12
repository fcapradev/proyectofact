// JavaScript Document

function salir_arq2(){
	
	$('#BotonesPri').fadeIn(500);
	$('#SobreFoca').fadeIn(500);
	Mos_Ocu('Arqueo');
	SoloNone('TecladoLet, TecladoNum, NumVol, fondotranspletras, fondotranspnumeros, CarAyuda, CarAyudaFon');

	document.getElementById('Arqueo').innerHTML = '';

}

function siguiente_arq1(){
	
	idsup = document.getElementById("sup").value;

	if(idsup == ''){
	
		buscaope();

	}else{

		$('#descpidesupe').load("ArqSelOpe.php?idsup="+idsup+"");

	}

}

function siguiente_arq11(){

	$("#efectivo").css("border-color", "#F90");
	$("#supnum").css("border-color", "transparent");

	EnvAyuda("Ingrese el efectivo");

	document.getElementById("gastosf").style.display = "block";
	document.getElementById("chequesf").style.display = "block";
	document.getElementById("anticipof").style.display = "block";
	document.getElementById("tarjetasf").style.display = "block";
	document.getElementById("cargasf").style.display = "block";
	document.getElementById("retirof").style.display = "block";
	document.getElementById("gascon01").style.display = "block";
	

	controlarcadainput('efe');
	document.getElementById("DondeE").value = "efe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';

}

function siguiente_arq2(){

	var efe = document.getElementById("efe").value;
	document.getElementById("efe").value = dec(efe.replace(",","."));

	if(efe < 0 || efe == ''){
		
		document.getElementById("efe").value = '';
		jAlert('Debe ingresar el efectivo.', 'Debo Retail - Global Business Solution');			
		
	}else{

		$("#tarjetasf").css("border-color", "#F90");
		$("#efectivo").css("border-color", "transparent");
	
		EnvAyuda("Ingrese tarjetas.");
	
		controlarcadainput('tar');
		document.getElementById("DondeE").value = "tar";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2_1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';
	
	}
}

function Volver_Operario(){
	
	$("#supnum").css("border-color", "#F90");
	$("#efectivo").css("border-color", "transparent");	
	
	controlarcadainput('sup');
	
	document.getElementById("DondeE").value = "sup";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda("Ingrese un n&uacute;mero de Supervisor o Enter para Listar.");
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqSup\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqSup"/></button>';	
}

function siguiente_arq2_1(){

	var tar = document.getElementById("tar").value;
	document.getElementById("tar").value = dec(tar.replace(",","."));

	if(tar < 0 || tar == ''){
		
		document.getElementById("tar").value = '';
		jAlert('Debe ingresar las tarjetas.', 'Debo Retail - Global Business Solution');			
		
	}else{
		
		var can = document.getElementById("can").value;
		
		if(can >= 1){
			
			mon1 = document.getElementById("mon1").value;

			$("#m01").css("border-color", "#F90");
			$("#tarjetasf").css("border-color", "transparent");
			
			EnvAyuda("Ingrese la moneda de "+mon1+"ES o Enter si no posee");
	
			var efe = parseFloat(document.getElementById('efe').value);
			var gas = parseFloat(document.getElementById('gas').value);
			var che = parseFloat(document.getElementById('che').value);
			var ant = parseFloat(document.getElementById('ant').value);
			var tar = parseFloat(document.getElementById('tar').value);
			var ret = parseFloat(document.getElementById('ret').value);
			var car = parseFloat(document.getElementById('car').value);
			var total = efe + gas + che + ant + tar - (car + ret);
			var res = dec(total);
			
			//document.getElementById("totalf").style.display = "block";
			document.getElementById("tot").value = res;
			
			controlarcadainput('m1');
			
			document.getElementById("DondeE").value = "m1";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';
			
		}else{
			
			$("#efectivo").css("border-color", "transparent");
			controlarcadainput('Terminar');
			EnvAyuda("Presione TERMINAR para Finalizar");
			
			SoloNone("NumVolPADiv");
			SoloBlock("bot_ter");
			
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq10\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq10"/></button>';
		}
	}
}

function Volver_arq2_1(){
	
	$("#efectivo").css("border-color", "#F90");
	$("#tarjetasf").css("border-color", "transparent");	

	EnvAyuda("Ingrese el efectivo");

	controlarcadainput('efe');
	document.getElementById("DondeE").value = "efe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';	
}

function siguiente_arq3(){
	
	m1 = document.getElementById("m1").value;
	document.getElementById("m1").value = dec(m1.replace(",","."));

	if(m1 < 0 ){

		document.getElementById("m1").value = '';
		jAlert('Debe ingresar una cantidad correcta.', 'Debo Retail - Global Business Solution');			

	}else{

		if(m1 == ''){
			document.getElementById("m1").value = "0,00";
		}

		var can = document.getElementById("can").value;

		if(can >= 2){

			mon2 = document.getElementById("mon2").value;

			$("#m02").css("border-color", "#F90");
			$("#m01").css("border-color", "transparent");

			EnvAyuda("Ingrese el monto de "+mon2+"S o Enter si no posee");
	
			controlarcadainput('m2');
			document.getElementById("DondeE").value = "m2";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
	
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq7"/></button>';

		}else{

			$("#m01").css("border-color", "transparent");
			controlarcadainput('Terminar');
			EnvAyuda("Presione TERMINAR para Finalizar");

			SoloNone("NumVolPADiv");
			SoloBlock("bot_ter");

			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq11\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq11"/></button>';
		}
	}
}

function Volver_Efectivo(){
	
	EnvAyuda("Ingrese el efectivo");
	
	$("#efectivo").css("border-color", "#F90");
	$("#m01").css("border-color", "transparent");	
	
	controlarcadainput('efe');
	document.getElementById("DondeE").value = "efe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';
	
}

function siguiente_arq4(){
	m2 = document.getElementById("m2").value;
	document.getElementById("m2").value = dec(m2.replace(",","."));

	if(m2 < 0 ){

		document.getElementById("m2").value = '';
		jAlert('Debe ingresar una cantidad correcta.', 'Debo Retail - Global Business Solution');			

	}else{

		if(m2 == ''){

			document.getElementById("m2").value = "0,00";

		}

		var can = document.getElementById("can").value;

		if(can >= 3){

			mon3 = document.getElementById("mon3").value;
			
			$("#m03").css("border-color", "#F90");
			$("#m02").css("border-color", "transparent");
			
			EnvAyuda("Ingrese el monto de "+mon3+"ES o Enter si no posee");

			controlarcadainput('m3');
			document.getElementById("DondeE").value = "m3";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
	
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq8\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq8"/></button>';

		}else{

			$("#m02").css("border-color", "transparent");
			controlarcadainput('Terminar');
			EnvAyuda("Presione TERMINAR para Finalizar");

			SoloNone("NumVolPADiv");
			SoloBlock("bot_ter");

			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq12\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq12"/></button>';
		}
	}
}

function Volver_Mon1(){

	mon1 = document.getElementById("mon1").value;

	$("#m01").css("border-color", "#F90");
	$("#m02").css("border-color", "transparent");
	
	EnvAyuda("Ingrese la moneda de "+mon1+"ES o Enter si no posee");
	
	controlarcadainput('m1');
	
	document.getElementById("DondeE").value = "m1";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';
	
}


function siguiente_arq5(){
	m3 = document.getElementById("m3").value;
	document.getElementById("m3").value = dec(m3.replace(",","."));

	if(m3 < 0 ){

		document.getElementById("m3").value = '';
		jAlert('Debe ingresar una cantidad correcta.', 'Debo Retail - Global Business Solution');			

	}else{

		if(m3 == ''){

			document.getElementById("m3").value = "0,00";

		}

		var can = document.getElementById("can").value;

		if(can >= 4){

			mon4 = document.getElementById("mon4").value;	

			$("#m04").css("border-color", "#F90");
			$("#m03").css("border-color", "transparent");

			EnvAyuda("Ingrese el monto de "+mon4+" o Enter si no posee");

			controlarcadainput('m4');
			document.getElementById("DondeE").value = "m4";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
	
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq9\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq9"/></button>';

		}else{
			
			$("#m03").css("border-color", "transparent");
			controlarcadainput('Terminar');
			EnvAyuda("Presione TERMINAR para Finalizar");

			SoloNone("NumVolPADiv");
			SoloBlock("bot_ter");

			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq13\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq13"/></button>';
	

		}
	}
}

function Volver_Mon2(){
	
	mon2 = document.getElementById("mon2").value;

	$("#m02").css("border-color", "#F90");
	$("#m03").css("border-color", "transparent");

	EnvAyuda("Ingrese el monto de "+mon2+"S o Enter si no posee");

	controlarcadainput('m2');
	document.getElementById("DondeE").value = "m2";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq7\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq7"/></button>';
	
}

function siguiente_arq6(){
	m4 = document.getElementById("m4").value;
	document.getElementById("m4").value = dec(m4.replace(",","."));

	if(m4 < 0 ){
	
		document.getElementById("m4").value = '';
		jAlert('Debe ingresar una cantidad correcta.', 'Debo Retail - Global Business Solution');
	
	}else{

		if(m4 == ''){

			document.getElementById("m4").value = "0,00";
	
		}

		var can = document.getElementById("can").value;

		if(can >= 5){

			mon5 = document.getElementById("mon5").value;	

			$("#m05").css("border-color", "#F90");
			$("#m04").css("border-color", "transparent");

			EnvAyuda("Ingrese el monto de "+mon5+" o Enter si no posee");
	
			controlarcadainput('m5');
			document.getElementById("DondeE").value = "m5";
			document.getElementById("CantiE").value = "10";
			document.getElementById("QuePoE").value = "1";
	
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq7();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq14\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq14"/></button>';
		}else{
			
			$("#m04").css("border-color", "transparent");
			controlarcadainput('Terminar');
			EnvAyuda("Presione TERMINAR para Finalizar");
			
			SoloNone("NumVolPADiv");
			SoloBlock("bot_ter");
			
			document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq15\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq15"/></button>';
		}
	}
}

function Volver_Mon3(){
	
	mon3 = document.getElementById("mon3").value;
	
	$("#m03").css("border-color", "#F90");
	$("#m04").css("border-color", "transparent");
	
	EnvAyuda("Ingrese el monto de "+mon3+"ES o Enter si no posee");

	controlarcadainput('m3');
	document.getElementById("DondeE").value = "m3";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq5();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq8\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq8"/></button>';
	
}

function siguiente_arq7(){
	m5 = document.getElementById("m5").value;
	document.getElementById("m5").value = dec(m5.replace(",","."));
	
	if(m5 == ''){
		document.getElementById("m5").value = "0,00";
	}
	
	$("#m05").css("border-color", "transparent");

	
	EnvAyuda("Presione TERMINAR para Finalizar");
	
	SoloNone("NumVolPADiv");
	
	controlarcadainput('Terminar');
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq16\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq16"/></button>';
	

	document.getElementById("bot_ter").style.display = "block";
}

function Volver_Mon4(){
	
	mon4 = document.getElementById("mon4").value;	

	$("#m04").css("border-color", "#F90");
	$("#m05").css("border-color", "transparent");

	EnvAyuda("Ingrese el monto de "+mon4+" o Enter si no posee");

	controlarcadainput('m4');
	document.getElementById("DondeE").value = "m4";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq6();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq9\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq9"/></button>';
	
}

function terminar(){

	$('#formarqueo2').submit();

	SoloBlock("imprimirarq");
	SoloNone("bot_ter, NumVolPADiv");
	EnvAyuda("Presione IMPRIMIR para ver el Arqueo");
	
	controlarcadainput('sup');
}

function Volver_Inicio(){
	
	EnvAyuda("Ingrese el efectivo.");

	SoloNone("bot_ter");
	SoloBlock("NumVolPADiv");
	
	$("div").css("border-color", "transparent");	
	$("#efectivo").css("border-color", "#F90");
	
	controlarcadainput('efe');
	document.getElementById("DondeE").value = "efe";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArq3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArq3"/></button>';

}

function generapdfarq(){
	
	$('#Bloquear').fadeIn(500);
	$('#arqueoimp').submit();
	SoloNone("sal_arq");
	SoloNone("imprimirarq");
	SoloNone("SobreFoca");
	SoloNone("NumVolPADiv");
	
}

function ImpreVolArq(){
	
	SoloNone('ImpresionPdfDiv, BotonesPri, LetTer');

	$("#ArqAgr").load("ArqAgr.php");

	SoloBlock('Marca, fondotranspnumeros, TecladoNum, NumVolPADiv, NumVol, sal_arq, Arq_BotVer');

	document.getElementById('sup').value = '';
	document.getElementById('supenom').value = '';
	document.getElementById('efe').value = '';
	document.getElementById("gastosf").style.display = "none";
	document.getElementById("chequesf").style.display = "none";
	document.getElementById("anticipof").style.display = "none";
	document.getElementById("tarjetasf").style.display = "none";
	document.getElementById("cargasf").style.display = "none";
	document.getElementById("retirof").style.display = "none";
	document.getElementById("gascondiv").style.display = "none";
	
	var can = document.getElementById("can").value;
	if(can >= 1){
		document.getElementById('m1').value = "";
	}
	if(can >= 2){
		document.getElementById('m2').value = "";
	}
	if(can >= 3){
		document.getElementById('m3').value = "";
	}
	if(can >= 4){
		document.getElementById('m4').value = "";
	}
	if(can >= 5){
		document.getElementById('m5').value = "";
	}
	document.getElementById('tot').value = "";
	
	$("#supnum").css("border-color", "#F90");

	controlarcadainput('sup');
	document.getElementById("DondeE").value = "sup";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda("Ingrese un n&uacute;mero de Supervisor o Enter para Listar.");
	
	document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqSup1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqSup1"/></button>';

}

function buscaope(){
	document.getElementById("fondosuper").style.display = "block";
	document.getElementById("descpidesupe").style.display = "block";
	document.getElementById("fondogeneralsupe").style.display = "block";
	document.getElementById("cruzope").style.display = "block";
	$('#descpidesupe').load('ArqSelOpe.php');
}


function verpdf(){
	document.getElementById("fondopidetipo").style.display = "block";
	document.getElementById("descpidetipo").style.display = "block";
	document.getElementById("fondogeneral").style.display = "block";
	document.getElementById("cruzpdf").style.display = "block";	
	$('#descpidetipo').load('ArqSelPdf.php');
}

function volver(){
	
	$("#Arqueo").load("ArqAgr.php");
	SoloNone('fondotranspletras');
	SoloNone('TecladoLet');
	SoloBlock('TecladoNum');
	SoloBlock('NumVol');		
	SoloBlock('fondotranspnumeros');
	EnvAyuda("Seleccione un Supervisor");
}

function salirpdf(a){
	if(a == 1){
		document.getElementById("fondopidetipo").style.display = "none";
		document.getElementById("descpidetipo").style.display = "none";
		document.getElementById("fondogeneral").style.display = "none";
		document.getElementById("cruzpdf").style.display = "none";	

		EnvAyuda("Seleccione un supervisor");
		
		controlarcadainput('sup');
		document.getElementById("DondeE").value = "efe";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";

	}else{

		document.getElementById("fondogeneralsupe").style.display = "none";
		document.getElementById("fondosuper").style.display = "none";
		document.getElementById("descpidesupe").style.display = "none";
		document.getElementById("cruzope").style.display = "none";

	}	
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function controlarcadainput(cu){

	$("input").attr("readonly", "readonly");
	$("#"+cu).removeAttr("readonly");
	$("#"+cu).focus();
}

function ControlOperario(){

	if(document.getElementById("supnum").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq1();
	}
	
}

function ControlOperarioVol(){
	
	if(document.getElementById("supnum").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 114){
		verpdf();
	}

}

function ControlEfectivo(){
	
	if(document.getElementById("efectivo").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq2();
	}

}

function ControlEfectivoVol(){
	
	if(document.getElementById("efectivo").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Operario();
	}

}

function ControlMon1(){
	
	if(document.getElementById("m01").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq3();
	}

}

function ControlMon1Vol(){
	
	if(document.getElementById("m01").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Efectivo();
	}

}

function ControlMon2(){
	
	if(document.getElementById("m02").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq4();
	}

}

function ControlMon2Vol(){
	
	if(document.getElementById("m02").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Mon1();
	}

}

function ControlMon3(){
	
	if(document.getElementById("m03").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq5();
	}

}

function ControlMon3Vol(){
	
	if(document.getElementById("m03").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Mon2();
	}

}

function ControlMon4(){
	
	if(document.getElementById("m04").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq6();
	}

}

function ControlMon4Vol(){
	
	if(document.getElementById("m04").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Mon3();
	}

}

function ControlMon5(){
	
	if(document.getElementById("m05").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq7();
	}

}

function ControlMon5Vol(){
	
	if(document.getElementById("m05").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Mon4();
	}

}

function ControlTerminar(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		terminar();
	}

}

function ControlTerminarVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Inicio();
	}

}

function ControlTarjetas(){
	
	if(document.getElementById("tarjetasf").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		siguiente_arq2_1();
	}

}

function ControlTarjetasVol(){
	
	if(document.getElementById("tarjetasf").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_arq2_1();
	}

}
