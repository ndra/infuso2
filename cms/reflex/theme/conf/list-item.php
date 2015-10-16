<?

$item = $editor->item();

<div class='ffm94FCxk2 list-item' data:id='{$editor->id()}' >
	<table style='width:100%; table-layout: fixed;' >
        <tr>
            <td class='sort-handle' ></td>
            
            $n = $item->children()->count();
            $class = $n > 0 ? "title folder" : "title";
            
            
            <td style='width:200px;' class='{$class}' >
				<a href='{$editor->url()}' >
					echo $editor->title();
					if($n) {
					    echo " (".$n.")";
					}
				</a>
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
                    
</div>