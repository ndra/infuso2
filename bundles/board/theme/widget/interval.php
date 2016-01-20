<?

<div class='g9cJIui7ST' >

    <table class='g9cJIui7ST' >
        <tr>
            <td>от</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datetime")
                    ->fieldName($widget->param("nameFrom"))
                    ->addClass("from")
                    ->value($widget->param("valueFrom"))
                    ->exec();
            </td>
            <td>до</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datetime")
                    ->fieldName($widget->param("nameTo"))
                    ->value($widget->param("valueTo"))
                    ->addClass("to")
                    ->exec();
            </td>
        </tr>
    </table>
    
    <div class='quick-intervals' >
    
        $intervals = array(
            "Сегодня" => array(
                "from" => \util::now()->date(),
                "to" => \util::now()->date(),
            ), "Неделя" => array(
                "from" => \util::date(strtotime("last Monday"))->date(),
                "to" => \util::date(strtotime("last Monday"))->date()->shiftDay(6),
            ), "Месяц" => array(
                "from" => \util::now()->day(1)->date(),
                "to" => \util::now()->day(1)->shiftMonth(1)->shiftDay(-1)->date(),
            ),
        );
        
        foreach($intervals as $name => $interval) {
            <span class='interval' data:from='{$interval["from"]}' data:to='{$interval["to"]}' >{$name}</span>    
        }
        
    </div>

</div>

