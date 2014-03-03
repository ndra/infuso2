<? 

<div class='x1arvpu0c38' >
    foreach($collection->editors() as $editor) {
        <div>
            <a href='{$editor->url()}' >
                echo $editor->title();
            </a>
        </div>
    }
</div>