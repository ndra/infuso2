<? 
<div class="add-comment-sldsjsct4f">
    <textarea class="comment-block" name="comment"></textarea>
    $w = new \Infuso\Cms\UI\Widgets\Button();
    $w->tag("button");
    $w->addClass("add-comment");
    $w->attr("data:userId", \user::active()->id());
    $w->attr("data:orgId", $org->id());
    $w->param("title", "Отправить");
    $w->exec();  
</div>