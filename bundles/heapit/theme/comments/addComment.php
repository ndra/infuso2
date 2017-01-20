<? 

<div class="add-comment-rz7kt16k3a">

    <textarea class="comment-block" name="comment"></textarea>
    
    $w = new \Infuso\Cms\UI\Widgets\Button();
    $w->tag("button");
    $w->addClass("add-comment");
    $w->attr("data:userId", app()->user()->id());
    $w->attr("data:parent", $parent);
    $w->style("margin-right", 0);
    $w->text("Отправить");
    $w->exec();  
</div>