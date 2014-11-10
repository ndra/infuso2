<?

<div class='MhpEuDh2NX c-board' >

    <div class='center' >
        <div class='roller' >
            <div class='tab' style='left: 0;' data:id='request' >
                widget("infuso\\board\\widget\\tasklist")
                ->status("request")
                ->exec();
            </div>
            <div class='tab' style='left: 100%;' data:id='backlog' >
                widget("infuso\\board\\widget\\tasklist")
                ->status("backlog")
                ->exec();
            </div>
            <div class='tab' style='left: 200%;' >
                widget("infuso\\board\\widget\\tasklist")
                ->status("inprogress")
                ->exec();
            </div>
            <div class='tab' style='left: 300%;' >
                echo 121212;
            </div>
        </div>
    </div>

</div>