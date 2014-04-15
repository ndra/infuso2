<? 

admin::header();

<div class='w7ywyb7f5' >

    <h1>Состояние системы</h1>
    
    $event = new \Infuso\Cms\Utils\Heartbeat\Event("Infuso/Admin/Heartbeat");
    $event->fire();
    
    <table>
        foreach($event->getMessages() as $record) {        
        
            $class = "message";                
            if($message["type"] == Infuso\Cms\Utils\Heartbeat\Event::TYPE_ERROR) {
                $class = "error";
            }
        
            <tr class='{$class}' >        
                <td class='class' >{$record['class']}</td>
                <td class='method' >{$record[method]}</td>
                <td>
                    echo $record["message"];                    
                </td>                
            </tr>    
        }
    </table>

</div>

admin::footer();