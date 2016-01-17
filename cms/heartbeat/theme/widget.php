<?

<div class='kjicTBX3F8' >

    $event = new \Infuso\Cms\Heartbeat\Event();
    $event->fire();
    
    $errors = 0;
    $warnings = 0;
    
    foreach($event->getMessages() as $message) {
        
        if($message["type"] == \Infuso\Cms\Heartbeat\Event::TYPE_ERROR) {
            $errors ++;
        }
        
        if($message["type"] == \Infuso\Cms\Heartbeat\Event::TYPE_WARNING) {
            $warnings++;
        }
        
    }
    
    $url = action(\Infuso\CMS\Heartbeat\Controller::inspector()->classname())->url();
    
    if($errors > 0) {
        <a href='{$url}' class='error' >Ошибки: {$errors}</a>
    }
    if($warnings > 0) {
        <a href='{$url}' class='warning' >Предупреждения: {$warnings}</a>
    }

</div>