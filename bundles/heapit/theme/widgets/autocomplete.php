<?
tmp::jq();
tmp::js($this->bundle()->path()."/res/js/jquery.autocomplete.min.js");
if(!$fieldId){
    $fieldId = $fieldName;   
}

if(!$hiddenFieldId){
    $hiddenFieldId = $fieldName."-hidden";       
}

<input type="text" id="{$fieldId}" value="{$title}"/>
<input type="hidden" name="{$fieldName}" id="{$hiddenFieldId}" value="{$value}">

tmp::script(<<<EOF

var options, a;
jQuery(function(){
    options = { 
        serviceUrl:'{$serviceUrl}',
        minChars:2,
        onSelect: function(value){ console.log(value);$('#{$hiddenFieldId}').val(value.data); } 
    };
    a = $('#{$fieldId}').autocomplete(options);
}); 

EOF
);


