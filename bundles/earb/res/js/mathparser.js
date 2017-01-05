earb.MathParser = function(str, params) {

    str += "";

    for(var i in params) {
        str = str.replace(i, params[i]);
    }
    
    var ret = 0;
    
    try {
        eval("ret = " + str);
    } catch(ex) {
        mod.msg(ex);
    }
    
    return ret;

}