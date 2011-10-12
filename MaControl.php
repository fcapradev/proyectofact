<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


//SESSION
$LISTA = $_SESSION['iListaBO'];
$ParCosto_Pb = $_SESSION['ParCosto_Pb'];
$IVAG = $_SESSION['ParIVAG'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>

#MaElProd{
	font-family: Arial;
}

#MaPreProd{
	text-align:right;
	position:absolute;
	font-family: Arial;
	font-size:22px;
	color:#000;
	top:202px;
	left:362px;
	width:97px;
}

#MaInfoProd{
	background-image:url(producto/Prodinfo.png);
	background-repeat:no-repeat;
	width:462px; 
	height:59px;
}

</style>

<script>

SoloNone('MaLoading, MaClientesFac');

function Maenviar_mod(itemm){
	
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
			
			document.getElementById('Mamod_item').value = 0;
			
			document.getElementById('NumTex').value = "";
			document.getElementById('LetTex').value = "";
			document.getElementById("DondeE").value = "LetTex";
			document.getElementById("CantiE").value = "50";
			document.getElementById("QuePoE").value = "0";
			
			$("#LetTex").focus();
			
			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac'+itemm+'"/></button>';
		
			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2FacO\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2FacO"/></button>';
		
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2Fac'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2Fac'+itemm+'"/></button>';
			
		}
	}else{
	
		document.getElementById('NumTex').value = "";
	
	}
	
return false;
}

function Macancel_mod(){
	
	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById('Mamod_item').value = 0;
	
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";

	$("#LetTex").focus();
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2FacO\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2FacO"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaTerminarVul();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetTer2FacO\',\'\',\'botones/ter-over.png\',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTer2FacO"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolFacO\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetVolFacO"/></button>';
	
}
	
function Mamodificar_itm(itemm){

	SoloNone('MaBotMod, MaBotEli');

	EnvAyuda('Ingrese cantidad del producto a modificar.');
	
	document.getElementById('Mamod_item').value = itemm;
	
	document.getElementById('NumTex').value = "";
	document.getElementById("DondeE").value = "NumTex";
	document.getElementById("CantiE").value = "6";
	document.getElementById("QuePoE").value = "6";
	
	$("#NumTex").focus();
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return Maenviar_mod('+itemm+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2FacM'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2FacM'+itemm+'"/></button>';

	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="return Macancel_mod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetCanFacM'+itemm+'\',\'\',\'botones/can-over.png\',0)"><img src="botones/can-up.png" name="Enter" title="Enter" border="0" id="LetEnt2FacM'+itemm+'"/></button>';

	document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return Maenviar_mod('+itemm+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2FacM'+itemm+'\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2FacM'+itemm+'"/></button>';

	
	return false;
	
}

function Maeliminar_itm(itemm){

$('#Bloquear').fadeIn(500);
$("#archivos").load("EArt.php?itemm="+itemm);

	var cant = document.getElementById('Macan_item').value;
	document.getElementById('Macan_item').value = parseFloat(cant) - 1;
	
	Mac = Mac - 1;
	
	if(Mac==0){
		
		$("#Macapasitems"+Mas).remove();
		$("#MaAnt_Pro_Ti_D"+Mas).remove();
		var Mat = Mas - 1;
		$("#MaAba_Pro_Ti_D"+Mat).remove();
		Mamovpaga_t(Mas);

	}
	
	if(Mac<0){
		
		Mac = 7;
		Mas = Mas - 1;

	}
	
	SoloNone('MaBotMod, MaBotEli');
	
	$("#fmaitems_s"+itemm).remove();
	
}
	
function MaEsPromo(cs,ca,cc){

	BValue('Macant_per');
	BValue('Macant_sel');
	IValue('Macant_sel',0);

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	$("#MaItemsSel").load("MaPArt.php?cs="+cs+"&ca="+ca+"&cc="+cc);
	
	SoloNone('LetEnt, LetTer, NumVol, MaMiProd, Mamicapa1');
	SoloBlock('MaPromo, MMaPromo');

	$("#NumTex").focus();

}


function MaNUPRO(cs,ca,cp,cc,cd){

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	MaEsPromo(cs,ca,cc);
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~0";
	IValue('Madatospro',t);
	
	$("#LetEnt2Pro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVol2Pro").removeClass("PosDivv1").addClass("PosDivv2");

}


function MaNUPROB(cs,ca,cp,cc,cd){

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	MaEsPromo(cs,ca,cc);
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~1";
	IValue('Madatospro',t);
	
	$("#LetEnt2Pro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVol2Pro").removeClass("PosDivv1").addClass("PosDivv2");

}	

function MaEnviar_XEnter(){
	
	var k = window.event.keyCode;
	if(!((k == 46) || (k == 13) || ((k >= 48) && (k <= 57)))){
		return false;
	}
	
	if(k == 13){
		var como = document.getElementById("popup_container");
		if(como == null){
			var Mamod = document.getElementById('Mamod_item').value;
			if(Mamod == 0){
				
				
				var mapromo = document.getElementById('MMaPromo').style.display;
				if(mapromo == "block"){
					
					try{
						document.getElementById("MaLetEntProBut").onclick();
					}catch(err){
						//jAlert('Debe seleccionar un producto.', 'Debo Retail - Global Business Solution');
					}

				}else{
					if(window.MaEnviar_NUU){
						MaEnviar_NUU();
					}else{
						MaNuevoIXCodigoB_Nueva();
					}
				}
				
				
			}else{
				Maenviar_mod(Mamod);
			}
		}
	}
	
}

</script>

</head>

<body>
<?php

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
	$SQLL = "select codsec, codart, detart, preven, exivta, exidep, pro, fpp, ILPC, codrub, ivaco from articulos where codsec = ".$cs." and codart = ".$ca."";
		
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


	$SQLL = "select b.codbar, a.codsec, a.codart, a.detart, a.preven, a.exivta, a.exidep, a.pro, a.fpp, a.ILPC, codrub, ivaco from articulos as a inner join codbar as b on b.codsec = a.codsec and b.codart = a.codart where b.codbar = '".$p."'";		
	
	$regi=mssql_query($SQLL) or die ("Error SQL");
	$nr1 = mssql_num_rows($regi);
	if($nr1 == 0){
		
		$d = $p;
		$p = (int)$p;
		
		$SQLL = "select codsec, codart, detart, preven, exivta, exidep, pro, fpp, ILPC, codrub, ivaco from articulos where codart = '".$p."'";
		
		$registros=mssql_query($SQLL) or die ("Error SQL");
		$nr = mssql_num_rows($registros); 
		if($nr == 0){
	
			?>
			<script>				
				EnvAyuda("Busqueda: <? echo $d; ?> --> Items: 0");
				SoloNone("Mamostrar, MaMiProd, MaLoading");
			</script>    
			<?
			exit;
			
		}else{
		
			?>
			<script>
				SoloBlock("MaMiProd, MaLoading");
				$("#Mamostrar").load("MaBusqueda.php?b_cod=1&l_env="+'<? echo $p; ?>');								
				document.getElementById('LetTex').value = "";
				$("#Mamostrar").fadeIn(tim);
			</script>
			<?
			
			exit;
		
		}
			
	}
	
}

}
$registros=mssql_query($SQLL) or die ("Error SQL");
$nr = mssql_num_rows($registros); 

if($nr == 0){

	?>
	<script>
	
	EnvAyuda('No Existe el producto selecionado. <? echo $SQL; ?>');
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="MaReeCodigo()" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEnt2tt\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEnt2tt"/></button>';
	</script>	

	<?
	
}


while ($reg=mssql_fetch_array($registros)){ 
	
	
$PRECIOV = $reg['preven'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////// Buscar productor relacionados promos /////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
if($reg['fpp'] == 1){

	if(!isset($_REQUEST['fpp'])){
		
		if(!isset($_REQUEST['itemm'])){
		
			$CODSEC = $reg['codsec'];
			$CODART = $reg['codart'];
			
			$SQL = "SELECT B.CodSec AS sec, b.CodArt as art, B.DetArt as det FROM AARTPRO AS A 
			INNER JOIN ARTICULOS AS B ON A.SECP = B.CodSec AND A.CODP = B.CodArt
			WHERE A.SECA = ".$CODSEC." AND A.CODA = ".$CODART." AND B.NHA = 0";
			
			$AARTPRO = mssql_query($SQL) or die("Error SQL");
			$co = mssql_num_rows($AARTPRO);
			mssql_free_result($AARTPRO);
			
			if($co == 0){
			
				$SQL = "UPDATE ARTICULOS SET FPP = 0 WHERE CodSec = ".$CODSEC." AND CodArt = ".$CODART;
				mssql_query($SQL) or die("Error SQL");
			
				?>
				<script>
					MaFX3(<? echo $CODSEC; ?>, <? echo $CODART; ?>);	
				</script>
				<?
				exit;
			
			}else{

				?>
				<script>
					SoloBlock("MaMiProd, MaLoading");
					$("#Mamostrar").load("MaBusquedaPro.php?cs=<? echo $CODSEC; ?>&ca=<? echo $CODART; ?>");
					document.getElementById('LetTex').value = "";
					$("#Mamostrar").fadeIn(500);
				</script>
				<?
				exit;
				
			}
			
		}
		
	}

}
*/

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
					MaFX3(<? echo $CODSEC; ?>, <? echo $CODART; ?>);
				</script>
				<?
				exit;
			
			}else{
			
				?>
				<script>			

				var cantidad = parseFloat(<? echo $_SESSION['ParPMA']; ?>);
						
				function MaEnviar_NUU(){
	
					var ingreso = document.getElementById("NumTex").value;
					if(ingreso < cantidad){			
						
						MaNUU('<? echo $CODSEC; ?>','<? echo $CODART; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
						MaFX2(<? echo $CODSEC; ?>, <? echo $CODART; ?>);
						
					}else{
						
						jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
						document.getElementById("NumTex").value = "";
						
					}
					
				}
				
				document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return MaEnviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
	
				document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaCanProLis();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolPorP\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolPorP"/></button>';
						
				document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return MaEnviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2n\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2n"/></button>';
				
					SoloBlock("LetTer");
	
					document.getElementById('LetTex').value = "";
					document.getElementById('NumTex').value = "";				
					document.getElementById("DondeE").value = "NumTex";
					document.getElementById("CantiE").value = "6";
					document.getElementById("QuePoE").value = "6";
					
					$("#NumTex").focus();
	
					SoloBlock("MaMiProd, MaLoading");
					$("#Mamostrar").load("MaBusquedaPro.php?cs=<? echo $CODSEC; ?>&ca=<? echo $CODART; ?>");
					$("#Mamostrar").fadeIn(500);
					
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
	$TIPOPRO = "";
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
		<div id="MaElProd">
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
                <div align="center" id="MaBotMod">
					<?
					if($ESPROMO == 1 and ($TIPOPRO == 'B' or $TIPOPRO == 'C')){}else{
               		?> 
					<button onClick="return Mamodificar_itm(<? echo $_REQUEST['itemm']; ?>);" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotModSm','','botones/mod-over.png',0)"><img src="botones/mod-up.png" border="0" id="BotModSm"/></button>
					<?	
					}
				?>
                </div>
                
                <div align="center" id="MaBotEli">
                <button onClick="return Maeliminar_itm(<? echo $_REQUEST['itemm']; ?>);" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotEliSm','','botones/eli-over.png',0)"><img src="botones/eli-up.png" border="0" id="BotEliSm"/></button>
                </div>
                <?
                }
                ?>
                </td>
            </tr>
            <tr>
		    	<td valign="bottom">
					<div><img src="producto/ProdPre.png" /></div>
                    <div id="MaPreProd"><? echo $PRECIOVE; ?></div>
                </td>
			</tr>
            
            <tr>
	            <td colspan="2">
            	<div id="MaInfoProd">
                <div id="MaInfoProdDat" style="position:absolute; left:2px; top:239px;">
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
					MaNuevoIXCodigoB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
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
						MaNUPRO('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
					</script>
					<?
				}
				if($MCDPRO == 1){
					?>
					<script>
						MaNUPROB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
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
						MaNUPRO('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
					</script>
					<?
				}
				if($MCDPRO == 1){
					?>
					<script>
						MaNUPROB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
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
		?>
		<script>
		
			var cantidad = parseFloat(<? echo $_SESSION['ParPMA']; ?>);
			
			function MaEnviar_NUU(){

				var ingreso = document.getElementById("NumTex").value;
				if(ingreso < cantidad){
					
					MaNUU('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
					
				}else{
					
					jAlert('La cantidad supera el maximo permitido.', 'Debo Retail - Global Business Solution');
					document.getElementById("NumTex").value = "";
					
				}
				
			}

			document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="return MaEnviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

			document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="MaCanProLis();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolPorP\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolPorP"/></button>';
					
			document.getElementById('NumVol').innerHTML = '<button class="StyBoton" onclick="return MaEnviar_NUU();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac2n\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac2n"/></button>';
			
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
		?>
		<script>
		function MaNuevoIXCodigoB_Nueva(){
			MaNUU('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
		}
		MaNuevoIXCodigoB('<? echo $psec; ?>','<? echo $part; ?>',<? echo $PRECIOV; ?>,<? echo $c; ?>,'<? echo substr(htmlentities(trim($reg['detart'])), 0, 30); ?>');
		</script>
		<?
		}
				
	}	

$LOG = "Nuevo Articulo~".$psec."~".$part."~".$PRECIOV."~".$c."~".$reg['detart'];
$ID = "Control.php";
esclog(2,$LOG,$ID);

mssql_close($conexion);

}


mssql_query("commit transaction") or die("Error SQL commit");

	
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