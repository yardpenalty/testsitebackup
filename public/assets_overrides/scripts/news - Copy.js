var News = function () {
  
	var badgeCt = 0;
	var localProfile = localStorage.getItem('profile');
	var actualKey = sessionStorage.getItem('actualKey');
	var myNewsKey = sessionStorage.getItem('myNewsKey');
	var instance = "";
	var notifs = sessionStorage.getItem('notifs');
	var auth = sessionStorage.getItem('auth');
    var hasGeneral = false;
	var hasInstance = false;

    var UpdateMyCookie = function(){
		var date = new Date();
	    var midnight = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 23, 59, 59);	
		var data = 'INSTANCE=HTHACKNEY';
		
		$.getJSON( "http://webservices.hthackney.com/WEB054K?callback=?",data )
		.done(function( json ) {
			//gets cookie of latest newsfeed id
			 $.cookie('latestNewsKey', $.trim(json.LatestNews), midnight); 
             console.log("trigger latestnews cookie = " + $.cookie('latestNewsKey'));
             sessionStorage.setItem('myNewsKey', $.cookie('latestNewsKey'));		
		     myNewsKey =  sessionStorage.getItem('myNewsKey');			 
		})	
		.fail(function( jqXHR, textStatus, error ) {
		var err = textStatus + ", " + error;
		alert('Unable to Connect to Server.\n Try again Later.\n Request Failed: ' + err);
		}); 		  
	}
/*
*	Notifs section
*
*/
    var handleNotif = function(){
		$('#notifs').on('click', 'li a', function (e) {
    
    	if(!$(this).hasClass('topic')){
			console.log("THis is a sibling");
			//update this record as visited via ajax
			sessionStorage.setItem('actualKey', "1");
			sessionStorage.setItem('instance', 'index.ph');
			var obj = {};
			 
			// set viewed flag to true in WBPCHANG
			  	// $.ajax({
           // type: "POST",
           // url:  "http://portal.hthackney.com:8082/rest/WEB054V?callback=?",
           // data:  obj,
           // dataType: "jsonp"}).
           // done(function(data){
           	  // $(this).closest('li').remove();
			  // DisplayBadgeCount();
			  StorageNotifsLinks();
			  HtmlNotifs();
		  }
		});
	}    
	
	var HtmlGritter = function(){
			
		if(hasGeneral){		
			setTimeout(function () {  
			$.extend($.gritter.options, {
				position: 'top-left'
			});
			var unique_id = $.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<i class="fa fa-4x fa-bolt"></i>&nbsp;&nbsp;New Announcements!',
				// (string | mandatory) the text inside the notification
				text: 'Please view links under "New Announcements" by clicking on the notifications icon.',
				// (string | optional) the image to display on the left
				image: '../images/logo.png',
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: true,
				// (int | optional) the time you want it to be alive for before fading out
				time: '',
				// (string | optional) the class name you want to apply to that specific message
				class_name: 'my-sticky-class'
			});
		  }, 3000);
		}
		
		if(hasInstance){
		   setTimeout(function () {  
			$.extend($.gritter.options, {
				position: 'top-left'
			});
			var unique_id = $.gritter.add({
				// (string | mandatory) the heading of the notification
				title: '<i class="fa fa-4x fa-bell"></i>&nbsp;&nbsp;New Page Enhancements!',
				// (string | mandatory) the text inside the notification
				text: 'Please view links under "New Page Enhancements" by clicking on the notifications icon.',
				// (string | optional) the image to display on the left
				image: '../images/logo.png',
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: true,
				// (int | optional) the time you want it to be alive for before fading out
				time: '',
				// (string | optional) the class name you want to apply to that specific message
				class_name: 'my-sticky-class'
			});
			
			// You can have it return a unique id, this can be used to manually remove it later using
			//setTimeout(function () {
				// $.gritter.remove(unique_id, {
					// fade: true,
					// speed: 'slow'
				// });
			//}, 12000);	
		  }, 3000);	   
		}
		//pulsate new notifications
		if(hasInstance || hasGeneral){
		  $('#header_notification_bar').pulsate({
			color: "#ec2e2b",
			repeat: 10
		  }); 
		}
	}

	var HtmlBadgeCount = function(){

				var header = $('#header_notification_bar');
				if(header.hasClass('hidden')){ 
					header.removeClass('hidden');
				}
				badgeCt = $("ul#notifs li.nws").length;		
			  	if(badgeCt > 0){
				header.find(".badge").text(badgeCt);
				}
	}
	
	var checkInstances = function(array){
		//checks to see if any unviewed notifications for ul#notifs
		for(var i = 0; i < array.length; i++)
		{
			if(array[i].FUNCTION == '*GENERAL' && array[i].VISITED !== "T")
			{
				hasGeneral = true;
			}
			
			if(array[i].FUNCTION == instance && array[i].VISITED !== "T"){
				hasInstance = true;
			}
		}
	}
	
	var HtmlNotifsLinks = function(){
		console.log('in HtmlNotifsLinks');
		var jsonStr = sessionStorage.getItem('notifs');
		
		jArray = $.parseJSON(jsonStr);
		
		if(jArray.length > 0 && !empty(jArray) ){
			checkInstances(jArray);
			$("#notifications li:first").append('<ul id="notifs" class="dropdown-menu-list scroller" style="max-height: 250px; overflow: hidden; width: auto;"></ul>');
			var ul = $('ul#notifs');
			
			if(hasGeneral){ //<!-- *GENERAL //-->
				ul.append('<li id="general" class="disabled topic"><span class="mt5l10">New Announcements</span></li>')
			 }
			 
			 if(hasInstance){ //<!-- *FUNCTION //-->
				ul.append('<li id="enhancements" class="disabled topic pages"><span class="mt5l10">New Page Enhancements</span></li>'); 
			 }	
             
            $.each(jArray, function(k, v) {
				if(v.FUNCTION === "*GENERAL"){
				console.log(v.HTML);
				}
				if(v.FUNCTION === instance){
					
				}
			});			 
				// <li>					                           
			  // <a href="#NewsModal" onclick="remote=\'modal_news.php?USER='.trim($USER).'&INSTANCE='.trim($PATH_INSTANCE).'&PKEY=1\'
							// remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-warning"><i class="fa fa-bell-o"></i></span> Test Announcement</a> 

				// </li>
				// <li>
					
					 // <a href="#NewsModal" class="enhance" onclick="remote=\'modal_news.php?USER='.trim($USER).'&FUNCTION='.trim(urlencode($FUNCTIONCODE)).'&PATH_INSTANCE='.$PATH_INSTANCE.'&Viewed=F\'
							// remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-warning"><i class="fa fa-bell-o"></i></span> Test Announcement</a> 
				// </li>

				// <li>
					// <a href="#">
					// <span class="label label-icon label-danger">
						// <i class="fa fa-bolt"></i>
					// </span>
					 // 2 user IP blocked.
					// <span class="time">
						// 5 hrs
					// </span>
					// </a>
				// </li>
				// <li>
					// <a href="#">
					// <span class="label label-icon label-warning">
						// <i class="fa fa-bell-o"></i>
					// </span>
					 // Storage Server #4 not responding.
					// <span class="time">
						// 45 mins
					// </span>
					// </a>
				// </li>
				// <li>
					// <a href="#">
					// <span class="label label-icon label-info">
						// <i class="fa fa-bullhorn"></i>
					// </span>
					 // System Error.
					// <span class="time">
						// 55 mins
					// </span>
					// </a>
				// </li>
				//external link for all viewed newsfeeds that are active
				var external = '<li class="external"><a href="#NewsModal" onclick="remote=\' modal_newsfeeds.php?USER=' + localProfile + '&INSTANCE=' +
				instance + '\'remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal">View All Past News <i class="m-icon-swapright m-icon-dark"></i></a></li>';

			   $("ul#notifications").append(external);				 
		}
		else{
			alert("YOU MESSED UP!");
		}
	}
	

	var HtmlNotifs = function(){

			HtmlNotifsLinks(); 
			HtmlGritter();	 
		    HtmlBadgeCount();
	}
	
	var StorageNotifsLinks = function(){
	
	    //load hrefs into sessionStorage notifs
		// $.getJSON( "http://portal.hthackney.com:8082/rest/WEB054A?callback=?",data )
		// .done(function( json ) {
			// = $('#notifs');
			console.log("trigger storagenotifslinks");
			
			 var jArray = [ 
				 {PKEY:"1",FUNCTION: "*GENERAL", TITLE:"Server Maintenance 8/24/2016 5pm - 7pm CT",VIEWED: ""},
				 {PKEY:"2", FUNCTION: "planogram.ph", TITLE:"New options",VIEWED: ""},
			     {PKEY:"3",FUNCTION: "orderscan.ph", TITLE:"New Preload cart option!",VIEWED: ""}
			 ];		   
			 jsonString = JSON.stringify(jArray);
			 //console.log(jsonString);
			 notifs = sessionStorage.setItem('notifs', jsonString);		 
	}

    /*
	*
	*Newsfeed section
	*
	*/
	var HtmlModalNewsFeeds = function(){
		
		
	}
	
	/* Display individual modal_news item based on AUTHCD(CRUD)*/
	var HtmlModalNewsFeed = function(){
       if(localProfile && instance && actualKey){
		var data =	'USER=' + localProfile +
			'&INSTANCE=' + instance +
			'&PKEY=' + actualKey;
	      
			$.getJSON( "http://webservices.hthackney.com/WEB054L?callback=?",data )
		     .done(function( json ) {
				  $("#title").val(json.TITLE);
				 if(/S/i.test(auth)){
                    //CRUD capable
				    $("#newsForm").find('.md-input').val(json.HTML);
					//handles Authorization List for feed
					var authlistArray = json.AUTHLST.split(','); 
					$.each(authlistArray, function (index, value) {
                          $('input[name="auth"][value="' + value + '"]').prop("checked", true);
                     });	
					//dates
					 $('input[name="STARTDATE"]').val(json.STARTDATE);
					 $('input[name="ENDDATE"]').val(json.ENDDATE);
					 if(json.FUNCTION === "*GENERAL")
						$('input[name="publish"][value="general"]').prop("checked", true);
					 if(/^Y$/i.test(json.ARCHIVE))
						$('input[name="publish"][value="archive"]').prop("checked", true);
				 }
				 else{
					 $("#html5").val(json.HTML);
				 }
				
			 });
	   }
	}
	
	var EditNewsFeed = function(){
     
	 $('[name="auth"]:checked').each(function() {
      
     });
	 
	 $('[name="publish"]:checked').each(function() {
      
     });
		
	}
	
	var AddNewsFeed = function(){
		
		
	}
	
	var DelNewsFeed = function(){
		
		
	}
	
	var handleNewsFeed = function(){
		$('#newsForm').on('change click','.feed', function(){
			 // Toggle details 
			 var details = $(this).find('.details').show();
			  $(".details").not(details).hide();
			 //toggle save btn //preview must be active 
		     if($(this).find(".btn-primary").hasClass("active"))
				$(this).find(".btn-info").prop("disabled", true);
             else
				$(this).find(".btn-info").prop("disabled", false);				 		       
    	});		     		
	}

	/*
	
	News app section
	
	*/
    return {

        //on login. If user leaves session open. it will update notifs after midnight
        initProfile: function (user) {
		        if(user.length > 0){
	                //  https://html.spec.whatwg.org/ultipage/webstorage.html
				    //store id for profile
                    localStorage.setItem('profile', user);
					localProfile = localStorage.getItem('profile');
                    //alert(localProfile);				
					if(localProfile){						
						if (myNewsKey != $.cookie('latestNewsKey') || empty(myNewsKey)){ 		
							UpdateMyCookie();	
						    StorageNotifsLinks();
				        }
					}
				}        			
	    },  
		triggerNotifs: function(pathInstance, authcd){	
           
			if(empty(pathInstance))
				instance = "index.ph";
			else
			    instance = pathInstance;
			
		     //ensures news gets updated when user leaves session open
			if(localProfile && ( empty($.cookie('latestNewsKey')) || empty(myNewsKey)) || empty(notifs)){
                UpdateMyCookie();	
				StorageNotifsLinks();				
			}	
			
			if(localProfile && myNewsKey == $.cookie('latestNewsKey') && !empty(myNewsKey)){				
				sessionStorage.setItem('auth', authcd);	   
		        auth = sessionStorage.getItem('auth');
				HtmlNotifs();	
			}	
          			
		},
		eventNotifs: function(){		   
			if(localProfile){        
			   handleNotif(); //responsive onclick #notifs > li > a	
			} 		
		},
		destroyStorage: function(){
			sessionStorage.clear();
			localStorage.clear();
			//alert('destroy localstorage');
		},	  
		eventNewsFeed: function(){
			   handleNewsFeed();
			   //CRUD events
			   EditNewsFeed();
			   AddNewsFeed();
			   DelNewsFeed();
		},
		triggerNewsFeed: function(pkey, pathInstance){						
			sessionStorage.setItem('instance', pathInstance);
            sessionStorage.setItem('actualKey', pkey);
			actualKey = sessionStorage.getItem('actualKey');
			instance = sessionStorage.getItem('instance');
			//display modal_news content
			HtmlModalNewsFeed();
		}
    }; 
	
    function hasCookies() {
	    return (navigator.cookieEnabled);
	}
	
	function setCookie(name, value, minutes) {
		var date = new Date();
		var m = minutes;
		date.setTime(date.getTime() + (m * 60 * 1000));
		$.cookie( name, value, { expires: date });
	}
	
	function empty(e) {
	  switch (e) {
		case "":
		case 0:
		case "0":
		case null:
		case false:
		case typeof this == "undefined":
		  return true;
		default:
		  return false;
	}
}
    
}();              