mod(".nRjkjN8GAn").init(function() {
    
    var $container = $(this);
    var $content = $container.children(".content");
    var $nodes = $content.children(".nodes");
    var $links = $content.children(".links");
    var $header = $container.children(".header");
    
    var data = {};
    try {
        data = JSON.parse(sessionStorage.getItem("song"));
    } catch(ex) {}

    var song = new earb.Song(data);
    
    song.on("addNode", function(node) {
        var $e = $("<div>").appendTo($nodes);
        node.view.render($e);
    });
    
    var redrawLinks = function() {
        
        var c = $links.get(0);
        var ctx = c.getContext("2d");
        ctx.clearRect(0, 0, c.width, c.height);
        
        var nodesOffset = $nodes.offset(); 
        
        for(var i in song.links) {
            var link = song.links[i];
            var src = song.node(link.from);
            var dest = song.node(link.to);
            
            var $src = src.view.getOutElement(link.fromPort);
            var $dest = dest.view.getInElement(link.toPort);
            
            ctx.beginPath();
            ctx.moveTo($src.offset().left - nodesOffset.left + 5, $src.offset().top - nodesOffset.top + 5);
            ctx.lineTo($dest.offset().left - nodesOffset.left + 5, $dest.offset().top - nodesOffset.top + 5);
            ctx.stroke();
            
        }
    };
    
    song.on("link/create", redrawLinks);
    song.on("node/move", redrawLinks);
    
    for(var i in earb.nodeTypes) {
        var type = earb.nodeTypes[i];
        var label = type.nodeClassLabel();
        $("<div>")
            .html(label)
            .appendTo($header)
            .data("type", i)
            .click(function() {
                song.addNode({
                    type: $(this).data("type")
                });
            });
    }
    
    setInterval(function() {
        var data = song.storeParams();
        sessionStorage.setItem("song", JSON.stringify(data));
    }, 1000);
    
    
    //song.addNode();
    //song.addNode();

});