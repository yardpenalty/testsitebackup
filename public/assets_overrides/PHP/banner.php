<?php
/**********************************************************************
 * Description:	Allow web user to print shelf tags in many different formats
 * 
 * Author:				Bob Ek
 * Date:					07/31/2012
 ***********************************************************************
 * Modification Log:
 * Date		Init	Description
 * --------	----	-----------------------------------------------------
 * 
 *************************************************************************/
// define global variables
$l_current = " ";
$l_type = " ";

include 'PHPTop.inc'; // Must exist at top of all PHP documents!


/* Define PHP Specific Variables */

/********************************************************************************** 
 * Execute the proper HTML section
 **********************************************************************************/
if (strtolower ( $HTML ) == 'banner' || trim ( $HTML ) == '') :
	Banner ();

endif;

/********************************************************************************* 
 * Selection web page   
 **********************************************************************************/
function Banner() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	?>
<html>
<head>
<title>The H.T. Hackney Co. - Secure web site Banner</title>

<? // Define the cascading style sheet 	?>
<?

	include 'style.inc';
	?>
<style>
body {
	margin-left: 0%;
}
</style>

<? // Define JavaScript variables that will be used by all pages to load menu options 	?>
<script LANGAUGE="javascript"><!-- 
StdTopMenu = new Array;
StdTopMenu.length = 0;
StdSubMenu = new Array; 
StdSubMenu.length = 0;

AddTopMenu = new Array; 
AddTopMenu.length = 0;
AddSubMenu = new Array;
AddSubMenu.length = 0;
//--></script>

<? /* If the user has turned off their scripting then display this section which
   will show them how to enable java scripting */	?>
<?

	include 'noscript.inc';
	?>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	style="margin-top: 0; margin-bottom: 0">
	<tr>
		<td><img src="/images/logo.png" width="125" height="76"></td>
		<td align="left"><font style="font-size: 28pt" color="<?
	echo $DARK?>">H.T.
		Hackney Secure Access Portal</font></td>

	</tr>
</table>
</body>
</html>
<?
}
?>