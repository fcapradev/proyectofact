<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tarjetas</title>

<style>

#TarjetasGeneral{
	position:absolute;
	width:777px;
	height:392px;
	display:block;	
}

#TarDetalles{
 	position:absolute;
	width:726px; 
	height:260px;
	left:11px; 
	top:50px;
	font: Gautami; 
	font-weight:bold; 
	color:#FFFFFF; 
	font-size:12px; 
	z-index:1;
	
}

#TarDetalle{
	position:absolute; 
	width:267px; 
	height:289px;
	top:52px;
	left:11px;
	z-index:2;
}

#TarDetalleFon{
	position:absolute; 
	width:354px; 
	height:240px;
	top:60px;
	left:350px;
	z-index:1;
}

#TarDetalleCon{
	position:absolute; 
	width:354px; 
	height:240px;
	top:60px;
	left:350px;
	z-index:3;
}

.OcultarDetalle{
	display: none;
}

</style>

<script language="javascript" type="text/javascript" >

var contador = 0;
var contador_cappp = 0;
var contador_capss = 1;
var contador_total = 0;

var controlde = 0;

document.onkeydown = function(){

if(controlde == 0){

	var control = document.getElementById('controldepaso').value;
	
		if(window.event && control == 0){
			
			if(window.event.keyCode == 38){
				
				document.getElementById('controldepaso').value = 1;
				
				var concontador = contador - 1;
				
				if(concontador <= 0){ 
					return false; 
				}else{
					contador = contador - 1;
				}
				if(document.getElementById('linea'+contador).className == 'lineare1'){
					document.getElementById('linea'+contador).onclick();
				}
				if(contador_cappp == 10){
					contador_capss = contador_capss + 1;
					if(contador_capss != 0){
						movpag_a_tar(contador_capss);
					}
				}
			
			}
			if(window.event.keyCode == 40){
				
				document.getElementById('controldepaso').value = 1;
				
				if(contador < contador_total || contador == 0){
					
					contador = contador + 1;
					
					if(document.getElementById('linea'+contador).className == 'lineare1'){
						document.getElementById('linea'+contador).onclick();
					}
					
					if(contador_cappp == 1){
						
						contador_capss = contador_capss - 1;
						if(contador_capss != 0){
							movpag_b_tar(contador_capss);
						}
						
					}
				
				}
							
			}
			
		}

	}
	
}

function salir_tar(){
	
	Mos_Ocu('BotonesPri');
	Mos_Ocu('Tarjetas');
	$('#SobreFoca').fadeIn(500);
	document.getElementById('Tarjetas').innerHTML = '';

}

function movpag_a_tar(p){
	
	np = p - 1;
	document.getElementById("capa_tar"+np).style.display="block";
	document.getElementById("capa_tar"+p).style.display="none";

return false;
}

function movpag_b_tar(p){

	np = p + 1;	
	document.getElementById("capa_tar"+np).style.display="block";
	document.getElementById("capa_tar"+p).style.display="none";
	
return false;
}

function select_tar(t,mp,tar,ncu,nlo){
	
	contador = mp;
	contador_total = t;
	
	contador_cappp = mp % 10;
	if(contador_cappp == 0){
		contador_cappp = 10;
		contador_capss = parseInt(mp / 10);
	}else{
		contador_capss = parseInt(mp / 10) + 1;
	}
	
	$('#TarDetalleCon').fadeOut(500);
	$("#TarDetalleCon").load("TarCon.php?tar="+tar+"&ncu="+ncu+"&nlo="+nlo+"");
	$('#TarDetalleCon').fadeIn(500);
	$("#TarDetalleCon").removeClass("OcultarDetalle");
	$("#TarDetalleFon").removeClass("OcultarDetalle");
	



	for (i=1; i<=t; i++){
	
		if(i == mp){			
			$("#linea"+mp).removeClass("lineare1").addClass("lineare2");
			
			SoloBlock("Tar_Mod, Tar_Eli");

			document.getElementById('Tar_Mod').innerHTML = '<button class="StyBoton" onclick="ModTar('+tar+','+ncu+','+nlo+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotModTar\',\'\',\'botones/mod-over.png\',0)"><img src="botones/mod-up.png" name="Modificar" title="Modificar" border="0" id="BotModTar"/></button>';

			document.getElementById('Tar_Eli').innerHTML = '<button class="StyBoton" onclick="ModEli('+tar+','+ncu+','+nlo+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotEliTar\',\'\',\'botones/eli-over.png\',0)"><img src="botones/eli-up.png" name="Eliminar" title="Eliminar" border="0" id="BotEliTar"/></button>';
			
			
		}else{
			$("#linea"+i).removeClass("lineare2").addClass("lineare1");
		}	
		
	}
}

function AccBotTar(){
	
	controlde = 1;
	
	$('#Tarjetas').fadeOut(500);
	$("#Tarjetas").load("TarAgr.php?se=a");
	$('#Tarjetas').fadeIn(500);
		
	SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, NumVol, LetSal');
	SoloNone('LetTer');
	
	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="asalir_tarjeta();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTarAgr\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTarAgr"/></button>';

}

function ModTar(tar, ncu, nlo){

	SoloBlock('Marca, fondotranspletras, TecladoLet, fondotranspnumeros, TecladoNum, LetEnt, LetSal');

	document.getElementById('LetEnt').innerHTML = '';
	document.getElementById('LetSal').innerHTML = '';
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tar_Mod();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTarMod\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTarMod"/></button>';

	document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_tarjeta_mod();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTarMod\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTarMod"/></button>';
	
	EnvAyuda("Ingrese el importe a modificar.");

	document.getElementById("DondeE").value = "importe_mod";
	document.getElementById("CantiE").value = "8";
	document.getElementById("QuePoE").value = "1";
	
	$('#Tarjetas').fadeOut(500);
	$("#Tarjetas").load("TarMod.php?tar="+tar+"&ncu="+ncu+"&nlo="+nlo+"");
	$('#Tarjetas').fadeIn(500);
}

function ModEli(tar, ncu, nlo){

	 jConfirm("¿Est\u00e1 seguro que desea eliminar la Tarjeta?", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			$("#archivos").load("TarProcesa.php?ban=2&tar="+tar+"&ncu="+ncu+"&nlo="+nlo+"");
		}
	});	
}

</script>
</head>

<body>

<div id="TarjetasGeneral">

	<div id="TarFondo"><img src="tarjetas/consulta de tarjeta.png"/></div>

	<div id="TarDetalle">
	
	<?

		//PRIMERO BUSCAR LOS DATOS DEL TURNO.
		//conteos cargados
		 
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
	
	
		$_SESSION['ParSQL'] = "SELECT A.TAR,B.NOM,A.NTE,A.NCU,A.NLO,A.IMP  FROM ACUPONES A
							INNER JOIN ATARJETAS B ON A.TAR=B.ID 
							WHERE A.PLA =".$PLA." ORDER BY A.TAR";

		$RSBTABLA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($RSBTABLA);
	
		if(!mssql_num_rows($RSBTABLA) == 0){
			$total = mssql_num_rows($RSBTABLA);
		}
	
		$c = 0;
		$cc = 0;
		$s = 1;
	
		while ($ATU=mssql_fetch_row($RSBTABLA)){	
		
			$tarid=$ATU[0];
			$tarnom=$ATU[1];
			$tarnte=$ATU[2];
			$tarncu=$ATU[3];
			$tarnlo=$ATU[4];
			$tarimp=$ATU[5];
			
			$c = $c + 1;
			$cc = $cc + 1;
			
			if ($c == 1){
			
				if($s == 1){
					$e = "block";
				}else{
					$e = "none";
				}
			
				echo "<div id=\"capa_tar".$s."\" style=\"display:".$e."\">";
				
				if($s <> 1){
					?>
	
					<div id="AnteriorTar" style=" position:absolute; top:298px; left:225px;">
						<button class="StyBoton" onclick="return movpag_a_tar(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Tar','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Tar"/></button>
					</div>
		
					<?
		
				}
		
				}
		
				?>
				<div class="lineare1" id="linea<?=$cc?>" onclick="select_tar(<?=$total?>,<?=$cc?>,<?=$ATU[0]?>,<?=$ATU[3]?>,<?=$ATU[4]?>);">
                <table width="269" height="26" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="67" align="center"><? echo $ATU[3]; ?></td>
                        <td width="134" align="left"><? echo $ATU[1]; ?></td>
                        <!-- <td width="50" align="center"><? echo $ATU[4]; ?></td> -->
                        <td width="69" align="center"><? echo dec($ATU[5],2); ?></td>
                    </tr>
                </table>
				</div>
				<?
	
				if ($c == 10){
		
				?>
		
				<div id="SiguienteTar" style="position:absolute; top:298px;  left:190px;">
					<button class="StyBoton" onclick="return movpag_b_tar(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Tar','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Tar"/></button>
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
		$("#SiguienteTar").fadeOut('fast');
    </script>
	<?
}
	?>
	
	</div>

</div>

	<div id="BotTarSal" style="position:absolute;  top:345px; left:15px;">
		<button  onclick="salir_tar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalirTar','','botones/sal-over.png',0)">
        <img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirTar"></button>
	</div>				

	<div id="Tar_BotAgrM" style="position:absolute; top:345px; left:384px;">
		<button class="StyBoton" onclick="AccBotTar(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotAgrTar','','botones/agr-tar-over.png',0)">
        <img src="botones/agr-tar-up.png" name="Agregar" title="Agregar" border="0" id="BotAgrTar"/></button>
	</div>

	<div id="Tar_Mod" style="position:absolute; top:345px; left:484px;"></div>
    
    <div id="Tar_Eli" style="position:absolute; top:345px; left:584px;"></div>

	<div id="TarDetalleFon" class="OcultarDetalle"><img src="tarjetas/tarjetas.png" /></div>

	<div id="TarDetalleCon" class="OcultarDetalle"></div>

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