<? 

<div class='aivh9q8neu' data:theme='{get_class($template->theme())}' data:template='{$template->name()}'>

    <div class='top' >
        <div>php</div>
        <div>js</div>
        <div>css</div>
    </div>
    <div class='center' >
        <div id='x{\util::id()}' class='editor' data:type='php' >{e($template->contents("php"))}</div>
        <div id='x{\util::id()}' class='editor' data:type='js' >{e($template->contents("js"))}</div>
        <div id='x{\util::id()}' class='editor' data:type='css' >{e($template->contents("css"))}</div>
    </div>

</div>