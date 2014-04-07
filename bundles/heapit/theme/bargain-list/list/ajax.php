<? 

$bargains = \Infuso\Heapit\Model\Bargain::all();
foreach($bargains as $bargain) {
    <div>
        echo $bargain->title();
    </div>
}