$(function() {

    $(".ybslv95net").submit(function(e) {
        e.preventDefault();
        var data = $(this).mod("formData");
        console.log(data);
    });

});