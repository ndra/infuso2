<? 

$code = $collection->serialize();
<div class='qoi8w451jl c-toolbar' infuso:collection='{$code}' >    

    <h1 class='g-header' >{$collection->collection()->title()}</h1>

    // Быстрый поиск
    <div style='display:none' >
        widget("\\Infuso\\Cms\\UI\\Widgets\\Textfield")
            ->placeholder("Быстрый поиск")
            ->style("width", 120)
            ->fieldName("query")
            ->clearButton()
            ->exec();
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("refresh")
            ->air()
            ->addClass("refresh")
            ->exec();
                
        // Режим отображения
        <select name='viewMode' >
            foreach($collection->editor()->viewModes() as $title => $template) {
                <option>{$title}</option>        
            }
        </select>
        
        <span class='spacer' ></span>
    </div>
    
    $w = widget("infuso\\cms\\ui\\widgets\\button")
        ->icon("plus")
        ->air()
        ->addClass("create")
        ->exec();
        
    <div class='with-selected' style='display: none;' >
    
        <span class='selection-info' ></span>
        <span class='deselect' >Отменить</span>
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("edit")
            ->air()
            ->addClass("edit")
            ->exec();
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("view")
            ->addClass("view")
            ->air()
            ->exec();
            
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("copy")
            ->air()
            ->exec();
            
        <span style='margin-right:20px;' ></span>
            
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("trash")
            ->addClass("delete")
            ->air()
            ->exec();
                   
    </div>
    
</div>