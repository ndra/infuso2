<?

admin::header();

<div class='UaDe2lQKdd' >

    <h1>Все классы модуля {$bundle->path()}</h1>
    <br>

    foreach(service("classmap")->classes() as $class) {
        $classBundle = service("classmap")->getClassBundle($class);
        if(trim($classBundle->path(), "/") == trim($bundle->path(), "/")) {
            
            $url = action("infuso\\cms\\bundlemanager\\controller\\doc", "class")."?class=".urlencode($class);
            <div class='item' ><a href='{$url}' >{$class}</a></div>
        }
    }
</div>

admin::footer();

