<?

<div class='MhpEuDh2NX' >

    <div class='status-list-wrapper' >
        <div class='status-list' >
            <span>Бэклог</span>
            <span>В работе</span>
            <span>Проверить</span>
        </div>
    </div>
    
    <table style='width:270%;table-layout: fixed'>
        <tr>
            <td style='width:33.33%;' >
                widget("infuso\\board\\widget\\tasklist")
                    ->status(0)
                    ->toolbar()
                    ->style("padding", 20)
                    ->exec();
            </td>
            <td style='width:33.33%;' >
                widget("infuso\\board\\widget\\tasklist")
                    ->status(1)
                    ->toolbar()
                    ->style("padding", 20)
                    ->exec();
            </td>
            <td style='width:33.33%;' >
                widget("infuso\\board\\widget\\tasklist")
                    ->status(2)
                    ->toolbar()
                    ->style("padding", 20)
                    ->exec();
            </td>
        </tr>
    </table>

</div>