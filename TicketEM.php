<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

if(isset($_REQUEST['ban'])){

	if($_REQUEST['ban'] == 1){
	?>	
		<script>

			SoloBlock("TicketGeneral");
			SoloNone("identificacion, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetSal, LetEnt");

    	</script>
    <?
	}	
}else{
	?>	
		<script>

			SoloBlock("identificacion, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetSal, LetEnt");
			SoloNone("TicketGeneral, NumVol");
			
			$("#usrDiv").css("border-color", "#F90");
			
			$('#usua').focus();
			document.getElementById("DondeE").value = "usua";
			document.getElementById("CantiE").value = "12";
			document.getElementById("QuePoE").value = "6";
			
			EnvAyuda("Ingrese la clave del operario Supervisor.");
			
			document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTicket\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTicket"/></button>';
			
			document.getElementById('LetSal').innerHTML = '<button onclick="Salir_Tic_Val();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTicket\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTicket"/></button>';

    	</script>    
	<?
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ticket Emitidos</title>

<style>

#TicketGeneral{
	position:absolute;
	width:726px;
	height:400px;
}

.det-tiq{
	font-family: "TPro";
	font-size:10px;
	position:absolute;
	height:16px;
}

.lineare1:active{ 
	position:relative;
	left:1px;
	top:1px;
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

#TicketLista{
 	position:absolute;
	width:269px; 
	height:280px;
	left:11px; 
	top:51px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
}

#TicketDetalle{
	position:absolute; 
	width:473px; 
	height:308px;
	top:29px;
	left:292px;
	z-index:2;
}

#TicketDetalleFon{
	position:absolute; 
	width:473px; 
	height:308px;
	top:29px;
	left:292px;
	z-index:2;
}


.OcultarDetalle{
	display: none;
}

.texteca{
	background-color:transparent;
	color:#FFF;
	text-align:center;
	font-family: "TPro";
	margin-top:5px;
	font-size:12px;
	border:0px;
}
</style>
<script>

function Salir_Tic_Val(){
	
	Mos_Ocu("BotonesPri");
	Mos_Ocu('TicketEM');
	SoloNone("identificacion, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetSal, LetEnt, CarAyudaFon, CarAyuda");
	$('#SobreFoca').fadeIn(500);
	document.getElementById('identificacion').innerHTML = '';


}

function salir_tic(){

	Mos_Ocu("BotonesPri");
	Mos_Ocu('TicketEM');
	$('#SobreFoca').fadeIn(500);
	document.getElementById('TicketEM').innerHTML = '';

}

function Valida_Usuario (){

	var usr = document.getElementById("usua").value;
	var usrDB  = document.getElementById("claDB").value;


	if(usr <= 0){
		
		jAlert('Ingrese un Operario.', 'Debo Retail - Global Business Solution');
		document.getElementById("usua").value = "";
//		controlarcadainput('usua');
		
	}else{

		$("#usrDiv").css("border-color", "transparent");
		$("#pswDiv").css("border-color", "#F90");
		
		$('#psw').focus();
		controlarcadainput('psw');
		document.getElementById("DondeE").value = "psw";
		document.getElementById("CantiE").value = "10";
		document.getElementById("QuePoE").value = "0";
		
		SoloBlock("NumVol");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Password();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTicket\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTicket"/></button>';		

		document.getElementById('NumVol').innerHTML = '<button onclick="Volver_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'NumVolTicket\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="NumVolTicket"/></button>';		
		
		EnvAyuda("Ingrese la contraseña del Operario.");
		
	}
	
	

}

function Volver_Usuario(){


	$("#usrDiv").css("border-color", "#F90");
	$("#pswDiv").css("border-color", "transparent");
	
	$('#usua').focus();	
	controlarcadainput('usua');
	
	document.getElementById("DondeE").value = "usua";
	document.getElementById("CantiE").value = "12";
	document.getElementById("QuePoE").value = "1";
	
	EnvAyuda("Ingrese la clave del operario Supervisor.");
	SoloNone("NumVol");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="Valida_Usuario();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTicket\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTicket"/></button>';		
	
}

function Valida_Password(){

	var usr  = document.getElementById("usua").value;
	var psw  = document.getElementById("psw").value;
	
	if(psw.length <= 0){
		
		jAlert('Ingrese una clave correcta.', 'Debo Retail - Global Business Solution');
		document.getElementById("psw").value = "";		
//		controlarcadainput('psw');
	}else{
		
		$("#archivos").load("TicketVal.php?usr="+usr+"&psw="+psw+"");
		
	}
}

function TicketSel(t,mp,tip,tco,suc,nco,anu){
	
	$('#TicketDetalle').fadeOut(500);

	$("#TicketDetalle").load("TicketM.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"");
	
	$('#TicketDetalle').fadeIn(500);
	
	$("#TicketDetalle").removeClass("OcultarDetalle");
	$("#TicketDetalleFon").removeClass("OcultarDetalle");

	for (i=1; i<=t; i++){
	
		if(i == mp){
			
			$("#linea"+mp).removeClass("lineare1").addClass("lineare2");
			
				if(anu == 'A'){

					document.getElementById("Tic_BotAnuM").style.display = "none";

				}else{
					
					document.getElementById("Tic_BotAnuM").style.display = "block";
					
					document.getElementById('Tic_BotAnuM').innerHTML = '<button class="StyBoton" onclick="AccBotAnuTic(\''+tip+'\',\''+tco+'\','+suc+','+nco+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnu\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnu"/></button>';

				}
		}else{
			$("#linea"+i).removeClass("lineare2").addClass("lineare1");
		}	
		
	}
}

function AccBotAnuTic(tip,tco,suc,nco){
	jConfirm("¿Est\u00e1 seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$("#archivos").load("TicketANU.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"");
		}
	});
}

function movpag_a_tiem(p){
	
	np = p - 1;
	document.getElementById("capa_tiem"+np).style.display="block";
	document.getElementById("capa_tiem"+p).style.display="none";

return false;
}

function movpag_b_tiem(p){

	np = p + 1;	
	document.getElementById("capa_tiem"+np).style.display="block";
	document.getElementById("capa_tiem"+p).style.display="none";
	
return false;
}


/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

$("input").attr("readonly", "readonly");
$("#usua").removeAttr("readonly");

function ControlUsr(){

	if(document.getElementById("usrDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 13) || ((k >= 48) && (k <= 57)))){		//SOLO NUMEROS
		return false;
	}
	if(k == 13){
		Valida_Usuario();
	}	
}

function ControlPsw(){

	if(document.getElementById("pswDiv").style.borderColor == 'transparent'){
		return false;
	}
	var k = window.event.keyCode;
	if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 48) && (k <= 57)) || ((k >= 97) && (k <= 122)))){	//ALFANUMERICO
		return false;
	}
	if(k == 13){
		Valida_Password();
	}

}

function ControlPswVol(){
	
	if(document.getElementById("pswDiv").style.borderColor == 'transparent'){
		return false;
	}	
	var k = window.event.keyCode;
	if(k == 27){
		Volver_Usuario();
	}

}


function controlarcadainput(cu){

	if(cu == "usua"){
		
		$("#usua").removeAttr("readonly");	
		$("#psw").attr("readonly", "readonly");

	}else{
		
		$("#psw").removeAttr("readonly");	
		$("#usua").attr("readonly", "readonly");
		
	}
}

</script>

</head>
<body>

<div id="identificacion" style="display:block; position:absolute; top:70px; left:266px;">

<?
	//SELECT PARA BUSCAR LA CLAVE DEL OPERARIO
	
	$_SESSION['ParSQL'] = "SELECT CodVen, ClaVen FROM VENDEDORES";
	$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($RSBTABLA);
	
	while ($RB=mssql_fetch_array($RSBTABLA)){
		$CodVen = $RB['CodVen'];
		$ClaVen = $RB['ClaVen'];
	}
?>
<input type="hidden" value="<? echo trim($ClaVen); ?>" id="claDB" name="claDB" />
<input type="hidden" value="<? echo trim($CodVen); ?>" id="pswDB" name="pswDB" />

<div id="titulo" style="position:absolute; top:10px; left:40px; font-family:'TPro'">Ingrese el c&oacute;digo de Operario</div>

<table width="239" height="108" align="center" background="tarjetas/fonind.png" style="background-color:transparent; background-repeat:no-repeat; ">
<tr>
<td valign="bottom">
    <table width="224" align="center">
   
    <tr>
    <td background="tarjetas/usua.png" style="background-repeat:no-repeat;" width="218" height="21">
        <div align="right" id="usrDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
            <input type="text" name="usua" id="usua" class="texteca" size="17" maxlength="8" onKeyPress="return ControlUsr();" style="position:absolute; left:80px; outline-style:none; border-style:none;" />
        </div>
    </td>
    </tr>
    <tr>
    <td background="tarjetas/cont.png" style="background-repeat:no-repeat;">
        <div align="right" id="pswDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
            <input type="password" name="psw" id="psw" class="texteca" size="17" maxlength="8" onKeyPress="return ControlPsw();" onKeyDown="return ControlPswVol();" style="position:absolute; left:80px; outline-style:none; border-style:none;"/>
        </div>
    </td>
    </tr>

    </table>
</td>
</tr>
</table>


</div>

<div id="TicketGeneral" style="display:none;">

<div id="Ticketfondo">
	<img src="ticketEmitidos/ticketsemitidos.png" />
</div>


<div id="TicketLista">
	
<?
$_SESSION['ParSQL'] = "
SELECT C.NplVen AS PLA FROM ATURNOSH AS A 
INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
WHERE A.MTN = D.MTN
";

$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		

if(mssql_num_rows($registros)==0){
	exit;
}
while ($reg=mssql_fetch_array($registros)){

	$PLA = $reg['PLA'];
	
}

$_SESSION['ParSQL'] = "SELECT TIP,TCO,SUC,NCO,ANU FROM AMAEFACT WHERE PLA =".$PLA." AND LUG =".$_SESSION['ParLUG']." ORDER BY TIP, TCO,SUC, NCO DESC"; 

$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($R1TB);		

if(!mssql_num_rows($R1TB) == 0){
	$total = mssql_num_rows($R1TB);
}

$c = 0;
$cc = 0;
$s = 1;

while ($ATU=mssql_fetch_row($R1TB)){


	$c = $c + 1;
	$cc = $cc + 1;

	
	if ($c == 1){
	
		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}
	
		echo "<div id=\"capa_tiem".$s."\" style=\"display:".$e."\">";
		
		if($s <> 1){
			?>
		
			<div id="AnteriorFac" style=" position:absolute; top:298px; left:225px;">
					<button class="StyBoton" onClick="return movpag_a_tiem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorFac_Ti','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorFac_Ti"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="lineare1" id="linea<? echo $cc; ?>" style="width:269px;" onClick="TicketSel(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $ATU['0']; ?>','<? echo $ATU['1']; ?>',<? echo $ATU['2'];?>,<? echo $ATU['3'];?>,'<? echo $ATU['4'];?>');">
		<table width="269" height="26" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="41" align="center"><? echo $ATU['0']; ?></td>
			<!--TIP-->
			<td width="45" align="center"><? echo $ATU['1']; ?></td>
			<!--,TCO-->
			<td width="73" align="center"><? echo $ATU['2']; ?></td>
			<!--,SUC-->
			<td width="64" align="center"><? echo $ATU['3']; ?></td>
			<!--,NCO-->
			<td width="46" align="center"><? echo $ATU['4']; ?></td>
			<!--,ANU-->
		</tr>
	  </table>
	</div>
	<?


	if ($c == 10){
	
		?>
	
		<div id="SiguienteFac" style="position:absolute; top:298px;  left:190px;">
				<button class="StyBoton" onClick="return movpag_b_tiem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteFac_Ti','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteFac_Ti"/></button>
		</div>
		
		</div>
		
		<?php
		  
		$c = 0;
		$s = $s + 1;

	}
	
}

if ($cc == 10){
	?>
	<script>
		$("#SiguienteFac").fadeOut('fast');
    </script>
	<?
}
?>
	
</div>
</div>

<div id="sale" style="position:absolute; left:5px; top:345px;">
	<button class="StyBoton" onClick="salir_tic();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('LetSalirTi','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirTi"></button>
</div>

<div id="TicketDetalleFon" class="OcultarDetalle"><img src="ticketEmitidos/comprobantes internos.png" /></div>

<div id="TicketDetalle" class="OcultarDetalle" ></div>

<div id="Tic_BotAnuM" style="position:absolute; top:345px; left:415px; display:none;"></div>
	
</div>	
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