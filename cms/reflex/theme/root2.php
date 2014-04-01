<? 

tmp::add("left","/reflex/layout/menu");

tmp::add("center","/reflex/collection",array(
    "collection" => $collection,
    "editor" => $editor,
));
tmp::exec("/reflex/layout");