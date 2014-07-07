<?

<div class='K1CczQm2Ul' >

    <h1>Помочь друзьям:</h1>
    <div style='height:160px;margin-bottom:30px;' >
        exec("/board/shared/task-list", array(
            "status" => 1,
        ));
    </div>

    <h1>Взять задачу из списка или <a href='#' >создать новую</a></h1>
    <div style='height:200px;margin-bottom:40px;' >
        exec("/board/shared/task-list", array(
            "status" => 0,
        ));
    </div>

</div>