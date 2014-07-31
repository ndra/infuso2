<?

<div class='MhpEuDh2NX' >

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

</div>