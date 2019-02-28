/*load a variable with the screen size and do special processing when the screen size changes*/
var sc_size = '';
function resize_check (){
  	//XS
   	if ($(".java-size").css("width") == "767px" && sc_size != 'xs'){
			sc_size = 'xs';
			// collapse portlets 
			if(!$('.portlet .portlet-body.collapse-xs').hasClass('collapse')){
				$('.portlet .portlet-body.collapse-xs').addClass('collapse');
				$('.portlet .tools .collapse-xs').addClass('expand').removeClass('collapse');;
			}
		}
		//SM
		if ($(".java-size").css("width") == "991px"  && sc_size != 'sm'){
			sc_size = 'sm';
		}
		//MD
		if ($(".java-size").css("width") == "1199px" && sc_size != 'md' ){
			sc_size = 'md';
			
		}
		//LG
		if ($(".java-size").css("width") == "1200px"  && sc_size != 'lg'){
			sc_size = 'lg';
		
		}
}