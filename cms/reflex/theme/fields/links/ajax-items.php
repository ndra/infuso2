<?

<div class='p7jBpDQmdS' >
    foreach($field->pvalue() as $item) {
        <div data:id='{$item->id()}' >
            <a href='{$item->plugin("editor")->url()}' >
                echo $item->title();
            </a>
            echo " ";
            <span class='remove' >x</span>
        </div>
    }
</div>