<?php

require("config/cnx.php");
require("util/utiles.php");


$data = new sqldata();

$mozos = $data->get_tabla("AMOZO");
$articulos = $data->get_tabla("ARTICULOS");

$dt = new sqldata();
$vendedor = array();
$vendedor = $dt->get_tabla("VENDEDORES","CodVen = ".$_SESSION['idsusua'] );

include("restaurant/salon/controller.php");
include("restaurant/salon/view.php"); 



?>




<script type="text/javascript" language="javascript" src="restaurant/salon/salon.js"></script>
<script type="text/javascript" language="javascript" src="restaurant/salon/mozos.js"></script>
<script type="text/javascript" language="javascript" src="restaurant/salon/mesas.js"></script>

<script type="text/javascript">
    
        
    var _request;

    function EditarMozos(){    
         <?php 
         if($vendedor[0]['ESENC']==1  ){
         ?>
             $(".lista_mesa, .opciones_salon").hide();
             $("#admin_mozos").load("Restaurant_mozos.php");
             <?php
         }else{ ?> 
                 _request = {load: "Restaurant_mozos.php", selector: "#admin_mozos"};
            $(".lista_mesa, .opciones_salon").hide();
            $("#login_admin").load("RestaurantID.php");        

         <?php    
         }   
         ?>
    }
    function EditarMesas(){    
         <?php 
         if($vendedor[0]['ESENC']==1){
         ?>
                 $(".lista_mesa, .opciones_salon").hide();
             $("#admin_mesas").load("Restaurant_mesas.php");
             <?php
         }else{ ?> 
                  _request = {load: "Restaurant_mesas.php", selector: "#admin_mesas"};
                 $(".lista_mesa, .opciones_salon").hide();
            $("#login_admin").load("RestaurantID.php");        

         <?php     
         }   
         ?>
    }        
</script>