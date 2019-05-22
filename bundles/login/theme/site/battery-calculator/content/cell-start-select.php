<?

<div class='oVRFmDrfO4' >

    <div style='max-width: 800px; margin: 20px auto 30px;' >
        echo "Вы также можете создать батарею на основе любой из следующих ячеек (при условии, что данные ячейки есть в наличии): ";
    </div> 
    
    <div class='items' >
        $cells = \Infuso\Site\Model\batteryCalculator\Cell::all()->eq("publish", true);
        foreach($cells as $cell) {
            $battery = new \Infuso\Site\Battery(10,13,$cell->id());
            <a class='cell' href='{$battery->url()}' >
                $preview = $cell->pdata("img")->preview(100,100);
                <img src='{$preview}' />
                echo $cell->vendor()->title()." ".$cell->title();
            </a>
        }
    </div>
    
</div>