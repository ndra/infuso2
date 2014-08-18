<?

<div class='LzMqPQSsHk' >
    <table>
    
        <thead>
            <tr>
                <td></td>
                <td colspan='2' >Товар</td>
                <td>Цена</td>
                <td>Количество</td>
                <td>Сумма по строке</td>
            </tr>
        </thead>
    
        foreach($cart->items() as $item) {
            <tr>
                <td>
                    <input type='checkbox' />
                </td>
                $preview = $item->item()->photos()->one()->pdata("photo")->preview(32,32);
                <td><a href='{$item->item()->url()}' ><img src='{$preview}' /></a></td>
                <td><a href='{$item->item()->url()}' >{$item->item()->title()}</a></td>
                <td class='price' >{$item->itemPrice()}</td>
                <td class='quantity' >
                    <input value='{$item->data("quantity")}' />
                </td>
                <td class='price' >{$item->totalPrice()}</td>
                <td>
                    <input type='button' value='Удалить' class='delete' data:item='{$item->id()}' />
                </td>
            </tr>
        }
    </table>
</div>