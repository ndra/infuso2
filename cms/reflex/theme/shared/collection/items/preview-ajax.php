<? 

exec("/reflex/layout/global");
exec("/ui/shared");

<div class='yy0l0qu78b' >

    $n = 0;
    <div class='items' >
        foreach($collection->editors() as $editor) {
            $preview = $editor->image()->preview(120,120);
            <div class='item list-item' data:id='{$editor->id()}' >
                <a href='{$editor->url()}' >
                    <img src='{$preview}' />
                    <div class='name' >{$editor->title()}</div>
                </a>
                <div class='select-handle' ></div>
            </div>
            $n++;
        }
        if($n == 0) {
            <div style='padding:5px; opacity: .5; font-style: italic;' >Нет элементов для отображения</div>
        }
    </div>
    
</div>