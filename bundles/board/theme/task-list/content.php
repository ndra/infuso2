<?

<div class='MhpEuDh2NX' >

    <div class='top tabs' >
        <div class='tab' >Бэклог</div>
        <div class='tab' >Выполняется</div>
        <div class='tab' >Проверить</div>
        <div class='tab' >Архив</div>
    </div>
    
    <div class='center' >
        <div class='roller' >
            <div class='tab' style='left: 0;' >
                widget("infuso\\board\\widget\\tasklist")
                ->status("backlog")
                ->exec();
            </div>
            <div class='tab' style='left: 100%;' >
                widget("infuso\\board\\widget\\tasklist")
                ->status("inprogress")
                ->exec();
            </div>
            <div class='tab' style='left: 200%;' >
                echo 121212;
            </div>
        </div>
    </div>

</div>