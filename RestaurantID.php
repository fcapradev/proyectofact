<?php


require("config/cnx.php");
require("util/utiles.php");


mssql_query("begin transaction",$conexion) or die("Error SQL begin trans");
$data = new sqldata();

/*************AJAX**************/
if (isset($_POST['formlogin'])){

   $result = $data->get_tabla("VENDEDORES"," CodVen = '".$_POST['usr']."'");
   
    if ($result){
        if (trim($result[0]['ClaVen']) == $_POST['pass']){
            if ($result[0]['ESENC'] != 1){
                echo "Permisos insuficientes";
            }
            else{
                echo "1";
            }
        }
        else{
            echo "Contraseña incorrecta";
        }
    }
    else{
        echo "Usuario incorrecto";
    }
    die();
}
/********************/
?>

<style>
    .texteca{
	background-color:transparent;
	color:#FFF;
	text-align:center;
	font-family: "TPro";
	margin-top:5px;
	font-size:12px;
	border:0px;
}
</style>

<script type="text/javascript">

    
    $("#identificacion, #login_admin").slideDown(200);
    $("#restaurant_base").slideUp(200);
    function select_password(){
        set_next("psw_f", 15,0,2);
        replace_func("LetEnt",'validar();');  
    }   

    function validar(){
        $.ajax({url: "RestaurantID.php",
                data: {usr: $("#usua").val(), 
                       pass: $("#psw_f").val(),
                       formlogin: 1},      
                type:"POST",
                success: function(data){
                    
                    if (data!="1"){
                        
                        jAlert(data, 'Debo Retail - Global Business Solution', function(r){
                            if (r){
                                set_next("usua", 15,1,2);
                                replace_func("LetEnt",'select_password();');     
                            }
                        });
                        
                          
                    }
                    else{
                        $(_request.selector).load(_request.load);
                    }
                    
                }
            });
    }
   $(document).ready(function(){
       $("#Teclado_Completo, #tec_num").show();
       
       //id del input, max_length, tipo
       set_next("usua", 15,1,2);
       
       //remplaza onclick del boton dentro del div (primer parametro) con funcion del segundo parametro
       replace_func("LetEnt",'select_password();');     
       
       $("#usua").keypress(function(e){
           if (e.keyCode==13 || e.keyCode==40 || e.keyCode==38){
               select_password();
           }
       });
       $("#psw_f").keypress(function(e){
           if (e.keyCode==13 || e.keyCode==40 || e.keyCode==38){
               validar();
           }
       });

   });
   
   
</script>



<div id="identificacion" style="display:block; position:absolute; top:70px; left:266px;">



<div id="titulo" style="position:absolute; top:10px; left:40px; font-family:'TPro'">Ingrese el c&oacute;digo de Operario</div>

<table width="239" height="108" align="center" background="tarjetas/fonind.png" style="background-color:transparent; background-repeat:no-repeat; ">
<tr>
<td valign="bottom">
    <table width="224" align="center">
   
    <tr>
    <td background="tarjetas/usua.png" style="background-repeat:no-repeat;" width="218" height="21">
        <div align="right" id="usrDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
            <input type="text" name="usua" id="usua" class="texteca" size="17" maxlength="8"  style="position:absolute; left:80px; outline-style:none; border-style:none;" />
        </div>
    </td>
    </tr>
    <tr>
    <td background="tarjetas/cont.png" style="background-repeat:no-repeat;">
        <div align="right" id="pswDiv" class="div-redondo" style="width:218px; height:22px; top:-5px; left:-2px; position:relative;">
            <input type="password" name="psw" id="psw_f" class="texteca" size="17" maxlength="8"  style="position:absolute; left:80px; outline-style:none; border-style:none;"/>
        </div>
    </td>
    </tr>

    </table>
</td>
</tr>
</table>


</div>

