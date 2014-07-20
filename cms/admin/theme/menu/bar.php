<?

<table id='raub2v07e-header'>
    <tr>    
        <td id='raub2v07e-title' >
            $title = param("title");
            echo "$_SERVER[HTTP_HOST] | $title";
        </td>
        
        // Добавляем в шапку стандартные блоки
        add("admin-header","info");
        add("admin-header","log");
        
        foreach(app()->tm()->block("admin-header")->templates() as $block) {
            <td id='raub2v07e-item' >
                $block->exec();
            </td>
        }
                
        <td style='font-weight:bold;'>
            $url = action("mod_about")->url();
            echo "Работает на <a href='$url' style='color:red;' >infuso</a>";
        </td>    
    </tr>
</table>
