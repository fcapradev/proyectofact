<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

set_time_limit(5000);



if(isset($_POST['sector'])){
	$teNomSec = $_POST['sector'];
	$sec = $_POST['sectorid'];
	$teNomRum = $_POST['rubrom'];
	$rum = $_POST['rubromid'];
	$nomrub = $_POST['rubro'];
	$numrub = $_POST['rubroid'];
	$detinv = $_POST['detsec'];
	$LugarInv = $_POST['tiposel'];
	$numinv = $_POST['numinv'];
	$txt = 1;
	@$orden = $_POST['ordenlista'];
	$fecinv = date("Y-m-d H:i:s");
	$opeinv = $_POST['opeinventario'];
	$TER = $_SESSION['ParPOS'];
	$col = $_POST['colector'];
}

//// ACTUALIZA LAS TABLAS ANTES DE MOSTRAR LA LISTA
//	
//
//
//
//
//
//
//
//
//
//
//
//
//

function ActualizaExiTomInv($s,$rm,$rb){

	$cRum = "";
	if ($rm > 0 and $rm < 999){
		$cRum = " AND RUBMAY = ".$rm;
	}
 	$ccod="";
	if ($rb > 0 and $rb < 999){
		$ccod = " AND CODRUB = ".$rb;
	}
	
	$_SESSION['ParSQL'] = "SELECT DEPSN,CODSEC,CODART FROM ARTICULOS WHERE CODSEC = ".$s.$ccod.$cRum;
	$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($ARTICULOS);		
	while ($RART=mssql_fetch_array($ARTICULOS)){
		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		
		if ($RART['DEPSN'] == true){

			$_SESSION['ParSQL'] = "
			SELECT ISNULL(SUM(CAN),0) AS VTA 
			FROM AMOVSTOC WHERE CYV = 'V' AND NOT TCO IN ('NC','NI')  AND TIM IN (
			'Ve','DV','OD','DX','DR','DQ','DO','Aj','Ax','DV') AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 1 AND ANU <> 'A'";
			
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta=$RAMOV['VTA'];
			}
			mssql_free_result($AMOVSTOC);
		

			$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C' AND TCO IN ('NC','NI') AND TIM IN ('Co') 
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO =1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nVta= $nVta + $RAMOV['COM'];
			}			
			mssql_free_result($AMOVSTOC);
			

			$_SESSION['ParSQL'] = "SELECT  ISNULL(SUM(CAN),0) AS COM 
					FROM AMOVSTOC WHERE CYV = 'C' AND TIM IN ('Co','Aj','Ax','DV','VD','OD','DO','DX','DR') 
					AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND NOT TCO IN ('NC','NI') AND DTO =1 AND ANU <> 'A'";
			$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($AMOVSTOC);		
			while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
				$nCom= $nCom + $RAMOV['COM'];
			}
			mssql_free_result($AMOVSTOC);

			$nAju = $nCom - $nVta;
			
			$_SESSION['ParSQL'] = "UPDATE ARTICULOS 
				SET EXIDEP = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
			$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($UARTICULOS);			
		}
		
////////// VENTAS SIEMPRE HACE ESTO

		$nVta = 0;
      	$nCom = 0;
      	$nAju = 0;
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0) AS VTA FROM AMOVSTOC WHERE TCO NOT IN ('NC','NI')  
				AND CYV = 'V' AND TIM IN ('Ve','VX','VV','VR','VQ','OV','VD','VO','Aj','Ax','DV','DO','AC') 
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta=$RAMOV['VTA'];
		}
		mssql_free_result($AMOVSTOC);
		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE TCO IN ('NC','NI')  AND CYV = 'V' AND TIM IN('Ve','VX','VV','VR','VQ','OV','VD','VO')
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);		

		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS VTA 
				FROM AMOVSTOC WHERE CYV = 'C' AND TCO IN ('NC','NI')  AND TIM IN ('Co')  
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nVta=$nVta + $RAMOV['VTA'];
		}			
		mssql_free_result($AMOVSTOC);
		
		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE  CYV = 'C' AND TCO IN ('NA') AND TIM IN ('VV')  
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$nCom + $RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);


		$_SESSION['ParSQL'] = "SELECT ISNULL(SUM(CAN),0)  AS COM 
				FROM AMOVSTOC WHERE  CYV = 'C' AND TIM IN ('Co','Aj','Ax','DV','VD','OV')  AND NOT TCO IN ( 'NC','NI')
				AND SEC = ".$RART['CODSEC']." AND ART = ".$RART['CODART']." AND DTO = 0 AND ANU <> 'A'";
		$AMOVSTOC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($AMOVSTOC);		
		while ($RAMOV=mssql_fetch_array($AMOVSTOC)){
			$nCom=$nCom + $RAMOV['COM'];
		}
		mssql_free_result($AMOVSTOC);		

		$nAju = $nCom - $nVta;
		
		$_SESSION['ParSQL'] = "UPDATE ARTICULOS SET EXIVTA = ".str_replace(",",".",$nAju)." WHERE CodSec = ".$RART['CODSEC']." AND CodArt = ".$RART['CODART']."";
		$UARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
		rollback($UARTICULOS);		
	}
	mssql_free_result($ARTICULOS);
	
	
	//	VARIABLE PARA NO ACTUALIZAR TANTO (DEMORA MUCHO)
	$_SESSION["ActLis"] = 3;
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
	top:0px;
	left:0px;
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
	background-image:url(InventarioToma/fonselgri.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:24px;
	width:585px;
}

.lineaTomLis:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

.lineaTomSel{
	background-image:url(InventarioToma/fonselnar.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:24px;
	width:585px;
}

.lineaTomSel:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

</style>

<script>
document.getElementById('archivos').style.display = "block";

SoloBlock("descpidelista, fondopidelista, fondolista");
SoloBlock("ordenalista, rubrotodos1, rubrostodos, GrabarInv, GrabarInven, Cancelar");

$(document).ready(function(){
	$('#formgravar').submit(function(){
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


////////////////   ENVIA FORMULARIO PARA GRABAR EN LAS TABLAS    /////////////////
function envialista(a){

	if(a == 1){

		genera_pdf();
		
	}else{
		
		var cant = document.getElementById('cant').value;
		var t = 0;
		for(i=1; i<=cant; i++){
			var x = "fila" + i;
			if (document.getElementById(x).checked) {
				t = t+1;
			}
		}
		if(t >= 1){
			
			//jAlert('Este proceso puede tomar varios minutos.', 'Debo Retail - Global Business Solution');
			
	//		$('#Esperar').fadeIn(500);
			
			SoloNone('ordenalista, detalletipos, fondolista, fondopidelista, descpidelista, GrabarInv, rubromnum, rubromalf, Cancelar, CarAyudaFon, CarAyuda');
	
			//document.getElementById('ImprimirInv').style.display = "block";
			document.getElementById('Grava').value = 1;
			document.getElementById('muchos').value = 0;
			document.getElementById("DondeE").value = "";
	
			document.getElementById('rubrostodos').checked = false;
			document.getElementById('rubrostodos').disabled = true;
			
			$('#formgravar').submit();
			$('#Bloquear').fadeIn(500);

//			$('#Bloquear').fadeOut(500);	
//			genera_pdf();
	
///////////////		MUESTRO BOTON PARA IMPRIMIR		/////////////////
	
			document.getElementById('LetEnt').innerHTML = '<button onclick="genera_pdf();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInvImpPDF\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="LetEntTomInvImpPDF"/></button>';
				
			SoloBlock("LetEnt, DivImp");
			
			EnvAyuda("Presione Imprimir para visualizar Inventario.");
			
			return false;
	

	
		}else{
			jAlert('No se ha seleccionado ning&uacute;n art&iacute;culo.', 'Debo Retail - Global Business Solution');
		}
		
	}

}

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

function envia_tip(id,des){
	document.getElementById("fondopidelista").style.display = "none";
	document.getElementById("descpidelista").style.display = "none";
	document.getElementById("fondolista").style.display = "none";
}

//	FUNCION PARA SELECCIONAR TODOS LOS ITEMS
function seltodos(a){

	var t = document.getElementById("cantidad").value;

	SoloBlock("Bloquear");

	if(a == 1){

		SoloNone("todartOff");
		SoloBlock("todartOn");	
		
		for (i=1; i<=t; i++){
		
			$("#linea"+i).removeClass("lineaTomLis").addClass("lineaTomSel");//NARANJA
			document.getElementById("fila" + i).checked = 1;
			
		}
	
	}else{
		
		SoloNone("todartOn");
		SoloBlock("todartOff");		
		
		for (i=1; i<=t; i++){
		
			$("#linea"+i).removeClass("lineaTomSel").addClass("lineaTomLis");//NEGRO
			document.getElementById("fila" + i).checked = 0;
			
		}
	}

	SoloNone("Bloquear");
}


function selart(t,mp){

//**	ACTIVA O DESACTIVA EL BOTON SELECCIONA TODOS LOS ART	**//
	var c = 0;

	for (i=1; i<=t; i++){
		
		var x = "fila" + i;	

		if(document.getElementById(x).checked == true){
			
			c = c + parseInt(1);
		}
		
		if( c == (t-parseInt(1))){
			SoloBlock("todartOn");
			SoloNone("todartOff");
		}else{
			SoloBlock("todartOff");
			SoloNone("todartOn");	
		}
	}
	
	for (i=1; i<=t; i++){
	
		var x = "fila" + i;	
		
		var it = document.getElementById(x).checked;

		if(i == mp){

			if(document.getElementById(x).checked == true){

				$("#linea"+i).removeClass("lineaTomSel").addClass("lineaTomLis");//NEGRO
				document.getElementById(x).checked = false;

			}else{

				$("#linea"+mp).removeClass("lineaTomLis").addClass("lineaTomSel");//NARANJA
				document.getElementById(x).checked = true;

			}
		}
	}
}

function enviaform(){
	return false;	
}


</script>

</head>
<body >

<!-- BOTON PARA GRABAR -->
<div id="GrabarInven" style="position:absolute; top:149px; left:547px; display:block; z-index:3;">
	<button  class="StyBoton" onClick="return envialista(2);" onMouseOut="MM_swapImgRestore()" onmouseover=	"MM_swapImage('BotGraInvLis','','botones/gra-over.png',0)"><img src="botones/gra-up.png" name="Grabar" title="Grabar" border="0" id="BotGraInvLis" /></button>
</div>


<form method="post" name="formgravar" id="formgravar" action="TomInvGra.php" onsubmit="enviaform();">

<div id="friendslist">

<!-- ENVIO TODAS LAS VARIABLES A GRABAR -->
<input type="hidden" name="sector" id="sector" value="<? echo $teNomSec;?>"  />
<input type="hidden" name="sectorid" id="sectorid" value="<? echo $sec;?>"  />
<input type="hidden" name="rubrom" id="rubrom" value="<? echo $teNomRum;?>"  />
<input type="hidden" name="rubromid" id="rubromid" value="<? echo $rum;?>"  />
<input type="hidden" name="rubro" id="rubro" value="<? echo $nomrub;?>"  />
<input type="hidden" name="rubroid" id="rubroid" value="<? echo $numrub;?>"  />
<input type="hidden" name="detsec" id="detsec" value="<? echo $detinv;?>"  />
<input type="hidden" name="tiposel" id="tiposel" value="<? echo $LugarInv;?>"  />
<input type="hidden" name="numinv" id="numinv" value="<? echo $numinv;?>"  />
<input type="hidden" name="opeinventario" id="opeinventario" value="<? echo $opeinv;?>"  />
<input type="hidden" name="muchos" id="muchos" value="1"/>
<input type="hidden" name="bot2" id="bot2"/>
<input type="hidden" name="Grava" id="Grava" />
<input type="hidden" name="colector2" id="colector2" value="<? echo $col;?>"/>

<div id="detalletipos">

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

// INVENTARIO AL AZAR O POR SELECCION DE RUBRO MAYOR Y RUBRO   =1 al azar     =2 por rubro y rm
$tipoInv=1;

// opcoin de si muestra o no stock actual
$swMueStock=false;


/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
//  SE QUITA LA ACTUALIZACION PORQUE CONSUME MUCHOS RECURSO, CREAR UN TRILLER  //
//  AL ABRIR TURNO QUE REALICE LA ACT DE LOS ARTICULOS						   //
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////

/*
if($orden == ""){

	if($_SESSION["ActLis"] == "1"){ 

		ActualizaExiTomInv($sec,$rum,$numrub);

	}
}
*/

$cNHA = " and NHA = 0 ";
$cDEP = "";
$cRum = "";
$cRub = "";

$cSec = "";
if ($sec <> "T") {
	$cSec = " AND A.CODSEC=".$sec ;
} 
if ($rum <> 0){
  $cRum = " AND A.RUBMAY = ".$rum."";
}
if ($numrub <> 0){
  $cRub = " AND A.CODRUB = ".$numrub."" ;
}
$cDEP = " ";
if ($LugarInv == 0) {
  $cDEP = " AND A.DEPSN = 1 ";
}

if ($orden == 1) {

	//	ORDENA EN FORMA ALFABETICA
	$_SESSION['ParSQL'] = "SELECT A.CODSEC,A.CODART,A.CODRUB,A.DETART,
			ISNULL((SELECT TOP 1 PRECIO_".$iLista." FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS PREVEN, 
			EXIVTA,EXIDEP,ISNULL((SELECT TOP 1 COSTO FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS COSTO,
			DEPSN FROM ARTICULOS A WHERE  A.TIP NOT IN ('L','G','A') and 
			A.DETART <> '�NO�DISPONIBLE' ".$cSec." ".$cRum." ".$cRub." ".$cDEP." ".$cNHA." ORDER BY A.DETART";			
}else{

	//	ORDENA EN FORMA NUMERICA
	$_SESSION['ParSQL'] = "SELECT A.CODSEC,A.CODART,A.CODRUB,A.DETART,
			ISNULL((SELECT TOP 1 PRECIO_".$iLista." FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS PREVEN, 
			EXIVTA,EXIDEP,ISNULL((SELECT TOP 1 COSTO FROM PLANILLA_COSTO WHERE A.CODSEC=SEC AND A.CODART=COD ),0) AS COSTO,
			DEPSN FROM ARTICULOS A WHERE  A.TIP NOT IN ('L','G','A') and 
			A.DETART <> '�NO�DISPONIBLE' ".$cSec." ".$cRum." ".$cRub." ".$cDEP." ".$cNHA." ORDER BY A.CODSEC,A.CODART";		
}

$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ARTICULOS);
if(mssql_num_rows($ARTICULOS)<>0){
	
	$total = mssql_num_rows($ARTICULOS);

	$c = 0;
	$cc = 0;
	$s = 1;

	?>
	<script>
		$('#Bloquear').fadeOut(500);
		$('#rubmay input[type="radio"]' ).removeAttr( "disabled" );
	</script>
	<?

	while ($RART=mssql_fetch_array($ARTICULOS)){
		$COL00 = $RART['CODART'];
		$COL0=format($RART['CODSEC'],2,'0',STR_PAD_LEFT)."-".format($RART['CODART'],4,'0',STR_PAD_LEFT);
		$COL1=$RART['CODRUB'];
		$COL2="NO";
		if ($RART['DEPSN']== true){
			$COL2="SI";
		}
		$COL3=$RART['DETART'];
		$COL4=dec($RART['PREVEN'],2);
		if($LugarInv==1){
			$COL5=dec($RART['EXIVTA'],2);
		}else{
			$COL5=dec($RART['EXIDEP'],2);
		}
		
		$c = $c + 1;
		$cc = $cc + 1;
		$t = 0;
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
		echo "<div id=\"capa_invlis".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>

				<div id="Anterior_Lista" style=" position:absolute; top:-20px; left:584px;">
					<button class="StyBoton" onClick="return movpag_a_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Lista<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Lista<?php echo $s; ?>"/></button>
				</div>
				<?
			}
		}
		?>

		<div class="lineaTomLis" id="linea<? echo $cc; ?>" style="cursor:pointer;">
			<table width="584" height="26" border="0" cellpadding="0" cellspacing="0"  onclick="selart(<? echo $total; ?>,<? echo $cc; ?>);">
				<tr>
					<td  width="63" align="center"><? echo $COL0; ?></td>
					<td  width="47" align="center"><? echo $COL1; ?></td>
					<td  width="33" align="center"><? echo $COL2; ?></td>
					<td  width="295" align="left">&nbsp;&nbsp;&nbsp;<? echo $COL3; ?></td>
					<td  width="73" align="center"><? echo $COL4; ?></td>
					<td  width="73" align="center"><? echo $COL5; ?></td>
					<div style="display:none; position:absolute; left:0px;">
	                	<input type="checkbox" name="item[]" id="fila<? echo $cc; ?>" value="<? echo $COL00; ?>">
                        <input type="hidden" name="cantidad" id="cantidad" value="<? echo $total; ?>" >
                    </div>
				</tr>
			</table>
	    </div>
		<?
		$t = $c;
		if ($c == 6){
		?>
			<div id="Siguiente_Lista<?php echo $s; ?>" style="position:absolute; top:100px;  left:584px;">
				<button class="StyBoton" onClick="return movpag_b_invlis(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Lista<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Lista<?php echo $s; ?>"/></button>
			</div>
        </div>

		<?php
		$c = 0;
        $s = $s + 1;  
	}
}

if ($t == 6){

	?>
	<script>
		SoloNone("Siguiente_Lista<?php echo $s-1; ?>");
    </script>
	<?
}

}else{
	?>
	<input type="hidden" name="cant" id="cant" value="0"  />
    <div id="fondorub2" style="position:absolute; width:665px; height:210px; z-index:1; display:none;"></div>

    <div id="fondopiderub2" style="position:absolute; top:-28px; left:165px; display:none; z-index:2;">
        <img src="InventarioToma/rubrosFC.png"/>
    </div>

    <div id="descpiderub2" style="position:absolute; top:423px; left:90px; display:none; z-index:2;"></div>

<script>
	//$("#rubro").attr('onclick','false');	//deshabilita llamada a funci�n con click->solo llama a rubro con enter
    $('#Bloquear').fadeOut(500);

	jAlert('No Hay Datos para la Selección Actual.', 'Debo Retail - Global Business Solution');

	var a = document.getElementById("sacaletter").value;

	if(a == 0){
		SoloNone("LetTer");
	}else{
		SoloBlock("LetTer");
	}

	SoloNone("BotSelTodRubOn");
	SoloBlock("BotSelTodRubOff");

    SoloBlock('LetEnt, NumVol');
    SoloNone('fondopidelista, ordenalista, fondolista, GrabarInv, GrabarInven, Cancelar');

	document.getElementById("rubroid").value = "";
	document.getElementById("rubro").value = "< RUBROS >";

	document.getElementById("DondeE").value = "rubroid";
	document.getElementById("CantiE").value = "3";
	document.getElementById("QuePoE").value = "1";
	
	$("#rub").css("border-color", "#F90");
	
	EnvAyuda("Ingrese un Rubro o Presione Enter para listar");
	
	document.getElementById('LetEnt').innerHTML = '<button onclick="siguiente_tominv3();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntTomInv5\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntTomInv5"/></button>';
	
	document.getElementById('NumVol').innerHTML = '<button onclick="volver_tominv2();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolTomInv2\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolTomInv2"/></button>';

</script>    

<?
exit;
}
?>

</div>
<input type="hidden" name="cant" id="cant" value="<? echo $cc; ?>"  />

</div>

</form>



<script>
	$('#Bloquear').fadeOut(500);
</script>

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