<? 

header();
lib::reset();
modjs();

lib::modJSUI();

exec("/heapit/shared/user-bar", array(
    "user" => app()->user(),
));

exec("menu");

<table class='layout-slpod3n5sa' >
    <tr>
        <td class='left' >
            <div style='height:100%;overflow:auto;' >           
                region("center");
            </div>
        </td>
        if(app()->tm()->block("right")->count()) {
            <td class='right' >
                <div style='height:100%;overflow:auto;' > 
                    region("right");
                </div>
            </td>
        }
    </tr>
</table>

footer();