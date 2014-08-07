<?

<div class='Q82FyMUhhH list-item' data:id='{$editor->id()}' >
    <div>
        <a href='{$editor->url()}' >
            echo $editor->title();
        </a> 
    </div>
    foreach($editor->subgroups() as $subgroup) {
        <a class='subgroup' href='{$subgroup->plugin("editor")->url()}' >
            echo $subgroup->title();
        </a> 
    }
    
    
</div>