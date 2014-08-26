<? 

$item = $editor->item();

<div class='QAehUBY6Cw list-item' data:id='{$editor->id()}' >

    <table>
        <tr>
            <td class='to' >{e($item->data("to"))}</td>
            <td class='subject' >{e($item->data("subject"))}</td>
            <td class='message' >{e($item->data("message"))}</td>
            <td class='date' >{$item->pdata("sentDatetime")->left()}</td>
        </tr>
    </table>
    
</div>