<? 
<div class="popup-ejmhyas19m">
    $w = new \Infuso\Cms\UI\Widgets\Autocomplete();
    $w->fieldName("occId");
    $w->cmd("/infuso/heapit/controller/widget/personalList");
    $w->cmdParams(array("orgId"=>$org->id()));
    $w->exec();
    $w = new \Infuso\Heapit\Widget\Button();
    $w->tag("button");
    $w->addClass("addItem-li16br8ida");
    $w->attr("data:orgid", $org->id());
    $w->param("title", "Добавить");
    $w->exec();
    $w = new \Infuso\Heapit\Widget\Button();
    $w->tag("button");
    $w->addClass("close-li16br8ida");
    $w->param("icon", $this->bundle()->path()."/res/img/staff/delete.png");
    $w->exec();
</div>
