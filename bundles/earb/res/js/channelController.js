earb.channelController = function(channel) {

    var controller = this;
    
    channel.on("1/32", function(event) {
        controller.handle32(event);
    });
       
    this.html = function() {    
        
        this.$e = $("<div>")
            .css({
                height: 50*10,
                border: "1px solid gray",
                position: "relative"
            }).appendTo("body");
            
        channel.$notes = {};
        channel.$cols = {};
    
        for(var i = 0; i < channel.pattern().duration() ; i ++ ) {
        
            var $col = $("<div>").appendTo(this.$e);
            channel.$cols[i] = $col;
        
            for(var j = 0; j < 10; j ++ ) {
            
                var degree = -j;
            
                var $note = $("<div>")
                    .css({
                        width: 40,
                        height: 40,
                        position: "absolute",
                        left: i * 50,
                        top: j * 50
                    }).appendTo($col)
                    .data("degree", degree)
                    .html(degree)
                    .data("position", i)
                    .mousedown(function() {
                        var place = channel.pattern().at($(this).data("position"));
                        if(place.notes().length) {
                            place.clear();
                        } else {                            
                            place.clear();
                            place.note({
                                degree: $(this).data("degree"),
                                duration: 1
                            });
                        }
                        channel.updatePatternHTML();
                        channel.saveData();
                    });
                channel.$notes[i + "-" + degree] = $note;
            }
        }
        
        this.updatePatternHTML();
        
    }     
        
    this.handle32 = function(event) {       
        var step = channel.pattern().currentStep();     
        for(var i in channel.$cols) {
            channel.$cols[i].css("opacity", i == step ? 1 : .8)
        }         
    }
    
    this.updatePatternHTML = function() {
    
        var notes = [];
        for(var i = 0; i < channel.pattern().duration(); i ++) {
            var n = channel.pattern().at(i).notes();
            for(var j in n) {
                notes[i+ "-" + n[j].degree] = true;
            }
        }
        
        for(var i in channel.$notes) {
            channel.$notes[i].css("background", notes[i] ? "red" : "#ccc");
        };

    }

    
}
