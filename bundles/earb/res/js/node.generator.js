earb.Node.Generator = class extends earb.Node {
    
    viewConstructor() {
        return earb.Node.Generator.View;
    }
    
    static nodeClassLabel() {
        return "Генератор";
    }
    
}

earb.registerNodeType(earb.Node.Generator, "zkJXRd90mqLA");