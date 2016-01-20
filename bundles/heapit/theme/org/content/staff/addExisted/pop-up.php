<? 
<div class="popup-ejmhyas19m">

    $w = new \Infuso\Cms\UI\Widgets\Combo();
    $w->fieldName("occId");
    $w->callParams(array(
        "cmd" => "/infuso/heapit/controller/widget/personalList",
        "orgId" => $org->id(),
    ));
    $w->exec();
    
    $w = new \Infuso\Cms\UI\Widgets\Button();
    $w->tag("button");
    $w->addClass("addItem-li16br8ida");
    $w->attr("data:orgid", $org->id());
    $w->text("Добавить");
    $w->exec();
    
    $w = new \Infuso\Cms\UI\Widgets\Button();
    $w->tag("button");
    $w->addClass("close-li16br8ida");
    $w->icon("/res/img/staff/delete.png");
    $w->exec();
    
</div>
