<?

<div class='mUzXFn1O2y' >
    
    <h1>{$item->title()}</h1>
    
    <div>{$item->data("description")}</div>
    
    exec("/eshop/shared/buy");
    
    foreach($item->photos() as $photo) {
        <div>
            $preview = $photo->pdata("photo")->preview(200,200);
            <img src='{$preview}' />
        <div>
    }

</div>