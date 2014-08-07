<? 

exec("/reflex/layout/global");

<div class='x1arvpu0c38' >

    <div class='items' >
        $n = 0;
        foreach($collection->editors() as $editor) {
            $editor->listItemTemplate()->exec();
            $n++;
        }
        
        if($n == 0) {
            <div style='padding:5px; opacity: .5; font-style: italic;' >Нет элементов для отображения</div>
        }
        
    </div>
    
</div>