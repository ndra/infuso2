<? 

<div class='yy0l0qu78b' >

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