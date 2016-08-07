earb.generator = function(instrument, params) {
    return new function() {
    
        var getRandomInt = function(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    
        this.generateText = function(params) {
        
  
            params = earb.extend({
                length: 16
            }, params);
            
            // Распределение ступеней гаммы по вероятности
            var degrees = [1,3,5,1,3,5,1,3,5,2,4,6,7];
            degrees = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]
            
            // Распределение длительностей
            // Положительные числа - ноты
            // Отрицательные - паузы
            var durations = [1,1,1,1,2,2,3,-1,-1,-1,-1,-2,-3]; 
            
            var ret = [];
            
            while(true) {
            
                var symbol;
                
                var option = durations[getRandomInt(0, durations.length - 1)];
                var d = Math.abs(option);
                
                switch(option) {
                    case 1:
                    case 2:
                    case 3:
                        symbol = degrees[getRandomInt(0, degrees.length - 1)] + "";
                        break;
                    case -1:
                    case -2:
                    case -3:
                        symbol = ".";
                        break;
                }
                
                ret.push(symbol + (d > 1 ? "("+d+")" : ""));
                
                if(ret.length == params.length) {
                    break;
                }
            
            }
            
            return ret.join(" ");   
        };
        
        this.generate = function() {         
            var txt = this.generateText();
            console.log(txt);
            var pattern = instrument.pattern(txt);
            return pattern;        
        }
      
    };
};