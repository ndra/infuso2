<? 

<div class='comments-ckvopjhgwq' data:parent='{$parent}'>

    exec("toolbar");
    
    <div class='items' >        
    </div>
    
    $loaderSrc = $this->bundle()->path()."/res/img/misc/loader.gif"; 
    <img class="loader" src="{$loaderSrc}">
    
    <div class='comment-container' >
        exec("addComment");
    </div>
    
</div>