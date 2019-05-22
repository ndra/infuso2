<?

<div class='xfyDOpWuHw' >

    <h2>Другие ячейки {$cell->vendor()->title()} </h2>

    <div class='items' >
        foreach($cell->vendor()->cells()->eq("publish", true) as $cell) {
            <a class='cell' href='{$cell->url()}' >
                $preview = $cell->pdata("img")->preview(100,100);
                <img src='{$preview}' />
                echo $cell->title();
            </a>
        }
    </div>
    
</div>
