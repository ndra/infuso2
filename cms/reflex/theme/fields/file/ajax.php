<? 

exec("/ui/shared");

<table class='rdwgX17MKs' >
    <tr>
        <td>
            <div class='preview-container' >
                <img src='{$file->preview(75,75)->fit()}' />
            </div>
        </td>
        <td>
            if($file->exists()) {
                <div class='value' >
                    <a href='{$file}' target="_blank" >{\Infuso\Util\Util::str($file->name())->ellipsis(60)}</a>
                </div>
                
                $size = \Infuso\Util\Units::formatBytes($file->size());
                $ext = $file->ext();
                $dimensions = $file->width() ? $file->width()."&times;".$file->height() : "";
                //<div class='ext' >{$ext}</div>
                <div class='size' >{$size}</div>
                <div class='dimensions' >{$dimensions}</div>
            } else {
                <div class='not-exists' >Файл не выбран</div>
            }
        </td>
    </tr>
</table>