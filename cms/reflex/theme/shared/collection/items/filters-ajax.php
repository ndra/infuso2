<?

<div class='edJEHvd7pc' >
    $n = 0;
    foreach($collection->editor()->filters($collection->collection()) as $name => $filter) {
        <span data:filter='{$n}' >{$name}</span>
        $n++;
    }
</div>