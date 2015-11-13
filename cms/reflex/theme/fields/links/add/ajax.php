<?

$collection = $field->items();
$virtual = $collection->virtual();
$editor = $virtual->plugin("editor");
$editor->applyQuickSearch($collection, $search);
$collection->limit(50);
$collection->page($page);

<div class='fJjAkO4k53' >

    exec("pager", array(
        "collection" => $collection,
    ));

    foreach($collection as $item) {
        $editUrl = $item->plugin("editor")->url();
        <div class='item' data:id='{$item->id()}' data:editUrl='{$editUrl}'>{$item->title()}</div>
    }
</div>