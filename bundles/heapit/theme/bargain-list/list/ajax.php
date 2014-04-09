<? 

$bargains = \Infuso\Heapit\Model\Bargain::all();
foreach($bargains as $bargain) {
    <div>
        <a href='{$bargain->url()}' >{$bargain->title()}</a>
    </div>
}