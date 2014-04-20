<? 

mod::coreJs();

admin::header("Синхронизация");
<div class='x0f1k9gbr5c' style='padding:40px;' >

    foreach($classes as $class) {
        <div class='class' >
            echo $class;
        </div>
    }
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->addClass("go")
        ->exec();

</div>
admin::footer();