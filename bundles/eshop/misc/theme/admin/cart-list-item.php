<?

$group = $editor->item();
$cart = $editor->item();

<div class='yS4JEF3JKQ list-item' data:id='{$editor->id()}' >

    <table style='width:100%;table-layout:fixed;' >
        <tr>
            <td style='width:300px;' >
                exec("info", array(
                    "cart" => $cart,
                ));
            </td>
            <td>
                <table class='items'>
                    foreach($cart->items() as $item) {
                        <tr>
                        
                            $preview = $item->item()->photo()->preview(24,24)->crop();
                            <td><img src='{$preview}' /></td>
                            <td><a href='{$item->item()->plugin("editor")->url()}' >{$item->title()}</a></td>
                            <td>{$item->itemPrice()}</td>
                            <td>{$item->quantity()}</td>
                            <td>{$item->totalPrice()}</td>
                        </tr>
                    }
                </table>
            </td>   
        </tr>
    </table>
    
</div>