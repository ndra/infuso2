<?

<div class='MhpEuDh2NX' >

    <div class='status-list disable-pan' >
        <span>Бэклог</span>
        <span>В работе</span>
        <span>Проверить</span>
    </div>
     
    <table style='width:270%;table-layout: fixed; height: 100%;' >
        <tr>
            <td style='width:33.33%;' >
                <div style='height: 100%; overflow: auto;' >
                    <br/><br/>
                    widget("infuso\\board\\widget\\tasklist")
                        ->status(0)
                        ->toolbar()
                        ->style("padding", 20)
                        ->exec();
                </div>
            </td>
            <td style='width:33.33%;background: #ededed;' >
                widget("infuso\\board\\widget\\tasklist")
                    ->status(1)
                    ->style("padding", 20)
                    ->exec();
            </td>
            <td style='width:33.33%;' >
                <div style='height: 100%; overflow: auto;' >
                    widget("infuso\\board\\widget\\tasklist")
                        ->status(2)
                        ->toolbar()
                        ->style("padding", 20)
                        ->exec();
                </div>
            </td>
        </tr>
    </table>

</div>