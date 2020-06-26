<?

<div class='ja4uA4Vb7E' >

    <table style='table-layout: fixed; width: 700px;' >
        <tr>
            <td style='width:100px;' >
                $preview = $item->photo()->preview(64,64);
                <img src='{$preview}' />
            </td>
            <td style='width:100%;'>
                <a href='{$item->url()}' >{$item->title()}</a>
            </td>
            <td style='width:100px;' >
                echo $item->data("price")." р.";
            </td>
        </tr>
    </table>
    
</div>

