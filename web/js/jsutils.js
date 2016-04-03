function post(url, data, callback){
	$.ajax({                                      
	      url: url,                        
	      type : 'POST',
	      data: data,
	      error: function(){ alert("Error processing your request!"); },
	      success: function(d){
	    	  return callback(d);
	      }
	 });
}

function replacePage(data){
	document.write(data);
}

function replaceElement(element, data){
	$(element).replaceWith(data);
}

function replaceElementById(element, data){
	$("#" + element).replaceWith(data);
}