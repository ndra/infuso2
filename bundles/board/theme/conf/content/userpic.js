$(function() {

    var form = $(".wi5cwqcx1q");
    form.find("input[type=file]").change(function(e) {
        mod.call({
            cmd:"infuso/board/controller/conf/userpic"
        }, function(html) {
            $(".wi5cwqcx1q").find(".ajax-container").html(html);
        }, {
            files: form
        });
    });

});