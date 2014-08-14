<?

<div class='LzMqPQSsHk' >
    <table>
        foreach($cart->items() as $item) {
            <tr>
                $preview = $item->item()->photos()->one()->pdata("photo")->preview(32,32);
                <td><a href='{$item->item()->url()}' ><img src='{$preview}' /></a></td>
                <td><a href='{$item->item()->url()}' >{$item->item()->title()}</a></td>
                <td>
                    <input value='{$item->data("quantity")}' />
                </td>
                <td>{$item->price()}</td>
            </tr>
        }
    </table>
</div>