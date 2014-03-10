<? 

<div class='qoi8w451jl' >

    // Быстрый поиск
    <input />  
      
    <button onclick='mod.fire("reflex/refresh");' >Обновить</button>
    
    // Режим отображения
    <select name='viewMode' >
        foreach($editor->viewModes() as $title => $template) {
            <option>{$title}</option>        
        }
    </select>
    
    <span class='spacer' ></span>    
    
    <button>Добавить</button>
    <button>Удалить</button>

</div>