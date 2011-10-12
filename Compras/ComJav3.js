// JavaScript Document

$("#EDat3").removeAttr("readonly");
$('#EDat3').focus();

function controlarcadainputcom(cu){

	$("input").attr("readonly", "readonly");
	$("#"+cu).removeAttr("readonly");
	$("#"+cu).focus();
	$("#"+cu).select();
	
}

/*********************************************************************************************************************/
function convertirL(id){
    document.getElementById(id).value = document.getElementById(id).value.toUpperCase();    
}
/*********************************************************************************************************************/

function ControlEDat3(){

	if(document.getElementById("EncDat3").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		MosPro();
	}
	
}

function ControlEDat5(){
	
	if(document.getElementById("EncDat5").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 114) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		MosFpa();
	}

}

function ControlEDat5Vol(){
	
	if(document.getElementById("EncDat5").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolProv();
	}
	if(k == 114){
		listadocomcom();
	}

}

function ControlEDat7_1(){
	
	if(document.getElementById("EncDat7-1").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 114)  || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		Sucursal();
	}
}

function ControlEDat7_1Vol(){
	
	if(document.getElementById("EncDat7-1").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolFdpago();
	}
	if(k == 114){
		listadocomcom();
	}
}

function ControlEscapeComprobantes(){
/*
	if($('#LisFacComFon').css('display') == 'none'){
		return false;
	}
*/
	var k = window.event.keyCode;
	if(k == 13){

	}
	
}

function ControlEscapeComprobantesVol(){
	var k = window.event.keyCode;
	if(k == 27){
		SalLisCom();
	}
	
}


function ControlEDat7_2(){
	
	if(document.getElementById("EncDat7-2").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 97) || (k == 98) || (k == 99) || (k == 109) || (k == 114) || (k == 65) || (k == 66) || (k == 67) || (k == 77) || (k == 88))){
		return false;
	}
	if(k == 13){
		FacturaC();
	}	
	
}

function ControlEDat7_2Vol(){
	
	if(document.getElementById("EncDat7-2").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolSucursal();
	}
	if(k == 114){
		listadocomcom();
	}
}

function ControlEDat7_3(){
	
	if(document.getElementById("EncDat7-3").style.borderColor == 'transparent'){
		return false;
	}
	
	var k = window.event.keyCode;

	if(!((k == 102) || (k == 116) || (k == 110) || (k == 99) || (k == 100) || (k == 114) || (k == 101) || (k == 105) || (k == 70) || (k == 84) || (k == 78) || (k == 67) || (k == 68) || (k == 82) || (k == 69) || (k == 73) || (k == 13))){
		return false;
	}
	if(k == 13){
		ComTipo();
	}	
}

function ControlEDat7_3Vol(){
	
	if(document.getElementById("EncDat7-3").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	
	if(k == 27){
		VolTipo();
	}
	if(k == 114){
		listadocomcom();
	}
}

function ControlEDat7_4(){
	
	if(document.getElementById("EncDat7-4").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		NumeroNco();
	}
}

function ControlEDat7_4Vol(){
	
	if(document.getElementById("EncDat7-4").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolNumNco();
	}
	if(k == 114){
		listadocomcom();
	}
}

function ControlEDat8(){
	
	if(document.getElementById("EncDat8").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 47) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		FechaFac();
	}
}

function ControlEDat8Vol(){
	
	if(document.getElementById("EncDat8").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolNdcom();
	}
}

function ControlEDat9(){
	
	if(document.getElementById("EncDat9").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 47) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		FechaPIva();
	}
}

function ControlEDat9Vol(){
	
	if(document.getElementById("EncDat9").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolFechaFac();
	}
}

function ControlEDat13(){
	
	if(document.getElementById("EncDat13").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 47) && (k <= 57)))){				//	NUM Y BARRA
		return false;
	}
	if(k == 13){
		FechaVencim();
	}
}

function ControlEDat13Vol(){
	
	if(document.getElementById("EncDat13").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolFecPIva();
	}
}

function ControlEDat14(){
	
	if(document.getElementById("EncDat14").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){	//	NUM Y PTO
		return false;
	}
	if(k == 13){
		Descuento();
	}
}

function ControlEDat14Vol(){
	
	if(document.getElementById("EncDat14").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolFecDes();
	}
}

function ControlEDat15(){
	
	if(document.getElementById("EncDat15").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){				//	NUM SOLO
		return false;
	}
	if(k == 13){
		Remitos();
	}
}

function ControlEDat15Vol(){
	
	if(document.getElementById("EncDat15").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolDescu();
	}
	if(k == 114){
		ConRemitos();
	}
}

function ControlEDat16(){
	
	if(document.getElementById("EncDat16").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		Empresa();
	}
}

function ControlEDat16Vol(){
	
	if(document.getElementById("EncDat16").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolRemitos();
	}
}

function ControlEDat17(){
	
	if(document.getElementById("EncDat17").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		Cuotas();
	}
}

function ControlEDat17Vol(){
	
	if(document.getElementById("EncDat17").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolEmpresa();
	}
}

function ControlEDat18(){
	
	if(document.getElementById("EncDat18").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		NotaPed();
	}
}

function ControlEDat18Vol(){
	
	if(document.getElementById("EncDat18").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolPedid();
	}
}

function ControlEDat10(){

	if($('#ImputarA').css('display') == 'none'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 49) && (k <= 52)))){
		return false;
	}
	if(k == 13){
		var a = document.getElementById("EDat10").value;
		if(a.length == 1){
			if(!isNaN(a)){
				CambiarImp(a);
			}else{
				CambiarImp(1);
			}
		}else{
			var b = document.getElementById("EDat10Val").value;
			CambiarImp(b);
		}
	}
}

function ControlEDat10Vol(){
	
	if($('#ImputarA').css('display') == 'none'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolImp();
	}
}

function ControlEDat11(){

	if(document.getElementById("EncDat11").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;

	if(!((k == 13) || ((k >= 48) && (k <= 57)))){				//	NUM SOLO
		return false;
	}
	if(k == 13){
		ImgCai();
	}
}

function ControlEDat11Vol(){
	
	if(document.getElementById("EncDat11").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		ImputarVol();
	}
}

function ControlEDat12(){

	if(document.getElementById("EncDat12").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;

	if(!((k == 13) || ((k >= 47) && (k <= 57)))){				//	NUM Y BARRA
		return false;
	}
	if(k == 13){
		VenCai();
	}
}

function ControlEDat12Vol(){
	
	if(document.getElementById("EncDat12").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolVCai();
	}
}

function ControlEDat12(){

	if(document.getElementById("EncDat12").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;

	if(!((k == 13) || ((k >= 47) && (k <= 57)))){				//	NUM Y BARRA
		return false;
	}
	if(k == 13){
		VenCai();
	}
}

function ControlEDat12Vol(){
	
	if(document.getElementById("EncDat12").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolVCai();
	}
}

function ControlEDatUnidades(){
	var k = window.event.keyCode;
	if(!((k == 13) )){
		return false;
	}
	if(k == 13){
		IngresoXCan(2);
	}
}

function ControlEDatUnidadesVol(){
	var k = window.event.keyCode;
	if(k == 27){

	}
}

function ControlEDatUnidadesCont(){
	var k = window.event.keyCode;
	if(!((k == 13) )){
		return false;
	}
	if(k == 13){
		var a = document.getElementById("Consulta").value;
		if(a == 1){
			SoloNone('Cantidadesx, CantidadesxDat');
			Mostrar_Cuerpo();
		}else{
			FormEncabezadoSub();
		}
	}
}

function ControlEDatUnidadesContVol(){
	var k = window.event.keyCode;
	if(k == 27){

	}
}


///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////		CUERPO DE COMPRAS	 //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

function ControlCDat1(){
	if(document.getElementById("CueDat1").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;

	if(!((k == 13) || ((k >= 47) && (k <= 57)))){				//	NUM
		return false;
	}
	if(k == 13){
		if($('#CuerpoProdu').css('display') == 'block'){
			enviarbarra();
		}else{
			enviarorigen();
		}
	}
}


var pasarapie = null;
function ControlCDat1Vol(){

	if(document.getElementById("CueDat1").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(k == 114){
		enviarcodorigen();
	}
	if(k == 115){
		Mostrar_Busqueda();
	}

	if(k == 113){
		if(pasarapie == 1){
			if($('#LetTer').css('display') == 'block'){
				EnvCuerpo();
			}
		}
	}
}

function ControlCDat2(){

	if(document.getElementById("CueDat2").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){				//	NUM
		return false;
	}
	if(k == 13){
		enviarsucursal();
	}
}

function ControlCDat2Vol(){

	if(document.getElementById("CueDat2").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 114){
		enviararticulo();	
	}
}

function ControlCDat3(){

	if(document.getElementById("CueDat3").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){				//	NUM
		return false;
	}
	if(k == 13){
		enviarsucursal2();
	}
}

function ControlCDat3Vol(){

	if(document.getElementById("CueDat3").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 114){
		enviararticulo();	
	}
	if(k == 27){
		volversuc();
	}
	
	
}

function ControlCDat4(){

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){				//	NUM Y BARRA
		return false;
	}
	if(k == 13){
		enviarCodO();
	}
}

function ControlCDat4Vol(){
	
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDat5(){

	if(document.getElementById("CueDat5").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	if(k == 13){
		ControlCan();
	}
}

function ControlCDat5Vol(){
	
	if(document.getElementById("CueDat5").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDat6(){

	if(document.getElementById("CueDat6").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 32) || ((k >= 48) && (k <= 57)) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		enviardetalle();
	}
}

function ControlCDat6Vol(){
	
	if(document.getElementById("CueDat6").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDat8(){

	if(document.getElementById("CueDat8").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		ControlCosto();
	}
}

function ControlCDat8Vol(){
	
	if(document.getElementById("CueDat8").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDat9(){

	if($('#CueDat9-2').css('display') == 'none'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		DescuentoCosto();
	}
}

function ControlCDat9Vol(){
	
	if(document.getElementById("CueDat9").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDat10(){

	if(document.getElementById("CueDat10").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		enviarsubpordet();
	}
}

function ControlCDat10Vol(){
	
	if(document.getElementById("CueDat10").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDatCalcSub(){

	var k = window.event.keyCode;
	if(!((k == 13) )){
		return false;
	}
	if(k == 13){
		subtotalesdeI();
	}

}

function ControlCDatCalcSubVol(){
	
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlCDatContinuar(){

	var k = window.event.keyCode;
	if(!((k == 13) )){
		return false;
	}
	if(k == 13){
		confirmarI();
		pasarapie = 1;
	}

}

function ControlCDatContinuarVol(){
	
	var k = window.event.keyCode;
	if(k == 114){
		
	}
	
}

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////		PIE DE COMPRAS	 //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////


function ControlPDat1(){

	if(document.getElementById("PDat1").style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		ValidarDP(1);
	}
}

function ControlPDat1Vol(){
	
	if(document.getElementById("PDat1").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 114){
		
	}
}

function ControlPIE(a){
	
	if(document.getElementById("PDat"+a).style.borderColor == 'transparent'){
		return false;
	}

	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		ValidarDP(a);
	}

}

function ControlPIEVol(a){

	if(document.getElementById("PDat"+a).style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		a = a - 1;
		if(a != 0){
			Vol_ValidarDP(a);
		}
	}
}


function ControlCDatContinuarPie(){
	
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		ConFCom();
	}

}

function ControlCosNue(f,t){
	
	if(document.getElementById("celda"+f).className == 'CComSinP1'){
		return false;
	}
	
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 46) || ((k >= 48) && (k <= 57)))){		//	NUM Y PUNTO
		return false;
	}
	if(k == 13){
		envcosto(t,f);
	}

}

function ControlCosNueVol(f,t){

	if(document.getElementById("celda"+f).className == 'CComSinP1'){
		return false;
	}

	var k = window.event.keyCode;
	if(k == 27){
		f = parseInt(f) - 1;
		VolEnvCosto(t,f);
	}
}

function ControlCDatCosto(){
	
	var k = window.event.keyCode;
	if(!((k == 13))){		//	ENTER
		return false;
	}
	if(k == 13){
		EnvCuerpo();
	}

}

function ControlCDatCostoVol(){

	var k = window.event.keyCode;
	if(k == 27){

		$('#NumVol').click();
	}
}
