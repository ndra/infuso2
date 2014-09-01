<?

// Сериализуем коллекцию для ajax-запроса
$code = $collection->serialize();

$class = "cjoesz8swu c-items";
if($collection->sortable()) {
    $class.= " sortable";
}

<div class='{$class}' infuso:collection='{$code}' >

    <div class='loader' >Загрузка...</div>
    <div class='ajax'></div>
    
    <div class='drag-splash' >
        <div class='text' >Перетащите файлы сюда</div>
    </div>
 
</div>