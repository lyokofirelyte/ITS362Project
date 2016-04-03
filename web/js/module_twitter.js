$(function(){
	$("li").on("click", function(e){
		switch (e.currentTarget.id){
                
            case "menu_twitter": {
                           
                post('../module/module_twitter.php', {
                    twitter_username: "lyokofirelyte"
                }, function(data){
                	location.reload();
                });
                
                break;
            }

            case "module_login": {
                
                post('../module/module_twitter.php', {
                    logged: "yes"
                }, function(data){
                	location.reload();
                });
                
                break;
            }
            
            case "module_logout": {
                
                post('../module/module_twitter.php', {
                    logged: "no"
                }, function(data){
                	location.reload();
                });
                
                break;
            }
        }
	});
});