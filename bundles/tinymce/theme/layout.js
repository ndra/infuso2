mod.init(".tinyMCE-qPe4r8Zov0h", function() {
    
    var $container = $(this);
    var editorParams = $.parseJSON($container.attr("data:params"));
    
    var myFileBrowser = function (field_name, url, type, win) {
		
            var $wnd = $.window({
                width: 800,
                height: 500,
                zIndex: 100000000000,
                call: {
                    cmd:"infuso/cms/reflex/controller/storage/getWindow",
                    editor: $container.attr("data:editor")
                }
            });
            
                            
            $wnd.on("reflex/storage/file", function(event) {
                $wnd.window("close");
                win.document.getElementById(field_name).value = event.filename;
            });
            
      
        return false;

    }
    
    var defaultTinyMCEparams = {
        selector:'.tinyMCE-qPe4r8Zov0h textarea', 
        language : 'ru',
        convert_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        file_browser_callback : myFileBrowser,
        image_advtab: true    
    }
    
    var InitTinyMCEparams = $.extend({},defaultTinyMCEparams,editorParams);
    
    mod.on("reflex/beforeSave", function(){ 
        tinymce.triggerSave();    
    });
    
    tinymce.init(InitTinyMCEparams);
});