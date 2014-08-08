<? 

<div class='yy0l0qu78b' >

    <div class='items' >
        foreach($collection->editors() as $editor) {
            
            $preview = $editor->image()->preview(200,200);
            
            <div class='item' >
            
                <img src='{$preview}' />
            
                <a href='{$editor->url()}' >
                    echo $editor->title();
                </a>                
            </div>
        }
    </div>
    
</div>