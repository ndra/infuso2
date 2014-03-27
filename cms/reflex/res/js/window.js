jQuery.fn.window = function() {

    var params = {
        width: 320,
        height: 240
    };

    var window = $("<div>").css({
        position: "absolute",
        width: params.width,
        height: params.height,
        background: "white",
        border: "1px solid gray"
    });

}