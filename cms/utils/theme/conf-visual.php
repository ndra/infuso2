<?

admin::header();
lib::modjs();
lib::modjsui();

<div class='Ojzq6i8KW9' >

    <a href='{action("infuso\cms\utils\conf")}' >Текстом</a>
    <br/>
    <br/>

    // Собираем описание настроек    
    $descr = array();
    $classes = service("classmap")->classes("infuso\\core\\component");
    foreach($classes as $class) {
        $descr = array_merge_recursive($descr, $class::confDescription());
    }
    
    exec("branch", array(
        "data" => $descr,
        "parents" => array(),
    ));
    
</div>

admin::footer();