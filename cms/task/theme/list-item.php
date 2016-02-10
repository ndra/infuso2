<? 

$item = $editor->item();

<div class='x0kf50uz479 list-item' data:id='{$editor->id()}'>

    <table>
    
        <tr>
            <td class='title' >
                echo $item->title();
            </td>
            <td class='iterator'>{$item->data("iterator")}</td>
            <td class='exec' data:task="{$item->id()}" >
            </td>
        </tr>
        
        /*<tr>
            <td></td>
            <td colspan='100' style='padding-top:0;' >
                <div class='info' >
                    <span>Crontab: {$item->data("crontab")}</span>
                    <span>Запущено: {$item->pdata("called")->num()}</span>
                    <span>Следующий запуск: {$item->pdata("nextLaunch")->num()}</span>
                    <span>Итерация: {$item->data("iterator")}</span>
                </div>
            </td>
        </tr> */
        
    </table>

</div>