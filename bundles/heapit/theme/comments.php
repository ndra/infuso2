<? 

<div class='comments-ckvopjhgwq' data:parent='{$parent}'>

    <div class='g-toolbar'>
        widget("infuso\\cms\\ui\\widgets\\textfield")
        ->placeholder("Найти сообщение")
        ->exec();
    </div>
    
    <div class='items' >        
    </div>
    
    <div class='comment-container' >
        exec("addComment");
    </div>
    
</div>