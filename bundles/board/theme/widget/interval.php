<?

<div class='g9cJIui7ST' >

    <table class='g9cJIui7ST' >
        <tr>
            <td>от</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datepicker")
                    ->value('2014-11-13')
                    ->fieldName("a")
                    ->addClass("from")
                    ->exec();
            </td>
            <td>до</td>
            <td>
                widget("infuso\\cms\\ui\\widgets\\datepicker")
                    ->fieldName("b")
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
                "from" => \util::now()->date()->shiftDay(2)->stamp(),
                "to" => \util::now()->date()->shiftDay(2)->stamp(),
            ), "Месяц" => array(
                "from" => \util::now()->date(),
                "to" => \util::now()->date(),
            ),
        );
        
        foreach($intervals as $name => $interval) {
            <span class='interval' data:from='{$interval["from"]}' data:to='{$interval["to"]}' >{$name}</span>    
        }
        
    </div>

</div>

