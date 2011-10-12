



function set_next(nombre_componente, max_length, tipo, forma){
    
    $("#DondeE").val(nombre_componente);
    $("#CantiE").val(max_length);
    $("#QuePoE").val(tipo);
 

  
    if (forma==1){        
        $("#"+nombre_componente).unbind('click');   
        $("input, div").unbind("click");
    } 
    else if (forma==2){
        
    }
    else if (forma==0){    
        $("#"+nombre_componente).unbind('click');   
        $("input, div").not("#+"+nombre_componente).click(function(){$("#"+nombre_componente).focus();})
    }

    
    $("#"+nombre_componente).attr("maxlength",max_length)
    $("#"+nombre_componente).focus();
    $("#"+nombre_componente).keydown(function(event){
        var k = event.keyCode;
        
        switch(tipo){
            case 0:
                if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 48) && (k <= 57)) || ((k >= 96) && (k <= 122)) || special_char(k))){	//ALFANUMERICO                
                    return false;
                }
                break;
            case 2:
                if(!((k == 32) || (k == 13) || ((k >= 65) && (k <= 90)) || ((k >= 96) && (k <= 122))  ||  special_char(k))){	//ALFABETICO                
                    return false;
                }
                
                break;
            case 1:
                if(!((k == 13) || ((k >= 48) && (k <= 57) || ((k >= 96) && (k <= 122))) || special_char(k))){		
                    return false;
                }
                break;
                
        }
        //event.stopPropagation();
        
    });
    //  backspace: 8,  delete: 46,  flechas : 37 39 , 
    function special_char(k){
        var rtn = false;
        if (k == 8 || k == 46|| k == 37|| k == 39)
            rtn = true;
        
        return rtn;
    }
    
    
    
    $("div").removeClass("active");
    $("#"+nombre_componente).parent().addClass("active");
    
}

function replace_button(id_div, str_func, img1, img2){
    $("#"+id_div+" button").removeAttr("onclick");
    $("#"+id_div+" button").unbind("click");
    
    eval('$("#'+id_div+' button").click(function(){'+str_func+'});');
    $("#"+id_div+" button img").attr("src", img1);
    $("#"+id_div+" button").removeAttr("onmouseover");
    $("#"+id_div+" button").removeAttr("onmouseout");

    $("#"+id_div).mouseout(function(){
         $(this).find("button img").attr("src",img1);
    });
    $("#"+id_div).mouseover(function(){
        $(this).find("button img").attr("src",img2);

    });

    
}
function replace_func(id_div, str_func){

     $("#"+id_div+" button").removeAttr("onclick");
     $("#"+id_div+" button").unbind("click");
    eval('$("#'+id_div+' button").click(function(){'+str_func+'});');   
    
}

function only_numbers(ev){
	
	var k = ev.keyCode;
	if(!((k == 13) || (k == 32) || (k == 42) || (k == 43) || (k == 44) || ((k >= 46) && (k <= 57)) || ((k >= 97) && (k <= 122)))){
		return false;
	}
        return true;
	

}

function php_urlencode (str) {
    
    str = escape(str);
    return str.replace(/[*+\/@]|%20/g,
        function (s) {
            switch (s) {
                case "*": s = "%2A"; break;
                case "+": s = "__mas__"; break;
                case "/": s = "%2F"; break;
                case "@": s = "%40"; break;
                case "%20": s = "+"; break;
            }
            return s;
        }
    );
}