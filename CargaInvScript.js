// JavaScript Document
$(document).ready(function(){
	$('#inventario').submit(function(){
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data){
            $('#descpidelista').html(data);
            }
        })
        return false;
    });
})

function salir_car(){

	$('#BotonesPri').fadeIn(500);
	Mos_Ocu('CargaInv');
	document.getElementById('CargaInv').innerHTML = '';
}


function salir_carga(){
	jConfirm("¿Esta seguro que desea salir?.", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$('#BotonesPri').fadeIn(500);
			SoloNone("CargaInv");
			SoloBlock('SobreFoca');	
			SoloNone('CarAyudaFon');
			SoloNone('CarAyuda');
			SoloBlock('Marca');
			SoloNone('LetTer');
			document.getElementById('fondoimg').style.display = "none";
			document.getElementById('archivos').style.display = "none";
			document.getElementById('fondotranspletras').style.display = "none";
			document.getElementById('TecladoLet').style.display = "none";
			document.getElementById('fondotranspnumeros').style.display = "none";
			document.getElementById('TecladoNum').style.display = "none";
			document.getElementById('CargaInv').innerHTML = '';


			
		}
	});
	
	
	$("#BotonesPri").load("BotonesPri.php");
 }
////// BOTON SELECCIONA //////
function cam_ord(o){
	if(o == 0){
		document.getElementById('BotNumSel').style.display = "none";
		document.getElementById('BotAlfSel').style.display = "block";
		document.getElementById("ordsel").value = 0;
	}else{
		document.getElementById('BotNumSel').style.display = "block";
		document.getElementById('BotAlfSel').style.display = "none";
		document.getElementById("ordsel").value = 1;
	}
	document.getElementById('fondolista').style.display = "block";
	document.getElementById('descpidelista').style.display = "block";
	document.getElementById('descpidetitulo').style.display = "block";
	$('#inventario').submit();
}

function cam_imp(o){
	if(o == 0){
		document.getElementById('BotDetSel').style.display = "none";
		document.getElementById('BotResSel').style.display = "block";
		document.getElementById("imps").value = 0;
		document.getElementById('valor').style.display = "none";
		document.getElementById("vals").value = 0;
	}else{
		document.getElementById('BotDetSel').style.display = "block";
		document.getElementById('BotResSel').style.display = "none";
		document.getElementById("imps").value = 1;
		document.getElementById('valor').style.display = "block";
		document.getElementById('BotCosSel').style.display = "block";
		document.getElementById('BotVenSel').style.display = "none";
		document.getElementById("vals").value = 1;
	}
}

function cam_val(o){
	if(o == 0){
		document.getElementById('BotVenSel').style.display = "none";
		document.getElementById('BotCosSel').style.display = "block";
		document.getElementById("vals").value = 1;

	}else{
		document.getElementById('BotVenSel').style.display = "block";
		document.getElementById('BotCosSel').style.display = "none";
		document.getElementById("vals").value = 2;
	}
	document.getElementById('fondolista').style.display = "block";
	document.getElementById('descpidelista').style.display = "block";
}

function busca_num_inv(){
	var inv = document.getElementById('inv').value.length;
	if(inv == 0 ){
		jAlert('Debe ingresar un número de Inventario.', 'Debo Retail - Global Business Solution');
	}else{
		$('#inventario').submit();
		document.getElementById('BotAlfSel').style.display = "block";
	}
}

var pags = 0;
var caps = 0;

function siguiente(){
	
	SoloBlock('NumVol');
	var n = document.getElementById("n").value;
	bordessiguiente(n);
	var items = "items"+n;
	var v = document.getElementById(items).value;
	if(v ==""){
		document.getElementById(items).value = 0;
	}
	var t = document.getElementById("t").value;

/*
	pags = parseInt(pags) + parseInt(1);			//** funcion que cambia de capa la lista cargada
	if(parseInt(pags) == 11){
		caps = caps + 1;
		pags = 0;
		movpag_b_invlis(caps);
	}
*/	
	if(parseInt(n) >= parseInt(t) ){
		document.getElementById("DondeE").value = ""; /// modificar a donde quiero que vaya cdo termine de cargar datos
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "6";
		SoloNone("orden");
		SoloNone("LetEnt");
		SoloBlock("grabar_car");
		SoloNone("importar_car");
		SoloNone("notomado_car");
		SoloBlock("NumVol");
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';
		EnvAyuda("Presione Grabar.");
	}else{

		var f = parseInt(n) + parseInt(1);
		var items = "items"+f;
		document.getElementById("n").value = f;
		//document.getElementById(items).selectionStart = 0;
		document.getElementById("DondeE").value = items;
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "6";

		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntTomInv" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="BotLetEntTomInv"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';

	}
	
}

function bordessiguiente(n){

	var saca = "#lin"+ (n-1);
	var mete = "#lin"+ n;

	$(saca).css("border-color", "transparent");
	
	$(mete).css("border-color", "#F90");
	
}

function Select () {
	var input = document.getElementById("myText");
	if('selectionStart' in input){
		input.selectionStart = 1;
		input.selectionEnd = 2 ;
		input.focus ();
	}
}

function anterior(){
	var n = document.getElementById("n").value;
	var t = document.getElementById("t").value;

	bordesanterior(n,1);

	if(parseInt(n) > parseInt(t) ){
		SoloNone('NumVol');
		//document.getElementById(items).selectionStart = 0;
		document.getElementById("DondeE").value = items;
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";
	}else{
		var f = parseInt(n) - parseInt(1);
		
		if(f == 1){
			SoloNone("NumVol");
		}
		var items = "items"+f;
		document.getElementById("n").value = f;
		//document.getElementById(items).selectionStart = 0;
		document.getElementById("DondeE").value = items;
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";
	}		
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntTomInv" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="BotLetEntTomInv"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';
}

function bordesanterior(n,a){

	if(a == 1){

		var saca = "#lin"+ (n-1);
		var mete = "#lin"+ (n-2);
	
		$(saca).css("border-color", "transparent");
		
		$(mete).css("border-color", "#F90");
		
	}else{

		var mete = "#lin"+ (n-1);
	
		$(mete).css("border-color", "#F90");
		
	}
}


function anterior1(){
	SoloBlock("LetEnt");
	SoloBlock("notomado_car");
	SoloNone("grabar_car");
	SoloNone("importar_car");

	var n = document.getElementById("n").value;
	var t = document.getElementById("t").value;
	if(n == 1){
		SoloNone("NumVol");
	}

	bordesanterior(n,2);
	
	pags = parseInt(pags) + parseInt(1);			//** funcion que cambia de capa la lista cargada
	if(parseInt(pags) == 11){
		caps = caps + 1;
		pags = 0;
		movpag_b_invlis(cap);
	}
		
	var items = "items"+n;
	document.getElementById("DondeE").value = items;
	//document.getElementById(items).selectionStart = 0;
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	var f = parseInt(n) - parseInt(1);
	document.getElementById("n").value = n;
	
	document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntTomInv" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="BotLetEntTomInv"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';

}

function notomado(){
	var n = document.getElementById("n").value;		//**	item
	var t = document.getElementById("t").value;		//**	cantidad de items
	var items = "items"+n;
	document.getElementById(items).value = "NO TOMADO";
	
	if(parseInt(n) >= parseInt(t) ){				//**	último item

/*
		SoloNone("LetEnt");
		SoloBlock("grabar_car");
		SoloNone("importar_car");
		SoloNone("notomado_car");
		SoloBlock("NumVol");
		document.getElementById("DondeE").value = ""; /// modificar a donde quiero que vaya cdo termine de cargar datos
		document.getElementById("CantiE").value = "3";
		document.getElementById("QuePoE").value = "1";
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';
*/
	
	}else{

		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntTomInv" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="BotLetEntTomInv"/></button>';

		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';
	}
	
	siguiente();
}

function grabar_car(){
	jConfirm("¿Realiza Calculos Previos de esta Carga?.", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$('#Bloquear').fadeIn(500);

			var gracol = document.getElementById('gracol').value;

			SoloNone("LetEnt, NumVol, grabar_car, notomado_car, cancelar");
			SoloBlock("LetTer, impresion");

			EnvAyuda("Seleccione el tipo de Impresi&oacute;n y presione Imprimir");

			if(gracol == 0){
				var inv = document.getElementById('inv').value;
				$('#formcargra').submit();
				$("#descpidelista").load("CarInvLis.php?i="+inv+"");
			}else{
				var num = document.getElementById('nume').value;
				$('#formcargracd').submit();
				$("#archivos").load("CarInvLisCD.php?i="+num+"");
			}
		}else{
			jAlert("El Inventario no fue grabado.", "Debo Retail - Global Business Solution");
		}
	});
}

function genera_pdf(){
	var imp = document.getElementById('imps').value;
	var val = document.getElementById('vals').value;
	var gracol = document.getElementById('gracol').value;
	if(gracol == 0){
		if(imp == 0){
			$('#Bloquear').fadeIn(500);
			document.getElementById('pdfs').value = 1;
			$('#pdfres').submit();
		}else{
			$('#Bloquear').fadeIn(500);
			if(imp == 1 && val == 1){
				$('#pdfdet1').submit();
				document.getElementById('pdfs').value = 2;
			}else{
				document.getElementById('pdfs').value = 3;
				$('#pdfdet2').submit();
			}
		}
	}else{
		if(imp == 0){
			$('#Bloquear').fadeIn(500);
			document.getElementById('pdfs').value = 1;
			$('#pdfresCD').submit();
		}else{
			$('#Bloquear').fadeIn(500);
			if(imp == 1 && val == 1){
				$('#pdfdet1CD').submit();
				document.getElementById('pdfs').value = 2;
			}else{
				document.getElementById('pdfs').value = 3;
				$('#pdfdet2CD').submit();
			}
		}
	}
}	

function ImpreVolCom(){
	SoloNone('ImpresionPdfDiv');
	$("#CargaInv").load("CargaInv.php");
	SoloNone("BotonesPri");
	SoloBlock("CargaInv");
	SoloNone('Marca');
	SoloBlock('fondotranspletras');
	SoloBlock('TecladoLet');
	SoloBlock('fondotranspnumeros');
	SoloBlock('TecladoNum');
	SoloBlock('LetEnt');
	SoloNone('LetTer');
	SoloNone('NumVol');
	SoloNone('SobreFoca');
	
	EnvAyuda("Ingrese el n&uacute;mero de Inventario que desea cargar");
	
	document.getElementById("DondeE").value = "inv";
	document.getElementById("CantiE").value = "6";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_carga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetImpCarInv\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Terminar" title="Terminar" border="0" id="LetImpCarInv"/></button>';

}

function buscainv(){
//	document.getElementById('archivos').style.display = "block";
	SoloNone("importar_car");
	SoloBlock("cruz");
	document.getElementById("fondocolector").style.display = "block";
	document.getElementById("fondopidecol").style.display = "block";
	document.getElementById("descpideinv").style.display = "block";
	$('#descpideinv').load('CargaInvSelInv.php');
}

function salir_trae_invcd(){
	SoloBlock("importar_car");
	SoloNone("cruz");
	document.getElementById("fondocolector").style.display = "none";
	document.getElementById("fondopidecol").style.display = "none";
	document.getElementById("descpideinv").style.display = "none";
}

function cancela(){
//	jAlert("El Inventario ingresado no existe.", "Debo Retail - Global Business Solution");
	$("#CargaInv").load("CargaInv.php");

	SoloBlock("CargaInv, LetEnt");
	SoloNone('LetTer, NumVol, cancelar, archivos');

	EnvAyuda("Ingrese el Inventario que desea cargar o importar desde Palm");

	document.getElementById("DondeE").value = "inv";
	document.getElementById("CantiE").value = "6";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById("detalle").value = "";
	document.getElementById("fecha").value = "";
	document.getElementById("tipo").value = "";
	document.getElementById("opegen").value = "";
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_carga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
	
}
