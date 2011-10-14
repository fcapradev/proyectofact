<?php



$producto = $data->get_tabla("ARTICULOS", "CodSec = ".$_GET['seccion']." AND CodArt = ".$_GET['codigo']);

$pr = $producto[0];

$seccion = $pr['CodSec'];
$codigo = $pr['CodArt'];
$detalle = $pr['DetArt'];
$precio = $pr['PreVen'];
$stock_dep = $pr['ExiDep'];
$stock_vta = $pr['ExiVta'];

$pid = $pr['PID'];

/*IMAGEN*/
$psec = format($seccion,2,'0',STR_PAD_LEFT);
$part = format($codigo,4,'0',STR_PAD_LEFT);
$file = $psec.'-'.$part;
$path = "articulos/".$file.".jpeg";
/***************/

if (!file_exists($path)){
    $path = "articulos/00-0000.jpeg";
}

$es_promo = $pr['PRO'];
$forma_parte_promo = $pr['FPP'];



$view = "";/*
if ($es_promo){
    $view = "normal.php";
}
else if($forma_parte_promo){
    $view = "parte-promo.php";
}else {
    $view = "espromo.php";
}*/ 
$view = "normal.php";
include($DIR.$view);

?>
