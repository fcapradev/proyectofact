<?php
if (isset($_POST['MOVER'])){


    $mesa['POS'] = $_POST['pos2'];
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $sql = "update AMESAS set POS = ".$_POST['pos2']." where POS = ".$_POST['pos1'];
    mssql_query($sql);
    mssql_query("commit transaction") or die("Error SQL commit");
            
    die();
}

if (isset($_POST['guardar'])){
  
    $mesa['MRT'] = $_POST['descripcion'];
    $mesa['POS'] = $_POST['numero_mesa'];
    $mesa['EST'] = 'D';
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->save("AMESAS", $mesa, 0);
    mssql_query("commit transaction") or die("Error SQL commit");
            
    die();
}

if (isset($_POST['eliminar'])){
    $id = $_POST['numero_mesa'];    
    mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
    $data->delete("AMESAS", "POS = ". $id);
    mssql_query("commit transaction") or die("Error SQL commit");    
    die();
    
}

?>
