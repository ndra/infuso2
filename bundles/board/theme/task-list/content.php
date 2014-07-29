<?

<div class='MhpEuDh2NX' >

    <div class='list-wrapper' >
        <h2>Бэклог</h2>
        widget("infuso\\board\\widget\\tasklist")
            ->status(0)
            ->toolbar()
            ->exec();
    </div>
    <div class='list-wrapper' style='background: #ededed;' >
        <h2>В работе</h2>
        widget("infuso\\board\\widget\\tasklist")
            ->status(1)
            ->exec();
    </div>
    <div class='list-wrapper' >
        <h2>Проверить</h2>
        widget("infuso\\board\\widget\\tasklist")
            ->status(2)
            ->toolbar()
            ->exec();
    </div>

</div>