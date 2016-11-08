mod(".c8vWaICF5n").init(function() {
    
    var $floater = $(this);
    
    $floater.find("a").mousedown(function(event) {
        event.stopPropagation();    
    });
    
    var id = $floater.attr("data:id");
    
    var drag;
    
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
				overflow: "auto",
				zIndex: 1000
			});
		mod.call({
			cmd: "infuso/cms/profiler/controller/info",
			id: id
		}, function(data) {
			$screen.html(data);
		});
	};
       
    var setPosition = function(x, y) {
	
		x = x * 1 || 100;
		y = y * 1 || 100;
		
		$floater.css({
			left: x,
			top: y
		});
		
        localStorage.setItem("profiler-x", x);
        localStorage.setItem("profiler-y", y);
	};
	
	setPosition(localStorage.getItem("profiler-x"), localStorage.getItem("profiler-y"));  		

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
	
});