<? 

\Infuso\Template\Lib::jqui(); 
$date = "";
$value = $widget->param("value");
if($value) {
    $date = \util::date($value)->date()->num();
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

$container = helper("<span class='datepicker-89z0fcfy09' >");
$container->begin();
    $input = helper("<input type='text' class='visibleField'/>");
    $input->attr("value", $date);
    $input->attr("placeholder", $placeholder);
    $input->style("width",80);
    $hiddenInput = helper("<input type='hidden' value='{$value}' class='hiddenField' name='{$name}'/>");
    
    if($widget->param("clearButton")) {
        $input->style("padding-right",30);
        <div class='button' ></div>
    }
    
    $input->exec();
    $hiddenInput->exec();
    $fastDayShifts = $widget->param("fastDayShifts");
    if($fastDayShifts){
        foreach($fastDayShifts as $date => $title){
            $tomorrow = \util::date($date)->num(); 
            <span class='fast-date' >$title<input type='hidden' class="fast-date-val" value='{$tomorrow}'></span>    
        }
    }     
    
         
$container->end();