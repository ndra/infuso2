<?

<div class='M3dHuHODq9' >

    <h2>Ячейки с химией {$chemistry->title()} </h2>

    <div class='items' >
        foreach($chemistry->cells()->eq("publish", true) as $cell) {
            <a class='cell' href='{$cell->url()}' >
                $preview = $cell->pdata("img")->preview(100,100);
                <img src='{$preview}' />
                echo $cell->title();
            </a>
        }
    </div>
    
</div>
