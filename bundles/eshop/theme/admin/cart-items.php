<?

<div class='AVhADISoZy' >
    $cart = $editor->item();
    <table>
        foreach($cart->items() as $item) {
            <tr>
                <td><a href='{$item->plugin("editor")->url()}' >{$item->item()->title()}</a></td>
                <td>{$item->data("quantity")}</td>
            </tr>
        }
    </table>
</div>