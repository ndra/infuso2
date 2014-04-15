<?

$item = $editor->item();
$route = \Infuso\Cms\Reflex\Model\Route::get($item);

<div class='ioy1gedqt1' data:editor='{$editor->id()}' >

    if($route->exists()) {
        <input />
    } else {
        <div class='' >
            echo "Сейчас используется адрес по умолчанию: {$item->url()}<br/>";
            <a href='#' class='create-object' >Изменить адрес</a>
        </div>
    }

</div>