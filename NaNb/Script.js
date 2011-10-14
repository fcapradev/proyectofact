// JavaScript Document
$(document).ready(function(){
	$('#genera').submit(function(){
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

$("#Bot1").focus();






function MsjSeleccion(a){
	
	if(a == 1){
		
		SoloNone("NaNb");
		
		$("#TomaInv").load("TomaInv.php");
		
		SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, TomaInv');

		document.getElementById("DondeE").value = "";
		
		document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="salir_tom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
		
		document.getElementById("LetEnt").innerHTML = '<button onclick="trae_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
	}else{
		
		if(a == 2){
			
			//jAlert('Módulo no habilitado.', 'Debo Retail - Global Business Solution');
			
			$("#TipoNotaDiv").css("border-color", "#F90");
			
			SoloNone("Marca");
			$('#MsjSeleccion').fadeOut(500);
			$('#NotaCuerpo').fadeIn(500);
			
			SoloBlock('fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, LetSal');
	
			Ir_a("TipoNota",1,2);
			
			document.getElementById("LetSal").innerHTML = '<button class="StyBoton" onclick="Salir_NaNb();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
			
			document.getElementById("LetEnt").innerHTML = '<button id="LetEntNaNb1" onclick="SelTipoNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
			EnvAyuda("Ingrese A: para N. de Alta o B: para N. de Baja. Enter para listar.");
			

		}else{

			$('#BotonesPri').fadeIn(500);
			$('#SobreFoca').fadeIn(500);

			SoloNone('NaNb');

			SoloBlock('SobreFoca, Marca');
			SoloNone('CarAyudaFon, CarAyuda, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum');
			
		}
	}
}

function Salir_NaNb(){
	jConfirm("¿Esta seguro que desea salir?.", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			
			$('#BotonesPri').fadeIn(500);
			$('#SobreFoca').fadeIn(500);

			SoloNone('NaNb');

			SoloBlock('SobreFoca, Marca');
			SoloNone('CarAyudaFon, CarAyuda, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum');
			
			document.getElementById('NaNb').innerHTML = '';

		}
	});	
}

/*****************************************************************************************************************/
/**************************************************	  TECLADO	 *************************************************/
/*****************************************************************************************************************/

function Ir_a(don,can,que){

	$('input, div').not("#"+don).click(function() {
		$("#"+don).focus();
	});

	$("input").attr("readonly", "readonly");
	$("#"+don).removeAttr("readonly");

	$("#"+don).focus();
	$("#"+don).select();

	$("input").css("outline-style", "none");
	$("input").css("border-style", "none");
	
	document.getElementById("DondeE").value = don;
	document.getElementById("CantiE").value = can;
	document.getElementById("QuePoE").value = que;
	
}

/*********************************************************************************************************************/
function convertirL(id){
    document.getElementById(id).value = document.getElementById(id).value.toUpperCase();    
}
/*********************************************************************************************************************/

function ControlTipoNota(){

	if(document.getElementById("TipoNotaDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 114) || ((k >= 97) && (k <= 98)) || ((k >= 65) && (k <= 66)))){
		return false;
	}
	if(k == 13){
		SelTipoNota();
	}
	
}

function ControlTipoOper(){
	
	if(document.getElementById("TipoOperacionDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 114) || (k >= 97) || (k >= 65) || (k >= 100) || (k >= 68) || (k >= 86) || (k >= 118) || (k >= 76) || (k >= 108) || (k >= 79) || (k >= 111))){
		return false;
	}
	if(k == 13){
		SelTipOper();
	}
}

function ControlTipoOperVol(){
	
	if(document.getElementById("TipoOperacionDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolTipoNota();
	}
}

function ControlOperador(){
	
	if(document.getElementById("OperadorDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
	if(k == 13){
		ValidaOperador();
	}
}

function ControlOperadorVol(){
	
	if(document.getElementById("OperadorDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolOperacion();
	}
}

function ControlSector(){
	if(document.getElementById("SectorDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaOrigen(1);
	}
}

function ControlSectorVol(){
	
	if(document.getElementById("SectorDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolOperacion();
	}
}

function ControlProducto(){
	if(document.getElementById("ProductoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaOrigen(2);
	}
}

function ControlProductoVol(){
	
	if(document.getElementById("ProductoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		Vol_Sector();
	}
}

function ControlSectorD(){
	if(document.getElementById("SectorDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaDestino(1);
	}
}

function ControlSectorDVol(){
	
	if(document.getElementById("SectorDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		Vol_Sector();
	}
}

function ControlProductoD(){
	if(document.getElementById("ProductoDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaDestino(2);
	}
}

function ControlProductoDVol(){
	
	if(document.getElementById("ProductoDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		Vol_SectorD();
	}
}

function ControlCantidadD(){
	
	if(document.getElementById("CantidadDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		Sig_Cantidad();
	}
}

function ControlCantidadDVol(){
	
	if(document.getElementById("CantidadDivD").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		Vol_SectorD();
	}
}

function ControlTerminarCar(){
	//alert("SIG CARGA");
	var k = window.event.keyCode;
	if(!((k == 13))){	
		return false;
	}
	if(k == 13){
		Sig_Cargar();
	}
}

function ControlTerminarCarVol(){

	var k = window.event.keyCode;

	if(k == 27){
		Vol_Cantidad();
	}
}

function ControlTerminarCar(){

	var k = window.event.keyCode;
	if(!((k == 13))){	
		return false;
	}
	if(k == 13){
		Sig_Cargar();
	}
}

function ControlTerminarCarVol(){

	var k = window.event.keyCode;

	if(k == 27){
		Vol_Cantidad();
	}
}


function ControlLocal(){
	if(document.getElementById("LocalDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaLocal();
	}
}

function ControlLocalVol(){
	
	if(document.getElementById("LocalDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolOperacion();
	}
}

function ControlLocalNB(){
	if(document.getElementById("LocalNBDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaLocalNB();
	}
}

function ControlLocalNBVol(){
	
	if(document.getElementById("LocalNBDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolOperacion();
	}
}

function ControlNumNota(){
	if(document.getElementById("NumeroNotaDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		Sig_NumNota();
	}
}

function ControlNumNotaVol(){
	
	if(document.getElementById("NumeroNotaDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		Vol_Local();
	}
}

function ControlSucursal(){
	if(document.getElementById("SucursalDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaSucursal();
	}
}

function ControlSucursalVol(){
	
	if(document.getElementById("SucursalDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolOperacion();
	}
}

function ControlTipo(){
	if(document.getElementById("TipoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 97) || (k == 65) || (k == 98) || (k == 66) || (k == 99) || (k == 67) || (k == 114) || (k == 82))){
		return false;
	}
	if(k == 13){
		BuscaTipo();
	}
}

function ControlTipoVol(){
	
	if(document.getElementById("TipoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolSucursal();
	}
}

function ControlTco(){
	if(document.getElementById("TcoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || (k == 97) || (k == 65) || (k == 102) || (k == 70) || (k == 105) || (k == 73) || (k == 100) || (k == 69) || (k == 101) || (k == 68) || (k == 110) || (k == 78) || (k == 116) || (k == 84) || (k == 115) || (k == 83) || (k == 99) || (k == 67) || (k == 114) || (k == 82))){
		return false;
	}
	if(k == 13){
		BuscaTco();
	}
}

function ControlTcoVol(){
	
	if(document.getElementById("TcoDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolTipo();
	}
}

function ControlNumero(){
	if(document.getElementById("NumeroDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){	
		return false;
	}
	if(k == 13){
		BuscaNumero();
	}
}

function ControlNumeroVol(){
	
	if(document.getElementById("NumeroDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolTco();
	}
}

function ControlConfirmaC(){

	var k = window.event.keyCode;
	if(!((k == 13))){	
		return false;
	}
	if(k == 13){
		ConfirmaCompr();
	}
}

function ControlConfirmaCVol(){
	
	if(document.getElementById("NumeroDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(k == 27){
		VolNumero();
	}
}

/*****************************************************************************************************************/
/***********************************************	  FIN TECLADO	 *********************************************/
/*****************************************************************************************************************/
	
////	LISTA DE NOTAS    ////
function SelTipoNota(){


	var TipoNota = document.getElementById('TipoNota').value;		

	if(TipoNota == '' ){
		
		$("#cuadrotipo").show("slow");
                
                document.onkeydown = function(){

                        var k = window.event.keyCode;

                        if(!((k == 13) || (k == 27) || (k == 38) || (k == 40) || (k == 114) || ((k >= 97) && (k <= 98)) || ((k >= 65) && (k <= 66)))){
                            return false;
                        }
                        if(k == 38){    //SUBE
                            $('#Img1').attr({src: 'NaNb/fon-nota-nar.png'});
                            $('#Img2').attr({src: 'NaNb/fon-nota.png'});
                            document.getElementById("TipoNota").value = "A";

                        }
                        if(k == 40){    //BAJA
                            $('#Img2').attr({src: 'NaNb/fon-nota-nar.png'});
                            $('#Img1').attr({src: 'NaNb/fon-nota.png'});
                            document.getElementById("TipoNota").value = "B";
                        }
                        if(k == 27){
                            $("#cuadrotipo").hide("slow");
                        }
                    }

                

		
	}else{

		if(TipoNota == 'A'){
			document.getElementById("TipoNota").value = "A - NOTA DE ALTA";
			document.getElementById("TN").value = 1;
		}else{
			if(TipoNota == 'B'){
				document.getElementById("TipoNota").value = "B - NOTA DE BAJA";	
				document.getElementById("TN").value = 2;
			}else{
				document.getElementById("TipoNota").value = "";
				return false;
			}
		}
		
		$("#archivos").load("NaNb/NaNbProcesa.php?tipo="+TipoNota);
		
		$("#cuadrotipo").hide("slow");
		SoloBlock("NumVol");
		$('#TipoNotaDiv').removeAttr('onclick');
		

	}	
}

function SelNota(a){
	var Nota;
	if(a == 1){
		Nota = 'A';
	}else{
		Nota = 'B';
	}
	$("#archivos").load("NaNb/NaNbProcesa.php?tipo="+Nota);
	
	SoloBlock("NumVol");
	$('#TipoNotaDiv').removeAttr('onclick');
		
	$("#cuadrotipo").hide("slow");

	document.getElementById("TipoNota").value = document.getElementById("NAB"+a).innerHTML;

	document.getElementById("TN").value = a;

	if(a == 1){
		$('#Img1').attr({
			src: 'NaNb/fon-nota-nar.png',
		});
		$('#Img2').attr({
			src: 'NaNb/fon-nota.png',
		});
	}else{
		$('#Img2').attr({
			src: 'NaNb/fon-nota-nar.png',
		});
		$('#Img1').attr({
			src: 'NaNb/fon-nota.png',
		});				
	}
}

function VolTipoNota(){
	
	SoloNone("NumVol, Pve, Fecha");
	
	$("#TipoNotaDiv").css("border-color", "#F90");
	$("#TipoOperacionDiv").css("border-color", "transparent");
	
	$('#TipoOperacionDiv').attr('onclick', 'SelTipoNota();');
	
	document.getElementById("TN").value = "";
	document.getElementById("Num").value = "";

	Ir_a("TipoNota",1,2);
	
	document.getElementById("LetEnt").innerHTML = '<button onclick="SelTipoNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
	
	EnvAyuda("Ingrese A: para N. de Alta o B: para N. de Baja. Enter para listar.");
	
}


////	LISTA DE MOVIMIENTOS    ////
function SelTipOper(){

	var N = document.getElementById("TipoOperacion").value;
	
	var nota = document.getElementById("TN").value;
		
	if(nota == 2){
		if(N == ''){
			$("#cuadrooperacionB").show("slow");
                        
                        document.onkeydown = function(){

                            var k = window.event.keyCode;

                            if(!((k == 13) || (k == 27) || (k == 38) || (k == 40) || (k == 114) || ((k >= 97) && (k <= 98)) || ((k >= 65) && (k <= 66)))){
                                return false;
                            }
                            /*
                            if(k == 38){    //SUBE
                                $('#Img1').attr({src: 'NaNb/fon-nota-nar.png'});
                                $('#Img2').attr({src: 'NaNb/fon-nota.png'});
                                document.getElementById("TipoNota").value = "A";

                            }
                            if(k == 40){    //BAJA
                                $('#Img2').attr({src: 'NaNb/fon-nota-nar.png'});
                                $('#Img1').attr({src: 'NaNb/fon-nota.png'});
                                document.getElementById("TipoNota").value = "B";
                            }
                            */
                            if(k == 27){
                                $("#cuadrooperacionB").hide("slow");
                            }
                        }
                        
		}else{
			switch(N){
				case 'A':
					SoloBlock("Comprobante");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("Op1").innerHTML;
					document.getElementById("TituloC").innerHTML = "DATOS COMPROBANTE DE COMPRAS";
					document.getElementById("tipo").value = 2;
					
					document.getElementById("MovTip").value = 1;
				break;
				case 'D':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op2").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Depósito";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 2;
				break;
				case 'P':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op3").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Retiro Ventas";
					document.getElementById("tipo").value = 3;

					document.getElementById("MovTip").value = 3;
				break;
				case 'E':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op4").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Depósito";
					document.getElementById("TituloB").innerHTML = "Destino: Retiro Depósito";
					document.getElementById("tipo").value = 3;

					document.getElementById("MovTip").value = 4;
				break;
				case 'R':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op5").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Rotura";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 5;
				break;
				case 'O':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op6").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Depósito";
					document.getElementById("TituloB").innerHTML = "Destino: Rotura";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 6;
				break;
				case 'Q':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op7").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Vencimiento";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 7;
				break;
				case 'U':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op8").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Depósito";
					document.getElementById("TituloB").innerHTML = "Destino: Vencimiento";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 8;
				break;
				case 'S':
					SoloBlock("LocalOrigenNB");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("Op9").innerHTML;	
					document.getElementById("TituloCNB").innerHTML = "LOCAL DESTINO";
					document.getElementById("tipo").value = 5;

					document.getElementById("MovTip").value = 9;
				break;
				case 'T':
					SoloBlock("LocalOrigenNB");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("Op10").innerHTML;	
					document.getElementById("TituloCNB").innerHTML = "LOCAL DESTINO";
					document.getElementById("tipo").value = 5;
					
					document.getElementById("MovTip").value = 10;
				break;
				case 'X':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op11").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Depósito";
					document.getElementById("TituloB").innerHTML = "Destino: Otros";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 11;
				break;
				case 'Z':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("Op12").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Aten. al Cliente";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 12;
				break;
				default:
					document.getElementById("TipoOperacion").value = "";
					document.getElementById("MovTip").value = 0;
				return false;
			}			

			SoloBlock("OperadorDiv");
			SiguienteOperador();		
	
		$("#cuadrooperacionB").hide("slow");
		}
		
	}else{
		if(N == ''){
			$("#cuadrooperacionA").show("slow");
		}else{

			switch(N){
				case 'A':
					SoloBlock("Comprobante");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("OpA1").innerHTML;
					document.getElementById("TituloC").innerHTML = "DATOS COMPROBANTE DE COMPRAS";
					document.getElementById("tipo").value = 1;
					
					document.getElementById("MovTip").value = 13;
				break;
				case 'D':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("OpA2").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Depósito";
					document.getElementById("TituloB").innerHTML = "Destino: Ventas";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 14;
				break;
				case 'V':
					SoloBlock("OriDes");
					SoloNone("Comprobante");
					document.getElementById("TipoOperacion").value = document.getElementById("OpA3").innerHTML;	
					document.getElementById("TituloA").innerHTML = "Origen: Ventas";
					document.getElementById("TituloB").innerHTML = "Destino: Ventas";
					document.getElementById("tipo").value = 3;
					
					document.getElementById("MovTip").value = 15;
				break;
				case 'L':
					SoloBlock("LocalOrigen");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("OpA4").innerHTML;	
					document.getElementById("TituloC").innerHTML = "LOCAL ORIGEN";
					document.getElementById("tipo").value = 4;
					
					document.getElementById("MovTip").value = 16;
				break;
				case 'O':
					SoloBlock("LocalOrigen");
					SoloNone("OriDes");
					document.getElementById("TipoOperacion").value = document.getElementById("OpA5").innerHTML;	
					document.getElementById("TituloC").innerHTML = "LOCAL ORIGEN";
					document.getElementById("tipo").value = 4;
					
					document.getElementById("MovTip").value = 17;
				break;
				default:
					document.getElementById("TipoOperacion").value = "";
					document.getElementById("MovTip").value = 0;
					return false;
			}
			SoloBlock("OperadorDiv");
			SiguienteOperador();
			
			$("#cuadrooperacionA").hide("slow");
		}
	}
}

function Operacion(a){
	
	$('#TipoOperacionDiv').removeAttr('onclick');

	$("#TipoOperacionDiv").css("border-color", "transparent");

	var nota = document.getElementById("TN").value;
	
	if(nota == 2){				//NOTA DE BAJA

		document.getElementById("TipoOperacion").value = document.getElementById("Op"+a).innerHTML;
		$("#cuadrooperacionB").hide("slow");	
		
		$('#Im'+a).attr({src: 'NaNb/fon-tip-mov-nar.png'});

		for (i=1; i<=12; i++){
			
			if(i != a){

				$('#Im'+i).attr({
					src: 'NaNb/fon-tip-mov.png',
				});

			}
		}
		
		switch(a){
			case 1:
				SoloBlock("Comprobante");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("Op1").innerHTML;
				document.getElementById("TituloC").innerHTML = "DATOS COMPROBANTE DE COMPRAS";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 1;
			break;
			case 2:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op2").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Depósito";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 2;
			break;
			case 3:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op3").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Retiro Ventas";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 3;
			break;
			case 4:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op4").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Depósito";
				document.getElementById("TituloB").innerHTML = "Destino: Retiro Depósito";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 4;
			break;
			case 5:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op5").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Rotura";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 5;
			break;
			case 6:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op6").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Depósito";
				document.getElementById("TituloB").innerHTML = "Destino: Rotura";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 6;
			break;
			case 7:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op7").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Vencimiento";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 7;
			break;
			case 8:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op8").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Depósito";
				document.getElementById("TituloB").innerHTML = "Destino: Vencimiento";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 8;
			break;
			case 9:
				SoloBlock("LocalOrigenNB");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("Op9").innerHTML;	
				document.getElementById("TituloCNB").innerHTML = "LOCAL DESTINO";
				document.getElementById("tipo").value = 5;

				document.getElementById("MovTip").value = 9;
			break;
			case 10:
				SoloBlock("LocalOrigenNB");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("Op10").innerHTML;	
				document.getElementById("TituloCNB").innerHTML = "LOCAL DESTINO";
				document.getElementById("tipo").value = 5;
				
				document.getElementById("MovTip").value = 10;
			break;
			case 11:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op11").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Depósito";
				document.getElementById("TituloB").innerHTML = "Destino: Otros";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 11;
			break;
			case 12:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("Op12").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Aten. al Cliente";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 12;
			break;
			default:
				document.getElementById("TipoOperacion").value = "";
				document.getElementById("MovTip").value = 0;
			return false;
		}	

		SoloBlock("OperadorDiv");
		SiguienteOperador();

	}else{			//NOTA DE ALTA

		document.getElementById("TipoOperacion").value = document.getElementById("OpA"+a).innerHTML;
		$("#cuadrooperacionA").hide("slow");
		
		$('#ImA'+a).attr({src: 'NaNb/fon-tip-mov-nar.png'});

		for (i=1; i<=5; i++){
			
			if(i != a){

				$('#ImA'+i).attr({
					src: 'NaNb/fon-tip-mov.png',
				});

			}
		}	

		switch(a){
			case 1:
				SoloBlock("Comprobante");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("OpA1").innerHTML;
				document.getElementById("TituloC").innerHTML = "DATOS COMPROBANTE DE COMPRAS";
				document.getElementById("tipo").value = 1;
				
				document.getElementById("MovTip").value = 13;
			break;
			case 2:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("OpA2").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Depósito";
				document.getElementById("TituloB").innerHTML = "Destino: Ventas";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 14;
			break;
			case 3:
				SoloBlock("OriDes");
				SoloNone("Comprobante");
				document.getElementById("TipoOperacion").value = document.getElementById("OpA3").innerHTML;	
				document.getElementById("TituloA").innerHTML = "Origen: Ventas";
				document.getElementById("TituloB").innerHTML = "Destino: Ventas";
				document.getElementById("tipo").value = 3;
				
				document.getElementById("MovTip").value = 15;
			break;
			case 4:
				SoloBlock("LocalOrigen");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("OpA4").innerHTML;	
				document.getElementById("TituloC").innerHTML = "LOCAL ORIGEN";
				document.getElementById("tipo").value = 4;
				
				document.getElementById("MovTip").value = 16;
			break;
			case 5:
				SoloBlock("LocalOrigen");
				SoloNone("OriDes");
				document.getElementById("TipoOperacion").value = document.getElementById("OpA5").innerHTML;	
				document.getElementById("TituloC").innerHTML = "LOCAL ORIGEN";
				document.getElementById("tipo").value = 4;
				
				document.getElementById("MovTip").value = 17;
			break;
			default:
				document.getElementById("TipoOperacion").value = "";
				document.getElementById("MovTip").value = 0;
			return false;
		}

		SoloBlock("OperadorDiv");
		SiguienteOperador();

	}
}

function VolOperacion(){
	
	$('#TipoOperacionDiv').attr('onclick', 'SelTipOper();');

	Ir_a("TipoOperacion",1,2);

	$("div").css("border-color", "transparent");
	$("#TipoOperacionDiv").css("border-color", "#F90");
	
	SoloNone("Cuerpo, Pie, ListaSectorDiv, ListaLocalDiv, LetTer, Lista_Items, Comprobante_Items");
	SoloBlock("LetEnt");
	
	document.getElementById("TituloA").innerHTML = "";
	document.getElementById("TituloB").innerHTML = "";
	document.getElementById("TituloC").innerHTML = "";
	document.getElementById("Lista").innerHTML = "";
	document.getElementById("Total").innerHTML = "";
	document.getElementById("Operador").value = "";
	document.getElementById("Local").value = "";
	document.getElementById("Direccion").value = "";
	document.getElementById("Razon").value = "";
	document.getElementById("LocalNB").value = "";
	document.getElementById("DireccionNB").value = "";
	document.getElementById("RazonNB").value = "";
	document.getElementById("NumeroNota").value = "";
	document.getElementById("CanArt").value = "";
	
	document.getElementById("LetTex").value = "";

	/**	LIMPIO INPUTS  "DATOS DE COMPRA"  **/
	document.getElementById("Sucursal").value = "";
	document.getElementById("Tipo").value = "";
	document.getElementById("Tco").value = "";
	document.getElementById("Numero").value = "";
	document.getElementById("ProveedorId").value = "";
	document.getElementById("Proveedor").value = "";
	document.getElementById("Lista_Art").innerHTML = "";

	EnvAyuda("Seleccione un Tipo de Operaci&oacute;n.");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="SelTipOper();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="VolTipoNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
	
}

function SiguienteOperador(){

	$("#TipoOperacionDiv").css("border-color", "transparent");

	$("#OperadorDiv").css("border-color", "#F90");
	
	EnvAyuda("Ingrese contraseña de Supervisor.");

	Ir_a("Operador",9,0);

	document.getElementById('LetEnt').innerHTML = '<button onclick="ValidaOperador();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
}

function ValidaOperador(){
	
	var psw = document.getElementById("Operador").value;
	var TN = document.getElementById("TN").value;

	if(psw.length = 0){
		jAlert('Ingrese una clave correcta.', 'Debo Retail - Global Business Solution');
		document.getElementById("Operador").value = "";		
	}else{
		$("#archivos").load("NaNb/NaNbProcesa.php?psw="+psw+"&tipoN="+TN+"");
	}
}

function muestrasiguiente(){

	var n = document.getElementById("tipo").value;
	
	if(n == 1){			//NA - > AJUSTE COMPRAS

		EnvAyuda("Ingrese la Sucursal o Enter para listar.");
		
		$("#SucursalDiv").css("border-color", "#F90");

		SoloBlock("Cuerpo, Pie");
		
		Ir_a("Sucursal",4,1);

		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaSucursal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
		
	}

	if(n == 2){			//NB - > AJUSTE COMPRAS

		EnvAyuda("Ingrese la Sucursal o Enter para listar.");

		$("#SucursalDiv").css("border-color", "#F90");

		SoloBlock("Cuerpo, Pie");
		
		Ir_a("Sucursal",4,1);

		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaSucursal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
		
	}
	
	if(n == 3){			//ORIGEN

		EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");

		$("#SectorDiv").css("border-color", "#F90");

		SoloBlock("Cuerpo, Pie");
		
		Ir_a("Sector",4,1);

		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
	}

	if(n == 4){			//NA - > LOCAL

		EnvAyuda("Ingrese el Local de Origen o Enter para listar.");
		
		$("#LocalDiv").css("border-color", "#F90");

		SoloBlock("Cuerpo, Pie");
		
		Ir_a("Local",4,1);

		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaLocal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
	}

	if(n == 5){			//NB - > LOCAL

		EnvAyuda("Ingrese el Local de Origen o Enter para listar.");
		
		$("#LocalNBDiv").css("border-color", "#F90");

		SoloBlock("Cuerpo, Pie");
		
		Ir_a("LocalNB",4,1);

		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaLocalNB();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacionNB();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
	}

}

function BuscaOrigen(a){

	var movtip = document.getElementById("MovTip").value;
	var TN = document.getElementById("TN").value;

	var Sector = document.getElementById("Sector").value;
	var Articulo = document.getElementById("Producto").value;

	switch (movtip){

		// AJUSTE DE COMPRAS (NB)  //
		case '1':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=1&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// DEPÓSITO A VENTAS (NB)  //
		case '2':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=1&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// RETIRO A VENTAS (NB)  //
		case '3':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// RETIRO A DEPOSITOS (NB)  //
		case '4':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=4");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=4&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=4&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// ROTURA VENTAS (NB)  //
		case '5':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// ROTURA DEPOSITOS (NB)  //
		case '6':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=4");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=4&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=4&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// VENCIMIENTO VENTAS (NB)  //
		case '7':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// ROTURA DEPOSITOS (NB)  //
		case '8':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=4");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=4&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=4&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// VENTAS A OTROS LOCALES (NB)  //
		case '9':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// DEPOSITOS A OTROS LOCALES (NB)  //
		case '10':

			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=4");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=4&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=4&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 
			
		// RETIRO A VENTAS (NB)  //
		case '12':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// AJUSTE DE COMPRAS (NA)  //
		case '13':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=1&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		// AJUSTE DE COMPRAS (NA)  //
		case '14':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=2");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=2&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=2&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 

		case '15':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=3");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=3&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=3&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 
			
		case '16':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaIzq.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDiv").css("border-color", "#F90");
					$("#SectorDiv").css("border-color", "transparent");
					
					Ir_a("Producto",4,1);
					
					EnvAyuda("Ingrese el Articulo de Origen o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaIzq.php?busca=1&sec="+Sector);
					}else{

						$('#divlista').load("NaNbListaIzq.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}
			
			break 


	}
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

function BuscaLocal(){
	
	var local = document.getElementById("Local").value;
	
	if(local.length == 0){
		
		SoloBlock("ListaLocalDiv");
		SoloNone("Cuerpo, Pie, LetEnt");
	
		$('#divlistalocal').load("NaNbListaLocal.php?ban=1");

		document.getElementById("LetTex").value = "";
		
		Ir_a("LetTex",25,0);

		EnvAyuda("Escriba el Local que desea encontrar.");
	
	}else{
		$('#divlistalocal').load("NaNbListaLocal.php?ban=1&loc="+local);
	}
}

function envialocal(num,nom,dir){

	SoloBlock("Cuerpo, Pie, LetEnt");
	SoloNone("ListaLocalDiv");
	
	document.getElementById('Local').value = num;
	document.getElementById('Razon').value = nom;
	document.getElementById('Direccion').value = dir;
	
	EnvAyuda("Ingrese un número de Nota.");
	
	Ir_a("NumeroNota",3,1);
	
	$("#LocalDiv").css("border-color", "transparent");
	$("#NumeroNotaDiv").css("border-color", "#F90");	

	document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_NumNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Local();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
	
}

function Vol_Local(){
	
	$("#NumeroNotaDiv").css("border-color", "transparent");
	$("#LocalDiv").css("border-color", "#F90");	
	
	EnvAyuda("Ingrese el Local de Origen o Enter para listar.");
	
	Ir_a("Local",4,1);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaLocal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}

function Sig_NumNota(){

	var numnota = document.getElementById("NumeroNota").value;
	
	if(numnota.length == 0){
		
		jAlert('Dene ingresar un número de Nota.', 'Debo Retail - Global Business Solution');
		
	}else{
		
		$("#NumeroNotaDiv").css("border-color", "transparent");
		$("#SectorDiv").css("border-color", "#F90");	
	
		SoloNone("LocalOrigen");
		SoloBlock("Cuerpo, Pie, OriDes");
		
		document.getElementById("TituloA").innerHTML = "Origen: Otros";
		document.getElementById("TituloB").innerHTML = "Destino: Dep&oacute;sito";		
		
		EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");
	
		Ir_a("Sector",2,1);
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
		
	}
	
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

function BuscaLocalNB(){
	
	var local = document.getElementById("LocalNB").value;
	
	if(local.length == 0){
		
		SoloBlock("ListaLocalDiv");
		SoloNone("Cuerpo, Pie, LetEnt");
	
		$('#divlistalocal').load("NaNbListaLocal.php?ban=2");

		document.getElementById("LetTex").value = "";
		
		Ir_a("LetTex",25,0);

		EnvAyuda("Escriba el Local que desea encontrar.");
	
	}else{
		
		$('#divlistalocal').load("NaNbListaLocal.php?ban=2&loc="+local);

	}
	
}

function envialocalNB(num,nom,dir){

	SoloBlock("Cuerpo, Pie, LetEnt");
	SoloNone("ListaLocalDiv");
	
	document.getElementById('LocalNB').value = num;
	document.getElementById('RazonNB').value = nom;
	document.getElementById('DireccionNB').value = dir;
	
	$("#LocalNBDiv").css("border-color", "transparent");
	
	EnvAyuda("Presione Enter para confirmar el Local.");

	//Ir_a("LetTex",0,0);

	document.getElementById('LetEnt').innerHTML = '<button id="EnterNota" onclick="ConfirmaLocal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';



	document.getElementById('NumVol').innerHTML = '<button onclick="Vol_LocalNB();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';

	$("#EnterNota").focus();
}


function ConfirmaLocal(){
///////////////////////////////////////////////////////////
	$("#SectorDiv").css("border-color", "#F90");	

	SoloNone("LocalOrigenNB");
	SoloBlock("Cuerpo, Pie, OriDes");
	
	document.getElementById("TituloA").innerHTML = "Origen: Otros";
	document.getElementById("TituloB").innerHTML = "Destino: Dep&oacute;sito";		
	
	EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");

	Ir_a("Sector",2,1);
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="Vol_LocalNB();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
	
}

function Vol_LocalNB(){
	
	$("#LocalNBDiv").css("border-color", "#F90");	
	$("#SectorDiv").css("border-color", "transparent");

	SoloBlock("LocalOrigenNB");
	SoloNone("Pie, OriDes");
	
	EnvAyuda("Ingrese el Local de Origen o Enter para listar.");
	
	Ir_a("LocalNB",4,1);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaLocalNB();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}




function enviaarticuloIzq(sec, art, det, vta, dep, cost,codrub){

//////////////////////////////////////////////////////////////////////////////////////////////////////
//////	ACTUALIZO STOCK DEL ARTICULO  ////////////////////////////////////////////////////////////////
////////$("#archivos").load("NaNb/NaNbProcesa.php?act=1&sec="+sec+"&art="+art+"&codrub="+codrub);/////
//////////////////////////////////////////////////////////////////////////////////////////////////////

	document.getElementById("LetTex").value = "";
	
	var movtip = document.getElementById("MovTip").value;

	SoloNone("ListaSectorDiv");
	SoloBlock("Cuerpo, Pie, LetEnt");	

	switch (movtip){

		case '1':
			$("#archivos").load("NaNb/NaNbProcesa.php?traven=1&sec="+sec+"&art="+art+"&codrub="+codrub);
			
				document.getElementById("Sector").value = sec;
				document.getElementById("Producto").value = art;
				document.getElementById("Detalle").value = det;
				document.getElementById("Stock").value = vta;
				document.getElementById("StockAct").value = vta;
	
				document.getElementById("SectorD").value = sec;
				document.getElementById("ProductoD").value = art;
				document.getElementById("DetalleD").value = det;
				document.getElementById("StockD").value = vta;
				document.getElementById("StockActD").value = vta;
				
				ColorStock();
				
				document.getElementById("CostoD").value = dec(cost);

				$("#SectorDiv").css("border-color", "transparent");
				$("#ProductoDiv").css("border-color", "transparent");
				$("#SectorDivD").css("border-color", "#F90");
				
				Ir_a("SectorD",3,1);
						
				EnvAyuda("Ingrese el sector Destino.");
		
				document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			
			break 

//	VENTAS A DEPOSITOS (NB)  //		
		case '2':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break 

//	RETIRO A VENTAS (NB)  //		
		case '3':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break

//	RETIRO A DEPOSITOS (NB)  //		
		case '4':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = dep;
			document.getElementById("StockAct").value = dep;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break			 			

//	ROTURA VENTAS (NB)  //		
		case '5':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break

//	ROTURA VENTAS (NB)  //		
		case '6':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = dep;
			document.getElementById("StockAct").value = dep;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break					

//	ROTURA VENTAS (NB)  //		
		case '7':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break

		case '8':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = dep;
			document.getElementById("StockAct").value = dep;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break					

		case '9':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break	
			
		case '10':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = dep;
			document.getElementById("StockAct").value = dep;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break					

//	ATENCION AL CLIENTE (NB)  //		
		case '12':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break
				
		case '13':
			$("#archivos").load("NaNb/NaNbProcesa.php?traven=1&sec="+sec+"&art="+art+"&codrub="+codrub);
			
				document.getElementById("Sector").value = sec;
				document.getElementById("Producto").value = art;
				document.getElementById("Detalle").value = det;
				document.getElementById("Stock").value = vta;
				document.getElementById("StockAct").value = vta;
	
				document.getElementById("SectorD").value = sec;
				document.getElementById("ProductoD").value = art;
				document.getElementById("DetalleD").value = det;
				document.getElementById("StockD").value = vta;
				document.getElementById("StockActD").value = vta;
				
				ColorStock();
				
				document.getElementById("CostoD").value = dec(cost);

				$("#SectorDiv").css("border-color", "transparent");
				$("#ProductoDiv").css("border-color", "transparent");
				$("#SectorDivD").css("border-color", "#F90");
				
				Ir_a("SectorD",3,1);
						
				EnvAyuda("Ingrese el sector Destino.");
		
				document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			
			break 

		case '14':
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = dep;
			document.getElementById("StockAct").value = dep;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break

		case '15': 	//VENTAS -> VENTAS
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break
			
		case '16': 	//INGRESO DE OTROS LOCALES A DEPOSITO
			document.getElementById("Sector").value = sec;
			document.getElementById("Producto").value = art;
			document.getElementById("Detalle").value = det;
			document.getElementById("Stock").value = vta;
			document.getElementById("StockAct").value = vta;

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDiv").css("border-color", "transparent");
			$("#ProductoDiv").css("border-color", "transparent");
			$("#SectorDivD").css("border-color", "#F90");
			
			Ir_a("SectorD",3,1);
					
			EnvAyuda("Ingrese el sector Destino.");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
			
			break 

		case '17': 	//INGRESO DE OTROS LOCALES A DEPOSITO

				document.getElementById("Sector").value = sec;
				document.getElementById("Producto").value = art;
				document.getElementById("Detalle").value = det;
				document.getElementById("Stock").value = stock;
				document.getElementById("StockAct").value = stock;

				if(stock <= 0){
					$("#Stock").css({'color':'red'});
				}else{
					$("#Stock").css({'color':'#06F'});
				}

				document.getElementById("SectorD").value = sec;
				document.getElementById("ProductoD").value = art;
				document.getElementById("DetalleD").value = det;
				document.getElementById("StockD").value = stock;
				document.getElementById("StockActD").value = stock;

				if(stock <= 0){
					$("#StockD").css({'color':'red'});
				}else{
					$("#StockD").css({'color':'#06F'});
				}
				
				document.getElementById("CostoD").value = dec(cost);
				
				$("#SectorDiv").css("border-color", "transparent");
				$("#ProductoDiv").css("border-color", "#F90");
				
				Ir_a("Producto",4,1);

				EnvAyuda("Ingrese el articulo.");
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Articulo('+tn+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';

			break 
							
		default: 

	}

}




function enviaarticuloDer(sec, art, det, vta, dep, cost,codrub){

//////////////////////////////////////////////////////////////////////////////////////////////////////
//////	ACTUALIZO STOCK DEL ARTICULO  ////////////////////////////////////////////////////////////////
////////$("#archivos").load("NaNb/NaNbProcesa.php?act=1&sec="+sec+"&art="+art+"&codrub="+codrub);/////
//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	document.getElementById("LetTex").value = "";
	
	var movtip = document.getElementById("MovTip").value;

	SoloNone("ListaSectorDiv");
	SoloBlock("Cuerpo, Pie, LetEnt");	

	switch (movtip){

//	AJUSTE DE COMPRAS (NB)  //		
		case '1':

			var secori = document.getElementById("Sector").value;
			var artori = document.getElementById("Producto").value;
			
			if((secori == sec) && (artori == art)){
				
				jAlert('El Artículo seleccionado no puede ser cargado.', 'Debo Retail - Global Business Solution');
				
				document.getElementById('ProductoD').value = "";
			
				Ir_a("ProductoD",4,1);
				
				EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
			
				document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

			}else{

				document.getElementById("SectorD").value = sec;
				document.getElementById("ProductoD").value = art;
				document.getElementById("DetalleD").value = det;
				document.getElementById("StockD").value = vta;
				document.getElementById("StockActD").value = vta;
				
				document.getElementById("Stock").value = vta;
				document.getElementById("StockAct").value = vta;
	
				ColorStock();
							
				document.getElementById("CostoD").value = dec(cost);
				
				$("#SectorDivD").css("border-color", "transparent");
				$("#ProductoDivD").css("border-color", "transparent");
				$("#CantidadDivD").css("border-color", "#F90");
				
				Ir_a("CantidadD",4,1);
	
				EnvAyuda("Ingrese la cantidad a Mover.");
			
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			}
			
			break 

//	VENTAS A DEPOSITOS (NB)  //		
		case '2':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break 

//	RETIRO A VENTAS (NB)  //		
		case '3':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break 

//	RETIRO A DEPOSITOS (NB)  //		
		case '4':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '5':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '6':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '7':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '8':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '9':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '10':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = dep;
			document.getElementById("StockActD").value = dep;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break

		case '12':

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;

			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			
			break
/////////////
			
		case '13': 	//TRANSFERIR A VENTAS
			var secori = document.getElementById("Sector").value;
			var artori = document.getElementById("Producto").value;
			
			if((secori == sec) && (artori == art)){
				
				jAlert('El Artículo seleccionado no puede ser cargado.', 'Debo Retail - Global Business Solution');
				
				document.getElementById('ProductoD').value = "";
			
				Ir_a("ProductoD",4,1);
				
				EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
			
				document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';

			}else{

				document.getElementById("SectorD").value = sec;
				document.getElementById("ProductoD").value = art;
				document.getElementById("DetalleD").value = det;
				document.getElementById("StockD").value = vta;
				document.getElementById("StockActD").value = vta;
				
				document.getElementById("Stock").value = vta;
				document.getElementById("StockAct").value = vta;
	
				ColorStock();
							
				document.getElementById("CostoD").value = dec(cost);
				
				$("#SectorDivD").css("border-color", "transparent");
				$("#ProductoDivD").css("border-color", "transparent");
				$("#CantidadDivD").css("border-color", "#F90");
				
				Ir_a("CantidadD",4,1);
	
				EnvAyuda("Ingrese la cantidad a Mover.");
			
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			}
			
			break 

		case '14': 	//DEPOSITO -> VENTAS

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;
			
			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			
			break;

		case '15': 	//VENTAS -> VENTAS
			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;
			
			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			

			break;

		case '16':
			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = vta;
			document.getElementById("StockActD").value = vta;
			
			ColorStock();
						
			document.getElementById("CostoD").value = dec(cost);
			
			$("#SectorDivD").css("border-color", "transparent");
			$("#ProductoDivD").css("border-color", "transparent");
			$("#CantidadDivD").css("border-color", "#F90");
			
			Ir_a("CantidadD",4,1);

			EnvAyuda("Ingrese la cantidad a Mover.");
		
			document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			

			break;
			
		case '17':
			if(document.getElementById("SectorD").value.length == 0){	//BUSCA POR SECTOR
		
				$("#SectorDivD").css("border-color", "transparent");
				$("#ProductoDivD").css("border-color", "#F90");

				Ir_a("ProductoD",4,1);

				EnvAyuda("Ingrese el articulo.");
				
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Articulo(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';

			}else{														//BUSCA POR ARTICULO

				$("#ProductoDivD").css("border-color", "transparent");
				$("#CantidadDivD").css("border-color", "#F90");
				
				Ir_a("CantidadD",4,1);

				EnvAyuda("Ingrese la cantidad a Mover.");
			
				document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';			

			}

			document.getElementById("SectorD").value = sec;
			document.getElementById("ProductoD").value = art;
			document.getElementById("DetalleD").value = det;
			document.getElementById("StockD").value = stockD;
			document.getElementById("StockActD").value = stockD;
			if(stockD <= 0){
				$("#StockD").css({'color':'red'});
			}else{
				$("#StockD").css({'color':'#06F'});
			}
			
			document.getElementById("CostoD").value = dec(cost);

			break 				

		default: 
 
	}	


}

function ColorStock(){
	var origen = document.getElementById("Stock").value;
	var destino = document.getElementById("StockD").value;

	if(origen <= 0){
		$("#Stock").css({'color':'red'});
	}else{
		$("#Stock").css({'color':'#06F'});
	}
	
	if(destino <= 0){
		$("#StockD").css({'color':'red'});
	}else{
		$("#StockD").css({'color':'#06F'});
	}
}

function Vol_Sector(){
	
	pasa1 = 0;
	pasa2 = 0;
	
	SoloNone("ListaSectorDiv");
	SoloBlock("Cuerpo, Pie, LetEnt");
	
	$("#SectorDivD").css("border-color", "transparent");
	$("#ProductoDiv").css("border-color", "transparent");
	$("#SectorDiv").css("border-color", "#F90");
	
	document.getElementById("Sector").value = "";
	document.getElementById("Producto").value = "";
	document.getElementById("Detalle").value = "";
	document.getElementById("Stock").value = "";

	document.getElementById("SectorD").value = "";
	document.getElementById("ProductoD").value = "";
	document.getElementById("DetalleD").value = "";
	document.getElementById("StockD").value = "";
	document.getElementById("CostoD").value = "";

	EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");

	Ir_a("Sector",2,1);
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
}

function BuscaDestino(a){
	
	var stockD = document.getElementById("StockD").value;
	var movtip = document.getElementById("MovTip").value;
	var TN = document.getElementById("TN").value;

	var Sector = document.getElementById("SectorD").value;
	var Articulo = document.getElementById("ProductoD").value;
	
	switch (movtip){

		case '1':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 

		case '2':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=2");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=2&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=2&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 

		case '3':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 

		case '4':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '5':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '6':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '7':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '8':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '9':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 

		case '10':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 			

		case '12':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break
			
		case '13':
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 
					

		case '14': 	//DEPOSITO -> VENTAS
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 

		case '15': 	//VENTAS -> VENTAS
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 
			
		case '16': 	//VENTAS -> VENTAS
			if(Sector.length == 0){
			
				SoloBlock("ListaSectorDiv");
				SoloNone("Cuerpo, Pie");	
				$('#Bloquear').fadeIn(500);				

				$('#divlista').load("NaNbListaDer.php?busca=1");
				
			}else{

				if(a == 1){
					
					$("#ProductoDivD").css("border-color", "#F90");
					$("#SectorDivD").css("border-color", "transparent");
					
					Ir_a("ProductoD",4,1);
					
					EnvAyuda("Ingrese el Articulo de Destino o Enter para listar.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(2);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';
					
				}else{
					if(Articulo.length == 0){
						SoloBlock("ListaSectorDiv");
						SoloNone("Cuerpo, Pie");	
						$('#Bloquear').fadeIn(500);				
			
						$('#divlista').load("NaNbListaDer.php?busca=1&sec="+Sector);
					}else{
						$('#divlista').load("NaNbListaDer.php?busca=1&dato=1&sec="+Sector+"&art="+Articulo);
					}
				}
			}				
	
			break 
			
			
			
			
	}

	
	
	
}

function Vol_SectorD(){
	
	SoloNone("ListaSectorDiv");
	SoloBlock("Cuerpo, Pie, LetEnt");
		
	$("#ProductoDivD").css("border-color", "transparent");
	$("#CantidadDivD").css("border-color", "transparent");
	$("#SectorDivD").css("border-color", "#F90");
	
	document.getElementById("Stock").value = document.getElementById("StockAct").value;
	document.getElementById("StockD").value = document.getElementById("StockActD").value;
	
	Ir_a("SectorD",3,1);
			
	EnvAyuda("Ingrese el Sector o Enter para continuar.");

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaDestino(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Sector();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
	
}



function Sig_Cantidad(){

	var movtip = document.getElementById("MovTip").value;
	var tn = document.getElementById("TN").value;
	var cant = document.getElementById("CantidadD").value;
	var stockD = document.getElementById("StockD").value;
	var stock = document.getElementById("Stock").value;
	
	if(cant == 0){
		jAlert('Ingrese una contidad correcta.', 'Debo Retail - Global Business Solution');
	}else{

		switch (movtip){
			case '1':
				var c = document.getElementById("CanArt").value;
	
				if(parseInt(cant) <= parseInt(c)){
					document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
					document.getElementById("Stock").value = parseFloat(stock) - parseInt(cant);
					ColorStock();
				}else{
					jAlert('La Cantidad es superior a la registrada en el comprobante de Compras.', 'Debo Retail - Global Business Solution');
					Ir_a("CantidadD",4,1);
			
					EnvAyuda("Ingrese la cantidad a Mover.");
				
					document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cargar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
				
					document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';						

					return false;
				}
				break 
				
			case '2':
				
				document.getElementById("Stock").value = parseFloat(stock) - parseInt(cant);
				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				ColorStock();
				
				break 

			case '3':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break 
				
			case '4':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break

			case '5':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break
				
			case '6':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break

			case '7':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break

			case '8':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break

			case '9':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break
				
			case '10':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break
				
			case '12':
				
				document.getElementById("StockD").value = parseFloat(stockD) - parseInt(cant);
				ColorStock();
				
				break

			case '13':
	
				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				document.getElementById("Stock").value = parseFloat(stock) + parseInt(cant);
				ColorStock();

				break 

			case '14': 	//DEPOSITO -> VENTAS
				
				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				document.getElementById("Stock").value = parseFloat(stock) - parseInt(cant);
				ColorStock();

				break 
				
			case '15': 	//VENTAS -> VENTAS
				
				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				document.getElementById("Stock").value = parseFloat(stock) - parseInt(cant);
				ColorStock();

				break 

			case '16': 	//INGRESO OTROS LOCA A VENTAS

				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				document.getElementById("Stock").value = parseFloat(stock) + parseInt(cant);
				ColorStock();
				
				break 

			case '17': 	//INGRESO OTROS LOCA A DEPOSITOS

				document.getElementById("StockD").value = parseFloat(stockD) + parseInt(cant);
				document.getElementById("Stock").value = parseFloat(stock) + parseInt(cant);
				ColorStock();
				
				break 
				
			default: 

		}

////////////////////////////////////////////////////////////////////////////////////////////////

		$("#CantidadDivD").css("border-color", "transparent");
		
		Ir_a("TerminarCarga",0,1);
				
		EnvAyuda("Presione Continuar para Confirmar Movimiento.");
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cargar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntNaNb\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntaNb"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="Vol_Cantidad();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';

	}
}

function Vol_Cantidad(){
	
	SoloBlock("LetEnt");
	SoloNone("LetTer, ListaSectorDiv");

	$("#CantidadDivD").css("border-color", "#F90");

	Ir_a("CantidadD",4,1);
			
	EnvAyuda("Ingrese la cantidad a Mover.");

	document.getElementById('LetEnt').innerHTML = '<button onclick="Sig_Cargar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="Vol_SectorD();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';						

}

function Sig_Cargar(){
	
	AgregarItem();
	
	SoloBlock("LetEnt, ListaArticulos, LetTer");
		
	$("#SectorDiv").css("border-color", "#F90");	
	
	document.getElementById("Sector").value = "";
	document.getElementById("Producto").value = "";
	document.getElementById("Detalle").value = "";
	document.getElementById("Stock").value = "";

	document.getElementById("SectorD").value = "";
	document.getElementById("ProductoD").value = "";
	document.getElementById("DetalleD").value = "";
	document.getElementById("StockD").value = "";
	document.getElementById("CostoD").value = "";
	document.getElementById("CantidadD").value = "";

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen(1);" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button onclick="TerminarNota();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerNaNb\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerNaNb"/></button>';	

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

	EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");

	Ir_a("Sector",2,1);

}


var TOTAL_GRAL = 0.00;
var filas = 0;

var cc = 0;
var capa = 1;
var cN = 0;
var t = 0;


function AgregarItem(){
	
	filas++
	
	var sec = document.getElementById("Sector").value;
	var pro = document.getElementById("Producto").value;
	var det = document.getElementById("Detalle").value;
	det = det.substring(0,15);
	var stock = document.getElementById("Stock").value;
	
	var codigoizq = sec +"-"+ pro;

	var secd = document.getElementById("SectorD").value;
	var prod = document.getElementById("ProductoD").value;
	var detd = document.getElementById("DetalleD").value;
	detd = detd.substring(0,15);	
	var cosd = document.getElementById("CostoD").value;
	var cand = document.getElementById("CantidadD").value;

	var tot = parseFloat(cand) * parseFloat(cosd);
	var codigodder = secd +"-"+ prod;
	
	if(filas > 7){
		capa = capa + parseInt(1);

	}


cc = cc + 1;
cN = cN + 1;

if(cc == 1){
		
	$("#CuerpoListaCI").append("<div id=\"comcapasitems"+capa+"\" style=\"display: block; left:2px; position:absolute;\">");
				
	if(capa != 1){

		$("#comcapasitems"+capa).append("<div id=\"Ant_Pro_TiC"+capa+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:460px; top:162px;\"><button class=\"StyBoton\" onclick=\"return movant_com("+capa+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AntProTiC','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"AntProTiC\"/></button></div>");
		
		cnp = capa - 1;
		$("#comcapasitems"+cnp).fadeOut(400);
		$("#comcapasitems"+capa).fadeIn(400);
		
		$("#comcapasitems"+cnp).append("<div id=\"Aba_Pro_TiC"+cnp+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:420px; top:162px;\"><button class=\"StyBoton\" onclick=\"return movaba_com("+cnp+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AbaProTiC','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"AbaProTiC\"/></button></div>");
		
	}

}

////	LISTA DE ARTICULOS    ////
	if(filas <= 8 ){
	$('#Lista').append('<tr id='+filas+'><td><div style="background:url(NaNb/fon-org-b.png); width:261px; height:17px; position:absolute;"><div id="ItemOrigen" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:0px; width:64px; cursor:pointer; text-align:center;">'+filas+'</div><div id="CodigoOrigen'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:73px; width:62px; cursor:pointer; text-align:center;"">'+codigoizq+'</div><div id="DetalleOrigen'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:149px; width:112px; cursor:pointer;">'+det+'</div></div><div style="background:url(NaNb/fon-des-n.png); width:346px; height:17px; position:absolute; left:282px;"><div id="CodigoDestino'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:2px; width:64px; cursor:pointer; text-align:center;">'+codigodder+' </div><div id="DetalleDestino'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:76px; width:113px; cursor:pointer;">'+detd+'</div><div id="CantDestino'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:194px; width:37px; cursor:pointer; text-align:center;">'+cand+'</div><div id="CostoDestino'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:240px; width:35px; cursor:pointer; text-align:center;">'+dec(cosd,2)+'</div><div id="TotalDestino'+filas+'" class="FuenteNaNbLista" style="color:#000; position:absolute; top:2px; left:286px; width:52px; cursor:pointer; text-align:right">'+dec(tot,2)+'</div></div></td></tr>')

	
	TOTAL_GRAL = parseFloat(TOTAL_GRAL) + parseFloat(tot);

	document.getElementById("Total").innerHTML = dec(TOTAL_GRAL);

	pasa1 = 0;
	pasa2 = 0;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function TerminarNota(){
	var movtip = document.getElementById("MovTip").value;
	var tn = document.getElementById("TN").value;
	var Ope = document.getElementById("OpeVal").value;

	if(tn == 1){
		var tipo = "Nota de Alta";
	}else{
		var tipo = "Nota de Baja";
	}
	
	var Origen;
	var Destino;
	
	switch (movtip){
		case '1':	
			Origen = "Ventas/Depósitos";
			Destino = "Ajuste";
			break 
			
		case '2':
			Origen = "Ventas";
			Destino = "Depósitos";
			break 

		case '3':	
			Origen = "Ventas";
			Destino = "Retiro Vtas.";
			break 			

		case '4':	
			Origen = "Depósitos";
			Destino = "Retiro Dep.";
			break 			

		case '5':	
			Origen = "Ventas";
			Destino = "Rotura";
			break 			

		case '6':	
			Origen = "Depósitos";
			Destino = "Rotura";
			break

		case '7':	
			Origen = "Ventas";
			Destino = "Vencimientos";
			break 			

		case '8':	
			Origen = "Depósitos";
			Destino = "Vencimientos";
			break

		case '9':	
			Origen = "Otros";
			Destino = "Depósitos";
			break
			
		case '10':	
			Origen = "Depósitos";
			Destino = "Otros";
			break

		case '12':	
			Origen = "Ventas";
			Destino = "At. al Cliente";
			break
						
		case '13':	
			Origen = "Ajuste";
			Destino = "Ventas/Depósitos";
			break 
			
		case '14':	
			Origen = "Deposito";
			Destino = "Ventas";
			break 

		case '15':	
			Origen = "Ventas";
			Destino = "Ventas";
			break 			

		case '16':	
			Origen = "Ing. Otros Locales";
			Destino = "Ventas";
			break 			
			
		case '17':	
			Origen = "Ing. Otros Locales";
			Destino = "Deposito";
			break 			
			
		default: 

	}

	jConfirm("¿Grabar Movimiento "+tipo+" ?. Origen: "+Origen+" -> Destino: "+Destino, "Debo Retail - Global Business Solution", function(r){
		if(r == true ){

			var i = 1;

			var Local = document.getElementById("Local").innerHTML;
			//var CodOri = document.getElementById("CodigoOrigen"+i).innerHTML;

			$('#Bloquear').fadeIn(500);
			
			for( i ; i <= filas ; i++){

				var CodOri = document.getElementById("CodigoOrigen"+i).innerHTML;
				var CodDes = document.getElementById("CodigoDestino"+i).innerHTML;
				var CanD = document.getElementById("CantDestino"+i).innerHTML;
				var CosD = document.getElementById("CostoDestino"+i).innerHTML;
				var TotD = document.getElementById("TotalDestino"+i).innerHTML;

				switch (movtip){

					case '1':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						document.getElementById("CanArt").value = "";
						break 

					case '2':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break 
						
					case '3':	
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break
												
					case '4':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break

					case '5':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break

					case '6':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break

					case '7':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break

					case '8':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break

					case '9':
						var Local = document.getElementById("LocalNB").value;
						
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&local="+Local+"&cd="+CodDes);
						break
					
					case '10':
						var Local = document.getElementById("LocalNB").value;
						
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&local="+Local+"&cd="+CodDes);
						break

					case '12':
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break
						
					case '13':	
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break 
						
					case '14':	
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break 
			
					case '15':	
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&cd="+CodDes);
						break 			
			
					case '16':	
						var Local = document.getElementById("Local").value;
						var NumNota = document.getElementById("NumeroNota").value;
						
						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&local="+Local+"&numnota="+NumNota+"&cd="+CodDes);
						break 			
						
					case '17':	
						var Local = document.getElementById("Local").value;
						var NumNota = document.getElementById("NumeroNota").value;

						$("#archivos").load("NaNb/NaNbProcesa.php?ter=1&movtip="+movtip+"&tn="+tn+"&i="+i+"&ope="+Ope+"&co="+CodOri+"&candes="+CanD+"&cosdes="+CosD+"&local="+Local+"&numnota="+NumNota+"&cd="+CodDes);
						break 			
						
					default: 
			
				}
			}
/////////////////////////////////////////////////
			genera_pdf();
/////////////////////////////////////////////////

		}
	});	
}

function genera_pdf(){

	if(document.getElementById("TN").value == 1){
		document.getElementById("TCO").value = "NA";
	}else{
		document.getElementById("TCO").value = "NB";
	}
	
	document.getElementById("NCO").value = document.getElementById("Num").value;
	document.getElementById("TIM").value = document.getElementById("MovTip").value;

	document.getElementById("EXI_ANT").value = document.getElementById("StockAct").value;
	document.getElementById("EXI_ANTD").value = document.getElementById("StockActD").value;
/*
	document.getElementById("TEXT01").value = document.getElementById("").value;
	document.getElementById("TEXT02").value = document.getElementById("").value;
	document.getElementById("TEXT03").value = document.getElementById("").value;
	document.getElementById("TEXT04").value = document.getElementById("").value;
	document.getElementById("TEXT05").value = document.getElementById("").value;
	document.getElementById("TEXT06").value = document.getElementById("").value;
*/
	
	
	
	$('#Bloquear').fadeIn(500);
	$('#genera').submit();
}

function ImpreVolNaNb(){

	SoloNone('ImpresionPdfDiv, Marca, LetTer');
	
/*

	EnvAyuda("Presione Enter para Agregar un Nuevo Inventario");

	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_tom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';

	document.getElementById('LetEnt').innerHTML = '<button onclick="trae_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
*/
	$("#NaNb").load("NaNb.php");
/*	
	SoloNone("BotonesPri, NumVol, LetTer");
	SoloBlock('NaNb');
*/	
}


////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

////	LISTA DE ARTICULOS

function movant_com(p){

	np = p - 1;
	document.getElementById('comcapasitems'+p).style.display="none";	
	document.getElementById('comcapasitems'+np).style.display="block";

}

function movaba_com(p){

	np = p + 1;
	document.getElementById('comcapasitems'+p).style.display="none";	
	document.getElementById('comcapasitems'+np).style.display="block";

}

var cc = 0;
var cs = 1;
var cN = 0;

function NuevoIFC(ccs,cca,ccp,ccc,ccd){

var comenzar = document.getElementById('ComenzarCom').value;

if(comenzar == 0){
	cc = 0;
	cs = 1;
	cN = 0;
	document.getElementById('ComenzarCom').value = 1;
}
if(comenzar == 2){
	
	var pdv = document.getElementById('ComenzarComV2').value;
	pdv = parseInt(pdv);
	
	var i = pdv;
	var c = 6;
	
	var pe = i / c;
	pe = parseInt(pe);

	var va = pe * c;
	va = i - va;

	cc = va;
	cs = pe + 1;
	cN = i;
	document.getElementById('ComenzarCom').value = 1;
}

	cN = cN + 1;
	cc = cc + 1;
	
	if (cc == 1){
			
		$("#CuerpoListaCI").append("<div id=\"comcapasitems"+cs+"\" style=\"display: block; left:2px; position:absolute;\">");
					
		if(cs != 1){

			$("#comcapasitems"+cs).append("<div id=\"Ant_Pro_TiC"+cs+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:642px; top:27px;\"><button class=\"StyBoton\" onclick=\"return movant_com("+cs+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AntProTiC','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"AntProTiC\"/></button></div>");
			
			cnp = cs - 1;
			$("#comcapasitems"+cnp).fadeOut(tim);
			$("#comcapasitems"+cs).fadeIn(tim);
			
			$("#comcapasitems"+cnp).append("<div id=\"Aba_Pro_TiC"+cnp+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:642px; top:156px;\"><button class=\"StyBoton\" onclick=\"return movaba_com("+cnp+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('AbaProTiC','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"AbaProTiC\"/></button></div>");
			
		}

	}

	EnvAyuda("Ingrese código de barras.");
	
	var cst = document.getElementById('CDat10').value;
	var ccp_v = document.getElementById('CDat8-2').value;
	var dep = document.getElementById('CDat11-2').value;	
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	if(ccs == 0 && cca == 0){
		var det = ccd.replace(/ /g, "~");
		$("#archivos").load("NCArt.php?xd=0&cs="+ccs+"&ca="+cca+"&cc="+ccc+"&cp="+ccp+"&cd="+det);
	}else{
		$("#archivos").load("NCArt.php?xd=0&cs="+ccs+"&ca="+cca+"&cc="+ccc+"&cp="+ccp);
	}
	
	$("#comcapasitems"+cs).append("<div id=\"itmesdecom"+cN+"\"><div class=\"itemslista\" onclick=\"env_ite_c("+ccs+","+cca+","+cN+");\"><table width=\"640\" cellpadding=\"0\" cellspacing=\"1\" align=\"center\" border=\"0\"><tr><td class=\"CCom\" width=\"21\"><div align=\"center\">"+cN+"</div></td><td class=\"CCom\" width=\"61\"><div align=\"center\">"+ccs+" - "+cca+"</div></td><td class=\"CCom\" width=\"65\"><div align=\"center\">"+ccc+"</div></td><td class=\"CCom\" width=\"156\"><div align=\"left\">"+ccd.substr(0,25)+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp_v+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+ccp+"</div></td><td class=\"CCom\" width=\"92\"><div align=\"center\">"+cst+"</div></td><td class=\"CCom\" width=\"38\"><div align=\"center\">"+dep+"</div></td></tr></table></div></div>");

	if (cc == 6){
		
		cc = 0; 
        cs = cs + 1;
		
	}
}


function BuscaSucursal(){

	var suc = document.getElementById("Sucursal").value;
	var tip = document.getElementById("Tipo").value;
	var tco = document.getElementById("Tco").value;
	var num = document.getElementById("Numero").value;

	if(suc.length == 0){
		//jAlert('La Sucursar ingresada no existe.', 'Debo Retail - Global Business Solution');

		//$('#Bloquear').fadeIn(500);
	
		SoloNone('NotaCuerpo, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon');
		SoloBlock('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis');
		
		$("#LisFacComLis").load("NaNbListaComprobantes.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&cod="+num);

	}else{
		
		EnvAyuda("Ingrese Tco: A - B - C - R.");
		
		$("#SucursalDiv").css("border-color", "transparent");
		$("#TipoDiv").css("border-color", "#F90");
	
		Ir_a("Tipo",1,2);
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaTipo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolSucursal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

	}
}

function SalLisComprobantes(){

	SoloBlock('NotaCuerpo, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon');
	SoloNone('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis, LisFacComDat, BotonesLisTarMod');
}


function VolSucursal(){

	EnvAyuda("Ingrese la Sucursal o Enter para listar.");

	$("#TipoDiv").css("border-color", "transparent");
	$("#SucursalDiv").css("border-color", "#F90");

	Ir_a("Sucursal",4,1);
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaSucursal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
}

function BuscaTipo(){
	
	var tip = document.getElementById("Tipo").value;
	tip = tip.toUpperCase();
	if(!(tip.length == 1 && (tip == "A" || tip == "B" || tip == "C" || tip == "R" ))){
		
		jAlert('El Tipo ingresado no existe.', 'Debo Retail - Global Business Solution');
		document.getElementById("Tipo").value = "";
	}else{
	
		EnvAyuda("Ingrese Tco: CI - DI - FT - NC - ND - NI - RE - SA.");
	
		$("#TipoDiv").css("border-color", "transparent");
		$("#TcoDiv").css("border-color", "#F90");
	
		Ir_a("Tco",2,2);
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaTco();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolTipo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	}
}

function VolTipo(){
	
	EnvAyuda("Ingrese Tco: A - B - C - R.");

	$("#TcoDiv").css("border-color", "transparent");
	$("#TipoDiv").css("border-color", "#F90");

	Ir_a("Tipo",1,2);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaTipo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolSucursal();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}

function BuscaTco(){
	
	var tco = document.getElementById("Tco").value;
	tco = tco.toUpperCase();
	if(!(tco.length == 2 && (tco == "CI" || tco == "DI" || tco == "FT" || tco == "NC" || tco == "ND" || tco == "NI" || tco == "RE" || tco == "SA"))){

		jAlert('El Tco ingresado no existe.', 'Debo Retail - Global Business Solution');
		document.getElementById("Tco").value = "";
	}else{
	
		EnvAyuda("Ingrese el n&uacute;mero.");
	
		$("#TcoDiv").css("border-color", "transparent");
		$("#NumeroDiv").css("border-color", "#F90");
	
		Ir_a("Numero",6,1);
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaNumero();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolTco();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
	}
}

function VolTco(){
	
	EnvAyuda("Ingrese Tco: CI - DI - FT - NC - ND - NI - RE - SA.");

	$("#NumeroDiv").css("border-color", "transparent");
	$("#TcoDiv").css("border-color", "#F90");

	Ir_a("Tco",2,2);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaTco();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolTipo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}

function BuscaNumero(){
	var suc = document.getElementById("Sucursal").value;
	var tip = document.getElementById("Tipo").value;
	var tco = document.getElementById("Tco").value;
	var num = document.getElementById("Numero").value;

	if(num.length == 0){

		jAlert('El N&uacute;mero ingresado no existe.', 'Debo Retail - Global Business Solution');

	}else{

		SoloNone('NotaCuerpo, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, CarAyuda, CarAyudaFon');
		SoloBlock('LisFacComFon, LisFacComFon2, TituloLis, TituloNom, TituloLisFac, LisFacComLis, BotonesLis');
		
		$("#LisFacComLis").load("NaNbListaComprobantes.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&cod="+num);

	}
}

function VolNumero(){
	
	EnvAyuda("Ingrese el n&uacute;mero.");

	$("#ProveedorIdDiv").css("border-color", "transparent");
	$("#NumeroDiv").css("border-color", "#F90");

	Ir_a("Numero",6,1);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaNumero();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolTco();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}

function BuscaProveedor(){
	
	var proId = document.getElementById("ProveedorId").value;
	if(proId.length == 0){

		jAlert('El Proveedor ingresado no existe.', 'Debo Retail - Global Business Solution');

	}else{

		//alert("Hace Algo");
		
		EnvAyuda("Ingrese el Proveedor.");
	
		$("#ProveedorIdDiv").css("border-color", "transparent");
		$("#ProveedorDiv").css("border-color", "#F90");
	
		document.getElementById("DondeE").value = "Proveedor";
		document.getElementById("CantiE").value = "4";
		document.getElementById("QuePoE").value = "1";
	
		document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaProveedor();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';
	
		document.getElementById('NumVol').innerHTML = '<button onclick="VolNumero();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
	
	}
}

function VolProveedor(){
	
	EnvAyuda("Ingrese el Proveedor.");

	$("#ProveedorDiv").css("border-color", "transparent");
	$("#ProveedorIdDiv").css("border-color", "#F90");

	document.getElementById("DondeE").value = "ProveedorId";
	document.getElementById("CantiE").value = "4";
	document.getElementById("QuePoE").value = "1";

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaProveedor();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolNumero();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	

}

function ConfirmaCompr(){
	
	SoloNone("LetTer, Comprobante");
	SoloBlock("LetEnt, OriDes");	

	var tn = document.getElementById("TN").value;
	if(tn == 1){
		document.getElementById("TituloA").innerHTML = "Origen: Ajuste";
		document.getElementById("TituloB").innerHTML = "Destino: Ventas/Depósito";
	}else{
		document.getElementById("TituloA").innerHTML = "Destino: Ventas/Depósito";
		document.getElementById("TituloB").innerHTML = "Origen: Ajuste";
	}
	EnvAyuda("Ingrese el Sector de Origen o Enter para listar.");

	$("#SectorDiv").css("border-color", "#F90");

	SoloBlock("Cuerpo, Pie");
	
	Ir_a("Sector",4,1);

	document.getElementById('LetEnt').innerHTML = '<button onclick="BuscaOrigen();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv3\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv3"/></button>';

	document.getElementById('NumVol').innerHTML = '<button onclick="VolOperacion();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv0\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv0"/></button>';	
}