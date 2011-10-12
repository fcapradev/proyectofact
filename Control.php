<?
require("config/cnx.php");


try {//////////////////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>

#ElProd{ 
	font-family: Arial;
}

#PreProd{ 
	text-align:right; 
	position:absolute; 
	font-family: Arial;
	font-size:22px;
	color:#000;
	top:202px; 
	left:362px; 
	width:97px;
}

#InfoProd{ 
	background-image:url(producto/Prodinfo.png);
	background-repeat:no-repeat;
	width:462px; 
	height:59px;
}

</style>

<script>

var variableparacontroPID = 0;

SoloNone('Loading, ClientesFac');

function enviar_mod(itemm){
	
	var control = document.getElementById('NumTex').value.length;
	var valor = document.getElementById('NumTex').value;
	var ingreso = document.getElementById("NumTex").value;
	var cantidad = parseFloat(<? echo $_SESSION['ParPMA']; ?>);

	if (/^([0-9])*$/.test(valor)){  

		if( ! (ingreso < cantidad)){
				
			jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
			document.getElementById('NumTex').value = "";
			return false;
							
		}
		if(control == 0 || valor == 0){
			
			document.getElementById('NumTex').value = "";
			
		}else{
			
			var cc = document.getElementById('NumTex').value;
			$("#archivos").load("MArt.php?cc="+cc+"&itemm="+itemm);
			
			EnvAyuda('Ingrese código de barras o realice una búsqueda.');

			document.getElementById('mod_item').value = 0;			

			document.getElementById('NumTex').value = "";
			document.getElementById('LetTex').value = "";
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "50";
			document.getElementById("QuePoE").value = "0";

			$("#LetTex").focus();
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac'+itemm+'"/></button>';
		
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFacO\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFacO"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac'+itemm+'"/></button>';
			
		}
		
	}else{
	
		document.getElementById('NumTex').value = "";
	
	}
	
return false;
}

function cancel_mod(){
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById('mod_item').value = 0;
	
	document.getElementById('NumTex').value = "";
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";

	$("#LetTex").focus();

	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacO\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacO"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="TerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTerFacO\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerFacO"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="ReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacO\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetVolFacO"/></button>';
	
}
	
function modificar_itm(itemm){
	
	SoloNone('BotMod, BotEli');

	EnvAyuda('Ingrese cantidad del producto a modificar.');

	document.getElementById('mod_item').value = itemm;

	document.getElementById('NumTex').value = "";
	document.getElementById("DondeE").value = "NumTex";
	document.getElementById("CantiE").value = "6";
	document.getElementById("QuePoE").value = "6";
	
	$("#NumTex").focus();
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return enviar_mod('+itemm+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacM'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacM'+itemm+'"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="return cancel_mod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFacM'+itemm+'\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Enter" title="Enter" border="0" id="LetEntFacM'+itemm+'"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return enviar_mod('+itemm+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFacM'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFacM'+itemm+'"/></button>';

}

function eliminar_itm(itemm){
	
$('#Bloquear').fadeIn(500);
$("#archivos").load("EArt.php?itemm="+itemm);

	var cant = document.getElementById('can_item').value;
	document.getElementById('can_item').value = parseFloat(cant) - 1;
	
	c = c - 1;
	
	if(c==0){
		
		$("#capasitems"+s).remove();
		$("#Ant_Pro_Ti_D"+s).remove();
		var t = s - 1;
		$("#Aba_Pro_Ti_D"+t).remove();
		movpaga_t(s);
		
	}
	
	if(c<0){
		
		c = 7;
		s = s - 1;

	}
	
	SoloNone('BotMod, BotEli');
	
	$("#items_s"+itemm).remove();

}
	
function EsPromo(cs,ca,cc){

	BValue('cant_per');
	BValue('cant_sel');
	IValue('cant_sel',0);

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	$("#ItemsSel").load("PArt.php?cs="+cs+"&ca="+ca+"&cc="+cc);
	
	SoloNone('LetEnt, LetTer, NumVol, MiProd, micapa1');
	SoloBlock('Promo, MPromo');
	
	$("#NumTex").focus();
	
}


function NUPRO(cs,ca,cp,cc,cd){
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~0";
	IValue('datospro',t);
	
	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	EsPromo(cs,ca,cc);
	
	$("#LetEntPro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVolPro").removeClass("PosDivv1").addClass("PosDivv2");

}

function NUPROB(cs,ca,cp,cc,cd){

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	EsPromo(cs,ca,cc);
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~1";
	IValue('datospro',t);
	
	$("#LetEntPro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVolPro").removeClass("PosDivv1").addClass("PosDivv2");

}	

function Enviar_XEnter(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	
	if(k == 13){
		var como = document.getElementById("popup_container");
		if(como == null){
			var mod = document.getElementById('mod_item').value;
			if(mod == 0){
				
				var promo = document.getElementById('MPromo').style.display;
				if(promo == "block"){
					
					try{
						document.getElementById("LetEntProBut").onclick();
					}catch(err){
						//jAlert('Debe seleccionar un producto.', 'Debo Retail - Global Business Solution');
					}

				}else{
					if(variableparacontroPID == 1){
						Enviar_NUU_PideP();
						return false;
					}
					if(window.Enviar_NUU){
						Enviar_NUU();
					}else{	
						NuevoIXCodigoB_Nueva();
					}
				}
				
			}else{
				enviar_mod(mod);
			}
		}
	}
	
}

</script>

</head>

<body>
<?php

//SESSION
$LISTA = $_SESSION['iListaBO'];
$ParCosto_Pb = $_SESSION['ParCosto_Pb'];
$IVAG = $_SESSION['ParIVAG'];

//REQUEST
$CLI = $_REQUEST['cli'];
$cb = $_REQUEST['cb'];

if(isset($_REQUEST['pro'])){
	$MCDPRO = $_REQUEST['pro'];
}else{
	$MCDPRO = 0;
}

if($cb == 0){

$cs = $_REQUEST['cs'];
$ca = $_REQUEST['ca'];

if(isset($_REQUEST['upd'])){

	$SQL = "UPDATE ARTICULOS SET FPP = 0 WHERE CodSec = ".$cs." AND CodArt = ".$ca."";
	$UPDATE_ART = mssql_query($SQL);
	
}

	$c = 1;
	$SQLL = "select codsec, codart, detart, preven, exivta, exidep, pro, fpp, ILPC, codrub, ivaco, PID from articulos where codsec = $cs and codart = $ca";
	
}else{

$c = 1;
if($_REQUEST['ca'] == 1){ 
	
	$pieces = explode(" ", $cb);
	$c = $pieces[0];
	
	if(isset($pieces[1])){
		$p = $pieces[1]; 
	}
	
	if(!isset($pieces[1])){
		$p = $pieces[0];
		$c = 1;
	}
	
	if($c > $_SESSION['ParPMA']){
			?>
			<script>
						
				jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
				document.getElementById("LetTex").value = "";
				
			</script>
			<?
		exit;
	}
	
	$SQLL = "select b.codbar, a.codsec, a.codart, a.detart, a.preven, a.exivta, a.exidep, a.pro, a.fpp, a.ILPC, codrub, ivaco, PID from articulos as a inner join codbar as b on b.codsec = a.codsec and b.codart = a.codart where b.codbar = '$p'";		
	
	$regi = mssql_query($SQLL) or die ("Error SQL");
	$nr1 = mssql_num_rows($regi);
		
	if($nr1 == 0){

		$d = $p;
		$p = (int)$p;
		
		$SQLL = "select codsec, codart, detart, preven, exivta, exidep, pro, fpp, ILPC, codrub, ivaco, PID from articulos where codart = $p";		
		$registros=mssql_query($SQLL) or die ("Error SQL");
		$nr = mssql_num_rows($registros); 

		if($nr == 0){

			?>
			<script>
				EnvAyuda("Busqueda: <? echo $d; ?> --> Items: 0");
				SoloNone("mostrar, MiProd, Loading");
			</script>    
			<?
			exit;
			
		}else{
			?>
			<script>				
				SoloBlock("MiProd, Loading");
				$("#mostrar").load("Busqueda.php?b_cod=1&l_env="+'<? echo $p; ?>');
				document.getElementById('LetTex').value = "";
				$("#mostrar").fadeIn(tim);
			</script>
			<?
			exit;
		}
	}
}

}

$registros=mssql_query($SQLL) or die ("Error SQL");
$nrrr = mssql_num_rows($registros); 

if($nrrr == 0){

	?>
	<script>
	
		EnvAyuda('No Existe el producto selecionado.');
	
		document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnttt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnttt"/></button>';
	
	</script>	

	<?
	
}


while ($reg=mssql_fetch_array($registros)){ ///////////////////////////////////////////////////////////////////////////////////////////////
	
	
$PRECIOV = $reg['preven'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Buscar precio de producto por costo //////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($ParCosto_Pb == true){

	if($reg['ILPC'] == false){

		$_SESSION['ParSQL'] = "SELECT TOP 1 RED FROM APAREMP";
		$APAREMRED = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($APAREMRED);
		while ($REGRED=mssql_fetch_array($APAREMRED)){
			$RED = $REGRED['RED'];			
		}
		if($RED == 0){
			$_SESSION['ParSQL'] = "SELECT preven FROM VI_CONSULTA_ARTICULOS_".$LISTA." WHERE sec = ".$reg['codsec']." and art = ".$reg['codart']." order by art";
		}else{
			$_SESSION['ParSQL'] = "SELECT preven FROM VI_CONSULTA_ARTICULOS_B_".$LISTA." WHERE sec = ".$reg['codsec']." and art = ".$reg['codart']." order by art";
		}
		
		$VI_CONSULTA_ARTICULOS=mssql_query($_SESSION['ParSQL']) or die ("Error SQL");
		rollback($VI_CONSULTA_ARTICULOS);
		while ($VI_CONSULTA=mssql_fetch_array($VI_CONSULTA_ARTICULOS)){ 
		
			$PRECIOV = $VI_CONSULTA['preven'];
			
		}
		
		mssql_free_result($VI_CONSULTA_ARTICULOS);	
						
	}
			
}///////fgin de trabaka con lista de precios


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Buscar precio de producto por cleinte

	$_SESSION['ParSQL'] = "SELECT CONVERT(INT,MOD) AS MOD FROM CLIENTES WHERE NHA <> 1 AND COD = ".$CLI."";
	$CLIENTES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($CLIENTES);
	while ($CLIEN=mssql_fetch_array($CLIENTES)){
		$MOD = $CLIEN['MOD'];			
	}
	
$busco_por_costo = false;
$SIM = '+';
$POR = 0;

if($MOD > 0){

	$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$reg['codsec']." and rub = ".$reg['codrub']." and bus = 0";
	$LIS_VAR1 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($LIS_VAR1);
	
	if(mssql_num_rows($LIS_VAR1)==0){

		$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$reg['codsec']." and rub = ".$reg['codart']." and bus = 1";
		$LIS_VAR2 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($LIS_VAR2);
	
		if(mssql_num_rows($LIS_VAR2)==0){
	
			$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = ".$reg['codsec']." and rub = 0";
			$LIS_VAR3 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($LIS_VAR3);

			if(mssql_num_rows($LIS_VAR3)==0){
			
				$_SESSION['ParSQL'] = "SELECT SIM, POR FROM LIS_VAR WHERE ID = '".$MOD."' and sec = 0 and rub = 0 and bus=1";
				$LIS_VAR4 = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
				rollback($LIS_VAR4);

					if(mssql_num_rows($LIS_VAR4) > 0){
                        $busco_por_costo = true;
					}
			
			} 
			
			while ($LIS3=mssql_fetch_array($LIS_VAR3)){
				$SIM = $LIS3['SIM'];
				$POR = $LIS3['POR'];
			}

		
		
		} 
		
		while ($LIS2=mssql_fetch_array($LIS_VAR2)){
			$SIM = $LIS2['SIM'];
			$POR = $LIS2['POR'];
		}


	
	} 
	
	while ($LIS1=mssql_fetch_array($LIS_VAR1)){
		$SIM = $LIS1['SIM'];
		$POR = $LIS1['POR'];
	}


if($busco_por_costo == true){

	if($reg['ILPC'] == false){
		
	$_SESSION['ParSQL'] = "SELECT precio_".$MOD." AS PRECIO FROM Planilla_Costo WHERE sec = ".$reg['codsec']." and cod = ".$reg['codart']." and precio_".$MOD." > 0";
		$Planilla_Cos = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($Planilla_Cos);
		while ($Pla_Cos=mssql_fetch_array($Planilla_Cos)){
			$PRECIOV = $Pla_Cos['PRECIO'];			
		}
		
	}

}else{
	
	if($POR > 0){		
		
		if($SIM == '+'){
			$PRECIOV = $PRECIOV * ( 1 + ($POR / 100));
		}else{
			$PRECIOV = $PRECIOV * ( 1 - ($POR / 100));
		}
		
		$r = 0;
		$t = 0;
		$r = redondeado($PRECIOV ,1);
		$t = $PRECIOV - $r;
		
		if($t >= 0.01 and $t <= 0.05 and $PRECIOV > $r){
		
			$PRECIOV = $r + 0.05;
		
		}else{
			
			if($t >= 0.05 and $t <= 0.09 and $PRECIOV > $r){
				$PRECIOV = $r + 0.1;
			}elseif($PRECIOV - $r == 0.05){
				$PRECIOV = $r + 0.05;
			}else{
				$PRECIOV = $r;
			}
			
		}
		
		
	}/////////////////////////////// busco lit_var
	

}/////////////////////////////// busco por costo	


}//////////////////////REALIZA PRECIO DE LISTA PARA EL CLIENTE


	$_SESSION['ParSQL'] = "SELECT SIM, POR, FEV FROM Pro_Prom WHERE SEC = ".$reg['codsec']." and ART = ".$reg['codart']."";
	$Pro_Prom = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($Pro_Prom);

if(mssql_num_rows($Pro_Prom) > 0){

	while ($Prom=mssql_fetch_array($Pro_Prom)){
		$SIM = $Prom['SIM'];
		$POR = $Prom['POR'];
		$FEV = $Prom['FEV'];
	}
	
	$FECHA = date("Ymd");
	
	$date = new DateTime($FEV);
	$date->format('Ymd');
	
	if(strtotime($FEV) >= strtotime($FECHA)){
	
		if($POR > 0){		
			
			if($SIM == '+'){
				$PRECIOV = $PRECIOV * ( 1 + ($POR / 100));
			}else{
				$PRECIOV = $PRECIOV * ( 1 - ($POR / 100));
			}
			
			$r = 0;
			$t = 0;
			$r = redondeado($PRECIOV ,1);
			$t = $PRECIOV - $r;
			
			if($t >= 0.01 and $t <= 0.05 and $PRECIOV > $r){
			
				$PRECIOV = $r + 0.05;
			
			}else{
				
				if($t >= 0.05 and $t <= 0.09 and $PRECIOV > $r){
					$PRECIOV = $r + 0.1;
				}elseif($PRECIOV - $r == 0.05){
					$PRECIOV = $r + 0.05;
				}else{
					$PRECIOV = $r;
				}
				
			}
				
		}
		
	}
	
}//////////////////////REALIZA PRECIO POR OFERTA


$PRECIOVE = dec($PRECIOV,2);
$PRECIOVE = "$ ".trim($PRECIOVE);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// BUSCA PRODUCTOS SUGERIDOS /////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($reg['fpp'] == 1){

	if(!isset($_REQUEST['fpp'])){
	
		if(!isset($_REQUEST['itemm'])){

			$CODSEC = format($reg['codsec'],2,'0',STR_PAD_LEFT);
			$CODART = format($reg['codart'],4,'0',STR_PAD_LEFT);		
			
			$SQL = "SELECT B.CodSec AS sec, b.CodArt as art, B.DetArt as det FROM AARTPRO AS A 
			INNER JOIN ARTICULOS AS B ON A.SECP = B.CodSec AND A.CODP = B.CodArt
			WHERE A.SECA = ".$CODSEC." AND A.CODA = ".$CODART." AND B.NHA = 0";
			$AARTPROPRO = mssql_query($SQL) or die("Error SQL");
			$co = mssql_num_rows($AARTPROPRO); 
			mssql_free_result($AARTPROPRO);
			
			
			if($co == 0){
		
				?>
				<script>
					FX3('<? echo $CODSEC; ?>', '<? echo $CODART; ?>');
				</script>
				<?
				exit;
			
			}else{
			
				?>
				<script>			

					var cantidad = parseFloat(<? echo $_SESSION['ParPMA']; ?>);
							
					function Enviar_NUU(){
		
						var ingreso = document.getElementById("NumTex").value;
						if(ingreso < cantidad){			
							
							NUU('<? echo $CODSEC; ?>','<? echo $CODART; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
							FX2('<? echo $CODSEC; ?>','<? echo $CODART; ?>');
							
						}else{
							
							jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
							document.getElementById("NumTex").value = "";
							
						}
						
					}
					
					document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
					document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="CanProLis();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolPorP\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolPorP"/></button>';
							
					document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2n\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2n"/></button>';
					
					SoloBlock("LetTer");
					
					document.getElementById('LetTex').value = "";
					document.getElementById('NumTex').value = "";
					document.getElementById("DondeE").value = "NumTex";
					document.getElementById("CantiE").value = "6";
					document.getElementById("QuePoE").value = "6";
					
					$("#NumTex").focus();
	
					SoloBlock("MiProd, Loading");
					$("#mostrar").load("BusquedaPro.php?cs=<? echo $CODSEC; ?>&ca=<? echo $CODART; ?>");
					$("#mostrar").fadeIn(500);
					
					EnvAyuda('Ingrese cantidad del producto.');					
					
				</script>
				<?
				
				exit;
							
			}
			
		}
		
	}

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$psec = format($reg['codsec'],2,'0',STR_PAD_LEFT);
	$part = format($reg['codart'],4,'0',STR_PAD_LEFT);

	$SQL = "SELECT SECP, TIPO_PROMOCION FROM AARTPRO WHERE SECP = ".$psec." AND CODP = ".$part."";
	$AARTPRO = mssql_query($SQL) or die("Error SQL");
	$CoPro = mssql_num_rows($AARTPRO);
	while ($AAR=mssql_fetch_array($AARTPRO)){
		$TIPOPRO = $AAR['TIPO_PROMOCION'];
	}
	mssql_free_result($AARTPRO);
	
	$p = $psec.'-'.$part;
	$n = "articulos/".$p.".jpeg";

	if (!file_exists($n)){$p = "00-0000";}
	?>
		<div id="ElProd">
          <table width="470" style="color:#FFF;" border="0">
            <tr>
                <td rowspan="2" background="producto/cont_fotos.png" width="350" height="227" valign="middle" align="center">
					<img src="articulos/<? echo $p; ?>.jpeg" width="330" height="200" />
                </td>
                <td rowspan="1" valign="top">
                <?
				
                if ($reg['pro'] == 1){
					$ESPROMO = 1;
				}else{
					$ESPROMO = 0;
				}
				
                if(isset($_REQUEST['itemm'])){
				
                ?>
                <div align="center" id="BotMod">
					<?
					//if($ESPROMO == 1 and ($TIPOPRO == 'B' or $TIPOPRO == 'C')){}else{
					if($ESPROMO == 1){}else{
               		?> 
					<button id="BotMod" onClick="return modificar_itm(<? echo $_REQUEST['itemm']; ?>);" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotModS','','botones/mod-over.png',0)"><img src="botones/mod-up.png" border="0" id="BotModS"/></button>
					<?	
					}
				?>
                </div>
                
                <div align="center" id="BotEli">
                <button id="BotEli" onClick="return eliminar_itm(<? echo $_REQUEST['itemm']; ?>);" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotEliS','','botones/eli-over.png',0)"><img src="botones/eli-up.png" border="0" id="BotEliS"/></button>
                </div>
                <?
                }
                ?>
                </td>
            </tr>
            <tr>
		    	<td valign="bottom">
					<div><img src="producto/ProdPre.png" /></div>
                    <div id="PreProd"><? echo $PRECIOVE; ?></div>
                </td>
			</tr>
            
            <tr>
	            <td colspan="2">
            	<div id="InfoProd">
                <div id="InfoProdDat" style="position:absolute; left:2px; top:239px;">
	                <table width="470" border="0" style="font-size:13px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="middle">
                            &nbsp;&nbsp;&nbsp;<b>Código:</b> <? echo $psec; ?>-<? echo $part; ?>
                            &nbsp;<b>Detalle:</b> <? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>
                            </td>
                         </tr>
                         <tr>
                            <td valign="middle">
                            &nbsp;&nbsp;&nbsp;<b>Es parte de una Promoción: </b> 
                            <?
                            if ($reg['fpp'] == 1){
                                echo "<img src=\"producto/ConTil.png\" align=\"texttop\" />";
                            }else{
                                echo "<img src=\"producto/SinTil.png\" align=\"texttop\" />";
                            }
                            ?>
                            &nbsp;&nbsp;&nbsp;<b>Es una Promoción: </b>
                            <?
                            if ($reg['pro'] == 1){
                                echo "<img src=\"producto/ConTil.png\" align=\"texttop\" />";
                            }else{
                                echo "<img src=\"producto/SinTil.png\" align=\"texttop\" />";
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="middle">
                            &nbsp;&nbsp;&nbsp;<b>Stock en Ventas:</b> <? echo $reg['exivta']; ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<b>Stock en Depósito:</b> <? echo $reg['exidep']; ?>
                            </td>
                        </tr>
                   </table>
                </div>
                </div>
              </td>
              </tr>   
        	</table>
		</div>
 	<?


	
	
	$_SESSION['CON_INTEGRI'] = 0;
	
	if(!isset($_REQUEST['itemm'])){
	
	if($CoPro != 0){
	
	$_SESSION['CON_INTEGRI'] = 0;
		
		if($TIPOPRO == 'A'){
			
			if($CoPro <= 1){
				?>	
				<script>
					NuevoIXCodigoB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
				</script>
				<?
				$_SESSION['CON_INTEGRI'] = 1;
			}else{
				
				$ESPROMO = 0;
				$LOG = "Promocion tipo A Mal Configurada~".$psec."~".$part."~".$PRECIOV."~".$c."~".$reg['detart'];
				$ID = "Control.php";
				esclog(3,$LOG,$ID);
				
			}
			
		}

		if($TIPOPRO == 'B'){
			
			$SQLI = "SELECT SECP FROM AARTPRO WHERE SECP = ".$psec." AND CODP = ".$part." AND SINONIMO = 0";
			$AARTPRO_IN = mssql_query($SQLI) or die("Error SQL");
			if(mssql_num_rows($AARTPRO_IN) == 1){
				
				$SQLI = "SELECT SECP FROM AARTPRO WHERE SECP = ".$psec." AND CODP = ".$part." AND SINONIMO = 1";
				$AARTPRO_IN = mssql_query($SQLI) or die("Error SQL");
				if(mssql_num_rows($AARTPRO_IN) == 1){
					
					$SQLI = "SELECT SECP FROM AARTPRO WHERE SECP = ".$psec." AND CODP = ".$part." AND SINONIMO = 2";
					$AARTPRO_IN = mssql_query($SQLI) or die("Error SQL");
					if(mssql_num_rows($AARTPRO_IN) >= 1){
						
						$_SESSION['CON_INTEGRI'] = 1;
						
					}
					
				
				}
				
			
			}
			mssql_free_result($AARTPRO_IN);
			
			if($_SESSION['CON_INTEGRI'] == 0){
				
				$LOG = "Promocion tipo B Mal Configurada~".$psec."~".$part."~".$PRECIOV."~".$c."~".$reg['detart'];
				$ID = "Control.php";
				esclog(3,$LOG,$ID);
				
			}
			if($_SESSION['CON_INTEGRI'] == 1){
				if($MCDPRO == 0){
				?>
				<script>
				NUPRO('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
				</script>
				<?
				}
				if($MCDPRO == 1){
				?>
				<script>
				NUPROB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
				</script>
				<?
				}
			}else{
				$ESPROMO = 0;
			}
			
		}
		
		if($TIPOPRO == 'C'){
			
			
			/* control de integridad para tipo c */
			$_SESSION['CON_INTEGRI'] = 1;

			if($_SESSION['CON_INTEGRI'] == 0){
				
				$LOG = "Promocion tipo C Mal Configurada~".$psec."~".$part."~".$PRECIOV."~".$c."~".$reg['detart'];
				$ID = "Control.php";
				esclog(3,$LOG,$ID);
				
			}
			if($_SESSION['CON_INTEGRI'] == 1){
				if($MCDPRO == 0){
				?>
				<script>
				NUPRO('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
				</script>
				<?
				}
				if($MCDPRO == 1){
				?>
				<script>
				NUPROB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
				</script>
				<?				
				}
			}else{
				$ESPROMO = 0;
			}
			
		}

	}
	}
	if($cb == 0){
		
		if(!isset($_REQUEST['itemm'])){
		if(!isset($_REQUEST['fpp'])){
			
			$PID = $reg['PID'];
			if($PID == 1){
				
			//////////////////////////////////////////////////////////////////////////
			///////////////////// PIDE PRECIO EN EL FACTURADOR////////////////////////
			//////////////////////////////////////////////////////////////////////////
					
					$CODSEC = format($reg['codsec'],2,'0',STR_PAD_LEFT);
					$CODART = format($reg['codart'],4,'0',STR_PAD_LEFT);	
					
					?>
					<script>
						
						function Enviar_NUU_PideP(){
							
							var NumTexPrecio = document.getElementById("NumTex").value;				
							NumTexPrecio = parseFloat(NumTexPrecio);
			
						NuevoIXCodigoB('<? echo $CODSEC; ?>','<? echo $CODART; ?>',NumTexPrecio,1,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
							
							document.getElementById('LetTex').value = "";
							document.getElementById('NumTex').value = "";
											
						}
									
						document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU_PideP();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
			
						document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="CanProLis();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolPorP\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolPorP"/></button>';
								
						document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU_PideP();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2n\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2n"/></button>';
						
						SoloBlock("LetTer");
			
						document.getElementById('LetTex').value = "";
						document.getElementById('NumTex').value = "";
						
						document.getElementById("DondeE").value = "NumTex";
						document.getElementById("CantiE").value = "6";
						document.getElementById("QuePoE").value = "4";
						
						$("#NumTex").focus();
						
						EnvAyuda('Ingrese precio del producto.');
						
						variableparacontroPID = 1;

					</script>
			
					<?
			//////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////

			}else{
			
			
		?>
		<script>
			
			var cantidad = parseFloat(<? echo $_SESSION['ParPMA']; ?>);
			
			function Enviar_NUU(){

				var ingreso = document.getElementById("NumTex").value;
				if(ingreso < cantidad){
					
					NUU('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
					
				}else{
					
					jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
					document.getElementById("NumTex").value = "";
					
				}
				
			}
						
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="CanProLis();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolPorP\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolPorP"/></button>';
					
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return Enviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2n\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2n"/></button>';
			
			SoloBlock("LetTer");

			document.getElementById('LetTex').value = "";
			document.getElementById('NumTex').value = "";
			
			document.getElementById("DondeE").value = "NumTex";
			document.getElementById("CantiE").value = "6";
			document.getElementById("QuePoE").value = "6";
			
			$("#NumTex").focus();
			
			EnvAyuda('Ingrese cantidad del producto.');

		</script>
		<?    
			}
		}else{
		?>
        <script>
			document.getElementById("LetTex").value = "";
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "50";
			document.getElementById("QuePoE").value = "0";
		</script>
		<?
		}
		}
		
	}else{
			
		if($ESPROMO == 0){
			if($c < $_SESSION['ParPMA']){
		?>
		<script>
		function NuevoIXCodigoB_Nueva(){
			NUU('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
		}
		
		NuevoIXCodigoB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');	
		</script>
		<?			
			}else{
				?>
                <script>
					jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
					document.getElementById("NumTex").value = "";
					document.getElementById("LetTex").value = "";
				</script>
				<?
			}
			
		}
				
	}	

$LOG = "Nuevo Articulo~".$psec."~".$part."~".$PRECIOV."~".$c."~".$reg['detart'];
$ID = "Control.php";
esclog(2,$LOG,$ID);

mssql_close($conexion);

}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mssql_query("commit transaction") or die("Error SQL commit");////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}


?>
</body>
</html>