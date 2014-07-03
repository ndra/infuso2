<?

admin::header();
lib::modjs();
lib::modjsui();
js("http://cdn.jsdelivr.net/ace/1.1.3/min/ace.js");

<div class='am2bKLBsQW' >
    $data = \file::get(app()->confPath()."/components.yml")->data();
    <div class='editor' id='x{\util::id()}' >
        echo e($data);
    </div>
    
    <br/>
    
    widget("infuso\\cms\\ui\\widgets\\button")
        ->text("Сохранить")
        ->addClass("save")
        ->exec();
    
</div>

admin::footer();