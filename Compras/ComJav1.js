// JavaScript Document
		
SoloNone('ComBotBusDiv, ComBotCueDiv, ComBotPieDiv, ComBotModDiv, ComBotEliDiv, EncabezadoLat, EncabezadoDLat');
		
//HABILITO EL READ ONLY PARA TODOS LOS INPUT
$("input").attr("readonly", "readonly");
$("input").css("outline-style", "none");
$("input").css("border-style", "none");

function ComenzarCompras(t){
	
	////	VARIABLES A REINICIAR	////
	pasarapie = 0;
	document.getElementById("Consulta").value = 0; 
	document.getElementById('ComenzarCom').value = 0;
	////////////////////////////////////
	
	var i=1;
	for(i=1;i<=18;i++){
		
		if(i<=6 && i>=3){
			document.getElementById('EDat'+i).value = "";
		}
		if(i<=6 && i>1){
			document.getElementById('EncLatI-'+i).value = "";	
		}
		if(i<=4){
			document.getElementById('EDat7_'+i).value = "";
		}		
		if(i>=8){
			document.getElementById('EDat'+i).value = "";
		}
		if(i<=11){
			document.getElementById('CDat'+i).value = "";
		}
		if(i<=14){
			document.getElementById('PDat'+i).value = "";
		}

		EnvAyuda('Ingrese proveedor. Enter para buscar.');
	}
	document.getElementById('EDat19').value = "";
	document.getElementById('EDat10Val').value = "";
	document.getElementById('CDat8-2').value = "";
	document.getElementById('CDat11-2').value = "";
	document.getElementById('PDat12-2').value = "";
	
	// borro itms //
	document.getElementById('CuerpoListaCI').innerHTML = '';
	
	SoloNone('LetTer, ComBotBusDiv, ComBotCueDiv, ComBotPieDiv, ComBotModDiv, ComBotEliDiv, EncabezadoLat, EncabezadoDLat');
	SoloBlock('LetEnt');

	document.getElementById("DondeE").value = "EDat3";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";	
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetSal').innerHTML = '<button onclick="SalirCompras();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalcomcom\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalcomcom"/></button>';


	var m = document.getElementById("ComenzarComV2").value;
	
	if(t == 1){
		if(m == 0){
			jAlert('La factura se guardo correctamnete.', 'Debo Retail - Global Business Solution');
		}else{
			jAlert('La factura se modifico correctamnete.', 'Debo Retail - Global Business Solution');
			document.getElementById("ComenzarCom").value = 0;
			document.getElementById("ComenzarComV2").value = 0;
			document.getElementById("ComenzarComPI").value = 0;
		}
	}	
	if(t == 2){
		jAlert('La factura se elimino correctamnete.', 'Debo Retail - Global Business Solution');
	}
	
	Mostrar_Encabezado();
	
	$('#Bloquear').fadeOut(500);

	//PONGO EN CERO TODO
	document.getElementById("Modifica").value = 0;		// PONE EN CERO EL MODIFICA
	document.getElementById("EDat19").value = 0;		// TIPO DE UNIDADES EN CERO
	document.getElementById("EDat10Val").value = 3;		// POR DEFECTO "CONTADO"

//	ACTUALIZO EL MODULO COMPRAS
	$("#Compras").load("Compras.php");

}
	
function SalirCompras(){
	
	jConfirm("&iquest;Est\u00e1 seguro que desea salir del facturador?", "Debo Retail - Global Business Solution", function(r){
	if(r == true ){
			$("#archivos").load("ConComTic.php");
		}
	});
	
}

function ImpreVolCom(){
	
	SoloNone('ImpresionPdfDiv');

}

/*****************************************************************************************************************************************************/
/*****************************************************************************************************************************************************/

function Mostrar_Busqueda(){

	SoloNone("ComBotEncDiv, ComBotCueDiv, ComBotPieDiv, ComBotModDiv, ComBotEliDiv, LetEnt, LetTer, CuerpoProdu, CuerpoProdu2, CuerpoProdu3, CuerpoProdu4, CuerpoProduTxt, CuerpoProdu5");
	SoloBlock("botonesdebusqueda");

	$("#CueDat2").css("border-color", "transparent");
	$("#CueDat5").css("border-color", "transparent");
	$("#CueDat6").css("border-color", "transparent");
	$("#CueDat8").css("border-color", "transparent");
		
}

function CodDebo(){
	
	SoloNone("CueDat1, botonesdebusqueda");
	SoloBlock("CueDat2, CueDat3, CueDat5, ComBotEncDiv, ComBotCueDiv, LetEnt, LetTer, CuerpoProdu4, CuerpoProduTxt");
	
	document.getElementById("CDat1").value = "";
	document.getElementById("CDat2").value = "";
	document.getElementById("CDat3").value = "";
	document.getElementById("CDat5").value = "";
	
	$("#CueDat2").css("border-color", "#F90");

	controlarcadainputcom("CDat2");
	
	EnvAyuda("Ingrese sucursal del articulo.");
	
	document.getElementById("DondeE").value = "CDat2";
	document.getElementById("CantiE").value = "2";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarsucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="enviararticulo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';
		
}

function CodBarra(){
		
	SoloNone("botonesdebusqueda, CueDat2, CueDat3, CueDat5");
	SoloBlock("CueDat1, ComBotEncDiv, ComBotCueDiv, LetEnt, CuerpoProdu, CuerpoProduTxt");
	
	document.getElementById("CDat1").value = "";
	document.getElementById("CDat2").value = "";
	document.getElementById("CDat3").value = "";
	document.getElementById("CDat5").value = "";
	
	$("#CueDat1").css("border-color", "#F90");
	
	EnvAyuda("Ingrese código de barras.");
		
	controlarcadainputcom("CDat1");
	document.getElementById("DondeE").value = "CDat1";
	document.getElementById("CantiE").value = "13";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarbarra();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

}

function CodOrigen(){
	
	SoloNone("botonesdebusqueda, CueDat2, CueDat3, CueDat5");
	SoloBlock("CueDat1, ComBotEncDiv, ComBotCueDiv, LetEnt, CuerpoProdu3, CuerpoProduTxt");
	
	document.getElementById("CDat1").value = "";
	document.getElementById("CDat2").value = "";
	document.getElementById("CDat3").value = "";
	document.getElementById("CDat5").value = "";
	
	$("#CueDat1").css("border-color", "#F90");	
	
	EnvAyuda("Ingrese código de origen.");
	
	controlarcadainputcom("CDat1");
	document.getElementById("DondeE").value = "CDat1";
	document.getElementById("CantiE").value = "15";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarorigen();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

}

function CodDetall(){
	
	SoloNone("CueDat1, botonesdebusqueda");
	SoloBlock("CueDat2, CueDat3, CueDat5, ComBotEncDiv, ComBotCueDiv, LetEnt, CuerpoProdu5, CuerpoProduTxt");

	$("#CueDat6").css("border-color", "#F90");
	
	EnvAyuda("Ingrese detalle del articulo.");
	
	document.getElementById("CDat1").value = "";
	document.getElementById("CDat2").value = "0";
	document.getElementById("CDat3").value = "0";
	document.getElementById("CDat5").value = "1";
	
	controlarcadainputcom("CDat6");
	document.getElementById("DondeE").value = "CDat6";
	document.getElementById("CantiE").value = "21";
	document.getElementById("QuePoE").value = "0";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviardetalle();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
}

function enviardetalle(){
	
	$("#CueDat6").css("border-color", "transparent");
	$("#CueDat10").css("border-color", "#F90");
	
	EnvAyuda("Ingrese subtotal.");
	
	controlarcadainputcom("CDat10");
	
	document.getElementById("DondeE").value = "CDat10";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarsubpordet();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
}

function enviarsubpordet(){
	
	var t = document.getElementById('CDat10').value;
	if (/^([0-9+\.])*$/.test(t)){
		if(t.length != 0){
			
			document.getElementById('CDat8').value = document.getElementById('CDat10').value;
			
			$("#CueDat10").css("border-color", "transparent");
			
			EnvAyuda("Continuar para confirmar la carga del item.");
			
			controlarcadainputcom("CDatCalcSub");
			
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="confirmarI();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCont\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetCont"/></button>';
			
			SoloNone("LetEnt");
			SoloBlock("LetTer");
		
		}
	}
}

/*****************************************************************************************************************************************************/
/*****************************************************************************************************************************************************/
function Mostrar_Encabezado(){
	
	$("div").css("border-color", "transparent");
	$("#EncDat3").css("border-color", "#F90");

	SoloNone('EncabezadoLat, EncabezadoDLat, Cuerpo, CuerpoDat, LetTer, Pie, PieDat, ComBotBusDiv, ComBotModDiv, ComBotEliDiv, BusquedaCodOrigen');	
	SoloBlock('ComBotEncDiv, Encabezado, EncabezadoDat, ComprasDfon');
	
	EnvAyuda('Ingrese proveedor. Enter para buscar.');
	
	$("#EDat3").removeAttr("readonly");
	$('#EDat3').focus();

	document.getElementById("DondeE").value = "EDat3";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById("Consulta").value = 1;	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
}

function Mostrar_Cuerpo(){
	
	//	EL IF BLOQUEA EL AGREGADO DE ITEMS HASTA QUE NO SE CARGUEN TODOS LOS COSTOS DEL REMITO
	if(document.getElementById("permiso").value == 1){
		
		jAlert('Ingrese Todos los Costos para agregar un nuevo Item.', 'Debo Retail - Global Business Solution');
		
	}else{
	
		//document.getElementById('LetTer').innerHTML = '';
			
		SoloNone('Encabezado, EncabezadoDat, ComprasDfon, CueDat2, CueDat3, CueDat4, CueDat4-2, CueDat5, CuerpoLista2, Pie, PieDat, BusquedaCodOrigen, BusquedaCodDebo');
		
		SoloNone("CuerpoProdu, CuerpoProdu2, CuerpoProdu4, CuerpoProdu5"); // SACO LAS 3 BUSQUEDAS
		
		SoloBlock('EncabezadoLat, EncabezadoDLat, ComBotBusDiv, ComBotEncDiv, ComBotCueDiv, Cuerpo, CuerpoDat, CuerpoLista, CueDat1, LetEnt, LetTer, CuerpoProdu3, CuerpoProduTxt');
		
		document.getElementById('CDat1').value = "";
		document.getElementById('CDat2').value = "";
		document.getElementById('CDat3').value = "";
		document.getElementById('CDat4').value = "";
		document.getElementById('CDat5').value = "";
		document.getElementById('CDat6').value = "";
		document.getElementById('CDat7').value = "";
		document.getElementById('CDat8').value = "";
		document.getElementById('CDat8-2').value = "";
		document.getElementById('CDat9').value = "";
		document.getElementById('CDat10').value = "";
		document.getElementById('CDat11').value = "";
		document.getElementById('CDat11-2').value = "";
				
		$("#CueDat1").css("border-color", "#F90");
		
		controlarcadainputcom("CDat1");
		
		EnvAyuda("Ingrese código de origen.");
			
		document.getElementById("DondeE").value = "CDat1";
		document.getElementById("CantiE").value = "15";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="enviarorigen();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	}
}

function Mostrar_Pie(){

	SoloNone('Encabezado, EncabezadoDat, Cuerpo, CuerpoDat, ComBotModDiv, ComBotEliDiv');
	SoloBlock('EncabezadoLat, EncabezadoDLat, ComBotPieDiv, ComprasDfon, Pie, PieDat, LetEnt');

	var tip = document.getElementById('EDat7_2').value;
	
	$("div").css("border-color", "transparent");
	
	if(tip == "C" || tip == "R" || tip == "M"){

		SoloNone('LetTer');

		$("#PieDat14").css("border-color", "#F90");
			
		EnvAyuda("Ingrese Total.");
			
		document.getElementById("DondeE").value = "PDat14";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
			
		SoloBlock('LetEnt');
			
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarXRE();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';		
		
	}else{
		
		$("div").css("border-color", "transparent");
		$("#PieDat1").css("border-color", "#F90");

		EnvAyuda("Ingrese Neto Grabado.");

		document.getElementById("DondeE").value = "PDat1";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ValidarDP(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	}
	
	EnvCuerpo();

}

function TarModFacItm(ccs,cca,cN){

	$('#Bloquear').fadeIn(500);
	
	$("#archivos").load("Control2.php?xd=2&cs="+ccs+"&ca="+cca+"&cn="+cN);
	document.getElementById('ComenzarComPI').value = cN;

	SoloNone('ComBotModDiv, ComBotEliDiv');

}

function TarEliFacItm(ccs,cca,ccc){

	//fabian vallejo
	$('#Bloquear').fadeIn(500);

	$("#archivos").load("ECArt.php?ccc="+ccc);
	
	SoloNone('ComBotModDiv, ComBotEliDiv');

}

function enviar_fac_com_com(){

	$('#Bloquear').fadeIn(500);	
	var tip = document.getElementById("EDat7_2").value;
	var tco = document.getElementById("EDat7_3").value;
	var suc = document.getElementById("EDat7_1").value;
	var nco = document.getElementById("EDat7_4").value;
	var cod = document.getElementById("EDat3").value;
	$("#archivos").load("TFCompra.php?tar=0&tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
	
}

function MosPro(){

	var pro = document.getElementById('EDat3').value;
	$("#archivos").load("RCombCom.php?a=1&ord=1&pro="+pro);
				
}

function MosFpa(){

	var fpa = document.getElementById('EDat5').value;
	$("#archivos").load("RCombCom.php?a=2&fpa="+fpa);
	
}

function MeterTip(mp){
	
var lik = document.getElementById('LetTex').value;
$("#Tipo"+mp).removeClass("SinTilde").addClass("ConTilde");
$("#Tipo"+mp).addClass("Sombra14");

if(mp == 5){

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolProvEventual();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveNom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	SoloNone("LetTer, ComDatos, ComDatosFon, ComDatosFor");
	SoloBlock("ComDatosEventualFon, ComDatosEventual, NumVol");
	
	$("#Eve1").css("border-color", "#F90");
	
	EnvAyuda('Ingrese nombre del proveedor.');

	document.getElementById("DondeE").value = "Eventual1";
	document.getElementById("CantiE").value = "25";
	document.getElementById("QuePoE").value = "0";
	
}else{
	
	SoloBlock("LetEnt, ComDatos, ComDatosFon, ComDatosFor");
	SoloNone("ComDatosEventualFon, ComDatosEventual, NumVol");
	
	$("#ComDatos").load("CombPro.php?a=1&lik="+lik+"&ord="+mp);
}

	for (i=1; i<=5; i++){
		
		if(i != mp){
			$("#Tipo"+i).removeClass("ConTilde").addClass("SinTilde");
			$("#Tipo"+i).removeClass("Sombra14");
		}

	}

}

function ProEveNom(){

	var t = document.getElementById('Eventual1').value;
	if(t.length > 5){
		
		$("#Eve1").css("border-color", "transparent");
		$("#Eve2").css("border-color", "#F90");
		
		EnvAyuda("Ingrese dirección del proveedor.");

		document.getElementById("DondeE").value = "Eventual2";
		document.getElementById("CantiE").value = "25";
		document.getElementById("QuePoE").value = "0";

		SoloBlock('LetEnt');

		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveDir();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		
	}
}

function ProEveDir(){

	var t = document.getElementById('Eventual2').value;
	if(t.length > 5){

		$("#Eve2").css("border-color", "transparent");
		$("#Eve3").css("border-color", "#F90");

		EnvAyuda("Ingrese cuit del proveedor.");

		document.getElementById("DondeE").value = "Eventual3";
		document.getElementById("CantiE").value = "11";
		document.getElementById("QuePoE").value = "1";

		SoloBlock('LetEnt');

		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveCuit();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
	}

}

function ProEveCuit(){
	
var cu = document.getElementById('Eventual3').value;

var t = CPcuitValido(cu);
	
	if(t == true){

		$("#Eve3").css("border-color", "transparent");
		$("#Eve4").css("border-color", "#F90");
			
		EnvAyuda("Ingrese forma de pago del proveedor. Solo Contado. ");
			
		document.getElementById("Eventual4").value = 1;
			
		document.getElementById("DondeE").value = "Eventual4";
		document.getElementById("CantiE").value = "2";
		document.getElementById("QuePoE").value = "1";

		SoloBlock('LetEnt');

		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveFdp();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	}else{
		document.getElementById('cuitevef').value = ""; 
	}
		
}

function ProEveFdp(){

	var t = document.getElementById('Eventual4').value;
	if (/^([0-9+\.])*$/.test(t)){
		if(t.length != 0){
			if(t == 1){
				
				document.getElementById("Eventual5").value = "CONTADO";
				
				$("#Eve4").css("border-color", "transparent");
				$("#Eve6").css("border-color", "#F90");
				
				EnvAyuda("Ingrese tipo de iva del proveedor.");
	
				document.getElementById("DondeE").value = "Eventual6";
				document.getElementById("CantiE").value = "2";
				document.getElementById("QuePoE").value = "1";
	
				SoloBlock('LetEnt');
	
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ProEveIva();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

			}
		}
	}
}

function ProEveIva(){
	
	var iva = document.getElementById('Eventual6').value;
	if(iva.length != 0){
		$("#archivos").load("RCombCom.php?a=3&iva="+iva);
	}
}

function ConfEventual(){

	$('#Bloquear').fadeIn(500);
	$('#FormaPorEventual').submit();

}

function VolProvEventual(){
	
	$("div").css("border-color", "transparent");
	SoloBlock("LetEnt, LetTer, ComDatos, ComDatosFon, ComDatosFor");
	SoloNone("ComDatosEventualFon, ComDatosEventual");
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolCompras();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
}

function VolCompras(){
	
	SoloNone('EncabezadoLat, EncabezadoDLat, Proveedores, ProveedoresDat');
	SoloBlock('ComprasDfon, Encabezado, EncabezadoDat, ComBotEncDiv');

	$("#EncDat3").css("border-color", "#F90");
		
	EnvAyuda('Ingrese proveedor. Enter para buscar.');

	document.getElementById("DondeE").value = "EDat3";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";
	
	controlarcadainputcom("EDat3");	

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
}

function MeterTipo(v){
		
	var lik = document.getElementById('LetTex').value;
	
	if(v == 1){
		$("#ComBotza").removeClass("Sombra5");
		$("#ComBotaz").addClass("Sombra5");
		$("#ComDatos").load("CombPro.php?lik="+lik+"&tor=1");
	}
	if(v == 2){
		$("#ComBotaz").removeClass("Sombra5");
		$("#ComBotza").addClass("Sombra5");		
		$("#ComDatos").load("CombPro.php?lik="+lik+"&tor=2");
	}
	if(v == 3){
		$("#ComBotcc").removeClass("Sombra5");
		$("#ComBotab").addClass("Sombra5");
		$("#ComDatos").load("CombPro.php?lik="+lik+"&abc=1");
	}
	if(v == 4){				
		$("#ComBotab").removeClass("Sombra5");
		$("#ComBotcc").addClass("Sombra5");
		$("#ComDatos").load("CombPro.php?lik="+lik+"&abc=2");
	}
	
}

function VolProv(){

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosPro();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	SoloNone('NumVol, LetTer');

//	document.getElementById("EDat3").value = "";
	document.getElementById("EDat4").value = "";
	document.getElementById("EDat5").value = "";
	document.getElementById("EDat7_2").value = "";

	$("#EncDat5").css("border-color", "transparent");
	$("#EncDat3").css("border-color", "#F90");
		
	EnvAyuda('Ingrese proveedor. Enter para buscar.');

	document.getElementById("DondeE").value = "EDat3";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";
	
	controlarcadainputcom("EDat3");

}

function VolFdpago(){

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosFpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolProv();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
	document.getElementById("EDat5").value = "";
	document.getElementById("EDat6").value = "";
	document.getElementById("EDat7_1").value = "";
	
	$("#EncDat7-1").css("border-color", "transparent");
	$("#EncDat5").css("border-color", "#F90");
		
	EnvAyuda('Ingrese forma de pago. Enter para buscar.');
	
	document.getElementById('EncDat771').innerHTML = '<img src="Compras/com.png" />';
	
	document.getElementById("DondeE").value = "EDat5";
	document.getElementById("CantiE").value = "5";
	document.getElementById("QuePoE").value = "1";

	controlarcadainputcom("EDat5");

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Sucursal(){

var t = document.getElementById('EDat7_1').value;
	if (/^([0-9])*$/.test(t)){	
		if(t.length != 0){
		
			var cod = str_pad(t, 4, '0', 'STR_PAD_LEFT');
			document.getElementById("EDat7_1").value = cod;
			document.getElementById("EncLatI-3").value = cod;
			
			$("#EncDat7-1").css("border-color", "transparent");
			$("#EncDat7-2").css("border-color", "#F90");
			
			EnvAyuda('Ingrese la letra del comprobante. Ej. A B C M R');
			
			document.getElementById("DondeE").value = "EDat7_2";
			document.getElementById("CantiE").value = "1";
			document.getElementById("QuePoE").value = "3";
		
			document.getElementById('EncDat771').innerHTML = '<img src="Compras/tco.png" />';
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FacturaC();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
			
			controlarcadainputcom("EDat7_2");
				
		}else{ document.getElementById('EDat7_1').value = ""; }
	}else{ document.getElementById('EDat7_1').value = ""; }
}

function VolSucursal(){

	EnvAyuda('Ingrese sucursal del comprobante.');
	
	$("#EncDat7-2").css("border-color", "transparent");
	$("#EncDat7-1").css("border-color", "#F90");

	document.getElementById('LetTex').value = "";
	document.getElementById('EDat7_1').value = "";
	document.getElementById('EDat7_2').value = "";
	
	document.getElementById("DondeE").value = "EDat7_1";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('EncDat771').innerHTML = '<img src="Compras/suc.png" />';
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="Sucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolFdpago();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';

	controlarcadainputcom("EDat7_1");

}

/****************************************************************************************************************/
function ErrorTiposF(id){
	document.getElementById(id).value = "";
	jAlert('El campo ingresado no es correcto.', 'Debo Retail - Global Business Solution');
}
/****************************************************************************************************************/

function FacturaC(){

	bandera = 0;
	var f = document.getElementById('EDat7_2').value;	
	
	if(f.length == 0){
		
		var ff = document.getElementById('EDat7_2_T').value;
		document.getElementById('EDat7_2').value = ff;
		f = ff;
		
	}
	
	if(f == "A"){

		$("#EncDat7-2").css("border-color", "transparent");
		$("#EncDat7-3").css("border-color", "#F90");		

		EnvAyuda('Ingrese tipo de comprobante. Ej. FT NC ND RE TI');
				
		document.getElementById("DondeE").value = "EDat7_3";
		document.getElementById("CantiE").value = "2";
		document.getElementById("QuePoE").value = "4";
		
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/tip.png" />';
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ComTipo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolTipo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
		
		bandera = 1;
		
		controlarcadainputcom("EDat7_3");
		
	}
	
	if(f == "B"){

		$("#EncDat7-2").css("border-color", "transparent");
		$("#EncDat7-3").css("border-color", "#F90");		

		EnvAyuda('Ingrese tipo de comprobante. Ej. FT NC ND RE TI');
		
		document.getElementById("DondeE").value = "EDat7_3";
		document.getElementById("CantiE").value = "2";
		document.getElementById("QuePoE").value = "4";
		
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/tip.png" />';
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ComTipo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolTipo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';

		bandera = 1;
		
		controlarcadainputcom("EDat7_3");
		
	}
	
	if(f == "C"){

		$("#EncDat7-2").css("border-color", "transparent");
		$("#EncDat7-4").css("border-color", "#F90");		

		document.getElementById('EDat7_3').value = "FT";
		
		EnvAyuda('Ingrese número del comprobante.');

		document.getElementById("DondeE").value = "EDat7_4";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/nco.png" />';
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
		
		bandera = 1;
		
		controlarcadainputcom("EDat7_4");

	}
	
	if(f == "M"){

		$("#EncDat7-2").css("border-color", "transparent");
		$("#EncDat7-4").css("border-color", "#F90");		

		document.getElementById('EDat7_3').value = "FT";
		
		EnvAyuda('Ingrese número del comprobante.');
		
		document.getElementById("DondeE").value = "EDat7_4";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/nco.png" />';
		
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
		
		bandera = 1;
		
		controlarcadainputcom("EDat7_4");
		
	}
	
	if(f == "R"){

		var tipo = document.getElementById('EDat5').value;

		if(tipo == 1){
			
			jAlert('No se puede cargar un Remito con Forma de Pago Contado.', 'Debo Retail - Global Business Solution');
			bandera = 1;
			
		}else{

			$("#EncDat7-2").css("border-color", "transparent");
			$("#EncDat7-4").css("border-color", "#F90");		
	
			document.getElementById('EDat7_3').value = "RE";
			
			EnvAyuda('Ingrese número del comprobante.');
			
			document.getElementById("DondeE").value = "EDat7_4";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('EncDat771').innerHTML = '<img src="Compras/nco.png" />';
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
			
			bandera = 1;
			
			controlarcadainputcom("EDat7_4");
			
		}
		
	}

	if(bandera == 0){
		ErrorTiposF("EDat7_2");
	}
	
}

function ComTipo(){

var f = document.getElementById('EDat7_2').value;
var tco = document.getElementById('EDat7_3').value;

	if(f == "A"){
		
		if(tco.length == 0){
			tco = "FT";
			document.getElementById('EDat7_3').value = "FT";
		}
		if(tco == "FT" || tco == "NC" || tco == "ND"){
		
			//document.getElementById('EDat7_4').value = "";

			$("#EncDat7-3").css("border-color", "transparent");
			$("#EncDat7-4").css("border-color", "#F90");	
			
			EnvAyuda('Ingrese número del comprobante.');
			
			document.getElementById("DondeE").value = "EDat7_4";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('EncDat771').innerHTML = '<img src="Compras/nco.png" />';
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
			
			controlarcadainputcom("EDat7_4");
			
		}else{
			ErrorTiposF("EDat7_3");

		}

	} 
	
	if(f == "B"){

		if(tco.length == 0){
			tco = "FT";
			document.getElementById('EDat7_3').value = "FT";
		}

		if(tco == "FT" || tco == "TI" || tco == "CI"){
		
			//document.getElementById('EDat7_4').value = "";

			$("#EncDat7-3").css("border-color", "transparent");
			$("#EncDat7-4").css("border-color", "#F90");	

			EnvAyuda('Ingrese número del comprobante.');
			
			document.getElementById("DondeE").value = "EDat7_4";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
			
			document.getElementById('EncDat771').innerHTML = '<img src="Compras/nco.png" />';
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
			
			controlarcadainputcom("EDat7_4");
			
		}else{
			if(tco == ""){
				document.getElementById('EDat7_3').value = "FT";
			}else{
				ErrorTiposF("EDat7_3");
			}
		}
	}
}

function VolTipo(){

	EnvAyuda('Ingrese letra del comprobante. Ej: A B C M R');
	
	$("#EncDat7-3").css("border-color", "transparent");
	$("#EncDat7-2").css("border-color", "#F90");

	document.getElementById('EDat7_2').value = "";
	document.getElementById('EDat7_3').value = "";
		
	document.getElementById("DondeE").value = "EDat7_2";
	document.getElementById("CantiE").value = "1";
	document.getElementById("QuePoE").value = "3";
	
	document.getElementById('EncDat771').innerHTML = '<img src="Compras/tco.png" />';
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FacturaC();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
	controlarcadainputcom("EDat7_2");
	
}

function VolNumNco(){

	$("#EncDat7-4").css("border-color", "transparent");
	$("#EncDat7-2").css("border-color", "#F90");
	
	EnvAyuda('Ingrese letra del comprobante. Ej: A B C M R');

	document.getElementById('EDat7_2').value = "";
	document.getElementById('EDat7_3').value = "";
	//document.getElementById('EDat7_4').value = "";
		
	document.getElementById("DondeE").value = "EDat7_2";
	document.getElementById("CantiE").value = "1";
	document.getElementById("QuePoE").value = "3";
	
	document.getElementById('EncDat771').innerHTML = '<img src="Compras/tip.png" />';
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FacturaC();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolSucursal();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
	
	controlarcadainputcom("EDat7_2");
	
}

function NumeroNco(){

var t = document.getElementById('EDat7_4').value;
	if (/^([0-9])*$/.test(t)){	
		if(t != 0){
			if(t.length != 0){
		
				var cod = str_pad(t, 8, '0', 'STR_PAD_LEFT');
				document.getElementById("EDat7_4").value = cod;
				
				////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////
				var com_fac_l = document.getElementById("EDat7_2").value;
				var com_fac_t = document.getElementById("EDat7_3").value;
				document.getElementById("EncLatI-4").value = com_fac_l+" - "+com_fac_t;
				
				document.getElementById("EncLatI-5").value = cod;
				var habmod = document.getElementById("HabFunModCom").value;
				
				if(habmod==0){
					$('#Bloquear').fadeIn(500);	
					var tip = document.getElementById("EDat7_2").value;
					var tco = document.getElementById("EDat7_3").value;
					var suc = document.getElementById("EDat7_1").value;
					var nco = document.getElementById("EDat7_4").value;
					var cod = document.getElementById("EDat3").value;
					$("#archivos").load("TFCompra.php?tar=1&tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"&cod="+cod);
				}
				////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////
				
				SoloNone("LetTer");
				
				$("#EncDat7-4").css("border-color", "transparent");
				$("#EncDat8").css("border-color", "#F90");
				
				EnvAyuda('Ingrese fecha del comprobante.');
				document.getElementById('EncDat771').innerHTML = '<img src="Compras/com.png" />';

				//document.getElementById('EDat8').value = "";
					
				document.getElementById("DondeE").value = "EDat8";
				document.getElementById("CantiE").value = "10";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FechaFac();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNdcom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
				
				controlarcadainputcom("EDat8");
				
			}else{
				ErrorTiposF("EDat7_4");
			}
		}else{
			ErrorTiposF("EDat7_4");
		}
	}else{
		ErrorTiposF("EDat7_4");
	}

}

function VolNdcom(){
	
	var ban = document.getElementById("HabFunModCom").value;
	if(ban == 1){
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MosFpa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolProv();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LeVolCom"/></button>';
		
		document.getElementById("EDat5").value = "";
		document.getElementById("EDat6").value = "";

		$("#EncDat8").css("border-color", "transparent");
		$("#EncDat5").css("border-color", "#F90");
	
		EnvAyuda('Ingrese forma de pago. Enter para buscar.');
		
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/com.png" />';
		
		document.getElementById("DondeE").value = "EDat5";
		document.getElementById("CantiE").value = "5";
		document.getElementById("QuePoE").value = "1";	
		
		controlarcadainputcom("EDat5");
		
	}else{
	
		SoloBlock('LetTer');
	
		$("#EncDat8").css("border-color", "transparent");
		$("#EncDat7-4").css("border-color", "#F90");
		
		EnvAyuda('Ingrese número de comprobante.');
		document.getElementById('EncDat771').innerHTML = '<img src="Compras/com.png" />';
		
		//document.getElementById('EDat7_4').value = "";
		//document.getElementById('EDat8').value = "";
			
		document.getElementById("DondeE").value = "EDat7_4";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="NumeroNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNumNco();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" boder="0" id="LeVolCom"/></button>';
		
		controlarcadainputcom("EDat7_4");
		
	}
}

/****************************************************************************************************************/
function ErrorFecha(id){
	document.getElementById(id).value = "";
	jAlert('Debe ingresar una fecha correcta.', 'Debo Retail - Global Business Solution');
}
/****************************************************************************************************************/

function FechaFac(){
	
	var fecemision  = document.getElementById("EDat8").value.length;
	if(fecemision == 0){
	
		var now = new Date();
		var d = str_pad(now.getDate(), 2, '0', 'STR_PAD_LEFT');
		var m = str_pad(now.getMonth() + 1, 2, '0', 'STR_PAD_LEFT');
		var y = now.getFullYear();
		var fecha = d+"/"+m+"/"+y;	
		document.getElementById("EDat8").value = fecha;
		
		/////////////////////////////////////////////////////////////////////////////////////
		y2 = String(y);
		var y2 = y2.substr(2);
		var fecha2 = d+"/"+m+"/"+y2;	
		document.getElementById("EncLatI-6").value = fecha2;
		/////////////////////////////////////////////////////////////////////////////////////

		$("#EncDat8").css("border-color", "transparent");
		$("#EncDat9").css("border-color", "#F90");
			
		EnvAyuda("Ingrese fecha P/Iva.");
		
		document.getElementById("DondeE").value = "EDat9";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="FechaPIva();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolFechaFac();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetEntChe"/></button>';
		
		controlarcadainputcom("EDat9");
		
	}else{
	if(fecemision != 10){
		ErrorFecha("EDat8");
	}else{
		
		var femis  = document.getElementById("EDat8").value;
		var arreglo_e = femis.split("/");
		var fecha_ya = new Date();
		var anio = fecha_ya.getFullYear();
	
		var edia  = arreglo_e[0].length;
		var emes  = arreglo_e[1].length;		
		var eanio  = arreglo_e[2].length;
	
		if(arreglo_e[0] > 31 || arreglo_e[1] > 12 || arreglo_e[2] > anio ){
			ErrorFecha("EDat8");
		}else{
			
			if(arreglo_e[0] > 28 & arreglo_e[1] == 2){
				ErrorFecha("EDat8");
			}else{
			
				if( edia == 2){
					if( emes == 2){
						if( eanio == 4){
							
							EnvAyuda("Ingrese fecha P/Iva.");
							
							$("#EncDat8").css("border-color", "transparent");
							$("#EncDat9").css("border-color", "#F90");

							document.getElementById("DondeE").value = "EDat9";
							document.getElementById("CantiE").value = "10";
							document.getElementById("QuePoE").value = "1";
							
							document.getElementById('LetEnt').innerHTML = '<button onclick="FechaPIva();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
							
							document.getElementById('NumVol').innerHTML = '<button onclick="VolFechaFac();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
							
							controlarcadainputcom("EDat9");

						}else{
							ErrorFecha("EDat8");
						}
					}else{
						ErrorFecha("EDat8");
					}
				}else{
					ErrorFecha("EDat8");
				}
			}
		}
	}
	}
}

function VolFechaFac(){

	$("#EncDat9").css("border-color", "transparent");
	$("#EncDat8").css("border-color", "#F90");

	EnvAyuda('Ingrese fecha del comprobante.');
	
	document.getElementById('EDat8').value = "";
	document.getElementById('EDat9').value = "";
		
	document.getElementById("DondeE").value = "EDat8";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FechaFac();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolNdcom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" boder="0" id="LeVolCom"/></button>';

	controlarcadainputcom("EDat8");

}

function FechaPIva(){
	
	var fecemision  = document.getElementById("EDat9").value.length;
	if(fecemision == 0){
	
		var now = new Date();
		var d = str_pad(now.getDate(), 2, '0', 'STR_PAD_LEFT');
		var m = str_pad(now.getMonth() + 1, 2, '0', 'STR_PAD_LEFT');
		var y = now.getFullYear();
		var fecha = d+"/"+m+"/"+y;	
		document.getElementById("EDat9").value = fecha;
		
		$("#EncDat9").css("border-color", "transparent");
		$("#EncDat13").css("border-color", "#F90");
		
		EnvAyuda("Ingrese fecha de vencimiento.");
		
		document.getElementById("DondeE").value = "EDat13";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="FechaVencim();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolFecPIva();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Vover" title="Volver" border="0" id="LetVolChe"/></button>';
		
		controlarcadainputcom("EDat13");
		
	}else{
		
	if(fecemision != 10){
		ErrorFecha("EDat9");
	}else{
		
		var femis  = document.getElementById("EDat9").value;
		var arreglo_e = femis.split("/");
		var fecha_ya = new Date();
		var anio = fecha_ya.getFullYear();
	
		var edia  = arreglo_e[0].length;
		var emes  = arreglo_e[1].length;		
		var eanio  = arreglo_e[2].length;
	
		if(arreglo_e[0] > 31 || arreglo_e[1] > 12 || arreglo_e[2] > anio ){
			ErrorFecha("EDat9");
		}else{
			
			if(arreglo_e[0] > 28 & arreglo_e[1] == 2){
				ErrorFecha("EDat9");
			}else{
			
				if( edia == 2){
					if( emes == 2){
						if( eanio == 4){

							$("#EncDat9").css("border-color", "transparent");
							$("#EncDat13").css("border-color", "#F90");
					
							EnvAyuda("Ingrese fecha de vencimiento.");
							
							document.getElementById("DondeE").value = "EDat13";
							document.getElementById("CantiE").value = "10";
							document.getElementById("QuePoE").value = "1";
							
							document.getElementById('LetEnt').innerHTML = '<button onclick="FechaVencim();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
							
							document.getElementById('NumVol').innerHTML = '<button onclick="VolFecPIva();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
							
							controlarcadainputcom("EDat13");

						}else{
							ErrorFecha("EDat9");
						}
					}else{
						ErrorFecha("EDat9");
					}
				}else{
					ErrorFecha("EDat9");
				}
			}
		}
	}
	}
}

function VolFecPIva(){

	$("#EncDat13").css("border-color", "transparent");
	$("#EncDat9").css("border-color", "#F90");
	
	EnvAyuda("Ingrese fecha P/Iva.");
	
	document.getElementById('EDat9').value = "";
	document.getElementById('EDat13').value = "";	

	document.getElementById("DondeE").value = "EDat9";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="FechaPIva();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="VolFechaFac();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LeVolCom\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" boder="0" id="LeVolCom"/></button>';

	controlarcadainputcom("EDat9");

}

function FechaVencim(){

	var fecemision  = document.getElementById("EDat13").value.length;
	if(fecemision == 0){
	
		var now = new Date();
		var d = str_pad(now.getDate(), 2, '0', 'STR_PAD_LEFT');
		var m = str_pad(now.getMonth() + 1, 2, '0', 'STR_PAD_LEFT');
		var y = now.getFullYear();
		var fecha = d+"/"+m+"/"+y;	
		document.getElementById("EDat13").value = fecha;
		
		$("#EncDat13").css("border-color", "transparent");
		$("#EncDat14").css("border-color", "#F90");
			
		EnvAyuda("Ingrese importe de descuento.");
		
		document.getElementById("DondeE").value = "EDat14";
		document.getElementById("CantiE").value = "12";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Descuento();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolFecDes();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Vover" title="Volver" border="0" id="LetVolChe"/></button>';
		
		controlarcadainputcom("EDat14");
		
	}else{
		
	if(fecemision != 10){
		ErrorFecha("EDat13");
	}else{
		
		var femis  = document.getElementById("EDat13").value;
		var arreglo_e = femis.split("/");
		var fecha_ya = new Date();
		var anio = fecha_ya.getFullYear();
	
		var edia  = arreglo_e[0].length;
		var emes  = arreglo_e[1].length;		
		var eanio  = arreglo_e[2].length;
	
		if(arreglo_e[0] > 31 || arreglo_e[1] > 12 || arreglo_e[2] > anio ){
			ErrorFecha("EDat13");
		}else{
			
			if(arreglo_e[0] > 28 & arreglo_e[1] == 2){
				ErrorFecha("EDat13");
			}else{
			
				if( edia == 2){
					if( emes == 2){
						if( eanio == 4){

							$("#EncDat13").css("border-color", "transparent");
							$("#EncDat14").css("border-color", "#F90");
					
							EnvAyuda("Ingrese importe de descuento.");

							document.getElementById("DondeE").value = "EDat14";
							document.getElementById("CantiE").value = "12";
							document.getElementById("QuePoE").value = "1";
							
							document.getElementById('LetEnt').innerHTML = '<button onclick="Descuento();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
							
							document.getElementById('NumVol').innerHTML = '<button onclick="VolFecDes();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
							controlarcadainputcom("EDat14");
							

						}else{
							ErrorFecha("EDat13");
						}
					}else{
						ErrorFecha("EDat13");
					}
				}else{
					ErrorFecha("EDat13");
				}
			}
		}
	}
  	}
}

function VolFecDes(){

	$("#EncDat14").css("border-color", "transparent");
	$("#EncDat13").css("border-color", "#F90");
	
	EnvAyuda("Ingrese fecha de vencimiento.");
	
	document.getElementById('EDat13').value = "";
	document.getElementById('EDat14').value = "";	
						
	document.getElementById("DondeE").value = "EDat13";
	document.getElementById("CantiE").value = "10";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="FechaVencim();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolFecPIva();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	controlarcadainputcom("EDat13");

}

function Descuento(){

	var rem = document.getElementById("EDat7_3").value;
	var des = document.getElementById('EDat14').value;

	if (/^([0-9+\,])*$/.test(des)){
		if(des != 0){
			if(des.length != 0){
					
				if(des > 100 && des != 100){
					ErrorTiposF('EDat14');
					return false;
				}
		
				$("#EncDat14").css("border-color", "transparent");
				$("#EncDat15").css("border-color", "#F90");
							
				EnvAyuda("Enter: Continua. Consultar: Ingresa remitos al comprobante.");
									
				document.getElementById("DondeE").value = "EDat15";
				document.getElementById("CantiE").value = "0";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Remitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				controlarcadainputcom("EDat15");
			
				if(rem != "RE"){
	
					SoloBlock("LetTer");
	
					document.getElementById('LetTer').innerHTML = '<button onclick="ConRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';

				}
			
				document.getElementById('NumVol').innerHTML = '<button onclick="VolDescu();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

			}
		}else{

			var mod = document.getElementById("HabFunModCom").value;
		
			if(mod == 1){
	
				var t = document.getElementById('EDat16').value;
				document.getElementById('EDat16').value = document.getElementById('NumEmpresa').value;
				$("#EncDat14").css("border-color", "transparent");
				$("#EncDat16").css("border-color", "transparent");
				$("#EncDat17").css("border-color", "#F90");
				
				EnvAyuda("Ingrese la cantidad de cuotas del comprobante.");
						
				document.getElementById("DondeE").value = "EDat17";
				document.getElementById("CantiE").value = "2";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Cuotas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolEmpresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';	
				
				controlarcadainputcom("EDat17");
				
			}else{

				document.getElementById('EDat14').value = '0';
	
				$("#EncDat14").css("border-color", "transparent");
				$("#EncDat15").css("border-color", "#F90");
	
				EnvAyuda("Enter: Continua. Consultar: Ingresa remitos al comprobante.");
			
				document.getElementById("DondeE").value = "EDat15";
				document.getElementById("CantiE").value = "0";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Remitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
				controlarcadainputcom("EDat15");
	
				if(rem != "RE"){
	
					SoloBlock("LetTer");
	
					document.getElementById('LetTer').innerHTML = '<button onclick="ConRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFac\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="LetConFac"/></button>';
	
				}
					
				document.getElementById('NumVol').innerHTML = '<button onclick="VolDescu();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
			}
		}
	}
	
}

function ConRemitos(){

	SoloNone("ComBotEncDiv, ComBotCueDiv, ComBotPieDiv");

	$('#Bloquear').fadeIn(500);
	
	var cp = document.getElementById("EDat3").value;
	
	EnvAyuda("Seleccione el o los Remitos.");
	
	$("#BusquedaRemito").load("ComBusRem.php?cp="+cp);

}

function enviar_remito(t, c){

	if($("#cadatilde"+c).hasClass('ComSinTil')){
		$("#cadatilde"+c).removeClass("ComSinTil").addClass("ComConTil");
	}else{
		$("#cadatilde"+c).removeClass("ComConTil").addClass("ComSinTil");
	}

	document.getElementById('LetEnt').innerHTML = '<button onclick="revisar_remitos('+t+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConFacRemitos\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetConFacRemitos"/></button>';

	SoloBlock("LetEnt");

}

function revisar_remitos(t){

$('#Bloquear').fadeIn(500);
	
	var tot = "";
	
	for (i=1; i<=t; i++){
		
		if($("#cadatilde"+i).hasClass('ComConTil')){
			
			var fac = document.getElementById("valorcadatilde"+i).value;		
			tot = tot + fac +",";		
		
		}
		
	}
	
	tot = tot.substring(0, tot.length - 1);
	if(tot.length > 0){
		$("#archivos").load("ComRevRem.php?tot="+tot);
	}else{
		$("#archivos").load("ComRevRem.php");
	}

}

function volverderemitos(){

	$("#EncDat16").css("border-color", "transparent");

	document.getElementById('LetEnt').innerHTML = '<button onclick="Remitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolDescu();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
		
	SoloNone("BusquedaRemito");
	SoloBlock("ComBotEncDiv, Encabezado, EncabezadoDat, LetEnt");
	
}

function VolDescu(){

	$("#EncDat15").css("border-color", "transparent");
	$("#EncDat14").css("border-color", "#F90");	
	
	EnvAyuda("Ingrese importe de descuento.");

	document.getElementById("EDat14").value = "";
	document.getElementById("EDat15").value = "";
	
	document.getElementById("DondeE").value = "EDat14";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Descuento();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolFecDes();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';

	SoloNone("LetTer");
	
	controlarcadainputcom("EDat14");
	
}

function Remitos(){
	
	var t = document.getElementById('EDat15').value;
	if (/^([0-9])*$/.test(t)){	
		if(t != 0){
			
			if(t.length != 0){
				
				////////////////////////////////////////////////////////////////
				document.getElementById('EDat15').value = "Sin Remitos";////////
				$("#archivos").load("ComRevRem.php?rev=1");/////////////////////
				SoloNone("LetTer");/////////////////////////////////////////////
				////////////////////////////////////////////////////////////////
				
				$("#EncDat15").css("border-color", "transparent");
				$("#EncDat16").css("border-color", "#F90");
	
				EnvAyuda("Ingrese empresa del comprobante.");
				
				document.getElementById("DondeE").value = "EDat16";
				document.getElementById("CantiE").value = "8";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
				
				controlarcadainputcom("EDat16");

			}else{
				
				$("#EncDat15").css("border-color", "transparent");
				$("#EncDat16").css("border-color", "#F90");
	
				EnvAyuda("Ingrese empresa del comprobante.");
				
				document.getElementById("DondeE").value = "EDat16";
				document.getElementById("CantiE").value = "8";
				document.getElementById("QuePoE").value = "1";
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';	
				
				controlarcadainputcom("EDat16");
				
			}
			
		}else{
			
			////////////////////////////////////////////////////////////////
			document.getElementById('EDat15').value = "Sin Remitos";////////
			$("#archivos").load("ComRevRem.php?rev=1");/////////////////////
			SoloNone("LetTer");/////////////////////////////////////////////
			////////////////////////////////////////////////////////////////

			$("#EncDat15").css("border-color", "transparent");
			$("#EncDat16").css("border-color", "#F90");
			
			EnvAyuda("Ingrese empresa del comprobante.");
							
			document.getElementById("DondeE").value = "EDat16";
			document.getElementById("CantiE").value = "8";
			document.getElementById("QuePoE").value = "1";
				
			document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
				
			document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';
			
			controlarcadainputcom("EDat16");
			
		}
	}else{
		$("#EncDat15").css("border-color", "transparent");
		$("#EncDat16").css("border-color", "#F90");
		
		EnvAyuda("Ingrese empresa del comprobante.");
		
		document.getElementById("DondeE").value = "EDat16";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Empresa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button onclick="VolRemitos();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolChe\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolChe"/></button>';	
		
		controlarcadainputcom("EDat16");
	}
}
