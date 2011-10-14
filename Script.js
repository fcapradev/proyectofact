// JavaScript Document

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

/*************************************************************************************************************************/
function Mos_Ocuu(){
	document.getElementById("BarraPro").style.display="none";
	document.getElementById("BotonesPri").style.display="block";
	document.getElementById("Marca").style.display="block";
	$("#BotonesPri").load("BotonesPri.php");
}
/*************************************************************************************************************************/

jQuery.preloadImages = function(){
  for(var i = 0; i<arguments.length; i++){
    jQuery("<img>").attr("src", arguments[i]);
  }
}


////////////////////////////////////////////////////////////////
///// Para utilizar el script y cargar tus im�genes: ///////////
////////////////////////////////////////////////////////////////
function CargarImagenes(){
	
$.preloadImages("botones/abr-over.png", "botones/abr-up.png", "botones/ace-over.png", "botones/ace-up.png", "botones/agr-gas-over.png", "botones/agr-gas-up.png", "botones/agr-ret-over.png", "botones/agr-ret-up.png", "botones/alf-over.png", "botones/alf-up.png", "botones/anu-over.png", "botones/anu-up.png", "botones/can-over.png", "botones/can-up.png", "botones/cer-over.png", "botones/cer-up.png", "botones/cod-over.png", "botones/cod-up.png", "botones/con-over.png", "botones/con-up.png", "botones/cta-over.png", "botones/cta-up.png", "botones/eli-over.png", "botones/eli-up.png", "botones/ent-over.png", "botones/ent-up.png", "botones/eve-over.png", "botones/eve-up.png", "botones/imp-over.png", "botones/imp-up.png", "botones/mod-over.png", "botones/mod-up.png", "botones/pro-over.png", "botones/pro-up.png", "botones/sal-over.png", "botones/sal-up.png", "botones/ter-over.png", "botones/ter-up.png", "botones/vol-over.png", "botones/vol-up.png", "teclado/Letras/A-over.png", "teclado/Letras/A-up.png", "teclado/Letras/B-over.png", "teclado/Letras/B-up.png", "teclado/Letras/BO-over.png", "teclado/Letras/BO-up.png", "teclado/Letras/C-over.png", "teclado/Letras/C-up.png", "teclado/Letras/CE-over.png", "teclado/Letras/CE-up.png", "teclado/Letras/CO-over.png", "teclado/Letras/CO-up.png", "teclado/Letras/D-over.png", "teclado/Letras/D-up.png", "teclado/Letras/E-over.png", "teclado/Letras/E-up.png", "teclado/Letras/F-over.png", "teclado/Letras/F-up.png", "teclado/Letras/G-over.png", "teclado/Letras/G-up.png", "teclado/Letras/H-over.png", "teclado/Letras/H-up.png", "teclado/Letras/I-over.png", "teclado/Letras/I-up.png", "teclado/Letras/J-over.png", "teclado/Letras/J-up.png", "teclado/Letras/K-over.png", "teclado/Letras/K-up.png", "teclado/Letras/L-over.png", "teclado/Letras/L-up.png", "teclado/Letras/M-over.png", "teclado/Letras/M-up.png", "teclado/Letras/N-over.png", "teclado/Letras/N-up.png", "teclado/Letras/O-over.png", "teclado/Letras/O-up.png", "teclado/Letras/P-over.png", "teclado/Letras/P-up.png", "teclado/Letras/Q-over.png", "teclado/Letras/Q-up.png", "teclado/Letras/R-over.png", "teclado/Letras/R-up.png", "teclado/Letras/S-over.png", "teclado/Letras/S-up.png", "teclado/Letras/T-over.png", "teclado/Letras/T-up.png", "teclado/Letras/U-over.png", "teclado/Letras/U-up.png", "teclado/Letras/V-over.png", "teclado/Letras/V-up.png", "teclado/Letras/W-over.png", "teclado/Letras/W-up.png", "teclado/Letras/X-over.png", "teclado/Letras/X-up.png", "teclado/Letras/Y-over.png", "teclado/Letras/Y-up.png", "teclado/Letras/Z-over.png", "teclado/Letras/Z-up.png", "teclado/numeros/0-over.png", "teclado/numeros/0-up.png", "teclado/numeros/1-over.png", "teclado/numeros/1-up.png", "teclado/numeros/2-over.png", "teclado/numeros/2-up.png", "teclado/numeros/3-over.png", "teclado/numeros/3-up.png", "teclado/numeros/4-over.png", "teclado/numeros/4-up.png", "teclado/numeros/5-over.png", "teclado/numeros/5-up.png", "teclado/numeros/6-over.png", "teclado/numeros/6-up.png", "teclado/numeros/7-over.png", "teclado/numeros/7-up.png", "teclado/numeros/8-over.png", "teclado/numeros/8-up.png", "teclado/numeros/9-over.png", "teclado/numeros/9-up.png", "teclado/numeros/AS-over.png", "teclado/numeros/AS-up.png", "teclado/numeros/BA-over.png", "teclado/numeros/BA-up.png", "teclado/numeros/CE-over.png", "teclado/numeros/CE-up.png", "teclado/numeros/CO-over.png", "teclado/numeros/CO-up.png", "teclado/numeros/esc.png", "teclado/numeros/SU-over.png", "teclado/numeros/SU-up.png", "PanPrin/ab-tur-over.png", "PanPrin/ab-tur-up.png", "PanPrin/anu-over.png", "PanPrin/anu-up.png", "PanPrin/arq-caj-over.png", "PanPrin/arq-caj-up.png", "PanPrin/car-inv-over.png", "PanPrin/car-inv-up.png", "PanPrin/cer-tur-over.png", "PanPrin/cer-tur-up.png", "PanPrin/che-over.png", "PanPrin/che-up.png", "PanPrin/cip-over.png", "PanPrin/cip-up.png", "PanPrin/cli-over.png", "PanPrin/cli-up.png", "PanPrin/com-over.png", "PanPrin/com-up.png", "PanPrin/cta-cte-over.png", "PanPrin/cta-cte-up.png", "PanPrin/fac-over.png", "PanPrin/fac-up.png", "PanPrin/gas-over.png", "PanPrin/gas-up.png", "PanPrin/mov-over.png", "PanPrin/mov-up.png", "PanPrin/nov-over.png", "PanPrin/nov-up.png", "PanPrin/per-ope-over.png", "PanPrin/per-ope-up.png", "PanPrin/pro-over.png", "PanPrin/pro-up.png", "PanPrin/rec-over.png", "PanPrin/rec-up.png", "PanPrin/ret-efe-over.png", "PanPrin/ret-efe-up.png", "PanPrin/sal-over.png", "PanPrin/sal-up.png", "PanPrin/tar-over.png", "PanPrin/tar-up.png", "PanPrin/tic-emi-over.png", "PanPrin/tic-emi-up.png", "PanPrin/tom-inv-over.png", "PanPrin/tom-inv-up.png");

}

/*************************************************************************************************************************/
/*************** str_pad *************************************************************************************************/
function str_pad(input, pad_length, pad_string, pad_type) {
    // Returns input string padded on the left or right to specified length with pad_string  
    // 
    // version: 1103.1210
    // discuss at: http://phpjs.org/functions/str_pad
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + namespaced by: Michael White (http://getsprink.com)
    // +      input by: Marco van Oort
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
    // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
    // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
    // *     returns 2: '------Kevin van Zonneveld-----'
    var half = '',
        pad_to_go;
 
    var str_pad_repeater = function (s, len) {
        var collect = '',
            i;
 
        while (collect.length < len) {
            collect += s;
        }
        collect = collect.substr(0, len);
 
        return collect;
    };
 
    input += '';
    pad_string = pad_string !== undefined ? pad_string : ' ';
 
    if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
        pad_type = 'STR_PAD_RIGHT';
    }
    if ((pad_to_go = pad_length - input.length) > 0) {
        if (pad_type == 'STR_PAD_LEFT') {
            input = str_pad_repeater(pad_string, pad_to_go) + input;
        } else if (pad_type == 'STR_PAD_RIGHT') {
            input = input + str_pad_repeater(pad_string, pad_to_go);
        } else if (pad_type == 'STR_PAD_BOTH') {
            half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
            input = half + input + half;
            input = input.substr(0, pad_length);
        }
    }
 
    return input;
}
/*************************************************************************************************************************/
/*************************************************************************************************************************/

function SoloBlock(id){
		
	var cu = id.split(", ");
	for (var i=0; i < cu.length; i++){
		if ($('#'+cu[i]).length > 0){
	 		document.getElementById(cu[i]).style.display="block";	
		}else{
			jAlert('SoloBlock: El elemento no existe. '+cu[i], 'Debo Retail - Global Business Solution');
		}
	}
	
}

function SoloNone(id){
		
	var cu = id.split(", ");
	for (var i=0; i < cu.length; i++){
		if ($('#'+cu[i]).length > 0){
	 		document.getElementById(cu[i]).style.display="none";
		}else{
			jAlert('SoloNone: El elemento no existe. '+cu[i], 'Debo Retail - Global Business Solution');
		}
	}

}

function TNValue(id){
	var v = document.getElementById(id).value;
	return parseInt(v,10);
}

function TValue(id){
	var v = document.getElementById(id).value;
	return v;
}

function LValue(id){
	var v = document.getElementById(id).value.length;
	return parseInt(v,10);
}

function IValue(id,va){
	document.getElementById(id).value = va;
}

function BValue(id){
	document.getElementById(id).value = "";
}


/*************************************************************************************************************************/
/*************************************************************************************************************************/

/*************************************************************************************************************************/
/*************************************************************************************************************************/


var tim = 800;

$(document).ready(function(){
	
	$("#SobreFoca").click(function(event){
		event.preventDefault();
		$("#MosAyuda1").fadeIn(800);
		$("#MosAyuda2").fadeIn(800);
		$("#BotonesPri").fadeOut(800);
		SoloNone("ProcesoSusp");
	});
	
	$("#Cerrar").click(function(event){
		event.preventDefault();
		$("#MosAyuda1").fadeOut(800);
		$("#MosAyuda2").fadeOut(800);
		$("#BotonesPri").fadeIn(800);
		SoloBlock("ProcesoSusp");
	});

});

/*************************************************************************************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/

function mouseMove(e) {
	document.getElementById("ejeX").value = (document.all)?event.x+document.body.scrollLeft:e.pageX;
	document.getElementById("ejeY").value = (document.all)?event.y+document.body.scrollTop:e.pageY;
}

function init() {
	if (!document.all) document.captureEvents(Event.MOUSEMOVE);
	document.onmousemove = mouseMove;
}

function prende() {
	anclas=document.getElementsByTagName("a").length;
    for (i=0;i<anclas;i++)
    document.getElementsByTagName("a").item(i).onfocus=new Function("if(this.blur)this.blur()")
}

/*************************************************************************************************************************/
/*************************************************************************************************************************/
/*************************************************************************************************************************/

function validateMultipleEmailsCommaSeparated(value) { 
    var result = value.split(","); 
	for(var i = 0;i < result.length;i++)    
    return false;
} 

/*************************************************************************************************************************/

function Mos_Ocu(iden){

var e=document.getElementById(iden);

if(!e){
	
	alert("El elemento <"+iden+"> no existe.");
	
}else{
		
	con=document.getElementById(iden).style.display;
	
		if(con=='block'){
			document.getElementById(iden).style.display="none";
		}else{
			document.getElementById(iden).style.display="block";
		}
		if(con==''){
			document.getElementById(iden).style.display="block";
		}else{
			document.getElementById(iden).style.display="none";
		}
		if(con=='none'){
			document.getElementById(iden).style.display="block";
		}else{
			document.getElementById(iden).style.display="none";
		}
		
	
		if(iden == 'BotonesPri'){
			
			$("#"+iden).load(iden+".php");
					
		}
		if(iden == 'TecladoLet'){
			
			document.getElementById("LetTex").value = "";
			
		}
			
		if(iden == 'AperturaTurno'){
			
			$("#"+iden).load(iden+".php?co=1");
			
		}
	
		if(iden == 'Facturador'){
			
			$("#"+iden).load(iden+".php");
		
		}
		
		if(iden == 'CierreTurno'){
			
			$("#"+iden).load(iden+".php");
			
		}
		
		if(iden == 'FacturadorMa'){
			
			$("#"+iden).load(iden+".php");
		
		}
		
		if(iden == 'Compras'){
			
			$("#"+iden).load(iden+".php");
		
		}
		
	}

}

/*************************************************************************************************************************/

function fun(){	
	location.reload();
	clearTimeout(timerID);
}

function funfun(){
			
	var c = document.getElementById("usua").value.length;	
	if(c == 0){
		return false;
	}else{
		EnvError('<br /><b style="color:#FF0000">En unos segundos ser� redirigido al sistema. Gracias.</b>');
		timerID = setTimeout("fun()", 2000);
		return true;
	}
	
}

function AccBotPri(P){

	$('#Bloquear').fadeIn(500);
	SoloNone("ProcesoSusp");
	document.getElementById('AccBotPriDis'+P).disabled = true;	
	$("#archivos").load("RTur.php?a="+P);

}

function AnaLet(let){

	var xdv = document.getElementById("YaFac").value;

	var vQuePoE = "QuePoE";
	var vCantiE = "CantiE";
	var vDondeE = "DondeE";
	if(xdv == 2){ }
	if(xdv == 3){ }
	
	var q = document.getElementById(vQuePoE).value;
	var c = document.getElementById(vCantiE).value;
	var d = document.getElementById(vDondeE).value;
	
	var cu = d.split(", ");
	
	for (var i=0; i < cu.length; i++){
		
		var texto = document.getElementById(cu[i]).value;
		var	cant = document.getElementById(cu[i]).value.length;
	
		if(let=="BO" || let=="CO" || let=="CE" || let=="ES"){
			
			if(q == 6){
				
					if(let=="BO"){
						numeroLetras=texto.length-1
						texto=texto.substring(0,numeroLetras);
					}
					if(let=="CE"){
						texto="";
					}
				document.getElementById(cu[i]).value = texto;
				return false;
				
			}
			if(q == 3){
				
				if(let=="BO"){
					numeroLetras=texto.length-1
					texto=texto.substring(0,numeroLetras);
				}
				if(let=="CE"){
					texto="";
				}
				
			}else{
				
				if(let=="BO"){
					numeroLetras=texto.length-1
					texto=texto.substring(0,numeroLetras);
				}
				if(let=="CE"){
					texto="";
				}
				if(let=="CO"){
					if (texto.slice(texto.length-1) != ','){
						texto=texto+',';
					}			
				}
				if(let=="ES"){
					if (texto.slice(texto.length-1) != ' '){
						texto=texto+' ';
					}	
				}
			}
		
		}else{


			if(q == 3 || q == 4){

				if(q == 3){
					if(let=="A" || let=="B" || let=="C" || let=="M" || let=="R"){
						if(cant >= c){
						}else{
							texto=texto+let;
						}
					}
				}
				if(q == 4){
					if(let=="N" || let=="C" || let=="D" || let=="R" || let=="E" || let=="F" || let=="T" || let=="I"){
						if(cant >= c){
						}else{
							texto=texto+let;
						}
					}
				}

			}else{	
				if(q == 0 || q == 2){
					if(cant >= c){
						if(let=="BO" || let=="CE"){
							texto=texto+let;
						}
						return false;
					}else{
						texto=texto+let;
					}
				}
			}


		}
		
		document.getElementById(cu[i]).value = texto;
		$(cu[i]).focus();
	}
	
}

/*************************************************************************************************************************/
/*************************************************************************************************************************/

function AnaNum(num){
	
	var xdv = document.getElementById("YaFac").value;

	var vQuePoE = "QuePoE";
	var vCantiE = "CantiE";
	var vDondeE = "DondeE";
	if(xdv == 2){ }
	if(xdv == 3){ }
	
	var q = document.getElementById(vQuePoE).value;
	var c = document.getElementById(vCantiE).value;
	var d = document.getElementById(vDondeE).value;
	
	var cu = d.split(", ");
	
	for (var i=0; i < cu.length; i++){

		var	texto = document.getElementById(cu[i]).value;
		var	ca = document.getElementById(cu[i]).value.length;
		
		if(num=="SU" || num=="CO" || num=="BA" || num=="AS" || num=="CE"){
			if(q != 6){
				if(num=="CO"){
					if (texto.slice(texto.length-1) != ','){
						texto=texto+',';
					}			
				}
				if(num=="SU"){
					if (texto.slice(texto.length-1) != '+'){
						texto=texto+'+';
					}			
				}
				if(num=="BA"){
					if (texto.slice(texto.length-1) != '/'){
						texto=texto+'/';
					}			
				}
				if(num=="AS"){
					if (texto.slice(texto.length-1) != '*'){
						texto=texto+'*';
					}			
				}

			}
			if(num=="CE"){
				numeroLetras=texto.length-1
				texto=texto.substring(0,numeroLetras);	
			}
		}else{

			if(q == 0 || q == 1 || q == 6 || q == 4){				
				if(ca >= c){
					if(num=="CE"){
						texto=texto+num;
					}
					return false; 
				}else{
					texto=texto+num;
				}
			}
			
		}

		document.getElementById(cu[i]).value = texto;
		$(cu[i]).focus();

	}
	
}


/*************************************************************************************************************************/
/*************************************************************************************************************************/

/********************************************************/
function clipFloat(num){
	var dec = 5;
	var t=num+"";
	num = parseFloat(t.substring(0,(t.indexOf(".")+dec+1)));
	return (num)
} 
/********************************************************/


var tim = 800;


function FX1(cs,ca){

var cli = document.getElementById("CLI").value;
document.getElementById('mostrar').innerHTML = "";
$("#micapa1").load("Control.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1");
	
	$("#micapa1").fadeIn(tim);
	$("#mostrar").fadeOut(tim);
	$("#toda_la_bus").fadeOut(tim);
		
}

function FX2(cs,ca){

var cli = document.getElementById("CLI").value;

$("#micapa1").load("Control.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1&fpp=1");
	
	$("#micapa1").fadeIn(tim);
	$("#mostrar").fadeOut(tim);
	$("#toda_la_bus").fadeOut(tim);

}

function FX3(cs,ca){

var cli = document.getElementById("CLI").value;

$("#micapa1").load("Control.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli+"&pro=1&fpp=1&upd=1");
	
	$("#micapa1").fadeIn(tim);
	$("#mostrar").fadeOut(tim);
	$("#toda_la_bus").fadeOut(tim);
		
}

function ReplaceAll(text, busca, reemplaza){
	while (text.toString().indexOf(busca) != -1)
	text = text.toString().replace(busca,reemplaza);
	return text;
}

function ReeCodigo(){

	var control = document.getElementById('LetTex').value.length;
	var cb = document.getElementById('LetTex').value;
	var cadena = cb.charAt(0);

	if (control == 0){ return false; }
	
		if (/^([0-9])*$/.test(cadena)){
			
			cb = $.trim(cb);

			/*			
			var buscar = cb.indexOf("-");
	
			if(buscar == -1){ 
			
				document.getElementById("MiProd").style.display="block";
				document.getElementById("Loading").style.display="block";
				$("#micapa1").load("Control.php?ca=0&cb="+cb);	
				document.getElementById('LetTex').value = "";
				$("#LetTex").focus();
				$("#micapa1").fadeIn(tim);
				$("#mostrar").fadeOut(tim);
				$("#toda_la_bus").fadeOut(tim);
				
			}else{
			*/
			
			document.getElementById('micapa1').innerHTML = "";
			document.getElementById('mostrar').innerHTML = "";
			document.getElementById('LetTex').value = "";
			SoloBlock("MiProd, Loading");
			
			var cli = document.getElementById("CLI").value;

			$("#micapa1").load("Control.php?ca=1&cb="+cb+"&cli="+cli);

			$("#micapa1").fadeIn(tim);
				
			/* } */
			
		}

		cb = cb.toLowerCase();

		if (/[a-z,�\s]/.test(cb)){
			var buscar = cb.indexOf("+");
			if(buscar == -1){ 

				document.getElementById('micapa1').innerHTML = "";
				document.getElementById('mostrar').innerHTML = "";
				document.getElementById('LetTex').value = "";
				SoloBlock("MiProd, Loading");;
				
				var cb_env = ReplaceAll(cb," ","+");
				$("#mostrar").load("Busqueda.php?l_env="+cb_env);
				
				$("#mostrar").fadeIn(tim);
				$("#micapa1").fadeOut(tim);
				$("#toda_la_bus").fadeOut(tim);
				
			}

		}
	
return false;
	
}

function validarEntero(valor){
	
	valor = parseInt(valor)
	if (isNaN(valor)) {
		return ""
	}else{
		return valor
	}
	
}

/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/********************************** COMINEZO DE FUNCIONES DE INSERCION DE ITEMS *****************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/

function dec(t){
	
	var t = parseFloat(t);
	var t = Math.round(t*100)/100
	var t = t.toFixed(2)
	return t;
	
}

function dec2(v,d){
	
	var v = parseFloat(v);
	var v = Math.round(v*100)/100
	var v = v.toFixed(d)
	return v;
	
}

var c = 0;
var s = 1;
var N = 0;

function NuevoIXCodigoB(cs,ca,cp,cc,cd){

var comenzar = document.getElementById('ComenzarTic').value;
var totaless = document.getElementById('total').value;

if(totaless == 0){
	document.getElementById('TiquetItem').innerHTML = "";
}
if(comenzar == 0){
	c = 0;
	s = 1;
	N = 0;
	document.getElementById('ComenzarTic').value = 1;
}

document.getElementById('LetTex').value = "";	
var cant = document.getElementById('can_item').value;
document.getElementById('can_item').value = parseFloat(cant) + 1;

$("#LetTex").focus();


  N = N + 1;
  c = c + 1;


	if (c == 1){
			
		$("#TiquetItem").append("<div id=\"capasitems"+s+"\" style=\"display: block;\">");
		
		if(s != 1){

			$("#capasitems"+s).append("<div id=\"Ant_Pro_Ti_D"+s+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:-2px;\"><button class=\"StyBoton\" onclick=\"return movpaga_t("+s+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Ant_Pro_Ti','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"Ant_Pro_Ti\"/></button></div>");
			
			np = s - 1;
			$("#capasitems"+np).fadeOut(tim);
			$("#capasitems"+s).fadeIn(tim);
			
			$("#capasitems"+np).append("<div id=\"Aba_Pro_Ti_D"+np+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:221px;\"><button class=\"StyBoton\" onclick=\"return movpag_t("+np+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Aba_Pro_Ti','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"Aba_Pro_Ti\"/></button></div>");
			
		}

	}

	EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");

	SoloNone("LetEnt, LetTer, NumVol");
	SoloBlock("Tiquet");
	
	$("#FacTotal").fadeIn(500);

	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntabc\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntabc"/></button>';
	
	
	var st = parseFloat(cp) * parseFloat(cc);
	var t = (parseFloat(cp) * parseFloat(cc)) + parseFloat(document.getElementById('total').value);
	var t = Math.round(t*100)/100
	var t = t.toFixed(2);
	var cl = document.getElementById('CLI').value;
	
	///////////// cortar el detalle y quitar caracteres especiales
	cd = cd.substring(0,29);

	document.getElementById('total').value = t;


if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	SoloBlock("LetEnt, LetTer, NumVol");
	return false;
	
}

	
csi = parseInt(cs,10);
cai = parseInt(ca,10);

	var modcli = document.getElementById('modcli').value;
	if(modcli == 0){
		$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl+"&por=1");
	}
	
$("#capasitems"+s).append("<div id=\"items_s"+N+"\"><table style=\"cursor:pointer;\" onclick=\"return enviar_item('"+cs+"','"+ca+"',"+N+");\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"SEC"+N+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"ART"+N+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"PUN"+N+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"CAN"+N+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"SUB"+N+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"DES"+N+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");
	
	SoloBlock("LetEnt, LetTer, NumVol");
	
	if (c == 8){
		
		c = 0; 
        s = s + 1;
		
	}


}


/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/


function NUU(cs,ca,cp,cd, cantidad){
    //cs: codigo seccion
    //ca: codigo articulo
    //cp: precio unitario
    //cd:descripcion
    //cc: cantidad
    





var comenzar = document.getElementById('ComenzarTic').value;
var totaless = document.getElementById('total').value;

if(totaless == 0){
	document.getElementById('TiquetItem').innerHTML = "";
}

if(comenzar == 0){
	c = 0;
	s = 1;
	N = 0;
	document.getElementById('ComenzarTic').value = "1";
}

/////////////////////////////////////////////////////////
//////////// Fabian Para el cancelar /////////////////////
/////////////////////////////////////////////////////////
	SoloBlock("LetTer");
			
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';


var cant = document.getElementById('can_item').value;
document.getElementById('can_item').value = parseFloat(cant) + 1;

var bcantidad = false;
 var cc = 0 ;
 var valoro 
if (!isNaN(cantidad))
    if (cantidad > 0){
        cc = cantidad;
        valoro = cantidad;
        bcantidad  = true;
    }

if (!bcantidad) {
    cc = document.getElementById('NumTex').value;
    valoro = document.getElementById('NumTex').value;
    document.getElementById('NumTex').value = "";
    $("#LetTex").focus();    
}



N = N + 1;
c = c + 1;

	
	if (c == 1){
			
		$("#TiquetItem").append("<div id=\"capasitems"+s+"\" style=\"display: block;\">");
					
		if(s != 1){

			$("#capasitems"+s).append("<div id=\"Ant_Pro_Ti_D"+s+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:-1px;\"><button class=\"StyBoton\" onclick=\"return movpaga_t("+s+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Ant_Pro_Ti','','otros/scr_arri-over.png',0)\"><img src=\"otros/scr_arri-up.png\" border=\"0\" id=\"Ant_Pro_Ti\"/></button></div>");
			
			np = s - 1;
			$("#capasitems"+np).fadeOut(tim);
			$("#capasitems"+s).fadeIn(tim);
			
			$("#capasitems"+np).append("<div id=\"Aba_Pro_Ti_D"+np+"\" style=\"position:absolute; cursor:pointer; z-index:2; left:267px; top:221px;\"><button class=\"StyBoton\" onclick=\"return movpag_t("+np+");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Aba_Pro_Ti','','otros/scr_aba-over.png',0)\"><img src=\"otros/scr_aba-up.png\" border=\"0\" id=\"Aba_Pro_Ti\"/></button></div>");
			
		}

	}
	
    valor = parseInt(valoro)
	
	if (valor == 0){
	
		jAlert("La cantidad debe ser mayor a 0");
		EnvAyuda("La cantidad debe ser mayor a 0");
		
	}else{
		
		if(valoro == ""){
				
				EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");
				if (!bcantidad){
                                    document.getElementById('LetTex').value = "";
                                    document.getElementById("DondeE").value = "LetTex";
                                    document.getElementById("CantiE").value = "50";
                                    document.getElementById("QuePoE").value = "0";

                                    $("#LetTex").focus();
                                }

								
				SoloNone("LetEnt, LetTer, NumVol");
				SoloBlock("Tiquet");

				$("#FacTotal").fadeIn(500);
				
				document.getElementById('LetEnt').innerHTML = '<button id="BotLetEnt" class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button id="BotLetEnt" class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';

				var cc = 1;
				var st = parseFloat(cp) * parseFloat(cc);
				var t = (parseFloat(cp) * parseFloat(cc)) + parseFloat(document.getElementById('total').value);
				var t = Math.round(t*100)/100
				var t = t.toFixed(2)	
				var cl = document.getElementById('CLI').value;
				
				SoloBlock("LetTer");
	
	///////////// cortar el detalle y quitar caracteres especiales
	cd = cd.substring(0,29);

if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	document.getElementById('total').value = "";
	document.getElementById("LetEnt").style.display="block";
	document.getElementById("LetTer").style.display="block";
	document.getElementById("NumVol").style.display="block";
	
return false
}


csi = parseInt(cs,10);
cai = parseInt(ca,10);

	$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl);
//ca: codigo articulo
//cs: codigo seccion
//N: numero de item
//cc: cantidad
//cd:descripcion
//dec(cp): precio unitario
$("#capasitems"+s).append("<div id=\"items_s"+N+"\"><table style=\"cursor:pointer;\" onclick=\"return enviar_item('"+cs+"','"+ca+"',"+N+");\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"SEC"+N+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"ART"+N+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"PUN"+N+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"CAN"+N+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"SUB"+N+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"DES"+N+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");

			document.getElementById('total').value = t;		
			SoloBlock("LetEnt, LetTer, NumVol");

		}else{

			if (isNaN(valor)) {
					
				jAlert("Debe ingresar n\u00fameros","Foca Software");
				EnvAyuda("Debe ingresar n&uacute;meros");
				
			}else{
				
				EnvAyuda("Ingrese c&oacute;digo de barras o realice una b&uacute;squeda.");
				
				var cl = document.getElementById('CLI').value;
				if (!bcantidad){
                                    document.getElementById('LetTex').value = "";	
                                    document.getElementById("DondeE").value = "LetTex";
                                    document.getElementById("CantiE").value = "50";
                                    document.getElementById("QuePoE").value = "0";

                                    $("#LetTex").focus();
                                }

								
				SoloNone("LetEnt, LetTer, NumVol");
				SoloBlock("Tiquet");
				
				$("#FacTotal").fadeIn(500);
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Lett\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="Lett"/></button>';
			
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntabcd\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntabcd"/></button>';
	
				cc = validarEntero(cc);
				cc = parseInt(cc,10);				
				var st = parseFloat(cp) * parseFloat(cc);
				var t = st + parseFloat(document.getElementById('total').value);
				var t = Math.round(t*100)/100
				var t = t.toFixed(2)	
				
				SoloBlock("LetTer");
				
	///////////// cortar el detalle y quitar caracteres especiales
	cd = cd.substring(0,29);

//es por codigo de articulo
if(cs.length == 0 || ca.length == 0 || cc.length == 0 || cl.length == 0){
	
	SoloBlock("LetEnt, LetTer, NumVol");
	return false;
	
}


csi = parseInt(cs,10);
cai = parseInt(ca,10);
//cai: codigo articulo
//csi: codigo seccion
//N: numero de item
//cc: cantidad
//cd:descripcion
//dec(cp): precio unitario
//cl : cliente

	$("#archivos").load("NArt.php?cs="+csi+"&ca="+cai+"&cc="+cc+"&cl="+cl);
	
$("#capasitems"+s).append("<div id=\"items_s"+N+"\"><table style=\"cursor:pointer;\" onclick=\"return enviar_item('"+cs+"','"+ca+"',"+N+");\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" ><tr><td><img src=\"ticket/botonbarra-over.png\" /></td><td><div class=\"items\"><table cellspacing=\"1\" cellpadding=\"0\" border=\"0\" width=\"246\"><tr><td width=\"15\"><div class=\"form_tick\" id=\"SEC"+N+"\">"+cs+"-</div></td><td width=\"45\" ><div class=\"form_tick\" id=\"ART"+N+"\">"+ca+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"PUN"+N+"\">"+dec(cp)+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"CAN"+N+"\">"+cc+"</div></td><td width=\"61\"><div class=\"form_tick\" id=\"SUB"+N+"\">"+dec(st)+"</div></td></tr><tr><td width=\"244\" colspan=\"5\" ><div class=\"form_tick\" id=\"DES"+N+"\">"+cd+"</div></td></tr></table></div></td></tr></table></div>");		

				document.getElementById('total').value = t;
				SoloBlock("LetEnt, LetTer, NumVol");
				
			}
			
		}

	}

	if (c == 8){
				
		c = 0; 
        s = s + 1;
		
	}



return false;

}

/************************************************************************************************************************************************/
/********************************** FIN DE FUNCIONES DE INSERCION DE ITEMS **********************************************************************/
/************************************************************************************************************************************************/
/************************************************************************************************************************************************/

function EnvError(h){

	document.getElementById('ErrorConex').innerHTML = "";
	document.getElementById('ErrorConex').innerHTML = "<table width='100%' height='300'><tr><td valign='middle' align='center'>"+h+"</td></tr></table>";
	SoloBlock('ErrorConex');

}

function EnvAyuda(h){

	if (h == "Ocultar"){
		
		document.getElementById('CarAyudaFon').style.display="none";
		document.getElementById('CarAyuda').style.display="none";
		
	}else{

		document.getElementById('CarAyuda').innerHTML = "";
		document.getElementById('CarAyuda').innerHTML = h;

		document.getElementById('CarAyudaFon').style.display="block";
		document.getElementById('CarAyuda').style.display="block";	
	
		if (h == "No Existe el producto selecionado."){
			SoloNone('MiProd, Loading');
		}
		
	}
	
}

function EnvAyuda2(h){

	if (h == "Ocultar"){
		
		document.getElementById('CarAyudaFon2').style.display="none";
		document.getElementById('CarAyuda2').style.display="none";
		
	}else{

		document.getElementById('CarAyuda2').innerHTML = "";
		document.getElementById('CarAyuda2').innerHTML = h;

		document.getElementById('CarAyudaFon2').style.display="block";
		document.getElementById('CarAyuda2').style.display="block";	
	
		if (h == "No Existe el producto selecionado."){
			SoloNone('MiProd, Loading');
		}
		
	}
	
}

function ComenzarFacError(){
	
	EnvAyuda('Error de grabacion reintente la operacion...');
	Mos_Ocu('LetSal');
	Mos_Ocu('LetEnt');
	Mos_Ocu('LetTer');
	Mos_Ocu('NumVol');
	
	SoloNone('Bloquear');
	
}

function IniciarFac(){
	
	clearTimeout(timerIDD);
	
	$("#Monedas").load("MMon.php?tot=0");
	
	Mos_Ocu('MiProd');
	Mos_Ocu('Tiquet');
	Mos_Ocu('FacTotal');
	SoloNone('MedioP, Cotizacion');
	
	document.getElementById('mostrar').innerHTML = '';
	document.getElementById('micapa1').innerHTML = '';
	document.getElementById('TiquetItem').innerHTML = '';
	
	document.getElementById('ComenzarTic').value = 0;
	document.getElementById('total').value = "0.00";
	document.getElementById('VUL').value = "";
	document.getElementById('PAG').value = "";
	document.getElementById("TARJ").value = 0;
	
	cancvuel()
	
	SoloBlock("LetSal, LetEnt, NumVol");
	SoloNone("LetTer");
	
	////////////////////////////////////////////////////////////////////////////////////////
	/////////////////  PARA FORMAS DE PAGO /////////////////////////////////////////////////
	document.getElementById('APagar').value = 0;
	document.getElementById("CANTARJETAS").value = 0;
	document.getElementById("CANCHEQUES").value = 0;
	document.getElementById("CANEFECTIVO").value = 0;
	document.getElementById("CANBONO").value = 0;
	
	$('#TotalesApagar').attr({
		'style': 'left:287px;'
	});
	
	SoloNone("MultipleFormaPago, bloquerfactur");
	
	document.getElementById('PAG').value = "";
	document.getElementById('VUL').value = "";
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	
	
	
}

function ComenzarFac(){

	$("#archivos").load("NTic.php");
	timerIDD = setTimeout("IniciarFac()", 2000);
	
}

function TerminarFac(){
	
	var Macan_item = document.getElementById('can_item').value;
	if(Macan_item >= 0){	
	
		EnvAyuda('Guardando Comprobante aguarde por favor...');
		
		SoloNone("LetSal, LetEnt, LetTer, NumVol");
		
		document.getElementById('Bloquear').style.display="block";
		
		var pag = document.getElementById('PAG').value;
                
                var comprobante = $("#numero_comprobante").val();
                var mesa = $("#numero_mesa").val();
                var cierre = $("#mesa_cierre").val();
                
		$("#archivos").load("NFac.php?pag="+pag+"&mesa="+mesa+"&comprobante="+comprobante+"&cierre="+cierre);
                
                $("#numero_comprobante").val(0);
                $("#numero_mesa").val(0);
                $("#mesa_cierre").val(0);
				
				$("#MiProd").hide();
                
		
	}	
}

function confvuel(){
	
	var pag = document.getElementById('PAG').value;
	var tot = document.getElementById('total').value;
		
	if(pag == tot){
		var cc = 1;
	}else{
		var cc = document.getElementById('PAG').value;
	}
	
	if(pag == 0){
		var cc = 1;
		pag = tot;
	}
	
	if (/^([0-9+\,+\.])*$/.test(cc)){
	
		if(tot == 0){
		
			document.getElementById('PAG').value = ""; 
			document.getElementById('VUL').value = "";
			
		}else{
							
			var p = parseFloat(pag.replace(",","."));
			var t = parseFloat(tot);
			
			if(p >= t){	
							
				if(p == 0.00){
					
					document.getElementById('PAG').value = "";
					document.getElementById('VUL').value = "";
					 
				}else{
									
					document.getElementById('PAG').value = dec(p);
					document.getElementById('total').value = dec(t);
					
					if(p >= t){
						
						$("#LetTex").focus();
						var tt = p - t;
						document.getElementById('VUL').value = dec(tt);
						TerminarFac();
						$("#LetTex").focus();
						
					}
					
				}	
				
			}else{
				
				////////////////////////////////////////////////////////////////////////////////////////
				/////////////////  PARA FORMAS DE PAGO /////////////////////////////////////////////////
				document.getElementById('APagar').value = dec(document.getElementById('PAG').value.replace(",","."),2);
	
				$('#TotalesApagar').attr({
					'style': 'left:8px;'
				});
				
				EnvAyuda('Ingrese importe de pago y un medio de pago.');
				
				document.getElementById("DondeE").value = "APagar";
				document.getElementById("CantiE").value = "12";
				document.getElementById("QuePoE").value = "1";
	
				SoloNone("LetEnt, NumVol");
				SoloBlock("MultipleFormaPago");

				document.getElementById('PAG').value = "";
				document.getElementById('VUL').value = "";
				
				var totparaenv = document.getElementById('total').value;
				
				$("#APagar").focus();
				
				////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////
				
			}
			
	
		}
		
	
	}
	
	
}

function cancvuel(){
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('TerminarTic').value = 1;
	
	EnvAyuda('Ingrese c�digo de barras o realice una b�squeda.');
			
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFac\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFac"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacV\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacV"/></button>';
	
	SoloNone('Desglose, Vuelto2, Bloquear');	
	
	document.getElementById('Bloquear').style.display="none";
	
	$("#TiquetComple").fadeIn(1000);
	$("#Vuelto1").fadeOut(1000);
	$("#DesgloseFon").fadeOut(500);
	
	$("#LetTex").focus();
	
}

function TerminarVul(){

	document.getElementById("ClientesFac").style.display="none";
	
	$("#archivos").load("MFac.php");
	
	document.getElementById('TOTO').value = document.getElementById('total').value;
	document.getElementById('TerminarTic').value = 0;
	
	document.getElementById("DondeE").value = "PAG";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda('Ingrese importe de pago. Enter para todo efectivo.');

	SoloBlock('Desglose, Vuelto2');

	$("#TiquetComple").fadeOut(800);
	$("#Vuelto1").fadeIn(500);
	$("#DesgloseFon").fadeIn(500);

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="confvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="cancvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFacV2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetCanFacV2"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="confvuel();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';

	$("#PAG").focus();
	
}

function apertur(ap){
	
	$("#AperturaTurno").load("AperturaTurno.php?co=0&ap="+ap);
	
}


var intentos = 0;
function vol_ide(){

intentos = intentos + 1;

	if(intentos > 2){

		//alert("tres intentos bloquear");
		EnvError('<br /><b style="color:#FF0000">Faltan archivos de configuraci�n.<br />Cont�ctese con la mesa de ayuda.<br>Gracias.</b>');

	}else{
		
		$("#enviodecookie").load("config/bor.php");
		timerID = setTimeout("fun()", 1000);

	}
	
}

function movpaga_t(p){
	
	np = p - 1;
	$("#capasitems"+p).fadeOut(tim);
	$("#capasitems"+np).fadeIn(tim);
	
return false;

}

function movpag_t(p){

	np = p + 1;	
	$("#capasitems"+p).fadeOut(tim);
	$("#capasitems"+np).fadeIn(tim);
	
return false;

}

function enviar_item(cs,ca,itemm){

	SoloNone('ClientesFac, BotonesParaO, EntraOpe, EntraOpeF, ReEmitirC, MedioP, Cotizacion');

	document.getElementById('micapa1').innerHTML = '';

	var cli = document.getElementById("CLI").value;
	
	$("#micapa1").load("Control.php?cb=0&cs="+cs+"&ca="+ca+"&itemm="+itemm+"&cli="+cli);
	$("#micapa1").fadeIn(tim);
	$("#MiProd").fadeIn(tim);
	
	document.getElementById('NumTex').value = "";
	document.getElementById('LetTex').value = "";
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$("#LetTex").focus();
	
	document.getElementById('mostrar').innerHTML = '';
	
return false;
}

function movpagatr(p){

	np = p - 1;
	document.getElementById('capa_tr'+p).style.display="none";	
	document.getElementById('capa_tr'+np).style.display="block";

return false;

}
function movpagtr(p){

	np = p + 1;
	document.getElementById('capa_tr'+p).style.display="none";	
	document.getElementById('capa_tr'+np).style.display="block";

return false;

}

function Cacelar_Pro(){
	
	EnvAyuda('Ingrese c�digo de barras o realice una b�squeda.');
				
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2"/></button>';
			
}

function CPcuitValido(cuit) {
	
    var vec = new Array(10);
    esCuit=false;
    cuit_rearmado="";
    errors = ''
    for (i=0; i < cuit.length; i++){
        caracter=cuit.charAt( i);
        if ( caracter.charCodeAt(0) >= 48 && caracter.charCodeAt(0) <= 57 ){
            cuit_rearmado +=caracter;
        }
    }
    cuit=cuit_rearmado;
    if ( cuit.length != 11) {
	
        esCuit=false;
        errors = 'Cuit < 11 ';
		return false;
		
    }else{
		
        x=i=dv=0;
        vec[0] = cuit.charAt(  0) * 5;
        vec[1] = cuit.charAt(  1) * 4;
        vec[2] = cuit.charAt(  2) * 3;
        vec[3] = cuit.charAt(  3) * 2;
        vec[4] = cuit.charAt(  4) * 7;
        vec[5] = cuit.charAt(  5) * 6;
        vec[6] = cuit.charAt(  6) * 5;
        vec[7] = cuit.charAt(  7) * 4;
        vec[8] = cuit.charAt(  8) * 3;
        vec[9] = cuit.charAt(  9) * 2;

        for( i = 0;i<=9; i++) {
            x += vec[i];
        }
        dv = (11 - (x % 11)) % 11;
        if ( dv == cuit.charAt( 10) ) { 
            esCuit=true;
			return true;
        } 
    }
    if (!esCuit){
        errors = 'Cuit Invalido';
		return false;	
    }
  document.MM_returnValue1 = (errors == '');
}

////////////////////////////////////////////////////////////////////////////////////////////////
////////// MANEJO DE COOKIES DESDE JAVASCRIPT //////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name){
	createCookie(name,"",-1);
}
////////////////////////////////////////////////////////////////////////////////////////////////
////////// MANEJO DE COOKIES DESDE JAVASCRIPT //////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

function CamFon(f){

$("#archivos").load("config/fon.php?f="+f);

	if(f == 1){
		document.getElementById('FondoAukon').innerHTML = '<img src="images/fondo1.png" />';
	}
	if(f == 2){
		document.getElementById('FondoAukon').innerHTML = '<img src="images/fondo2.png" />';
	}
	if(f == 3){
		document.getElementById('FondoAukon').innerHTML = '<img src="images/fondo3.png" />';
	}
	if(f == 4){
		document.getElementById('FondoAukon').innerHTML = '<img src="images/fondo4.png" />';
	}
	if(f == 5){
		document.getElementById('FondoAukon').innerHTML = '<img src="images/fondo5.png" />';
	}			
	
}

function AgrFon(f){
	alert("ENTRA");
	$('#imagenfon').submit();
//	$("#archivos").load("config/fon.php?t="+f);

}

/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/

function EscrCookies(){

	var valor;
	var ban = 0;
	
	var VerFacAu = document.getElementById('Facturador').style.display;
	var VerFacMa = document.getElementById('FacturadorMa').style.display;
	var VerFacCo = document.getElementById('Compras').style.display;

	var VerLetSal = document.getElementById('LetSal').style.display;
	var VerLetEnt = document.getElementById('LetEnt').style.display;
	var VerLetTer = document.getElementById('LetTer').style.display;
	var VerNumVol = document.getElementById('NumVol').style.display;

	var VerDondeE = document.getElementById("DondeE").value;
	var VerCantiE = document.getElementById("CantiE").value;
	var VerQuePoE = document.getElementById("QuePoE").value;

	if(VerFacAu == "block"){ ban = 1; }
	if(VerFacMa == "block"){ ban = 2; }
	if(VerFacCo == "block"){ ban = 3; }
	
	if(ban != 0){
		
		SoloBlock("ProcesoSusp"+ban);
			
		valor = ReplaceAll(document.getElementById('CarAyuda').innerHTML,";",",");
		valor = ReplaceAll(valor,"&","~");
		createCookie("ayu"+ban,valor,1);
		
		/*************************************************************************************/ 
		
		valor = VerDondeE+"|"+VerCantiE+"|"+VerQuePoE;
		createCookie("esc"+ban,valor,1);
		
		/*************************************************************************************/ 
		
		valor = ReplaceAll(document.getElementById('LetSal').innerHTML,";","~");
		var letrasalir = valor+"|"+VerLetSal;
		
		valor = ReplaceAll(document.getElementById('LetEnt').innerHTML,";","~");
		var letraenter = valor+"|"+VerLetEnt;
		
		valor = ReplaceAll(document.getElementById('LetTer').innerHTML,";","~");
		var letraterminar = valor+"|"+VerLetTer;
		
		valor = ReplaceAll(document.getElementById('NumVol').innerHTML,";","~");
		var letravolver = valor+"|"+VerNumVol;
		
			var botones = letrasalir+"|"+letraenter+"|"+letraterminar+"|"+letravolver;
			createCookie("bot"+ban,botones,1);

	}
	
}

function LeerCookies(leer){

	var valor;

	valor = ReplaceAll(readCookie("ayu"+leer),",",";");
	valor = ReplaceAll(valor,"~","&");
	EnvAyuda(valor);

	/*************************************************************************************/
	
	valor = readCookie("esc"+leer);
	valor = valor.split("|");
	document.getElementById("DondeE").value = valor[0];
	document.getElementById("CantiE").value = valor[1];
	document.getElementById("QuePoE").value = valor[2];
	
	/*************************************************************************************/
	
	valor = ReplaceAll(readCookie("bot"+leer),"~",";");
	valor = valor.split("|");
	
		document.getElementById('LetSal').innerHTML = valor[0];
		document.getElementById('LetSal').style.display = valor[1];
		
		document.getElementById('LetEnt').innerHTML = valor[2];
		document.getElementById('LetEnt').style.display = valor[3];

		document.getElementById('LetTer').innerHTML = valor[4];
		document.getElementById('LetTer').style.display = valor[5];

		document.getElementById('NumVol').innerHTML = valor[6];
		document.getElementById('NumVol').style.display = valor[7];
	
}

function FacAu(){

///////////////////////////////////////////
EscrCookies(); ////////////////////////////
///////////////////////////////////////////	

	var ya = document.getElementById("YaFacAu").value;
	if(ya == 1){

	///////////////////////////////////////////
	LeerCookies(1);////////////////////////////
	///////////////////////////////////////////	
	
		$('#Bloquear').fadeIn(500);

			$('#TecladoNum').attr({
			   'style': 'top:28px',
			});
			
			$('#NumVol').attr({
			   'style': 'left:747px; display:block;'
			});

//////////////////// para ingresar el codigo de barra ////////////////////////////////////////////////////
			document.getElementById("LetTexDiv").innerHTML = '<form id="ConReCodigo" name="ConReCodigo" method="post" onsubmit="return ReeCodigo();"><input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; text-transform:uppercase; font-family:\'TPro\'; font-size:14px;" onkeypress="return ControlDeEnvioLetTexPres();" onkeydown="return ControlDeEnvioLetTexDown();" /></form>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// para ingresar cantidad de producto //////////////////////////////////////////////////
			document.getElementById('NumTexDiv').innerHTML = '<input style="outline-style:none; border-style:none;" type="text" name="NumTex" id="NumTex" maxlength="10" onkeypress="return Enviar_XEnter();"/>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$("#archivos").load("config/VarSer.php?v=1");
		
			SoloNone("FacturadorMa, Compras, BotMins1, BotMins2");
			SoloBlock("Facturador, BotMins");
			
			document.getElementById("YaFacAu").value = 1;
			document.getElementById("YaFac").value = 1;
			
		$('#Bloquear').fadeOut(500);
		
		if(document.getElementById("TarjetasEnFacturador")){
					
			document.getElementById('TarPorFacFor').value = document.getElementById('bTarPorFac').value;

		}
		
	}else{
		AccBotPri(2);
	}

//////////////////////////////////////////////////////////////////////
$("#"+document.getElementById("DondeE").value).focus(); //////////////
//////////////////////////////////////////////////////////////////////

}

function FacMa(){

///////////////////////////////////////////
EscrCookies(); ////////////////////////////
///////////////////////////////////////////

	var ya = document.getElementById("YaFacMa").value;	
	if(ya == 1){

	///////////////////////////////////////////
	LeerCookies(2);////////////////////////////
	///////////////////////////////////////////

		$('#Bloquear').fadeIn(500);
		
			$('#TecladoNum').attr({
			   'style': 'top:28px',
			});
			
			$('#NumVol').attr({
			   'style': 'left:747px; display:block;'
			});

//////////////////// para ingresar el codigo de barra ////////////////////////////////////////////////////
			document.getElementById("LetTexDiv").innerHTML = '<form id="MaConReCodigo" name="MaConReCodigo" method="post" onsubmit="return MaReeCodigo();"><input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; text-transform:uppercase; font-family:\'TPro\'; font-size:14px;" onkeypress="return MaControlDeEnvioLetTexPres();" onkeydown="return MaControlDeEnvioLetTexDown();" /></form>';	
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// para ingresar cantidad de producto //////////////////////////////////////////////////
			document.getElementById('NumTexDiv').innerHTML = '<input style="outline-style:none; border-style:none;" type="text" name="NumTex" id="NumTex" maxlength="10" onkeypress="return MaEnviar_XEnter();"/>';
//////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			$("#archivos").load("config/VarSer.php?v=2");
		
			SoloNone("Facturador, Compras, BotMins, BotMins2");
			SoloBlock("FacturadorMa, BotMins1");
			
			document.getElementById("YaFacMa").value = 1;
			document.getElementById("YaFac").value = 3;
			
		$('#Bloquear').fadeOut(500);
		
		if(document.getElementById("MaTarjetasEnFacturador")){

			document.getElementById('TarPorFacFor').value = document.getElementById('cTarPorFac').value;

		}
		
	}else{
		AccBotPri(24);
	}

//////////////////////////////////////////////////////////////////////
$("#"+document.getElementById("DondeE").value).focus(); //////////////
//////////////////////////////////////////////////////////////////////

}

function FacCo(){

///////////////////////////////////////////
EscrCookies(); ////////////////////////////
///////////////////////////////////////////

	var ya = document.getElementById("YaFacCo").value;
	if(ya == 1){

	///////////////////////////////////////////
	LeerCookies(3);////////////////////////////
	///////////////////////////////////////////
	
		$('#Bloquear').fadeIn(500);
			
			$('#TecladoNum').attr({
			   'style': 'top:28px',
			});
			
			$('#NumVol').attr({
			   'style': 'left:747px; display:block;'
			});
						
			SoloNone("FacturadorMa, Facturador, BotMins, BotMins1");
			SoloBlock("Compras, BotMins2");
			
			document.getElementById("YaFacCo").value = 1;
			document.getElementById("YaFac").value = 2;
		
		$('#Bloquear').fadeOut(500);
		
	}else{
		AccBotPri(9);
	}

}

/*************************************************************************************/
/*************************************************************************************/
/*************************************************************************************/

//CON ENTER SACO EL BOTON "ACEPTAR" DEL JALERT

if($('#popup_ok').css('display') == 'inline'){



	
}































