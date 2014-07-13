<?

<div class='K1CczQm2Ul' >

    <h2>Выполняется:</h1>
    <div style='margin-bottom:30px;' >
        /*exec("/board/shared/task-list", array(
            "status" => 1,
        )); */
        widget("infuso\\board\\widget\\tasklist")
            ->status(1)
            //->style("height", 150)
            //->singleline()
            ->exec();
    </div>

    <h2>Взять задачу из списка или <a href='#' >создать новую</a></h1>
    <div style='margin-bottom:40px;' >
        widget("infuso\\board\\widget\\tasklist")
            ->status(0)
            //->style("height", 150)
            //->singleline()
            ->exec();
    </div>
    
    <h2>За сегодня</h1>
    exec("timeline");

</div>