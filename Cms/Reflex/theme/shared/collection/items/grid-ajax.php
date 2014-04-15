<? 

<div class='x1arvpu0c38' >

    <div class='items' >
        foreach($collection->editors() as $editor) {
            <div class='list-item' data:id='{$editor->id()}' >
                <a href='{$editor->url()}' >
                    echo $editor->title();
                </a>                
            </div>
        }
    </div>
    
</div>