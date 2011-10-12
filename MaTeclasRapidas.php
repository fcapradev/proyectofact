<?
require("config/cnx.php");
?>

<style>

#CadaProdtr{ 
	cursor:pointer; 
	color:#FFF;
}

#MaAnterior_Pro_tr1{ 
	position:absolute;
	cursor:pointer; 
	top:93px; 
	left:5px;
}

#MaSiguiente_Pro_tr2{
	position:absolute;
	cursor:pointer; 
	top:93px; 
	left:434px;
}

#Mateclasrapidas{ 
	position:absolute; 
	width:475px; 
	height:293px;
	top:20px; 
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





function MaInArtTR(cs,ca){

var cli = document.getElementById("MaCLI").value;

$("#Mamicapa1").load("MaControl.php?cb=0&cs="+cs+"&ca="+ca+"&cli="+cli);
	
	$("#Mamicapa1").fadeIn(tim);
	$("#Mateclasrapidas").fadeOut(tim);
	$("#Mamostrar").fadeOut(tim);
	$("#Matoda_la_bus").fadeOut(tim);
	

}

function Mamovpaga_pr(p){

	np = p - 1;
	document.getElementById('capa_pr'+p).style.display="none";	
	document.getElementById('capa_pr'+np).style.display="block";

return false;

}
function Mamovpag_pr(p){

	np = p + 1;
	document.getElementById('capa_pr'+p).style.display="none";	
	document.getElementById('capa_pr'+np).style.display="block";

return false;

}

</script>
<?

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


$TER = $_SESSION['ParPOS'];

$_SESSION['ParSQL'] = "SELECT * FROM ACONF_TR WHERE COD <> '' AND BOT < 37 AND POS = ".$TER."";
$ACONF_TR = mssql_query($_SESSION['ParSQL']) or die("Error SQL");
rollback($ACONF_TR);


$c = 0;
$cc = 0;
$s = 1;

echo "<div id='Mateclasrapidas'>";

if(mssql_num_rows($ACONF_TR) == 0){

	?>
    <table width="100%" height="200" align="center">
    <tr>
    	<td>
    		<div id="NoTeclasR" >
            	No ahí Teclas Rápidas configuradas para este Terminal.
            </div>
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
                <div id="MaAnterior_Pro_tr1"><img onClick="return movpagatr(<? echo $s; ?>)" src="TeclasRapidas/fle-izq.png" border="0"/></div>
				<?
			}
			
	}
	?>
    
    <td>
    <div id="CadaProdtr" onClick="MaInArtTR(<? echo $SECI; ?>, <? echo $ARTI; ?>)">
        <table cellpadding="0" cellspacing="0">
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
	if ($c == 3){
		echo '</tr><tr>';
	}

	if ($c == 6){

		if($cc != 24){
			?>
			<div id="MaSiguiente_Pro_tr2"><img onClick="return  movpagtr(<? echo $s; ?>)" src="TeclasRapidas/fle-der.png" border="0" /></div>
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