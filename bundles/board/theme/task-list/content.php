<?

<div class='MhpEuDh2NX c-board' data:status='{$status}' >

    $tabs = array(
        "request",
        "backlog",
        "inprogress",
    );

    <div class='center' >
        <div class='roller' >
            foreach($tabs as $n => $tab) {
                <div class='tab' style='left: {$n * 100}%;' data:id='{$tab}' >
                    widget("infuso\\board\\widget\\tasklist")
                    ->status($tab)
                    ->exec();
                </div>
            }
        </div>
    </div>

</div>