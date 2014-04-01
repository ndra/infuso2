<? 

<div class='x1arvpu0c38' >

    <div class='items' >
        foreach($collection->editors() as $editor) {
            <div class='item' >
                <a href='{$editor->url()}' >
                    echo $editor->title();
                </a>                
            </div>
        }
    </div>
    
</div>