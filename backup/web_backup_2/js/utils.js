function php(functionName, params){
    for (i = 0; i < params.length; i++){
        params[i] = "'" + params[i] + "'";
    }
    document.write("<?php " + functionName + "(" + params + "); ?>");
}