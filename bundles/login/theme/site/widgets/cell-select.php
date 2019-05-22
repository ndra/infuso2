<?

lib::modjsui();
exec("/site/layout/shared");
exec("/ui/shared");

<div class='K1ci1AAFuh' >

    <input type='hidden' name='{$name}' value='{$value}' />

    <div class='input-like' >
        <table class='value-table' >
            <tr><td>Выберите элемент</td></tr>
        </table>
    </div>

    <div class='dropdown' >
        <table class='items-table' >
            $items = \Infuso\Site\Model\BatteryCalculator\Cell::all()
                ->joinByField("vendor")
                ->asc("Infuso\\Site\\Model\\BatteryCalculator\\Vendor.title")
                ->asc("title", true)
                ->eq("publish", true);
            foreach($items as $cell) {
                <tr class='list-item' data:id='{$cell->data("niceId")}' >
                    <td><img src='{$cell->pdata("img")->preview(16,16)}' /></td>
                    <td>{$cell->vendor()->title()} {$cell->title()}</td>
                    <td>{$cell->priceSelling(999)->rurTxt()}</td>
                </tr>
            }
        </table>
    </div>
    
</div>