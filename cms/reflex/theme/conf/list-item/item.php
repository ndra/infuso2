<?

$item = $editor->item();

<table class='tiy0dEnJg5'>
    <tr>
        if($level == 0) {
            <td class='sort-handle' ></td>
        } else {
            <td class='sort-handle-spacer' ></td>
        }
        
        $n = $item->children()->count();
        $class = $n > 0 ? "folder" : "title";
        
        <td class='title' >
            <div style='padding-left:{$level*20}px;' >
                <div class='{$class}' >
        			<a href='{$editor->url()}' >
        				echo $editor->title();
        				if($n) {
        				    echo " (".$n.")";
        				}
        			</a>
    			</div>
			</div>
		</td>
		
		<td style='width:100%;' >
		    echo \Infuso\Util\Util::str(e($editor->item()->data("value")))->ellipsis(300);
		</td>
		<td class='type' style='width:100px;' >
		    if($editor->item()->data("type")) {
		        echo $editor->item()->pdata("type")->typeName();
		    }
		</td>
	</tr>
</table>