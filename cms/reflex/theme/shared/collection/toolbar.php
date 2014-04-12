<? 

$code = $collection->serialize();
<div class='qoi8w451jl c-toolbar' infuso:collection='{$code}' >

    // Быстрый поиск
    <input />  
      
    <button onclick='mod.fire("reflex/refresh");' >Обновить</button>
    
    // Режим отображения
    <select name='viewMode' onchange='mod.fire("reflex/refresh");' >
        foreach($editor->viewModes() as $title => $template) {
            <option>{$title}</option>        
        }
    </select>
    
    <span class='spacer' ></span>    
    
    <button class='create' >Добавить</button>
    
    <span class='selection-info' >
    </span>
    <button>Удалить</button>

</div>