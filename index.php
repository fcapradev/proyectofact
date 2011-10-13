<?php
session_start();

if(isset($_SESSION['ParFON'])){
	$FON = $_SESSION['ParFON'];
}else{
	$FON = 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="Estilo.css" rel="stylesheet" type="text/css" />
<link href="EstiloMa.css" rel="stylesheet" type="text/css" />
<link href="js/jquery.alerts.css" rel="stylesheet" type="text/css" />

<!-- Agregado Federico 27/3: scrollers -->
<link href="js/jslider/jquery.jscrollpane.css" rel="stylesheet" type="text/css" />
<link href="js/jslider/scroll_config.css" rel="stylesheet" type="text/css" />

<!-- Agregado Federico 27/3: cambiador de estilo ajax -->
<link id="ajax_css" href="tmp.css" rel="stylesheet" type="text/css" />


<title>Debo Retail</title>

<script type="text/javascript" language="javascript" src="util/general.js"></script>
<script type="text/javascript" language="javascript" src="js/shortcut.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-1.6.1.js"></script>
<script type="text/JavaScript" language="javascript" src="Script.js"></script>
<script type="text/JavaScript" language="javascript" src="ScriptMa.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.alerts.js"></script>

<!-- Agregado Federico 27/3: convierte arrays y objects js en JSON -->
<script type="text/javascript" language="javascript" src="js/jquery.json-2.3.min.js"></script>
<script type="text/javascript" language="javascript" src="js/tabs_manager.js"></script>
<script type="text/javascript" language="javascript" src="js/busqueda.js"></script>

<script type="text/javascript" src="js/quicksearch.js"></script> 

<!-- Agregado Federico 27/3: scrollers -->
<script type="text/javascript" language="javascript" src="js/jslider/jquery.jscrollpane.min.js"></script>


<script>
	CargarImagenes();
	
	$(document).ready(function(){
		$('#codidenti').submit(function(){
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data){
					$('#enviodecookie').html(data);	
				}
			})
			return false;
		});
	})
	
shortcut.add("Ctrl+Shift+D",function() {
	Mos_Ocu("Bloquear");
});

shortcut.add("Ctrl+Shift+S",function() {
	AccBotPri(23);
});

// FUNIONES DESHABILITADAS
shortcut.add("Ctrl+T",function(){});
//shortcut.add("tab",function(){});

shortcut.add("Ctrl+A",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(1);
	}
});

shortcut.add("Ctrl+F",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(2);
	}
});

shortcut.add("Ctrl+M",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(24);
	}
});

shortcut.add("Ctrl+C",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(9);
	}
});

shortcut.add("Ctrl+E",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(3);
	}
});

shortcut.add("Ctrl+J",function() {
	if(document.getElementById('BotonesPri').style.display == 'block'){
		AccBotPri(7);
	}
});

shortcut.add("F1",function() {

	if($('#SobreFoca').css('display') == 'block'){	
	
		con = document.getElementById("MosAyuda1").style.display;	
		if(con=='block'){
			$("#MosAyuda1").fadeOut(800);
			$("#MosAyuda2").fadeOut(800);
			$("#BotonesPri").fadeIn(800);
			SoloBlock("ProcesoSusp");
		}else{
			$("#MosAyuda1").fadeIn(800);
			$("#MosAyuda2").fadeIn(800);
			$("#BotonesPri").fadeOut(800);
			SoloNone("ProcesoSusp");
		}
	
	}else{
		//alert("ayuda");
	}

});

shortcut.add("Ctrl+Shift+1",function() {
	CamFon(1);
});
shortcut.add("Ctrl+Shift+2",function() {
	CamFon(2);
});
shortcut.add("Ctrl+Shift+3",function() {
	CamFon(3);
});
shortcut.add("Ctrl+Shift+4",function() {
	CamFon(4);
});
shortcut.add("Ctrl+Shift+4",function() {
	CamFon(5);
});

//shortcut.add("F2",function(){});
shortcut.add("F3",function(){});
shortcut.add("F4",function(){});

//shortcut.add("F5",function(){});
shortcut.add("F6",function(){});
shortcut.add("F7",function(){});
shortcut.add("F8",function(){});

shortcut.add("F9",function(){});
shortcut.add("F10",function(){});
//shortcut.add("F11",function(){});
shortcut.add("F12",function(){});

</script>

</head>

<?
/*
if(isset($_REQUEST['estado'])){
	if($_REQUEST['estado'] == 1){
		?>
		<script>
            jAlert('Im?gen Cargada Correctamente.', 'Debo Retail - Global Business Solution');
        </script>		
        <?
	}
	if($_REQUEST['estado'] == 2){
		?>
		<script>
            jAlert('Campo vac&iacute;o, no ha seleccionado ninguna imagen.', 'Debo Retail - Global Business Solution');
        </script>
        <?
	}
	if($_REQUEST['estado'] == 3){
		?>
		<script>
            jAlert('S?lo se permiten im?genes en formato jpg. y png., no se ha podido adjuntar.', 'Debo Retail - Global Business Solution');
        </script>
        <?
	}
	if($_REQUEST['estado'] == 4){
		?>
		<script>
            jAlert('La Im?gen que ha intentado adjuntar es mayor de 1.5 Mb, si desea cambie el tama?o de la im?gen y vuelva a intentarlo.', 'Debo Retail - Global Business Solution');
        </script>
		<?
	}
}
*/
?>

<body onLoad="prende();" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="overflow:hidden;">

<div style="position:absolute; top:10px; left:850px; font-family:'Courier'; font-size:12px; z-index:10;">

	<form>

       	<input type="hidden" size="7" id="evitarcaracteres" value="0" />
       
        <input type="hidden" size="7" id="ComenzarTic" value="0" />
        <input type="hidden" size="7" id="EliminarTic" value="0" />
        <input type="hidden" size="7" id="TerminarTic" value="1" />

        <input type="hidden" size="7" id="MaComenzarTic" value="0" />
        <input type="hidden" size="7" id="MaEliminarTic" value="0" />
        <input type="hidden" size="7" id="MaTerminarTic" value="1" />

        <input type="hidden" size="7" id="ComenzarCom" value="0" />
        <input type="hidden" size="7" id="ComenzarComV2" value="0" />
        <input type="hidden" size="7" id="ComenzarComPI" value="0" />
        
        <input type="hidden" id="YaFac" value="0" />
        <input type="hidden" id="YaFacAu" value="0" />
        <input type="hidden" id="YaFacMa" value="0" />
        <input type="hidden" id="YaFacCo" value="0" />

		<input type="hidden" size="7" id="DondeE" value="LetTex"/>
		<input type="hidden" size="7" id="CantiE" value="10" />
		<input type="hidden" size="7" id="QuePoE" value="0" />
		
        <input type="hidden" id="controldepaso" value="0" />
        <input type="hidden" id="controldepasoche" value="0" />
         
	</form>

</div>


<div style="position:absolute; width:800px; left:0px; top:0px;">
	<iframe allowtransparency="yes" frameborder="0" scrolling="no" id="NFac_Fra" name="NFac_Fra" width="1" height="1" ></iframe>
</div>

<div style="position:absolute; left:0px; top:0px;">
	<iframe allowtransparency="yes" frameborder="0" scrolling="no" name="FrameNCliente" id="FrameNCliente" width="1" height="1"></iframe>
</div>

<div id="ImpresionPdfDiv" style="position:absolute; width: 777px; left:10px; top:10px; display:none;">
	<iframe allowtransparency="yes" frameborder="0" name="ImpresionPdf" id="ImpresionPdf" width="777" height="540"></iframe>
    <div style="position:absolute; width: 777px; left:10px; top:545px; z-index:10;" id="ImpPdfDivVol" align="center"></div>
</div>


<div id="FondoAukonOriginal"><img src="images/fondomarco.png" width="800" height="600" /></div>
<div id="FondoAukon"><img src="images/fondo<? echo $FON; ?>.png" width="800" height="600" /></div>


<div id="ErrorConex"></div>


<!-- ------- Inicio Teclado ------- -->
<div id="Teclado_Completo">


<div id="fondotranspletras" style="display:none; position:absolute;"><img src="teclado/fondotranspletras.png" /></div>


<div id="TecladoLet" style="display:none;"> 
<?php

for ($i = 1 ; $i <= 30 ; $i ++) {

switch($i){
   
	case 1:
	  $r = "Q";
	  break;
	case 2:
	  $r = "W";
	  break;
	case 3:
	  $r = "E";
	  break;
	case 4:
	  $r = "R";
	  break;
	case 5:
	  $r = "T";
	  break;
	case 6:
	  $r = "Y";
	  break;
	case 7:
	  $r = "U";
	  break;
	case 8:
	  $r = "I";
	  break;
	case 9:
	  $r = "O";
	  break;
	case 10:
	  $r = "P";
	  break;
	case 11:
	  $r = "A";
	  break;
	case 12:
	  $r = "S";
	  break;
	case 13:
      $r = "D";
	  break;
	case 14:
	  $r = "F";
	  break;
	case 15:
	  $r = "G";
	  break;
	case 16:
	  $r = "H";
	  break;
	case 17:
	  $r = "J";
	  break;
	case 18:
	  $r = "K";
	  break;
	case 19:
	  $r = "L";
	  break;
	case 20:
	  $r = "BO";
	  break; 
	case 21:
	  $r = "Z";
	  break;
	case 22:
	  $r = "X";
	  break;
	case 23:
	  $r = "C";
	  break;
	case 24:
	  $r = "V";
	  break;
	case 25:
	  $r = "B";
	  break; 
	case 26:
	  $r = "N";
	  break; 
	case 27:
	  $r = "M";
	  break; 
	case 28:
	  $r = "CO";
	  break;   
	case 29:
	  $r = "CE";
	  break;   
	case 30:
	  $r = "Ne";
	  break;   
	  
}  

?>
<div id="Let<? echo $r; ?>" class="PosDiv1">
<button onclick="AnaLet('<? echo $r; ?>');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Letras<? echo $i; ?>','','teclado/Letras/<? echo $r ?>-over.png',0)"><img src="teclado/Letras/<? echo $r; ?>-up.png" name="<? echo $r; ?>" title="<? echo $r; ?>" border="0" id="Letras<? echo $i; ?>" width="49" height="35" />
</button>
</div>
<?

}

?>

<div id="BotonesLet1">
    <div id="LetSal" class="PosDiv1"></div>
    
    <div id="LetEnt" class="PosDiv1"></div>
    
    <div id="LetTer" class="PosDiv1"></div>
    
    <div id="NumVol" class="PosDiv1" style=""></div>
</div>

<div id="LetAre" class="div-redondo"><img src="teclado/esc.png" width="537" height="20" border="0" /></div>


<div id="LetTexDiv" class="div-redondo">
	<input type="text" name="LetTex" id="LetTex" style="outline-style:none; border-style:none; font-family:'TPro'; font-size:14px;"/>
</div>


<div id="LetBar" class="PosDiv1">
    <button class="StyBoton" onclick="AnaLet('ES')" onmouseout="MM_swapImgRestore()" 
    onmouseover="MM_swapImage('LetBar1','','teclado/otros/bar-esp-over.png',0)">
    <img src="teclado/otros/bar-esp-up.png" name="Barra" title="Barra" border="0" id="LetBar1"/></button>
</div>

     <div id="LetEntPro" class="PosDivv1"></div>
     <div id="NumVolPro" class="PosDivv1"></div>
     
</div> 


<!-- ------- Fin Teclado ------- -->


<!-- ------- Inicio Numeros ------- -->


<div id="fondotranspnumeros" style="display:none; position:absolute;"><img src="teclado/fondotranspnumeros.png" /></div>

<div id="TecladoNum" style="display:none">
<?php

for ($i = 0 ; $i <= 14 ; $i ++) {

$r = 0;
switch($i){
	
   	case 0:
	  $r = "0";
	  break;
	case 1:
	  $r = "1";
	  break;
	case 2:
	  $r = "2";
	  break;
	case 3:
	  $r = "3";
	  break;
	case 4:
	  $r = "4";
	  break;
	case 5:
	  $r = "5";
	  break;
	case 6:
	  $r = "6";
	  break;
	case 7:
	  $r = "7";
	  break;
	case 8:
	  $r = "8";
	  break;
	case 9:
	  $r = "9";
	  break;
	case 10:
	  $r = "BA";
	  break;
	case 11:
	  $r = "SU";
	  break;
	case 12:
	  $r = "CO";
	  break;
	case 13:
	  $r = "AS";
	  break;
	case 14:
	  $r = "CE";
	  break;

}  

?>
<div id="Num<? echo $r; ?>" class="PosDiv1">
<button onclick="AnaNum('<? echo $r; ?>');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Numeros<? echo $i; ?>','','teclado/numeros/<? echo $r; ?>-over.png',0)"><img src="teclado/numeros/<? echo $r; ?>-up.png" name="<? echo $r; ?>" title="<? echo $r; ?>" border="0" id="Numeros<? echo $i; ?>" width="47" height="36" />
</button>
</div>
<?

}
?>


</div> 


<!-- ------- Fin Numeros ------- -->

<div id="NumAre"><img src="teclado/esc_num.png" border="0" width="125" height="20" /></div>
</div>

	
    <div id="NumTexDiv">
	    <input type="text" name="NumTex" id="NumTex" maxlength="10" onkeypress="return Enviar_XEnter();" style="outline-style:none; border-style:none;"/>
    </div>
    <div id="LetAux" class="PosDiv1">
        <button class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetraAux','','botones/ent-over.png',0)">
        <img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetraAux" width="85" height="35" /></button>
    </div>


<div id="CarAyudaFon">&nbsp;</div><div id="CarAyuda"></div>

<div id="CarAyudaFon2">&nbsp;</div><div id="CarAyuda2"></div>

<div id="enviodecookie" style="position:absolute; left:600px; top:800px;"></div>


<script>
///////////// fabian vallejo /////////////
/*
	$("#FondoAukon").height($(document).height());
	$("#FondoAukon").width('100%');

	$("div").attr({
		oncontextmenu: "return false",
		ondragstart: "return false",
		onmousedown: "return false",
		onselectstart: "return false"
	});
*/
///////////// fabian vallejo /////////////
</script>


<?
require("config/config.php");
require("config/login.php");

?>

<div id="SobreFoca" class="PosDiv"><img src="otros/int-over.png" width="32" height="32" /></div>

<div id="MosAyuda1" class="PosPri10"><img src="images/Ayuda.png" width="630" height="300" /></div>

<div id="MosAyuda2" class="PosPri10" style="color:#FFF">

<div style="color:#FFF;" align="right" ><img src="otros/cru-over.png" id="Cerrar" style="cursor:pointer;" width="32" height="32" /></div>

<table width="100%" border="0">
<tr>
    <td rowspan="2"><div style="margin-left:25px;"><img src="images/About.png" /></div></td>
    <td colspan="2" valign="top">
		<table width="420" border="0">
			<tr>
			<td><div align="right">Codigo de Operario:</div></td>
			<td><div align="left"><? echo $_SESSION["idsusua"]; ?></div></td>
			</tr>
			<tr>
			<td><div align="right">Nombre de Operario:</div></td>
			<td><div align="left"><? echo $_SESSION["idsusun"]; ?></div></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			<td><div align="right">Empresa:</div></td>
			<td><div align="left"><? echo $_SESSION['EMP01']; ?></div></td>
			</tr>
			<tr>
			<td><div align="right">Direccion:</div></td>
			<td><div align="left"><? echo $_SESSION['EMP02']; ?></div></td>
			</tr>
			<tr>
			<td><div align="right">Telefono:</div></td>
			<td><div align="left"><? echo $_SESSION['EMP03']; ?></div></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			<td><div align="right" >Debo Online:</div></td>
			<td><div align="left" >http://debonline.dyndns.org/cliente/</div></td>
			</tr>
		</table>
    </td>
</tr>
<tr>
	<td valign="bottom">
    	<table>
        <tr>
            <td colspan="4"><div align="center">Fondo de Escritorio</div></td>
        </tr>
        <tr>    
            <td>
                <div class="BotEsc" onclick="CamFon(1);">
                <table cellpadding="0" cellspacing="0" width="30" height="32">
                    <tr>
                        <td valign="middle" align="center">1</td>
                    </tr>
                </table>
                </div>
			</td>
            <td>
                <div class="BotEsc" onclick="CamFon(2);">
                <table cellpadding="0" cellspacing="0" width="30" height="32">
                    <tr>
                        <td valign="middle" align="center">2</td>
                    </tr>
                </table>
                </div>
            </td>
            <td>
                <div class="BotEsc" onclick="CamFon(3);">
                <table cellpadding="0" cellspacing="0" width="30" height="32">
                    <tr>
                        <td valign="middle" align="center">3</td>
                    </tr>
                </table>
                </div>
            </td>
            <td>
                <div class="BotEsc" onclick="CamFon(4);">
                <table cellpadding="0" cellspacing="0" width="30" height="32">
                    <tr>
                        <td valign="middle" align="center">4</td>
                    </tr>
                </table>
                </div>
            </td>
            <td>
                <div class="BotEsc" onclick="CamFon(5);">
                <table cellpadding="0" cellspacing="0" width="30" height="32">
                    <tr>
                        <td valign="middle" align="center">5</td>
                    </tr>
                </table>
                </div>
            </td>            
            <td>
                <div  >
                <table cellpadding="0" cellspacing="0" width="100" height="32">
                    <tr>
                        <td valign="middle" align="right">

<form action="config/fon.php" method="post" id="imagenfon" name="imagenfon" enctype="multipart/form-data"> 

	<input name="upfile" id="upfile" type="file" style="position:absolute; top:227px; left:350px;"/>
    
    <button class="StyBoton" type="submit" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImgFon','','otros/tec-over.png',0)" style="position:absolute; top:253px; left:335px;">
        <img src="otros/tec-up.png" border="0" id="BotImgFon" width="88" height="26" /></button>
</form>                         
                        
                        </td>
                    </tr>
                </table>
                </div>
            </td>            

        </tr>
        </table>
    </td>
    <td valign="bottom"><div align="right" style="top:267px; left:444px; position:absolute;">Powered by: Foca Software 2011</div></td>
</tr>
</table>
</div>

<div id="Bloquear" align="center">
    <table width="800" height="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td><img src="otros/loading.gif" /></td>
    </tr>
    </table>
<div id="msj" align="center" style='font-family: "TPro"; font-size:20px; color:#F00; position:absolute; top:227px; left:0px; width:800px;'></div>    
</div>

<div id="Bloquear1" align="center" style="display:none;">
    <table width="232" height="145" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td><img src="otros/loading.gif" width="32" height="32" /></td>
    </tr>
    </table>
</div>

<div id="Marca" class="PosDiv"><img src="images/Marca.png" width="231" height="92" /></div>


    <div id="BotonesPri" style="display:block;"> <!-- -------- BotonesPri ------------- --> </div>
    
    <div id="AperturaTurno" style="display:none"> <!-- ------- AperturaTurno ---------- --> </div>
    
    <div id="Facturador" style="display:none"> <!-- ---------- Facturador ------------- --> </div>
    
    <div id="FacturadorMa" style="display:none"> <!-- -------- Facturador ------------- --> </div>
    
    <div id="CierreTurno" style="display:none"> <!-- --------- CierreTurno ------------ --> </div>
    
    <div id="RetiroEfectivo" style="display:none"> <!-- ------ RetiroEfectivo --------- --> </div>
    
    <div id="Gastos" style="display:none"> <!-- -------------- Gastos ----------------- --> </div>
    
    <div id="TicketEM" style="display:none"> <!-- ------------ TicketEM --------------- --> </div>
    
    <div id="CoIdPe" style="display:none"> <!-- -------------- CoIdPe ----------------- --> </div>
    
    <div id="ChequesCar" style="display:none"> <!-- ---------- Cheques ---------------- --> </div>
    
    <div id="Confirmar" style="display:none"> <!-- ----------- Confirmacion de caja --- --> </div>
    
    <div id="Tarjetas" style="display:none"> <!-- ------------ Tarjetas --------------- --> </div>
    
    <div id="Recuento" style="display:none"> <!-- ------------ Recuento --------------- --> </div>
    
    <div id="Movimientos" style="display:none"> <!-- --------- Movimientos ------------ --> </div>
    
    <div id="Novedades" style="display:none"> <!-- ----------- Novedades -------------- --> </div>
    
	<div id="Compras" style="display:none"> <!-- ------------- Compras ---------------- --> </div>
	
    <div id="Arqueo" style="display:none"> <!-- -------------- Arqueo ----------------- --> </div>

	<div id="CargaInv" style="display:none"> <!-- ------------ CargaInv --------------- --> </div>

	<div id="TomaInv" style="display:none"> <!-- ------------- TomaInv ---------------- --> </div>
    
    <div id="ComAut" style="display:none"> <!-- -------------- Compras Automaticas ---- --> </div>
    	
	<div id="CierreTurno2" style="display:none"> <!-- -------- CierreTurno2 ----------- --> </div>
        
        <div id="Restaurant" class="" style="display:none"> <!-- -------- Resto ----------- --> </div>
    
    <div id="NaNb" style="display:none"> <!-- ---------------- NotaAltaBaja ----------- --> </div>
    

<div id="dummy"></div>


<div id="BotMins" style="display:none">
<div style="position:absolute; left:-4px; top:0px;">
    <table cellpadding="0" cellspacing="0">
    <tr>
        <td>
        <button class="StyBoton" onclick="TecladoCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax1','','otros/tec-over.png',0)">
        <img src="otros/tec-up.png" border="0" id="BotMax1" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacCo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax2','','otros/com-over.png',0)">
        <img src="otros/com-up.png" border="0" id="BotMax2" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacMa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax3','','otros/facm-over.png',0)">
        <img src="otros/facm-up.png" border="0" id="BotMax3" width="88" height="26" /></button>
        </td>
    </tr>
	<tr>
        <td>
        <button class="StyBoton" onclick="AccBotFac(9);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax4','','otros/susp-over.png',0)">
        <img src="otros/susp-up.png" border="0" id="BotMax4" width="88" height="26" /></button>
        </td>
	</tr>
    </table>
</div>    
</div>

<div id="BotMins1" style="display:none">
<div style="position:absolute; left:-4px; top:0px;">
    <table width="96" cellpadding="0" cellspacing="0">
    <tr>
        <td>
        <button class="StyBoton" onclick="TecladoCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax11','','otros/tec-over.png',0)">
        <img src="otros/tec-up.png" border="0" id="BotMax11" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacCo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax21','','otros/com-over.png',0)">
        <img src="otros/com-up.png" border="0" id="BotMax21" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacAu();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax31','','otros/fac-over.png',0)">
        <img src="otros/fac-up.png" border="0" id="BotMax31" width="88" height="26" /></button>
        </td>
    </tr>
	<tr>
        <td>
        <button class="StyBoton" onclick="MaAccBotFac(9);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax41','','otros/susp-over.png',0)">
        <img src="otros/susp-up.png" border="0" id="BotMax41" width="88" height="26" /></button>
        </td>
	</tr>    
    </table>
</div>
</div>

<div id="BotMins2" style="display:none">
<div style="position:absolute; left:-4px; top:0px;">
    <table width="96" cellpadding="0" cellspacing="0">
    <tr>
        <td>
        <button class="StyBoton" onclick="TecladoCom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax12','','otros/tec-over.png',0)">
        <img src="otros/tec-up.png" border="0" id="BotMax12" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacAu();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax22','','otros/fac-over.png',0)">
        <img src="otros/fac-up.png" border="0" id="BotMax22" width="88" height="26" /></button>
        </td>
    </tr>
    <tr>    
        <td>
        <button class="StyBoton" onclick="FacMa();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax32','','otros/facm-over.png',0)">
        <img src="otros/facm-up.png" border="0" id="BotMax32" width="88" height="26" /></button>
        </td>
    </tr>
	<tr>
        <td>
        <button class="StyBoton" onclick="botoncerrar();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotMax42','','otros/susp-over.png',0)">
        <img src="otros/susp-up.png" border="0" id="BotMax42" width="88" height="26" /></button>
        </td>
	</tr>    
    </table>
</div>
</div>

<div id="ProcesoSusp">
	<div id="ProcesoSusp1">Suspendido</div>
	<div id="ProcesoSusp2">Suspendido</div>
	<div id="ProcesoSusp3">Suspendido</div>
</div>


<div id="archivos" style="position:absolute; top:800px; left:0px; width:800px; height:0px;"></div>


<script>

	$("#BotonesPri").load("BotonesPri.php");
	
///////////// fabian vallejo /////////////
/*
	$("div").attr({
		oncontextmenu: "return false",
		ondragstart: "return false",
		onmousedown: "return false",
		onselectstart: "return false"
	});

	$(document).ready(function(){
		$("div").each(function(i){
			$(this).attr({
				oncontextmenu: "return false",
				ondragstart: "return false",
				onmousedown: "return false",
				onselectstart: "return false"
			});	
		});
	});
*/
///////////// fabian vallejo /////////////	
</script>

</body>
</html>