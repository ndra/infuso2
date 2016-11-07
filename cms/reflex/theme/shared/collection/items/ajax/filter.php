<?

$filters = $collection->editor()->filters($collection->collectionWithoutRestrictions());
if(sizeof($filters) == 1) {
    return;
}

<div class='edJEHvd7pc' >
    $n = 0;
    foreach($filters as $name => $filter) {
        
        $class = $n == $collection->param("filter") ? "active" : "";
        
        $count = $filter->copy()->count();

        <span data:filter='{$n}' class='filter {$class}' >{$name} <span class='count' >{$count}</span></span>
        $n++;
    }
</div>