<?

<div class='MhpEuDh2NX' >

    <table style='height:100%;' >
        <tr>
            <td>
                widget("infuso\\board\\widget\\tasklist")
                    ->status(0)
                    ->addClass("task-list")
                    ->toolbar()
                    ->exec();
                    
                widget("infuso\\board\\widget\\tasklist")
                    ->status(1)
                    ->addClass("task-list")
                    ->style("background", "#ededed")
                    ->exec();
                    
                widget("infuso\\board\\widget\\tasklist")
                    ->status(2)
                    ->addClass("task-list")
                    ->toolbar()
                    ->exec();
            </td>
        </tr>
    </table>

</div>