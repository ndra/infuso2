<? 

switch($path->ext()) {
    case "php":
        $lang = "php";
        break;
    case "js":
        $lang = "js";
        break;
    case "css":
        $lang = "css";
        break;
    default:
        $lang = "text";
        break;    
}


<div class='y1esl75wqs' data:path='{e($path)}' data:lang='{$lang}' >

    <div class='editor c-editor' id='x{\util::id()}' >
        echo e($path->data());
    </div>

</div>