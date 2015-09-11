mod.init(".f0rw8hlkvh", function() {
    
    var $container = $(this);
    var $textarea = $container.find("textarea");
    
    $container.find(".bold").click(function() {
        replaceSelection("<b>","</b>");
    });
    
    $container.find(".italic").click(function() {
        replaceSelection("<i>","</i>");
    });
    
    $container.find(".image").click(function() {
        
        var $wnd = $.window({
            width:800,
            height: 500,
            call: {
                cmd:"infuso/cms/reflex/controller/storage/getWindow",
                editor: $container.attr("data:editor")
            }
        });
        
        $wnd.on("reflex/storage/file", function(event) {
            $wnd.window("close");
            replaceSelection("<img src='" + event.filename + "' />", "");
        });
        
    });
    
    $container.find(".file").click(function() {
        
        var $wnd = $.window({
            width:800,
            height: 500,
            call: {
                cmd:"infuso/cms/reflex/controller/storage/getWindow",
                editor: $container.attr("data:editor")
            }
        });
        
        $wnd.on("reflex/storage/file", function(event) {
            $wnd.window("close");
            replaceSelection("<a href='" + event.filename + "' >", "</a>");
        });
        
    });
	
	$container.find(".href").click(function() {
        
       var href = prompt("Введите адрес ссылки");
       if(!href) return; 
	   replaceSelection("<a href='"+href+"'>","</a>");
        
    });
	
	$container.find(".tipograf").click(function() {
       var text = $textarea.val();
       function changeQuotes(text){
			var el = document.createElement("DIV");
			el.innerHTML = text;
			for(var i=0, l=el.childNodes.length; i<l; i++){
				if (el.childNodes[i].hasChildNodes() && el.childNodes.length>1){
					el.childNodes[i].innerHTML = changeQuotes(el.childNodes[i].innerHTML);
				}
				else{
					el.childNodes[i].textContent = el.childNodes[i].textContent.replace(/\x27/g, '\x22').replace(/(\w)\x22(\w)/g, '$1\x27$2').replace(/(^)\x22(\s)/g, '$1»$2').replace(/(^|\s|\()"/g, "$1«").replace(/"(\;|\!|\?|\:|\.|\,|$|\)|\s)/g, "»$1");
				}
			}
			return el.innerHTML;
		}
		
        $textarea.val(changeQuotes(text));
    });
    
    var replaceSelection = function(prefix, suffix) {
        var src = $textarea.val();
        var caret = getCaret();
        var a = src.substr(0,caret.start);
        var b = src.substr(caret.start,caret.end-caret.start);
        var c = src.substr(caret.end,src.length-caret.end);
        $textarea.val(a+prefix+b+suffix+c);
        setCaret((a+prefix).length,(a+prefix+b).length);
    }

    var getCaret = function() {
    
        var e = $textarea[0];  
    
        if(typeof(window.getSelection)==="function") {
        
            // Т.к. опера считает перевод строки двумя символами, учитываем это при опрееделнии начала и конца
            start = e.value.substr(0,e.selectionStart).replace(/\r\n/g, "\n").length;
            end = e.value.substr(0,e.selectionEnd).replace(/\r\n/g, "\n").length;
            
            return {start:start,end:end}
        }
            
            var range = document.selection.createRange();
            var start = 0;
            var end = 0;        
    
            if (range && range.parentElement() == e) {
            
                var len = e.value.length;
                var normalizedValue = e.value.replace(/\r\n/g, "\n");
                var nlen = normalizedValue.length;
    
                // Create a working TextRange that lives only in the input
                var textInputRange = e.createTextRange();
                textInputRange.moveToBookmark(range.getBookmark());
    
                // Check if the start and end of the selection are at the very end
                // of the input, since moveStart/moveEnd doesn't return what we want
                // in those cases
                var endRange = e.createTextRange();
                endRange.collapse(false);
    
                if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                    start = end = nlen;
                } else {
                    start = -textInputRange.moveStart("character", -len);
                    if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                        end = nlen;
                    } else {
                        end = -textInputRange.moveEnd("character", -len);
                    }
                }
            }
            
            return {start:start,end:end};
    
    }
     
    var setCaret = function(start,end) {
    
        var e = $textarea[0];  
        
        if(typeof(window.getSelection)==="function") {
        
            var fn = function(str,len) {
                str = str.split("\r");            
                var seek = 0;
                for(var i in str) {
                    var x = Math.min(str[i].length,len);
                    seek+= x;
                    len-= x;
                    if(len<=0)
                        return seek;
                        
                    seek++;
                }              
            }
        
            e.selectionStart = fn(e.value,start);
            e.selectionEnd = fn(e.value,end);    
            e.focus();
            
        } else {
        
            var selRange = e.createTextRange();
            selRange.collapse(true);
            selRange.moveStart('character', start);
            selRange.moveEnd('character', end-start);
            selRange.select();
            
        }
        
    }

});