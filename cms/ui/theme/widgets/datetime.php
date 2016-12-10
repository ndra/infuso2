<? 

lib::modJS(); 
Lib::jqui(); 

$timeEnabled = $widget->param("timeEnabled");

$name = $widget->param("name");
$value = $widget->param("value");

exec("../../shared");

$containerStyles = array(
    "margin",
    "margin-left",
    "margin-right",
    "margin-top",
    "margin-bottom",
);

$container = helper("<span class='datetime-hZ1EqT1dlO' >");
$container->begin();

    $input = helper("<input type='text' class='visibleField'/>");
    $input->attr("placeholder", $widget->param("placeholder") ?: "Дата");
    $input->style("width", 70);
    if($widget->param("disabled")) {
        $input->attr("disabled", "disabled");
    }
    $input->exec();
    
    if($timeEnabled) {
        $input = helper("<input type='text' class='timeField'/>");
        $input->attr("placeholder", "Время");
        $input->style("width", 40);
        if($widget->param("disabled")) {
            $input->attr("disabled", "disabled");
        }
        $input->exec();
    }

    <input type='hidden' style='background:gray;' value='{e($value)}' class='hiddenField' name='{e($name)}'/>
    
$container->end();