<?
require("config/cnx.php");

try {////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");


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

	$pla_ver = $reg['PLA'];
}
mssql_free_result($registros);


if(isset($_REQUEST['ban'])){
	if($_REQUEST['ban'] == 1){
		?>
        <script>
        	MsjSeleccion(1);
		</script>
        <?	
	}else{
		?>
        <script>
        	MsjSeleccion(2);
		</script>
        <?	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Retiro de efectivo</title>

<style>
.lineaCaj{
	background-image:url(RetiroCaja/lin.png);
	background-repeat:repeat-x;
	font-family: "TPro";
	font-weight:100;
	height:27px;
	width:699px;
	margin-top:2px;
}

.lineaCaj:active{ 
	position:relative;
	left:1px;
	top:1px;
	
	-moz-box-shadow:0px 1px 0 ;
	-webkit-box-shadow:0px 1px 0 ;
}

</style>
<script>

function MsjSeleccion(a){
	
	if(a == 1){
		
		SoloNone("MsjSeleccion, RetVales");
		SoloBlock("RetEfectivo");
		
	}else{
		
		if(a == 2){
	
			SoloBlock("RetVales");
			SoloNone("MsjSeleccion, RetEfectivo");


		}else{

			Mos_Ocu("BotonesPri");
			Mos_Ocu('RetiroEfectivo');
			$('#SobreFoca').fadeIn(500);
			document.getElementById('RetiroEfectivo').innerHTML = '';
			
		}
	}
}


/**** RETIRO EFECTIVO ****/
function salir_ret(){
	jConfirm("¿Esta seguro que desea salir?.", "Debo Retail - Global Business Solution", function(r){
		if(r == true ){
			Mos_Ocu("BotonesPri");
			Mos_Ocu('RetiroEfectivo');
			$('#SobreFoca').fadeIn(500);
			document.getElementById('RetiroEfectivo').innerHTML = '';
		}
	});	
}

function RetiroEfectivo(t,p,mp,anu,e){

	for (i=1; i<=t; i++){
		if(i == p){
			$("#linea"+i).removeClass("lineaCaj").addClass("lineare2");
			if(anu == 'ANULADO'){
				document.getElementById("Ret_BotAnuM").style.display = "none";
			}else{
				document.getElementById("Ret_BotAnuM").style.display = "block";
				document.getElementById('Ret_BotAnuM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(2,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnu\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnu"/></button>';
			}
			document.getElementById('Ret_BotConM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(3,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotCon\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="BotCon"/></button>';
			document.getElementById('Ret_BotImpM').innerHTML = '<button class="StyBoton" onclick="AccBotRetEfe(4,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImp\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImp"/></button>';
		}else{
			$("#linea"+i).removeClass("lineare2").addClass("lineaCaj");
		}
	}
}

function AccBotRetEfe(f,p,n){

	if(f == 1){
		
		$('#RetiroEfectivo').fadeOut(500);
		SoloBlock("LetSal");
		document.getElementById("DondeE").value = "retiro";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';

		$("#RetiroEfectivo").load("RetEfeN.php?ban=1");
		
		$('#RetiroEfectivo').fadeIn(500);
	}
	if(f == 2 ){
	  jConfirm("¿Está seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				
				$("#archivos").load("RetEfeT.php?ban=1&f="+f+"&p="+p+"&n="+n+"");
				
			}
		});
	}
	if(f == 3){

		$('#RetiroEfectivo').fadeOut(500);

		$("#RetiroEfectivo").load("RetEfeC.php?ban=1&p="+p+"&n="+n+"");

		$('#RetiroEfectivo').fadeIn(500);
		
	}
	if(f == 4){
		$("#archivos").load("RetEfeT.php?ban=1&f="+f+"&p="+p+"&n="+n+"");
	}
}

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

function SelVale(t,p,mp,anu,e){
	for (i=1; i<=t; i++){
		if(i == p){
			
			$("#lineaval"+i).removeClass("lineaCaj").addClass("lineare2");
			if(anu == 'ANULADO'){
			
				document.getElementById("Ret_BotAnuMVal").style.display = "none";
			
			}else{
			
				document.getElementById("Ret_BotAnuMVal").style.display = "block";
				document.getElementById('Ret_BotAnuMVal').innerHTML = '<button class="StyBoton" onclick="AccBotVale(2,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotAnuVal\',\'\',\'botones/anu-over.png\',0)"><img src="botones/anu-up.png" name="Anular" title="Anular" border="0" id="BotAnuVal"/></button>';
			}
			
			document.getElementById('Ret_BotConMVal').innerHTML = '<button class="StyBoton" onclick="AccBotVale(3,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotConVal\',\'\',\'botones/con-over.png\',0)"><img src="botones/con-up.png" name="Consultar" title="Consultar" border="0" id="BotConVal"/></button>';
			
			document.getElementById('Ret_BotImpMVal').innerHTML = '<button class="StyBoton" onclick="AccBotVale(4,'+e+','+mp+');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'BotImpVal\',\'\',\'botones/imp-over.png\',0)"><img src="botones/imp-up.png" name="Imprimir" title="Imprimir" border="0" id="BotImpVal"/></button>';
			
		}else{
			$("#lineaval"+i).removeClass("lineare2").addClass("lineaCaj");
		}
	}
}

function AccBotVale(f,p,n){

	if(f == 1){
		
		$('#RetiroEfectivo').fadeOut(500);
		SoloBlock("LetSal");
		
		document.getElementById("DondeE").value = "retiro";
		document.getElementById("CantiE").value = "8";
		document.getElementById("QuePoE").value = "1";
		
		document.getElementById('LetSal').innerHTML = '<button class="StyBoton" onclick="salir_ret();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetSalRetE\',\'\',\'botones/sal-over.png\',0)"><img src="botones/sal-up.png" name="Volver" title="Volver" border="0" id="LetSalRetE"/></button>';
		
		document.getElementById('LetEnt').innerHTML = '<button id="BotLetEntFac" onclick="siguiente();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetEntFac\',\'\',\'botones/ent-over.png\',0)"><img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="LetEntFac"/></button>';
		
		document.getElementById('NumVol').innerHTML = '<button id="LetVolRet" onclick="salir_ret();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'LetVolRet\',\'\',\'botones/vol-over.png\',0)"><img src="botones/vol-up.png" name="Volver" title="Volver" border="0" id="LetVolRet"/></button>';

		$("#RetiroEfectivo").load("RetEfeN.php?ban=2");
		
		$('#RetiroEfectivo').fadeIn(500);
	}
	if(f == 2 ){
	  jConfirm("¿Está seguro que desea anular?", "Debo Retail - Global Business Solution", function(r){
			if(r == true ){
				
				$("#archivos").load("RetEfeT.php?ban=2&f="+f+"&p="+p+"&n="+n+"");
				
			}
		});
	}
	if(f == 3){

		$('#RetiroEfectivo').fadeOut(500);

		$("#RetiroEfectivo").load("RetEfeC.php?ban=2&p="+p+"&n="+n+"");

		$('#RetiroEfectivo').fadeIn(500);
		
	}
	if(f == 4){
		$("#archivos").load("RetEfeT.php?ban=2&f="+f+"&p="+p+"&n="+n+"");
	}
}
</script>
</head>
<body>

<div id="MsjSeleccion" align="center" style="position:absolute; top:0px; left:0px; z-index:3;">
	<table width="800" height="600" border="0" cellpadding="0" cellspacing="0">
    <tr>
    	<td align="center">
        <div>
        <table width="300" height="150" border="1" cellpadding="0" cellspacing="0" bordercolor="#DD7927">
        <tr height="26" align="center">
            <td background="js/images/title.gif">
            <div style='font-family: "TPro"; font-size:16px; color:#DD7927;'>
				Debo Retail - Global Business Solution
            </div>
            </td>
        </tr>
        <tr>
            <td bgcolor="#000000">
            <div style='font-family: "TPro"; font-size:16px; color:#DD7927;'>
            	<table width="300" >
                <tr>
                <div align="center">
                	Seleccione la operaci&oacute;n deseada.
                </div>
                <br />
                </tr>
                <tr align="center">
                    <td width="100">
                    <div id="RetiroEfectivo" style="top:20px; left:0px; display:block; z-index:3;">
                        <button  class="StyBoton" onClick="MsjSeleccion(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotRetiroEfectivo','','botones/ret-efe-over1.png',0)"><img src="botones/ret-efe-up1.png" name="Retiro de Efectivo" title="Retiro de Efectivo" border="0" id="BotRetiroEfectivo" /></button>
                    </div>
                    </td>
                    <td width="100">
                    <div id="Vales" style=" top:20px; left:100px; display:block; z-index:3;">
                        <button  class="StyBoton" onClick="MsjSeleccion(2);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotVales','','botones/val-over.png',0)"><img src="botones/val-up.png" name="Vales" title="Vales" border="0" id="BotVales" /></button>
                    </div>
                    </td>
                </tr>
                <tr align="center">
                    <td width="100" colspan="2">
                    <div id="SalirRETVAL" style=" top:20px; left:100px; display:block; z-index:3;">
                        <button  class="StyBoton" onClick="MsjSeleccion(3);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotSalRET','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir Mov. Stock" border="0" id="BotSalRET" /></button>
                    </div>
                    </td>
                </tr>                
	            </table>
            </div>
            </td>
        </tr>
        </table>
	    </div>
        </td>
    </tr>
    </table>
</div>


<div id="RetEfectivo" style="display:none;">

    <div id="retiroefectivoimagen">
        <img src="RetiroCaja/fondoytitulos.png" />
    </div>
    
    <div id="retiroefectivo" style="left:47px;">
        <table width="699" height="26" cellpadding="0" cellspacing="0">
            <tr>		
            <?
            
            $SQL = "SELECT top 10 PLA, NUM, OPE, B.NomVen, A.FEC, 
						CASE ANU WHEN 1 THEN 'ANULADO' 
								ELSE ' ' 
								END AS ANU,
						(EFE+REF1+REF2+REF3+REF4+REF5+GAS+TAR+CHE) AS TOT 
					FROM ATURRPA A 
					INNER JOIN VENDEDORES B ON OPE=B.CodVen 
					WHERE PLA = ".$pla_ver." AND ANT = 0
					ORDER BY PLA, NUM asc";
/*			
			SELECT top 10 PLA, NUM, OPE, B.NomVen, A.FEC, CASE ANU WHEN 1 THEN 'ANULADO' ELSE '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' END AS ANU, (EFE+REF1+REF2+REF3+REF4+REF5+GAS+ANT+TAR+CHE) AS TOT FROM ATURRPA A INNER JOIN VENDEDORES B ON OPE=B.CodVen WHERE PLA =  ORDER BY PLA, NUM desc
*/
            $ATURRPA = mssql_query($SQL) or die("Error SQL");
            if(!mssql_num_rows($ATURRPA) == 0){
                    
                    $total = mssql_num_rows($ATURRPA);
                    $c = 0;
                    $cc = 0;
                    
                        
                while ($ATU=mssql_fetch_row($ATURRPA)){
                    
                    $c = $c + 1;
                    $cc = $cc + 1;
    
                    $fecha = $ATU['4'];
                    $date = new DateTime($fecha);
                    $fecha = $date->format('d-m-Y');
    
                    ?>
                    <tr>
                        <td>
                            <div class="lineaCaj" id="linea<? echo $cc; ?>" onClick="RetiroEfectivo(<? echo $total; ?>,<? echo $cc; ?>,<? echo $ATU[1]; ?>,'<? echo $ATU[5]; ?>',<? echo $ATU[0]; ?>);">
                                <table width="700" height="26" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer;">
                                <tr>
                                    <td width="50" align="center"><? echo $ATU[0]; ?></td>
                                    <td width="58" align="center"><? echo $ATU[1]; ?></td>
                                    <td width="84" align="center"><? echo $ATU[2]; ?></td>
                                    <td width="256" align="center"><? echo $ATU[3]; ?></td>
                                    <td width="107" align="center"><? echo $fecha; ?></td>
                                    <td width="71" align="center"><? echo $ATU[5]; ?></td>
                                    <td width="73" align="right"><? echo dec($ATU[6],2); ?>&nbsp;&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                        </td>
                        
                    </tr>
                    
                    <?
                    $c = 0;
                }
                mssql_free_result($ATURRPA);
            }	
            ?>
            </tr>
        </table>
    </div>
    
    <div id="retiroefectivoboton" style="position:absolute; left:50px; top:416px;">
    <table width="726">
        <tr>
            
            <td width="367">
            <div id="saleret" style="position:absolute;  top:4px; left:20px;">
                <button id="BotRetSal" onClick="salir_ret();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('LetSalirRe','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirRe"></button>
            </div>		
            </td>
            
            <td width="85">
            <div id="Ret_BotAgrM">
            <button style="position:absolute; top:5px; left:283px;" class="StyBoton" onClick="AccBotRetEfe(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotAgr','','botones/agr-ret-over.png',0)"><img src="botones/agr-ret-up.png" name="Agregar" title="Agregar" border="0" id="BotAgr"/></button>
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotAnuM" style="display:none; position:absolute; top:4px; left:394px;">
    
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotConM">
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotImpM">
    
            </div>
            </td>
        
        <td width="20"></td>
            
        </tr>
    </table>
    
    </div>	

</div>

<div id="RetVales" style="display:none;">

    <div id="retiroefectivoimagen">
        <img src="RetiroCaja/fondoytitulos.png" />
    </div>
    
    <div id="retiroefectivo" style="left:47px;">
        <table width="699" height="26" cellpadding="0" cellspacing="0">
            <tr>		
            <?
            
            $SQL = "SELECT top 10 PLA, NUM, OPE, B.NomVen, A.FEC, 
						CASE ANU WHEN 1 THEN 'ANULADO' 
								ELSE ' ' 
								END AS ANU, 
						(ANT+REF1+REF2+REF3+REF4+REF5+GAS+TAR+CHE) AS TOT 
					FROM ATURRPA A 
					INNER JOIN VENDEDORES B ON OPE=B.CodVen 
					WHERE PLA = ".$pla_ver." AND EFE = 0
					ORDER BY PLA, NUM asc";
        
            $ATURRPA = mssql_query($SQL) or die("Error SQL");
            if(!mssql_num_rows($ATURRPA) == 0){
                    
                    $total = mssql_num_rows($ATURRPA);
                    $c = 0;
                    $cc = 0;
                    
                        
                while ($ATU=mssql_fetch_row($ATURRPA)){
                    
                    $c = $c + 1;
                    $cc = $cc + 1;
    
                    $fecha = $ATU['4'];
                    $date = new DateTime($fecha);
                    $fecha = $date->format('d-m-Y');
    
                    ?>
                    <tr>
                        <td>
                            <div class="lineaCaj" id="lineaval<? echo $cc; ?>" onClick="SelVale(<? echo $total; ?>,<? echo $cc; ?>,<? echo $ATU[1]; ?>,'<? echo $ATU[5]; ?>',<? echo $ATU[0]; ?>);">
                                <table width="700" height="26" border="0" cellpadding="0" cellspacing="0" style="cursor:pointer;">
                                <tr>
                                    <td width="50" align="center"><? echo $ATU[0]; ?></td>
                                    <td width="58" align="center"><? echo $ATU[1]; ?></td>
                                    <td width="84" align="center"><? echo $ATU[2]; ?></td>
                                    <td width="256" align="center"><? echo $ATU[3]; ?></td>
                                    <td width="107" align="center"><? echo $fecha; ?></td>
                                    <td width="71" align="center"><? echo $ATU[5]; ?></td>
                                    <td width="73" align="right"><? echo dec($ATU[6],2); ?>&nbsp;&nbsp;</td>
                                </tr>
                              </table>
                            </div>
                            
                        </td>
                        
                    </tr>
                    
                    <?
                    $c = 0;
                }
                mssql_free_result($ATURRPA);
            }	
            ?>
            </tr>
        </table>
    </div>
    
    <div id="retiroefectivoboton" style="position:absolute; left:50px; top:416px;">
    <table width="726">
        <tr>
            
            <td width="367">
            <div id="saleret" style="position:absolute;  top:4px; left:20px;">
                <button id="BotRetSal" onClick="salir_ret();" class="StyBoton" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('LetSalirVa','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="LetSalirVa"></button>
            </div>		
            </td>
            
            <td width="85">
            <div id="Ret_BotAgrM">
            <button style="position:absolute; top:5px; left:283px;" class="StyBoton" onClick="AccBotVale(1);" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotAgrVal','','botones/agr-val-over.png',0)"><img src="botones/agr-val-up.png" name="Agregar" title="Agregar" border="0" id="BotAgrVal"/></button>
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotAnuMVal" style="display:none; position:absolute; top:4px; left:394px;">
    
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotConMVal">
            </div>
            </td>
            <td width="85">
            <div id="Ret_BotImpMVal">
    
            </div>
            </td>
        
        <td width="20"></td>
            
        </tr>
    </table>
    
    </div>	

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