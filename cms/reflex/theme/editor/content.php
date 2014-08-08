<? 

exec("/reflex/shared/editor-head");

foreach($editor->layout() as $item) {
    if($item === "form") {
        exec("fields");    
    } elseif(preg_match("/^collection:(.*)/",$item,$matches)) {
        $method = $matches[1];
        $collection = new \Infuso\Cms\Reflex\Collection(get_class($editor), $method, $editor->itemId());
        exec("/reflex/shared/collection", array(
            "collection" => $collection,
        ));
    } elseif(preg_match("/^tmp:(.*)/",$item,$matches)) {
        $tmp = $matches[1];
        exec($tmp);
    } else {
        echo $item;
    }

}