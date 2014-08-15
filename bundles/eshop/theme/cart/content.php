<?

<div class='LzMqPQSsHk' >
    <table>
        foreach($cart->items() as $item) {
            <tr>
                <td>
                    <input type='checkbox' />
                </td>
                $preview = $item->item()->photos()->one()->pdata("photo")->preview(32,32);
                <td><a href='{$item->item()->url()}' ><img src='{$preview}' /></a></td>
                <td><a href='{$item->item()->url()}' >{$item->item()->title()}</a></td>
                <td class='quantity' >
                    <input value='{$item->data("quantity")}' />
                </td>
                <td class='price' >{$item->itemPrice()}</td>
                <td class='price' >{$item->totalPrice()}</td>
            </tr>
        }
    </table>
</div>