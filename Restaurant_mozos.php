<?php


require("config/cnx.php");
require("util/utiles.php");



$data = new sqldata();
/*
 
AMOZO = MAESTRO DE MOZOS
NMO = NUMERO DE MOZO O CODIGO
NOM = NOMBRE Y APELLIDO
DIR = DIRECCION
POR_COM = COMISION
QUEY = LIBRE
 */


include("restaurant/mozos/controller.php");
include("restaurant/mozos/view.php");
/********************/
?>


<script type="text/javascript" src="restaurant/mozos/mozos.js" ></script>




