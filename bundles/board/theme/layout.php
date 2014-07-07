<? 

header();
tmp::reset();
modjs();
exec("/ui/shared");

lib::modJSUI();

<div class='layout-slpod3n5sa' >

    <div class='top' >
        exec("header");
    </div>

    <div class='center' >
        region("center");
    </div>
    
    if(tmp::block("right")->count()) {
        <div class='right' >
            region("right");
        </div>
    }
    
</div>

<div class='task-container-slpod3n5sa' style='display:none;' >
    <div style='width:800px;margin: 0 auto; background: white;' class='ajax' >
    </div>
</div>

footer();