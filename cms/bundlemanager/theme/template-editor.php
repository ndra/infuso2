<? 

<div class='aivh9q8neu' data:theme='{get_class($template->theme())}' data:template='{$template->relName()}'>

    <table class='top' >
        <tr>
            <td class='tabs' >
                <div>php</div>
                <div>js</div>
                <div>css</div>
            </td>
            <td class='functions' >
                echo "id";
            </td>
        </tr>
    </table>
        
        <div style='float:right;' >id</div>
    </table>
    <div class='center' >
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='php' data:lang='php' >{e($template->contents("php"))}</div>
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='js'  data:lang='javascript' >{e($template->contents("js"))}</div>
        <div id='x{\util::id()}' class='editor layout-change-listener' data:type='css'  data:lang='css' >{e($template->contents("css"))}</div>
    </div>

</div>