<? 

exec("../../shared");

$containerStyles = array(
    "margin",
    "margin-left",
    "margin-right",
    "margin-top",
    "margin-bottom",
);

$container = helper("<div class='s9nh9b1znm' >");
$container->begin();

    $input = helper("<textarea>");
    $input->attr("name", $widget->param("name"));
    $input->attr("placeholder", $widget->param("placeholder"));    
    
    // Некоторые стили, например отступы, присваиваются контейнеру
    // Все остальные, например цвет, присваиваются полю
       
    foreach($widget->style() as $key => $val) {
        if(in_array($key, $containerStyles)) {
            $container->style($key,$val);
        } else {
            $input->style($key,$val);
        }
    }
    
    foreach($widget->attr() as $key => $val) {
        $input->attr($key,$val);
    }
    
    $input->begin();
        echo e($widget->param("value"));
    $input->end();
    
    
$container->end();