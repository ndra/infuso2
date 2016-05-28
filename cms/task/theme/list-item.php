<? 

$item = $editor->item();

<div class='x0kf50uz479 list-item' data:id='{$editor->id()}'>


    <div class='title' >{$item->title()}</div>
    <div>{$item->data("crontab")}</div>
    <div class='iterator'>{$item->data("iterator")}</div>
    <div class='exec' data:task="{$item->id()}" ></div>


</div>