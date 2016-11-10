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
		paste_as_text: true,
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern ",
			"removediv"
        ],
		style_formats: [
			{title: 'Headers', items: [
			  {title: 'Header 1', format: 'h1'},
			  {title: 'Header 2', format: 'h2'},
			  {title: 'Header 3', format: 'h3'},
			  {title: 'Header 4', format: 'h4'},
			  {title: 'Header 5', format: 'h5'},
			  {title: 'Header 6', format: 'h6'}
			 ]},
			 {title: 'Inline', items: [
			  {title: 'Bold', icon: 'bold', format: 'bold'},
			  {title: 'Italic', icon: 'italic', format: 'italic'},
			  {title: 'Underline', icon: 'underline', format: 'underline'},
			  {title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
			  {title: 'Superscript', icon: 'superscript', format: 'superscript'},
			  {title: 'Subscript', icon: 'subscript', format: 'subscript'},
			  {title: 'Code', icon: 'code', format: 'code'}
			 ]},
			 {title: 'Blocks', items: [
			  {title: 'Paragraph', format: 'p'},
			  {title: 'Blockquote', format: 'blockquote'},
			  {title: 'Div', format: 'div'},
			  {title: 'Pre', format: 'pre'}
			 ]},
			 {title: 'Alignment', items: [
			  {title: 'Left', icon: 'alignleft', format: 'alignleft'},
			  {title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
			  {title: 'Right', icon: 'alignright', format: 'alignright'},
			  {title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
			 ]},
			 {title: 'Маркеры списка', items: [
			  {title: 'Custom Bullet',selector: 'ul', classes: 'tiny-marker-line'},
			 ]}
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