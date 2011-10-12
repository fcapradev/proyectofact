<?
require("config/cnx.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Armar Arqueo</title>
<script type="text/javascript" language="javascript" src="ArqueoCaja/ArqueoScript.js"></script>

<style>
.fon-mon{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#F6F6F7;
	height:16px;
	text-align:right;
}
.fon-arq{
	font-family: "TPro";
	font-size:11px;
	position:absolute;
	color:#FFFFFF;
	height:16px;
}
.fon-arq1{
	font-family: "TPro";
	font-size:11px;
	position:absolute;
	color:#000000;
	text-align:center;
	height:16px;
}

.fon-arq2{
	font-family: "TPro";
	font-size:11px;
	position:absolute;
	color:#000000;
	text-align:right;
	height:16px;
}

#arqueocaja2{
	position:absolute;
	left:210px;
	z-index:3;
}

#NumVolPADiv { 
	left: 544px; 
	top: 441px; 
	width: 80px; 
	height: 35px; 
}

</style>

<script>

$(document).ready(function(){
	$('#formarqueo2').submit(function(){
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

SoloBlock("LetSal");

$("#supnum").css("border-color", "#F90");

controlarcadainput('sup');

document.getElementById("DondeE").value = "sup";
document.getElementById("CantiE").value = "4";
document.getElementById("QuePoE").value = "1";

EnvAyuda("Ingrese un n&uacute;mero de Supervisor o Enter para Listar.");

document.getElementById('NumVolPADiv').innerHTML = '<button onclick="siguiente_arq1();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntArqSup\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntArqSup"/></button>';


</script>
</head>

<body>


<div id="arqueocaja2">
	<div id="fondoaqueo" style="position:absolute;">
		<img src="ArqueoCaja/arqueodecaja.png" />
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


$_SESSION['ParSQL'] = "SELECT LUG FROM ALUGVTA WHERE ID=".$LUG."";
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
while ($reg=mssql_fetch_array($registros)){
	$LUGNOM = $reg['LUG'];
}

$_SESSION['ParSQL'] = "SELECT NOMVEN FROM VENDEDORES WHERE CODVEN = ".$OPE;
$registros = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($registros);		
while ($reg=mssql_fetch_array($registros)){
	$OPENOM = $reg['NOMVEN'];
}

$GAS=0;
$_SESSION['ParSQL'] = "select sum(TOT) as TOT from pmaefact  where CG = 'G' and pla = ".$PLA."";
$GASTOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($GASTOS);		
while ($RGAS=mssql_fetch_array($GASTOS)){
	if($RGAS['TOT'] == NULL){
		$GAS = dec(0,2);
	}else{
		$GAS = dec($RGAS['TOT'],2);
	}
}

$CHE=0;
$_SESSION['ParSQL'] = "select sum(imp) as TOT from tvalor WHERE pla = ".$PLA."";
$CHEQUES = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CHEQUES);		
while ($RCHE = mssql_fetch_array($CHEQUES)){
	if($RCHE['TOT'] == NULL){
		$CHE = dec(0,2);
	}else{
		$CHE = dec($RCHE['TOT'],2);
	}
}

$RET=0;
$ANT=0;
$_SESSION['ParSQL'] = "select  sum(efe) as RET, sum(ant) as ANT from aturrpa  where pla = ".$PLA."";
$EFECTIVO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($EFECTIVO);		
while ($REFE=mssql_fetch_array($EFECTIVO)){
	
	if($REFE['RET'] == NULL){
		$RET = dec(0,2);
	}else{
		$RET = dec($REFE['RET'],2);
	}
	if($REFE['ANT'] == NULL){
		$ANT = dec(0,2);
	}else{
		$ANT = dec($REFE['ANT'],2);
	}
	
} 	

$TAR=0;
$_SESSION['ParSQL'] = "select  sum(imp) as TOT from acupones  where pla = ".$PLA."";
$TARJETAS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($TARJETAS);		
while ($RTAR=mssql_fetch_array($TARJETAS)){
	if($RTAR['TOT'] == NULL){
		$TAR = dec(0,2);
	}else{
		$TAR = dec($RTAR['TOT'],2);
	}
}

$CBE=0;
$_SESSION['ParSQL'] = "select sum(tot) as TOT from pmaefact where tco = 'FT' and fpa = 1 and anu <> 'A' and pla = ".$PLA."";
$COMPEFE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($COMPEFE);		
while ($RCBE=mssql_fetch_array($COMPEFE)){
	if($RCBE['TOT'] == NULL){
		$CBE = dec(0,2);
	}else{
		$CBE = dec($RCBE['TOT'],2);
	}
}	

$CAR=0;
$_SESSION['ParSQL'] = "select CAR as TOT from aturnoso where pla = ".$PLA."";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
while ($RCAR=mssql_fetch_array($CAMBREC)){
	if($RCAR['TOT'] == NULL){
		$CAR = dec(0,2);
	}else{
		$CAR = dec($RCAR['TOT'],2);		
	}
}

//	CALCULO GASTOS CONTADOS
$_SESSION['ParSQL'] = "select sum(tot) as TOT from pmaefact where tco in ('FT','CI') and fpa = 1 and anu <> 'A' and pla = ".$PLA." and CG = 'C'";
$COMPEFE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($COMPEFE);		
while ($RCBE=mssql_fetch_array($COMPEFE)){
	if($RCBE['TOT'] == NULL){
		$TOTGC1 = dec(0,2);
	}else{
		$TOTGC1 = dec($RCBE['TOT'],2);
	}
}	

$_SESSION['ParSQL'] = "select sum(tot) as TOT from pmaefact where tco in ('NC') and fpa = 1 and anu <> 'A' and pla = ".$PLA." and CG = 'C'";
$COMPEFE = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($COMPEFE);		
while ($RCBE=mssql_fetch_array($COMPEFE)){
	if($RCBE['TOT'] == NULL){
		$TOTGC2 = dec(0,2);
	}else{
		$TOTGC2 = dec($RCBE['TOT'],2);
	}
}

$TOTAL_GC = $TOTGC1 - $TOTGC2;

/////////////////////////////////////


$B01 = 0;
$B02 = 0;
$B03 = 0;
$B04 = 0;
$B05 = 0;

?>
<form method="post" name="formarqueo2" id="formarqueo2" action="ArqAgrN.php">

	<div id="detallearqueo" style="position:absolute;" class="fon-arq">	
	
		<div style="position:absolute; top:18px; left:134px; width:35px;" align="center"><? echo $LUG; ?></div>
		<div style="position:absolute; top:18px; left:180px; width:112px;" align="center"><? echo $LUGNOM; ?></div>
		<div style="position:absolute; top:37px;left:134px; width:35px;" align="center"><? echo $PLA; ?></div>
		<div style="position:absolute; top:56px;left:134px; width:35px;" align="center"><? echo $OPE; ?></div>
		<div style="position:absolute; top:56px;left:180px; width:112px;" align="center"><? echo $OPENOM; ?></div>
		
		<div id="supnum" class="div-redondo" style="position:absolute; top:72px; left:131px; width:38px;" align="center">
			<input class="fon-arq1" type="text" name="sup" readonly="readonly" id="sup" maxlength="4" style="border:0; width:35px; height:12px; background-color:transparent; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlOperario();"  onKeyDown="return ControlOperarioVol();"/>
		</div>
		
		<!-- TRAE EL OPERARIO SUPERVISOR -->        
        <div id="fondogeneralsupe" style="position:absolute; width:600px; height:800px; z-index:1; display:none;"></div>
		<div id="fondosuper" style="position:absolute; top:9px; left:-89px; z-index:2; display:none;">
			<img src="otros/fon-der.png" />
		</div>
		<div id="descpidesupe" style="position:absolute; top:-25px; left:58px; display:none; z-index:2;"></div>
		
        <!-- DETALLE DE PDF -->
        <div id="fondogeneral" style="position:absolute; width:600px; height:800px; z-index:1; display:none;"></div>
		<div id="fondopidetipo" style="position:absolute; top:17px; left:-89px; z-index:2; display:none;">
			<img src="otros/fon-der.png" />
		</div>
		<div id="descpidetipo" style="position:absolute; top:-25px; left:58px; display:none; z-index:2;"></div>
		
		<div style="position:absolute; top:74px;left:181px; width:108px;" align="center">
			<input class="fon-arq" type="text" name="supenom" onclick="buscaope();" id="supenom" readonly="readonly" style="border:0; width:112px; height:12px; background-color:#DD7927; cursor:pointer; text-align:center">
		</div>
		<div id="efectivo" class="div-redondo" style="position:absolute; top:117px; left:173px; width:96px; height:14px;">
			<input class="fon-arq2" type="text" name="efe" id="efe" readonly="readonly" style="border:0; width:90px; height:12px; background-color:transparent; outline-style:none; border-style:none; position:absolute; top:-1px; left:0px;" onKeyPress="return ControlEfectivo();" onKeyDown="return ControlEfectivoVol();" maxlength="7"/>
		</div>
		<div id="gastosf" style="position:absolute; top:139px; left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="gas" id="gas" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" value="<? echo $GAS; ?>"/>
		</div>
		<div id="chequesf" style="position:absolute; top:158px;left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="che" id="che" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" value="<? echo $CHE; ?>"/>
		</div>
		<div id="anticipof" style="position:absolute; top:176px;left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="ant" id="ant" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" value="<? echo $ANT; ?>"/>
		</div>
		<div id="tarjetasf" class="div-redondo" style="position:absolute; top:192px;left:174px; width:95px; display:none;">
			<input class="fon-arq2" type="text" name="tar" id="tar" readonly="readonly" style="left:2px; border:0; width:88px; height:13px;  background-color:transparent; outline-style:none; border-style:none; position:absolute; top:-1px; left:0px;" value="<? echo $TAR; ?>"  onKeyPress="return ControlTarjetas();" onKeyDown="return ControlTarjetasVol();" maxlength="7"/>
		</div>
		<div id="cargasf" style="position:absolute; top:212px;left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="car" id="car" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" value="<? echo $CAR; ?>"/>
		</div>
		<div id="retirof" style="position:absolute; top:232px;left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="ret" id="ret" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" value="<? echo $RET; ?>"/>
		</div>

        <div id="gascondiv" style="position:absolute; top:252px;left:180px; width:90px; display:block;">
        
                <img id="mon01" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-1px; left:-6px; width:99px;" />
                <img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-1px; left:-148px;"/>
        
                <div class="fon-mon" style="position:absolute; width:135px; top:-2px; left:-148px; z-index:1; font-size:12px;" align="right">
                    GASTOS CONTADO
                </div>
                <div id="gascon01" class="div-redondo" style="position:absolute; top:-2px; left:-9px; height:12px; width:99px; z-index:1; display:none;">
                    <input class="fon-arq2" type="text" name="gascon02" id="gascon02" readonly="readonly" style="position:absolute; top:-1px; border:0; width:90px; height:12px; background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon1();" onKeyDown="return ControlMon1Vol();" maxlength="5" value="<? echo $TOTAL_GC; ?>"/>
                </div>
		</div>		
        
       
<!-- ------- ------- ------- ------- ------- ------- ------- ------- ------- -->		
<!-- ------- ------- ------- IMAGENES DE LAS MONEDAS ------- ------- ------- -->
<!-- ------- ------- ------- ------- ------- ------- ------- ------- ------- -->
<div id="monedas" style="display:block; position:absolute; top:21px; left:0px;">
<?


$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
$can = mssql_num_rows($CAMBREC);
?>
	<input type="hidden" name="can" id="can" value="<? echo $can; ?>" />
<?
while ($RCAR=mssql_fetch_array($CAMBREC)){
	$B01DES = $RCAR['DES'];
	$B01ID = $RCAR['ID'];	

	if($B01ID == 1){
	?>
	<div id="moneda" style="position:absolute; top:250px; left:180px; width:90px; display:block;">

        <img id="mon01" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-1px; left:-6px; width:99px;" />
        <img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-1px; left:-148px;"/>

        <div class="fon-mon" id="<? echo $B01DES;?>" style="position:absolute; width:135px; top:-1px; left:-148px; z-index:1;" align="right">
            <? echo trim($B01DES); ?>
        </div>

        <div id="m01" class="div-redondo" style="position:absolute; top:-2px; left:-9px; height:12px; width:99px; z-index:1;">
            <input type="hidden" name="mon1" id="mon1" value="<? echo $B01DES;?>" />
            <input class="fon-arq2" type="text" name="m1" id="m1" readonly="readonly" style="position:absolute; top:-1px; border:0; width:90px; height:12px; background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon1();" onKeyDown="return ControlMon1Vol();" maxlength="5"/>
        </div>
    </div>
	<?
	}
}

$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
while ($RCAR=mssql_fetch_array($CAMBREC)){
	$B01DES = $RCAR['DES'];
	$B01ID = $RCAR['ID'];	

	if($B01ID == 2){
	?>
		<div id="moneda" style="position:absolute; top:270px;left:180px; width:90px; display:block; z-index:1"">
			<img id="mon02" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-3px; left:-6px; width:99px;" />
			<img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-3px; left:-148px;"/>
			<div class="fon-mon" id="<? echo trim($B01DES);?>" style="position:absolute; width:135px; top:-3px; left:-148px; z-index:1;" align="right">
				<? echo trim($B01DES); ?>
            </div>
	        <div id="m02" class="div-redondo" style="position:relative; top:-4px; left:-9px; height:12px; width:99px;">
                <input type="hidden" name="mon2" id="mon2" value="<? echo $B01DES;?>" />
                <input class="fon-arq2" type="text" name="m2" id="m2" readonly="readonly" style="position:absolute; top:-2px;border:0; width:90px; height:12px; background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon2();" onKeyDown="return ControlMon2Vol();" maxlength="5"/>
            </div>
		</div>
	<?
	}
}

$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
while ($RCAR=mssql_fetch_array($CAMBREC)){
	$B01DES = $RCAR['DES'];
	$B01ID = $RCAR['ID'];	

	if($B01ID == 3){
	?>
		<div id="moneda" style="position:absolute; top:289px;left:180px; width:90px; display:block; z-index:1"">
			<img id="mon03" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-4px; left:-6px; width:99px;"/>
			<img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-4px; left:-148px;"/>
			<div class="fon-mon" id="<? echo trim($B01DES);?>" style="position:absolute; width:135px; top:-4px; left:-148px; z-index:1;" align="right">
				<? echo trim($B01DES);?>
            </div>
	        <div id="m03" class="div-redondo" style="position:relative; top:-5px; left:-9px; height:12px; width:99px;">
                <input type="hidden" name="mon3" id="mon3" value="<? echo $B01DES;?>" />
                <input class="fon-arq2" type="text" name="m3" id="m3" readonly="readonly" style="position:absolute; top:-3px;border:0; width:90px; height:12px;background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon3();" onKeyDown="return ControlMon3Vol();" maxlength="5"/>"/>
			</div>
		</div>
	<?
	}
}
$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
while ($RCAR=mssql_fetch_array($CAMBREC)){
	$B01DES = $RCAR['DES'];
	$B01ID = $RCAR['ID'];	

	if($B01ID == 4){
	?>   
		<div id="moneda" style="position:absolute; top:305px;left:180px; width:90px; display:block; z-index:1"">
			<img id="mon04" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-2px; left:-6px; width:99px;" />
			<img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-2px; left:-148px;"/>
			<div class="fon-mon" id="<? echo trim($B01DES);?>" style="position:absolute; width:135px; top:1px; left:-148px; z-index:1;" align="right">
				<? echo trim($B01DES);?>
            </div>
            <div id="m04" class="div-redondo" style="position:relative; top:-5px; left:-9px; height:12px; width:99px;">
                <input type="hidden" name="mon4" id="mon4" value="<? echo $B01DES;?>" />
                <input class="fon-arq2" type="text" name="m4" id="m4" readonly="readonly" style="position:absolute; top:-2px; border:0; width:90px; height:12px; background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon4();" onKeyDown="return ControlMon4Vol();" maxlength="5"/>" />
            </div>
		</div>
	<?		
	}else{
	/*
	?>
	<input type="hidden" name="mon4" id="mon4" value="0" />
	<?
	*/
	}
}
$_SESSION['ParSQL'] = "SELECT * FROM CPARBON";
$CAMBREC = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($CAMBREC);		
while ($RCAR=mssql_fetch_array($CAMBREC)){
	$B01DES = $RCAR['DES'];
	$B01ID = $RCAR['ID'];	

	if($B01ID == 5){
	?>
		<div id="moneda" style="position:absolute; top:325px;left:180px; width:90px; display:block; z-index:1">
			<img id="mon05" src="ArqueoCaja/fondo blanco.png" style="z-index:0; position:absolute; top:-4px; left:-6px; width:99px;" />
			<img src="ArqueoCaja/fondo gris.png" style="z-index:0; position:absolute; top:-4px; left:-148px;"/>
			<div class="fon-mon" id="<? echo trim($B01DES);?>" style="position:absolute; width:135px; top:-1px; left:-148px; z-index:1;" align="right">
				<? echo trim($B01DES); ?>
            </div>
            <div id="m05" class="div-redondo" style="position:relative; top:-7px; left:-9px; height:12px; width:99px;">
                <input type="hidden" name="mon5" id="mon5" value="<? echo $B01DES;?>" />
                <input class="fon-arq2" type="text" name="m5" id="m5" readonly="readonly" style="position:absolute; top:-3px; border:0; width:90px; height:12px;background-color:transparent; z-index:3; outline-style:none; border-style:none; position:absolute; top:-2px; left:0px;" onKeyPress="return ControlMon5();" onKeyDown="return ControlMon5Vol();" maxlength="5"/>
            </div>

		</div>
	<?		
	}else{
	?>
	<input type="hidden" name="mon5" id="mon5" value="0" />
	<?
	}
}
?>		
</div>
		<div id="totalf" style="position:absolute; top:342px;left:180px; width:90px; display:none;">
			<input class="fon-arq2" type="text" name="tot" id="tot" readonly="readonly" style="border:0; width:90px; height:12px; background-color:#DD7927;" />
		</div>
			
	<input type="hidden" name="cbe" id="cbe" value="<? echo $CBE;?>" />
	</div>
    
	<!-- AYUDA CON ENTER -->    
	<input type="text" id="Terminar" name="Terminar" onkeypress="return ControlTerminar();" onkeydown="return ControlTerminarVol();" style="position:absolute; left:256px; top:487px; height:0px; width:0px; z-index:-2;" />

</form>	

<!-- CIERRA VENTANA LISTA PDF -->
<div id="cruzpdf" style="position:absolute; top:14px; left:346px; display:none; z-index:2;">
    <button class="StyBoton" onclick="salirpdf(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotVolPdf','','otros/cru-over.png',0)"><img src="otros/cru-up.png" name="Volver" title="Volver" border="0" id="BotVolPdf"/></button>
</div>

<!-- CIERRA VENTANA LISTA OPE -->
<div id="cruzope" style="position:absolute; top:6px; left:346px; display:none; z-index:2;">
    <button class="StyBoton" onclick="salirpdf(2);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotVolOpe','','otros/cru-over.png',0)"><img src="otros/cru-up.png" name="Volver" title="Volver" border="0" id="BotVolOpe"/></button>
</div>

<!-- BOTON PARA IMPRIMIR PDF -->
<div id="imprimirarq" style="position:absolute; top:442px; left:334px; display:none;">
	<button class="StyBoton" onclick="generapdfarq();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImpArq','','botones/imp-over.png',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImpArq"/></button>
</div>

<!-- BOTON PARA SALIR DE ARQUEO -->
<div id="sal_arq" style="position:absolute;  top:440px; left:-200px;">
	<button onclick="salir_arq();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetSalArq1','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalArq1"></button>
</div>

<!-- BOTON PARA CONSULTAR PDF -->
<div id="Arq_BotVer" style="position:absolute; top:395px; left:107px;">
	<button class="StyBoton" onclick="verpdf();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotImpUltArqPdf','','botones/con-over.png',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar Arqueos" border="0" id="BotImpUltArqPdf"/></button>
</div>

<!-- BOTON PARA TERMINAR EL ARQUEO -->
<div id="bot_ter" style="position:absolute; left:335px; top:441px; display:none;">
	<button onclick="terminar();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('LetTerArq1','','botones/ter-over.png',0)"><img src="botones/ter-up.png" name="Terminar" title="Terminar" border="0" id="LetTerArq1"/></button>
</div>
</div>




<div id="NumVolPADiv" class="PosDiv1">
    <button class="StyBoton" onclick="siguiente_arq2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('NumVolPA','','botones/ent-over.png',0)">
    <img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="NumVolPA"/></button>
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


