<?
require("config/cnx.php");
try {////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

///////////////// INCIO DE CARGA ////////////////////
$_SESSION['ParSQL'] = "SELECT zon FROM aparemp";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);
while ($RSEC=mssql_fetch_array($APAREMP)){
	$numEmp = $RSEC['zon'];/****** NOMBRE DE LA EMPRESA *******/
}	
mssql_free_result($APAREMP);

$_SESSION["ActLis"] = 1;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Toma de Inventario</title>

<script type="text/javascript" language="javascript" src="TomaInvScript.js"></script>

<style>
#comope{
	position:absolute;
	top:17px;
	left:21px;
}
#conope{
	position:absolute;
	top:17px;
	left:122px;
}

#comie{
	position:absolute;
	top:17px;
	left:21px;
}
#conti{
	position:absolute;
	top:17px;
	left:122px;
}
#comi{
	position:absolute;
	top:17px;
	left:21px;
}
#cont{
	position:absolute;
	top:17px;
	left:122px;
}
.fon-tom{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#000;
	height:16px;
}
#botones_tom{
	position:absolute;
	width:664px;
	height:60px;
	left:1px;
	top:313px;
	z-index:0;
}

#fondoimg{
	position:absolute;
	z-index:-3;
}

#detsec{
	width:220px; 
	height:11px;
	top:-1px;
	left:4px;
	position:absolute;
	font-family: "TPro";

}

#sector {
	background-color:#C57624;
	border:0; 
	width:148px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:48px;
	text-align:center;
}
#sectorid{
/*	background-color:#DD7927;*/
	border:0; 
	width:29px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:2px;
	text-align:center;
}
#rubrom {
	background-color:#C57624;
	border:0; 
	width:148px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:46px;
	text-align:center;
}
#rubromid{
/*	background-color:#DD7927;*/
	border:0; 
	width:29px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:4px;
	text-align:center;
}
#rubromnum{
	position:absolute;
	top:17px;
	left:120px;
}
#rubromalf{
	position:absolute;
	top:17px;
	left:11px;
}
#rubro{
	background-color:#C57624;
	border:0; 
	width:148px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:48px;
	text-align:center;
}
#rubroid{
/*	background-color:#DD7927;*/
	border:0; 
	width:29px; 
	height:13px;
	font-family: "TPro";
	position:absolute;
	top:-1px;
	left:3px;
	text-align:center;
}

#Bloquear1{ 
	background-image:url(images/blo.png);
	position: absolute;
	text-align: center;
	display: none;
	top: 182px;
	left: 250px;
	width: 230px;
	height: 150px;
	z-index: 10;
}

#Seleccion{
	
	position:absolute;
	text-align:center;
	display:none; 
	top:-4px; 
	left:-67px; 
	width:800px; 
	height:600px; 
	z-index:10;
}

.BotTomTipoDep{
	background-color:transparent; 
	cursor:pointer;
	border:0px;
}

.BotTomTipoDep:active{ 
	position:relative;
	left:-60px;
	top:-5px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

.BotTomTipoVen{
	background-color:transparent; 
	cursor:pointer;
	border:0px;
}

.BotTomTipoVen:active{ 
	position:relative;
	left:-78px;
	top:-5px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}


</style>
<script>

SoloBlock("BotonesLet1");

$(document).ready(function(){
	$('#formTomInv').submit(function(){
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data){
			$('#descpidelista').html(data);
			}
		})
		return false;
	});
})

document.getElementById("DondeE").value = "LetTex";
document.getElementById("CantiE").value = "0";
document.getElementById("QuePoE").value = "1";

$('#Seleccion').fadeIn(500);

//SELECCIONA TODOS LOS RUBROS MAYORES
function selrumtodos(a){
	
	var bus = document.getElementById("fondopiderubm").style.display;
	
	if(bus = "block"){
		document.getElementById("fondopiderubm").style.display = "none";
		document.getElementById("descpiderubm").style.display = "none";
		document.getElementById("fondorubm").style.display = "none";
		document.getElementById('botbus').style.display = "none";	
	}

	var det = document.getElementById('detsec').value.length;
	if(det == 0 ){
		jAlert('Presione Enter para comenzar la carga de inventarios.', 'Debo Retail - Global Business Solution');
	}else{

		if(a == 1){
			
			SoloNone("BotSelTodOff");
			SoloBlock("BotSelTodOn");
	
			document.getElementById("rubrom").value = " TODOS ";
			document.getElementById("rubromid").value = 0;

			document.getElementById("DondeE").value = "rubroid";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			$("#rubmay").css("border-color", "transparent");
			$("#rub").css("border-color", "#F90");
			
			EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';

		}else{
			
			SoloBlock("BotSelTodOff");
			SoloNone("BotSelTodOn");

			document.getElementById("rubrom").value = "< RUBRO MAYOR >";
			document.getElementById("rubromid").value = "";
			
			document.getElementById("DondeE").value = "rubromid";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			EnvAyuda("Ingrese un Rubro Mayor o Presione Enter para listar");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv1\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv1"/></button>';
	
		}
	}
}

//SELECCIONA TODOS LOS RUBROS
function selrubtodos(a){

	var bus = document.getElementById("fondopiderub").style.display;

	if(bus == "block"){
		document.getElementById("fondopiderub").style.display = "none";
		document.getElementById("descpiderub").style.display = "none";
		document.getElementById("fondorub").style.display = "none";
		document.getElementById('botbusr').style.display = "none";	
	}
	
	var det = document.getElementById('detsec').value.length;
	if(det == 0 ){
		jAlert('Presione Enter para comenzar la carga de inventarios.', 'Debo Retail - Global Business Solution');
	}else{

		var rubid = document.getElementById('rubroid').value;
		if(rubid == ""){
			SoloBlock("BotSelTodRubOff");
			SoloNone("BotSelTodRubOn");
		}
	
		if(a == 1){
			
			SoloBlock("BotSelTodRubOn");
			SoloNone("BotSelTodRubOff");
			
			document.getElementById("rubro").value = " TODOS ";
			document.getElementById("rubroid").value = 0;

			$("#rub").css("border-color", "transparent");

			EnvAyuda("Presione Enter para Listar");
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv4();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv6\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv6"/></button>';
	
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv3\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv3"/></button>';
	
		}else{
			
			SoloBlock("BotSelTodRubOff");
			SoloNone("BotSelTodRubOn");
			
			document.getElementById("rubro").value = "< RUBROS >";
			document.getElementById("rubroid").value = "";		
			
			document.getElementById("DondeE").value = "rubroid";
			document.getElementById("CantiE").value = "3";
			document.getElementById("QuePoE").value = "1";
			
			EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
			
			document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';
		}
	}
}

</script>
</head>
<body>
<?

/******		PROBLEMAS CON LA TMAEFACT	******/
$swHay = false;
$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT";
$TMAEFACT = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TMAEFACT);
if(mssql_num_rows($TMAEFACT) <> 0){
	$swHay = true;
	?>
    <script>
		document.getElementById("comp").value = 0;
    </script>
    <?
}
?>
<!-- COMPROBANTE PARA TMAEFACT -->
<input type="hidden" name="comp" id="comp" />

<input type="hidden" name="sacaletter" id="sacaletter" value="0" />

<!-- MENSAJE DE BIENVENIDA -->
<div id="Seleccion" align="center">
	<table width="800" height="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td align="center">
        <div>
        <table width="300" height="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#DD7927">
        <tr height="26" align="center">
            <td background="js/images/title.gif">
            <div style='font-family: "TPro"; font-size:16px; color:#DD7927;'>
				Debo Retail - Global Business Solution
            </div>
            </td>
        </tr>
        <tr>
            <td bgcolor="#000000">
            <div style='font-family: "TPro"; font-size:16px; color:#DD7927;'>
	           	<table width="300" >
                <tr>
                <div align="center">
                	Seleccione como desea realizar la Toma de Inventario.
                </div>
                <br />
                </tr>
                <tr>
                    <td width="100">
                    <div id="Colector" style="top:20px; left:0px; display:block; z-index:3;">
                        <button  class="StyBoton" onclick="seleccion(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotColInv','','botones/col-over.png',0)"><img src="botones/col-up.png" name="Colector" title="Colector" border="0" id="BotColInv" /></button>
                    </div>
                    </td>
                    <td width="100">
                    <div id="Manual" style=" top:20px; left:100px; display:block; z-index:3;">
                        <button  class="StyBoton" onclick="seleccion(2);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotManInv','','botones/man-over.png',0)"><img src="botones/man-up.png" name="Manual" title="Manual" border="0" id="BotManInv" /></button>
                    </div>
                    </td>
                    <td width="100">
                    <div id="Salir" style=" top:20px; left:200px; display:block; z-index:3;">
                        <button  class="StyBoton" onclick="salir_tom();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotSalInv','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="BotSalInv" /></button>
                    </div>
                    </td>
                </tr>
	            </table>
            </div>
            </td>
        </tr>
        </table>
	    </div>
        </td>
    </tr>
    </table>
</div>

<div id="fondocompleto" style="display:block; position:absolute;">
<div id="fondoimg">
	<img src="InventarioToma/fondo negro1.png"/>
</div>
<div id="detallecar">
	<div id="detalleimg">
		<img src="InventarioToma/toma de inventario.png" />
	</div>
<?

$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){
	$PLA = $reg['PLA'];
}
$LUG = $_SESSION['ParLUG'];
$OPE = $_SESSION['idsusua'];

$numinv=0;
$_SESSION['ParSQL'] = "SELECT ISNULL(MAX(ID)+1,0) AS NUM FROM ITOMINVC";
$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ITOMINVC);		
while ($RITO=mssql_fetch_array($ITOMINVC)){
	$numinv=$RITO['NUM'];
}
// fecha inventario
$fecinv=date("d/m/Y");
//operario
$opeinv=$OPE;

?>
<!-- CONTROLAR COMPROBANTES PENDIENTES DE IMPRESION -->
<form method="post" action="TomInvLis.php" id="formTomInv" name="formTomInv" >
	<input type="hidden" name="colector" id="colector"/>
    <input type="hidden" name="numemp" id="numemp" value="<? echo $numEmp;?>"/>
    <input type="hidden" name="validar" id="validar" value="si" />
    <input type="hidden" name="eliminar" id="eliminar" value="no" />
    
    <?
	$lista = 0;
	if($lista != 0){
	?>
	    <input type="hidden" name="lista" id="lista" value="<? echo $lista; ?>" />    		
	<?
	}
	?>
	<input type="hidden" name="cfMSG" id="cfMSG" value="1" />
	
    <!-- BOTONES PARA BUSCAR RUBROS OPERARIOS 
	<div id="botbusope" style="position:absolute; top:315px; left:204px; display:none;">
		<input type="radio" name="comope" id="comope" onclick="cambiaope(1);" />
		<input type="radio" name="conope" id="conope" onclick="cambiaope(2);" />
		<input type="hidden" name="opebus" id="opebus" />
	</div>
    -->
    <!-- BOTONES PARA BUSCAR RUBROS MAYORES -->
	<div id="botbus" style="position:absolute; top:315px; left:204px; display:none;">
<!--
		<input type="radio" name="comi" id="comi" onclick="cambiabus(1);" />
		<input type="radio" name="cont" id="cont" onclick="cambiabus(2);" />

-->		<input type="hidden" name="rubmbus" id="rubmbus" />

		<div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:33px; z-index:3;'>Comience</div>        
        <div id="busrubmayComOff" style=" position:absolute; top:0px; left:113px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;">
                <img src="producto/fondo de tilde.png" onclick="cambiabus(1);" style="cursor:pointer;"/>
            </div>
        </div>
        <div id="busrubmayComOn" style="display:none; position:absolute; top:0px; left:113px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;" align="center">
                <img src="producto/ConTil.png" onclick="cambiabus(1);" style="cursor:pointer;"/>
            </div>
        </div>

        <div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:155px; z-index:3;'>Contenga</div>
        <div id="busrubmayConOff" style=" position:absolute; top:0px; left:235px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;">
                <img src="producto/fondo de tilde.png" onclick="cambiabus(2);" style="cursor:pointer;"/>
            </div>
        </div>
        <div id="busrubmayConOn" style="display:none; position:absolute; top:0px; left:235px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;" align="center">
                <img src="producto/ConTil.png" onclick="cambiabus(2);" style="cursor:pointer;"/>
            </div>
        </div>

	</div>


    
    
	<!-- BOTONES PARA BUSCAR RUBROS -->
	<div id="botbusr" style="position:absolute; top:315px; left:204px; display:none; z-index:10;">

<!--	<input type="radio" name="comie" id="comie" onclick="cambiabusc(1);" />
		<input type="radio" name="conti" id="conti" onclick="cambiabusc(2);" />
-->
		<input type="hidden" name="rubbus" id="rubbus" />

		<div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:33px; z-index:3;'>Comience</div>        
        <div id="busrubComOff" style=" position:absolute; top:0px; left:113px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;">
                <img src="producto/fondo de tilde.png" onclick="cambiabusc(1);" style="cursor:pointer;"/>
            </div>
        </div>
        <div id="busrubComOn" style="display:none; position:absolute; top:0px; left:113px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;" align="center">
                <img src="producto/ConTil.png" onclick="cambiabusc(1);" style="cursor:pointer;"/>
            </div>
        </div>

        <div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:155px; z-index:3;'>Contenga</div>
        <div id="busrubConOff" style=" position:absolute; top:0px; left:235px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;">
                <img src="producto/fondo de tilde.png" onclick="cambiabusc(2);" style="cursor:pointer;"/>
            </div>
        </div>
        <div id="busrubConOn" style="display:none; position:absolute; top:0px; left:235px; z-index:3;">
            <div style="position:absolute; top:22px; left:-117px;" align="center">
                <img src="producto/ConTil.png" onclick="cambiabusc(2);" style="cursor:pointer;"/>
            </div>
        </div>




	</div>


	<div id="datos_planilla">
		<div id="numinv1" class="fon-tom" style="position:absolute; top:53px; left:19px; width:63px; display:none;" align="center"><? echo $numinv; ?></div>

			<input type="hidden" name="numinv" id="numinv" value="<? echo $numinv; ?>" />
            
		<div id="detinv" class="div-redondo" style="position:absolute; top:51px; left:86px; width:233px; height:14px; display:none; " align="center">
			<input type="text" name="detsec" id="detsec" maxlength="25" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent;" />
		</div>

		<div id="fecinv" class="fon-tom" style="position:absolute; top:53px; left:331px; width:74px; display:none;" align="center"><? echo $fecinv; ?></div>

		<!-- SELECCION DE TIPOS -->
        <div id="tipoinv" class="fon-tom" style="position:absolute; top:50px; left:412px; width:153px;" align="center">
        
            <button onclick="return seltipoinv(0);" class="BotTomTipoDep" >
                <img src="InventarioToma/deposito-up.png" name="BotDep1Inv" title="Depósito" border="0" id="BotDep1Inv" style=" position:absolute; top:1px; left:4px; cursor:pointer" />
            </button>


            <button onclick="return seltipoinv(1);" class="BotTomTipoVen" >
                <img src="InventarioToma/ventas-up.png" name="BotVen1Inv" title="Ventas" border="0" id="BotVen1Inv" style=" position:absolute; top:1px; left:84px; cursor:pointer" />
            </button>

            <input type="hidden" name="tiposel" id="tiposel" />
        
        </div>

		<div id="opeinv" class="div-redondo" style="position:absolute; top:50px; left:568px; width:65px; display:none;" align="center">
			<input type="text" onclick="buscaope();" name="opeinventario" class="fon-tom" id="opeinventario" readonly="readonly" autocomplete="off" style="width:65px; background-color:#DD7927; height:13px; border:0px; text-align:center; cursor:pointer; background-color:transparent;" value="<? echo $opeinv; ?>" />
		</div>

		<!-- BUSQUEDA DEL OPERARIO SI TOMA POR COLECTOR -->
		<div id="fondoope" style="position:absolute; top:0px; left:-41px; width:704px; height:572px; z-index:1; display:none;"></div>
		<div id="fondopideope" style="position:absolute; top:140px; left:178px; display:none; z-index:2;">
			<img src="InventarioToma/cuadro operario.png"/>
		</div>
		<div id="descpideope" style="position:absolute; top:178px; left:185px; display:none; z-index:2;"></div>

		<!-- BUSQUEDA DE SECTOR -->
		<div id="sectores" class="div-redondo" style="position:absolute; top:97px; left:14px; width:36px;" align="center">
			<input type="text" name="sector" id="sector" onclick="buscasec();" style="cursor:pointer;" autocomplete="off" readonly="readonly" value="< SECTORES >"/>
			<input type="text" name="sectorid" id="sectorid" readonly="readonly" autocomplete="off" style="background-color:transparent; width:30px;"/>

		</div>
		
		<div id="fondosec" style="position:absolute; top:0px; left:-41px; width:704px; height:572px; z-index:1; display:none;"></div>
		<div id="fondopidesec" style="position:absolute; top:149px; left:178px; display:none; z-index:2;">
			<img src="InventarioToma/cuadro sector.png" />
		</div>
		<div id="descpidesec" style="position:absolute; top:600px; left:104px; display:none; z-index:2;"></div>
	
		<!-- BUSQUEDA DE RUBRO MAYOR -->
		<div id="rubmay" class="div-redondo" style="position:absolute; top:97px; left:222px; width:36px;" align="center">
            <input type="text" name="rubrom" id="rubrom" onclick="buscarubm();" style="cursor:pointer;" autocomplete="off" readonly="readonly"  value="< RUBRO MAYOR >" />
            <input type="text" name="rubromid" id="rubromid" readonly="readonly" autocomplete="off" style="background-color:transparent;"/>

            <!-- SELECCIONA TODOS LOS RUBROS MAYORES -->
            <div id="BotSelTodOff" style=" position:absolute; top:0px; left:140px;">
                <div style="position:absolute; top:22px; left:-117px;">
                    <img src="producto/fondo de tilde.png" onclick="selrumtodos(1);" style="cursor:pointer;"/>
                </div>
                <div style='font-family: "TPro"; width:133px; position:absolute; top:23px; left:-82px;'>Todos Los Rubros Mayores </div>
            </div>
    
            <div id="BotSelTodOn" style="display:none; position:absolute; top:0px; left:140px;">
                <div style="position:absolute; top:22px; left:-117px;" align="center">
                    <img src="producto/ConTil.png" onclick="selrumtodos(2);" style="cursor:pointer;"/>
                </div>
                <div style='font-family: "TPro"; width:133px; position:absolute; top:23px; left:-82px;'>Todos Los Rubros Mayores </div>
            </div>
		</div>

		<div id="fondorubm" style="position:absolute; top:0px; left:-41px; width:704px; height:367px; z-index:1; display:none;"></div>
		<div id="fondopiderubm" style="position:absolute; top:147px; left:178px; display:none; z-index:2;">
			<img src="InventarioToma/rubromFC.png"/>
		</div>
		<div id="descpiderubm" style="position:absolute; top:598px; left:103px; display:none; z-index:2;"></div>


		<!-- BUSQUEDA DE RUBRO -->
		<div id="rub" class="div-redondo" style="position:absolute; top:97px; left:432px; width:36px;" align="center">
			<input type="text" name="rubro" id="rubro" onclick="buscarub();" style="cursor:pointer;" autocomplete="off" readonly="readonly"  value="< RUBROS >" />
			<input type="text" name="rubroid" id="rubroid" readonly="readonly" autocomplete="off" style="background-color:transparent;" />
            
            
			<!-- SELECCIONA TODOS LOS RUBROS MAYORES -->
            <div id="BotSelTodRubOff" style=" position:absolute; top:0px; left:160px;">
                <div style="position:absolute; top:22px; left:-117px;">
                    <img src="producto/fondo de tilde.png" onclick="selrubtodos(1);" style="cursor:pointer;"/>
                </div>
                <div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:-82px;'>Todos Los Rubros</div>
            </div>
    
            <div id="BotSelTodRubOn" style="display:none; position:absolute; top:0px; left:160px;">
                <div style="position:absolute; top:22px; left:-117px;" align="center">
                    <img src="producto/ConTil.png" onclick="selrubtodos(2);" style="cursor:pointer;"/>
                </div>
                <div style='font-family: "TPro"; width:91px; position:absolute; top:23px; left:-82px;'>Todos Los Rubros</div>
            </div>
            
		</div>
		<div id="fondorub" style="position:absolute; top:0px; left:-41px; width:704px; height:367px; z-index:1; display:none;"></div>
		<div id="fondopiderub" style="position:absolute; top:147px; left:178px; display:none; z-index:2;">
			<img src="InventarioToma/rubrosFC.png"/>
		</div>
		<div id="descpiderub" style="position:absolute; top:599px; left:103px; display:none; z-index:2;"></div>
        
		<!-- LISTA DETALLADA -->
		<div id="fondolista" style="position:absolute; width:650px; height:325px; top:0px; left:0px; z-index:1; display:none;"></div>
		<div id="fondopidelista" style="position:absolute; top:147px; left:10px; display:none; z-index:2;">
			<img src="InventarioToma/titulo de toma de inventario.png" />
		</div>
		<div id="descpidelista" style="position:absolute; top:174px; left:17px; display:none; z-index:2;"></div>


        <!-- SELECCIONA TODOS LOS RUBROS MAYORES -->
		<div id="ordenalista" style="display:none; position:absolute; top:326px; left:211px; z-index:3;">
            <input type="hidden" name="ordenlista" id="ordenlista" />
            <div id="rubromalf" style="position:absolute; top:-12px; left:-90px;">
                <div id="rubromalfOff" style="position:absolute; top:22px; left:-117px; display:block; cursor:pointer;">
                    <img src="producto/fondo de tilde.png" onclick="ordenarlista(1);" />
                </div>
                <div id="rubromalfOn" style="position:absolute; top:22px; left:-117px; display:none; cursor:pointer;">
                    <img src="producto/ConTil.png" onclick="ordenarlista(1);" />
                </div>
                <div onclick="ordenarlista(1);" style='font-family: "TPro"; width:70px; position:absolute; top:23px; left:-82px; cursor:pointer;'>ALFAB&Eacute;TICO</div>
            </div>
    
            <div id="rubromnum" style="position:absolute; top:-12px; left:37px;">
                <div id="rubromnumOff" style="display:block; position:absolute; top:22px; left:-117px; cursor:pointer;" align="center">
                    <img src="producto/fondo de tilde.png" onclick="ordenarlista(2);"/>
                </div>
                <div id="rubromnumOn" style="display:block; position:absolute; top:22px; left:-117px; cursor:pointer;" align="center">
                    <img src="producto/ConTil.png" onclick="ordenarlista(2);"/>
                </div>
                <div onclick="ordenarlista(2);" style='font-family: "TPro"; width:61px; position:absolute; top:23px; left:-82px; cursor:pointer;'>NUM&Eacute;RICO </div>
            </div>

            <!-- BOTON SELECCIONA TODOS LOS ARTICULOS -->
	        <div id="selectodos" style="position:absolute; top:-12px; left:154px; z-index:3;">
                <div id="todartOff" style="display:block; position:absolute; top:22px; left:-117px; cursor:pointer;" align="center">
                    <img src="producto/fondo de tilde.png" onclick="seltodos(1);"/>
                </div>
                <div id="todartOn" style="display:none; position:absolute; top:22px; left:-117px; cursor:pointer;" align="center">
                    <img src="producto/ConTil.png" onclick="seltodos(2);"/>
                </div>
                <div onclick="seltodos();" style='font-family: "TPro"; width:100px; position:absolute; top:23px; left:-82px; cursor:pointer;'>Sel.Todos los Art. </div>
            </div>

			<div style="display:none;">
                <input type="radio" name="rubrostodos" id="rubrostodos" onclick="seltodos();" style="position:absolute; top:18px; left:475px; display:none; z-index:4; cursor:pointer;"/>
                <div id="rubrotodos1" style="display:none; position:absolute; top:21px; left:493px; width:100px; font-family: 'TPro'; z-index:4; cursor:pointer;"></div>
			</div>
		</div>


	</div>
</form>

<div id="botones_tom">
	<table width="726" >
		<tr>
			<td width="20">
			<div id="Cancelar" style="position:absolute; top:9px; left:365px; display:none; z-index:3;">
				<button  class="StyBoton" onclick="cancelalista();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotCanInv','','botones/can-over.png',0)"><img src="botones/can-up.png" name="Cancelar" title="Cancelar" border="0" id="BotCanInv" /></button>
			</div>
            </td>
            
			<td width="367">
            <div id="GrabarInv" style="position:absolute; top:10px; left:465px; display:none; z-index:3;">
				<button  class="StyBoton" onclick="nuevalista();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAgrInv','','botones/agr-rub-over.png',0)"><img src="botones/agr-rub-up.png" name="Agregar Rubro" title="Agregar Rubro" border="0" id="BotAgrInv" /></button>
			</div>
			</td>
			
			<td width="85">	
<!--
            <div id="ImprimirInv" style="position:absolute; top:10px; left:465px; display:none; z-index:1;">
				<button  class="StyBoton" onclick="genera_pdf();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImpInv','','botones/imp-over.png',0)"><img src="botones/imp-up.png" name="Generar" title="Imprimir" border="0" id="BotImpInv" /></button>
			</div>
-->
          </td>
			
			<td width="85">
            <form action="TomaInvPdf.php" method="post" name="genera" id="genera">
            	<input type="hidden" name="var" id="var" value="1" />
            </form>
			</td>
            
            <td width="400">
            <div id="GrabarInvenTer" style="position:absolute; top:10px; left:565px; display:none; z-index:3;">
	<button  class="StyBoton" onClick="return envialista(1);" onMouseOut="MM_swapImgRestore()" onmouseover=	"MM_swapImage('BotGraInvLis1','','botones/gra-over.png',0)"><img src="botones/gra-up.png" name="Grabar" title="Grabar" border="0" id="BotGraInvLis1" /></button>
			</div>
            </td>
            
		</tr>
	</table>
</div>
</div>
</div>

<div id="DivImp" style="position:absolute; top:0px; left:-59px; width:790px; height:528px; display:none; z-index:3;"></div>

</body>
</html>

<?
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