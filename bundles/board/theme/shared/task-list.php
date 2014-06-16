<?

js($this->bundle()->path()."/res/js/sortable.min.js");
<div class="task-list-rpu80rt4m0" data:status='{$status}' >

    if($enbaleToolbar) {
        exec("toolbar");
    }
    
    <div class='ajax-container center' >
    </div>
    
    // Индикатор загрузки
    $loaderSrc = $this->bundle()->path()."/res/img/misc/loader.gif"; 
    <img class="loader" src="{$loaderSrc}" />
    
</div>