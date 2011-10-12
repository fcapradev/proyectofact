<?
require("config/cnx.php");
?>

<style>

#CadaProdtr{ 
	cursor:pointer; 
	color:#FFF;
}

#Anterior_Pro_tr1{ 
	position:absolute;
	cursor:pointer; 
	top:130px; 
	left:5px;
}

#Siguiente_Pro_tr2{
	position:absolute;
	cursor:pointer; 
	top:130px; 
	left:434px;
}

#teclasrapidas{ 
	position:absolute; 
	width:475px; 
	height:265px;
	top:0px; 
	left:0px; 
	z-index:2;
}

#NoTeclasR{ 
	text-align:center; 
	font-family:"TPro"; 
	font-size:18px;
	color:#FFF;
}

</style>

<script>

function CofSelecArt(cs,ca,cc){

	SoloNone('LetEntPro, NumVolPro');
	
	var catp = TValue('cant_per');
	var cati = TValue('LetTex');
	var cats = TValue('cant_sel');
	var catil = LValue('LetTex');
		
	if(catil == 0){
		cati = 1;
	}
	
	var t = cats + cati;
	
	if(catp >= cati && catp >= t && cati != 0){

		IValue('cant_sel',t);
		BValue('LetTex');
		var cats = TValue('cant_sel');

			$("#archivos").load("NArtA.php?cc="+cati+"&cs="+cs+"&ca="+ca);

		if(catp == cats){
			
			$("#LetEntPro").removeClass("PosDivv2").addClass("PosDivv1");
			$("#NumVolPro").removeClass("PosDivv2").addClass("PosDivv1");

			SoloNone('teclasrapidas', 'LetEntPro, NumVolPro', 'Promo, MPromo');
			SoloBlock('LetEnt, NumVol, MiProd, micapa1');
			var cad = document.getElementById('datospro').value;			
			var dat = cad.split("~");
			
			if(dat[6] == 0){
				NuevoIXCodigoB(dat[1],dat[2],dat[3],dat[4],dat[5]);
			}
			
			IValue('datospro'," ");
			
		}
		
	}else{
		
		BValue('LetTex');
	
	}

}

function SelecArt(cs,ca,cc){
	
	EnvAyuda('Ingrese cantidad del producto en promocion.');

	document.getElementById('LetEntPro').innerHTML = '<button id="BotEntFacPro" onclick="CofSelecArt('+cs+','+ca+','+cc+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'EntFacPro\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="EntFacPro"/></button>';
		
	document.getElementById('NumVolPro').innerHTML = '<button id="BotVolFacPro" onclick="CofSelecArt('+cs+','+ca+','+cc+');" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'EntFacPro2\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="EntFacPro2"/></button>';

	SoloNone('LetEnt, NumVol');
	SoloBlock('LetEntPro, NumVolPro');

}

function NUPRO(cs,ca,cp,cc,cd){

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	EsPromo(cs,ca,cc);
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~0";
	IValue('datospro',t);
	
	$("#LetEntPro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVolPro").removeClass("PosDivv1").addClass("PosDivv2");
	
}

function NUPROB(cs,ca,cp,cc,cd){

	cs = parseInt(cs,10);
	ca = parseInt(ca,10);
	
	EsPromo(cs,ca,cc);
	
	var t = "~"+cs+"~"+ca+"~"+cp+"~"+cc+"~"+cd+"~1";
	IValue('datospro',t);
	
	
	$("#LetEntPro").removeClass("PosDivv1").addClass("PosDivv2");
	$("#NumVolPro").removeClass("PosDivv1").addClass("PosDivv2");
}


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


function InArtTR(cs,ca){

var cli = document.getElementById("CLI").value;

$("#micapa1").load("Control.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli);
	
	$("#micapa1").fadeIn(tim);
	$("#teclasrapidas").fadeOut(tim);
	$("#mostrar").fadeOut(tim);
	$("#toda_la_bus").fadeOut(tim);
	

}

function AgregaArt(){
/*
	SoloBlock("MsjAgr");
*/
	SoloNone("teclasrapidas");

	document.getElementById("Loading").style.display="block";
		$("#mostrar").load("facturador/TeclaRapConfig.php?l_env=1");
		
		$("#mostrar").fadeIn(tim);
		$("#micapa1").fadeOut(tim);
		$("#toda_la_bus").fadeOut(tim);

	EnvAyuda('Ingrese código de barras o realice una búsqueda.');
	
	document.getElementById("DondeE").value = "LetTex";
	document.getElementById("CantiE").value = "50";
	document.getElementById("QuePoE").value = "0";
	
	$('#LetTex').focus();
	
	document.getElementById('LetEnt').innerHTML = '<button class="StyBoton" onclick="ReeCodigoAgr();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';

}

function ReeCodigoAgr(){

	var control = document.getElementById('LetTex').value.length;
	var cb = document.getElementById('LetTex').value;
	var cadena = cb.charAt(0);

	if (control == 0){ return false; }
	
		if (/^([0-9])*$/.test(cadena)){
			
			document.getElementById('micapa1').innerHTML = "";
			document.getElementById('mostrar').innerHTML = "";
			document.getElementById('LetTex').value = "";
			SoloBlock("MiProd, Loading");
			
			var cli = document.getElementById("CLI").value;
			$("#mostrar").load("facturador/TeclaRapConfig.php?b_cod=1&l_env="+cb);
			$("#micapa1").fadeIn(tim);
			document.getElementById("Loading").style.display="none";
		
		}
		
		cb = cb.toLowerCase();
		if (/[a-z\s,ñ]/.test(cb)){
					
			var buscar = cb.indexOf("+");
	
			if(buscar == -1){ 
				
				document.getElementById('micapa1').innerHTML = "";
				document.getElementById('mostrar').innerHTML = "";
				document.getElementById('LetTex').value = "";
				SoloBlock("MiProd, Loading");
				
				var cb_env = ReplaceAll(cb," ","+");
				$("#mostrar").load("facturador/TeclaRapConfig.php?l_env="+cb_env);
				
				$("#mostrar").fadeIn(tim);
				$("#micapa1").fadeOut(tim);
				$("#toda_la_bus").fadeOut(tim);
			}

		}	
	
return false;
	
}

function EliminarArt(cod){

	jConfirm("&iquest;Est\u00e1 seguro que desea eliminar una Tecla R&aacute;pida?", "Debo Retail - Global Business Solution", function(r){
	if(r == true ){
			$("#archivos").load("facturador/Nuevo_Articulo.php?cod='"+cod+"'");
		}
	});
	
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

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<div id="MsjAgr" style="display:none;">
	<table width="100%" height="293" align="center">
    <tr>
    	<td>
    		<div id="NoTeclasR">
            	Realice la búsqueda del producto que desea Agregar.<br />
            </div>
    	</td>
    </tr>
    </table>
</div>

<?
$TER = $_SESSION['ParPOS'];

$_SESSION['ParSQL'] = "SELECT * FROM ACONF_TR WHERE COD <> '' AND BOT < 46  AND POS = ".$TER."";
//$_SESSION['ParSQL'] = "SELECT * FROM ACONF_TR WHERE COD <> '' AND BOT < 37 AND POS = 2";
$ACONF_TR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACONF_TR);


$c = 0;
$cc = 0;
$s = 1;

echo "<div id='teclasrapidas'>";

$total = mssql_num_rows($ACONF_TR);

if(mssql_num_rows($ACONF_TR) == 0){

	?>
	<table width="100%" height="100" align="center">
    <tr>
    	<td>
    		<div id="NoTeclasR">No hay Teclas Rápidas configuradas para este Terminal.</div>
    	</td>
    </tr>
    </table>
	<?

}

while ($ACONF=mssql_fetch_array($ACONF_TR)){

$COD = $ACONF['COD'];
$DT1 = $ACONF['DT1'];


	$pieces = explode("-",$COD);
	
		$SEC = $pieces[0]; 
		$ART = $pieces[1];

		$SECI = (int)$pieces[0]; 
		$ARTI = (int)$pieces[1];

	$p = $SEC.'-'.$ART;
	
	$COD_2=format($SEC,2,'0',STR_PAD_LEFT)."-".format($ART,4,'0',STR_PAD_LEFT);

	$n = "articulos/".$p.".jpeg";

	if (!file_exists($n)){$p = "00-0000";}

	$c = $c + 1;
	$cc = $cc + 1;
	
	if ($c == 1){

		if($s == 1){
			$e = "block";
		}else{
			$e = "none";
		}

		echo "<div id=\"capa_tr".$s."\" style=\"display:".$e."\">";
		echo '<table width="391px" cellpadding="0" cellspacing="1" align="center" border="0"><tr>';

			if($s <> 1){
				?>
                <div id="Anterior_Pro_tr1">
					<img onClick="return movpagatr(<? echo $s; ?>)" src="TeclasRapidas/fle-izq.png" border="0"/>
                </div>

                
				<?
			}
			
	}
	if($c == 1 && $s == 1){
	?>
    
    <td>
    <div id="CadaProdtr" onClick="AgregaArt()" style="position:absolute; top:1px; left:43px;">
    
        <div id="EliminarDiv" style="position:relative; cursor:pointer;  top:19px; left:130px; height:17px;"></div>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <td background="TeclasRapidas/con-fot.png" style="background-repeat:no-repeat;" width="131" height="80" align="center" valign="middle">
                    <img src="facturador/agregar.png" width="70" height="70" />
                </td>
             <tr>
             </tr>
                <td background="TeclasRapidas/con-des.png" style="background-repeat:no-repeat;" width="131" height="34" align="center" valign="middle">
					Agregar un art&iacute;culo
                </td>
            </tr>
        </table>
    </div>
	</td>
	
	<?
	}else{
	?>
    
    <td>
        <div onclick="EliminarArt('<? echo $COD_2; ?>');" style="position:relative; cursor:pointer; top:19px; left:103px; z-index:4;"><img src="iconos/botcerrar.png" width="25" height="17"/></div>

    <div id="CadaProdtr" onClick="InArtTR(<? echo $SECI; ?>, <? echo $ARTI; ?>)">
        <table id="art" cellpadding="0" cellspacing="0">
            <tr>
                <td background="TeclasRapidas/con-fot.png" style="background-repeat:no-repeat;" width="131" height="80" align="center" valign="middle">
                    <img src="articulos/<? echo $p; ?>.jpeg" width="116" height="58" />
                </td>
             <tr>
             </tr>
                <td background="TeclasRapidas/con-des.png" style="background-repeat:no-repeat;" width="131" height="34" align="center" valign="middle">
                    <? echo substr($DT1,0,12); ?>
                </td>
            </tr>
        </table>
    </div>
	</td>
	
	<?
	}

	if ($c == 3){
		echo '</tr><tr>';
	}

	if ($c == 6){

		if($cc != $total){
			?>
			<div id="Siguiente_Pro_tr2">
				<img onClick="return  movpagtr(<? echo $s; ?>)" src="TeclasRapidas/fle-der.png" border="0" />
            </div>
			<?
		}
		?>
		<td>
		</tr>
		</table>

        </div>
        
		<?php

		$c = 0; 
        $s = $s + 1; 

	}

}
echo "</div>";


mssql_query("commit transaction") or die("Error SQL commit");

	
}catch(Exception $e){//////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}