<? 

admin::header();

$classes = service("classmap")->classes();

<div class='PLzFEdbQNb' >
    foreach(service("bundle")->all() as $bundle) {

        $bundlePath = (string) $bundle->classPath();
        ob_start();
        foreach($classes as $class) {
            $path = (string)service("classmap")->classPath($class);
            if (strpos($path, $bundlePath) === 0) {
                $inspector = new \Infuso\Core\Inspector($class);
                $todos = $inspector->todos();
                if(sizeof($todos)) {
                    foreach($todos as $method => $todo) {
                        <div><b>{$class}::{$method}()</b> $todo</div>
                    }
                }
            }
        }
        $html = ob_get_clean();
        
        if($html) {
            <h2>{$bundle->path()}</h2>            
            echo $html;
        }
        
    }
</div>

admin::footer();