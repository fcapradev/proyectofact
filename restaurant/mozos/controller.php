<?php
/*************AJAX**************/
if (isset($_POST['validarNumero']) ){
    
    $mozos = $data->get_tabla("AMOZO", " NMO = ".$_POST['nmo']);
    if (count($mozos)>0){
        echo "Numero de mozo duplicado";
    }
    else{
        echo "success";
    }
    unset($_POST['validarNumero']);
    die();
}

if (isset($_POST['guardar'])){

 //1- edit ,  0-nuevo
    $data_ar['NMO'] = trim($_POST['nmo']);
    $data_ar['NOM'] = trim($_POST['nom']);
    $data_ar['DIR'] = trim($_POST['direccion']);
    $data_ar['POR_COM'] = trim(trim($_POST['comision'],"."));
    $data_ar['QUEY'] = trim($_POST['estado']);
    
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->save("AMOZO", $data_ar, $_POST['tipo']);
    mssql_query("commit transaction") or die("Error SQL commit");
    
    mostrarMozos();
    die();
}


function mostrarMozos(){ 
    $data = new sqldata();
    echo '   <table width="435px" cellpadding="0" cellspacing="1"> ';
    $mozos = $data->get_tabla("AMOZO");
    for($i = 0 ; $i < count($mozos) ; $i++){ 
        echo '              <tr class="item_mozo_edit fon_itm" > 
                                <td class="num_mozo " width="45">'.$mozos[$i]['NMO'].'</td>	
                                <td class="nom_mozo " width="390">'.$mozos[$i]['NOM'].'</td>
                                <td class="dir_mozo " width="390">'.$mozos[$i]['DIR'].'</td>
                                <input type="hidden" class="com_mozo" value="'.$mozos[$i]['POR_COM'].'" /> 
                                <input type="hidden" class="quey_mozo" value="'.$mozos[$i]['QUEY'].'" /> 
                            </tr>';
    } 
    echo '    </table> ';
}



?>