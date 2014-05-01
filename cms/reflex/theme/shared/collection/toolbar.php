<? 

$code = $collection->serialize();
<div class='qoi8w451jl c-toolbar' infuso:collection='{$code}' >

    <div class='a' >

    // Быстрый поиск
    widget("\\Infuso\\Cms\\UI\\Widgets\\Textfield")
        ->placeholder("Быстрый поиск")
        ->style("width", 120)
        ->fieldName("query")
        ->clearButton()
        ->exec();
      
    <button onclick='mod.fire("reflex/refresh");' >Обновить</button>
    
    // Режим отображения
    <select name='viewMode' >
        foreach($editor->viewModes() as $title => $template) {
            <option>{$title}</option>        
        }
    </select>
    
    <span class='spacer' ></span>    
    
    <button class='create' >Добавить</button>
    
    </div>
    
    <div class='with-selected' >
        <span class='selection-info' ></span>
        <button>Копировать</button>
        <button class='delete' >Удалить</button>        
    </div>

</div>