var News = function () {
  
	var badgeCt = 0;
	var localProfile = localStorage.getItem('profile');
	var myNewsKey = sessionStorage.getItem('myNewsKey');
	var notifs = sessionStorage.getItem('notifs'); 
    var editor = localStorage.getItem('editor'); 
	var functionCode = '';
	var actualKey = "";
    var hasGeneral = false;
	var hasInstance = false;
	var hasUrgent = false;
    var instanceText = '';
	var generalText = '';
    var urgentText = '';
	var instanceCt = 0;
	var generalCt = 0; 
	var urgentCt = 0;
	
var UpdateMyCookie = function(){
	
	var date = new Date();
	var midnight = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 23, 59, 59);	
	var data = 'INSTANCE=HTHACKNEY';
	
	$.getJSON( "http://webservices.hthackney.com/WEB054K?callback=?",data )
	.done(function( json ) {
		//gets cookie of latest newsfeed id
		 $.cookie('latestNewsKey', $.trim(json.LatestNews), midnight); 
		 //console.log("latestnews cookie = " + $.cookie('latestNewsKey'));
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
var StorageNotifsLinks = function(){ //load newsfeed into temporary storage
	//load hrefs into sessionStorage notifs
	 var data = 'USER=' + localProfile +
	    				'&INSTANCE=HTHACKNEY';
	$.getJSON( "http://webservices.hthackney.com/WEB054A?callback=?",data )
	.done(function( json ) {
		// = $('#notifs');
		 var jArray = [ 
			 {PKEY:"1",FUNCTION: "*GENERAL", TITLE:"Server Maintenance 8/24/2016 5pm - 7pm CT",VISITED: "",URGENT: "Y"},
			 {PKEY:"4",FUNCTION: "*GENERAL", TITLE:"Server Install",VISITED: ""},
			 {PKEY:"2", FUNCTION: "SPLASH PAGE", TITLE:"New options for home page!",VISITED: ""},
			 {PKEY:"5", FUNCTION: "SPLASH PAGE", TITLE:"New carousal!",VISITED: "",URGENT: "Y"},
			 {PKEY:"3",FUNCTION: "ORDERSCAN", TITLE:"New Preload cart option!",VISITED: ""}
		 ];		
   
		 jsonString = JSON.stringify(json);
		 notifs = sessionStorage.setItem('notifs', jsonString);	
	});		 
} 

var checkInstances = function(array){
	//checks to see if any unviewed notifications for ul#notifs
	for(var i = 0; i < array.length; i++)
	{
		//console.log(array[i].FUNCTION);
		if(array[i].URGENT === "Y")
			hasUrgent = true;
		if(array[i].FUNCTION === '*GENERAL' && array[i].VISITED !== "Y")
			hasGeneral = true;
		if(array[i].FUNCTION == functionCode && array[i].VISITED !== "Y")				
			hasInstance = true;			
	}
}

var HtmlNotifsLinks = function(){
	
	var jsonStr = sessionStorage.getItem('notifs');
	var jArray = {};
	if(!empty(jsonStr))
		jArray = $.parseJSON(jsonStr);
	
	if(jArray.length > 0 && !empty(jArray)){
		checkInstances(jArray);
		var tempStr = "";
		var title = "";
		var edtr = "";
		$("#notifications li:first").append('<ul id="notifs" class="dropdown-menu-list scroller" style="max-height: 250px; overflow: hidden; width: auto;"></ul>');
		var ul = $('ul#notifs');
		
		if(hasGeneral){ //<!-- *GENERAL //-->
			ul.append('<li id="general" class="disabled topic"><span class="mt5l10">New Announcements</span></li>')
		 }
		 
		 if(hasInstance){ //<!-- *FUNCTION //-->
			ul.append('<li id="enhancements" class="disabled topic pages"><span class="mt5l10">New Page Enhancements</span></li>'); 
		 }	
		 
		$.each(jArray, function(k, v) {
		  
			title = v.TITLE;
			
			if(v.FUNCTION === "*GENERAL"){
				//console.log(v.URGENT);
				if(v.URGENT == "Y"){
					tempStr = '<a href="#NewsModal" class="urgent" title="' + title + '" onclick="remote=\'modal_news.php?USER=' + localProfile + '&PKEY=' +
					v.PKEY + '&FUNCTION=' + functionCode + '\'; remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-danger"><i class="fa fa-bolt"></i></span>'
					+  title.dotdotdot(28) + '</a>';
					hasUrgent = true;
					urgentCt++;
					urgentText += tempStr;
				}
				else{
					tempStr = '<a href="#NewsModal" title="' + title + '" onclick="remote=\'modal_news.php?USER=' + localProfile + '&PKEY=' +
					v.PKEY  + '&FUNCTION=' + functionCode + '\'; remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-info"><i class="fa fa-bullhorn"></i></span>'
					+  title.dotdotdot(28) + '</a>';
					generalCt++;
					generalText += tempStr;
				}						

				$('<li class="nws">' + tempStr + '</li>').insertAfter("#general");
				//console.log(tempStr);
			}
			
			if(v.FUNCTION === functionCode){
				if(v.URGENT == "Y"){
					tempStr = '<a href="#NewsModal" class="urgent" title="' + title + '" onclick="remote=\'modal_news.php?USER=' + localProfile + '&PKEY=' +
					v.PKEY  + '&FUNCTION=' + functionCode + '\'; remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-danger"><i class="fa fa-bolt"></i></span>'
					+  title.dotdotdot(28) + '</a>';
					hasUrgent = true;
					urgentCt++;
					urgentText += tempStr;
				}
				else{
					tempStr = '<a href="#NewsModal" title="' + title + '" onclick="remote=\'modal_news.php?USER=' + localProfile + '&PKEY=' +
					v.PKEY  + '&FUNCTION=' + functionCode + '\'; remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-warning"><i class="fa fa-feed"></i></span>'
					+  title.dotdotdot(28) + '</a>';
					instanceCt++;
					instanceText += tempStr;	
				}				
			
				$('<li class="nws">' + tempStr + '</li>').insertAfter("#enhancements");
				//console.log(tempStr);
			}
		});	
	}
	// <li><a href="#NewsModal" onclick="remote=\'modal_news.php?USER='.trim($USER).'&INSTANCE='.trim($PATH_INSTANCE).'&PKEY=1\'
	// remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal"><span class="label label-icon label-warning"><i class="fa fa-bell-o"></i></span> Test Announcement</a> 
	// </li>
	//external link for all viewed newsfeeds that are active
	//alert(functionCode);
	var external = '<li class="external"><a href="#NewsModal" onclick="remote=\'modal_newsfeed.php?USER=' + localProfile + '&FUNCTION=' +
	functionCode + '\'; remote_target=\'#NewsModal .modal-body\'" role="button" data-toggle="modal">View all related News <i class="m-icon-swapright m-icon-dark"></i></a></li>';

   $("ul#notifications").append(external);				 
}
	
var HtmlBadgeCount = function(){
	var header = $('#header_notification_bar');
	if(header.hasClass('hidden')){ 
		header.removeClass('hidden');
	}
	badgeCt = $("ul#notifs li.nws").length;		
	if(badgeCt > 0){
		header.find(".badge").text(badgeCt);
		header.find('.fa-bell').removeClass('opaque');
	}
	else{
		header.find('.fa-bell').addClass('opaque');	
		header.find(".badge").addClass("hidden");
	}
}

var HtmlGritter = function(){
	//pulsate new notifications
	if(hasInstance || hasGeneral || hasUrgent){

	//instance or urgent?
	if(instanceCt > 0)
		hasInstance = true;
	else
		hasInstance = false;
	//general or urgent?
	if(generalCt > 0)
		hasGeneral = true;
	else
		hasGeneral = false;
	
	setTimeout(function () { 
	
	if(hasUrgent){	
		$.extend($.gritter.options, {
			position: 'top-left'
		});
				
	   var urgentArray = urgentText.split(",");
		var urgent_id = $.gritter.add({
			// (string | mandatory) the heading of the notification
			title: '<i class="fa fa-4x fa-bolt"></i>&nbsp;&nbsp;Urgent News!',
			// (string | mandatory) the text inside the notification
			text: urgentText,
			// (string | optional) the image to display on the left
			image: '../images/logo.png',
			// (bool | optional) if you want it to fade out on its own or just sit there
			sticky: true,
			// (int | optional) the time you want it to be alive for before fading out
			time: '',
			// (string | optional) the class name you want to apply to that specific message
			class_name: 'clicker'
		});
	} 	
	
	if(hasGeneral){		
		$.extend($.gritter.options, {
			position: 'top-left'
		});
		var ct = 'New Announcement!';
		if(generalCt > 1)
			ct =  'New Anouncements!';	
		
		var general_id = $.gritter.add({
			// (string | mandatory) the heading of the notification
			title: '<i class="fa fa-4x fa-bullhorn"></i>&nbsp;&nbsp;' + ct,
			// (string | mandatory) the text inside the notification
			text: generalText,
			// (string | optional) the image to display on the left
			image: '../images/logo.png',
			// (bool | optional) if you want it to fade out on its own or just sit there
			sticky: true,
			// (int | optional) the time you want it to be alive for before fading out
			time: '',
			// (string | optional) the class name you want to apply to that specific message
			class_name: ''
		});
		// remove this gritter
		setTimeout(function () {
			$.gritter.remove(general_id, {
				fade: true,
				speed: 'slow'
			});
		}, 8000);	
	}

	if(hasInstance){
		$.extend($.gritter.options, {
			position: 'top-left'
		});
		var ct = 'New Page Enhancement!';
		if(instanceCt > 1)
			ct =  'New Page Enhancements!';
		var instance_id = $.gritter.add({
			// (string | mandatory) the heading of the notification
			title: '<i class="fa fa-4x fa-bell"></i>&nbsp;&nbsp;' + ct,
			// (string | mandatory) the text inside the notification
			text: instanceText,
			// (string | optional) the image to display on the left
			image: '../images/logo.png',
			// (bool | optional) if you want it to fade out on its own or just sit there
			sticky: true,
			// (int | optional) the time you want it to be alive for before fading out
			time: '',
			// (string | optional) the class name you want to apply to that specific message
			class_name: ''
		});
		
		// remove this gritter
		setTimeout(function () {
			$.gritter.remove(instance_id, {
				fade: true,
				speed: 'slow'
			});
		}, 8000);	
	}	
			
	//pulsate once
	$('#header_notification_bar').pulsate({
		color: "#ec2e2b",
		repeat: 8
	}); 
	
	//pulsate recursively on urgent
	if(hasUrgent){
		setTimeout(function () {
		var pulsateInterval = setInterval(function() {
			$('#header_notification_bar').pulsate({
				color: "#ec2e2b",
				repeat: 5
			}); 
			//console.log('urgent pulsate');
			}, 9000);
		}, 3000);	
	}
	
	}, 3000);
	
	} //eof if has gritter
}

var handleNotif = function(){
	$('#notifs').on('click', 'li.nws a', function (e) {
		//console.log("This is a news li");
		//update this record as visited via ajax
		sessionStorage.setItem('actualKey', "1");
		//sessionStorage.setItem('instance', 'index.ph');
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
		  //0StorageNotifsLinks();
		  //HtmlNotifs();
 
	});
}    

var HtmlNotifs = function(){
		HtmlNotifsLinks(); 
		HtmlGritter();	 
		HtmlBadgeCount();
}
	
    /*
	*
	*Newsfeed section
	*
	*/
var HtmlModalNewsfeed = function(){
	  if(localProfile && functionCode){
		  
		  
	  }
	
}

/* Load individual modal_news item */
var HtmlModalNews = function(){
       if(localProfile && functionCode && actualKey){
		   
		var data =	'USER=' + localProfile +
			'&INSTANCE=' + functionCode +
			'&PKEY=' + actualKey;
	  
			$.getJSON( "http://webservices.hthackney.com/WEB054L?callback=?",data )
		     .done(function( json ) {
			     $('<label class="control-label xs-small" style="margin: 10px 0px 0px -15px">HTML: </label>').insertBefore('#editorForm .btn-primary');
 
				 if(/^Y$/i.test(editor)){
                    //CRUD capable
				    $(".editorForm").find('.md-input').val(json.HTML);
					$("#title").val(json.TITLE);
					//handles Authorization List for feed
					var authlistArray = json.AUTHLST.split(','); 
					$.each(authlistArray, function (index, value) {
                          $('input[name="AUTHLST"][value="' + value + '"]').prop("checked", true);
                     });	
					//dates
					 $('input[name="STARTDATE"]').val(json.STARTDATE);
					 $('input[name="ENDDATE"]').val(json.ENDDATE);
					 if(json.FUNCTION === "*GENERAL")
						$('select[name="PAGE"][value="*GENERAL"]').prop("checked", true);
					 else{
						 var selected = 'select[name="PAGE"][value="'+ json.FUNCTION +'"]';
						$(selected).prop("checked", true);
					 }						
					 if(/^Y$/i.test(json.ARCHIVE))
						$('[name="ARCHIVE"]').prop("checked", true);
					 if(/^Y$/i.test(json.ACTIVE))
						$('[name="ACTIVE"]').prop("checked", true);
					 if(/^Y$/i.test(json.URGENT))
						$('input[name="URGENT"]').prop("checked", true);	
					 if($('.editorForm').hasClass('hidden'))
						$('.editorForm').removeClass('hidden');

				 }  
				 else{
			        if($('.newsForm').hasClass('hidden'))
					   $('.newsForm').removeClass('hidden');
				 }
				 
                 //modal-headers				 
				 if(json.FUNCTION === "*GENERAL"){
					if(json.URGENT === "Y")
						$('.newsLabel').text('General Announcement: Urgent!');
				    else	
						$('.newsLabel').text('General Announcement');
				 }
				 if(json.FUNCTION !== "*GENERAL"){
					if(json.URGENT === "Y") 
						$('.newsLabel').text('Page Enhancement: Urgent!');
					else	
                        $('.newsLabel').text('Page Enhancement');						
				 }
				
				  //general user news
				 $("#hl").html(json.HTML);
				 $("#te").html(json.TITLE);
			 });
	   }
	}
/*
*
* Editor eventHandlers
* 
*/
var HtmlMarkdown = function(){

	 $("#html5").markdown({ 
    			  onShow: function(e){
    				     //hide buttons
    				     $("[data-handler=bootstrap-markdown-cmdItalic]").hide();
    					 $("[data-handler=bootstrap-markdown-cmdImage]").hide();
    					 $("[data-handler=bootstrap-markdown-cmdBold]").hide();
    					 $("[data-handler=bootstrap-markdown-cmdList]").hide();
    					 $("[data-handler=bootstrap-markdown-cmdHeading]").hide();
    					 $("[data-handler=bootstrap-markdown-cmdUrl]").hide();
        				// Date Range
        				if (jQuery().datepicker) {
        					$("input[name='STARTDATE']").datepicker({
        						  showOn: "button",
        					      buttonImage: "/images/calendar.png",
        					      buttonImageOnly: true,
        					      buttonText: 'Select a start date',
        					      changeMonth: true,
        					      changeYear: true,
        					      onClose: function( selectedDate ) {
        					        $("input[name='STARTDATE']").datepicker( "option", "minDate", selectedDate );
        					      }, 
        					      beforeShow: function() {
        					          setTimeout(function(){
        					              $('.ui-datepicker').css('z-index', 100100);
        					          }, 0);
        					      },
        					      minDate: '0', // The min start date that can be selected, i.e. 30 days from the 'now'
        					      maxDate: '+1m'  // The max start date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        					});
        				    $("input[name='ENDDATE']").datepicker({
        				    	  showOn: "button",
        					      buttonImage: "/images/calendar.png",
        					      buttonImageOnly: true,
        					      changeMonth: true,
        					      changeYear: true,
        					      onClose: function( selectedDate ) {
        					        $("input[name='ENDDATE']").datepicker( "option", "maxDate", selectedDate );
        					      }, 
        					      beforeShow: function() {
        					          setTimeout(function(){
        					              $('.ui-datepicker').css('z-index', 100100);
        					          }, 0);
        					      },
        					      minDate: '+1m', // The min date that can be selected, i.e. 30 days from the 'now'
        					      maxDate: '+2m'  // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
        				    });				
        				}
    			  }
    		});
}

var EditorMarkdown = function(){
		$("input[name='STARTDATE']").datepicker({
			  showOn: "button",
			  buttonImage: "/images/calendar.png",
			  buttonImageOnly: true,
			  buttonText: 'Select a start date',
			  changeMonth: true,
			  changeYear: true,
			  onClose: function( selectedDate ) {
				$("input[name='STARTDATE']").datepicker( "option", "minDate", selectedDate );
			  }, 
			  beforeShow: function() {
				  setTimeout(function(){
					  $('.ui-datepicker').css('z-index', 100100);
				  }, 0);
			  },
			  minDate: '0', // The min start date that can be selected, i.e. 30 days from the 'now'
			  maxDate: '+1m'  // The max start date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
		});
		$("input[name='ENDDATE']").datepicker({
			  showOn: "button",
			  buttonImage: "/images/calendar.png",
			  buttonImageOnly: true,
			  changeMonth: true,
			  changeYear: true,
			  onClose: function( selectedDate ) {
				$("input[name='ENDDATE']").datepicker( "option", "maxDate", selectedDate );
			  }, 
			  beforeShow: function() {
				  setTimeout(function(){
					  $('.ui-datepicker').css('z-index', 100100);
				  }, 0);
			  },
			  minDate: '+1m', // The min date that can be selected, i.e. 30 days from the 'now'
			  maxDate: '+2m'  // The max date that can be selected, i.e. + 1 month, 1 week, and 1 days from 'now'
		});				   		 
}

var NewsValidation = function(){
		  //Variables created without the keyword var, are always global, even if they are created inside a function.
	var form = $('#editorForm');
    var FormError = $('.alert-danger',form);
   	var success = $('.alert-success',form);

     form.validate({
		focusInvalid: false, // do not focus the last invalid input
		onkeyup: false,	
		ignore: ".ignore", //required for hidden input validation ie: hiddenRecaptcha
		rules:{
			"TITLE": {
           	 	required: true, 
                rangelength:[15,100]				
   	    	},
   	    	"HTML": {
   	   	    	required: true,
   	   	   	    rangelength:[15,5000]
   	    	},
       	 	"AUTHLST": {
          	 	 required: true
			},
			"ACTIVE": {
				 required: {
					depends: function() {
						if(!$("#archive:checked"))
							return true;
						else
							return false;
					}
				 }
		   },
			"STARTDATE": { 
                required: true, 
                HTH_dateUSA: true,
                HTH_dateRange: ['<=',$('input[name="ENDDATE"]').val()]
        	},
			"ENDDATE": { 
                required: true, 
                HTH_dateUSA: true,
                HTH_dateRange: ['>=',$('input[name="STARTDATE"]').val()]
        	} 			
    	},
    	messages: { // custom messages for form validation input
       		   "TITLE": {
       	   		 	required: "The TITLE will also be displayed in notification area so make sure to be clear and concise. " +
					"eg: Server Maintenance: Fri 5-7pm CT 08/28/2016"
    	   	   },
    	   	   "HTML": {
					required: "The HTML secton is where the actual content is saved" 		 
    	   	   },
    	   	   "ACTIVE": {
       	   		required: "Archive must be checked if news item is to be active on archive"
    	   	   },
			   "AUTHLST": {
				   required: "At least one type of user is required"
			   },
			    "STARTDATE": {
        		required: "Start Date is required.",
        		HTH_dateUSA: "Start Date must be a valid date in mm/dd/yyyy format.",
        		HTH_dateRange: "Start Date cannot be before End Date"			
            },
			 "ENDDATE": {
        		required: "End Date is required.",
        		HTH_dateUSA: "End Date must be a valid date in mm/dd/yyyy format.",
        		HTH_dateRange: "End Date cannot be before Start Date"			
            }
     	},
     	showErrors: function(errorMap, errorList) {
            // Clean up any tooltips for valid elements
            $.each(this.validElements(), function (index, element) {
            	element = $(element);
                NoError_ToolTip(element);
            });
            // Create new tooltips for invalid elements
            $.each(errorList, function (index, error) {
                element = $(error.element);
                message = error.message;
                Error_ToolTip(element,message);
            });
        },  				
		invalidHandler: function (event, validator) { //display error alert on form submit     
        	success.hide();
            $(document).scrollTop( $(".form-body").offset().top ); 
      	},
		 submitHandler: function () {
			  
			 }
  	});
	}
	
var editNews = function(){
	var buttonValue;

	$('button[type="submit"]').click(function(e){
	   buttonValue = $(this).val();
	});
	
	//add validation at later date
	$("#editorForm").on("submit", function(){
		
		if(buttonValue === "edit"){
		   alert("submit this until validation is implemented");
		}
		return false;
	});
}

var addNews = function(){

	//add validation at later date
	$("#editorForm").on("submit", function(){		
	   
	   var authlst = [];
	   
		$('[name="AUTHLST"]:checked').each(function(i,e) {
			authlst.push(e.value);
		});

        authlst = authlst.join(',');
	   var authStr = authlst.toString();
	    
       console.log(html);
	   var html = $(".editorForm").find(".md-preview").html();
	   alert(authStr);
	   alert(html);
	   
	   var data = 'USER=' + localProfile +
	    '&INSTANCE=HTHACKNEY' +
		'&PAGE=' + $('select[name="PAGE"]').val() +
		'&TITLE=' + $("input[name='TITLE']").val() +
		'&HTML=' + encodeURI(html) +
		'&STARTDATE=' + $("input[name='STARTDATE']").val() +
		'&ENDDATE=' + $("input[name='ENDDATE']").val() +
		'&ARCHIVE=' + $("input[name='ARCHIVE']").val() +
		'&ACTIVE=' + $("input[name='ACTIVE']").val() +
		'&URGENT=' + $("input[name='URGENT']").val() +	
		'&AUTHLST=' + authStr;
		
		alert(data);
	   $.getJSON(
	   "http://webservices.hthackney.com/web054S?callback=?",data).
	   done(function(data){
		   if(data["SUCCESS"]){
			   $(".shell").html('<div class="h4 msg xs-small text-center" style="font-weight: 400;">' + data["message"] + '</div><br><br><br><br><br><br>'+
						'<div class="caption right">'+
							'<a href="index.php" id="defaultactionbutton" class="btn btn-success">home&nbsp;<i class="fa fa-home"></i></a>'+
						  '</div>');
			   }
			   else{
				   $(".shell").html('<div class="msg text-center xs-small">' + data["error"] + '</div>');
		   }
		   setTimeout(good, 1200);
		
	   }).
	   fail(function(){
		   function bad(){
		   $("#newsForm").html("<div class='h4 msg xs-small text-center' style='font-weight: 400;'>we're sorry!<br><br><br><br><span class='text-danger'>unfortunately this inquiry cannot be processed at this time." +
		   "<br>please try again at a later time or give us a call at:</span><br><br>+1.800.406.1291</div><br><br><br><br><br><br>"+
					'<div class="caption right">'+
					'<a href="index.php" id="defaultactionbutton" class="btn btn-success">home&nbsp;<i class="fa fa-home"></i></a>'+
					'</div>');
		   }
		   setTimeout(bad, 1200);
	   });
			return false;
	 });	
}

var delNews = function(){
	$('[data-toggle=confirmation-popout]').confirmation({ 
		popout: true, 
		singleton: true,
		placement:'bottom', 
		btnOkClass: 'btn-small btn-success mr5',
		btnCancelClass: 'btn-small btn-warning',
		onConfirm: function(){
		if(this.context.id == "del"){
		//delete news item
			alert('delete successful');
		}
		}
	});		
}

var visitedNews = function(){
	//trigger this on modal_news ready() in News.triggerNews()
	var data = 'USER=' + localProfile + '&PKEY=' + actualKey + '&INSTANCE=' + functionCode;
	
	 $.ajax({
			type: 'POST', // prefered to GET when updating records
			url: 'http://webservices.hthackney.com/WEB054V?callback=?',  // RPG program in HTHREST library
			data: data, // loaded above
			 //contentType: "application/json; charset=utf-8",
			dataType: "jsonp"}).
			done(function(data){
				function good(){
			   if(data["MESSAGE"]){
			 
			   }
			   else{
				   $(".shell").html('<div class="msg text-center xs-small">' + data["ERROR"] + '</div>');
			   }
			}
			setTimeout(good, 1200);
		
			}).
			fail(function(){
			   function bad(){
			   $(".shell").html("<div class='h5 msg xs-small text-center' style='font-weight: 400;'><br>We're Sorry!<br><br><br><br><span class='text-danger'>Unfortunately this inquiry cannot be processed at this time." +
			   "<br>Please try again at a later time or give us a call at:</span><br><br>+1.800.406.1291</div><br><br><br><br><br><br>"+
						'<div class="caption right">'+
						'<a href="index.php" id="defaultActionButton" class="btn btn-success">Home&nbsp;<i class="fa fa-home"></i></a>'+
						'</div>');
			   }
			   setTimeout(bad, 1200);
			});
}

var handleNews = function(){
	 
	$('#editorForm').on('click','.btn-primary', function(){   
	 //toggle save btn //preview must be active 
	 if($("#upd").hasClass("disabled")){
		$("#upd").removeClass("disabled");
	 }
	 else{
		$("#upd").addClass("disabled");
	 }
	});
	
	 //NewsValidation();
 }
 
 var handleNewsfeed = function(){
	 handleNews();
	//need to inject inside plugin somehow: see newsfeed.js for starters
	$('.modal').on('focus', ".dp:not(.hasDatepicker)", function(e){
		var dater = $(this).datepicker();
		var nodater = $('.hasDatePicker').not(dater);
		nodater.datepicker('destroy');
   });
 }
 
 var toggleEditor = function(){
	 var toggle = true;
	 $(".cmn-toggle-round").change(function() {
		 if(toggle){
			 $(".editorForm").addClass('hidden');
			 $(".newsForm").removeClass('hidden');
			 toggle = false;
		 }
		 else{
			 $(".newsForm").addClass('hidden');
			 $(".editorForm").removeClass('hidden');
			 toggle = true;
		}
		
	  return false;
	});
 }
	/*
	
	News app section
	
	*/
    return {

        //on login. If user leaves session open. it will update notifs after midnight
        initProfile: function (user, edit) {
		        if(user.length > 0){
                    localStorage.setItem('profile', user);
					localProfile = localStorage.getItem('profile');
					localStorage.setItem('editor', edit);
					editor = localStorage.getItem('editor');
                    //alert(localProfile);				
					if(localProfile){						
						if (myNewsKey != $.cookie('latestNewsKey') || empty(myNewsKey)){ 		
							UpdateMyCookie();	
						    StorageNotifsLinks();
				        }
					}
				}        			
	    },  
		triggerNotifs: function(pathInstance){	  
			//ensures news gets updated when user leaves session open or changes tabs
			if(localProfile && ( empty($.cookie('latestNewsKey')) || empty(myNewsKey)) || empty(notifs)){
				UpdateMyCookie();	
				StorageNotifsLinks();				
			}	
			//displays notifs if user is logged in and news updated
			if(localProfile && myNewsKey == $.cookie('latestNewsKey') && !empty(myNewsKey)){	
				functionCode = pathInstance;			
				HtmlNotifs();	
			}	   			
		},
		eventNotifs: function(user){		   
			if(localProfile === user){        
			   handleNotif(); //responsive onclick #notifs > li > a	
			} 		
		},
		destroyStorage: function(){
			sessionStorage.clear();
			localStorage.clear();
			//alert('destroys local/sessionStorage');
		},	  
		eventEditor: function(){
			if(editor === "Y"){		
	            $("#newsForm .slides").removeClass("hidden");
				//always two feeds in modal_news editor & user feed
				if($('.feed').length > 2){
					$("#editorForm").removeClass("hidden");
					EditorMarkdown();
					handleNewsfeed();
					addNews();
				}
				else{
					HtmlMarkdown();
					handleNews();
				}
				//CRUD events
				toggleEditor();
			    editNews();
				delNews();
			}
		},
		triggerNews: function(pkey){						
			actualKey = pkey;	
			//display modal_news content
			HtmlModalNews();
			//WBPCHANG VISTED = "Y" 
			//visitedNews();
		},
		triggerNewsfeed: function(user){
			
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

String.prototype.dotdotdot = function(len) {
	if(this.length > len){
		var temp = this.substr(0, len);
		temp = $.trim(temp);
		temp = temp + "...";
		return temp;
	}
	else
		return $.trim(this);
};
            