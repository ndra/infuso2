<? 

<div class='dconz46d83'>

    $classes = service("classmap")->getClassesExtends("Infuso\\ActiveRecord\\Record");
    foreach($classes as  $class) {
        $item = new $class;
        <div>{$item->prefixedTableName()}</div>
    }

</div>