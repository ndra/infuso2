<?

<div class='K1CczQm2Ul' >

    <h2>Помочь друзьям:</h1>
    <div style='height:160px;margin-bottom:30px;' >
        /*exec("/board/shared/task-list", array(
            "status" => 1,
        )); */
        widget("infuso\\board\\widget\\tasklist")
            ->status(1)
            ->style("height", 150)
            ->exec();
    </div>

    <h2>Взять задачу из списка или <a href='#' >создать новую</a></h1>
    <div style='height:200px;margin-bottom:40px;' >
        widget("infuso\\board\\widget\\tasklist")
            ->status(0)
            ->style("height", 150)
            ->singleline()
            ->exec();
    </div>

</div>