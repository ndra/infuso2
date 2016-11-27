<? 

admin::header();

<div class='PLzFEdbQNb' >
    foreach(service("bundle")->all() as $bundle) {
        <h2>{$bundle->path()}</h2>
        /*foreach($bundle->classpath()->dir() as $class) {
            $inspector = new \Infuso\Core\Inspector($class);
            <div>{var_export($inspector->todos())}</div>
        } */
        
        $classes = service("classmap")->classes();
        var_export($classes);
        
    }
</div>

admin::footer();