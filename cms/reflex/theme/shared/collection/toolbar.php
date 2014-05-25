<? 

$code = $collection->serialize();
<div class='qoi8w451jl c-toolbar' infuso:collection='{$code}' >    

    <div class='a' >
    
        <h1 class='g-header' >{$collection->collection()->title()}</h1>

        // Быстрый поиск
        widget("\\Infuso\\Cms\\UI\\Widgets\\Textfield")
            ->placeholder("Быстрый поиск")
            ->style("width", 120)
            ->fieldName("query")
            ->clearButton()
            ->exec();
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("refresh")
            ->air()
            ->addClass(".refresh")
            ->exec();
                
        // Режим отображения
        <select name='viewMode' >
            foreach($collection->editor()->viewModes() as $title => $template) {
                <option>{$title}</option>        
            }
        </select>
        
        <span class='spacer' ></span>    
        
        $w = widget("infuso\\cms\\ui\\widgets\\button")
            ->icon("plus")
            ->text("Создать")
            ->air()
            ->addClass("create")
            ->exec();
    
    </div>
    
    <div class='with-selected' >
        <span class='hint' >Выделите один или несколько элементов для выполнения операций</span>
        <div class='functions' >
            <span class='selection-info' ></span>
            <span class='deselect' >Отменить</span>
            
            $w = widget("infuso\\cms\\ui\\widgets\\button")
                ->icon("edit")
                ->air()
                ->exec();
            
            $w = widget("infuso\\cms\\ui\\widgets\\button")
                ->icon("view")
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

</div>