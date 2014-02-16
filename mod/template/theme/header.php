<?

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        
        //$action = $this->app()->action();
        //var_export($action->ar());

        // Добавляем <title>
        /*$title = $obj->meta("title");
        $title = strtr($title,array("<"=>"&lt;",">"=>"&gt;"));
        $head.= "<title>$title</title>\n";

        // Добавляем noindex
        if($obj->meta("noindex") || tmp::param("meta:noindex")) {
            $head.= "<meta name='ROBOTS' content='NOINDEX,NOFOLLOW' >\n";
        }

        // Добавляем меты
        foreach(array("keywords","description") as $name) {
            if($val = trim($obj->meta($name))) {
                $head.= "<meta name='{$name}' content='{$val}' />\n";
            }
        } */
        
        echo tmp_delayed::add(array(
            "class" => "tmp",
            "method" => "headInsert",
            "priority" => 1000,
        ));
        
    </head>
<body>