<?

$filters = $collection->editor()->filters($collection->collection());
if(sizeof($filters) == 1) {
    return;
}

<div class='edJEHvd7pc' >
    $n = 0;
    foreach($filters as $name => $filter) {
        
        $class = $n == $collection->param("filter") ? "active" : "";
        
        <span data:filter='{$n}' class='{$class}' >{$name}</span>
        $n++;
    }
</div>