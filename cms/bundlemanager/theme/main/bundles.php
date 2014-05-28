<? 

<div class='erjk605ygl' >
    
    foreach(service("bundle")->all() as $bundle) {
        <div class='bundle' >
            echo $bundle->path();
        </div>
    }
    
</div>