<? 

header();
tmp::reset();
modjs();

lib::modJSUI();

exec("header");
   
<table class='layout-slpod3n5sa' >
    <tr>
        <td class='left' >
            <div style='height:100%;overflow:auto;' >           
                region("center");
            </div>
        </td>
        if(tmp::block("right")->count()) {
            <td class='right' >
                <div style='height:100%;overflow:auto;' > 
                    region("right");
                </div>
            </td>
        }
    </tr>
</table>

<div class='task-container-slpod3n5sa' >
    <div class='close' >закрыть</div>
    <div class='ajax'></div>
</div>

footer();