<?php

function print_array($arr, $alert = false){
    if ($alert) echo "<scrip>alert('";
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    if ($alert) echo "')</scrip>";
}

function alert($str){
    echo "<script>alert('".$str."')</script>";
    
}

class sqldata{
    var $_where ;
    var $_select;
    var $_join;
    var $_sql;
    
    function sqldata(){
        $this->reset();
    }
    
    
    function reset(){
        $this->_where = "";
        $this->_select = " * ";
        $this->_join = "";
        $this->_sql = ""; 
    }
    
    function where($where){
        $this->_where = $where;
    }
    
    function select($select = ' * '){
        $this->_select = $select;
    }
    
    function join($tabla, $on){
        
    }
    
    function get_tabla($tab, $where = false, $order = false){
        
        if ($where) $where = "WHERE ".$where;
        $sql = "SELECT ".$this->_select." FROM $tab $this->_join $where";
        
        $this->_sql = $sql;
        $_SESSION['ParSQL'] =  $this->_sql;
        $registros = mssql_query($sql);
      //  rollback($registros);		
        $result = array();
        
        $i = 0;
        while ($reg=mssql_fetch_assoc($registros)){
                $result[] = $reg;
        }
        $this->reset();
        return $result;
    }
    
    function query($sql, $ret = true){
        $this->_sql = $sql;
        $_SESSION['ParSQL'] =  $this->_sql;
        
        if ($ret){
            $registros = mssql_query($sql);
            rollback($registros);		
            $result = array();
            $i=0;            
            while ($reg=mssql_fetch_array($registros)){
                    $result[$i++] = $reg;
            }
            return $result;
        }
        else{
            mssql_query($sql);
        }
    }
    
    
    function delete($tabla,$where = false){
        if ($where) $where = " where ".$where;
        
        $sql = "delete ".$tabla.$where;
        mssql_query($sql);
               
    }
    
    function insert($tabla, $data){
        $id = $this->save($tabla, $data, 0);
        return $id;
    }
    function update($tabla, $data){
        $this->save($tabla, $data, 1);
    }
    
    function save($tabla, $data, $tipo = 0){
        
        if ($tipo == 0)        {
            $cols = "";
            $vals = "";
            foreach($data as $key=>$val){
                $cols .= $key.", ";
                $vals .= "'".$val."', ";
            }

            $cols = trim($cols,", ");
            $vals = trim($vals,", ");            
            $sql = "insert into ".$tabla." (".$cols.") values (".$vals.")";
        }
        else{
            $edits = "";
            $i = 0;
            $id_key = "";
            $id_val = "";
             foreach($data as $key=>$val){
                 if ($i == 0){
                     $id_key = $key;
                     $id_val = $val;
                 }else{
                    $edits .= $key."='".$val." ', ";                
                 }
                 $i++;
            }
            $edits = trim($edits,", ");
            
            $sql = "update ".$tabla." set ".$edits." where ".$id_key." = ".$id_val;
            

        }
        $this->_sql = $sql;
        $_SESSION['ParSQL'] =  $this->_sql;
        mssql_query($sql);
        
    }
    
    function last_query(){
        return $this->_sql;
    }
    
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
