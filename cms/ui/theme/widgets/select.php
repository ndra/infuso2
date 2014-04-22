<? 

exec("../../shared");

$input = helper("<select />");
$input->attr("name", $widget->param("name"));
$input->attr("value", $widget->param("value"));

// Некоторые стили, например отступы, присваиваются контейнеру
// Все остальные, например цвет, присваиваются полю

foreach($widget->style() as $key => $val) {
    $input->style($key,$val);
}

foreach($widget->attr() as $key => $val) {
    $input->attr($key,$val);
}

$input->begin();

foreach($widget->param("values") as $key => $val) {

    if($key == $widget->param("value")) {
        <option selected value='{e($key)}' >{e($val)}</option>
    } else {
        <option value='{e($key)}' >{e($val)}</option>
    }
}

$input->end();