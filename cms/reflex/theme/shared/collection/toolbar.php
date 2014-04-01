<? 

$code = $collection->serialize();
<div class='qoi8w451jl' infuso:collection='{$code}' >

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
    
    <button>Удалить</button>

</div>