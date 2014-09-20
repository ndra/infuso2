<?

<form>
    <input name='query' value='{e($query)}' />
    <input value='Найти' type='submit' value='Найти' />
</form>

$results = service("search")->query($query);

foreach($results as $result) {
    <div>
        <a href='{$result->item()->url()}' >{$result->item()->title()}</a>
    </div>
}