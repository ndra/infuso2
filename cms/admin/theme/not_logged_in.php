<?

tmp::header();
tmp::reset();
lib::modjs();

<div class='lPRf9GbGAu' >

    <table>
        <tr>
            <td style='padding-right:50px;' >
                <h2>Вход по почте и паролю</h2>
                exec("normal");
            </td>
            <td style='padding-left:50px;border-left: 4px solid #ccc;' >
                <h2>Вход по техническому паролю</h2>
                exec("superadmin");
            </td>
        </tr>
    </table>

</div>

tmp::footer();
