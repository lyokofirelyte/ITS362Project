var move_header = true;

$(function(){
	
    $("#regSubmit").on("click", function(e){
        wipePage();
        post("index.php", {
            update_views: [
                "register"
            ],
            registerSubmited: "yes",
            register_username: $("#register_username").val(),
            register_email: $("#register_email").val(),
            register_password1: $("#register_password1").val(),
            register_password2: $("#register_password2").val()
        }, function(data){
            window.setTimeout(function(){
                restorePage(data);
            }, 500);
        });
    });
    
    $("#loginSubmit").on("click", function(e){
        wipePage();
        post("index.php", {
            update_views: [
                "login"    
            ],
            login_email: $("#login_email").val(),
            login_password: $("#login_password").val(),
            logged_in: 0
       }, function(data){
            window.setTimeout(function(){
                restorePage(data);
            }, 500);
        });
    });
	
	$("li").on("click", function(e){
		switch (e.currentTarget.id){
			case "sidebar_button_twitter": {
				move_header = false;
				if(twitter_linked == 0){
					twitter_linked = 1;
					post('index.php', {
						update_views: [
							"login"
						],
						link_twitter: "link",
						twitter_linked: 1
					}, function(data){
						window.setTimeout(function(){
							restorePage(data);
						}, 500);
					});
				}
				else{
					move_header = false;
					twitter_linked = 0;
					post('index.php', {
						update_views: [
							"login"
						],
						twitter_linked: 0
					}, function(data){
						var x = 0;
		        		$(".twitter_post").each(function(i){
		            		var dis = $(this);
		            		try {
			        			window.setTimeout(function(){
			        				dis.animate({
			        					opacity: "0"
			        				}, 1000);
			        				window.setTimeout(function(){
										dis.remove();
			        				}, 1000);
			            		}, x);
		        				x += 100;
		            		} catch (e){}
		        		});
					});
				}
            	
                break;
			}

            case "sidebar_button_login": {
            	
            	wipePage();
                
                post('index.php', {
                    update_views: [
                        "login"
                    ],
                    logged_in: 2
                }, function(data){
               	 	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 500);
                });
                
                break;
            }
            
            case "sidebar_button_tumblr": {
            	
            	move_header = false;
            	
            	post("index.php", {
            		show_tumblr: "yes"
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
                    update_views: [
                        "register"
                    ],
                }, function(data){
                	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 500);
                });
            	
            	break;
            }
            
            case "sidebar_button_logout": {
            	
            	//wipePage();
            	
            	$("div").each(function(i){
        			$(this).animate({
    					opacity: "0"
    				}, {
						duration: 3000,
						queue: false
    				});

        			$(this).animate({
    					marginTop: "400"
    				}, {
						duration: 3000,
						queue: false
    				});
        		});
                
                post('index.php', {
                	logged_in: 1
                }, function(data){
                	move_header = false;
               	 	window.setTimeout(function(){
               	 		restorePage(data);
               	 	}, 3000);
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
                
            case "sidebar_button_refresh": {
                location.reload();
                break;
            }
			
			case "sidebar_button_youtube": {
				
				var youtube_search = prompt("Youtube Search", "");
				
				if (youtube_search != null){
					post('index.php', {
	                	youtube_search: youtube_search
	                }, function(data){
	               	 	window.setTimeout(function(){
	               	 		restorePage(data);
	               	 	}, 500);
	                });
				}
				
				break;
			}
			
			case "sidebar_button_background": {
				var input = "<form enctype='multipart/form-data' action='index.php' method='post' style='display: none'><input type='file' name='file' id='file' /><input type='submit' name='file_bg' id='file_submit'/></form>";
				$("body").append(input);
				$(".tooltip").remove();
				$("#file").trigger('click');
				$(this).html("<i class='fa fa-upload'></i>");
				$(this).attr("id", "sidebar_button_upload");
				break;
			}
			
			case "sidebar_button_header": {
				var input = "<form enctype='multipart/form-data' action='index.php' method='post' style='display: none'><input type='file' name='header_file' id='header_file' /><input type='submit' name='header_file_submit' id='header_file_submit'/></form>";
				$("body").append(input);
				$(".tooltip").remove();
				$("#header_file").trigger('click');
				$(this).html("<i class='fa fa-upload'></i>");
				$(this).attr("id", "sidebar_button_upload_2");
				break;
			}
			
			case "sidebar_button_upload": {
				$("#file_submit").trigger('click');
				break;
			}
			
			case "sidebar_button_upload_2": {
				$("#header_file_submit").trigger('click');
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
	$("div").each(function(i){
		$(this).animate({
			opacity: "0"
		}, {
			duration: 500,
			queue: false
		});
	});
	/*window.setTimeout(function(){
		$(".header").animate({
			height: "100%"
		}, 300);
	}, 1500);*/
}

function restorePage(data){
	window.setTimeout(function(){
		data = data.replace("<div class=\"header\"", "<div class=\"header\" style=\"height: 100%\"");
		data = data.replace("<div class=\"sidebar\"", "<div class=\"sidebar\" style=\"display: none\"");
		var newDiv = "<div class='master' style='opacity: 0'>" + data + "</div>";
		$("body").html(newDiv);
		$(".header").css("height", "60px");
		$(".header").css("opacity", 1);
		/*if (move_header){
			$(".header").animate({
				height: "60px"
			}, 400);
		}*/
		$(".master").animate({
			opacity: 1
		}, 500);
		window.setTimeout(function(){
			$(".sidebar").css({display:"block"});
			$("#loading_icon").css({display:"none"});
		}, 400);
		move_header = true;
	}, 200);
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
		case "sidebar_button_account" : return "Logged in!";
		case "sidebar_button_user": return "User Account Management";
		case "sidebar_button_logout": return "Logout";
		case "sidebar_button_twitter": return "Link/Unlink Twitter";
		case "sidebar_button_youtube": return "Search Youtube";
		case "sidebar_button_background": return "Change Background";
		case "sidebar_button_upload": case "sidebar_button_upload_2": return "Submit Image";
		case "sidebar_button_header": return "Change Header";
		case "sidebar_button_tumblr": return "Link/Unlink Tumblr";
        case "sidebar_button_refresh": return "Refresh";
		default: return "No tooltip found!";
	}
}

function pageDone(){
	console.log("Page load complete!");
}