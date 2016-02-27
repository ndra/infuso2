mod.init(".tinyMCE-qPe4r8Zov0h", function() {
    
    var $container = $(this);
    
    /**
    *  достает кастомные параметры для редактора
    **/
    var editorParams = $.parseJSON($container.attr("data:params"));
    
    /**
    *  ф-ция заменяет вызов стнадратного файлбраузера на наш
    **/
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

    };
    
    
    /**
    * дефолтные настройки редактора, включены все плагины, убит странный шортакт ctrl+s
    **/
    var defaultTinyMCEparams = {
        selector:'.tinyMCE-qPe4r8Zov0h textarea', 
        language : 'ru',
        convert_urls: false,
        menubar:false,
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        file_browser_callback : myFileBrowser,
        image_advtab: true,
        setup : function(editor) {
            //переделал решение отсюда http://wordpress.stackexchange.com/questions/167402/how-to-disable-tinymce-4-keyboard-shortcuts
            var orig_shortcuts_add = editor.shortcuts.add;
            editor.shortcuts.add = function(pattern, desc, cmdFunc, scope) {
                if(pattern == "Meta+S"){
                    cmdFunc = function () {};
                }
                return orig_shortcuts_add(pattern, desc, cmdFunc, scope);
            };
        }

    };
    
    /**
    * миксим дефолтные настройки со своими
    **/
    var InitTinyMCEparams = $.extend({},defaultTinyMCEparams,editorParams);
    
    /**
    * тини не сейвит в тектстарею сам по себе что либо, поэтому передсохраннем в бд вызваем сейвтригер 
    **/
    mod.on("reflex/beforeSave", function(){ 
        tinymce.triggerSave();    
    });
    
    
    /**
    * инициализируем тини
    **/
    tinymce.init(InitTinyMCEparams);
    
});