<?
tmp::jq();
tmp::js($this->bundle()->path()."/res/js/jquery.autocomplete.min.js");
if(!$fieldId){
    $fieldId = $fieldName;   
}
if(!$hiddenFieldName){
    $hiddenFieldName = $fieldName."ID";    
}

if(!$hiddenFieldId){
    $hiddenFieldId = $hiddenFieldName;       
}

<input type="text" name="{$fieldName}" id="{$fieldId}" />
<input type="hidden" name="{$hiddenFieldName}" id="{$hiddenFieldId}">

tmp::script(<<<EOF

var options, a;
jQuery(function(){
    options = { 
        serviceUrl:'{$serviceUrl}',
        minChars:2,
        onSelect: function(value){ $('#{$hiddenFieldId}').val(value.data); } 
    };
    a = $('#{$fieldId}').autocomplete(options);
}); 

EOF
);


