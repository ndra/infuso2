<? 

if(!$editor) {
    return;
}

if(is_a($editor->item(),"infuso\\cms\\reflex\\model\\constructor")) {
    return;
}

<div style='background: #666;color: white;' >
    exec("header");
    exec("menu");
</div>