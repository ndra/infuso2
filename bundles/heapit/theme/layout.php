<? 

tmp::header();
tmp::reset();
\mod::coreJS();

$bundlePath = \Infuso\Cms\Reflex\Editor::inspector()->bundle()->path();
tmp::js($bundlePath."/res/js/window.js");
    
<div class='slpod3n5sa' >

    tmp::exec("menu");
    tmp::region("center");

</div>

tmp::footer();