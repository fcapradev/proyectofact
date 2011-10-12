<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");



/*
1) BORRAR TMAEFACT 
2) CREAR UN CI TIPO B, PARA INSERTA EN LA AMAEFACT, AMOVFAC, Y AMOSTOCK
*/


$t = $_REQUEST['tip'];
$c = $_REQUEST['tco'];
$s = $_REQUEST['suc'];
$n = $_REQUEST['nco'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalles Ticket Cierre Turno</title>

<style>
.items-tarcon{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}
.det-tarcon{
	font-family: "TPro";
	font-size:11px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}
</style>

<script>
function movpag_a_tiem2(p){
	
	np = p - 1;
	document.getElementById("capa_tidet"+np).style.display="block";
	document.getElementById("capa_tidet"+p).style.display="none";
	
	
return false;
}

function movpag_b_tiem2(p){

	np = p + 1;	
	document.getElementById("capa_tidet"+np).style.display="block";
	document.getElementById("capa_tidet"+p).style.display="none";
	
return false;
}
</script>
<?
///////////////////////////////////////////////////////
//  cuando se le hace click para que muestre el detalle

   //'---------------------------------------------------------------------------------
   //' DATOS DE TIPOS DE COMPROBANTES
   //'---------------------------------------------------------------------------------

	
	$laTco="";
	
	$_SESSION['ParSQL'] = "SELECT NOMBRE FROM TICOMP WHERE ID = '".$c."'"; 
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);		
	while ($R3=mssql_fetch_array($R1TB)){
		$laTco=trim($R3['NOMBRE']);
	}

	$laNUF = format($s,4,'0',STR_PAD_LEFT)."-".format($n,8,'0',STR_PAD_LEFT);


	$_SESSION['ParSQL'] = "SELECT * FROM TMAEFACT WHERE TIP = '".$t."' AND SUC = ".$s." AND TCO = '".$c."' AND NCO = ".$n." AND LUG = ".$_SESSION['ParLUG']."";
	$R1TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R1TB);
	while ($R3=mssql_fetch_array($R1TB)){
	
     	$laFEC = $R3['FEC'];
      	//$laATO = $R3['ATO'];
		$laATO = 0;
		$laNGR = dec($R3['NET'], 2);
		$laIRI = dec($R3['IRI'], 2);
		$laIRS = dec($R3['IRS'], 2);
		$laIMI = dec($R3['IMI'], 2);
		$laIMI2 = dec($R3['IMI2'], 2);
		//$laAPR = dec($R3['APR'], 2);
		$laAPR = 0;
		$laPER = dec($R3['PER'], 2);
		$laTOT = dec($R3['TOT'], 2);
		$laDTO = dec($R3['DTO'], 2);

		///// CARGAR LAS VARIABLES EN LOS CASILLEROS CORRESPONDEINTES.
		$laFPA ="";
		$_SESSION['ParSQL'] = "SELECT Nombre FROM FDPAGO WHERE ID = ".$R3['DTO'];
		$R2TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R2TB);		
		while ($R2=mssql_fetch_array($R2TB)){
			$laFPA = "PAGO: " & trim($R3['Nombre']);
		}

	   //'---------------------------------------------------------------------------------
	   //' DATOS DE CLIENTE
	   //'---------------------------------------------------------------------------------

		$laCLI =" Consumidor Final";
		$laDir = " Sin Direcci&oacute;n";
		$_SESSION['ParSQL'] = "SELECT COD,NOM,DOM,LOC,PCI FROM CLIENTES WHERE COD = ".$R3['CLI'];
		$R2TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($R2TB);		
		while ($R2=mssql_fetch_array($R2TB)){
			 $laCLI = "(".format($R2['COD'],5,'0',STR_PAD_LEFT).")".trim($R2['NOM'])."";
			 $laDir = trim($R2['DOM']).", ".trim($R2['LOC']).", ".trim($R2['PCI'])."";
			
		}

	}
	
   //'---------------------------------------------------------------------------------
   //' DATOS DE DETALLES DE FACTURA
   //'---------------------------------------------------------------------------------
	$_SESSION['ParSQL'] = "SELECT * FROM TMOVFACT WHERE TIP = '".$t."' AND TCO = '".$c."' AND SUC = ".$s." AND NCO = ".$n."";
	$R2TB = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($R2TB);		
	
	$c = 0;
	$cc = 0;
	$s = 1;
	?>
	
	<div class="items-tarcon" id="FacCabecera1" style="position:absolute; top:0px; font-size:17px;">
		<table width="473">
			<tr>
				<td><? echo $laCLI; ?>	</td>
			</tr>
		</table>
	</div>	
	
	<div class="items-tarcon" id="FacCabecera2" style="position:absolute; top:34px; font-size:14px;">
		<table width="473">
			<tr>
				<td><? echo $laDir; ?></td>
			</tr>
		</table>
	</div>
	
	<div class="items-tarcon" id="FacPie1" style="position:absolute; top:250px; font-size:16px;">		
		<table width="473">
			<tr>
				<td width="95" align="center"><? echo $laNGR; ?></td>
				<td width="94" align="center"></td>
				<td width="94" align="center"><? echo $laIRI; ?></td>
				<td width="94" align="center"><? echo $laIRS; ?></td>
				<td width="94" align="center"><? echo $laDTO; ?></td>
			</tr>
		</table>
	</div>
	
	<div class="items-tarcon" id="FacPie2"  style="position:absolute; top:287px; font-size:16px;">
		<table width="473">
			<tr>
				<td width="95" align="center"><? echo $laPER; ?></td>
				<td width="94" align="center"><? echo $laIMI; ?></td>
				<td width="94" align="center"><? echo $laIMI2; ?></td>
				<td width="94" align="center"><? echo $laAPR; ?></td>
				<td width="94" align="center"><? echo $laTOT; ?></td>
			</tr>
		</table>
	</div>
	
	<div class="det-tarcon" id="FacDetalless" style="position:absolute; top:87px;">
	<?		
	while ($R2=mssql_fetch_array($R2TB)){
		 
		$laCOD = format($R2['SEC'],2,'0',STR_PAD_LEFT)."-".format($R2['ART'],4,'0',STR_PAD_LEFT);
		$LAdet = $R2['DES'];
		$laUNI = dec($R2['PUN'], 2);
		$laIMP = dec($R2['PUN'] * $R2['CAN'],2);
		$laCAN = $R2['CAN'];
	
		$c = $c + 1;
		$cc = $cc + 1;
	
		
		if ($c == 1){
		
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
		
			echo "<div id=\"capa_tidet".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
			
				?>
				<div id="AnteriorDet2" style=" position:absolute; top:232px; left:435px;">
					<button class="StyBoton" onclick="return movpag_a_tiem2(<? echo $s; ?>);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AnteriorDet_Ti2','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="AnteriorDet_Ti2"/></button>
				</div>
				<?
			}
		}
		?>
		<div id="lineadp<? echo $cc; ?>" style="width:473px; font-size:13px;"">
		<table cellpadding="1" cellspacing="1">
			<tr>
				<td width="66" align="center"><? echo $laCOD; ?></td>
				<td width="32" align="center"><? echo $laCAN; ?></td>
				<td width="205" align="left"><? echo substr($LAdet,0,28); ?></td>
				<td width="76" align="right"><? echo $laUNI; ?></td>
				<td width="84" align="right"><? echo $laIMP; ?></td>			
			</tr>
		</table>
		</div>			
		<?		
	
		if ($c == 7){
	
		?>

			<div id="SiguienteDet2" style="position:absolute; top:232px;  left:400px;">
        			<button class="StyBoton" onclick="return movpag_b_tiem2(<? echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('SiguienteDet_Ti2','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="SiguienteDet_Ti2"/></button>
			</div>
			
		</div>
		
		<?php
		  
		$c = 0;
		$s = $s + 1;
		
		}
		
}
if ($cc == 7){
	?>
	<script>
		SoloNone("SiguienteDet2");
//		$("#SiguienteDet2").fadeOut('fast');
    </script>
	<?
}
?>
</div>









</body>
</html>
<?
mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debor Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>