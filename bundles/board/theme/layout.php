<? 

header();
Lib::reset();
\Infuso\Template\Lib::jqui(); 

exec("/ui/shared");

modjs();
lib::modJSUI();

<div class='layout-slpod3n5sa' >

    <div class='top' >
        exec("header");
    </div>

    <div class='center' >
        region("center");
    </div>
    
    <div class='left' style='width:1px;' >
        <div class='collapse' title='Свернуть' ></div>
        <div class='container' ></div>
    </div>

</div>

footer();