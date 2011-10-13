<?
require("config/cnx.php");

try {////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Nota de Alta y Baja</title>

<script type="text/javascript" language="javascript" src="NaNb/Script.js"></script>

<style>

.FuenteNaNb{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#000;
	height:16px;
	text-transform: uppercase;
}

.FuenteNaNbStock{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	height:18px;
	color:#06F; 
	font-weight: bold;
	text-transform: uppercase;
	
}

.FuenteNaNbLista{
	font-family: "TPro";
	font-size:12px;
	position:absolute;
	color:#F00;
	height:16px;
	text-transform: uppercase;
}

#LisFacComFon{
	position:absolute;
	display:none;
	top:112px;
	left:7px; 
	z-index:3;
}

#LisFacComFon2{
	position:absolute;
	display:none;
	top:141px;
	left:300px;
	z-index:3;
}

#LisFacComLis{
	position:absolute;
	font-family: 'TPro'; 
	text-align:center; 
	font-size:12px; 
	display:none;
	color:#FFF;
	height:57px;
	width:267px;
	top:162px;
	left:19px;
	z-index:3;
}


#LisFacComDat{
	font-family: "TPro";
	position:absolute;
	display:none;
	color:#FFF; 
	width:473px; 
	height:308px;
	top:142px;
	left:300px;
	z-index:3;
}

	#LisFacComDatEnc{
		position:absolute;
		font-size:14px; 
		width:473px; 
		top:0px;
		left:0px;
		z-index:3;
	}
	
	#LisFacComDatMed{
		position:absolute;
		font-size:11px; 
		width:473px;
		top:86px;
		left:0px;
		z-index:3;
	}
	
	#LisFacComDatTot{
		position:absolute;
		font-size:12px; 
		width:473px;
		top:214px;
		left:0px;
		z-index:3;
	}

#TituloLis{
	position:absolute; 
	font-family: 'TPro'; 
	text-align:center; 
	font-size:16px; 
	display:none;
	color:#FFF;
	top:115px; 
	left:18px; 
	width:267px;
	z-index:3;
}

#TituloNom{
	position:absolute; 
	font-family: 'TPro'; 
	text-align:center; 
	font-size:12px; 
	display:none;
	color:#FFF;
	top:115px; 
	left:270px; 
	width:388px;
	z-index:3;
}

#TituloLisFac{
	position:absolute; 
	font-family: 'TPro'; 
	text-align:center; 
	font-size:14px; 
	display:none;
	color:#FFF;
	top:140px; 
	left:18px; 
	width:267px;
	z-index:3;
}

#BotonesLis{
	position:absolute; 
	font-family: 'TPro'; 
	text-align:center; 
	font-size:16px; 
	display:none;
	color:#FFF;
	top:455px; 
	left:7px; 
	width:777px;
	z-index:3;
}
	#BotonesLisSal{
		position:absolute;
		top:0px;
		left:5px;
	}
	#BotonesLisTar{
		position:absolute; 
		display:none;
		top:0px;
		left:285px;
	}

</style>
<script>

</script>
</head>
<body>

<!-- MENSAJE DE BIENVENIDA -->

<div id="MsjSeleccion" align="center">
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
                    <div id="TomaInventario" style="top:20px; left:0px; display:block; z-index:3;">
                        <button id="Bot1" class="StyBoton" onclick="MsjSeleccion(1);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotTomInv','','PanPrin/tom-inv-over.png',0)"><img src="PanPrin/tom-inv-up.png" name="Toma de Inventario" title="Toma de Inventario" border="0" id="BotTomInv" /></button>
                    </div>
                    </td>
                    <td width="100">
                    <div id="NotaAltaBaja" style=" top:20px; left:100px; display:block; z-index:3;">
                        <button id="Bot2" class="StyBoton" onclick="MsjSeleccion(2);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotNaNb','','PanPrin/nanb-over.png',0)"><img src="PanPrin/nanb-up.png" name="NaNb" title="Nota Alta y Baja" border="0" id="BotNaNb" /></button>
                    </div>
                    </td>
                </tr>
                <tr align="center">
                    <td width="100" colspan="2">
                    <div id="SalirStock" style=" top:20px; left:100px; display:block; z-index:3;">
                        <button  class="StyBoton" onclick="MsjSeleccion(3);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('BotSalStock','','botones/sal-over.png',0)"><img src="botones/sal-up.png" name="Salir" title="Salir Mov. Stock" border="0" id="BotSalStock" /></button>
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

<!-- -------------------------- -->
<!-- CUERPO DE NOTA ALTA Y BAJA -->
<!-- -------------------------- -->

<div id="NotaCuerpo" style="display:none; width:740px; height:370px; top:10px; left:30px; position:absolute;">

    <div style="position:absolute; top:0px; left:38px; z-index:0;">
        <img src="NaNb/fondo.png" />
    </div>

<!-- CABECERA -->
	<div id="cabecera" style="position:absolute; top:24px; left:50px; width:635px; height:40px; display:block;">
    	<div style="position:absolute; top:0px; left:0px; z-index:0;">
        	<img src="NaNb/cabecera.png" />
        </div>
        
        <div id="TipoNotaDiv" class="div-redondo" style="position:absolute; top:21px; left:5px; width:126px; height:14px; display:block; " align="center" onclick="SelTipoNota();">
			<input class="FuenteNaNb"  type="text" name="TipoNota" id="TipoNota" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; text-align:center; width:120px; left:3px;" onkeypress="return ControlTipoNota();" maxlength="1" onkeyup="convertirL('TipoNota');" />
            
            <input type="hidden" id="TN" name="TN"  />
            <input type="hidden" id="MovTip" name="MovTip" />
            
		</div>
        

<!-- SELECCIONA EL TIPO DE NOTA (ALTA / BAJA) -->
		<div id="cuadrotipo" style="display:none; position:absolute; top:40px; left:4px;">
            <div id="fondotipoimg" >
                <img src="NaNb/fon-neg-tip.png"/>
            </div>
            
            <div style="top:1px; left:4px; z-index:3; position:absolute; width:129px; height:40px;">
                <div style="position:relative; cursor:pointer;"><img id="Img1" src="NaNb/fon-nota.png" /></div>
                <div id="NAB1" class="FuenteNaNb" style="color:#FFF; position:absolute; top:2px; left:10px; width:129px; cursor:pointer;" onclick="SelNota(1)" > A - NOTA DE ALTA </div>
                
                <div style="position:relative; cursor:pointer;"><img id="Img2" src="NaNb/fon-nota.png"/></div>
                <div id="NAB2" class="FuenteNaNb" style="color:#FFF; position:absolute; top:20px; left:10px; width:129px; cursor:pointer;" onclick="SelNota(2)" > B - NOTA DE BAJA </div>
            </div>
			
		</div>
        
        <div id="PveDiv" class="div-redondo" style="position:absolute; top:21px; left:138px; width:35px; height:14px; display:block;" align="center" onclick="SelTipoNota();">
			<input class="FuenteNaNb" type="text" name="Pve" id="Pve" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:30px; text-align:center; display:none;" value="<? echo $_SESSION['ParEMP'];?>" />
		</div>
        
        <div id="NumDiv" class="div-redondo" style="position:absolute; top:21px; left:179px; width:60px; height:14px; display:block; " align="center" onclick="SelTipoNota();">
			<input class="FuenteNaNb" type="text" name="Num" id="Num" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; text-align:center; width:60px;"/>
		</div>

        <div id="fecinv" class="div-redondo" style="position:absolute; top:21px; left:252px; width:74px;" align="center">
        <input class="FuenteNaNb" type="text" name="Fecha" id="Fecha" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; text-align:center; width:74px; display:none;" value="<? echo date("d/m/Y"); ?>" />
        </div>
    
        <div id="TipoOperacionDiv" class="div-redondo" style="position:absolute; top:21px; left:334px; width:189px; height:14px; display:block;" align="center" onclick="SelTipOper();">
			<input class="FuenteNaNb" type="text" name="TipoOperacion" id="TipoOperacion" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:182px; left:4px; text-align:center;" onkeypress="return ControlTipoOper();" onkeydown="return ControlTipoOperVol();" maxlength="1" onkeyup="convertirL('TipoOperacion');" />
		</div>
        
		<!-- OPERACIONES DE NOTA DE ALTA -->
		<div id="cuadrooperacionA" style="display:none; z-index:3; width:300px; height:200px;">
        
        	<div id="fondoblock" style="width:740px; height:565px; z-index:2; top:0px; left:0px; position:absolute;"></div>

            <div id="fondoopeimg" style="position:absolute; top:40px; left:332px; z-index:0.9;">
                <img src="NaNb/fon-mov-A.png"/>
            </div>

		<div style="top:40px; left:334px; z-index:3; position:absolute; width:230px; height:230px;">
			<div id="AjusteA" style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="ImA1" /></div>
            <div id="OpA1" class="FuenteNaNb" style="color:#FFF; position:absolute; top:2px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(1);" > A - A AJUSTE DE COMPRAS </div>
            
            <div id="DepositoA" style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="ImA2"/></div>
            <div id="OpA2" class="FuenteNaNb" style="color:#FFF; position:absolute; top:22px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(2);" > D - DEP&Oacute;SITO A VENTAS </div>
            
            <div id="VentasA" style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="ImA3" /></div>
            <div id="OpA3" class="FuenteNaNb" style="color:#FFF; position:absolute; top:41px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(3);"> V - VENTAS A VENTAS </div>
            
            <div id="VingA" style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="ImA4" /></div>
            <div id="OpA4" class="FuenteNaNb" style="color:#FFF; position:absolute; top:59px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(4);"> L - ING. DE OTROS LOCALES A VENTAS</div>
            
            <div id="DingA" style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="ImA5" /></div>
            <div id="OpA5" class="FuenteNaNb" style="color:#FFF; position:absolute; top:78px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(5);"> O - ING. DE OTROS LOCALES A DEP&Oacute;SITO </div>
		</div>
		</div> 


		<!-- OPERACIONES DE NOTA DE BAJA -->
		<div id="cuadrooperacionB" style="display:none; z-index:3; width:300px; height:300px;">
        
        	<div id="fondoblock" style="width:740px; height:565px; z-index:2; top:0px; left:0px; position:absolute;"></div>
            
            <div id="fondoopeimg" style="position:absolute; top:40px; left:332px; z-index:0.9;">
                <img src="NaNb/fon-mov-B.png"/>
            </div>

		<div style="top:40px; left:334px; z-index:3; position:absolute; width:230px; height:230px;">
			<div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im1" /></div>
            <div id="Op1" class="FuenteNaNb" style="color:#FFF; position:absolute; top:3px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(1);" > A - AJUSTE DE COMPRAS </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im2"/></div>
            <div id="Op2" class="FuenteNaNb" style="color:#FFF; position:absolute; top:22px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(2);" > D - VENTAS A DEP&Oacute;SITO </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im3" /></div>
            <div id="Op3" class="FuenteNaNb" style="color:#FFF; position:absolute; top:41px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(3);"> P - RETIRO DE VENTAS </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im4" /></div>
            <div id="Op4" class="FuenteNaNb" style="color:#FFF; position:absolute; top:59px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(4);"> E- RETIRO DE DEP&Oacute;SITO</div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im5" /></div>
            <div id="Op5" class="FuenteNaNb" style="color:#FFF; position:absolute; top:78px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(5);"> R - ROTURA DE VENTAS </div>

			<div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im6" /></div>
            <div id="Op6" class="FuenteNaNb" style="color:#FFF; position:absolute; top:98px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(6);" > O - ROTURA DEP&Oacute;SITO </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im7"/></div>
            <div id="Op7" class="FuenteNaNb" style="color:#FFF; position:absolute; top:116px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(7);" > Q - VENCIMIENTO VENTAS </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im8" /></div>
            <div id="Op8" class="FuenteNaNb" style="color:#FFF; position:absolute; top:135px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(8);"> U - VENCIMIENTO DEP&Oacute;SITO </div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im9" /></div>
            <div id="Op9" class="FuenteNaNb" style="color:#FFF; position:absolute; top:154px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(9);"> S - VENTAS A OTROS LOCALES</div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im10" /></div>
            <div id="Op10" class="FuenteNaNb" style="color:#FFF; position:absolute; top:173px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(10);"> T - DEP&Oacute;SITOS A OTROS LOCALES </div>

            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im11" /></div>
            <div id="Op11" class="FuenteNaNb" style="color:#FFF; position:absolute; top:193px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(11);"> X - DEP&Oacute;SITO A OTROS / C&Oacute;DIGO</div>
            
            <div style="position:relative; cursor:pointer;"><img src="NaNb/fon-tip-mov.png" id="Im12" /></div>
            <div id="Op12" class="FuenteNaNb" style="color:#FFF; position:absolute; top:212px; left:10px; width:229px; cursor:pointer;" onclick="Operacion(12);"> Z - ATENCI&Oacute;N AL CLIENTE </div>
		</div>
        
		</div>
        
		<input type="hidden" name="tipo" id="tipo" />
        
        <div id="OperadorDiv" class="div-redondo" style="position:absolute; top:22px; left:528px; width:95px; height:14px; display:none; " align="center">
			<input class="FuenteNaNb" type="password" name="Operador" id="Operador" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:90px; text-align:center;" onkeypress="return ControlOperador();" onkeydown="return ControlOperadorVol();" maxlength="12" />
            
            <input type="hidden" name="OpeVal" id="OpeVal" />
		</div>
        
    </div>
    
<!-- FIN CABECERA -->


<!-- CUERPO -->
	<div id="Cuerpo" style="position:absolute; top:70px; left:39px; width:660px; height:250px; display:none;">

		<div id="LocalOrigen" style="display:none;">
	        <div id="TituloC" style="position:absolute; top:4px; left:10px; font-size:24px; font-family: 'TPro'; display:block; width:640px; text-align:center; z-index:3;"></div>

            <div style="position:absolute; top:0px; left:10px;">
                <img src="NaNb/Local Origen.png" />
            </div>
            
            <div id="LocalDiv" class="div-redondo" style="position:absolute; top:51px; left:20px; width:66px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Local" id="Local" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:65px; text-align:center" onkeypress="return ControlLocal();" onkeydown="return ControlLocalVol();" maxlength="4" />
            </div>
    
            <div id="RazonDiv" class="div-redondo" style="position:absolute; top:50px; left:93px; width:250px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Razon" id="Razon" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:250px; text-align:left" />
            </div>
        
            <div id="DireccionDiv" class="div-redondo" style="position:absolute; top:50px; left:353px; width:275px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Direccion" id="Direccion" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:273px; text-align:left;" />
            </div>
    
            <div id="NumeroNotaDiv" class="div-redondo" style="position:absolute; top:85px; left:20px; width:174px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="NumeroNota" id="NumeroNota" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:174px; text-align:center;" onkeypress="return ControlNumNota();" onkeydown="return ControlNumNotaVol();" maxlength="4" />
            </div>    
      

		</div>

		<div id="LocalOrigenNB" style="display:none;">
	        <div id="TituloCNB" style="position:absolute; top:4px; left:10px; font-size:24px; font-family: 'TPro'; display:block; width:640px; text-align:center; z-index:3;"></div>

            <div style="position:absolute; top:0px; left:10px;">
                <img src="NaNb/Local Origen NB.png" />
            </div>
            
            <div id="LocalNBDiv" class="div-redondo" style="position:absolute; top:51px; left:20px; width:66px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="LocalNB" id="LocalNB" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:65px; text-align:center" onkeypress="return ControlLocalNB();" onkeydown="return ControlLocalNBVol();" maxlength="4" />
            </div>
    
            <div id="RazonNBDiv" class="div-redondo" style="position:absolute; top:50px; left:93px; width:250px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="RazonNB" id="RazonNB" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:250px; text-align:left" />
            </div>
        
            <div id="DireccionNBDiv" class="div-redondo" style="position:absolute; top:50px; left:353px; width:275px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="DireccionNB" id="DireccionNB" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:273px; text-align:left;" />
            </div>
		</div>

		<div id="Comprobante" style="display:none;">
	        <div id="TituloC" style="position:absolute; top:4px; left:10px; font-size:24px; font-family: 'TPro'; display:block; width:640px; text-align:center; z-index:3;"></div>

            <div style="position:absolute; top:0px; left:10px;">
                <img src="NaNb/comprobantes.png" />
            </div>
            <div style="position:absolute; top:56px; left:24px;">
                <img src="NaNb/fon-com-b.png" />
            </div>            
            <div id="Comprobante_Items" style="position:absolute; top:74px; left:18px; display:none">
                <img src="NaNb/compr_fondo.png" />
            </div>
            
			<div id="Lista_Items" style="display:none; position:absolute; top:10px; left:10px;">
            <table id="Lista_Art" border="0" cellpadding="8">

            </table>   
			</div>


            <div id="SucursalDiv" class="div-redondo" style="position:absolute; top:55px; left:22px; width:45px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Sucursal" id="Sucursal" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:45px; text-align:center" onkeypress="return ControlSucursal();" onkeydown="return ControlSucursalVol();" maxlength="4" />
            </div>
    
            <div id="TipoDiv" class="div-redondo" style="position:absolute; top:55px; left:70px; width:40px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Tipo" id="Tipo" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:40px; text-align:center" onkeypress="return ControlTipo();" onkeydown="return ControlTipoVol();" maxlength="1"/>
            </div>
        
            <div id="TcoDiv" class="div-redondo" style="position:absolute; top:55px; left:113px; width:38px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Tco" id="Tco" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:37px; text-align:center;"  onkeypress="return ControlTco();" onkeydown="return ControlTcoVol();" maxlength="2"/>
            </div>    
    
            <div id="NumeroDiv" class="div-redondo" style="position:absolute; top:55px; left:157px; width:65px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Numero" id="Numero" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:66px; text-align:center;" onkeypress="return ControlNumero();" onkeydown="return ControlNumeroVol();" maxlength="6"/>
            </div>    
    
            <div id="ProveedorIdDiv" class="div-redondo" style="position:absolute; top:54px; left:232px; width:29px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="ProveedorId" id="ProveedorId" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:25px; text-align:center"/>
            </div>
    
            <div id="ProveedorDiv" class="div-redondo" style="position:absolute; top:54px; left:263px; width:364px; height:14px; display:block; " align="center">
                <input class="FuenteNaNb" type="text" name="Proveedor" id="Proveedor" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:360px; text-align:center" />
            </div>
      	
		<input type="text" name="ConfirmaC" id="ConfirmaC" autocomplete="off" style="height:1px; width:1px; border:0px; background-color:transparent; width:360px; text-align:center"  onkeypress="return ControlConfirmaC();" onkeydown="return ControlConfirmaCVol();" maxlength="1"/>
		</div>

		<div id="OriDes" style="display:none;">
            <div id="TituloA" style="position:absolute; top:5px; left:10px; font-size:24px; font-family: 'TPro'; display:block; width:270px; text-align:center; z-index:3;"></div>
    
            <div id="TituloB" style="position:absolute; top:5px; left:290px; font-size:24px; font-family: 'TPro'; display:block; width:351px; text-align:center; z-index:3;"></div>
    
            <div style="position:absolute; top:0px; left:10px;">
                <img src="NaNb/cuerpo.png" />
            </div>
            
    <div style="position:absolute; top:10px; left:-66px; display:none;">
    <input type="button" id="btnAdd" onclick="AgregarItem()" value="INSERTAR"/> 
    </div>
            <div id="ListaArticulos" style="position:absolute; top:27px; left:9px; display:block; width:628px; height:169px;">
    
                <div id="CuerpoListaCI" style="width:628px; height:160px; position:absolute; top:0px; left:0px;">
                
                <table id="Lista" border="0" cellpadding="8">
                    <tr>
                        <td>
                        
                        </td>        	
                    </tr>
                </table>   
    
                </div>
        
                <!-- TOAL -->
                <div id="TotalDiv" style="position:absolute; top:170px; left:520px; display:block;">
                    <div style="position:relative; cursor:pointer;"><img src="NaNb/total.png" /></div>
                    <div id="Total" class="FuenteNaNb" style="color:#FFF; position:absolute; top:7px; left:52px; width:50px; cursor:pointer;" align="center"></div>
                </div>
                <!-- FIN TOTAL -->
            </div>
		</div>

    </div>
<!-- FIN CUERPO -->

<!-- BUSQUEDA DE SECTORES -->
	<div id="ListaSectorDiv" style="position:absolute; top:70px; left:125px; display:none;">

        <div style="position:absolute; top:0px; left:0px;">
        	<img src="NaNb/busqueda de productos.png" />
        </div>
		<div id="divlista" style="position:absolute; top:46px; left:5px; z-index:2;"></div>
        
	</div>
<!-- FIN BUSQUEDA DE SECTORES -->

<!-- BUSQUEDA DE LOCALES -->
    <div id="ListaLocalDiv" style="position:absolute; top:70px; left:43px; display:none;">
		<div style="position:absolute; top:2px; left:200px; font-size:17px; font-family: 'TPro'; display:block; width:189px; text-align:center; z-index:3;"> BUSQUEDA DEL LOCAL </div>
        <div style="position:absolute; top:0px; left:0px;">
            <img src="NaNb/bus_loc.png" />
        </div>
        <div id="divlistalocal" style="position:absolute; top:53px; left:1px; z-index:2;"></div>
        
    </div>
<!-- FIN BUSQUEDA DE SECTORES -->

<!-- PIE -->
	<div id="Pie" style="position:absolute; top:302px; left:36px; width:660px; height:48px; display:none;">

<!-- ORIGEN -->

		<input type="hidden" name="traven" id="traven" />
        
		<div id="SectorDiv" class="div-redondo" style="position:absolute; top:12px; left:23px; width:28px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="Sector" id="Sector" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:25px; text-align:center" onkeypress="return ControlSector();" onkeydown="return ControlSectorVol();" maxlength="4" />
		</div>

		<div id="ProductoDiv" class="div-redondo" style="position:absolute; top:12px; left:52px; width:40px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="Producto" id="Producto" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:40px; text-align:center" onkeypress="return ControlProducto();"  onkeydown="return ControlProductoVol();" maxlength="5" />
		</div>
    
		<div id="DetalleDiv" class="div-redondo" style="position:absolute; top:12px; left:102px; width:165px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="Detalle" id="Detalle" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:165px;" />
		</div>    

		<div id="StockDiv" class="div-redondo" style="position:absolute; top:28px; left:236px; width:36px; height:14px; display:block; " align="center">
			<input class="FuenteNaNbStock" type="text" name="Stock" id="Stock" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:38px; text-align:center;"/>
            <input type="hidden" name="StockAct" id="StockAct" />
		</div>    

<!-- DESTINO -->
		<div id="SectorDivD" class="div-redondo" style="position:absolute; top:13px; left:293px; width:28px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="SectorD" id="SectorD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:26px; text-align:center" onkeypress="return ControlSectorD();"  onkeydown="return ControlSectorDVol();" maxlength="4" />
		</div>

		<div id="ProductoDivD" class="div-redondo" style="position:absolute; top:13px; left:325px; width:39px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="ProductoD" id="ProductoD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:40px; text-align:center" onkeypress="return ControlProductoD();"  onkeydown="return ControlProductoDVol();" maxlength="5" />
		</div>
    
		<div id="DetalleDivD" class="div-redondo" style="position:absolute; top:12px; left:374px; width:165px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="DetalleD" id="DetalleD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:165px;" />
		</div>    

		<div id="StockDivD" class="div-redondo" style="position:absolute; top:28px; left:499px; width:40px; height:14px; display:block; " align="center">
			<input class="FuenteNaNbStock" type="text" name="StockD" id="StockD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:38px; text-align:center;"/>
            <input type="hidden" name="StockActD" id="StockActD" value="0" />
		</div>
        
        <div id="CostoDivD" class="div-redondo" style="position:absolute; top:12px; left:541px; width:42px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="CostoD" id="CostoD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:43px; text-align:center;"/>
		</div>
        
        <div id="CantidadDivD" class="div-redondo" style="position:absolute; top:13px; left:587px; width:39px; height:14px; display:block; " align="center">
			<input class="FuenteNaNb" type="text" name="CantidadD" id="CantidadD" readonly="readonly" autocomplete="off" style="height:15px; border:0px; background-color:transparent; width:39px; text-align:center;" onkeypress="return ControlCantidadD();"  onkeydown="return ControlCantidadDVol();" maxlength="4" />
		</div>

		<input type="text" id="TerminarCarga" name="TerminarCarga" onkeypress="return ControlTerminarCar();" onkeydown="return ControlTerminarCarVol();" style="position:absolute; left:473px; top:78px; width:1px;" />
    
    </div>
<!-- FIN PIE -->

<!--	GENERA EL PDF	-->
<form action="NaNbPDF.php" method="post" name="genera" id="genera">

    <input type="hidden" id="TCO" name="TCO" />
    <input type="hidden" id="NCO" name="NCO" />
    <input type="hidden" id="TIM" name="TIM" />
    
    <input type="hidden" id="EXI_ANT" name="EXI_ANT" />
    <input type="hidden" id="EXI_ANTD" name="EXI_ANTD" />
    
    <input type="hidden" id="TEXT01" name="TEXT01" />
    <input type="hidden" id="TEXT02" name="TEXT02" />
    <input type="hidden" id="TEXT03" name="TEXT03" />
    <input type="hidden" id="TEXT04" name="TEXT04" />
    <input type="hidden" id="TEXT05" name="TEXT05" />
    <input type="hidden" id="TEXT06" name="TEXT06" />

</form>

</div>

<!-- BUSQUEDA DE SUCURSALES -->

	<div id="LisFacComFon">
    	<input type="text" id="EscapeComprobantes" name="EscapeComprobantes" onkeypress="return ControlEscapeComprobantes();" onkeydown="return ControlEscapeComprobantesVol();" style="position:absolute; left:38px; top:350px; width:1px;" />
    	<img src="Compras/con_com.png" />
    </div>
   	<div id="LisFacComFon2"><img src="Compras/compra.png" /></div>

    <div id="TituloLis">Consulta de comprbates de compra</div>
    <div id="TituloNom">
        <table width="100%" border="0">
            <tr>
                <td><div id="LisNom"></div></td>
                <td><div id="LisDom"></div></td>
            </tr>
        </table>    
    </div>
    <div id="TituloLisFac">
        <table width="100%" border="0">
            <tr>
                <td>TIP</td>
                <td>TCO</td>
                <td>SUC</td>
                <td>NCO</td>
            </tr>
        </table>
    </div>

       	<div id="LisFacComLis">
    	</div>
        
		<div id="LisFacComDat">
            <div id="LisFacComDatEnc">
            <table width="473" height="62">
                <tr>
	                <td>
                        <div id="cantidad_art" style="display:none;"></div>

                    	<div id="tit1"></div>
                        <div id="tit4" style="display:none;"></div>
                        <div id="tit3" style="display:none;"></div>
	                    <div id="estado" style="position:absolute; top:6px; left:143px; width:320px; color:#000;" ></div>
                    </td>
                </tr>
                <tr>
    	            <td><div id="tit2"></div></td>
                </tr>
            </table>
            </div>
            <div id="LisFacComDatMed"></div>
            <div id="LisFacComDatTot">
            <table width="473">
                <tr>
	                <td width="94" height="49"><div align="center" id="det1"></div></td>
                    <td width="94" height="49"><div align="center" id="det2"></div></td>
                    <td width="94" height="49"><div align="center" id="det3"></div></td>
                    <td width="94" height="49"><div align="center" id="det4"></div></td>
                    <td width="94" height="49"><div align="center" id="det5"></div></td>
                </tr>
                <tr>
    	            <td width="94" height="17"><div align="center" id="det6"></div></td>
                    <td width="94" height="17"><div align="center" id="det7"></div></td>
                    <td width="94" height="17"><div align="center" id="det8"></div></td>
                    <td width="94" height="17"><div align="center" id="det9"></div></td>
                    <td width="94" height="17"><div align="center" id="det10"></div></td>
                </tr>
                <tr>
    	            <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94">&nbsp;</td>
                    <td width="94"><div align="center" id="det11"></div></td>
                </tr>
            </table>
            </div>
		</div>
        
	<div id="BotonesLis">

    	<div id="BotonesLisSal">
        	<button class="StyBoton" onClick="SalLisComprobantes();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('BotLisConSal','','botones/sal-over.png',0)">
            <img src="botones/sal-up.png" name="Salir" title="Salir" border="0" id="BotLisConSal"/></button>
        </div>

    	<div id="BotonesLisTar">
        <table width="255" border="0">
        <tr>
        <td width="85">
        <div id="BotonesLisTarMod" style="display:none;">
	        
        </div>    
        </td>
        </tr>
        </table>
        </div>
    
    </div>
<!-- FIN BUSQUEDA DE SECTORES -->


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