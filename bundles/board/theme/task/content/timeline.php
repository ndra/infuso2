<? 

<div class='hhraxv0jki' >

    foreach($task->timeLog()->limit(0) as $item) {
        <div>
            echo $item->pdata("begin")->text();
            echo " - ";
            echo $item->pdata("end")->text();
        </div>
    }

</div>