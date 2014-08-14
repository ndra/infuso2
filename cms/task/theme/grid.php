<? 

exec("/reflex/layout/global");

<div class='x0kf50uz479' >

    foreach($collection->editors() as $editor) {
        
        $item = $editor->item();
        
        $class = "";
        if($item->data("completed")) {
            $class.= " completed";
        }
        
        <table class='list-item $class' data:id='{$editor->id()}'>
        
            <tr>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\button")
                        ->air()
                        ->icon("play")
                        ->attr("data:task", $editor->item()->id())
                        ->attr("title", "Выполнить сейчас")
                        ->addClass("exec")
                        ->exec();
                </td>
                <td>
                    exec("timeline", array(
                        "task" => $item,
                    ));
                </td>
                <td>
                    $title = $item->data("class")."::".$item->data("method");
                    <div class='title' >{$title}</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan='100' style='padding-top:0;' >
                    <div class='info' >
                        <span>Crontab: {$item->data("crontab")}</span>
                        <span>Запущено: {$item->pdata("called")->num()}</span>
                        <span>Следующий запуск: {$item->pdata("nextLaunch")->num()}</span>
                        <span>Итерация: {$item->data("iterator")}</span>
                    </div>
                </td>
            </tr>
            
        </table>
    }

</div>