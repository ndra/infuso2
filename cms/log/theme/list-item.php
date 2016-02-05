<?

$item = $editor->item();

<div class='iBpprkr1AE list-item' data:id='{$editor->id()}' >

    <table>
        <tr>
            <td class='message' >{e($item->data('message'))}</td>
            <td class='user' >{e($item->pdata('user')->title())}</td>
            <td class='item' >
                if($item->data("index")) {
                    <a href='{$item->item()->plugin("editor")->url()}' >{$item->item()->title()}</a>
                }
            </td>
            <td class='type' >{e($item->data('type'))}</td>
            <td class='date' >{$item->pdata('datetime')->num()}</td>
        </tr>
    </table>
    
</div>