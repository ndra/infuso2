<? 

$url = new Infuso\Core\Action($class,"root",array(
    "method" => $method,
));

<a href='{$url}' >
    echo $title;
    echo " (".$collection->count().")";
</a>