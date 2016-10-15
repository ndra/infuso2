<? 

$item = $editor->item();

<div class='x0kf50uz479 list-item' data:id='{$editor->id()}'>


    <div class='title' >{$item->title()}</div>
    
    // Ошибки
    $n = $item->plugin("log")->all()->eq("type", "error")->count();
    if($n > 0) {
        <div class='error' >Ошибки: {$n}</div>
    }
    
    <div class='crontab' >{$item->data("crontab")}</div>
    <div class='iterator' title='Итерация' >{$item->data("iterator")}</div>
    <div class='counter' title='Выполнено раз' >{$item->data("counter")}</div>
    <div class='exec' data:task="{$item->id()}" ></div>


</div>