// JavaScript Document

$(document).ready(function(){
    $('#MaComprobanteForm').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#archivos').html(data);
            }
        })        
        return false;
    });
	$('#Maformfpafpa').submit(function(){
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

function MaEnviarForm(con){
	return false;
} 	

function MaAccBotFac(P){

if(document.getElementById("MaTerminarTic").value == 1){
	
	if(P == 1){
		
		EnvAyuda('Ingrese código de barras o realice una búsqueda.');
		
		SoloNone('MaClientesFac, MaBotonesParaO, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaMiProd, MaCotizacion');
		SoloBlock('MaMiProd, MaLoading, LetEnt, NumVol');
		
		document.getElementById("LetTex").value = "";
		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "50";
		document.getElementById("QuePoE").value = "0";

		BValue('LetTex');
		
		$("#LetTex").focus();		
		$("#Mamostrar").load("MaBusqueda.php?l_env=77codigooculto77");
		$("#LetTex").focus();
		$("#Mamostrar").fadeIn(tim);
		$("#Mamicapa1").fadeOut(tim);
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt2Fac" onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="BotLetTer2Fac" onclick="MaTerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2Fac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2Fac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac2"/></button>';
		
		if(document.getElementById('Macan_item').value > 0){
			SoloBlock("LetTer");
		}else{
			SoloNone("LetTer");
		}
				
	}
	if(P == 2){
		
		EnvAyuda('Ingrese datos para busqueda de cliente.');
				
		SoloNone('MaMiProd, MaLoading, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaMiProd, MaCotizacion');
		SoloBlock('MaClientesFac, MaBotonesParaO, LetEnt, NumVol');
		
		BValue('LetTex');
		
		$("#LetTex").focus();		
		$("#Mamostrar").load("MaMCli.php?co=1");
		
		$("#Mamostrar").fadeIn(tim);
		$("#MaMiProd").fadeIn(tim);
		$("#Mamicapa1").fadeOut(tim);

		document.getElementById("DondeE").value = "LetTex";
		document.getElementById("CantiE").value = "50";
		document.getElementById("QuePoE").value = "0";
	
	}
	if(P == 3){
		
	var tot = document.getElementById('Matotal').value;
		if(tot != 0){
		
		document.getElementById("MaMedioP").value = "";
			
		EnvAyuda('Seleccione medio de pago.');
		
		SoloNone('MaClientesFac, MaBotonesParaO, MaMiProd, MaLoading, Mamicapa1, MaPromo, MMaPromo, Mamostrar, MaReEmitirC, MaEntraOpe, MaEntraOpeF, MaCotizacion');
			
		SoloBlock('MaMedioP, MaMiProd');
			
		$("#MaMedioP").load("MaMMed.php");
			
		}
		
	}
	if(P == 4){

		EnvAyuda('Selecione producto.');
		
		SoloNone('MaClientesFac, MaBotonesParaO, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaMiProd, MaCotizacion');
		SoloBlock('LetEnt, NumVol');
		
		BValue('LetTex');
		
		$("#LetTex").focus();		
		$("#Mamostrar").load("MaTeclasRapidas.php");
		$("#Mamostrar").fadeIn(tim);
		$("#MaMiProd").fadeIn(tim);
		$("#Mamicapa1").fadeOut(tim);
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt2Fac" onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="BotLetTer2Fac" onclick="MaTerminarVul();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2Fac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2Fac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolFac" onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac2"/></button>';

	}
	if(P == 6){
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt2Ope" onclick="MaEntradaCod();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Ope\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Ope"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button id="BotLetTer2Ope" onclick="MaTerminarOpe();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2Ope\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2Ope"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="BotLetVolOpe" onclick="MaEntradaCod();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Ope2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Ope2"/></button>';
	
		SoloNone('MaClientesFac, MaBotonesParaO, MaMiProd, MaLoading, Mamicapa1, MaPromo, MMaPromo, Mamostrar, MaReEmitirC, MaMedioP, MaMiProd, MaCotizacion');
		SoloBlock('MaEntraOpe, MaEntraOpeF, LetEnt, NumVol');
		$("#MaEntraOpe").load("MaFOpe.php");

	}
	if(P == 7){
		
		EnvAyuda('Seleccione el comprobante que desea re emitir.');
		SoloNone('MaClientesFac, MaBotonesParaO, MaLoading, Mamicapa1, MaPromo, MMaPromo, Mamostrar, MaEntraOpe, MaEntraOpeF, LetTer, LetEnt, NumVol, MaMedioP, MaCotizacion');
		SoloBlock('MaMiProd, MaReEmitirC');
		BValue('LetTex');
		$("#MaReEmitirC").load("MaREmi.php");
		
	}
	if(P == 8){
		
		EnvAyuda('Cotizaciones disponibles.');
		SoloNone('MaClientesFac, MaBotonesParaO, MaLoading, Mamicapa1, MaPromo, MMaPromo, Mamostrar, MaEntraOpe, MaEntraOpeF, MaMedioP, MaReEmitirC');
		SoloBlock('MaMiProd, MaCotizacion');

		$("#MaCotizacion").load("MaMCot.php");
		
	}
	if(P == 9){
		
		//////////////////////////////////////////////////
		EscrCookies(); ///////////////////////////////////
		//////////////////////////////////////////////////
		
		$('#TecladoNum').attr({
		   'style': 'top:-4px',
		}); 
		
		$('#NumVol').attr({
		   'style': 'left:625px; display:block;'
		});
		
		SoloNone("FacturadorMa, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyudaFon, CarAyuda, BotMins1, NumAre, NumTexDiv");
		SoloBlock("BotonesPri, Marca, ProcesoSusp, ProcesoSusp2");
		
		$("#SobreFoca").fadeIn(400);
		
	}
	
  }
  
  	if(P == 10){

		jConfirm("&iquest;Est\u00e1 seguro que desea salir del facturador manual?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
				$("#archivos").load("MaComTic.php");
			}
		});

	}
  
}

function MaDesglose(){

	var tot = document.getElementById('Matotal').value;
	if(tot != 0){

		SoloNone('LetEnt, LetTer');
		SoloBlock('MaDesglose, MaTiquetDesgloseVol');

		$("#MaTiquetComple").fadeOut(800);
		$("#MaDesgloseFon").fadeIn(500);
	
		$("#archivos").load("MaMFac.php");

		document.getElementById('NumVol').innerHTML = '<button onclick="MaDesgloseVol();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolDes\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="LetVolDes"/></button>';
		
	}
}

function MaDesgloseVol(){

	SoloNone('MaDesglose, MaTiquetDesgloseVol');
	SoloBlock('LetEnt, LetTer');
	
	$("#MaTiquetComple").fadeIn(800);
	$("#MaDesgloseFon").fadeOut(500);
	
	document.getElementById('NumVol').innerHTML = '<button onclick="MaReeCodigo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac2"/></button>';
	
}

function MaClienteEv(){

	EnvAyuda('Ingrese nombre del cliente.');
			
	BValue('LetTex');
	
	document.getElementById("DondeE").value = "nombreevef";
	document.getElementById("CantiE").value = "22";
	document.getElementById("QuePoE").value = "0";
		
	$("#Mamostrar").load("MaFCli.php");
	
}

function MaCanProLis(){

	var tot = document.getElementById("Matotal").value;
	if(tot != 0){
		SoloNone("MaElProd, MaPromo, MMaPromo");	
	}else{
		SoloNone("LetTer, MaElProd, MaPromo, MMaPromo");
	}
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById("LetTex").value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$("#LetTex").focus();
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="MaAccBotFac(10);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalFacmama\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalFacmama"/></button>';
				
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
		
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
		
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function MaTraerTotalFPA(){

	var MaCANTARJETAS = dec(document.getElementById("MaCANTARJETAS").value.replace(",","."),2);
	var MaCANCHEQUES = dec(document.getElementById("MaCANCHEQUES").value.replace(",","."),2);
	var MaCANEFECTIVO = dec(document.getElementById("MaCANEFECTIVO").value.replace(",","."),2);
	var MaCANBONO = dec(document.getElementById("MaCANBONO").value.replace(",","."),2);

var MaTotFPA = parseFloat(MaCANTARJETAS) + parseFloat(MaCANCHEQUES) + parseFloat(MaCANEFECTIVO) + parseFloat(MaCANBONO);

return MaTotFPA;

}

function MaGrabarFPAs(){
	
	$('#Maformfpafpa').submit();

}

function Manuevatarjeta(){
	
	var Maimp = document.getElementById("MaAPagar").value;
	var Maimpmin = document.getElementById("MaPAR_MINTSH_FAC").value;
	
	if((Maimp == 0) || (Maimp <= Maimpmin)){
		
		jAlert('Debe ingresar un importe mayor al minimo.', 'Aukon - Global Business Solution');
		
	}else{
	
		SoloNone("MaDesglose");
		SoloBlock("MaNuevaFormaPago");
	
		$("#MaDesgloseFon").fadeOut(800);
	
		$("#MaNuevaFormaPago").load("TarAgr.php?se=e");
		
	}
	
}

function MaTer_nuevatarjeta(){
	
	EnvAyuda('Ingrese importe de pago y un medio de pago.');
	
	SoloNone("LetTer, LetEnt, NumVol");
	
	var MaAPagar = dec(document.getElementById("MaAPagar").value.replace(",","."),2);
	var Matotal = dec(parseFloat(document.getElementById("Matotal").value.replace(",",".")),2);	
	var MaCANTARJETAS = dec(parseFloat(document.getElementById("MaCANTARJETAS").value.replace(",",".")),2);
	
	var Maactual = dec(MaTraerTotalFPA());
	
	if(Maactual == '0.00'){ Maactual = 0; }
	
	var MaPagado = dec(parseFloat(MaCANTARJETAS) + parseFloat(MaAPagar),2);
	MaAPagar = dec(parseFloat(Maactual) + parseFloat(MaAPagar),2);

	Matotal = parseFloat(Matotal);
	MaAPagar = parseFloat(MaAPagar);

	if(Matotal > MaAPagar){
		
		Maresto = dec(parseFloat(Matotal) - parseFloat(MaAPagar),2);
		document.getElementById("MaAPagar").value = Maresto;
		document.getElementById("MaCANTARJETAS").value = MaPagado;

	}
	if(Matotal <= MaAPagar){

		document.getElementById("MaCANTARJETAS").value = MaPagado;
		document.getElementById("MaPAG").value = dec(parseFloat(MaAPagar));
		document.getElementById("MaAPagar").value = "";

		///////////////////////////////////////////////////////
		MaGrabarFPAs(); ///////////////////////////////////////
		///////////////////////////////////////////////////////

	}	
	
	document.getElementById("DondeE").value = "MaAPagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloNone("MaNuevaFormaPago");
	SoloBlock("MaDesglose");

	$("#MaDesgloseFon").fadeIn(800);

}

function Manuevocheque(){
	
	var Maimp = document.getElementById("MaAPagar").value;
	var Maimpmin = document.getElementById("MaPAR_MINCSH_FAC").value;
	
	if((Maimp == 0) || (Maimp <= Maimpmin)){
		
		jAlert('Debe ingresar un importe mayor al minimo.', 'Aukon - Global Business Solution');
		
	}else{
			
		SoloNone("MaDesglose");
		SoloBlock("MaNuevaFormaPago");
	
		$("#MaDesgloseFon").fadeOut(800);
	
		$("#MaNuevaFormaPago").load("Cheques.php?se=e");
		
	}
	
}

function MaTer_nuevocheque(){

	EnvAyuda('Ingrese importe de pago y un medio de pago.');
	
	SoloNone("LetTer, LetEnt, NumVol");
	
	var MaAPagar = dec(document.getElementById("MaAPagar").value.replace(",","."),2);
	var Matotal = dec(parseFloat(document.getElementById("Matotal").value.replace(",",".")),2);	
	var MaCANCHEQUES = dec(parseFloat(document.getElementById("MaCANCHEQUES").value.replace(",",".")),2);
	
	var Maactual = dec(MaTraerTotalFPA());
	
	if(Maactual == '0.00'){ Maactual = 0; }
	
	var MaPagado = dec(parseFloat(MaCANCHEQUES) + parseFloat(MaAPagar),2);
	MaAPagar = dec(parseFloat(Maactual) + parseFloat(MaAPagar),2);

	Matotal = parseFloat(Matotal);
	MaAPagar = parseFloat(MaAPagar);

	if(Matotal > MaAPagar){
		
		Maresto = dec(parseFloat(Matotal) - parseFloat(MaAPagar),2);
		document.getElementById("MaAPagar").value = Maresto;
		document.getElementById("MaCANCHEQUES").value = MaPagado;

	}
	if(Matotal <= MaAPagar){

		document.getElementById("MaCANCHEQUES").value = MaPagado;
		document.getElementById("MaPAG").value = dec(parseFloat(MaAPagar));
		document.getElementById("MaAPagar").value = "";

		///////////////////////////////////////////////////////
		MaGrabarFPAs(); ///////////////////////////////////////	
		///////////////////////////////////////////////////////

	}	
	
	document.getElementById("DondeE").value = "MaAPagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloNone("MaNuevaFormaPago");
	SoloBlock("MaDesglose");

	$("#MaDesgloseFon").fadeIn(800);

}

function MaIngEfectivo(){

	var MaAPagar = dec(document.getElementById("MaAPagar").value.replace(",","."),2);
	var Matotal = dec(parseFloat(document.getElementById("Matotal").value.replace(",",".")),2);	
	var MaCANEFECTIVO = dec(parseFloat(document.getElementById("MaCANEFECTIVO").value.replace(",",".")),2);
	
	var Maactual = dec(MaTraerTotalFPA());
	
	if(Maactual == '0.00'){ Maactual = 0; }
	
	var MaPagado = dec(parseFloat(MaCANEFECTIVO) + parseFloat(MaAPagar),2);
	MaAPagar = dec(parseFloat(Maactual) + parseFloat(MaAPagar),2);

	Matotal = parseFloat(Matotal);
	MaAPagar = parseFloat(MaAPagar);

	var Maresto = 0;
	var Matengo = 0;
	
	if(Matotal > MaAPagar){
		
		Maresto = dec(parseFloat(Matotal) - parseFloat(MaAPagar),2);
		document.getElementById("MaAPagar").value = Maresto;
		document.getElementById("MaCANEFECTIVO").value = MaPagado;
		
	}
	if(Matotal <= MaAPagar){
		
		document.getElementById("MaCANEFECTIVO").value = MaPagado;
		document.getElementById("MaPAG").value = dec(parseFloat(MaAPagar));
		document.getElementById("MaAPagar").value = "";	
		
		///////////////////////////////////////////////////////
		MaGrabarFPAs(); ///////////////////////////////////////	
		///////////////////////////////////////////////////////
		
	}	
	
	document.getElementById("DondeE").value = "MaAPagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
			
}

function MaIngBonos(){

	SoloNone("MaDesglose, LetEnt, LetTer, NumVol");
	SoloBlock("MaNuevaFormaPago, Mabloquerfactur");

	$("#MaDesgloseFon").fadeOut(800);
	
	var Maim = dec(document.getElementById("MaAPagar").value.replace(",","."),2);
	$("#MaNuevaFormaPago").load("Bonos.php?se=e&im="+Maim);
	
	SoloBlock("NumVol");
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaVol_Fpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetNumVolBonos\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetNumVolBonos"/></button>';

}

function MaTer_IngBonos(){
	
	SoloNone("MaNuevaFormaPago, Mabloquerfactur, LetTer");
	
	document.getElementById("MaCANBONO").value = 0;

	var eCANBONOCALL = dec(parseFloat(document.getElementById("eCANBONOCALL").value.replace(",",".")),2);
	document.getElementById("MaAPagar").value = eCANBONOCALL;
	var MaAPagar = dec(document.getElementById("MaAPagar").value.replace(",","."),2);
	var Matotal = dec(parseFloat(document.getElementById("Matotal").value.replace(",",".")),2);	

	var Maactual = dec(MaTraerTotalFPA());
	
	if(Maactual == '0.00'){ Maactual = 0; }
	
	var MaPagado = dec(parseFloat(eCANBONOCALL));
	MaAPagar = dec(parseFloat(Maactual) + parseFloat(MaAPagar),2);

	Matotal = parseFloat(Matotal);
	MaAPagar = parseFloat(MaAPagar);

	var Maresto = 0;
	var Matengo = 0;
	
	if(Matotal > MaAPagar){
		
		Maresto = dec(parseFloat(Matotal) - parseFloat(MaAPagar),2);
		document.getElementById("MaAPagar").value = Maresto;
		document.getElementById("MaCANBONO").value = MaPagado;
		
	}
	if(Matotal <= MaAPagar){
		
		document.getElementById("MaCANBONO").value = MaPagado;
		document.getElementById("MaPAG").value = dec(parseFloat(MaAPagar));
		document.getElementById("MaAPagar").value = "";
		
		///////////////////////////////////////////////////////
		MaGrabarFPAs(); ///////////////////////////////////////
		///////////////////////////////////////////////////////
		
	}	
	
	document.getElementById("DondeE").value = "MaAPagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	SoloBlock("MaDesglose");

	$("#MaDesgloseFon").fadeIn(800);
		
}

function MaVol_Fpa(){

	EnvAyuda('Ingrese importe de pago. Enter para todo efectivo.');
	
	$("#MaDesgloseFon").fadeIn(800);
	$("#MaDesglose").fadeIn(800);

	document.getElementById("DondeE").value = "MaAPagar";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
			
	SoloNone("MaNuevaFormaPago, LetEnt, LetTer, NumVol, Mabloquerfactur");

}

function ControlEDat7Ma1(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		MaSucursal();
	}
		
}

function ControlEDat7Ma1Vol(){

	var k = window.event.keyCode;
	if(k == 27){
		Macancvuel();
	}
	
}

function ControlEDat7Ma4(){

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		MaNumeroNco();
	}
	
}

function ControlEDat7Ma4Vol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		MaVolNumNco();
	}
	if(k == 113){
		if(document.getElementById('EDat7Ma4').value.length == 8){
			ContinuarCarga();
		}
	}
	
}

function ControlMaPAG(){

	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		Maconfvuel();
	}
	
}

function ControlMaPAGVol(){
	
	var k = window.event.keyCode;
	if(k == 27){
		Macancvuel();
		alert("cambiar");
	}
	
}

function MaControlDeEnvioLetTexPres(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 32) || (k == 42) || (k == 209) || (k == 241) || (k == 43) || (k == 44) || ((k >= 46) && (k <= 57)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
		
}

function MaControlDeEnvioLetTexDown(){
	
	var k = window.event.keyCode;
	if(k == 113){
		if(document.getElementById('Macan_item').value > 0){
			MaTerminarVul();			
		}		
	}
	
}