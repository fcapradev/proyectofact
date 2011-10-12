<?php

$lista = array();

$lista = $_SESSION['iListaBO'];

$param = isset($_GET['param']) ? $_GET['param'] : "";
$param = urldecode($param);
$param = str_replace("__mas__", "+",$param);
$cantidad = 0;

$varios_art = explode("+",$param);;
if (count($varios_art)==2) $param = $varios_art[1];

if (is_numeric($param)){

    
    
 
    $lista = $data->get_tabla("VI_CONSULTA_ARTICULOS_".$lista, " art = ".$param." order by art");
    
    if (count($lista)==0){
        if (count($varios_art)==2) {
            $cantidad = $varios_art[0];
        }
        $sql = "select b.codbar, a.codsec as sec, a.codart as art, a.detart as det, a.preven, a.exivta, a.exidep, a.pro, a.fpp, a.ILPC, codrub, ivaco, PID from articulos as a inner join codbar as b on b.codsec = a.codsec and b.codart = a.codart where b.codbar = '$param'";		
        $lista = $data->query($sql,true);

        
    }
}
else{
    $lista = $data->get_tabla("VI_CONSULTA_ARTICULOS_".$lista, " det like '%".$param."%' order by art");
    
    
}
include($DIR."tabla.php");/*
if (count($lista)>1){
    
} else if(count($lista)==0){
    
} else {
    
}
*/
?>
