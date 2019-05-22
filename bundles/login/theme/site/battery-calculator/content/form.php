<?

<form class='verCFCn5J1 c-toolbar' >

    <div>Ячейка</div>
    widget("cell-select")
        ->param("value", $battery->cell()->data("niceId"))
        ->param("name", "cell")
        ->exec();
        
    <br/>
        
    $w = widget("collapser-head");
    $w->id("b44UquBg1V");
    $w->begin();
        <span class='more' >Сравнение ячеек</span>
    $w->end();
    
    <br/>

    <table>
        <tr>
            <td style='padding-bottom: 10px;' class='small-label' >Последовательно</td>
            <td style='padding-bottom: 10px;' >
                exec("number", array(
                    "name" => "serial",
                    "value" => $battery->serial(),
                ));
            </td>
        </tr>
        <tr>
            <td style='padding-bottom: 10px;' class='small-label' >Параллельно</td>
            <td style='padding-bottom: 10px;' >
                exec("number", array(
                    "name" => "parallel",
                    "value" => $battery->parallel(),
                ));
            </td>
        </tr>
        <tr>
            <td class='small-label' >Всего элементов</td>
            <td class='total' >{$battery->count()}</td>
        </tr>        
    </table>
    
    <div class='additional' >
    
        <div style='margin-bottom: 10px;' >
            $id = \Infuso\Util\Util::id();
            $h = helper("<input type='checkbox' name='work' />");
            if($work) {
                $h->attr("checked", "true");
            }
            $h->attr("id", $id);
            $h->exec();
            <label for='{$id}' >С учетом работы</label>
        </div>

        // БМС
        <div style='margin-bottom: 10px;' >
            $values = array(0 => "Без учета БМС");
            foreach(\Infuso\EShop\Model\Group::get(3)->items() as $item) {
                $values[$item->id()] = $item->title()." (".round($item->price())." р.)";
            }
            $w = widget("infuso\\cms\\ui\\widgets\\select");
            $w->values($values);
            $w->fieldName("bms");
            $w->value($bms);
            $w->exec();
        </div>
        
        // Зарядки
        $values = array(0 => "Зарядка не нужна");
        foreach(\Infuso\EShop\Model\Group::get(4)->items() as $item) {
            $values[$item->id()] = $item->title()." (".round($item->price())." р.)";
        }
        $w = widget("infuso\\cms\\ui\\widgets\\select");
        $w->values($values);
        $w->fieldName("charger");
        $w->value($charger);
        $w->exec();
    
    </div>

</form>