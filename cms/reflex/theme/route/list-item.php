<?

$item = $editor->item();

<div class='rSxy24u7JT list-item' data:id='{$editor->id()}' >
	<table style='width:100%; table-layout: fixed;' >
        <tr>
            <td class='sort-handle' ></td>
            
            <td class='url' >{e($item->data("url"))}</td>
            
            <td class='action' >{$item->data("className")}::{$item->data("action")}()</td>
		</tr>
	</table>
                    
</div>