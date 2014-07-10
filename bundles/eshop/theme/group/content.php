<?

<h1>{$group->title()}</h1>

foreach($group->items() as $item) {
    <div>
        <a href='{$item->url()}' >{$item->title()}</a>
    </div>
}