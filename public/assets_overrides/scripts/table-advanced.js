var TableAdvanced = function () {
         
	var initTable1 = function(table_name,table_build) {
	
	    /* Add the expand/collapse capability*/
	    function fnFormatDetails ( oTable, nTr )
	    {
	        var aData = oTable.fnGetData( nTr );
	        var sOut = '<table>';
	        var ct = -1; 
	        $('#'+table_name+' thead th').each( function () {
	        		ct += 1;
	        		if (ct > 0 && aData[ct+1]) { 
	        			if(aData[ct+1] != '&nbsp;') {
		        			var class_add_bot = '';
					        for (i in myObject) {
										for (j in myObject[i]["lower_hidden"]) {
											if (ct == myObject[i]["lower_hidden"][j]) {
												if (class_add_bot == '') class_add_bot = ' class="'; 
												class_add_bot += ' hidden-' + myObject[i]["size"];
											}
										}
									}
									//stg = $.trim($('#'+table_name+' thead th').eq(ct+1).text());
									len = $('#'+table_name+' thead th').eq(ct+1).text().length;
									chr = $('#'+table_name+' thead th').eq(ct+1).text().substring(len-1,len); 
									if (chr >= '0' && chr <= '9') {
										stg = $('#'+table_name+' thead th').eq(ct+1).text().substring(0,len-1)+'<sup><b>'+chr+'</b></sup>';
										
									}
									else {
										stg = $('#'+table_name+' thead th').eq(ct+1).text();
									}
									//alert(stg);
									
									if (class_add_bot != '') class_add_bot += '"';
		        			sOut += '<tr><td' + class_add_bot + '>'+
		        			stg+':</td><td' + 
		        			class_add_bot +'>'+aData[ct+1]+'</td></tr>'; 	
		        		}
	        		}
	        });
	        sOut += '</table>';   
	        return sOut;
	    }      
	     
			var oTable = $('#'+table_name).dataTable();

			if (table_build == 'Y') {
		    jQuery('#'+table_name+'_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
		    //jQuery('#'+table_name+'_wrapper .dataTables_length select').addClass("form-control input-small"); // modify table per page dropdown
		    //jQuery('#'+table_name+'_wrapper .dataTables_length select').select2(); // initialize select2 dropdown

		    /* Add event listener for opening and closing details
		     * Note that the indicator for showing which row is open is not controlled by DataTables,
		     * rather it is done here
		     */
		    $('#'+table_name).on('click', ' tbody td .row-details', function () {
		        var nTr = $(this).parents('tr')[0];
		        if ( oTable.fnIsOpen(nTr) )
		        {		
		            /* This row is already open - close it */
		            $(this).parents('td')[0].innerHTML = '<span class="row-details row-details-close"><i class="fa fa-plus-square icon-large"></i></span>';
		            oTable.fnClose( nTr );
		        }
		        else
		        {		
		            /* Open this row */               
		            $(this).parents('td')[0].innerHTML = '<span class="row-details row-details-open"><i class="fa fa-minus-square icon-large"></i></span>';
		            oTable.fnOpen( nTr, fnFormatDetails(oTable, nTr), 'details' );
		            $(nTr).next().addClass(expand_class);
		            $('td.details tr td:first-child').addClass('bold'); // headings changed to bold
		        }
		    });
		   }
	    /******************************************************************************************************************* 
	    1. load the 1st 'th' JSON string into an array so that it can be processed  
	    2. Attach hidden classes to the 'th' and 'td' tags 
	    ------------------------------------------------------------------------------------------------------------------*/ 
	   	var ctl = new String($('#'+table_name+' th').eq(1).text());
			var myObject = eval("(" + ctl + ")");
			
			// is column specific searching allowed?
			allow_search = 'N';
			if (window.Search_Capable) {
				if($.trim(Search_Capable) != "") {
					allow_search = 'Y';
				}
			}
	
			//if column specific searching is allowed then remove/add the TFOOT tag
			if ($('#'+table_name+' tfoot').val() == undefined) {
					$('#'+table_name+' thead').after('<tfoot></tfoot>');
				}
			if (table_build == 'Y' && allow_search == 'Y') {
				if ($('#'+table_name+' tfoot tr').val() != undefined) {
					$('#'+table_name+' tfoot tr').remove();
				}
				$('#'+table_name+' tfoot').append('<tr></tr>');
			}
			
			var ct = -1; 
			var first = 'Y';
			var expand_class = '';
			var th_count = 	$('#'+table_name+' thead th').length-2;
			var class_add_top = '';
			var class_add_footer = '';
			$('#'+table_name+' thead th').each( function () {
	  		ct += 1;
	  		class_add_footer = class_add_top;
	  		class_add_top = '';
	  		if (ct > 0) {	
	        for (i in myObject) {
	        	if (first == 'Y') {
		        	cnt = myObject[i]["lower_hidden"].length;
		        	if (cnt == th_count) {
		        		expand_class += ' hidden-' + myObject[i]["size"];
		        	}
	        	}
						for (j in myObject[i]["upper_hidden"]) {
							if (ct == myObject[i]["upper_hidden"][j]) {
								class_add_top += ' hidden-' + myObject[i]["size"];
							}
						}
					}
					if ($.trim(class_add_top) != "") {
						$('#'+table_name+' tbody td:nth-child('+(ct+2)+')').addClass(class_add_top);
						if (table_build == 'Y') {
							$('#'+table_name+' thead th').eq(ct+1).addClass(class_add_top);
						}
					}
					first = 'N';
	  		}
	  		
				// Add TH tags in the TFOOT --------------------------------------------------------------------------
				
				// if column specific searching is allowed
				if (table_build == 'Y' && allow_search == 'Y') {
					class_add = 'class="';
					html_add = '';
					if ($('#'+table_name+' thead th').eq(ct).hasClass('hidden')){
						class_add += ' hidden';	
					}
					if ($.trim(class_add_footer) != "") {
						class_add += $.trim(class_add_footer);	
					}
					if ($.inArray(ct,Search_Capable ) >= 0){
						var title = $('#'+table_name+' thead th').eq( $(this).index() ).text();
						html_add = '<input type="text" size="6" placeholder="'+title+'" class="searchable" value=>';
					}
					class_add += '"'
					$('#'+table_name+' tfoot tr').append('<th '+$.trim(class_add)+'>'+$.trim(html_add)+'</th>');
				}
				//-------------------------------------------------------------------------------------------------------
	 		});
	 		// add handlers
	 		if (table_build == 'Y') {
	 				$('#'+table_name+' thead tr th:first').addClass(expand_class);
	 				if ( allow_search == 'Y') {
	 						$('#'+table_name+' tfoot tr th:first').addClass(expand_class);
	 				}
	 		}
	 		$('#'+table_name+' tbody tr td:first-child').addClass(expand_class);
	 		$('#'+table_name+' tbody tr.total-line td:nth-child(3)').addClass('total-line');
	 		
	 		//$('div .dataTables_info').addClass('hidden');
	 		// group headers & comment lines
	 		$('#'+table_name+' tbody td.grp-header').each( function () {
		 			$(this).parent().addClass('grp-header');  //add class to header
		 			$(this).prevAll().empty();  //remove the expand icon
		 			$(this).attr('colspan','100%');   // extend to entire line
		 			$(this).nextUntil().remove();  // remove all place holder 'td' elements (elements initially needed for jquery)
	 		});
	 		$('#'+table_name+' tbody td.comment-line').each( function () {
		 			$(this).parent().addClass('comment-line');  //add class to header
		 			$(this).prevAll().empty();  //remove the expand icon
		 			$(this).attr('colspan','100%');   // extend to entire line starting at current position
		 			$(this).prevUntil().addClass('comment-line');
		 			$(this).nextUntil().remove();  // remove all place holder 'td' elements (elements initially needed for jquery)
	 		});
	
	 		/******************************************************************************************************************/
	}
	return {
	  //main function to initiate the module
	  init: function (table_name,table_build) {
	    if (!jQuery().dataTable) { return; }
			initTable1(table_name,table_build);
		//----------------------------------------------------------------------------------------------------------------
	  }
	};
}();