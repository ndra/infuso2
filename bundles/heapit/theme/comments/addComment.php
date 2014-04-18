<? 
<div class="add-comment-rz7kt16k3a">
    <textarea class="comment-block" name="comment"></textarea>
    $w = new \Infuso\Cms\UI\Widgets\Button();
    $w->tag("button");
    $w->addClass("add-comment");
    $w->attr("data:userId", \user::active()->id());
    $w->attr("data:parent", $parent);
    $w->param("title", "Отправить");
    $w->exec();  
</div>