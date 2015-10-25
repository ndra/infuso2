<? 

lib::jq();
lib::modjs();
lib::modjsui();  

$editor = get_class($editor).":".$editor->itemId();
<div class='x0jgagz44k7' infuso:editor='{$editor}' >

    <div class='top' >
        exec("toolbar");
    </div>

    <div class='files center' >
        // ajax here
    </div>
    
    <div class='drag-splash' >
        <div class='text' >Перетащите файлы сюда</div>
    </div>
    
</div>