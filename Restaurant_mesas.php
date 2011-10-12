<?php


require("config/cnx.php");
require("util/utiles.php");



$data = new sqldata();
/*
 
AMESAS = MAESTRO DE MESAS
MRT= NUMERO DE MESA
POS = POSICION EN EL SALON
DET = DESCRIPCION
EST= ESTADO = 'D' DISPONIBLE  -  'O' OCUPADA   
UNI = UNIDA  (VA EL NUMERO DE MESA CON LA QUE SE UNE PARA HACER UNA SOLA)
 */



define("TOTAL_MESAS",24);

/*************AJAX**************/

include("restaurant/mesas/controller.php");
include("restaurant/mesas/view.php");



?>

<script src="restaurant/mesas/mesas.js" type="text/javascript"></script>


