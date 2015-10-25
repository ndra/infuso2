<? 

add("left","/reflex/layout/menu");
add("center","/reflex/shared/editor-head");

if(strtolower($editor->itemClass()) != "infuso\\cms\\reflex\\model\\route") {
    add("center","url");
}
add("center","content");
app()->tm("/reflex/layout")->exec();