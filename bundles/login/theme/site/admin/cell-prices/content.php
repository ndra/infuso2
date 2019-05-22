<?

$cell = $editor->item();

<div class='iFp4vhXrrS' data:id="{$cell->id()}" >

    <form>
        <table>
            <tr>
                <td>Цена закупки, USD</td>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->value($cell->data("pricePurchase"))
                        ->style("width", 60)
                        ->fieldName("pricePurchase")
                        ->exec();
                </td>
            </tr>
            <tr>
                <td>Розничная наценка, %</td>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->value($cell->data("retailMarkup"))
                        ->style("width", 60)
                        ->fieldName("retailMarkup")
                        ->exec();
                </td>
            </tr>
            <tr>
                <td>Оптовая наценка, %</td>
                <td>
                    widget("infuso\\cms\\ui\\widgets\\textfield")
                        ->value($cell->data("wholesaleMarkup"))
                        ->fieldName("wholesaleMarkup")
                        ->style("width", 60)
                        ->exec();
                </td>
            </tr>
        </table>
        
        widget("infuso\\cms\\ui\\widgets\\button")
            ->text("Сохранить")
            ->attr("type", "submit")
            ->exec();
        
    </form>
        
    <div style='flex: 1 0 auto;' class='ajax-container' >
        exec("ajax", array(
            "cell" => $cell,
        ));
    </div>
    
</div>
