<? 

exec("/reflex/layout/global");

<div class='x1arvpu0c38' >

    <div class='items' >
        foreach($collection->editors() as $editor) {
            /*exec("item", array(
                "editor" => $editor,
            )); */
            
            $editor->listItemTemplate()->exec();
            
        }
    </div>
    
</div>