<?

<div class='LzMqPQSsHk' >

    if($cart->items()->count()) {

        <table>
        
            // Заголовок таблицы
            <thead>
                <tr>
                    <td></td>
                    <td colspan='2' >Товар</td>
                    <td>Цена</td>
                    <td>Количество</td>
                    <td>Сумма по строке</td>
                </tr>
            </thead>
        
            // Товары
            foreach($cart->items()->limit(0) as $item) {
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
            
            // Итого
            <tr>
                <td colspan='4' ></td>
                <td>Итого</td>
                <td>{$cart->total()}</td>
            </tr>
            
        </table>
        
        <table class='actions' >
            <tr>
                <td>
                    <a class='submit' href='{action("infuso\\eshop\\controller\\cart", "form")}' >Оформить заказ</a>
                </td>
                <td style='text-align: right;' >
                    <span class='clear' >Очистить корзину</span>
                </td>
            </tr>
        </table>
        
    } else {
        echo "Ваша корзина пуста";
    }
    
</div>