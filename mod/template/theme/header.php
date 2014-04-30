<?

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        
        // Добавляем <title>
        $title = e(tmp::param("head/title"));
        tmp::head("<title>{$title}</title>");
        
        // Добавляем noindex
        /*if($obj->meta("noindex") || tmp::param("meta:noindex")) {
            $head.= "<meta name='ROBOTS' content='NOINDEX,NOFOLLOW' >\n";
        }

        // Добавляем меты
        foreach(array("keywords","description") as $name) {
            if($val = trim($obj->meta($name))) {
                $head.= "<meta name='{$name}' content='{$val}' />\n";
            }
        } */
        
        echo \tmp_delayed::add(array(
            "class" => "tmp",
            "method" => "headInsert",
            "priority" => 1000,
        ));
        
    </head>
<body>