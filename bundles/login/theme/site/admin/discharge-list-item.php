<?

$item = $editor->item();
<div class='list-item MyYHHlqtVg' data:id='{$editor->id()}' >
    <table>
        <tr>
            <td><a href='{$editor->url()}' >{$item->data("rate")}C</a></td>
            <td>{$item->data("voltage")} В</td>
            <td>{$item->data("capacity")} Ач</td>
            <td>{round($item->data("capacity") * $item->data("voltage"), 3)} Вт*ч</td>
            <td>{$item->data("cycles-70")}</td>
            <td>{$item->data("comment")}</td>
        </tr>
    </table>
</div>