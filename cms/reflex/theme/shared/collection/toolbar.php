<? 

$code = $collection->serialize();
<div class='qoi8w451jl c-toolbar' infuso:collection='{$code}' >

    <h1 class='g-header' >{$collection->collection()->title()}</h1>

    <div class='a' >

        // Быстрый поиск
        widget("\\Infuso\\Cms\\UI\\Widgets\\Textfield")
            ->placeholder("Быстрый поиск")
            ->style("width", 120)
            ->fieldName("query")
            ->clearButton()
            ->exec();
        
        <button class='refresh' >Обновить</button>
        
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
        <span class='hint' >Выделите один или несколько элементов для выполнения операций</span>
        <div class='functions' >
            <span class='selection-info' ></span>
            <span class='deselect' >Отменить</span>
            <button>Копировать</button>
            <button class='delete' >Удалить</button>    
        </div>
    </div>

</div>