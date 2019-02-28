<?php
// Define the cascading style sheet 
if ($OFORMAT != "E") :
	require "style.inc";

	endif;

/* If the user has turned off their scripting then display this section which
	   will show them how to enable java scripting */
require "noscript.inc";
?>
<SCRIPT LANGUAGE="JavaScript"><!--
function check_frames() {
	<?
	if ($AUTHCD != "S") :
		?>
		if(top.frames.length =="0")
			<?
		if ($PATH_INSTANCE == "hacktest") :
			?>
				top.location="<?
			echo $SPLASHPAGE_TEST?>";
			
		 else :
			?>
				top.location="<?
			echo $SPLASHPAGE?>";
			
		<?endif;
		?> 
	
	<?endif;
	?>
	if (navigator.appName.indexOf("Netscape") != -1)
		document.form.reset();
}
//--></script>