<? 

\Infuso\Template\Lib::jqui(); 

$date = "";
$value = $widget->param("value");
if($value) {
    list($date, $time) = explode(" ", $value);
    $date = \util::date($date)->date()->num();
    $datetime = $date." ".$time;
    $msqlDate = (string)\util::date($date)->date();
    $value = $msqlDate." ".$time;
}

$placeholder = "Указать дату";
if($widget->param("placeholder")){
    $placeholder = $widget->param("placeholder");   
}

$name = $widget->param("name");

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
    $input->attr("value", $datetime);
    $input->attr("placeholder", $placeholder);
    $input->style("width",120);

    <input type='hidden' value='{e($value)}' class='hiddenField' name='{e($name)}'/>
    <input type='hidden' value='{e($msqlDate)}' class='hiddenFieldDate' name='{e($name)}_date'/>
    <input type='hidden' value='{e($time)}' class='hiddenFieldTime' name='{e($name)}_time'/>
    
    $input->exec();
    
    
$container->end();