<?
require("config/cnx.php");
include("util/utiles.php");

try {////////////////////////////////////////////////////////////////////////////////////////////////// COMIENZO TRY //

mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");

$dt = new sqldata();
$vendedor = array();
$vendedor = $dt->get_tabla("VENDEDORES","CodVen = ".$_SESSION['idsusua'] );










?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Restaurante</title>


<style>
    #fondorestaurant{
        width: 800px;
        height:10px;
        left: 0px;
        top: 0px;
        
    }
    
    #botonera_resto{
        position: absolute;
        width:470px;
        height: 50px;
        top: 80px;
        left: 180px;
            
    }

    #botonera_resto ul li{
        float: left;
        display: inline;
        padding: 20px;
        
    }
    #botonera_resto ul {
        list-style: none;
    }
    
    
    
</style>

<script>
$("#Teclado_Completo, #tec_num").hide();
$("#BarFac").hide();
$("#BotonesFac").hide();
$("#BarFacD").hide();
$("#BotMins").hide();

$("#login_admin").hide();
$("#admin_mozos").hide();
$("#div_salon").hide();



function EntrarMozo(){    
     <?php 
     if($vendedor[0]['ESENC']==1 || true){
     ?>
         $("#admin_mozos").load("Restaurant_mozos.php");
         <?php
     }else{ ?> 
        $("#login_admin").load("RestaurantID.php");        
     
     <?php     
     }   
     ?>
}
function EntrarMesas(){    
     <?php 
     if($vendedor[0]['ESENC']==1 || true){
     ?>
         $("#admin_mesas").load("Restaurant_mesas.php");
         <?php
     }else{ ?> 
        $("#login_admin").load("RestaurantID.php");        
     
     <?php     
     }   
     ?>
}
function EntrarSalon(){    
     $("#div_salon").load("Restaurant_salon.php");
}


$(document).ready(function(){
        
    

    });


SoloBlock("LetSal");





</script>
</head>

<body>


<div id="restaurant_base">
<?php

?>
	<div id="fondorestaurant" style="position:absolute;">
		<img src="restaurant/fondo.png" />
	</div>
    
    <div id="botonera_resto">
        <ul>
            <li>
                <button onclick="EntrarMozo();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('boton_mozo','','restaurant/img/bot-mozo-over.png',0)"><img src="restaurant/img/bot-mozo-up.png" name="Enter" title="Mozo" border="0" id="boton_mozo"/></button>                
            </li>
            <li>
                <button onclick="EntrarMesas();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('boton_mesas','','restaurant/img/bot-mesa-over.png',0)"><img src="restaurant/img/bot-mesa-up.png" name="Enter" title="Mesas" border="0" id="boton_mesas"/></button>                                
            </li>
            <li>
                <button onclick="EntrarSalon();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('boton_salon','','restaurant/img/bot-salon-over.png',0)"><img src="restaurant/img/bot-salon-up.png" name="Enter" title="Salón" border="0" id="boton_salon"/></button>                                
            </li>
            
        </ul>
    </div>
</div>

<div id="login_admin"></div>


<div id="admin_mesas"></div>
<div id="admin_mozos"></div>
<div id="div_salon"></div>


<div id="NumVolPADiv" class="PosDiv1">
    <button class="StyBoton" onclick="siguiente_arq2();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('NumVolPA','','botones/ent-over.png',0)">
    <img src="botones/ent-up.png" name="Enter" title="Enter" border="0" id="NumVolPA"/></button>
</div>


</body>
</html>

<?



}catch(Exception $e){ ////////////////////////////////////////////////////////////////////////////////////////////////// FIN DE TRY //
	
	?>
	<script>
		jAlert('ERROR Reintente la operacion solicitada.', 'Debo Retail - Global Business Solution');
	</script>
	<?

exit;

}

?>