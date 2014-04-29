<?

js($this->bundle()->path()."/res/js/sortable.min.js");
$uID = "uid-".\util::id();
<div class="task-list-rpu80rt4m0 $uID" >
    if($enbaleToolbar){
        exec("toolbar");
    }
    //echo "Здесь будет список задач";
    <div class='ajax-container' >
       // exec("ajax");
    </div>
    
    $loaderSrc = $this->bundle()->path()."/res/img/misc/loader.gif"; 
    <img class="loader" src="{$loaderSrc}">
</div>