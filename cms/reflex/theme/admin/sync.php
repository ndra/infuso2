<? 

lib::modjs();

admin::header("Синхронизация");
<div class='x0f1k9gbr5c' style='padding:40px;' >

    foreach($classes as $class) {
        
        $id = \Infuso\Util\Util::id();
        
        <div class='class class-{md5($class)}' data:class='{e($class)}' >
            <input type='checkbox' id='{$id}' checked />
            <label for='{$id}' >{$class}</label>
            <span class='log' ></span>
        </div>
    }
    
    <br>
    
    <div>
        <span class='select-all' >Выбрать все</span>
        <span class='deselect' >Очистить</span>
    </div>
    
    <br><br>
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->addClass("go")
        ->attr("value","Начать")
        ->exec();

</div>
admin::footer();