mod.init(".b-datetime-field-DDS1aSAThE", function(){
    
    var $container = $(this);
    
    var $input = $container.find(".x8zq1fi07zr > input");
    
    var $datepickerCont = $container.find(".datepicker-89z0fcfy09").height(0); 
    
    var $datepicker = $container.find(".datepicker-89z0fcfy09 input[type='text']");
    
    //$datepicker.css({height: 0, margin: 0, padding: 0,border: "none", lineHeight: 0, fontSize: "0px"});
    
    $input.click(function(){
        $datepicker.datepicker('show');
    });
});