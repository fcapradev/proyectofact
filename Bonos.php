<?
require("config/cnx.php");


try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //


$se = $_REQUEST['se'];
$im = $_REQUEST['im'];

$oncli = "";
if($se == "e"){ $oncli = "Ma"; }

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bonos</title>

<script>
	
document.getElementById("DondeE").value = "<? echo $se; ?>CANBONOCAL";
document.getElementById("CantiE").value = "12";
document.getElementById("QuePoE").value = "1";
	
function movpaga_bo(p){
	
	np = p - 1;
	document.getElementById("capa_cot_bo"+np).style.display="block";
	document.getElementById("capa_cot_bo"+p).style.display="none";

return false;
}

function movpag_bo(p){

	np = p + 1;	
	document.getElementById("capa_cot_bo"+np).style.display="block";
	document.getElementById("capa_cot_bo"+p).style.display="none";
	
return false;
}

function calcotizacion(f,t,v){
	
	var catcot = document.getElementById("<? echo $se; ?>CANBONOCAL").value;
	
	var controldebon_CR = 0;
	controldebon_CR = document.getElementById("<? echo $oncli; ?>total").value;
	
	var resto = controldebon_CR / v;
	var resto1 = dec(resto);
	
	catcot = catcot.replace(",",".");
	catcot = dec(catcot);
	
	document.getElementById("<? echo $se; ?>CANBONOCAL").value = catcot;
	
	var sumcalcot = 0;
	if(resto1 == catcot){
		sumcalcot = resto * v;
	}else{
		sumcalcot = parseFloat(catcot) * parseFloat(v);
	}

	sumcalcot = dec(sumcalcot);
	
	document.getElementById("<? echo $se; ?>CANBONOCALL").value = sumcalcot;

	for (i=1; i<=t; i++){
	
		if(i == f){		
			$("#cadcot"+f).removeClass("paracadacoti1").addClass("paracadacoti2");
			document.getElementById("<? echo $se; ?>ID_BONO").value = f;
		}else{
			$("#cadcot"+i).removeClass("paracadacoti2").addClass("paracadacoti1");	
		}	
		
	}

	SoloBlock("LetTer");
	
	document.getElementById('LetTer').innerHTML = '<button class="StyBoton" onclick="<? echo $oncli; ?>Ter_IngBonos();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetConBonos\',\'\',\'botones/cont-over.png\',0)"><img src="botones/cont-up.png" name="Continuar" title="Continuar" border="0" id="LetConBonos"/></button>';

}	

</script>

<style>

.paracadacoti1{ 
	background-image:url(producto/Bus_Item.png); 
	height:28px; 
	font-family: "TPro";
	font-size: 12px;
	color:#FFF; 
	cursor:pointer;
}
.paracadacoti2{ 
	background-image:url(producto/FonSel.png); 
	height:28px; 
	font-family: "TPro";
	font-size: 12px;
	color:#FFF; 
	cursor:default;
}

</style>

</head>
<body>
<div style="position:absolute; top:0px; left:207px; z-index:5;">

	<div style="position:absolute; z-index:5; top:0px; left:0px;"><img src="facturador/coti.png" /></div>
	<div style="position:absolute; z-index:5; top:5px; left:5px;">
        <table width="340" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td>
            <div align="left"><img src="facturador/cot.png"></div>
        </td>        
        <td>
            <table align="right" border="0" cellpadding="0" cellspacing="0">
            <tr><td>&nbsp;</td></tr>
            </table>
        </td>
        </tr>
        </table>
        
        <?
        $c = 0;
        $cc = 0;
        $s = 1;
        
        $SQL = "SELECT ID, DES, COT, ABR FROM CPARBON ORDER BY ID";
        $registros = mssql_query($SQL) or die("Error SQL");	
		
		$toto = mssql_num_rows($registros);
		
        while ($reg=mssql_fetch_array($registros)){
        
            $c = $c + 1;
            $cc = $cc + 1;
            
            if ($c == 1){
        
                if($s == 1){
                    $e = "block";
                }else{
                    $e = "none";
                }
        
                echo "<div id=\"capa_cot_bo".$s."\" style=\"display:".$e."\">";
                
                if($s <> 1){
                    ?>
                
                    <div id="Anterior_Pro">
                    
                    <button class="StyBoton" onClick="return movpaga_bo(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Anterior_Pro<?php echo $s; ?>','','otros/scr_arri-over.png',0)"><img src="otros/scr_arri-up.png" border="0" id="Anterior_Pro<?php echo $s; ?>"/></button>
                    
                    </div>
        
                    <?
        
                }
        
            }
        
            ?>
            <div id="cadcot<? echo $cc; ?>" class="paracadacoti1" onclick="calcotizacion(<? echo $cc; ?>, <? echo $toto; ?>, <? echo $reg['COT']; ?>);">
            <table width="340" cellpadding="0" cellspacing="0" border="0" height="28">
                <tr> 
                    <td width="40" align="center">&nbsp;<? echo $reg['ID']; ?></td>	
                    <td width="75">&nbsp;<? echo substr($reg['DES'], 0, 30);  ?></td>
                    <td width="75">&nbsp;<? echo $reg['ABR']; ?></td>
                    <td width="75">&nbsp;<? echo dec($reg['COT'],2); ?></td>
                    <td width="75">&nbsp;<? echo dec($im / $reg['COT'],2); ?></td>
                </tr>
            </table>  
            </div>
            <?
        
            if ($c == 8){
        
                ?>
                
                <div id="Sig_Bonos">
                
                	<button class="StyBoton" onClick="return movpag_bo(<?php echo $s; ?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Siguiente_Pro<?php echo $s; ?>','','otros/scr_aba-over.png',0)"><img src="otros/scr_aba-up.png" border="0" id="Siguiente_Pro<?php echo $s; ?>"/></button>
                
                </div>
                
                </div>
                
                <?php
                  
                $c = 0; 
                $s = $s + 1;  
                
            }
        
        }
        if ($cc == 8){
            ?>
            <script>
                SoloNone("Sig_Bonos");
            </script>
            <?
        }
        
        ?>
	</div>    
    <div style="position:absolute;  top:237px; left:2px;">
    
        <table width="340" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td>
            <div style="position:relative;">
                <div style="position:relative;"><img src="facturador/pago/bla.png" width="120" /></div>
                <div style="position:absolute; top:0px; left:0px;">
                    <input class="vuelto22" readonly="readonly" type="text" size="9" name="<? echo $se; ?>CANBONOCAL" id="<? echo $se; ?>CANBONOCAL" value="0" />
                </div>
            </div>
        </td>
        <td>
            <div style="position:relative;">
                <div style="position:relative;"><img src="facturador/pago/nar.png" width="120" /></div>
                <div style="position:absolute; top:0px; left:0px;">
                    <input class="vuelto22" readonly="readonly" type="text" size="9" name="<? echo $se; ?>CANBONOCALL" id="<? echo $se; ?>CANBONOCALL" value="0" />
                </div>
            </div>
        </td>
        </tr>
        </table>       

    </div>
        
</div>

</body>
</html>
<?

mssql_query("commit transaction") or die("Error SQL commit");
 
?>
<script>
	
	document.getElementById("<? echo $se; ?>CANBONOCAL").value = document.getElementById("<? echo $oncli; ?>APagar").value;
	
</script>
<?

}catch(Exception $e){////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?
exit;

}