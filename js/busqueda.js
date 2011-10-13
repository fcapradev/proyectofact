/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    function _jscrollshow(selector){
        var pane = $(selector);
        $(selector).jScrollPane({showArrows: true , arrowScrollOnHover: true, stickToBottom: true});

        $(selector+' .jspArrowUp, '+selector+' .jspArrowDown').bind('mouseenter mouseleave', function() {
          $(this).toggleClass('over');
        });
        
        $_actual_scroll = pane.data('jsp');
        return $_actual_scroll;    
    }
    