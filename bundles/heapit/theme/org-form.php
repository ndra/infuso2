<? 

<div class='m69716bx32' >

    <table>
        <tr>
            <td>ФИО / Название</td>
            <td><input type='text' name='title' value='{e($org->data("title"))}' ></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='checkbox' name='org'  >
                <label>Организация</label>                
            </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td><input type='text' name='phone' ></td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td><input type='text' name='phone' ></td>
        </tr>
        <tr>
            <td>Электропочта</td>
            <td><input type='text' name='phone' ></td>
        </tr>
        <tr>
            <td>ICQ</td>
            <td><input type='text' name='phone' ></td>
        </tr>
        <tr>
            <td>ICQ</td>
            <td><input type='text' name='phone' ></td>
        </tr>        
        <tr>
            <td>Кто привел</td>
            <td>
                $w = new \Infuso\Heapit\Widget\Autocomplete;
                $w->fieldName("org");
                $w->serviceUrl("/infuso/heapit/controller/widget/orgList");
                $w->exec();
            </td>
        </tr> 
        <tr>
            <td></td>
            <td><input type='submit' value='Создать' /></td>
        </tr>
        
    </table>

</div>