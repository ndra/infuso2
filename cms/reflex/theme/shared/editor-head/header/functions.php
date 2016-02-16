<? 

<table class='pn2dSKDht6' >

    <tr>
        <td style='width:100%;' >

            $w = widget("infuso\\cms\\ui\\widgets\\button")
                ->air()
                ->text("Просмотреть")
                ->addClass("view")
                ->attr("data:url", $editor->item()->url())
                ->style("color", "white")
                ->exec();
        </td>
        <td>
                
            $w = widget("infuso\\cms\\ui\\widgets\\button")
                ->icon("trash")
                ->air()
                ->attr("data:id", $editor->id())
                ->addClass("delete")
                ->exec();
                
        </td>
    </tr>
        
</table>