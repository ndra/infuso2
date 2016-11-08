$(function() {

    // Читаем переменную id
    // window.SoS4LQkVRF8Q хранит значение id профайлера
	var id = window.SoS4LQkVRF8Q;

	mod.call({
		cmd: "infuso/cms/profiler/controller/short",
		id: id
	}, function(data) {       
		var $floater = $(data).appendTo("body");
	}); 

});