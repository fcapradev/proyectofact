<?php

/*AJAX*/


function get_mesas_unidas($id){
     $data = new sqldata();
     $mesas = $data->get_tabla("AMESAS", "EST = 'O' AND UNI = ".$id);
     $str = "";
     foreach($mesas as $mesa){
             $str .= $mesa['MRT'].",";
     }
     $str = trim($str,",");  
     return $str;    
}

function abrir_mesa($datos){
    $data = new sqldata();
    //obtener ultimo elemento
    $max = $data->query("select MAX(NCO) maxco from AMAEMESA");

    //guarda datos de mesa de abierta
    $amaemesa['NCO'] = $max[0]['maxco']+1;    
    $amaemesa['PLA'] = "";    
    $amaemesa['MRT'] = $datos->num_mesa; //numero mesa
    $amaemesa['FEC'] = date("Ymd H:i:s");
    $amaemesa['VEN'] = $datos->mozo;
    $amaemesa['CER'] = "N";
    $amaemesa['FAC'] = 0;   
    $amaemesa['TUR'] = 0;   
    $amaemesa['LUG'] = $_SESSION['ParLUG']; 
    $data->save("AMAEMESA", $amaemesa,0);
    
    //actualiza el estado de la mesa a ocupada
    $mesa['MRT'] = $datos->num_mesa;
    $mesa['EST'] = 'O';
    $data->save("AMESAS", $mesa, 1);    
    
    return $amaemesa;
}




if (isset($_POST['MESAS'])){

    $arr = new stdClass();
    $data = new sqldata();
    $numero_mesa = $_POST['nromesa'];
    //traigo ultimo registro de esta mesa
    $mesa = $data->get_tabla("AMAEMESA", "MRT = ".$numero_mesa." AND CER='N'");
    if (!$mesa){

        //Guardo datos de la mesa
        
        /*Obtener Planilla*/
        $sql = "SELECT C.NplVen AS PLA, D.FAP AS FAP, A.MTN, A.DES, A.INI, A.FIN FROM ATURNOSH AS A 
    INNER JOIN APARPOS AS B ON B.ID = '".$_SESSION['ParPOS']."'
    INNER JOIN VENDEDORES AS C ON C.CodVen = B.OPE
    INNER JOIN ATURNOSO AS D ON D.PLA = C.NplVen
    WHERE A.MTN = D.MTN";

        $item = $data->query($sql);
        $mesa[0]['NCO'] = 0;
        $mesa[0]['PLA'] = $item[0]['PLA'];    
        $mesa[0]['MRT'] = $_POST['nromesa'];
        $mesa[0]['FEC'] = date("Y-m-d H:i:s");
        $mesa[0]['VEN'] = 0; 
        $mesa[0]['VENNUM'] = 0; 
        $mesa[0]['CER'] = "S";
        $mesa[0]['TUR'] = $item[0]['MTN'];   
        $mesa[0]['LUG'] = $_SESSION['ParLUG'];    
    }
    else{
        foreach($mozos as $mozo)
            if($mozo['NMO']==$mesa[0]['VEN']){
                $mesa[0]['VENNUM'] = $mozo['NMO'];
                $mesa[0]['VEN'] = $mozo['NOM'];
                break;
            }
    }

    /*Obtener mesas unidas*/
    $str = get_mesas_unidas($numero_mesa);
    $arr->mesas = strlen($str)>0 ? $str : "[...]";

    /*Obtener mozo si hay*/
    $arr->numero_comprobante = $mesa[0]['NCO'];
    $arr->mozo_numero = $mesa[0]['VENNUM'];
    $arr->mozo = $mesa[0]['VEN'];
    $arr->hora = date("h:i");
    $arr->estado_mesa = $mesa[0]['CER'];
    
    $rtn = json_encode($arr);
    echo $rtn;
    die();    
}


//UNE MESA OCUPADA
if (isset($_POST['LINK_MESA'])){
    $mesa_actual = $_POST['mesa_actual'];
    $mesa_source = $_POST['mesa_source'];
    $numero_comprobante = $_POST['numero_comprobante'];
    
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    
//obtiene el maestro de la mesa especificada que no este cerrada    
    $mesa_source_reg = $data->get_tabla("AMAEMESA", "CER = 'N' AND MRT = ".$mesa_source);
    $mesa_mov = $data->get_tabla("AMOVMESA", "NCO = ".$mesa_source_reg[0]['NCO']." AND MRT = ".$mesa_source_reg[0]['MRT']);
    
//contador de mesa actual    
    $tmp = $data->query("select MAX(ORD) MAXORD from AMOVMESA where  MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante, false);    
    $cont = $tmp[0]['MAXORD'] + 1;
    
//actualiza cada item    
    foreach($mesa_mov as $item){
        $data->query("update AMOVMESA set MRT = ".$mesa_actual.", NCO = ".$numero_comprobante.", ORD = ".$cont." where MRT = ".$mesa_source." AND NCO = ".$mesa_source_reg[0]['NCO']." AND ORD = ".$item['ORD'], false);
        $cont++;
    }
    
//vincula a la mesa actual
    $data->query("update AMESAS set EST = 'O', UNI = ".$mesa_actual." WHERE MRT = ".$mesa_source,false);
    
//borra maestro de la mesa vacia
    $data->query("delete AMAEMESA where MRT = ".$mesa_source." AND NCO = ".$mesa_source_reg[0]['NCO'],false);   
    
     mssql_query("commit transaction") or die("Error SQL commit");       
     echo "<br/>";
    die();
}


if (isset($_POST['ACTUALIZAR_MESAS'])){
//{ACTUALIZAR_MESAS : 1, datos: res, mesa_actual : $("#numero_mesa").val() , mesa_target : num_mesa},    
    extract($_POST);
    $datos = json_decode($datos);
    
    $items_nuevos = array(); 
    $max_ord = 0; //contador nuevos
    $items_update = array(); 
    $cu = 1; //contador update
    

    $datos_mesa->num_mesa = $mesa_target;
    $datos_mesa->mozo = $mozo;

    $amaemesa = array();

    if($mesa_target_ocupada=='D'){
        $amaemesa = abrir_mesa($datos_mesa);
    }
    else{        
        //trae ammaemesa de la mesa ocupada donde se lleva los items
        $tmp = $data->get_tabla("AMAEMESA", "CER ='N' AND MRT = ".$mesa_target);   
        $amaemesa = $tmp[0];

        //trae el mayor orden de esta mesa 
        $tmp = $data->query("select MAX(ORD) MAXORD from AMOVMESA where  MRT = ".$amaemesa['MRT']." AND NCO = ".$amaemesa['NCO']);
        $max_ord = $tmp[0]['MAXORD']+1; 
    }
    
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
//    $tmp = $data->query("select MAX(ORD) MAXORD from AMOVMESA where  MRT = ".$numero_mesa." AND NCO = ".$comprobante);
    //se recorre cada uno de los items
    foreach($datos as $dato){
        //si las cantidades actuales son iguales se le hace un update al item del numero de mesa
        if ($dato->newcant == $dato->old_cant){
            $orden = $dato->numero_lista;
            $MRT = $mesa_target;
            $NCO = $amaemesa['NCO'];
            $query = "UPDATE AMOVMESA  SET MRT = ".$MRT.", NCO = ".$NCO.", ORD = ".$max_ord."  WHERE MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante." AND ORD = ".$orden;
            
            $data->query($query, false);
            $max_ord++;
            
        } 
        else if ($dato->newcant < $dato->old_cant){
            //se genera un nuevo item en la mesa target solo si es menor el numero nuevo
            //se evita que entre un numero mayor en cantidad nuevo
            
       
            $movmesa->MRT = $mesa_target;
            $movmesa->NCO = $amaemesa['NCO'];
            $movmesa->ORD = $cu;
            
            $movmesa->COD = $dato->cod_seccion_lista;
            $movmesa->ART = $dato->cod_articulo_lista;
            $movmesa->TIO = $dato->descripcion_lista;    
            $movmesa->CAN = $dato->newcant;
            $movmesa->PUN = $dato->precio_lista;
            $movmesa->PUT = ($dato->newcant * $dato->precio_lista);
            $movmesa->LUG = $_SESSION['ParLUG'];

            $data->insert("AMOVMESA",$movmesa);            
            $cu++;
            
            //update datos del origen
            $ITEM_SOURCE = $dato->numero_lista;
            $cant = $dato->old_cant - $dato->newcant;
            $total = $cant * $dato->precio_lista;
            $query = "UPDATE AMOVMESA SET CAN = ".$cant.", PUT = ".$total." WHERE ORD = ".$ITEM_SOURCE." AND MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante;
            $data->query($query, false);
        }        
    }

    mssql_query("commit transaction") or die("Error SQL commit");       

    die();
}

if (isset($_POST['ENVIAR_A_FAC'])){

    extract($_POST);
    $datos = json_decode($datos);
    
    $items_nuevos = array(); 
    $max_ord = 0; //contador nuevos
    $items_update = array(); 
    $cu = 1; //contador update
    

    $datos_mesa->num_mesa = $mesa_actual;
    $datos_mesa->mozo = $mozo;

    $amaemesa = array();

     
    
    $tmp = $data->query("select MAX(ORD) MAXORD from AMOVMESA where  MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante);
    $max_ord = $tmp[0]['MAXORD']+1; 

    
    mssql_query("begin transaction") or die("Error SQL begin trans");

    //se recorre cada uno de los items
    foreach($datos as $dato){
        //si las cantidades actuales son iguales se le hace un update al item del numero de mesa
        if ($dato->newcant == $dato->old_cant){
            $orden = $dato->numero_lista;
            $query = "UPDATE AMOVMESA  SET FAC = 1 WHERE MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante." AND ORD = ".$orden;

            $data->query($query, false);
            $max_ord++;
            
        } 
        else if ($dato->newcant < $dato->old_cant){
            //se genera un nuevo item en la mesa target solo si es menor el numero nuevo
            //se evita que entre un numero mayor en cantidad nuevo            
       
            $movmesa->MRT = $mesa_actual;
            $movmesa->NCO = $numero_comprobante;
            $movmesa->ORD = $cu;
            
            $movmesa->FAC = 1;
            $movmesa->COD = $dato->cod_seccion_lista;
            $movmesa->ART = $dato->cod_articulo_lista;
            $movmesa->TIO = $dato->descripcion_lista;    
            $movmesa->CAN = $dato->newcant;
            $movmesa->PUN = $dato->precio_lista;
            $movmesa->PUT = ($dato->newcant * $dato->precio_lista);
            $movmesa->LUG = $_SESSION['ParLUG'];

            $data->insert("AMOVMESA",$movmesa);            
            $cu++;
            
            //update datos del origen
            $ITEM_SOURCE = $dato->numero_lista;
            $cant = $dato->old_cant - $dato->newcant;
            $total = $cant * $dato->precio_lista;
            $query = "UPDATE AMOVMESA SET CAN = ".$cant.", PUT = ".$total." WHERE ORD = ".$ITEM_SOURCE." AND MRT = ".$mesa_actual." AND NCO = ".$numero_comprobante;
            $data->query($query, false);
        }        
    }

    mssql_query("commit transaction") or die("Error SQL commit");       

    die();

}


if (isset($_POST['DESOCUPAR_MESAS'])){
    
    $mesa['MRT']=$_POST['mesa'];
    $mesa['EST']='D';
    $mesa['UNI']=0;

     mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->save("AMESAS", $mesa, 1);
     mssql_query("commit transaction") or die("Error SQL commit");
     
     $str = get_mesas_unidas($_POST['nromesa']);
     echo $str;
     
    die();
}
if (isset($_POST['OCUPAR_MESAS'])){
    
    $mesa['MRT']=$_POST['mesas'];
    $mesa['EST']='O';
    $mesa['UNI']=$_POST['nromesa'];

     mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->save("AMESAS", $mesa, 1);
     mssql_query("commit transaction") or die("Error SQL commit");
     
    $str = get_mesas_unidas($_POST['nromesa']);
     echo $str;
    die();
}

if (isset($_POST['CERRAR_MESA'])){
    $numero_mesa = $_POST['numero_mesa'];
    $numero_comprobante = $_POST['numero_comprobante'];
    
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->query("delete AMAEMESA where NCO = ".$numero_comprobante." AND MRT = ".$numero_mesa, false);
    $data->query("update AMESAS set EST = 'D', UNI = 0 where MRT = ".$numero_mesa, false);
    $data->query("update AMESAS set EST = 'D', UNI = 0 where UNI = ".$numero_mesa, false);
    
    
    mssql_query("commit transaction") or die("Error SQL commit");
    
    die();
}

if (isset($_POST['COMPROBAR_FACTURA_VACIA'])){
     
    $carg = $data->get_tabla("TMOVFACT_T", " TER = ".$_SESSION["ParPOS"]);
    echo isset($carg[0]['NCO']) ? "true" : "false";
    die();
}

if (isset($_POST['ABRIR_MESA'])){
    $datos = new stdClass();
    $datos->num_mesa = $_POST['numero_mesa'];
    $datos->mozo = $_POST['mozo'];
    
    $amaemesa = abrir_mesa($datos);
    
    echo $amaemesa['NCO']; //si el resultado es 'open' la mesa ha sido abierta correctamente
    die();
}

if (isset($_POST['GUARDAR_MOZO'])){
/*
    numero_mesa : $("#numero_mesa").val(),
    numero_comprobante : $("#numero_comprobante").val(data),
    mozo : numero}, 
 
 */
    $data = new sqldata();
    extract($_POST);
    $sql = "UPDATE AMAEMESA SET VEN = ".$mozo." WHERE MRT = ".$numero_mesa." AND NCO = ".$numero_comprobante;
    $data->query($sql, false);
    die();
}

//obtener mesas para unirlas
if (isset($_POST['LISTA_MESAS'])){
    $mesa_actual = $_POST['numero_mesa'];
    print_mesas($mesa_actual);
    die();
}

if (isset($_POST['OBTENER_PRODUCTOS_MESA'])){
    $numero_mesa = $_POST['numero_mesa'];
    $numero_comprobante = $_POST['numero_comprobante'];
    $productos = $data->get_tabla("AMOVMESA", " MRT = ".$numero_mesa." AND NCO = ".$numero_comprobante." AND FAC = 0 OR FAC = 1");
    $data->query("UPDATE AMOVMESA SET FAC = 0 WHERE FAC = 1 AND NCO = ".$numero_comprobante." AND MRT = ".$numero_mesa, false);
    $prod  = json_encode($productos);
    
    echo $prod;
    die();
    
}

if (isset($_POST['ELIMINAR_ITEM'])){
    $id_sec = $_POST['sector_articulo'];
    $id_art = $_POST['codigo_articulo'];
    $numero_item = $_POST['numero_item'];
     $max = $data->delete("AMOVMESA","COD = ".$id_sec." AND ART = ".$id_art." AND ORD = ".$numero_item);
     die();
     
}

if (isset($_POST['MODIFICAR_CANTIDAD_ITEM'])){
    $numero_mesa = $_POST['numero_mesa'];
    $comprobante = $_POST['numero_comprobante'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $total = $_POST['total'];
    $orden = $_POST['numero_orden'];
    
    
    $data->query("UPDATE AMOVMESA set CAN = ".$cantidad.", PUT = ".$total." WHERE NCO = ".$comprobante." AND ORD = ".$orden." AND MRT = ".$numero_mesa, false);

    die();
     
}


if (isset($_POST['AGREGAR_ITEM'])){
    /*
amovmesa = movimientos de la mesa para despues facturar
MRT = numero de mesa
NCO = Numero de comprobante (estos dos se unen con el maestro de mesa)
ord = orden de ingreso de los productos pedidos
cod = sector del producto
art = codigo del producto
rub = rubro del producto
con = 0 fijo
tio = descripcion del producto
can = cantidad pedida
pun = precio unitario final de la ficha
put = precio cobrado por si tiene lista (hoy no se usa)
TUR = TUR DEL AMAEMESA
LEG = CODIGO DE VENDEDOR
PLA = PLANILLA DEL AMAEMESA
LUG = LUGAR DE LA AMAEMESA
ESC = LIBRE = BIT PARA SI O NO --> NO TIENE USO ACTUAL
     */
    $numero_mesa = $_POST['numero_mesa'];
    $comprobante = $_POST['numero_comprobante'];
    $codigo_articulo = $_POST['codigo_articulo'];
    $sector_articulo = $_POST['sector_articulo'];
    $detalle = $_POST['detalle'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];
    $total = $_POST['total'];
    
    
    $tmp = $data->query("select MAX(ORD) MAXORD from AMOVMESA where  MRT = ".$numero_mesa." AND NCO = ".$comprobante);
    
    $orden = $tmp[0]['MAXORD'] + 1;    
    $movmesa->MRT = $numero_mesa;
    $movmesa->NCO = $comprobante;
    $movmesa->ORD = $orden;
    $movmesa->COD = $sector_articulo;
    $movmesa->ART = $codigo_articulo;
    $movmesa->TIO = $detalle;    
    $movmesa->CAN = $cantidad;
    $movmesa->PUN = $precio_unitario;
    $movmesa->PUT = $total;
    $movmesa->LUG = $_SESSION['ParLUG'];
    
    $data->insert("AMOVMESA",$movmesa);
    echo $orden;
    die();
    
}



if(isset($_POST['MESAS_ENVIO'])){
    verMesasDisponibles();
    die();
}


/***************************************************************/
// Grilla de mesas cambiar 
// Funcion para insertar adelante la busqueda de mesas libres para enviar pedido
function verMesasDisponibles(){ 
        $data = new sqldata();
        $arr_mesas = $data->get_tabla("AMESAS", "UNI = 0");
        $mesas = array();
        if (count($arr_mesas)==0) {echo "no"; return;}
        ?>
    <div class="lista_mesa_reubicar">
<?php 
            for($i = 0 ; $i < count($arr_mesas) ; $i++){
                $mesas[$arr_mesas[$i]['POS']] = $arr_mesas[$i];
            }
            for($i = 0 ; $i < 24 ; $i++){ 
                $class="";
                $event = "";
                $nro = "";                
                if (isset($mesas[$i]['POS'])){
                    $class = "mesa_desocupada_ocupar" ;
                    $event = 'onclick=\'mesaSaleccionada('.$mesas[$i]["MRT"].',"'.$mesas[$i]["EST"].'");\'';
                    $nro = $mesas[$i]['MRT'];
                }
                ?>
            <div class="mesa_pos <?=$class?>" id="mesa_<?=$i?>" <?=$event?> >
                <span class="sp_numero_mesa"><?=$nro?></span>
                <span class="sp_nombre_mesa"></span>
            </div>
            <?php } ?>
        <button onclick="cerrarCambioMesa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnCancelarCambioMesa','','botones/botonvolver-over.png',0)"><img src="botones/botonvolver-up.png" name="Enter" title="Enter" border="0" id="btnCancelarCambioMesa" /></button>
    </div>
<?php   
}


//mesas para cambio
function print_mesas($mesa_actual){ 

        $data = new sqldata();
        
        $arr_mesas = $data->get_tabla("AMESAS");
        $mesas = array();
        if (count($arr_mesas)==0) {echo "no"; return;}
        ?>
    <div class="lista_mesa_reubicar">
<?php 
            for($i = 0 ; $i < count($arr_mesas) ; $i++){
                $mesas[$arr_mesas[$i]['POS']] = $arr_mesas[$i];
                $mesas_unidas = $data->get_tabla("AMESAS", "UNI = ".$arr_mesas[$i]['MRT']);
                $mesas[$arr_mesas[$i]['POS']]['tiene_uniones'] = count($mesas_unidas)>0 ? true : false ;
            }
            for($i = 0 ; $i < 24 ; $i++){ 
 
                $class="";
                $event = "";
                $nro = "";                
                if (isset($mesas[$i]['POS'])){
                    if($mesas[$i]['MRT'] == $mesa_actual){
                        $class = "";
                    }
                    else if ($mesas[$i]['UNI'] == $mesa_actual){
                        $class = "mesa_ocupada_unida";
                        $event = 'onclick=\'desocupar_mesa('.$mesas[$i]["MRT"].');\'';
                    }
                    else if  ($mesas[$i]['EST'] == 'D'){       
                        $class = "mesa_desocupada";
                        $event = 'onclick=\'seleccionar_mesa('.$mesas[$i]["MRT"].');\'';
                    }
                    else if ($mesas[$i]['EST'] == 'O' && $mesas[$i]['UNI'] == "0" && !$mesas[$i]['tiene_uniones']){
                        $class = "mesa_ocupada";
                        $event = 'onclick=\'seleccionar_mesa_ocupada('.$mesas[$i]["MRT"].');\'';
                    }
                
                    
                    $nro = $mesas[$i]['MRT'];
                }
                ?>
            <div class="mesa_pos <?=$class?>" id="mesa_<?=$i?>" <?=$event?> >
                <span class="sp_numero_mesa"><?=$nro?></span>
                <span class="sp_nombre_mesa"></span>
            </div>
            <?php } ?>
        <button onclick="cerrarCambioMesa();" class="StyBoton" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('btnCancelarCambioMesa','','botones/botonvolver-over.png',0)"><img src="botones/botonvolver-up.png" name="Enter" title="Enter" border="0" id="btnCancelarCambioMesa" /></button>
    </div>
<?php   
}


?>
