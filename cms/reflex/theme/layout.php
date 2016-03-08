<? 

lib::modJS();
lib::modjsui();

add("left","../layout/menu");
add("top", "/reflex/shared/editor-head");

\admin::header();

<div class='x0h4tfwmhnn' >
    <div style='width:300px;' class='left' >
        region("left");
    </div>
    <div class='top' >
        region("top");
    </div>
    <div class='center' >
        region("center");
    </div>
</div>

\admin::footer();