<?

<div class='MhpEuDh2NX' >

    widget("infuso\\board\\widget\\tasklist")
        ->status(1)
        ->addClass("task-list")
        ->style("background", "#ededed")
        ->exec();

    widget("infuso\\board\\widget\\tasklist")
        ->status(0)
        ->addClass("task-list")
        ->style("border-bottom", "1px solid #ccc")
        ->toolbar()
        ->exec();
            
    /*widget("infuso\\board\\widget\\tasklist")
        ->status("check")
        ->addClass("task-list")
        ->toolbar()
        ->exec(); */
        
    <div class='right-toolbar' >
        exec("toolbar");
    </div>

</div>