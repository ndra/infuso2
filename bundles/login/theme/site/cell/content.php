<?

<div class='nC6S4HomAZ' >
    <h1>Ячейка {$cell->vendor()->title()} {$cell->size()->title()} {$cell->title()} {$cell->nominalCapacity() * 1000}mAh {$cell->maxContinuousCurrentDischarge()}A</h1>
    
    <div class='top' >
        <div class='a' >
            $preview = $cell->pdata("img")->preview(300,300);
            <img src='{$preview}' />
        </div>
        <div class='b' >
            exec("specs");
        </div>
    </div>
    
    echo $cell->pdata("text");
    
    echo $cell->pdata("descr");
    
    exec("batteries");
    exec("graph");
    
    exec("other-vendor-cells");
    
<div>

