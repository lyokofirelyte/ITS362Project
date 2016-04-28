var data = "";
var count = 500;
var counter = setInterval(timer, 10);

function timer(){
    if (count <= 0){
        count = 500;
    	post('error.php', {
            a: "a"
        }, function(data2){
        	if (data != data2){
    	    	$("body").html(data2);
    	    	data = data2;
    	    	clearInterval(counter);
    	    	return;
        	}
        });
     }
     count--;
     $("h3").html(((count / 100) + "").substring(0, 1)); 
}
$(function(){
	startErrors()
});