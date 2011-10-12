<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


?>

<style>

.bpro1{ 
	background-image:url(producto/FonSel.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	cursor:pointer; 
	height:28px;
}

.bpro2{ 
	background-image:url(producto/FonMar.png); 
	background-repeat:repeat-x;
	font-family: "TPro";
	cursor:pointer;
	height:28px;
}

.bpro3{
	background-image:url(producto/Bus_Item.png); 
	background-repeat:repeat-x;
	font-family: "TPro";
	cursor:pointer;
	height:28px;
}

#Anterior_Pro_Pro{
	position:absolute;
	left:430px; 
	top:85px;
}

#Siguiente_Pro_Pro{
	position:absolute;
	left:430px; 
	top:238px;
}

.bptsintil{ 
	background-image:url(producto/ProSinTil.png); 
	background-repeat:no-repeat; 
	width:38px; 
	height:28px; 
}

.bptcontil{
	background-image:url(producto/ProConTil.png); 
	background-repeat:no-repeat; 
	width:38px; 
	height:28px;
}

</style>

<script>

function MeterPromo(t,mp,cs,ca,cc){

SelecArt(cs,ca,cc);
IValue('hp'+mp,1);

$("#bp"+mp).removeClass("bpro2").addClass("bpro1");

	for (i=1; i<=t; i++){

		if(i == mp){
			$("#bp"+i).removeClass("bpro3").addClass("bpro1");
			$("#bpt"+i).removeClass("bptsintil").addClass("bptcontil");
		}else{

			if (TValue('hp'+i) == 1){
				$("#bp"+i).removeClass("bpro1").addClass("bpro2");
			}else{
				$("#bp"+i).removeClass("bpro1").addClass("bpro3");
			}

		}

	}

}


function SelecArt(cs,ca,cc){
	
	EnvAyuda('Ingrese cantidad del producto.');
	
	document.getElementById('LetTex').value = "";
	document.getElementById("DondeE").value = "NumTex";
	document.getElementById("CantiE").value = "6";
	document.getElementById("QuePoE").value = "6";

	$("#NumTex").focus();

	document.getElementById('LetEntPro').innerHTML = '<button id="LetEntProBut" class="StyBoton" onclick="CofSelecArt('+cs+','+ca+','+cc+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'EntFacPro\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="EntFacPro"/></button>';
		
	document.getElementById('NumVolPro').innerHTML = '<button class="StyBoton" onclick="CofSelecArt('+cs+','+ca+','+cc+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'EntFacPro2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="EntFacPro2"/></button>';

	SoloNone('LetEnt, NumVol');
	SoloBlock('LetEntPro, NumVolPro');

}

function CofSelecArt(cs,ca,cc){

	SoloNone('LetEntPro, NumVolPro');
	
	var catp = TNValue('cant_per');
	var cati = TNValue('NumTex');
	var cats = TNValue('cant_sel');
	var catil = LValue('NumTex');
		
	if(catil == 0){
		cati = 1;
	}
	
	var t = cats + cati;
	
	if(catp >= cati && catp >= t && cati != 0){

		IValue('cant_sel',t);
		BValue('NumTex');
		var cats = TValue('cant_sel');

			$("#archivos").load("NArtA.php?cc="+cati+"&cs="+cs+"&ca="+ca);

		if(catp == cats){
			
			$("#LetEntPro").removeClass("PosDivv2").addClass("PosDivv1");
			$("#NumVolPro").removeClass("PosDivv2").addClass("PosDivv1");

			SoloNone('LetEntPro, NumVolPro, Promo, MPromo');
			SoloBlock('LetEnt, NumVol, MiProd, micapa1');
			var cad = document.getElementById('datospro').value;
			var dat = cad.split("~");

			if(dat[6] == 0){
				NuevoIXCodigoB(''+dat[1]+'',''+dat[2]+'',dat[3],dat[4],dat[5]);			
			}
			
			IValue('datospro'," ");
			
		}
		
	}else{
		
		BValue('NumTex');
	
	}

}

function movpaga_pr(p){

	np = p - 1;
	document.getElementById('capa_pr'+p).style.display="none";	
	document.getElementById('capa_pr'+np).style.display="block";

return false;

}
function movpag_pr(p){

	np = p + 1;
	document.getElementById('capa_pr'+p).style.display="none";	
	document.getElementById('capa_pr'+np).style.display="block";

return false;

}



</script>
<?

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


//REQUEST
$SEC = $_REQUEST['cs'];
$ART = $_REQUEST['ca'];
$CANPRO = $_REQUEST['cc'];


//SESSION
$TER = $_SESSION['ParPOS'];


$SQL = "SELECT SECP, TIPO_PROMOCION FROM AARTPRO WHERE SECP = ".$SEC." AND CODP = ".$ART."";
$AARTPRO = mssql_query($SQL) or die("Error SQL");
$CoPro = mssql_num_rows($AARTPRO);
while ($AAR=mssql_fetch_array($AARTPRO)){
	$TIPOPRO = $AAR['TIPO_PROMOCION'];
}


if($TIPOPRO == 'A'){

}


$c = 0;
$s = 1;

if($TIPOPRO == 'B'){



	$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO WHERE SECP = ".$SEC." AND CODP = ".$ART." AND SINONIMO = 0";
	$AARTPRO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AARTPRO);
	while ($AART=mssql_fetch_array($AARTPRO)){
	
		$SECA = $AART['SECA'];
		$ARTA = $AART['CODA'];
		$CANAP = $AART['CANA'];
		
	}
	$CANA = $CANAP * $CANPRO;
	
	$_SESSION['ParSQL'] = "INSERT INTO AARTPRO_T VALUES (".$CANA.", ".$SECA.", ".$ARTA.", ".$TER.")";
	$AARTPRO_TI = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	rollback($AARTPRO_TI);
	

	$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO WHERE SECP = ".$SEC." AND CODP = ".$ART." AND SINONIMO <> 0";
	$AARTPRO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	$total = mssql_num_rows($AARTPRO);
	rollback($AARTPRO);
	
	echo "<table width='425'><tr><td>";
	$contar = 0;
	while ($AART=mssql_fetch_array($AARTPRO)){
		
		$contar = $contar + 1;
	
		$SECA = $AART['SECA'];
		$ARTA = $AART['CODA'];
		$CANA = $AART['CANA'];
		$TIPO = $AART['TIPO_PROMOCION'];
				
			$_SESSION['ParSQL'] = "SELECT DetArt FROM ARTICULOS WHERE CODSEC = ".$SECA." AND CODART = ".$ARTA."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($ARTT=mssql_fetch_array($ARTICULOS)){
				
				$DES = $ARTT['DetArt'];			
				
			}
			
		$CANA = $CANA * $CANPRO;
		
		$c = $c + 1;
		
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"capa_pr".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
			
				<div id="Anterior_Pro_Pro">
				<button class="StyBoton" onClick="return movpaga_pr(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro_Pro<?php echo $s; ?>"/></button>
				</div>
	
				<?
	
			}
	
		}
		?>
   		<div onclick="MeterPromo(<? echo $total; ?>, <? echo $contar; ?>,<? echo $SECA; ?>,<? echo $ARTA; ?>,<? echo $CANPRO; ?>);">
		<table  width="425" cellpadding="0" cellspacing="1">
			<tr>
			<td width="38" height="28">
            				
				<div id="bpt<? echo $contar ; ?>" class="bptsintil"><input type="hidden" id="hp<? echo $contar ; ?>" value="0" /></div>
			</td>
			<td>
				<div id="bp<? echo $contar ; ?>" class="bpro3">
					<? echo trim($DES); ?>
                </div>
			</td>
			</tr>
		</table>
	   </div>
		<?
		
		if ($c == 6){
	
			?>
			
			<div id="Siguiente_Pro_Pro">
			
			<button class="StyBoton" onClick="return  movpag_pr(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro_Pro<?php echo $s; ?>"/></button>
			
			</div>
			
			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	
	}

	echo "</td></tr></table>";

}




if($TIPOPRO == 'C'){

	echo "<table width='425'><tr><td>";
	$contar = 0;
	
	$_SESSION['ParSQL'] = "SELECT * FROM AARTPRO WHERE SECP = ".$SEC." AND CODP = ".$ART."";
	$AARTPRO = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
	$total = mssql_num_rows($AARTPRO);
	rollback($AARTPRO);
	while ($AART=mssql_fetch_array($AARTPRO)){
				
		$contar = $contar + 1;
	
		$SECA = $AART['SECA'];
		$ARTA = $AART['CODA'];
		$CANA = $AART['CANA'];
		$TIPO = $AART['TIPO_PROMOCION'];
				
			$_SESSION['ParSQL'] = "SELECT DetArt FROM ARTICULOS WHERE CODSEC = ".$SECA." AND CODART = ".$ARTA."";
			$ARTICULOS = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
			rollback($ARTICULOS);		
			while ($ARTT=mssql_fetch_array($ARTICULOS)){
				
				$DES = $ARTT['DetArt'];			
				
			}
			
		$CANA = $CANA * $CANPRO;
		
		$c = $c + 1;
		
		if ($c == 1){
	
			if($s == 1){
				$e = "block";
			}else{
				$e = "none";
			}
	
			echo "<div id=\"capa_pr".$s."\" style=\"display:".$e."\">";
			
			if($s <> 1){
				?>
			
				<div id="Anterior_Pro_Pro">
				
				<button class="StyBoton" onClick="return movpaga_pr(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro_Pro<?php echo $s; ?>"/></button>
				
				</div>
	
				<?
	
			}
	
		}
		?>
   		<div onclick="MeterPromo(<? echo $total; ?>, <? echo $contar; ?>,<? echo $SECA; ?>,<? echo $ARTA; ?>,<? echo $CANPRO; ?>);">
		<table  width="425" cellpadding="0" cellspacing="1">
			<tr>
			<td width="38" height="28">		
				<div id="bpt<? echo $contar ; ?>" class="bptsintil">
                	<input type="hidden" id="hp<? echo $contar ; ?>" value="0" />
                </div>
			</td>
			<td>
				<div id="bp<? echo $contar ; ?>" class="bpro3">
					<? echo trim($DES); ?>
                </div>
			</td>
			</tr>
		</table>
	    </div>
		<?
		
		if ($c == 6){
	
			?>
			
			<div id="Siguiente_Pro_Pro">
			
			<button class="StyBoton" onClick="return  movpag_pr(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro_Pro<?php echo $s; ?>"/></button>
			
			</div>
			
			</div>
			
			<?php
			  
			$c = 0; 
			$s = $s + 1;  
			
		}
	
	
	}

echo "</td></tr></table>";

}


?>
<script>
	document.getElementById('cant_per').value = "<? echo (int)$CANA;?>";
</script>
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