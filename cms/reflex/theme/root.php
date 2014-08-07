<? 

add("left","/reflex/layout/menu");

add("center","/reflex/shared/collection", array (
    "collection" => $collection,
    "layout" => true,
));

exec("/reflex/layout");