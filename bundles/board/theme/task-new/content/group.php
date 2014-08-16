<?

<form class='XodEbnBfVK' data:group='{$group->id()}'>

    <h2 class='g-header' >Введите название группы</h2>
    
    widget("Infuso\\CMS\\Ui\\Widgets\\Textfield")
        ->fieldName("title")
        ->fieldName("text")
        ->style("margin-bottom", 10)
        ->exec();
        
    widget("Infuso\\CMS\\Ui\\Widgets\\Button")
        ->text("Создать")
        ->attr("type", "submit")
        ->exec();

</form>