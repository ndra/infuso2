earb.channelController = function(channel) {

    var controller = this;
    
    this.$notes = {};
    this.$cols = {};
    
    channel.on("1/32", function(event) {
        controller.handle32(event);
    });
       
    this.html = function() {    
    
        var buttonWidth = 40;
        var buttonHeight = 40;
        var buttonHSpacing = 5;
        var buttonVSpacing = 5; 
        
        // Сколько ступеней выводить        
        var degrees = 10;
        
        this.$e = $("<div>")
            .css({
                height: degrees * (buttonHeight + buttonVSpacing) + buttonVSpacing,
                border: "1px solid gray",
                position: "relative",
                "user-select": "none"
                
            }).appendTo("body");
    
        for(var i = 0; i < channel.pattern().duration() ; i ++ ) {
        
            var $col = $("<div>").appendTo(this.$e);
            this.$cols[i] = $col;
        
            for(var j = 0; j < degrees; j ++ ) {
            
                var degree = degrees - j - 1;
            
                var $note = $("<div>")
                    .css({
                        width: buttonWidth,
                        height: buttonHeight,
                        position: "absolute",
                        left: buttonHSpacing + i * (buttonWidth + buttonHSpacing),
                        top: buttonVSpacing + j * (buttonHeight + buttonVSpacing)
                    }).appendTo($col)
                    .data("degree", degree)
                    .html(degree)
                    .data("position", i)
                    .mousedown(function() {
                        var place = channel.pattern().at($(this).data("position"));
                          
                            var exists = false;
                            var notes = place.notes();
                            for(var k in notes) {
                                if(notes[k].degree == $(this).data("degree")) {
                                    exists = true;
                                }
                            }
                          
                            if(!exists) {
                                place.note({
                                    degree: $(this).data("degree"),
                                    duration: 1
                                });
                            } else {
                                place.clear();
                            }
 
                        controller.updatePatternHTML();
                        channel.saveData();
                    });
                this.$notes[i + "-" + degree] = $note;
            }
        }
        
        this.updatePatternHTML();
        
    }     
        
    this.handle32 = function(event) {       
        var step = channel.pattern().currentStep();     
        for(var i in this.$cols) {
            this.$cols[i].css("opacity", i == step ? .8 : 1)
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
        
        for(var i in this.$notes) {
            this.$notes[i].css("background", notes[i] ? "red" : "#ccc");
        };

    }

    
}
