<?

// Сериализуем коллекцию для ajax-запроса
$code = $collection->serialize();

<div class='cjoesz8swu c-items' infuso:collection='{$code}' >

    <div class='loader' >Загрузка...</div>
    <div class='ajax'>
        exec("ajax", array(
            "collection" => $collection,
        ));
    </div>
    
    <div class='drag-splash' >
        <div class='text' >Перетащите файлы сюда</div>
    </div>
 
</div>