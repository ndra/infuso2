<? 

lib::modjs();

admin::header("Синхронизация");
<div class='x0f1k9gbr5c' style='padding:40px;' >

    foreach($classes as $class) {
        <div class='class class-{md5($class)}' >
            echo $class;
            <span class='log' ></span>
        </div>
    }
    
    <br/>
    <br/>
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->addClass("go")
        ->attr("value","Начать")
        ->exec();

</div>
admin::footer();