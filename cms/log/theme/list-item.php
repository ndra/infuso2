<?

$item = $editor->item();

<div class='iBpprkr1AE list-item' data:id='{$editor->id()}' >

    <table>
        <tr>
            <td class='type' >{e($item->data('type'))}</td>
            <td class='message' >{e($item->data('message'))}</td>
            <td class='date' >{$item->pdata('datetime')->num()}</td>
        </tr>
    </table>
    
</div>