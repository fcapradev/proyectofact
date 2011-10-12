// JavaScript Document

var tim = 800;

function MaFX1(cs,ca){

var cli = document.getElementById("MaCLI").value;
document.getElementById('Mamostrar').innerHTML = "";
$("#Mamicapa1").load("MaControl.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1");
	
	$("#Mamicapa1").fadeIn(tim);
	$("#Mamostrar").fadeOut(tim);
	$("#Matoda_la_bus").fadeOut(tim);

}

function MaFX2(cs,ca){

var cli = document.getElementById("MaCLI").value;

$("#Mamicapa1").load("MaControl.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1&fpp=1");
	
	$("#Mamicapa1").fadeIn(tim);
	$("#Mamostrar").fadeOut(tim);
	$("#Matoda_la_bus").fadeOut(tim);
		
}

function MaFX3(cs,ca){
	
var cli = document.getElementById("MaCLI").value;

$("#Mamicapa1").load("MaControl.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1&fpp=1&upd=");
	
	$("#Mamicapa1").fadeIn(tim);
	$("#Mamostrar").fadeOut(tim);
	$("#Matoda_la_bus").fadeOut(tim);
	
}

function MaReeCodigo(){

	var control = document.getElementById('LetTex').value.length;
	var cb = document.getElementById('LetTex').value;
	var cadena = cb.charAt(0);
	
	if (control == 0){ document.getElementById('LetTex').value = ""; return false; }
	if (cb == 0){ document.getElementById('LetTex').value = ""; return false; }
	
		if (/^([0-9])*$/.test(cadena)){  
			
			document.getElementById('Mamicapa1').innerHTML = "";
			document.getElementById('Mamostrar').innerHTML = "";
			document.getElementById('LetTex').value = "";
			SoloBlock("MaMiProd, MaLoading");
			
			var cli = document.getElementById("MaCLI").value;
			
			$("#Mamicapa1").load("MaControl.php?ca=1&cb="+cb+"&cli="+cli);
			$("#Mamicapa1").fadeIn(tim);
			
		}
		
		cb = cb.toLowerCase();
		if (/[a-z,ñ\s]/.test(cb)){
		
			var buscar = cb.indexOf("+");
			if(buscar == -1){ 
				
				document.getElementById('Mamicapa1').innerHTML = "";
				document.getElementById('Mamostrar').innerHTML = "";	
				document.getElementById('LetTex').value = "";
				
				SoloBlock("MaMiProd, MaLoading");
				
				cb_env = ReplaceAll(cb," ","+");
				$("#Mamostrar").load("MaBusqueda.php?l_env="+cb_env);
				
				$("#Mamostrar").fadeIn(tim);
				$("#Mamicapa1").fadeOut(tim);
				$("#Matoda_la_bus").fadeOut(tim);
				
			}

		}	
	
	return false;
	
}


/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/********************************** COMINEZO DE FUNCIONES DE INSERCION DE ITEMS *****************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/

var Mac = 0;
var Mas = 1;
var MaN = 0;

function MaNuevoIXCodigoB(cs,ca,cp,cc,cd){

var comenzar = document.getElementById('MaComenzarTic').value;
var totalesm = document.getElementById('Matotal').value;

if(totalesm == 0){
	document.getElementById('MaTiquetItem').innerHTML = "";
}
if(comenzar == 0){
	Mac = 0;
	Mas = 1;
	MaN = 0;
	document.getElementById('MaComenzarTic').value = 1;
}


document.getElementById('LetTex').value = "";	
var cant = document.getElementById('Macan_item').value;
document.getElementById('Macan_item').value = parseFloat(cant) + 1;

$("#LetTex").focus();
	

  MaN = MaN + 1;
  Mac = Mac + 1;
	
	if(Mac == 1){
			
		$("#MaTiquetItem").append("<div id=\"Macapasitems"+Mas+"\" style=\"display: block;\">");
					
		if(Mas != 1){

			$("#Macapasitems"+Mas).append("<div id=\"MaAnt_Pro_Ti_D"+Mas+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:-2px;\"><button class=\"StyBoton\" onclick=\"return movpaga_t("+Mas+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Ant_Pro_Ti','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"Ant_Pro_Ti\"/></button></div>");
			
			Manp = Mas - 1;
			$("#Macapasitems"+Manp).fadeOut(tim);
			$("#Macapasitems"+Mas).fadeIn(tim);
			
			$("#Macapasitems"+Manp).append("<div id=\"MaAba_Pro_Ti_D"+Manp+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:221px;\"><button class=\"StyBoton\" onclick=\"return movpag_t("+Manp+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Aba_Pro_Ti','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"Aba_Pro_Ti\"/></button></div>");
			
		}

	}

	EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");
	
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$("#LetTex").focus();
	
	SoloNone("LetEnt, LetTer, NumVol");
	SoloBlock("MaTiquet");
	
	$("#MaFacTotal").fadeIn(500);

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2tt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2tt"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt22\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt22"/></button>';
	
	
	var st = parseFloat(cp) * parseFloat(cc);
	var t = (parseFloat(cp) * parseFloat(cc)) + parseFloat(document.getElementById('Matotal').value);
	var t = Math.round(t*100)/100
	var t = t.toFixed(2);
	var cl = document.getElementById('MaCLI').value;

	///////////// cortar el detalle y quitar caracteres especiales
	cd = cd.substring(0,30);
		
	document.getElementById('Matotal').value = t;


if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	SoloBlock("LetEnt, LetTer, NumVol");
	return false;
	
}

	
csi = parseInt(cs,10);
cai = parseInt(ca,10);
	
	var Mamodcli = document.getElementById('Mamodcli').value;
	if(Mamodcli == 0){
		$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl+"&por=1");
	}

$("#Macapasitems"+Mas).append("<div id=\"fmaitems_s"+MaN+"\" style=\"cursor:pointer;\" onclick=\"return Maenviar_item("+cs+","+ca+","+MaN+");\"><table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"MaSEC"+MaN+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"MaART"+MaN+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaPUN"+MaN+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaCAN"+MaN+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaSUB"+MaN+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"MaDES"+MaN+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");
	
	SoloBlock("LetEnt, LetTer, NumVol");

	if (Mac == 8){
		
		Mac = 0; 
        Mas = Mas + 1;
		
	}


}


/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/


function MaNUU(cs,ca,cp,cd){

var comenzar = document.getElementById('MaComenzarTic').value;
var totalesm = document.getElementById('Matotal').value;

if(totalesm == 0){
	document.getElementById('MaTiquetItem').innerHTML = "";
}
if(comenzar == 0){
	Mac = 0;
	Mas = 1;
	MaN = 0;
	document.getElementById('MaComenzarTic').value = "1";
}


/////////////////////////////////////////////////////////
////////////Fabian Para el cancelar /////////////////////
/////////////////////////////////////////////////////////
	SoloBlock("LetTer");
			
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFacm\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFacm"/></button>';


var cant = document.getElementById('Macan_item').value;
document.getElementById('Macan_item').value = parseFloat(cant) + 1;
var cc = document.getElementById('NumTex').value;
var valoro = document.getElementById('NumTex').value;
document.getElementById('NumTex').value = "";
$("#LetTex").focus();


MaN = MaN + 1;
Mac = Mac + 1;


	if(Mac == 1){
			
		$("#MaTiquetItem").append("<div id=\"Macapasitems"+Mas+"\" style=\"display:block;\">");
					
		if(Mas != 1){

			$("#Macapasitems"+Mas).append("<div id=\"MaAnt_Pro_Ti_D"+Mas+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:-1px;\"><button class=\"StyBoton\" onclick=\"return movpaga_t("+Mas+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Ant_Pro_Ti','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"Ant_Pro_Ti\"/></button></div>");
			
			Manp = Mas - 1;
			$("#Macapasitems"+Manp).fadeOut(tim);
			$("#Macapasitems"+Mas).fadeIn(tim);
			
			$("#Macapasitems"+Manp).append("<div id=\"MaAba_Pro_Ti_D"+Manp+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:221px;\"><button class=\"StyBoton\" onclick=\"return movpag_t("+Manp+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Aba_Pro_Ti','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"Aba_Pro_Ti\"/></button></div>");
			
		}

	}

	
    valor = parseInt(valoro)
	
	if (valor == 0){
	
		jAlert("La cantidad debe ser mayor a 0");
		EnvAyuda("La cantidad debe ser mayor a 0");
		
	}else{
		
		if(valoro == ""){
				
				EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");
				
				document.getElementById('LetTex').value = "";
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "50";
				document.getElementById("QuePoE").value = "0";
				
				$("#LetTex").focus();
				
				SoloNone("LetEnt, LetTer, NumVol");
				SoloBlock("MaTiquet");

				$("#MaFacTotal").fadeIn(500);
				
				document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt2" class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2tt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2tt"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button id="BotLetEnt2" class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2tt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2tt"/></button>';

				var cc = 1;
				var st = parseFloat(cp) * parseFloat(cc);
				var t = (parseFloat(cp) * parseFloat(cc)) + parseFloat(document.getElementById('Matotal').value);
				var t = Math.round(t*100)/100
				var t = t.toFixed(2)	
				
				///////////// cortar el detalle y quitar caracteres especiales
				cd = cd.substring(0,30);
	
				var cl = document.getElementById('MaCLI').value;
				
				SoloBlock("LetTer");
				

if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	document.getElementById('Matotal').value = "";
	SoloBlock("LetEnt, LetTer, NumVol");
	return false;
	
}


csi = parseInt(cs,10);
cai = parseInt(ca,10);

	$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl);

$("#Macapasitems"+Mas).append("<div id=\"fmaitems_s"+MaN+"\" style=\"cursor:pointer;\" onclick=\"return Maenviar_item("+cs+","+ca+","+MaN+");\"><table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"MaSEC"+MaN+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"MaART"+MaN+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaPUN"+MaN+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaCAN"+MaN+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaSUB"+MaN+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"MaDES"+MaN+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");

			document.getElementById('Matotal').value = t;		
			SoloBlock("LetEnt, LetTer, NumVol");

		}else{

			if (isNaN(valor)) {
					
				jAlert("Debe ingresar n\u00fameros","Foca Software");
				EnvAyuda("Debe ingresar n&uacute;meros");
				
			}else{
				
				EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");
				
				document.getElementById('LetTex').value = "";
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "50";
				document.getElementById("QuePoE").value = "0";
				
				$("#LetTex").focus();
				
				var cl = document.getElementById('MaCLI').value;

				SoloNone("LetEnt, LetTer, NumVol");
				SoloBlock("MaTiquet");
				document.getElementById("MaTiquet").style.display="block";
	
				$("#LetTex").focus();
				$("#MaFacTotal").fadeIn(500);
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2tt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2tt"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt22\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt22"/></button>';
	
				cc = validarEntero(cc)
				cc = parseInt(cc,10);				
				var st = parseFloat(cp) * parseFloat(cc);
				var t = st + parseFloat(document.getElementById('Matotal').value);
				var t = Math.round(t*100)/100
				var t = t.toFixed(2)	
				
				///////////// cortar el detalle y quitar caracteres especiales
				cd = cd.substring(0,30);
				
				SoloBlock("LetTer");

//es por codigo de articulo

if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	SoloBlock("LetEnt, LetTer, NumVol");
	return false;
}


csi = parseInt(cs,10);
cai = parseInt(ca,10);
	
	$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl);

$("#Macapasitems"+Mas).append("<div id=\"fmaitems_s"+MaN+"\" style=\"cursor:pointer;\" onclick=\"return Maenviar_item("+cs+","+ca+","+MaN+");\"><table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"MaSEC"+MaN+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"MaART"+MaN+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaPUN"+MaN+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaCAN"+MaN+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"MaSUB"+MaN+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"MaDES"+MaN+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");
				
				document.getElementById('Matotal').value = t;			
				SoloBlock("LetEnt, LetTer, NumVol");
				
			}
			
		}

	}

	if (Mac == 8){
				
		Mac = 0; 
        Mas = Mas + 1;
		
	}

return false;

}

/************************************************************************************************************************************************/
/********************************** FIN DE FUNCIONES DE INSERCION DE ITEMS **********************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/

function MaEnvError(h){

	document.getElementById('ErrorConex').innerHTML = "";
	document.getElementById('ErrorConex').innerHTML = "<table width='100%' height='300'><tr><td valign='middle' align='center'>"+h+"</td></tr></table>";
	SoloBlock('ErrorConex');

}

function MaEnvAyuda(h){

	if (h == "Ocultar"){
		
		document.getElementById('CarAyudaFon').style.display="none";
		document.getElementById('CarAyuda').style.display="none";
		
	}else{

		document.getElementById('CarAyuda').innerHTML = "";
		document.getElementById('CarAyuda').innerHTML = h;

		document.getElementById('CarAyudaFon').style.display="block";
		document.getElementById('CarAyuda').style.display="block";	
	
		if (h == "No Existe el producto selecionado."){
			SoloNone('MaMiProd, MaLoading');
		}
		
	}

}

function MaComenzarFacError(){
	
	EnvAyuda('Error de grabacion reintente la operacion...');
	Mos_Ocu('LetSal');
	Mos_Ocu('LetEnt');
	Mos_Ocu('LetTer');
	Mos_Ocu('NumVol');
	
	SoloNone('Bloquear');
	
}

function MaIniciarFac(){
	
	clearTimeout(timerIDD);
	
	$("#MaMonedas").load("MMon.php?tot=0");
		
	Mos_Ocu('MaMiProd');
	Mos_Ocu('MaTiquet');
	Mos_Ocu('MaFacTotal');
	SoloNone('MaMedioP, MaCotizacion');
	
	document.getElementById('Mamostrar').innerHTML = '';
	document.getElementById('Mamicapa1').innerHTML = '';
	document.getElementById('MaTiquetItem').innerHTML = '';
	
	document.getElementById('MaComenzarTic').value = 0;
	document.getElementById('Matotal').value = "0.00";
	document.getElementById('MaVUL').value = "";
	document.getElementById('MaPAG').value = "";
	
	Macancvuel()
	
	SoloBlock("LetSal, LetEnt, NumVol");
	SoloNone("LetTer");
	
	////////////////////////////////////////////////////////////////////////////////////////
	/////////////////  PARA FORMAS DE PAGO /////////////////////////////////////////////////
	document.getElementById('MaAPagar').value = 0;
	document.getElementById("MaCANTARJETAS").value = 0;
	document.getElementById("MaCANCHEQUES").value = 0;
	document.getElementById("MaCANEFECTIVO").value = 0;
	document.getElementById("MaCANBONO").value = 0;
	
	$('#MaTotalesApagar').attr({
		'style': 'left:287px;'
	});
	
	SoloNone("MaMultipleFormaPago, Mabloquerfactur");
	
	document.getElementById('MaPAG').value = "";
	document.getElementById('MaVUL').value = "";
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
}

function MaComenzarFac(){

	$("#archivos").load("NTic.php");
	timerIDD = setTimeout("MaIniciarFac()", 2000);
	
}

function MaTerminarFac(){
	
	var Macan_item = document.getElementById('Macan_item').value;
	if(Macan_item >= 0){	
	
		EnvAyuda('Guardando Comprobante aguarde por favor...');
		
		SoloNone("LetSal, LetEnt, LetTer, NumVol");
		
		document.getElementById('Bloquear').style.display="block";
		
		var suc = document.getElementById('EDat7Ma1').value;
		var tip = document.getElementById('EDat7Ma2').value;
		var tco = document.getElementById('EDat7Ma3').value;
		var nco = document.getElementById('EDat7Ma4').value;
		
		var pag = document.getElementById('MaPAG').value;
		$("#archivos").load("NFac.php?pag="+pag+"&tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco);
		
	}
	
}

function Maconfvuel(){
	
	var pag = document.getElementById('MaPAG').value;
	var tot = document.getElementById('Matotal').value;
	
	if(pag == tot){
		var cc = 1;
	}else{
		var cc = document.getElementById('MaPAG').value;
	}
	
	if(pag == 0){
		var cc = 1;
		pag = tot;
	}
	
	if (/^([0-9+\,])*$/.test(cc)){
	
		if(tot == 0){
		
			document.getElementById('MaPAG').value = ""; 
			document.getElementById('MaVUL').value = "";
			
		}else{
							
			var p = parseFloat(pag.replace(",","."));
			var t = parseFloat(tot);
			
			if(p >= t){	
							
				if(p == 0.00){
				
					document.getElementById('MaPAG').value = "";
					document.getElementById('MaVUL').value = "";
					 
				}else{
									
					document.getElementById('MaPAG').value = dec(p);
					document.getElementById('Matotal').value = dec(t);
					
					if(p >= t){
						
						$("#LetTex").focus();
						var tt = p - t;
						document.getElementById('MaVUL').value = dec(tt);
						MaTerminarFac();
						$("#LetTex").focus();
						
					}
					
				}	
				
			}else{					

				////////////////////////////////////////////////////////////////////////////////////////
				/////////////////  PARA FORMAS DE PAGO /////////////////////////////////////////////////
				document.getElementById('MaAPagar').value = dec(document.getElementById('MaPAG').value.replace(",","."),2);
	
				$('#MaTotalesApagar').attr({
					'style': 'left:8px;'
				});
				
				EnvAyuda('Ingrese importe de pago y un medio de pago.');
				
				document.getElementById("DondeE").value = "MaAPagar";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
	
				SoloNone("LetEnt, NumVol");
				SoloBlock("MaMultipleFormaPago");
	
				document.getElementById('MaPAG').value = "";
				document.getElementById('MaVUL').value = "";
				
				var totparaenv = document.getElementById('Matotal').value;
				////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////

			}
	
	
		}
		
	
	}
	
	
}

function Macancvuel(){
	
	document.getElementById('MaTerminarTic').value = 1;
	
	EnvAyuda('Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.');
	
	document.getElementById('LetTex').value = "";
	
	$("#EstFormComprobanteDiv").css("border-color", "transparent");
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2Fac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2Fac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2FacV\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2FacV"/></button>';
	
	SoloNone('MaDesglose, MaVuelto2, Bloquear, MaComprobanteFon, MaComprobante');
	
	$("#MaTiquetComple").fadeIn(1000);
	$("#MaVuelto1").fadeOut(1000);
	$("#MaDesgloseFon").fadeOut(500);
	
	$("#LetTex").focus();
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function MaTerminarVul(){//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById("MaClientesFac").style.display="none";
	
	$("#archivos").load("MaMFac.php");

	EnvAyuda('Ingrese sucursal del comprobante.');
	
	document.getElementById("EDat7Ma1").value = "";
	document.getElementById("EDat7Ma4").value = "";

	$("#EstFormComprobanteDiv").css("border-color", "#F90");
	
	document.getElementById("DondeE").value = "EDat7Ma1";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntSucMa1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntSucMa1"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="Macancvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFacMavol\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetCanFacMavol"/></button>';
	
	document.getElementById('MaTOTO').value = document.getElementById('Matotal').value;
	document.getElementById('MaTerminarTic').value = 0;
	
	SoloBlock('MaDesglose, MaComprobanteFon, MaComprobante, LetTer');

	$("#MaTiquetComple").fadeOut(800);
	$("#MaDesgloseFon").fadeIn(500);

	$("#EDat7Ma1").focus();	
}

function Mamovpaga_t(p){
	
	np = p - 1;
	$("#Macapasitems"+p).fadeOut(tim);
	$("#Macapasitems"+np).fadeIn(tim);
	
return false;

}

function Mamovpag_t(p){

	np = p + 1;	
	$("#Macapasitems"+p).fadeOut(tim);
	$("#Macapasitems"+np).fadeIn(tim);
	
return false;

}

function Maenviar_item(cs,ca,itemm){

	SoloNone('MaClientesFac, MaBotonesParaO, MaEntraOpe, MaEntraOpeF, MaReEmitirC, MaMedioP, MaCotizacion');

	document.getElementById('Mamicapa1').innerHTML = '';

	var cli = document.getElementById("MaCLI").value;
	$("#Mamicapa1").load("MaControl.php?cb=0&cs="+cs+"&ca="+ca+"&itemm="+itemm+"&cli="+cli);
	$("#Mamicapa1").fadeIn(tim);
	$("#Mamostrar").fadeOut(tim);
	$("#Matoda_la_bus").fadeOut(tim);
	
	document.getElementById('NumTex').value = "";
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$("#LetTex").focus();
	
	document.getElementById('Mamostrar').innerHTML = '';
	
return false;
}

function Mamovpagatr(p){

	np = p - 1;
	document.getElementById('capa_tr'+p).style.display="none";	
	document.getElementById('capa_tr'+np).style.display="block";

return false;

}
function Mamovpagtr(p){

	np = p + 1;
	document.getElementById('capa_tr'+p).style.display="none";	
	document.getElementById('capa_tr'+np).style.display="block";

return false;

}

function MaCacelar_Pro(){
	
	///error
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$("#LetTex").focus();

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';
			
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac2"/></button>';
			
}

$(document).ready(function(){
    $('#FormVolverFac').submit(function() {
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
})

function TecladoCom(){
	
	Mos_Ocu('fondotranspletras');
	Mos_Ocu('TecladoLet');
	Mos_Ocu('fondotranspnumeros'); 
	Mos_Ocu('TecladoNum');
	Mos_Ocu('NumTexDiv');
	Mos_Ocu('NumAre');
	
}






/****************************************************************************************************************/
function ErrorTiposF(id){
	document.getElementById(id).value = "";
	jAlert('El campo ingresado no es correcto.', 'Debo Retail - Global Business Solution');
}
/****************************************************************************************************************/

function MaSucursal(){

	var t = document.getElementById('EDat7Ma1').value;

	if(t.length != 0){
		
		$("#archivos").load("ControlManual.php?suc="+t);
						
	}else{

		$("#archivos").load("ControlManual.php?suc=777777");
	}

}

function MaVolNumNco(){

	EnvAyuda('Ingrese sucursal del comprobante.');
	
	document.getElementById("EDat7Ma1").value = "";
	document.getElementById("EDat7Ma4").value = "";
	
	$("#EDat7Ma4Div").css("border-color", "transparent");
	$("#EstFormComprobanteDiv").css("border-color", "#F90");
	
	document.getElementById("DondeE").value = "EDat7Ma1";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	SoloBlock("LetEnt, LetTer, NumVol");

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntSucMa1\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntSucMa1"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="Macancvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFacMavol\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetCanFacMavol"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntSucMa2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntSucMa2"/></button>';
	
	$("#EDat7Ma1").focus();
	
}

function MaNumeroNco(){

var t = document.getElementById('EDat7Ma4').value;
	if (/^([0-9])*$/.test(t)){	
		if(t != 0){
			if(t.length != 0){
		
				var cod = str_pad(t, 8, '0', 'STR_PAD_LEFT');
				document.getElementById("EDat7Ma4").value = cod;
				$('#Bloquear').fadeIn(500);
				
				$("#EDat7Ma4Div").css("border-color", "transparent");
		
				$('#MaComprobanteForm').submit();
					
			}else{
				ErrorTiposF("EDat7Ma4");
			}
		}else{
			ErrorTiposF("EDat7Ma4");
		}
	}else{
		ErrorTiposF("EDat7Ma4");
	}

}

function VolNdcom(){
	
	EnvAyuda('Ingrese número de comprobante.');
	
	document.getElementById('EDat7Ma4').value = "";
		
	document.getElementById("DondeE").value = "EDat7Ma4";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaNumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaVolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" boder="0" id="LeVolCom"/></button>';
	
}

function ContinuarCarga(){

	$("#MaVuelto1").fadeIn(500);
	$("#MaVuelto2").fadeIn(500);

	SoloNone('MaComprobanteFon, MaComprobante');
	
	document.getElementById("DondeE").value = "MaPAG";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda('Ingrese importe de pago. Enter para todo efectivo.');

	SoloBlock("LetEnt");

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="Maconfvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="Macancvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFac\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar" border="0" id="LetCanFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="Maconfvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac"/></button>';

	$("#MaPAG").focus();

}

function ContinuarCargaFPA(){

	SoloNone("MaComprobanteFon, MaComprobante, LetEnt, LetTer, NumVol");
	SoloBlock("MaVuelto1, MaVuelto2");
	Maconfvuel();

}