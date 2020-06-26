<?

$group = $editor->item();

<div class='Q82FyMUhhH list-item' data:id='{$editor->id()}' >

    <table style='width:100%;table-layout:fixed;' >
        <tr>
            <td class='sort-handle' >
            </td>
            <td style='width:100%;' >
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
            </td>
            <td class='status' >
                echo $group->data("numberOfItems");
            </td>
            <td class='status' >
                echo $group->pdata("status");
            </td>
        </tr>
    </table>
    
    
</div>