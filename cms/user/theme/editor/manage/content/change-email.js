$(function() {

    var container = $(".jgaz87ie6e");

    container.find(".change").click(function() {
        mod.call({
            cmd:"infuso/cms/user/controller/changeEmail",
            userId: container.attr("data:userid"),
            newEmail: container.find("input[name=newEmail]").val(),
        });
    });

});