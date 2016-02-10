<?

<div class='MSZIreHebX' >

    foreach($task->plugin("log")->all()->geq("datetime", \util::now()->shiftDay(-1)) as $log) {
        $left = 100 - (\util::now()->stamp() - $log->pdata("datetime")->stamp()) / 3600 / 24 * 100;
        <div class='run' style='left:{$left}%;' ></div>
    }

</div>