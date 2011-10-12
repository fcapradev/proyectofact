// JavaScript Document

$(document).ready(function(){
	$('#formfpafpa').submit(function(){
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

function AccBotFac(P){

if(document.getElementById("TerminarTic").value == 1){
	
	if(P == 1){
		
		EnvAyuda('Ingrese código de barras o realice una búsqueda.');
		
		SoloNone('ClientesFac, BotonesParaO, EntraOpe, EntraOpeF, ReEmitirC, MedioP, MiProd, Cotizacion');
		SoloBlock('MiProd, Loading, LetEnt, NumVol');
		
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "50";
		document.getElementById("QuePoE").value = "0";
		
		BValue('LetTex');
		
		$("#LetTex").focus();		
		$("#mostrar").load("Busqueda.php?l_env=77codigooculto77");
		$("#LetTex").focus();
		
		$("#mostrar").fadeIn(tim);
		$("#micapa1").fadeOut(tim);
		$("#toda_la_bus").fadeOut(tim);
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="BotLetTerFac" onclick="TerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
		
		if(document.getElementById('can_item').value > 0){
			SoloBlock("LetTer");
		}else{
			SoloNone("LetTer");
		}
		
	}
	
	if(P == 2){
				
		SoloNone('MiProd, Loading, EntraOpe, EntraOpeF, ReEmitirC, MedioP, MiProd, Cotizacion');
		SoloBlock('ClientesFac, BotonesParaO, LetEnt, NumVol');
		
		BValue('LetTex');
		
		$("#LetTex").focus();
		$("#mostrar").load("MCli.php?co=1");
		
		$("#mostrar").fadeIn(tim);
		$("#MiProd").fadeIn(tim);
		$("#micapa1").fadeOut(tim);

		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "50";
		document.getElementById("QuePoE").value = "0";
	
	}
	
	if(P == 3){

		var tot = document.getElementById('total').value;
		if(tot != 0){

			document.getElementById("MedioP").value = "";

			SoloNone('ClientesFac, BotonesParaO, MiProd, Loading, micapa1, Promo, MPromo, mostrar, ReEmitirC, EntraOpe, EntraOpeF, Cotizacion');
			SoloBlock('MedioP, MiProd');

			EnvAyuda('Seleccione medio de pago.');
					
			$("#MedioP").load("MMed.php");
			
		}
		
	}
	
	if(P == 4){

		EnvAyuda('Seleccione producto.');
		
		SoloNone('ClientesFac, BotonesParaO, EntraOpe, EntraOpeF, ReEmitirC, MedioP, MiProd, Cotizacion');
		SoloBlock('LetEnt, NumVol');
		
		BValue('LetTex');
		
		$("#LetTex").focus();		
		$("#mostrar").load("TeclasRapidas.php");
		$("#mostrar").fadeIn(tim);
		$("#MiProd").fadeIn(tim);
		$("#micapa1").fadeOut(tim);
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="BotLetTerFac" onclick="TerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';

	}
	
	if(P == 6){
		
		EnvAyuda('Entrada de operario.');
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="EntradaCod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntOpe\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntOpe"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarOpe();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerOpe\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerOpe"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="EntradaCod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntOpe2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntOpe2"/></button>';
	
		SoloNone('ClientesFac, BotonesParaO, MiProd, Loading, micapa1, Promo, MPromo, mostrar, ReEmitirC, MedioP, MiProd, Cotizacion');
		SoloBlock('EntraOpe, EntraOpeF, LetEnt, NumVol');
		
		$("#EntraOpe").load("FOpe.php");

	}
	
	if(P == 7){
		
		EnvAyuda('Seleccione el comprobante que desea re emitir.');
		
		SoloNone('ClientesFac, BotonesParaO, Loading, micapa1, Promo, MPromo, mostrar, EntraOpe, EntraOpeF, LetTer, LetEnt, NumVol, MedioP, Cotizacion');
		SoloBlock('MiProd, ReEmitirC');
		
		BValue('LetTex');
		$("#ReEmitirC").load("REmi.php");
		
	}
	
	if(P == 8){
		
		EnvAyuda('Cotizaciones disponibles.');
		
		SoloNone('ClientesFac, BotonesParaO, Loading, micapa1, Promo, MPromo, mostrar, EntraOpe, EntraOpeF, MedioP, ReEmitirC');
		SoloBlock('MiProd, Cotizacion');

		$("#Cotizacion").load("MCot.php");

	}
		
	if(P == 9){

		EnvAyuda('Retaurant.');
		$("#Restaurant").load("Restaurant_salon.php");
		SoloNone('ClientesFac, BotonesParaO, Loading, micapa1, Promo, MPromo, mostrar, EntraOpe, EntraOpeF, MedioP, ReEmitirC');
		SoloBlock('Restaurant');

		
				
	}
	
  }
  
  	if(P == 10){
		
		jConfirm("&iquest;Est\u00e1 seguro que desea salir del facturador?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
				$("#archivos").load("ComTic.php");
			}
		});

	}
  
}

function Desglose(){
	
	var tot = document.getElementById('total').value;
	if(tot != 0){
		
		document.getElementById("TerminarTic").value = 0;
			
		SoloNone('LetEnt, LetTer');	
		SoloBlock('Desglose, TiquetDesgloseVol');

		$("#TiquetComple").fadeOut(800);
		$("#DesgloseFon").fadeIn(500);
	
		$("#archivos").load("MFac.php");

		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="DesgloseVol();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolDes\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="LetVolDes"/></button>';
		
	}
}

function DesgloseVol(){
	
	document.getElementById("TerminarTic").value = 1;
	SoloNone('Desglose, TiquetDesgloseVol');
	SoloBlock('LetEnt, LetTer');
	
	$("#TiquetComple").fadeIn(800);
	$("#DesgloseFon").fadeOut(500);
	
	document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="ReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
		
}

function ClienteEv(){

	EnvAyuda('Ingrese nombre del cliente.');
			
	BValue('LetTex');
	
	document.getElementById("DondeE").value = "nombreevef";
	document.getElementById("CantiE").value = "22";
	document.getElementById("QuePoE").value = "0";
		
	$("#mostrar").load("FCli.php");
	
}

function CanProLis(){
	
	var tot = document.getElementById("total").value;
	if(tot != 0){
		SoloNone("ElProd, Promo, MPromo, MiProd");	
	}else{
		SoloNone("LetTer, ElProd, Promo, MPromo, MiProd");
	}
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$('#LetTex').focus();
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="AccBotFac(10);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSal\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSal"/></button>';
				
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
		
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function TraerTotalFPA(){

	var CANTARJETAS = dec(document.getElementById("CANTARJETAS").value.replace(",","."),2);
	var CANCHEQUES = dec(document.getElementById("CANCHEQUES").value.replace(",","."),2);
	var CANEFECTIVO = dec(document.getElementById("CANEFECTIVO").value.replace(",","."),2);
	var CANBONO = dec(document.getElementById("CANBONO").value.replace(",","."),2);

var TotFPA = parseFloat(CANTARJETAS) + parseFloat(CANCHEQUES) + parseFloat(CANEFECTIVO) + parseFloat(CANBONO);

return TotFPA;

}

function GrabarFPAs(){
	
	$('#formfpafpa').submit();

}

function nuevatarjeta(){
	
	var imp = document.getElementById("APagar").value;
	var impmin = document.getElementById("PAR_MINTSH_FAC").value;
	
	if((imp == 0) || (imp <= impmin)){
		
		jAlert('Debe ingresar un importe mayor al minimo.', 'Aukon - Global Business Solution');
		
	}else{
	
		SoloNone("Desglose");
		SoloBlock("NuevaFormaPago");
	
		$("#DesgloseFon").fadeOut(800);
	
		$("#NuevaFormaPago").load("TarAgr.php?se=d");
		
	}
	
}

function Ter_nuevatarjeta(){
	
	EnvAyuda('Ingrese importe de pago y un medio de pago.');
	
	SoloNone("LetTer, LetEnt, NumVol");
	
	var APagar = dec(document.getElementById("APagar").value.replace(",","."),2);
	var total = dec(parseFloat(document.getElementById("total").value.replace(",",".")),2);	
	var CANTARJETAS = dec(parseFloat(document.getElementById("CANTARJETAS").value.replace(",",".")),2);
	
	var actual = dec(TraerTotalFPA());
	
	if(actual == '0.00'){ actual = 0; }
	
	var Pagado = dec(parseFloat(CANTARJETAS) + parseFloat(APagar),2);
	APagar = dec(parseFloat(actual) + parseFloat(APagar),2);

	total = parseFloat(total);
	APagar = parseFloat(APagar);

	if(total > APagar){
		
		resto = dec(parseFloat(total) - parseFloat(APagar),2);
		document.getElementById("APagar").value = resto;
		document.getElementById("CANTARJETAS").value = Pagado;

	}
	if(total <= APagar){

		document.getElementById("CANTARJETAS").value = Pagado;
		document.getElementById("PAG").value = dec(parseFloat(APagar));
		document.getElementById("APagar").value = "";

		///////////////////////////////////////////////////////
		GrabarFPAs(); /////////////////////////////////////////	
		///////////////////////////////////////////////////////

	}	
	
	document.getElementById("DondeE").value = "APagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloNone("NuevaFormaPago");
	SoloBlock("Desglose");

	$("#DesgloseFon").fadeIn(800);

}

function nuevocheque(){
	
	var imp = document.getElementById("APagar").value;
	var impmin = document.getElementById("PAR_MINCSH_FAC").value;
	
	if((imp == 0) || (imp <= impmin)){
		
		jAlert('Debe ingresar un importe mayor al minimo.', 'Aukon - Global Business Solution');
		
	}else{
			
		SoloNone("Desglose");
		SoloBlock("NuevaFormaPago");
	
		$("#DesgloseFon").fadeOut(800);
	
		$("#NuevaFormaPago").load("Cheques.php?se=d");
		
	}
	
}

function Ter_nuevocheque(){

	EnvAyuda('Ingrese importe de pago y un medio de pago.');
	
	SoloNone("LetTer, LetEnt, NumVol");
	
	var APagar = dec(document.getElementById("APagar").value.replace(",","."),2);
	var total = dec(parseFloat(document.getElementById("total").value.replace(",",".")),2);	
	var CANCHEQUES = dec(parseFloat(document.getElementById("CANCHEQUES").value.replace(",",".")),2);
	
	var actual = dec(TraerTotalFPA());
	
	if(actual == '0.00'){ actual = 0; }
	
	var Pagado = dec(parseFloat(CANCHEQUES) + parseFloat(APagar),2);
	APagar = dec(parseFloat(actual) + parseFloat(APagar),2);

	total = parseFloat(total);
	APagar = parseFloat(APagar);

	if(total > APagar){
		
		resto = dec(parseFloat(total) - parseFloat(APagar),2);
		document.getElementById("APagar").value = resto;
		document.getElementById("CANCHEQUES").value = Pagado;

	}
	if(total <= APagar){

		document.getElementById("CANCHEQUES").value = Pagado;
		document.getElementById("PAG").value = dec(parseFloat(APagar));
		document.getElementById("APagar").value = "";

		///////////////////////////////////////////////////////
		GrabarFPAs(); /////////////////////////////////////////	
		///////////////////////////////////////////////////////

	}	
	
	document.getElementById("DondeE").value = "APagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloNone("NuevaFormaPago");
	SoloBlock("Desglose");

	$("#DesgloseFon").fadeIn(800);

}

function IngEfectivo(){

	var APagar = dec(document.getElementById("APagar").value.replace(",","."),2);
	var total = dec(parseFloat(document.getElementById("total").value.replace(",",".")),2);	
	var CANEFECTIVO = dec(parseFloat(document.getElementById("CANEFECTIVO").value.replace(",",".")),2);
	
	var actual = dec(TraerTotalFPA());
	
	if(actual == '0.00'){ actual = 0; }
	
	var Pagado = dec(parseFloat(CANEFECTIVO) + parseFloat(APagar),2);
	APagar = dec(parseFloat(actual) + parseFloat(APagar),2);

	total = parseFloat(total);
	APagar = parseFloat(APagar);

	var resto = 0;
	var tengo = 0;
	
	if(total > APagar){
		
		resto = dec(parseFloat(total) - parseFloat(APagar),2);
		document.getElementById("APagar").value = resto;
		document.getElementById("CANEFECTIVO").value = Pagado;
		
	}
	if(total <= APagar){
		
		document.getElementById("CANEFECTIVO").value = Pagado;
		document.getElementById("PAG").value = dec(parseFloat(APagar));
		document.getElementById("APagar").value = "";	
		
		///////////////////////////////////////////////////////
		GrabarFPAs(); /////////////////////////////////////////	
		///////////////////////////////////////////////////////
		
	}	
	
	document.getElementById("DondeE").value = "APagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
			
}

function IngBonos(){

	SoloNone("Desglose, LetEnt, LetTer, NumVol");
	SoloBlock("NuevaFormaPago, bloquerfactur");

	$("#DesgloseFon").fadeOut(800);
	
	var im = dec(document.getElementById("APagar").value.replace(",","."),2);
	$("#NuevaFormaPago").load("Bonos.php?se=d&im="+im);
	
	SoloBlock("NumVol");
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Vol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolBonos\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolBonos"/></button>';

}

function Ter_IngBonos(){
	
	SoloNone("NuevaFormaPago, bloquerfactur, LetTer");
	
	document.getElementById("CANBONO").value = 0;

	var dCANBONOCALL = dec(parseFloat(document.getElementById("dCANBONOCALL").value.replace(",",".")),2);
	document.getElementById("APagar").value = dCANBONOCALL;
	var APagar = dec(document.getElementById("APagar").value.replace(",","."),2);
	var total = dec(parseFloat(document.getElementById("total").value.replace(",",".")),2);	

	var actual = dec(TraerTotalFPA());
	
	if(actual == '0.00'){ actual = 0; }
	
	var Pagado = dec(parseFloat(dCANBONOCALL));
	APagar = dec(parseFloat(actual) + parseFloat(APagar),2);

	total = parseFloat(total);
	APagar = parseFloat(APagar);

	var resto = 0;
	var tengo = 0;
	
	if(total > APagar){
		
		resto = dec(parseFloat(total) - parseFloat(APagar),2);
		document.getElementById("APagar").value = resto;
		document.getElementById("CANBONO").value = Pagado;
		
	}
	if(total <= APagar){
		
		document.getElementById("CANBONO").value = Pagado;
		document.getElementById("PAG").value = dec(parseFloat(APagar));
		document.getElementById("APagar").value = "";
		
		///////////////////////////////////////////////////////
		GrabarFPAs(); /////////////////////////////////////////	
		///////////////////////////////////////////////////////
		
	}	
	
	document.getElementById("DondeE").value = "APagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloBlock("Desglose");

	$("#DesgloseFon").fadeIn(800);
		
}

function Vol_Fpa(){

	EnvAyuda('Ingrese importe de pago. Enter para todo efectivo.');
	
	$("#DesgloseFon").fadeIn(800);
	$("#Desglose").fadeIn(800);

	document.getElementById("DondeE").value = "APagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
			
	SoloNone("NuevaFormaPago, LetEnt, LetTer, NumVol, bloquerfactur");

}


////////////////////////////////////////////////////////////////////////////////////////////////////////
function sacarformapago(){

	$("#DesgloseFon").fadeIn(800);
	$("#Desglose").fadeIn(800);

	document.getElementById("DondeE").value = "PAG";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda('Ingrese importe de pago. Enter para todo efectivo.');
		
	SoloNone("NuevaFormaPago");

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="confvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="cancvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="confvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';

}

function Enviar_XEnterPag(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		confvuel();
	}
	
}

function ControlPagVol(){

	var k = window.event.keyCode;
	if(k == 27){
		cancvuel();
	}
	
}

function Enviar_XEnterApagar(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	
}

function ControlDeEnvioLetTexPres(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 32) || (k == 42) || (k == 209) || (k == 241) || (k == 43) || (k == 44) || ((k >= 46) && (k <= 57)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	
}

function ControlDeEnvioLetTexDown(){

	var k = window.event.keyCode;
	if(k ==113){
		if(document.getElementById('can_item').value > 0){
			TerminarVul();			
		}		
	}
		
}


////	FRANCO - MINUTOS CONTINUOS
function Reloj(){ 

	var fecha = new Date(); 
	var hora = fecha.getHours(); 
	var minutos = fecha.getMinutes(); 
	var segundos = fecha.getSeconds(); 
	
	if (minutos<=9) 
		minutos = "0" + minutos; 
	
	if (segundos <= 9) 
		segundos = "0" + segundos; 
	
	document.getElementById("reloj").innerHTML = hora + ":" + minutos + ":" + segundos; 
	
	setTimeout("Reloj()",1000); 
} 

onload = Reloj(); 
