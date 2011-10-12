<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ticket Emitidos</title>

<style>
.det-tiq{
	font-family: "TPro";
	font-size:10px;
	position:absolute;
	height:16px;
}

#TicketLista{
 	position:absolute;
	width:269px; 
	height:280px;
	left:11px; 
	top:49px;
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
	top:-20px;
	left:281px;
	z-index:2;
}

#TicketDetalleFon{
	position:absolute; 
	width:473px; 
	height:308px;
	top:-20px;
	left:281px;
	z-index:2;
}


.OcultarDetalle{
	display: none;
}

</style>
<script>

function salir_tic(){

	$('#BotonesPri').fadeIn(500);
	//Mos_Ocu('TicketEM');
	document.getElementById('TicketEM').innerHTML = '';
	
}

function TicketSel(t,mp,tip,tco,suc,nco,anu){

	$("#TicketDetalle").load("TicketM.php?tip="+tip+"&tco="+tco+"&suc="+suc+"&nco="+nco+"");
	
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

</script>


</head>

<body>


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
//$_SESSION['ParSQL'] = "SELECT TIP,TCO,SUC,NCO,ANU FROM AMAEFACT WHERE PLA = ".$PLA." AND LUG = ".$_SESSION['ParLUG']." ORDER BY TIP, TCO,SUC, NCO DESC"; 

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
		
			<div id="AnteriorFac" style=" position:absolute; top:304px; left:225px;">
					<button class="StyBoton" onclick="return movpag_a_tiem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorFac_Ti','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorFac_Ti"/></button>
			</div>
	
			<?
	
		}
	
	}
	
	?>
	<div class="lineare1" id="linea<? echo $cc; ?>" style="width:269px;" onclick="TicketSel(<? echo $total; ?>,<? echo $cc; ?>,'<? echo $ATU['0']; ?>','<? echo $ATU['1']; ?>',<? echo $ATU['2'];?>,<? echo $ATU['3'];?>,'<? echo $ATU['4'];?>');">
		<table width="269" height="26" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="53" align="center"><? echo $ATU['3']; ?></td>
			<!--TIP-->
			<td width="53" align="center"><? echo $ATU['0']; ?></td>
			<!--,TCO-->
			<td width="53" align="center"><? echo $ATU['1']; ?></td>
			<!--,SUC-->
			<td width="53" align="center"><? echo $ATU['2']; ?></td>
			<!--,NCO-->
			<td width="53" align="center"><? echo $ATU['4']; ?></td>
			<!--,ANU-->
		</tr>
	  </table>
	</div>
	<?


	if ($c == 10){
	
		?>
	
		<div id="SiguienteFac" style="position:absolute; top:304px;  left:190px;">
				<button class="StyBoton" onclick="return movpag_b_tiem(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteFac_Ti','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteFac_Ti"/></button>
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


<div id="sale" style="position:absolute; left:5px; top:300px;">
	<button id="BotLetSal" onclick="salir_tic();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirTi','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirTi"></button>
</div>


<div id="TicketDetalleFon" class="OcultarDetalle" >
	<img src="ticketEmitidos/comprobantes internos.png" />
</div>

<div id="TicketDetalle" class="OcultarDetalle" >
</div>

<div id="Tic_BotAnuM" style="position:absolute; top:300px; left:415px; display:none;">

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