<? 

<div class='aivh9q8neu' data:theme='{get_class($template->theme())}' data:template='{$template->name()}'>

    <div class='top' >
        <div>php</div>
        <div>js</div>
        <div>css</div>
    </div>
    <div class='center' >
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='php' data:lang='php' >{e($template->contents("php"))}</div>
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='js'  data:lang='javascript' >{e($template->contents("js"))}</div>
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='css'  data:lang='css' >{e($template->contents("css"))}</div>
    </div>

</div>