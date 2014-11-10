<?

<div class='MhpEuDh2NX c-board' data:status='{$status}' >

    <div class='center' >
        <div class='roller' >
            $group = new \Infuso\Board\Controller\Pseudogroup("");
            foreach($group->subgroups() as $n => $sub) {
                <div class='tab' style='left: {$n * 100}%; display: none;' data:id='{$sub->id()}' >
                    widget("infuso\\board\\widget\\tasklist")
                    ->status($sub->id())
                    ->exec();
                </div>
            }
        </div>
    </div>

</div>