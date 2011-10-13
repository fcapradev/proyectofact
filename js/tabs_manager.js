function tabmanager(){
    var panel = [];
    var _panel;
    var _no_tab = false;
    
    var panel_default = {};
    
    this.add = function(elem, def){    

        elem.active = true;
        panel.push(elem);
        
     /*   $(elem.tab).focus(function(){
            
        });*/
        
        if (def==true){
            panel_default = elem;
        }
        else{
            //el primer panel que se agrega es el default
            if (panel.length == 1){
                panel_default = panel[0];
            }                
        }        
        _panel = 0; 
    }
    
    this.remove = function(str){
        for(var i = 0 ; i < panel.length ; i++){
            if (str == panel[i]["tab"]){
                _panel = i;
                break;
            }
        }
        this.panel.splice(_panel,1);
        _panel = 0;        
    }
    
    this.set_tab = function(str){

        if (typeof str == 'undefined' || str=='default'){
            _panel = 1000;
            
        }
        else{
            for(var i = 0 ; i < panel.length ; i++){
                if (typeof(str)== "object"){
                    if (str.tab == panel[i]["tab"]){
                        _panel = i;
                    }
                }
                else{
                    if (str == panel[i]["tab"]){
                        _panel = i;
                    }
                }  
            }
            
        }
        this.get_tab();   

    }
    
    this.get_tab = function(){
        $(document).unbind("keyup");
        $(document).bind("keyup",keyup_bind);        
    }
    
    this.set_inactive = function(str){
        for(var i = 0 ; i < this.panel.length ; i++){
            if (str == this.panel[i]["tab"]){
                this.panel[i]["active"] = false;
                _panel = i;
            }
        }
    }
    
    this.set_active = function(str, go){
        for(var i = 0 ; i < this.panel.length ; i++){
  
            if (typeof(str)== "object"){
                if (str.tab == panel[i]["tab"]){
                    _panel = i;
                }
            }
            else{
                if (str == panel[i]["tab"]){
                    _panel = i;
                }
            }            
            
        }
        
        if (typeof go == 'undefined' || go == false){
            
        }
        else{
            set_tab(str);
        }        
    }

    function keyup_bind (ev){
                // cambia con tabulador pero si esta activado
             if(ev.keyCode == 9 && !_no_tab ){
                 ev.preventDefault(); 
        

                _panel++;
                if (_panel >= panel.length) _panel = 0;                


                
                $(document).unbind("keyup");
                $(document).bind("keyup",keyup_bind);
                 
             }
             
             //se evalua si se trae el panel default   
             var panel_tmp = _panel == 1000 ? panel_default : panel[_panel] ;
             
            for (atributo in panel_tmp) {
                
                if (atributo!="tab"){
                    var code = 0;
                    switch(atributo){
                        case "tab":code = 0;break;
                        case "up":code = 38;break;
                        case "down":code = 40;break;
                        case "left":code = 37;break;
                        case "right":code = 39;break;
                        case "intro":code = 13;break;
                        case "space":code = 32;break;
                        case "del":code = 46;break;
                        case "insert":code = 45;break;
                        case "ctrl":code = 17;break;
                        case "esc":code = 27;break;
                        default:break;
                    }                  
                    if(ev.keyCode==code){
                        eval(panel[_panel][atributo]);
                    }                
                   
                }
            }    
    }
    
    this.not_tab = function(){
        _no_tab = true;
    }
    
    this.reset = function(){
        $(document).unbind("keyup");
    }
}


