$(function() {

	var id = SoS4LQkVRF8Q;

	// Записывает куку
	var createCookie = function(name,value) {
	    document.cookie = name + "=" + value + "; path=/";
	}
	
	// Читает куку
	var readCookie = function(name) {
	    var nameEQ = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i = 0; i < ca.length; i ++) {
	        var c = ca[i];
	        while (c.charAt(0) == ' ') {
				c = c.substring(1, c.length);
			}
	        if (c.indexOf(nameEQ) == 0) {
				return c.substring(nameEQ.length, c.length);
			}
	    }
	    return null;
	}
	
	var openProfiler = function() {
		var $screen = $("<div>")
			.appendTo("body")
			.css({
				position: "fixed",
				left: 0,
				top: 0,
				width: "100%",
				height: "100%",
				background: "#ededed",
				zIndex: 1000
			});
		mod.call({
			cmd: "infuso/cms/profiler/controller/info",
			id: id
		}, function(data) {
			$screen.html(data);
		});
	};
	
	var drag;

	var $floater = $("<div>")
		.css({
			position: "fixed",
			width: 200,
			background: "#ededed",
			zIndex: 1000
		}).appendTo("body")
		.addClass("jj6C9CG39lUb");
		
	mod.call({
		cmd: "infuso/cms/profiler/controller/short",
		id: id
	}, function(data) {
		$floater.html(data);
	});
		
	var setPosition = function(x, y) {
	
		x = x * 1 || 100;
		y = y * 1 || 100;
		
		$floater.css({
			left: x,
			top: y
		});
		
		createCookie("profiler-x", x);
		createCookie("profiler-y", y);
	};
	
	setPosition(readCookie("profiler-x"), readCookie("profiler-y"));
		
	// Реализация драга
	(function() {
	
		var mouseStart;
		var initialPos;
		var d;
		
		$floater.mousedown(function(event) {
			event.preventDefault();
			drag = true;
			mouseStart = {x: event.pageX, y: event.pageY};
			initialPos = {x: parseInt($floater.css("left")), y: parseInt($floater.css("top"))}
		});  
		
		var update = function(event) {
			if(drag) {		
				var offset = {
					x: event.pageX - mouseStart.x,
					y: event.pageY - mouseStart.y
				};   
				d = Math.sqrt(offset.x * offset.x + offset.y * offset.y);
				if(d > 10) {			
					setPosition(
						initialPos.x + offset.x,
						initialPos.y + offset.y
					);
				}
			}
		}
		
		$(document).mousemove(function(event) {
			update(event);
		});
		
		$(document).mouseup(function(event) {
			if(drag) {
				update(event);
				drag = false;	
				if(d <= 10) {
					openProfiler();
				}
			}
		});
	
	})();

});