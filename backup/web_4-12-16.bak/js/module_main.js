var isDown = false;
var held;

var mouseX;
var mouseY;

$(function(){
	$("li").on("click", function(e){
		switch (e.currentTarget.id){
                
            /*case "menu_twitter": {
                           
                post('../module/module_main.php', {
                    twitter_username: "lyokofirelyte"
                }, function(data){
                	location.reload();
                });
                
                break;
            }*/

            case "sidebar_button_login": {
            	
            	wipePage();
                
                post('index.php', {
                    logged_in: "yes"
                }, function(data){
               	 	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 500);
                });
                
                break;
            }
            
            case "sidebar_button_register": {
            	
            	wipePage();
            	
            	post('index.php', {
                    register: "yes"
                }, function(data){
                	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 500);
                });
            	
            	break;
            }
            
            case "sidebar_button_logout": {
            	
            	wipePage();
                
                post('index.php', {
                	logged_in: "no"
                }, function(data){
               	 	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 500);
                });
                
                break;
            }
            
            case "sidebar_button_collapse": {
            	collapse();
            	break;
            }
            
            case "sidebar_button_expand": {
            	expand();
            	break;
            }
        }
	});
	
	$(".float-right i").on("click", function(e){
		if (e.currentTarget.id == "arrows"){
			$(this).parent().parent().animate({
				height:"70px",
				overflow:"hidden",
			}, 200);
			$(this).attr("id", "arrows2");
			$(this).attr("class", "fa fa-angle-down");
			$(this).parent().parent().find("p").css({display:"none"});
			$(this).parent().parent().find("a").css({display:"none"});
			$(this).parent().parent().find("img").css({display:"none"});
			$(this).parent().parent().find(".generic_header img").css({display:"inline"});
			$(this).parent().parent().find(".generic_username a").css({display:"inline"});
		} else if (e.currentTarget.id == "arrows2"){
			$(this).parent().parent().css({height:"auto"});
			$(this).parent().parent().find("p").css({display:""});
			$(this).parent().parent().find("a").css({display:""});
			$(this).parent().parent().find("img").css({display:""});
			$(this).attr("id", "arrows");
			$(this).attr("class", "fa fa-angle-up");
		}
	});
	
	$(".sidebar li").on("mouseover", function(e){
		if (e.currentTarget.id != "sidebar_button_collapse" && e.currentTarget.id != "sidebar_button_expand"){
			var newDiv = "<div class='tooltip'><p id='tooltip_text'>" + getDisplayTag(e.currentTarget.id) + "</p></div>";
			var pos = $(this).position();
			var width = $(this).outerWidth();
			
			$(this).after(newDiv);
	
			$(".tooltip").css({
				position: "fixed",
				padding: "10px",
				right: width + 5,
				top: pos.top + (width / 2) + 36,
				height: $(this).height()
			}).show();
		}
	});
	
	$(".sidebar li").on("mouseout", function(e){
		$(".tooltip").remove();
	});
});

function wipePage(){
	$(".sidebar").css({display:"none"});
	$("#loading_icon").css({display:"inline-block"});
	$(".header").animate({
		height: "100%"
	}, 400);
}

function restorePage(data){
	data = data.replace("<div class=\"header\"", "<div class=\"header\" style=\"height: 100%\"");
	data = data.replace("<div class=\"sidebar\"", "<div class=\"sidebar\" style=\"display: none\"");
	$("body").html(data);
	$(".header").animate({
		height: "60px"
	}, 400);
	window.setTimeout(function(){
		$(".sidebar").css({display:"block"});
		$("#loading_icon").css({display:"none"});
	}, 400);
}


function collapse(){
	$("#collapse").attr("class", "fa fa-angle-left");
	$("#sidebar_button_collapse").attr("id", "sidebar_button_expand");
	$(".sidebar").animate({right:"-=80"}, 200);
	$(".the_grid").animate({marginLeft:"+=60"}, 200);
	$(".tooltip").remove();
	$("#sidebar_button_expand").animate({right: "-=30"}, 200);
}

function expand(){
	$("#collapse").attr("class", "fa fa-angle-right");
	$("#sidebar_button_expand").attr("id", "sidebar_button_collapse");
	$(".sidebar").animate({right:"+=80"}, 200);
	$(".the_grid").animate({marginLeft:"-=60"}, 200);
	$("#sidebar_button_collapse").animate({right: "+=30"}, 200);
	$(".tooltip").remove();
}

function getDisplayTag(item){
	switch (item){
		case "sidebar_button_login": return "Log In";
		case "sidebar_button_register": return "Register";
		case "sidebar_button_collapse": return "Collapse";
		case "sidebar_button_expand": return "Expand";
		case "sidebar_button_account" : return "Logged in as $user";
		case "sidebar_button_user": return "User Account Management";
		case "sidebar_button_logout": return "Logout";
		default: return "No tooltip found!";
	}
}

function pageDone(){
	console.log("Page load complete!");
}