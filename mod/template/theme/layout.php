<?

header();
lib::reset();
exec("header");
//\infuso\Template\Lib::components();

<table class='pwq3nk3agh' >
    <tr>
    
        // Левая часть
        <td class='left' >
            <div>
                region("left");
            </div>
        </td>
        
        // Центральная часть
        <td class='center' >
            region("center");
        </td>
        
        // Правая часть
        <td class='right' >
            <div>
                region("right");
            </div>
        </td>
    
    </tr>
</table>

//tmp::obj()->editor()->placeWidget();

exec("footer");

footer();