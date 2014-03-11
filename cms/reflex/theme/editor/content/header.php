<? 

<div class='qm15c9g910' >
    <table style='width:100%;' >
        <tr>
            <td style='width:100%;' >
            
                foreach($editor->item()->parents() as $parent) {
                    $parent->addBehaviour("\\Infuso\\Cms\\Reflex\\Behaviour\\ActiveRecord");
                    <a href='{$parent->editor()->url()}' >{$parent->title()}</a>
                }
            
                <div class='title' >{$editor->title()}</div>
            </td>
            <td>
                tmp::exec("actions");
            </td>
        </tr>
    </table>
</div>