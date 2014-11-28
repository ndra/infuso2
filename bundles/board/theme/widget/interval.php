<?

<div class='g9cJIui7ST' >

    <table class='g9cJIui7ST' >
        <tr>
            <td>от</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datepicker")
                    ->value('2014-11-13')
                    ->fieldName($widget->param("nameFrom"))
                    ->addClass("from")
                    ->value($widget->param("valueFrom"))
                    ->exec();
            </td>
            <td>до</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datepicker")
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
                "from" => \util::now()->date()->stamp(),
                "to" => \util::now()->date()->stamp(),
            ), "Неделя" => array(
                "from" => \util::date(strtotime("last Monday"))->date()->stamp(),
                "to" => \util::date(strtotime("last Monday"))->date()->shiftDay(6)->stamp(),
            ), "Месяц" => array(
                "from" => \util::now()->day(1)->stamp(),
                "to" => \util::now()->day(1)->shiftMonth(1)->shiftDay(-1)->stamp(),
            ),
        );
        
        foreach($intervals as $name => $interval) {
            <span class='interval' data:from='{$interval["from"]}' data:to='{$interval["to"]}' >{$name}</span>    
        }
        
    </div>

</div>

