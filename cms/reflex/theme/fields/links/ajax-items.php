<?

<div class='p7jBpDQmdS' >
    foreach($field->pvalue() as $item) {
        <div data:id='{$item->id()}' >
            echo $item->title();
            echo " ";
            <span class='remove' >x</span>
        </div>
    }
</div>