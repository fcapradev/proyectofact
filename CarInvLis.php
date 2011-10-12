<?
require("config/cnx.php");
try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //
mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$orden = 1;
if(isset($_POST['inv'])){
	$num_inv = $_POST['inv'];
	@$orden = $_POST['ordsel'];
}else{
	$num_inv = $_REQUEST['i'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de Toma de Inventario</title>
<style>
#detalletipos{
	position:absolute;
	top:-76px;
	left:-8px;
	z-index:3;
	font-size:12px;
	color:#FFF;
	display:block;
}

.fon_lista{ 
	background-image:url(InventarioToma/fon-item-suc.png); 
	height:19px; 
	font-family: "TPro";
	width:229px;
}
.lineaTomLis{
	background-image:url(InventarioCarga/fondo_linea.png);
	font-family: "TPro";
	font-weight:100;
	height:16px;
	width:544px;
	margin-top:2px;
}

#datos {
	background-color:#D07417;
	border:0; 
	height:16px;
	font-family: "TPro";
	position:absolute;
	text-align:center;
}

</style>
<script>
$(document).ready(function(){
	$('#formcargra').submit(function(){
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
	$('#pdfres').submit(function(){
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
	$('#pdfdet1').submit(function(){
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
	$('#pdfdet2').submit(function(){
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

//document.getElementById('archivos').style.display = "block";
function movpag_a_invlis(p){
	np = p - 1;
	document.getElementById("capa_invlis"+np).style.display="block";
	document.getElementById("capa_invlis"+p).style.display="none";
	return false;
}

function movpag_b_invlis(p){
	np = p + 1;	
	document.getElementById("capa_invlis"+np).style.display="block";
	document.getElementById("capa_invlis"+p).style.display="none";
	return false;
}
</script>

</head>
<body>
<!-- FORMULARIOS PARA CREAR LA IMPRESION Y LOS PDF´S -->
<form action="CarInvPdfRes.php" method="post" name="pdfres" id="pdfres">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />	
</form>
<form action="CarInvPdfDet1.php" method="post" name="pdfdet1" id="pdfdet1">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />
    <input type="hidden" name="impsel" id="impsel" value="0" />
    <input type="hidden" name="valsel" id="valsel" value="0" />
</form>
<form action="CarInvPdfDet2.php" method="post" name="pdfdet2" id="pdfdet2">
	<input type="hidden" name="var" id="var" value="<? echo $num_inv; ?>" />
    <input type="hidden" name="impsel" id="impsel" value="0" />
    <input type="hidden" name="valsel" id="valsel" value="0" />
</form>



<form method="post" name="formcargra" id="formcargra" action="CarInvGra.php">
	<input type="hidden" name="gracol" id="gracol" value="0" />
<div id="detalletipos">
<?
	$_SESSION['ParSQL'] = "SELECT * FROM ITOMINVC WHERE ID = ".$num_inv."";
	$ITOMINVC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ITOMINVC);
if(mssql_num_rows($ITOMINVC) == 0){
?>
	<script>
		jAlert("El Inventario ingresado no existe.", "Debo Retail - Global Business Solution");
		$("#CargaInv").load("CargaInv.php");
		SoloNone("BotonesPri");
		SoloBlock("CargaInv");
		SoloNone('Marca');
		SoloBlock('fondotranspletras');
		SoloBlock('TecladoLet');
		SoloBlock('fondotranspnumeros');
		SoloBlock('TecladoNum');
		SoloBlock('LetEnt');
		SoloNone('LetTer');
		SoloNone('NumVol');
		SoloNone('SobreFoca');
		
		EnvAyuda("Ingrese el Inventario que desea cargar o importar desde Palm");
		
		document.getElementById("DondeE").value = "inv";
		document.getElementById("CantiE").value = "6";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_carga();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalTomInv\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalTomInv"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
		document.getElementById('LetTer').innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetImpCarInv\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Terminar" title="Terminar" border="0" id="LetImpCarInv"/></button>';
	</script>
	<?
}else{
	$_SESSION['ParSQL'] = "SELECT * FROM INV_PALM_REA WHERE NUM_INV = ".$num_inv."";
	$INV_PALM_REA = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($INV_PALM_REA);
	if(mssql_num_rows($INV_PALM_REA) >= 1){
		?>
		<script>
			$("#archivos").load("CarInvLisCD.php?i="+<? echo $num_inv; ?>+"");
			SoloNone("invent, notomado_car, orden, cancelar");
			EnvAyuda("Presione Grabar para cargar el Inventario.");
		</script>
		<?
		exit;
	}else{
		while ($RINV=mssql_fetch_array($ITOMINVC)){
			$est = $RINV['EST'];
			$num_inv = $RINV['ID'];
			$det = $RINV['DET'];
			$fecha = $RINV['FET'];
			@$fecha_tom = $RINV['FEC'];
		
			$date2 = new DateTime($fecha_tom);
			$fecha_tom = $date2->format('d-m-Y');
			
			$date1 = new DateTime($fecha);
			$fecha = $date1->format('d-m-Y');
	
			if ($est == "A"){
				$estado = "Anulado";
			}elseif ($est == "F"){
				$estado = "Fallado";
			}else{
				$estado = "Disponible";
			}
			$ope_gen = $RINV['OPE'];
			$tipo = $RINV['DEP'];
	
			if($tipo == 1){
				$tipo = "DEPOSITO";
			}else{
				$tipo = "VENTAS";
			}

			
		
			if ($est == "C"){
			?>		
			<script>
				SoloBlock('descpidetitulo');
				SoloNone("LetEnt, notomado_car, importar_car, cancelar");
				
				createCookie('jAlertT','17000',1);
				
				jAlert("La Toma de Inv. <? echo $num_inv; echo " - ".$tipo;?> fue cargada por el operario <? echo "'".$ope_gen."' ";?> el d&iacute;a <? echo $fecha_tom; ?>.", "Debo Retail - Global Business Solution");
				
				SoloBlock("LetTer, descpidelista, cancelar");
				
				document.getElementById("orden").style.display = "none";
				
				document.getElementById("DondeE").value = "LetTex";
				document.getElementById("CantiE").value = "0";
				document.getElementById("QuePoE").value = "0";
				
				document.getElementById("impresion").style.display = "block";
				
				EnvAyuda("Seleccione el tipo de Impresi&oacute;n y presione Imprimir");
				
			</script>
			<?

			$swRI = true;

			}else{

			?>
            <script>
				SoloBlock("notomado_car, cancelar");

				document.getElementById('fondolista').style.display = "block";
				document.getElementById('descpidelista').style.display = "block";
				document.getElementById('descpidetitulo').style.display = "block";
				document.getElementById('orden').style.display = "block";
				document.getElementById('importar_car').style.display = "none";
				
				SoloNone("LetTer");
				
				document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntTomInv" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetEntTomInv\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="BotLetEntTomInv"/></button>';
				
				document.getElementById('NumVol').innerHTML = '<button id="BotLetVolTomInv" onclick="anterior_1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotLetVolTomInv\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Enter" title="Enter" border="0" id="BotLetVolTomInv"/></button>';
				
				document.getElementById("DondeE").value = "items1";
				document.getElementById("CantiE").value = "3";
				document.getElementById("QuePoE").value = "6";
				
				$("#lin0").css("border-color", "#F90");
				$("#invent").css("border-color", "transparent");
				
				EnvAyuda("Ingrese la Cantidad contada de cada art&iacute;culo.");
            </script>
		<? }
		}
	}
$swRI = false;
?>
 	<div id="detalle" class="fon-car2" style="position:absolute; top:-47px; left:150px; width:180px; display:block;" align="center"><? echo $det; ?></div>
	
	<div id="fecha" class="fon-car1" style="position:absolute; top:-45px; left:332px; width:78px; display:block;" align="center"><? echo $fecha; ?></div>
	
	<div id="tipo" class="fon-car" style="position:absolute; top:-47px; left:410px; width:63px; display:block;" align="center"><? echo $tipo; ?></div>
	
	<div id="opegen" class="fon-car" style="position:absolute; top:-47px; left:480px; width:63px; display:block;" align="center"><? echo $ope_gen; ?></div>


<?php

// CUANDO SE PRESIONA ENTER Y COMIENZA A CARGAR LA GRILLA
$_SESSION['ParSQL'] = "SELECT LIST_DEFECTO FROM APAREMP";
$APAREMP = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($APAREMP);	
if(mssql_num_rows($APAREMP)==0){
	?>
	<script>
		jAlert('No se ha seleccionado ninguna lista para la empresa.', 'Debo Retail - Global Business Solution');
		salir_tom();
	</script>
	<?	
}
					
while ($REMP=mssql_fetch_array($APAREMP)){
	$iLista=$REMP['LIST_DEFECTO'];
}

if($iLista==0){
	?>
	<script>
		jAlert('No se ha seleccionado ninguna lista para la empresa.', 'Debo Retail - Global Business Solution');
		salir_tom();
	</script>
	<?	
}

$opeinv = $_SESSION['idsusua'];

if($orden == 1){
	$_SESSION['ParSQL'] = "SELECT SEC, ART, RUB, DET,DIF,CON, CAR, REA FROM ITOMINVD WHERE INV = ".$num_inv." ORDER BY INV,SEC,ART";
}else{
	$_SESSION['ParSQL'] = "SELECT SEC, ART, RUB, DET,DIF,CON, CAR, REA FROM ITOMINVD WHERE INV = ".$num_inv." ORDER BY INV,DET";
}

$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ARTICULOS);
if(mssql_num_rows($ARTICULOS)<>0){
	$total = mssql_num_rows($ARTICULOS);
	
	$c = 0;
	$cc = 0;
	$s = 1;
	$n = 0;

	while ($RART=mssql_fetch_array($ARTICULOS)){
		$DET = $RART['DET'];
		$COD=format($RART['SEC'],2,'0',STR_PAD_LEFT)."-".format($RART['ART'],4,'0',STR_PAD_LEFT);
		$RUB=format($RART['RUB'],2,'0',STR_PAD_LEFT);
		$ART=$RART['ART'];
		$DIF=$RART['DIF'];
		$CON=$RART['CON'];
		$CAR=$RART['CAR'];
		$REA=$RART['REA'];
		
		$c = $c + 1;
		$cc = $cc + 1;
		$n = $n + 1;
		
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
		echo "<div id=\"capa_invlis".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="Anterior_Lista" style=" position:absolute; top:-20px; left:580px;">
					<button class="StyBoton" onClick="return movpag_a_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Lista<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Lista<?php echo $s; ?>"/></button>
				</div>
				<?
			}
		}
		?>

		<div class="lineaTomLis" id="linea<? echo $cc; ?>">
			<table height="16" border="0" cellpadding="0" cellspacing="0" >
				<tr>
					<td width="72" align="center" >
                    	<input style="background-color:#D07417; width:61px; height:12px; font-family: 'TPro'; size:auto; border:0px; text-align:center;	" type="text" readonly="readonly" value="<? echo $COD; ?>"/>
                    </td>
                    
                    <td  width="72" class="datos" align="center">
                    	<input style="background-color:#D07417; width:50px; height:12px; font-family: 'TPro'; border:0px; text-align:center;	" type="text" name="rubro" id="rubro" readonly="readonly" value="<? echo $RUB; ?>" />
                    </td>
                    
                    <td  width="263" align="center">
                    	<input style="background-color:#D07417; width:239px; height:12px; left:10px; font-family: 'TPro'; border:0px; text-align:center;" type="text" name="detalle" id="detalle" readonly="readonly" value="<? echo $DET; ?>"/>
                    </td>
                    
    <td  width="135" align="center">
    <?
	
//  if($DIF == 0.00 && $CON == 0.00 && $est == "T" ){
    if($est == "T" ){	
		
    ?>
    <div id="lin<? echo $n-1; ?>" class="div-redondo" style="position:relative; left:2px; width:133px; top:-1px;">
        <input type="text" name="valores[<? echo $RART['ART'];?>]" id="items<? echo $n; ?>" autocomplete="off" style="width:125px; top:-2px; left:0px; position:absolute; height:14px; text-align:center; font-size:12px; font-family: 'TPro'; background-color:transparent; border:0px;" readonly="readonly"/>
    </div>
    <?
    }else{
        if($est == "C" && $DIF == 0 && $CON == 0 && $CAR == 0 && $REA == 0){
    ?>
        <input type="text" name="valores[<? echo $RART['ART'];?>]" id="items<? echo $n; ?>" autocomplete="off" style="width:125px; height:14px; font-family: 'TPro'; font-size:12px; border:0px; text-align:center; left:20px; background-color:#F3F3F3;" readonly="readonly" value="NO TOMADO"/>
    <?
        }else{
    ?>
        <input type="text" name="valores[<? echo $RART['ART'];?>]" id="items<? echo $n; ?>" autocomplete="off" style="width:125px; height:14px; font-family: 'TPro'; font-size:12px; border:0px; text-align:center; left:20px; background-color:#F3F3F3;" readonly="readonly" value="<? echo $CON; ?>"/>
    <?
        }
    }
    ?>
        <input type="hidden" name="codi" id="codi" value="<? echo $RART['ART']; ?>" />
        <input type="hidden" name="n" id="n" value="<? echo $n; ?>" />
        <input type="hidden" name="t" id="t" value="<? echo $total; ?>" />
        <input type="hidden" name="nume" id="nume" value="<? echo $num_inv; ?>" />
        <input type="hidden" name="tipo" id="tipo" value="<? echo $tipo; ?>" />
    </td>
				</tr>
			</table>
	    </div>
		<?
		if ($c == 11){
		?>
			<div id="Siguiente_Lista" style="position:absolute; top:163px;  left:580px;">
				<button class="StyBoton" onClick="return  movpag_b_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Lista<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Lista<?php echo $s; ?>"/></button>
			</div>
        </div>

<?
		$c = 0; 
        $s = $s + 1;  
	}
}

if ($cc == 11){
	?>
	<script>
		$("#Siguiente_Lista").fadeOut('fast');
    </script>
	<?
}

}else{
	?>
	<script>
		jAlert('El Inventario no posee items.', 'Debo Retail - Global Business Solution');
		
		document.getElementById("inv").value = "";
		document.getElementById("DondeE").value = "inv";

		SoloNone("notomado_car, cancelar");
		
		document.getElementById('LetEnt').innerHTML = '<button onclick="busca_num_inv();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInve\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInve"/></button>';
		
		$("#CargaInv").load("CargaInv.php");
		$('#Bloquear').fadeOut(500);
	</script>    
	<?
	exit;
}
}
?>

</div>


</form>


</body>
</html>
<?
mssql_query("commit transaction") or die("Error SQL commit");

}catch(Exception $e){/////////////////////////////////////////////////// FIN DE TRY //
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}

?>