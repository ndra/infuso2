<? 

add("left","/reflex/layout/menu");

add("center","/reflex/shared/collection",array(
    "collection" => $collection,
    "editor" => $editor,
));

exec("/reflex/layout");