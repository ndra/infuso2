<?

<div class='CrQrvfv2DL' >

    $access = \Infuso\Board\Model\Access::all();
    <table>
        foreach($access as $item) {
            <tr>
                <td>{$item->id()}</td>
                <td>{$item->user()->title()}</td>
                <td>{$item->project()->title()}</td>
            </tr>
        }
    </table>
    
    <a href='{action("infuso\\board\\controller\\access", "new")}' >Предоставить доступ</a>
    
</div>