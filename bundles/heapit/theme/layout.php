<? 

header();
tmp::reset();
modjs();

lib::modJSUI();

exec("menu");
   
<table class='layout-slpod3n5sa' >
    <tr>
        <td class='left' >
            <div style='height:100%;overflow:auto;' >           
                region("center");
            </div>
        </td>
        <td class='right' >
            <div style='height:100%;overflow:auto;' > 
                region("right");
            </div>
        </td>
    </tr>
</table>

footer();