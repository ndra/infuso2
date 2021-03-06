<?

$item = $editor->item();

<div class='a5mJFdwVMY list-item' data:id='{$editor->id()}' >

    <table style='width:100%; table-layout: fixed;' >
        <tr>
            <td class='sort-handle' ></td>
            <td style='width:100%;' >
                <a href='{$editor->url()}' >
                    $preview = $item->photos()->one()->pdata("photo")->preview(32,32)->crop();
                    <img src='{$preview}' align='absmiddle' />
                    echo $editor->title();
                </a> 
            </td>
            <td class='group' >
                $html = array();
                foreach($item->parents() as $group) {
                    $html[] = "<a href='{$group->plugin(editor)->url()}' >".$group->title()."</a>";
                }
                echo implode(" / ", $html);
            </td>
            <td class='status' >
                echo $item->pdata("status");
            </td>
        </tr>
    </table>
    
</div>