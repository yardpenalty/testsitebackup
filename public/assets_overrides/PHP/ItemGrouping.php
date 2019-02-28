<?php
/**********************************************************************
 * Description:	Allow websuer to create item groupings
 * 
 * Author:				Bob Ek
 * Date:					12/21/2011
 ***********************************************************************
 * Modification Log:
 * Date		Init	Description
 * --------	----	-----------------------------------------------------
 * 
 *************************************************************************/
// define global variables
$l_button = " ";
$GRPID = " ";
$ORGID = " ";
$CPYID = " "; 
$ORIGGRPID = " ";
$GRPNAM = " ";
$LEVEL = " ";
$AUTUSR = " ";
$FILTER = " ";
$SEL1 = " ";
$SEL2 = " ";
$SEL3 = " ";
$SEL4 = " ";
$SEL5 = " ";
$SI = " ";
$SE = " ";
$JI = " ";
$JE = " ";
$MI = " ";
$ME = " ";
$VI = " ";
$VE = " ";
$BI = " ";
$BE = " ";
$II = " ";
$IE = " ";
$SEL = " ";
$WHSSEC = " ";
$CORP = " ";

$SEL01 = " ";
$LOADSEL1 = " ";
$LOADSEL2 = " ";
$HEADER = " ";

$page = " ";
$fitem = " ";
$PROTECT = " ";

include 'PHPTop.inc'; // Must exist at top of all PHP documents!


//Power users
$poweruser = ",bobe,";
if (strpos ( $poweruser, (trim ( $USER ) . ',') ) !== false)
	$l_power = "Y";
else
	$l_power = "N";
	
/* Define PHP Specific Variables */
$table1 = array ();
$table2 = array ();
$table3 = array ();
$table4 = array ();
$table5 = array ();
$table6 = array ();

/********************************************************************************** 
 * Execute the proper HTML section
 **********************************************************************************/
if (strtolower ( $HTML ) == 'group' || trim ( $HTML ) == '') :
	Group ();
 elseif (strtolower ( $HTML ) == 'selectiontool') :
	SelectionTool ();
 elseif (strtolower ( $HTML ) == "submit1") :
	Submit1 ();
endif;

/********************************************************************************* 
 * Selection web page   
 **********************************************************************************/
function Group() {
	
// Include ALL global variables 
eval ( globals () );

//Load local variables


$FUNCTIONCODE = 'ITEMGROUPING'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'GROUP'; // Set equal to "*SKIP" if logging is not desired 


 //Do not allow Excel Download capability	


	header ( "Content-Type: text/html" );
?>

<html>
<head>
<title>The H.T. Hackney Co. - Item Grouping</title>

<?php
// Include standard Header code 
include 'standardheadv03.inc';
echo '<SCRIPT LANGUAGE="JavaScript"><!--';
include 'js_lookup.inc';
echo '//--></script>';
?>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
</head>
<body onload="check_frames();">
<?php
//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
if ($AUTH != 'Y') :
	$MACRO = 'NotAuthorized.mac/Display';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
 //Else, if all users are lock-out of this web page then display the Not-Available web page and DO NOT proceed further 
elseif (trim ( $LOCKOUT ) != '') :
	$MACRO = 'NotAvailable.mac/Display?LOCKOUT=' . urlencode ( $LOCKOUT ) . '&MNUTXT=' . urlencode ( $MNUTXT );
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
 //Else if the user's password has expired then force user to change it 
elseif ($EXPIRED == 'Y') :
	$MACRO = 'ChangePassword.mac/Password';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
else :
	
	// process/load web page	
	$fitem = $FITEM;
	$page = $PAGE;
	Load1 ();
	if (trim ( $USER ) == trim ( $AUTUSR ) || $l_power == 'Y') :
		$PROTECT = 'N';
	 else :
		$PROTECT = 'Y';
	endif;
		?>
	<? // Build the custom page header in the following section		?>
	<h2 align="center" style="margin-top: 0; margin-bottom: 0">
		Item Grouping - Inquiry/Maintenance
	</h2>

	<h3 align="center" style="margin-top: 0; margin-bottom: 0;">
	</h3>
	
	<?// Display the selection form ?>
	<form method="POST" action="itemgrouping.php?HTML=Submit1" name="form" onSubmit="return Edit();">	
<?php
	$vars [] = 'GRPID'; // Load all FORM elements to this array <-------------
	$vars [] = 'GRPNAM';
	$vars [] = 'LEVEL';
	$vars [] = 'WHSEU';
	$vars [] = 'WHSEA';
	$vars [] = 'ENTITYU';
	$vars [] = 'ENTITYA';
	$vars [] = 'USERU';
	$vars [] = 'USERA';
	$vars [] = 'SEL1';
	$vars [] = 'SEL2';
	$vars [] = 'SEL3';
	$vars [] = 'SEL4';
	$vars [] = 'SEL5';
	$vars [] = 'FILTER';
	
	include 'hiddenfields.inc';
	echo '
	<INPUT TYPE=HIDDEN NAME=PROTECT VALUE="' . $PROTECT . '">
	<INPUT TYPE=HIDDEN NAME=CORP VALUE="' . $CORP . '">
	<INPUT TYPE=HIDDEN NAME=WHSSEC VALUE="' . $WHSSEC . '">
	<INPUT TYPE=HIDDEN NAME=CPYID VALUE="' . $CPYID . '">
	<INPUT TYPE=HIDDEN NAME=ORGID VALUE="' . $GRPID . '">
	
	<INPUT TYPE=HIDDEN NAME=WHSU>
	<INPUT TYPE=HIDDEN NAME=WHSA>
	<INPUT TYPE=HIDDEN NAME=ENTU>
	<INPUT TYPE=HIDDEN NAME=ENTA>
	<INPUT TYPE=HIDDEN NAME=USRU>
	<INPUT TYPE=HIDDEN NAME=USRA>';
	
	if (trim ( ltrim ( $GRPID, "0" ) ) != "") :
		echo '<INPUT TYPE=HIDDEN NAME=ORIGGRPID VALUE="' . $LEVEL . $PROTECT . ltrim ( $GRPID, "0" ) . '">';
	 else :
		echo '<INPUT TYPE=HIDDEN NAME=ORIGGRPID VALUE="">';
	endif;
?>				
	<? //If enter key is pressed, then we do not want to issue the 1st submit button.  Instead we want to override		?>
	<INPUT TYPE="image" SRC="/images/pixel.jpg" HEIGHT="1" WIDTH="1" BORDER="0" onclick="document.form.l_button.value='Process Changes'">
		
	<? // Load all selections into a table		?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="100%" align="center">
				<h4>Item Groupings</h4> 
				<?if (trim($USER) == 'bobe'):?>
					<table border="0" cellpadding="0" cellspacing="0" align="center" style="margin-top: 0; margin-bottom: 0"><tr><td align="center">
						<font size="1pt">Contains:</font><br>
						<input type="text" name="CONTAINS" size="75" maxlength="75" onkeyup="lookup(this.value,this.form.GRPID)" onchange="lookup(this.value,this.form.GRPID)">
					</td></tr></table>
				<?endif;?>
				<select size="5" name="GRPID">
				<option VALUE="SEL"
<?php
				if (trim ( $GRPID ) == "" || trim ( $GRPID ) == "SEL" || trim ( $GRPID ) == "AA000A")
					echo ' selected';
?>
				>Select one of the following...</option>
				<option VALUE="ADD" 
<?php
				if (trim ( $GRPID ) == "ADD")
					echo ' selected';
?>
				>Add a new Grouping</option>
<?php
			foreach ( $table1 as $t1 ) {
				echo '<option VALUE="' . trim ( $t1 ['level'] ) . trim ( $t1 ['protect'] ) . substr($t1 ['userid'],0,10) . trim ( $t1 ['grpid'] ) . '"';
				if (trim ( $GRPID ) == trim ( $t1 ['grpid'] ))
					echo ' selected';
				if (trim ( $t1 ['grpid'] ) == "A") 
					echo ' class="light"';
				echo '> ' . trim ( $t1 ['grpnam'] );
				if (trim ( $t1 ['grpid'] ) != "A") 
					echo ' [' . trim ( $t1 ['userid'] ) . ']';
				echo ' </option>';
			}
?>
					</select></td>
	</tr>
	<tr>
		<td width="100%" align="center"><br>
		<br>
		<input type="submit" value="Select" name="SUBMIT_BUTTON"
			onclick="document.form.l_button.value='Select'">&nbsp;&nbsp; <input
			type="submit" value="Copy" name="SUBMIT_BUTTON"
			onclick="document.form.l_button.value='Copy'">&nbsp;&nbsp; <input
			type="submit" value="Delete" name="SUBMIT_BUTTON"
			onclick="document.form.l_button.value='Delete';return confirm('Are you ABSOLUTELY sure you want to delete this Item Grouping?');"">

		</td>
			<?
		if (trim ( $GRPID ) != '') :
			?>
			</tr>
	<td>
	<hr>
	</td>
	</tr>
	</tr>
	<td>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>
<?php
			echo 'Grouping Name:&nbsp;';
			if ($PROTECT == 'Y') :
				echo $GRPNAM;
			 else :
				echo '<input type="text" name="GRPNAM" size="30" maxlength="30" class="fill" value="' . $GRPNAM . '">';
			endif;
			?>
								</td>
			<td><input type="submit" value="Process" name="SUBMIT_BUTTON2"
				onclick="document.form.l_button.value='Process Changes'">&nbsp;&nbsp;

			</td>
		</tr>
	<tr>
			<td colspan="2">
				<hr>
			</td>
		</tr>	
	<tr>
		<td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td width="45%" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td>
						<h4>Click a selection below to expand/shrink</h4>
						</td>
					</tr>					 			
<?php
			// Standard Invoice Category ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $SI ) != '' || trim ( $SE ) != '') :
				echo '
										<tr>
											<td>
												<a name="std">';
				
				if (trim ( $SEL ) != "S") :
					echo '
														<span title="Click to expand">
														<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'S\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
														<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
														<span title="Click to shrink">
														<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
														<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				?>
													Standard Invoice Categories
												</a>
	<?php
				if (trim ( $SI ) != '' || trim ( $SE ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $SI ) != '') {
						echo trim ( $SI ) . ' included';
					}
					if (trim ( $SI ) != '' && trim ( $SE ) != '') {
						echo ', ';
					}
					if (trim ( $SE ) != '') {
						echo trim ( $SE ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '</td>';
				if (trim ( $SEL ) == "S") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Standard Invoice Category
																	</th>
																</tr>
												';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 10pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['code'] ) . '">
																				</td>';
							
																			endif;
							echo '
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					if ($PROTECT == 'N') :
						echo '	
														<tr>
															<td valign="top" align="center">
																<br><font color="' . $DARK . '"><b>Not Selected</b></font>
																<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																	<tr align="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">
																		<th valign="bottom">
																			<br>
																			Include
																		</th>
																		<th valign="bottom">
																			Exclude
																		</th>
																		<th valign="bottom">
																			Standard Invoice Category
																		</th>
																	</tr>';
						$cnt = 0;
						foreach ( $table3 as $t3 ) {
							if (trim ( $t3 ['incexc'] ) == '') :
								$cnt += 1;
								echo '
																			<tr style="font-size: 10pt">
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL2' . trim ( $cnt ) . '" name="SEL2[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL3' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL3' . trim ( $cnt ) . '" name="SEL3[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL2' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																				</td>
																			</tr>';
							
																		endif;
						}
						echo '
																</table>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				echo '
										</tr>';
			
									endif;
			// Major Category ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $JI ) != '' || trim ( $JE ) != '') :
				echo '
										<tr>';
				echo '
											<td>
												<a name="maj">';
				if (trim ( $SEL ) != "J") :
					echo '
													<span title="Click to expand">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'J\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
													<span title="Click to shrink">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				echo '
												Major Categories
												</a>';
				if (trim ( $JI ) != '' || trim ( $JE ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $JI ) != '') {
						echo trim ( $JI ) . ' included';
					}
					if (trim ( $JI ) != '' && trim ( $JE ) != '') {
						echo ', ';
					}
					if (trim ( $JE ) != '') {
						echo trim ( $JE ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '			
											</td>';
				if (trim ( $SEL ) == "J") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '	
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Major Category
																	</th>
																</tr>
												';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 10pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['code'] ) . '">
																				</td>';
							
																			endif;
							echo '
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					if ($PROTECT == 'N') :
						echo '
														<tr>
															<td valign="top" align="center">
																<br><font color="' . $DARK . '"><b>Not Selected</b></font>
																<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																	<tr align="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">
																		
																		<th valign="bottom">
																			<br>
																			Include
																		</th>
																		<th valign="bottom">
																			Exclude
																		</th>
																		<th valign="bottom">
																			Major Category
																		</th>
																	</tr>';
						$cnt = 0;
						foreach ( $table3 as $t3 ) {
							if (trim ( $t3 ['incexc'] ) == '') :
								$cnt += 1;
								echo '
																			<tr style="font-size: 10pt">
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL2' . trim ( $cnt ) . '" name="SEL2[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL3' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL3' . trim ( $cnt ) . '" name="SEL3[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL2' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																				</td>
																			</tr>';
							
																		endif;
						}
						echo '
																</table>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				echo '
										</tr>';
			
									endif;
			// Product Category ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $MI ) != '' || trim ( $ME ) != '') :
				echo '
										<tr>';
				echo '
											<td>
												<a name="min">';
				if (trim ( $SEL ) != "M") :
					echo '
													<span title="Click to expand">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'M\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
													<span title="Click to shrink">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				echo '
												Minor Categories
												</a>';
				if (trim ( $MI ) != '' || trim ( $ME ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $MI ) != '') {
						echo trim ( $MI ) . ' included';
					}
					if (trim ( $MI ) != '' && trim ( $ME ) != '') {
						echo ', ';
					}
					if (trim ( $ME ) != '') {
						echo trim ( $ME ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '
											</td>';
				if (trim ( $SEL ) == "M") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Minor Category
																	</th>
																</tr>
												';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 10pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['code'] ) . '">
																				</td>';
							
																			endif;
							echo '
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					
					if ($PROTECT == 'N') :
						echo '
														<tr>
															<td valign="top" align="center">
																<br><font color="' . $DARK . '"><b>Not Selected</b></font>
																<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																	<tr align="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">
																		<th valign="bottom">
																			<br>
																			Include
																		</th>
																		<th valign="bottom">
																			Exclude
																		</th>
																		<th valign="bottom">
																			Minor Category
																		</th>
																	</tr>';
						$cnt = 0;
						foreach ( $table3 as $t3 ) {
							if (trim ( $t3 ['incexc'] ) == '') :
								$cnt += 1;
								echo '
																			<tr style="font-size: 10pt">
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL2' . trim ( $cnt ) . '" name="SEL2[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL3' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL3' . trim ( $cnt ) . '" name="SEL3[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL2' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																				</td>
																			</tr>';
							
																		endif;
						}
						echo '
																</table>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				echo '
										</tr>';
			
									endif;
			// Cigarette Brands  ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $BI ) != '' || trim ( $BE ) != '') :
				echo '
										<tr>';
				echo '
											<td>
												<a name="bnd">';
				if (trim ( $SEL ) != "B") :
					echo '
													<span title="Click to expand">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'B\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
													<span title="Click to shrink">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				echo '
												Cigarette Brands
												</a>';
				if (trim ( $BI ) != '' || trim ( $BE ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $BI ) != '') {
						echo trim ( $BI ) . ' included';
					}
					if (trim ( $BI ) != '' && trim ( $BE ) != '') {
						echo ', ';
					}
					if (trim ( $BE ) != '') {
						echo trim ( $BE ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '
											</td>';
				if (trim ( $SEL ) == "B") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Cigarette Brand
																	</th>
																</tr>
												';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 10pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['code'] ) . '">
																				</td>';
							
																			endif;
							echo '
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					if ($PROTECT == 'N') :
						echo '
														<tr>
															<td valign="top" align="center">
																<br><font color="' . $DARK . '"><b>Not Selected</b></font>
																<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																	<tr align="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">
																		<th valign="bottom">
																			<br>
																			Include
																		</th>
																		<th valign="bottom">
																			Exclude
																		</th>
																		<th valign="bottom">
																			Cigarette Brand
																		</th>
																	</tr>';
						$cnt = 0;
						foreach ( $table3 as $t3 ) {
							if (trim ( $t3 ['incexc'] ) == '') :
								$cnt += 1;
								echo '
																			<tr style="font-size: 10pt">
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL2' . trim ( $cnt ) . '" name="SEL2[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL3' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL3' . trim ( $cnt ) . '" name="SEL3[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL2' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td class="dottedtop">' . trim ( $t3 ['code'] ) . '
																				</td>
																			</tr>';
							
																		endif;
						}
						echo '
																</table>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				echo '
										</tr>';
			
									endif;
			// Corporate Vendors ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $VI ) != '' || trim ( $VE ) != '') :
				echo '
										<tr>';
				echo '
											<td>
												<a name="vnd">';
				if (trim ( $SEL ) != "V") :
					echo '
													<span title="Click to expand">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'V\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
													<span title="Click to shrink">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				echo '
												Corporate Vendors
												</a>';
				if (trim ( $VI ) != '' || trim ( $VE ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $VI ) != '') {
						echo trim ( $VI ) . ' included';
					}
					if (trim ( $VI ) != '' && trim ( $VE ) != '') {
						echo ', ';
					}
					if (trim ( $VE ) != '') {
						echo trim ( $VE ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '
											</td>';
				if (trim ( $SEL ) == "V") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Corporate Vendor
																	</th>
																</tr>
												';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 10pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['code'] ) . '">
																				</td>';
							
																			endif;
							echo '	
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					if ($PROTECT == 'N') :
						echo '
														<tr>
															<td valign="top" align="center">
																<br><font color="' . $DARK . '"><b>Not Selected</b></font>
																<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																	<tr align="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">
																		<th valign="bottom">
																			<br>
																			Include
																		</th>
																		<th valign="bottom">
																			Exclude
																		</th>
																		<th valign="bottom">
																			Corporate Vendor
																		</th>
																	</tr>';
						$cnt = 0;
						foreach ( $table3 as $t3 ) {
							if (trim ( $t3 ['incexc'] ) == '') :
								$cnt += 1;
								echo '
																			<tr style="font-size: 10pt">
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL2' . trim ( $cnt ) . '" name="SEL2[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL3' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" id="SEL3' . trim ( $cnt ) . '" name="SEL3[]" value="' . trim ( $SEL ) . trim ( $t3 ['code'] ) . '" onclick="if (this.checked == true){document.getElementById(\'SEL2' . trim ( $cnt ) . '\').checked = false;}">
																				</td>
																				<td class="dottedtop">' . trim ( $t3 ['code'] ) . ' - ' . trim ( $t3 ['codnam'] ) . ' 
																				</td>
																			</tr>';
							
																		endif;
						}
						echo '
																</table>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				echo '
										</tr>';
			
									endif;
			// Individual Items ---------------------------------------------------
			if ($PROTECT == 'N' || trim ( $II ) != '' || trim ( $IE ) != '') :
				echo '
										<tr>';
				echo '
											<td>
												<a name="itm">';
				if (trim ( $SEL ) != "I") :
					echo '
													<span title="Click to expand">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if(Edit()){document.form.SEL.value=\'I\';document.form.l_button.value=\'Process Changes\';document.form.submit(); } else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/plus.gif" width="11" height="11">';
				 else :
					echo '
													<span title="Click to shrink">
													<a href="javascript:document.form.l_button.value=\'Process Changes\';if (Edit()){document.form.SEL.value=\'\';document.form.l_button.value=\'Process Changes\';document.form.submit();}else javascript:void(0)" STYLE="color:BLACK;text-decoration:none" onmouseover="this.style.color=\'RED\';" onmouseout="this.style.color=\'BLACK\';">
													<img border="0" src="/images/minus.gif" width="11" height="11">';
				endif;
				echo '
												Hackney Items
												</a>';
				if (trim ( $II ) != '' || trim ( $IE ) != '') {
					echo '<font size="-1"><b>(';
					if (trim ( $II ) != '') {
						echo trim ( $II ) . ' included';
					}
					if (trim ( $II ) != '' && trim ( $IE ) != '') {
						echo ', ';
					}
					if (trim ( $IE ) != '') {
						echo trim ( $IE ) . ' excluded';
					}
					echo ')</b></font>';
				}
				echo '
											</td>';
				if (trim ( $SEL ) == "I") :
					echo '
												</tr><tr><td>
												<table border="0" cellpadding="0" cellspacing="0" width="95%" align="center">
													<tr>
														<td valign="top" align="center">
															<br>
															<font color="' . $DARK . '"><b>Selected</b></font>
															<table border="0" cellpadding="0" cellspacing="2" width="100%" align="center">
																<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
					if ($PROTECT == 'N') :
						echo '
																		<th>
																			Remove
																		</th>';
					
																	endif;
					echo '
																	<th>
																		Include/<br>Exclude
																	</th>
																	<th>
																		Item No.
																	</th>
																	<th>
																		Pack
																	</th>
																	<th>
																		Size
																	</th>
																	<th>
																		Description
																	</th>
																</tr>';
					foreach ( $table3 as $t3 ) {
						if (trim ( $t3 ['incexc'] ) != '') :
							echo '
																		<tr  style="font-size: 7pt">';
							if ($PROTECT == 'N') :
								echo '
																				<td align="center" class="dottedtop">
																					<input type= "checkbox" name="SEL1[]" value="' . trim ( $SEL ) . trim ( $t3 ['incexc'] ) . trim ( $t3 ['item'] ) . '">
																				</td>';
							
																			endif;
							echo '
																			<td align="center" class="dottedtop">';
							if (trim ( $t3 ['incexc'] ) == 'E') :
								echo 'Exclude';
							 else :
								echo 'Include';
							endif;
							echo '
																			</td>
																			<td class="dottedtop" align="center">' . trim ( $t3 ['item'] ) . ' 
																			</td>
																			<td class="dottedtop" align="center">' . trim ( $t3 ['pack'] ) . ' 
																			</td>
																			<td class="dottedtop" align="center">' . trim ( $t3 ['size'] ) . ' 
																			</td>
																			<td class="dottedtop">' . trim ( $t3 ['desc'] ) . ' 
																			</td>
																		</tr>
																		';
						
																	endif;
					}
					echo '
															</table>
														</td>
													</tr>';
					if ($PROTECT == 'N') :
						echo '
														<tr>
															<td>
																<h3 align="center" style="margin-top: 20; margin-bottom: 0">
											    					Add Items to Include
												    			</h3>
												    			<h4 align="center" style="margin-top: 0; margin-bottom: 5;font-size: 8pt"">
												   					(Separate by blanks or commas)
												   				</h4>
															</td>
														</tr>
														<tr>
															<td align="right" style="font-size:8pt">
																Need to find an item? <input style="font-size:8pt" type="submit" name="l_submit" value="Selection Tool" style="font-size: 8pt" onclick="document.form.l_button.value=\'Selection Tool\'">
															</td>
														</tr>
														<tr>
															<td>
																<center><textarea name="SEL2" cols="60" rows="4" wrap>' . $SEL2 . '</textarea></center><br>
															</td>
														</tr>';
					
													endif;
					echo '
												</table>
												</td>';
				
											endif;
				?>			
							 			</tr>
							 		
			<?endif;?>
						 		</table>
				</td>
				<td>&nbsp;&nbsp;</td>
				<td width="55%" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td>
						<h4 align="center">Below Items are included in this Item Grouping</h4>
						<table border="0" cellpadding="0" cellspacing="2" width="100%"
							align="center">
<?php
			echo '
												<tr><td colspan="5">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td width="100%" align="center">
																<font size="2">Item Filter:</font><br>
																<font size="-2">(Hackney Item # or partial UPC can also be entered)</font><br>
																<input type="text" name="FILTER" size="30" maxlength="30" value="' . $FILTER . '" class="fill">
															</td>
														</tr>
													
														<tr>
															<td align="center" valign="top">
																<font size="1">
																	<input type="radio" name="SEL5" value="01"';
			if ($SEL5 != "02")
				echo 'checked';
			echo '
																	>Contains
																	<input type="radio" name="SEL5" value="02"';
			if ($SEL5 == "02")
				echo 'checked';
			echo '
																	>Starts with<br><br>
																</font>
															</td>
														</tr>
													</table>
												</td></tr>
												<tr><td colspan="5">';
			$PARMS = 'document.form.l_button.value=\'Process Changes\'';
			$MACRO = 'itemgrouping.php?HTML=Group&l_button=' . urlencode ( trim ( $l_button ) ) . '&GRPID=' . trim ( $GRPID ) . '&GRPNAM=' . urlencode ( trim ( $GRPNAM ) ) . '&LEVEL=' . urlencode ( trim ( $LEVEL ) ) . '&SEL=' . trim ( $SEL ) . '&SEL5=' . trim ( $SEL5 ) . '&FILTER=' . urlencode ( trim ( $FILTER ) ) . '&LISTKEY=' . trim ( $LISTKEY );
			PhoneBook ();
			echo '
												</td></tr>
												<tr valign="center" style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . ';font-size: 10pt">';
			if ($PROTECT == 'N') :
				echo '
														<th>
															Exclude
														</th>';
			
													endif;
			echo '
													<th>
														Item No.
													</th>
													<th>
														Pack
													</th>
													<th>
														Size
													</th>
													<th>
														Description
													</th>
												</tr>
												';
			if (sizeof ( $table4 ) == "0") :
				echo '
													<tr valign="center" style="font-size: 12pt">
														<td colspan="5" align="center">
															<br><font color="red">No Items have been loaded.</font>
														</td>
														
													</tr>
													';
			
												endif;
			if (trim ( $page ) == '1' and trim ( $fitem ) != "*FIRST") {
				$table4 = array_reverse ( $table4 );
			}
			foreach ( $table4 as $t4 ) {
				echo '
													<tr  style="font-size: 10pt">';
				if ($PROTECT == 'N') :
					echo '
															<td align="center" class="dottedtop">
																<input type= "checkbox" name="SEL4[]" value="' . trim ( $t4 ['item'] ) . '">
															</td>';
				
														endif;
				echo '
														<td class="dottedtop" align="center">' . trim ( $t4 ['item'] ) . ' 
														</td>
														<td class="dottedtop" align="center">' . trim ( $t4 ['pack'] ) . ' 
														</td>
														<td class="dottedtop" align="center">' . trim ( $t4 ['size'] ) . ' 
														</td>
														<td class="dottedtop">' . trim ( $t4 ['desc'] ) . ' 
														</td>
													</tr>
													';
			}
			?>
											</table>
						</td>
					</tr>
				</table>
				</td>
			</tr>
			
		</table>
		</td>
	</tr>
	<tr>
	<td align="right" colspan="2">
	<input type="submit" value="Process" name="SUBMIT_BUTTON2"
				onclick="document.form.l_button.value='Process Changes'">&nbsp;&nbsp;

			</td>
	</tr>
	
	<?if($PROTECT != 'Y'):?>
	<tr>
			<td colspan="2">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a name="SHARE">
				<h4>Who do you want to share this item grouping with?</h4>
			</td>
			
		</tr>
		
	
		<tr>
			<td colspan="2">
				<table border="0"cellpadding="0" cellspacing="0" width="100%" align="left">
					<?if(count($table2) != 0):?>
					<tr>
						<td valign="center" width="25%" class="dottedtop">
							All users attached to Warehouses:
						</td>
						<td class="dottedtop">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
								<tr>
									<th align="center" width="45%">
										<font color="#330000">Unselected Warehouses</font>
									</th>
									<th align="center" valign="center">
										&nbsp;
									</th>
									<th align="center" width="45%">
										<font color="#330000">Selected Warehouses</font>
									</th>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
								<tr>

								</tr>
								<tr>
									<td align="center" valign="top">
										<select size="4" name="WHSEU" multiple>

<?php 
										foreach ( $table2 as $t2 ) {
											if (trim ( $t2 ['incexc']) != "Y"):
												echo '<option value = "' . trim ( $t2 ['whsno']) . '"'.'>';
												if (trim($t2 ['whsno']) != "-1")
													echo trim ( $t2 ['whsno'] ) . ' ';
												echo trim ( $t2 ['whsnam'] ) . '</option>';
											endif;
										}
?>								
										</select>
									</td>
									<td align="center" valign="center">
										<br>
										<input type="submit" name="l_submit" value="Move -->" Style="font:7pt" onClick="document.form.l_button.value = '34';">
										<br><br>
										<input type="submit" name="l_submit" value="<-- Move" Style="font:7pt" onClick="document.form.l_button.value = '35';">
									</td>
									<td align="center" valign="top">

										<select size="4" name="WHSEA" multiple>

<?php 
										foreach ( $table2 as $t2 ) {
											if (trim ( $t2 ['incexc']) == "Y"):
												echo '<option value = "' . trim ( $t2 ['whsno'] . '"' ).'>';
												if (trim($t2 ['whsno']) != "-1")
													echo trim ( $t2 ['whsno'] ) . ' ';
												echo trim ( $t2 ['whsnam'] ) . '</option>';
											endif;
										}
?>
										</select>
									</td>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							</table>								
						</td>						
					</tr>
					<?else:?>
						<input type="hidden" name="WHSEA">
						<input type="hidden" name="WHSEU">
					<?endif;?>
					<?if(count($table5) != 0):?>	
					<tr>
						<td width="20%" valign="center" class="dottedtop">
							All Users attached to Entities:
						</td>
						<td class="dottedtop">						
							<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
								<tr>
									<th align="center" width="45%">
										<font color="#330000">Unselected Entities</font>
									</th>
									<th align="center" valign="center">
										&nbsp;
									</th>
									<th align="center" width="45%">
										<font color="#330000">Selected Entities</font>
									</th>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
								<tr>
									<td align="center">
										<font size="2">Locate an Entity:<br></font>
										<input type="text" name="ENTITYUU" size="50" maxlength="50" value="" class="fill"
										onkeyup="lookup(this.value,this.form.ENTITYU)" onchange="lookup(this.value,this.form.ENTITYU)">
									</td>
									<td>&nbsp;</td>
									<td align="center">
										<font size="2">Locate an Entity:<br></font>
										<input type="text" name="ENTITYAA" size="50" maxlength="50" value="" class="fill"
										onkeyup="lookup(this.value,this.form.ENTITYA)" onchange="lookup(this.value,this.form.ENTITYA)">
									</td>
								</tr>
								<tr>
									<td align="center" valign="top">
										<select size="4"name="ENTITYU" multiple>
										<option VALUE="*NONE" Selected>--------------------------------------------------</option>
										<?php 
										foreach ( $table5 as $t5 ) {
											if (trim ( $t5 ['incexc']) != "Y"):
												echo '<option value = "' . trim ( $t5 ['entyid'] . '"' ).'>' . trim ( $t5 ['entynm'] )  . '</option>';
											endif;
										}
										?>
										</select>
									</td>
									<td align="center" valign="center">
										<br>
										<input type="submit" name="l_submit" value="Move -->" Style="font:7pt" onClick="document.form.l_button.value = '30';">
										<br><br>
										<input type="submit" name="l_submit" value="<-- Move" Style="font:7pt" onClick="document.form.l_button.value = '31';">
									</td>
									<td align="center" valign="top">
										<select size="4" name="ENTITYA" multiple>
										<option VALUE="*NONE" Selected>--------------------------------------------------</option>
										<?php 
										foreach ( $table5 as $t5 ) {
											if (trim ( $t5 ['incexc']) == "Y"):
												echo '<option value = "' . trim ( $t5 ['entyid'] . '"' ).'>' . trim ( $t5 ['entynm'] )  . '</option>';
											endif;
										}
										?>
										</select>

									</td>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							</table>								
						</td>
					</tr>
					<?else:?>
						<input type="hidden" name="ENTITYA">
						<input type="hidden" name="ENTITYU">
					<?endif;?>	
					<?if(count($table6) != 0):?>	
					<tr>
						<td valign="center" width="15%" class="dottedtop">
							Specific Users:
						</td>
						<td class="dottedtop">	
							<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
								<tr>
									<th align="center" width="45%">
										<font color="#330000">Unselected Web Users</font>
									</th>
									<th align="center" valign="center">
										&nbsp;
									</th>
									<th align="center" width="45%">
										<font color="#330000">Selected Web Users</font>
									</th>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
								<tr>
									<td align="center">
										<font size="2">Locate a User:<br></font>
										<input type="text" name="USERUU" size="50" maxlength="50" value="" class="fill"
										onkeyup="lookup(this.value,this.form.USERU);" onchange="lookup(this.value,this.form.USERU)">
									</td>
									<td>&nbsp;</td>
									<td align="center">
										<font size="2">Locate a User:<br></font>
										<input type="text" name="USERAA" size="50" maxlength="50" value="" class="fill"
										onkeyup="lookup(this.value,this.form.USERA)" onchange="lookup(this.value,this.form.USERA)">
									</td>
								</tr>
								<tr>
									<td align="center" valign="top">
										<select size="4" name="USERU" multiple>
										<option VALUE="*NONE" Selected>--------------------------------------------------</option>
										<?php 
										foreach ( $table6 as $t6 ) {
											if (trim ( $t6 ['incexc']) != "Y"):
												echo '<option value = "' . trim ( $t6 ['userid'] . '"' ).'>' . trim ( $t6 ['usernm'] ).' ('. trim ( $t6 ['userid'] ).')'  . '</option>';
											endif;
										}
										?>
										</select>
									</td>
									<td align="center" valign="center">
										<br>
										<input type="submit" name="l_submit" value="Move -->" Style="font:7pt" onClick="document.form.l_button.value = '32';">
										<br><br>
										<input type="submit" name="l_submit" value="<-- Move" Style="font:7pt" onClick="document.form.l_button.value = '33';">
									</td>
									<td align="center" valign="top">
										<select size="4" name="USERA" multiple>
										<option VALUE="*NONE" Selected>--------------------------------------------------</option>
										<?php 
										foreach ( $table6 as $t6 ) {
											if (trim ( $t6 ['incexc']) == "Y"):
												echo '<option value = "' . trim ( $t6 ['userid'] . '"' ).'>' . trim ( $t6 ['usernm'] ).' ('. trim ( $t6 ['userid'] ).')'  . '</option>';
											endif;
										}
										?>
										</select>									
									</td>
								</tr>
								<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							</table>							
						</td>
					</tr>
					<?else:?>
						<input type="hidden" name="USERA">
						<input type="hidden" name="USERU">	
					<?endif;?>				
				</table>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	
<?endif?>
	<tr>
		<td>
		<hr>
		</td>
	</tr>		
		<?endif;
		?>
		</table>
</form>
<p align="center"><a href="/images/item grouping.pdf" target="_BLANK">View
User Guide</a> <a
	href="http://www.adobe.com/products/acrobat/readstep2.html"
	target="_BLANK"><img src="/Images/get_adobe_reader.gif" width="81"
	height="31" border="0"></a> <br>
</p>	
	<? // Include the standard page footer		?>
	<?
		include 'footer.inc';
		?>

	<? // Load web page specific menu bar entries, such as DOWNLOAD 		?>
	<script language="javascript">
		if(top.frames.length != "0"){	
			parent.banner.AddTopMenu.length=0;  //NEVER DELETE THIS LINE OF CODE 
			parent.banner.AddSubMenu.length=0;  //NEVER DELETE THIS LINE OF CODE
		}
	</script>
<?php
		// Load the menu bar 
		include 'menubar.inc';
		
		// display the alert window if there is an error for this web page 
		If (trim ( $ERRORD ) != "")
			//echo $ERRORD;
			error ( $ERRORD );
		elseif (trim ( $ERROR ) != "")
			error ( $ERROR );
		elseif (trim ( $ERROR1 ) != "")
			error ( $ERROR1 );
?>

<? //Validate form?>	
<SCRIPT LANGUAGE="JavaScript"><!--

<?include "js_trim.inc";?>

function Edit() { 

<?php
		echo '
	
	if(trim(document.form.l_button.value) == "Process Changes"){
		for (var i = 0; i < document.form.GRPID.length; i++) { 
			if(document.form.GRPID[i].value.length >= 2){
				if (document.form.GRPID[i].value.substr(2) == document.form.ORIGGRPID.value.substr(2)) {
					document.form.GRPID[i].selected = true; 
					break;        
				}
			}
		}
		if (document.form.GRPNAM) {
			if (trim(document.form.GRPNAM.value) == "") {
				alert("Group Name must be supplied.");
				document.form.GRPNAM.focus();
				return false;
			}
		}
	}
	if (document.form.l_button.value == "Select" && (document.form.GRPID.value == "SEL" || (document.form.GRPID.value.substr(0,1) == "A" && document.form.GRPID.value != "ADD"))) {
		alert("You have not selected an Item Grouping.");
		document.form.GRPID[0].selected = true;
		document.form.GRPID.focus();
		return false;
	}';
		if ($l_power != 'Y') :
			echo '
		if (document.form.l_button.value == "Delete" && trim(document.form.GRPID.value.substr(2,10)) != "'.trim($USER).'") {
			alert("You do not have the proper authority to delete this item grouping.");
			for (var i = 0; i < document.form.GRPID.length; i++) { 
				if(document.form.GRPID[i].value.length >= 2){
					if (document.form.GRPID[i].value.substr(2) == document.form.ORIGGRPID.value.substr(2)) {
						document.form.GRPID[i].selected = true; 
						break;        
					}
				}
			}
			document.form.GRPID.focus();
			return false;
		}
		
		';
		
	endif;
		echo '
	if ((document.form.l_button.value == "Copy" || document.form.l_button.value == "Delete" )&& (document.form.GRPID.value == "SEL" || document.form.GRPID.value == "ADD" || document.form.GRPID.value.substr(0,1) == "A")) {
		alert("You have not selected an Item Grouping.");
		document.form.GRPID[0].selected = true;
		document.form.GRPID.focus();
		return false;
	}
	if (document.form.l_button.value == "Delete" && document.form.GRPID.value.substr(1,1) == "Y") {
		alert("Grouping cannot be deleted because it is integrated into other web pages.");
		for (var i = 0; i < document.form.GRPID.length; i++) { 
			if(document.form.GRPID[i].value.length >= 5){
				if (document.form.GRPID[i].value.substr(5) == document.form.ORIGGRPID.value.substr(5)) {
					document.form.GRPID[i].selected = true; 
					break;        
				}
			}
		}
		document.form.GRPID.focus();
		return false;
	}';
		?>
	document.form.WHSU.value = '';
	comma= '';
	if (document.form.WHSEU){
		for (var i = 0; i < document.form.WHSEU.length; i++) { 
			if (document.form.WHSEU[i].selected == true) {
				document.form.WHSU.value = trim(document.form.WHSU.value) + trim(comma) +trim(document.form.WHSEU[i].value);
				comma= ',';
			}
		}
	}
	document.form.WHSA.value = '';
	comma= '';
	comma= '';
	if (document.form.WHSEA){
		for (var i = 0; i < document.form.WHSEA.length; i++) { 
			if (document.form.WHSEA[i].selected == true) {
				document.form.WHSA.value = trim(document.form.WHSA.value) + trim(comma) +trim(document.form.WHSEA[i].value);
				comma= ',';
			}
		}
	}
	document.form.ENTU.value = '';
	comma= '';
	comma= '';
	if (document.form.ENTITYU){
		for (var i = 0; i < document.form.ENTITYU.length; i++) { 
			if (document.form.ENTITYU[i].selected == true) {
				document.form.ENTU.value = trim(document.form.ENTU.value) + trim(comma) +trim(document.form.ENTITYU[i].value);
				comma= ',';
			}
		}
	}
	document.form.ENTA.value = '';
	comma= '';
	if (document.form.ENTITYA){
		for (var i = 0; i < document.form.ENTITYA.length; i++) { 
			if (document.form.ENTITYA[i].selected == true) {
				document.form.ENTA.value = trim(document.form.ENTA.value) + trim(comma) +trim(document.form.ENTITYA[i].value);
				comma= ',';
			}
		}
	}
	document.form.USRU.value = '';
	comma= '';
	if (document.form.USERU){
		for (var i = 0; i < document.form.USERU.length; i++) { 
			if (document.form.USERU[i].selected == true) {
				document.form.USRU.value = trim(document.form.USRU.value) + trim(comma) +trim(document.form.USERU[i].value);
				comma= ',';
			}
		}
	}
	document.form.USRA.value = '';
	comma= '';
	if (document.form.USERA){
		for (var i = 0; i < document.form.USERA.length; i++) { 
			if (document.form.USERA[i].selected == true) {
				document.form.USRA.value = trim(document.form.USRA.value) + trim(comma) +trim(document.form.USERA[i].value);
				comma= ',';
			}
		}
	}
		
	return true;
}
//--></script>

<?endif;?>


</body>
</html>
<?php
}

/********************************************************************************* 
 * Phone Book paging
 **********************************************************************************/
function PhoneBook() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	if (($DSP_PREV != "N" || $DSP_NEXT != "N") && trim ( $LOADSEL1 ) != 'CS') :
		echo '
	<div align="center"> <div class="smallest">';
		if ($DSP_PREV != "N") :
			echo '<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=1;document.form.FITEM.value=\'' . urlencode ( trim ( $FITEM ) ) . '\';if (Edit()){document.form.submit();}else javascript:void(0)" class="page">
		Prev</a>
		|';
		
	endif;
		if ($DSP_FIRST != "N") :
			echo '
		<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=1;document.form.FITEM.value=\'*FIRST\';if (Edit()){document.form.submit();}else javascript:void(0)" class="page">	
		1st</a>
		|';
		
	endif;
		$alpha = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
		foreach ( $alpha as $a ) {
			if (trim ( $PAGE ) != $a) :
				echo '
			<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=\'' . trim ( $a ) . '\';if (Edit()){document.form.submit();}else javascript:void(0)" class="page">' . $a . '</a>
			|';
			 else :
				echo '
				<font size="+2" color="' . $DARK . '">' . $a . '</font> |
			';
			endif;
		}
		if (trim ( $PAGE ) != '0') :
			echo '
			<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=0;if (Edit()){document.form.submit();}else javascript:void(0)" class="page">	
			0-9</a>
			|';
		 else :
			echo '
				<font size="+2" color="' . $DARK . '">0-9</font> |
			';
		endif;
		if ($DSP_LAST != "N") :
			echo '
		<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=1;document.form.FITEM.value=\'*LAST\';if (Edit()){document.form.submit();}else javascript:void(0)" class="page">
		Last</a>';
		
	endif;
		if ($DSP_NEXT != "N") :
			echo '
		|
		<a href="javascript:' . trim ( $PARMS ) . ';document.form.PAGE.value=9;document.form.LITEM.value=\'' . urlencode ( trim ( $LITEM ) ) . '\';if (Edit()){document.form.submit();}else javascript:void(0)" class="page">
		Next</a>';
		
	endif;
		echo '
	<br><br>
	</div></div>';
	
endif;
}

/********************************************************************************* 
 * Load Group page
 **********************************************************************************/
function Load1() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_pconnect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB290 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 2, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 3, "FUNCTIONCODE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 4, "l_button", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 5, "GRPID", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 6, "ORGID", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 7, "CPYID", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 8, "GRPNAM", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 9, "AUTUSR", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 10, "FILTER", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 11, "SEL5", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 12, "SEL", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 13, "LISTKEY", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 14, "SI", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 15, "SE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 16, "JI", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 17, "JE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 18, "MI", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 19, "ME", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 20, "VI", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 21, "VE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 22, "BI", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 23, "BE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 24, "II", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 25, "IE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 26, "CORP", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 27, "l_power", DB2_PARAM_IN );
	
	db2_bind_param ( $stmt, 28, "PAGE", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 29, "FITEM", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 30, "LITEM", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 31, "DSP_PREV", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 32, "DSP_NEXT", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 33, "DSP_LAST", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 34, "DSP_FIRST", DB2_PARAM_INOUT );
	
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	// load the array for later processing
	$table1 = array (); // Item grouping
	$table2 = array (); // warehouse selections
	$table3 = array (); // include/exclude selections
	$table4 = array (); // list of items included
	$table5 = array (); // list of entities
	$table6 = array (); // list of web users
	$cnt1 = 0;
	$cnt2 = 0;
	$cnt3 = 0;
	$cnt4 = 0;
	$cnt5 = 0;
	$cnt6 = 0;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		if (trim ( $row [0] ) == 'a') : // Item Groupings
			$cnt1 += 1;
			$table1 [$cnt1] ['type'] = $row [0];
			$table1 [$cnt1] ['grpid'] = $row [1];
			$table1 [$cnt1] ['grpnam'] = $row [2];
			$table1 [$cnt1] ['protect'] = $row [3];
			$table1 [$cnt1] ['level'] = $row [4];
			$table1 [$cnt1] ['userid'] = $row [5];
			$table1 [$cnt1] ['whsno'] = $row [7];
			$table1 [$cnt1] ['whsnam'] = $row [8];
		 elseif (trim ( $row [0] ) == 'b') : // warehouse selections
			$cnt2 += 1;
			$table2 [$cnt2] ['type'] = $row [0];
			$table2 [$cnt2] ['whsno'] = $row [7];
			$table2 [$cnt2] ['whsnam'] = $row [8];
			$table2 [$cnt2] ['incexc'] = $row [11];
		 elseif (trim ( $row [0] ) == 'c') : // include/exclude selections
			$cnt3 += 1;
			$table3 [$cnt3] ['type'] = $row [0];
			$table3 [$cnt3] ['code'] = $row [9];
			$table3 [$cnt3] ['codnam'] = $row [10];
			$table3 [$cnt3] ['incexc'] = $row [11];
			$table3 [$cnt3] ['item'] = $row [12];
			$table3 [$cnt3] ['pack'] = $row [13];
			$table3 [$cnt3] ['size'] = $row [14];
			$table3 [$cnt3] ['desc'] = $row [15];
		 elseif (trim ( $row [0] ) == 'd') : // item list
			$cnt4 += 1;
			$table4 [$cnt4] ['type'] = $row [0];
			$table4 [$cnt4] ['item'] = $row [12];
			$table4 [$cnt4] ['pack'] = $row [13];
			$table4 [$cnt4] ['size'] = $row [14];
			$table4 [$cnt4] ['desc'] = $row [15];
		elseif (trim ( $row [0] ) == 'e') : // entity list
			$cnt5 += 1;
			$table5 [$cnt5] ['type'] = $row [0];
			$table5 [$cnt5] ['entyid'] = $row [1];
			$table5 [$cnt5] ['entynm'] = $row [2];
			$table5 [$cnt5] ['incexc'] = $row [11];
		elseif (trim ( $row [0] ) == 'f') : // web user list
			$cnt6 += 1;
			$table6 [$cnt6] ['type'] = $row [0];
			$table6 [$cnt6] ['userid'] = $row [5];
			$table6 [$cnt6] ['usernm'] = $row [6];
			$table6 [$cnt6] ['incexc'] = $row [11];
		endif;
	}
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );

		//print_r($table6);
}
/********************************************************************************* 
 * Load Group page
 **********************************************************************************/
function Load2() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_pconnect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB291 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 2, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 3, "FUNCTIONCODE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 4, "LISTKEY", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 5, "l_button", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 6, "GRPID", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 7, "LOADSEL1", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 8, "LOADSEL2", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 9, "FILTER", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 10, "SEL01", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 11, "HEADER", DB2_PARAM_OUT );
	
	db2_bind_param ( $stmt, 12, "PAGE", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 13, "FITEM", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 14, "LITEM", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 15, "DSP_PREV", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 16, "DSP_NEXT", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 17, "DSP_LAST", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 18, "DSP_FIRST", DB2_PARAM_INOUT );
	
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	// load the array for later processing
	$table1 = array (); // Item selections
	$table2 = array (); // grouping selections
	$cnt1 = 0;
	$cnt1 = 0;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		if (trim ( $row [0] ) == 'a') : // Items
			$cnt1 += 1;
			$table1 [$cnt1] ['type'] = $row [0];
			$table1 [$cnt1] ['checked'] = $row [1];
			$table1 [$cnt1] ['itemno'] = $row [2];
			$table1 [$cnt1] ['descpt'] = $row [3];
			$table1 [$cnt1] ['pack'] = $row [4];
			$table1 [$cnt1] ['size'] = $row [5];
		 elseif (trim ( $row [0] ) == 'b') : // groups
			$cnt2 += 1;
			$table2 [$cnt2] ['type'] = $row [0];
			$table2 [$cnt2] ['code'] = $row [6];
			$table2 [$cnt2] ['codnam'] = $row [7];
		endif;
	
	}
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );

		//print_r($table1);
}

/********************************************************************************* 
 * Select items to include
 **********************************************************************************/

function SelectionTool() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	//Load local variables
	

	$FUNCTIONCODE = 'ITEMGROUPING'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
	$PAGEID = 'SELECTIONTOOL'; // Set equal to "*SKIP" if logging is not desired 
	

	?>

<? //Do not allow Excel Download capability	?>
<?

	header ( "Content-Type: text/html" );
	?>

<html>
<head>
<title>The H.T. Hackney Co. - Item Grouping - Selection Tool</title>

<?php
	// Include standard Header code 
	include 'standardheadv03.inc';
	?>

<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
</head>
<body onload="check_frames();">
<?php
	//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
	if ($AUTH != 'Y') :
		$MACRO = 'NotAuthorized.mac/Display';
		echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
	 //Else, if all users are lock-out of this web page then display the Not-Available web page and DO NOT proceed further 
	elseif (trim ( $LOCKOUT ) != '') :
		$MACRO = 'NotAvailable.mac/Display?LOCKOUT=' . urlencode ( $LOCKOUT ) . '&MNUTXT=' . urlencode ( $MNUTXT );
		echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
	 //Else if the user's password has expired then force user to change it 
	elseif ($EXPIRED == 'Y') :
		$MACRO = 'ChangePassword.mac/Password';
		echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=', str_replace ( "^holymacro", $MACRO, $FULLURLMAC ), '">';
	 else :
		
		// process/load web page	
		$fitem = $FITEM;
		$page = $PAGE;
		Load2 ();
		?>
	<form method="POST" action="itemgrouping.php?HTML=Submit1" name="form"
	onSubmit="return Edit();">	
<?php
		$vars [] = 'FILTER'; // Load all FORM elements to this array <-------------
		$vars [] = 'SEL01';
		
		include 'hiddenfields.inc';
		?>				
		<? //If enter key is pressed, then we do not want to issue the 1st submit button.  Instead we want to override		?>
		<INPUT TYPE="image" SRC="/images/pixel.jpg" HEIGHT="1" WIDTH="1"
	BORDER="0" onclick="document.form.l_button.value='Reload'">

<table border="0" cellspacing="1" width="100%" align="center"
	style="font-size: 10pt" style="border-left: double #330000;">
	<tr>
		<td align="left" valign="top" style="background-color: #fde8c4">
		<table border="0" cellspacing="0" align="left"
			style="margin-top: 0; margin-bottom: 0; font-size: xx-small">
			<tr>
				<td><b><font style="background-color: #330000; color: #fde8c4">LIMIT
				SELECTIONS</font></b><br>
				<br>
				</td>
			</tr>
			<tr>
				<td><b><font style="color: #330000">Matching Description</font></b>
				</td>
			</tr>
			<tr>
				<td align="left"><input type="Text" name="FILTER" size="30"
					maxlength="30" value="<?
		echo trim ( $FILTER )?>" class="fill"><br>
				<input type="radio" name="SEL01" value="01"
					<?php
		if (trim ( $SEL01 ) == "" || trim ( $SEL01 ) == "01") :
			echo 'checked';
		
								endif;
		echo '
								>
								Contains
								<input type="radio" name="SEL01" value="02"';
		if (trim ( $SEL01 ) == "02") :
			echo 'checked';
		
								endif;
		?>> Starts with</td>
			</tr>
			<tr>
				<td align="center" colspan="2"><input type="submit" name="l_submit"
					value="Reload" style="font-size: 8pt"
					onclick="document.form.l_button.value='Reload';document.form.PAGE.value='1';document.form.PAGE.value='1';document.form.FITEM.value='*FIRST'">
				</td>
			</tr>
			<tr>
				<td style="border-top: double #330000;">
			    		<?
		$PARMS = 'document.form.l_button.value=\'Reload\'';
		?>
			    			<br>
				<b><font style="background-color: #330000; color: #fde8c4">ITEM
				GROUPINGS</font></b><br>
				<br>
				<input type="button" value="All Items" Style="font: 8pt"
					onclick="
									document.form.LOADSEL1.value='AL';
									document.form.LOADSEL2.value='';
									document.form.l_button.value='Reload';
									document.form.PAGE.value='1';
									document.form.FITEM.value='*FIRST';
									if (Edit()){document.form.submit();}else javascript:void(0)
								"> &nbsp; <input type="button" value="Current Selections"
					Style="font: 8pt"
					onclick="
									document.form.LOADSEL1.value='CS';
									document.form.LOADSEL2.value='';
									document.form.l_button.value='Reload';
									document.form.PAGE.value='1';
									document.form.FILTER.value='';
									if (Edit()){document.form.submit();}else javascript:void(0)
								"> <br>
				<br>
				<a href="javascript:<?
		echo trim ( $PARMS )?>;document.form.LOADSEL1.value='01';document.form.LOADSEL2.value='';if (Edit()){document.form.submit();}else javascript:void(0)"
								STYLE="color:<?
		echo $DARK?>" onmouseover="this.style.color='red';" onmouseout="this.style.color='<?
		echo $DARK?>';">
				Standard Invoice Categories </a><br>
				<a href="javascript:<?
		echo trim ( $PARMS )?>;document.form.LOADSEL1.value='03';document.form.LOADSEL2.value='';if (Edit()){document.form.submit();}else javascript:void(0)"
								STYLE="color:<?
		echo $DARK?>" onmouseover="this.style.color='red';" onmouseout="this.style.color='<?
		echo $DARK?>';">
				Major Categories </a><br>
				<a href="javascript:<?
		echo trim ( $PARMS )?>;document.form.LOADSEL1.value='02';document.form.LOADSEL2.value='';if (Edit()){document.form.submit();}else javascript:void(0)" 
								STYLE="color:<?
		echo $DARK?>" onmouseover="this.style.color='red';" onmouseout="this.style.color='<?
		echo $DARK?>';">
				Minor Categories </a><br>
				<a href="javascript:<?
		echo trim ( $PARMS )?>;document.form.LOADSEL1.value='04';document.form.LOADSEL2.value='';if (Edit()){document.form.submit();}else javascript:void(0)" 
								STYLE="color:<?
		echo $DARK?>" onmouseover="this.style.color='red';" onmouseout="this.style.color='<?
		echo $DARK?>';">
				Cigarette Brands </a><br>
				<a href="javascript:<?
		echo trim ( $PARMS )?>;document.form.LOADSEL1.value='05';document.form.LOADSEL2.value='';if (Edit()){document.form.submit();}else javascript:void(0)"
								STYLE="color:<?
		echo $DARK?>" onmouseover="this.style.color='red';" onmouseout="this.style.color='<?
		echo $DARK?>';">
				Corporate Vendors </a></td>
			</tr> 
		    		<?
		if (trim ( $LOADSEL1 ) != "" && trim ( $LOADSEL1 ) != "AL" && trim ( $LOADSEL1 ) != "CS") :
			?>
		    			<tr>
				<td style="border-top: double #330000;"><br>
		    					<? // Display the table for display 			?>
		    					<b><font style="background-color: #330000; color: #fde8c4">
<?php
			if (trim ( $LOADSEL1 ) == "01") :
				echo 'Standard invoice Categories';
			 elseif (trim ( $LOADSEL1 ) == "02") :
				echo 'Minor Categories';
			 elseif (trim ( $LOADSEL1 ) == "03") :
				echo 'Major Categories';
			 elseif (trim ( $LOADSEL1 ) == "04") :
				echo 'Cigarette Brands';
			 elseif (trim ( $LOADSEL1 ) == "05") :
				echo 'Corporate Vendors';
			endif;
			echo '
			    					</font></b>';
			if (trim ( $LOADSEL1 ) != "" && trim ( $LOADSEL1 ) != "AL" && trim ( $LOADSEL1 ) != "CS") :
				echo '
		    							<br><br>';
				Disp4 ();
			
									endif;
			echo '		
			    			</td>
			    		</tr>';
		
			    	endif;
		echo ' 	
		  		</table>
				</td>
				<td valign="top"  style="border-left: double #330000;" width= "75%">
					<h2 align="center">Item Selection Tool</h2>
					<h3 align="center">For Group: ' . $GRPNAM . '</h2>';
		// Display the table for display 
		Disp3 ();
		echo '
				</td>
			</tr>
		</table>							
		
		</form>	';
		?>
		
		<? // Include the standard page footer		?>
		<?
		include 'footer.inc';
		?>
	
		<? // Load web page specific menu bar entries, such as DOWNLOAD 		?>
		<script language="javascript">
			if(top.frames.length != "0"){	
				parent.banner.AddTopMenu.length=0;  //NEVER DELETE THIS LINE OF CODE 
				parent.banner.AddSubMenu.length=0;  //NEVER DELETE THIS LINE OF CODE
			}
		</script>
<?php
		// Load the menu bar 
		include 'menubar.inc';
		
		// display the alert window if there is an error for this web page 
		If (trim ( $ERRORD ) != "")
			//echo $ERRORD;
			error ( $ERRORD );
		elseif (trim ( $ERROR ) != "")
			error ( $ERROR );
		elseif (trim ( $ERROR1 ) != "")
			error ( $ERROR1 );
		?>

		<? //Validate form		?>	
		<SCRIPT LANGUAGE="JavaScript"><!--
		
		function Edit() {
			return true;
		}
		//--></script>

<?endif;?>


</body>
</html>
<?php
}

/********************************************************************************** 
 * Display items within a a selected group
 ***********************************************************************************/
function Disp3() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	echo '
 	<table border="0" cellspacing="1" width="100%" align="center" style="font-size: 10pt" style="margin-top:-10; margin-bottom:0">
		<tr>
			<td  align="center" colspan="10">
				<h3 align="center">';
	if (trim ( $LOADSEL1 ) == "CS") :
		echo 'Current Selections Loaded';
	 elseif (trim ( $LOADSEL1 ) == "" || trim ( $LOADSEL2 ) == "") :
		echo 'All Items Loaded';
	 elseif (trim ( $LOADSEL1 ) == "01") :
		echo 'Standard invoice Category: ' . trim ( $LOADSEL2 ) . ' - ' . trim ( $HEADER );
	 elseif (trim ( $LOADSEL1 ) == "02") :
		echo 'Minor Category: ' . trim ( $LOADSEL2 ) . ' - ' . trim ( $HEADER );
	 elseif (trim ( $LOADSEL1 ) == "03") :
		echo 'Major Category: ' . trim ( $LOADSEL2 ) . ' - ' . trim ( $HEADER );
	 elseif (trim ( $LOADSEL1 ) == "04") :
		echo 'Cigarette Brand: ' . trim ( $LOADSEL2 );
	 elseif (trim ( $LOADSEL1 ) == "05") :
		echo 'Corporate Vendor: ' . trim ( $HEADER );
	endif;
	echo '
				</h3>
			</td>	
		</tr>
		<tr>
			<td  align="center" colspan="10">
				<input type="submit" name="l_submit" value="Return - With Selections" 
				onclick="
					document.form.l_button.value=\'ReturnW\';
				"> 
				&nbsp;&nbsp;
				<input type="submit" name="l_submit" value="Return - IGNORE Selections" 
				onclick="
					document.form.l_button.value=\'ReturnWO\';
				">
				&nbsp;&nbsp;
				<input type="submit" name="l_submit" value="Clear Selections" 
				onclick="
					document.form.l_button.value=\'Clear\';
					document.form.LOADSEL1.value=\'\';
					document.form.LOADSEL2.value=\'\';
				">
			</td>	
		</tr>
		<tr>
			<td  align="center" colspan="10">';
	$PARMS = 'document.form.l_button.value=\'Reload\'';
	PhoneBook ();
	echo '
			</td>	
		</tr>
	    <tr style="background-color:' . $DARK . '; color:' . $LIGHTLETTER . '">
	    	<th>
	    		Select
	    	</th>
	    	<th>
	    		Item No.
	    	</th>
	    	<th>
	    		Pack
	    	</th>
	    	<th>
	    		Size
	    	</th>
	    	<th>
	    		Description
	    	</th>';
	if (sizeof ( $table1 ) == "0") :
		echo '
				<tr valign="center" style="font-size: 12pt">
					<td colspan="5">
						<br><font color="red">No Items have been Loaded. Change selection criteria.</font>
					</td>
				</tr>
				';
	
			endif;
	if (trim ( $page ) == '1' and trim ( $fitem ) != "*FIRST") {
		$table1 = array_reverse ( $table1 );
	}
	foreach ( $table1 as $t1 ) {
		echo '
				<tr>
		  			<td class="dottedtop"  align="center">
						<span title="Check to include"><input type="checkbox" name="NEWITEM[]" value="' . trim ( $t1 ['itemno'] ) . '" class="fill" ' . trim ( $t1 ['checked'] ) . '></span>
					</td>
					<td class="dottedtop"  align="center">
						<span title="Hackney Item Number">' . trim ( $t1 ['itemno'] ) . '</span>
					</td>
					<td class="dottedtop"  align="center">
						<span title="Pack">' . trim ( $t1 ['pack'] ) . '</span>
					</td>
					<td class="dottedtop"  align="center">
						<span title="Size">' . trim ( $t1 ['size'] ) . '</span>
					</td>
					<td class="dottedtop"  align="left">
						<span title="Description">' . trim ( $t1 ['descpt'] ) . '</span>
					</td>
				</tr>';
	}
	echo '</table>';
}

/********************************************************************************** 
 * Display detail within one item grouping - left side of web page
 ***********************************************************************************/
function Disp4() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	echo '
	<table border="0" cellspacing="0" width="100%" align="center" style="font-size:xx-small" style="margin-top: 0; margin-bottom: 0">';
	
	foreach ( $table2 as $t2 ) {
		echo '
			<tr>
				<td align="left">
					<a href="javascript:' . trim ( $PARMS ) . ';document.form.LOADSEL2.value=\'' . urlencode ( trim ( $t2 ['code'] ) ) . '\';document.form.l_button.value=\'Reload\';if (Edit()){document.form.submit();}else javascript:void(0)" 
					STYLE="color:' . $DARK . '" onmouseover="this.style.color=\'red\';" onmouseout="this.style.color=\'' . $DARK . '\';">';
		if ($LOADSEL1 == '05') :
			$t2 ['code'] = str_replace ( '*', ' ', $t2 ['code'] );
		
						endif;
		echo trim ( $t2 ['code'] );
		if (trim ( $t2 ['codnam'] ) != "" && trim ( $t2 ['codnam'] ) != trim ( $t2 ['code'] )) :
			echo ' - ' . trim ( $t2 ['codnam'] );
		
						endif;
		echo '
					</a>
				</td>
			</tr>';
	}
	echo '
	  </table>';
}

/********************************************************************************** 
 * Submit  
 ***********************************************************************************/
function Submit1() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	//Load variables
	$ORIG = "itemgrouping.php"; // Do Not set to t.mac for testing 
	$FUNCTIONCODE = 'ITEMGROUPING'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
	

	// Setup Parameters that are specific for the web page being executed 
	

	echo '<html><head><title>The H.T. Hackney Co. - Item Grouping Submit</title>';
	
	//Include the style sheet
	include "style.inc";
	echo '
</head>
<body>';
	
	echo $PLEASEWAIT;
	//print_r($_GET);
	//print_r($_POST);
	//print_r($GLOBALS);
	//print_r($_FILES);
	if ((substr ( trim ( $GRPID ), 1, 1 ) < '0' || substr ( trim ( $GRPID ), 1, 1 ) > '9') && trim ( $GRPID ) != 'ADD') :
		$GRPID = substr ( $GRPID, 12 );
	endif;
	if ($l_button == 'Process Changes' && $PROTECT == 'Y') :
		$l_button = ' ';	
	endif;
	
	// Store the selections
	if ($l_button == 'Process Changes' || $l_button == 'Selection Tool' || $l_button == '30' || $l_button == '31' || $l_button == '32' || $l_button == '33' || $l_button == '34' || $l_button == '35') :
		$ACTION = "U";
		$KEY = "SEL1";
		$ORGIN = "WEB";
		$LIST = trim ( $SEL1 );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "SEL2";
		$ORGIN = "WEB";
		$LIST = trim ( $SEL2 );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "SEL3";
		$ORGIN = "WEB";
		$LIST = trim ( $SEL3 );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "SEL4";
		$ORGIN = "WEB";
		$LIST = trim ( $SEL4 );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "WHSEU";
		$ORGIN = "WEB";
		$LIST = trim ( $WHSU );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "WHSEA";
		$ORGIN = "WEB";
		$LIST = trim ( $WHSA );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "ENTITYU";
		$ORGIN = "WEB";
		$LIST = trim ( $ENTU );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "ENTITYA";
		$ORGIN = "WEB";
		$LIST = trim ( $ENTA );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "USERU";
		$ORGIN = "WEB";
		$LIST = trim ( $USRU );
		Store_Lists ();
		$ACTION = "U";
		$KEY = "USERA";
		$ORGIN = "WEB";
		$LIST = trim ( $USRA );
		Store_Lists ();
		if ($l_button == 'Selection Tool') : // store parms for 1st web page for later retrieval
			$ACTION = "U";
			$KEY = "PARMS";
			$ORGIN = "WEB";
			$LIST = trim ( $PAGE ) . '|' . trim ( $FITEM ) . '|' . trim ( $LITEM ) . '|' . trim ( $FILTER ) . '|' . trim ( $SEL ) . '|' . trim ( $SEL5 ) . '|';
			Store_Lists ();
		
		endif;
	 elseif ($l_button == 'Reload' || $l_button == 'ReturnW') :
		// add newly selected items to the list of selected items
		$ACTION = "R";
		$KEY = "NEWITEM";
		$ORGIN = "WEB";
		Store_Lists ();
		if (trim ( $LIST ) != '') :
			$itemList = array ();
			$itemList = explode ( ',', $NEWITEM );
			foreach ( $itemList as $a ) {
				if (strpos ( $LIST, $a ) === false) {
					$LIST = trim ( $LIST ) . ',' . trim ( $a );
				}
			}
		 else :
			$LIST = trim ( $NEWITEM );
		endif;
		$ACTION = "U";
		$KEY = "NEWITEM";
		$ORGIN = "WEB";
		Store_Lists ();
	endif;
	
	if ($l_button == 'Select' || $l_button == 'Copy' || $l_button == 'Delete') :
		$PAGE = '';
		$SEL = '';
		$FILTER = '';
		$LEVEL = 'Z';
	
	endif;
	
	// Process main web page, then display the 'Selection Tool' web page
	if ($l_button == 'Selection Tool') :
		Load1 ();
		$webpage = 'SelectionTool';
		$MACRO = 'itemgrouping.php?HTML=SelectionTool&l_button=Reload&GRPID=' . trim ( $GRPID ). '&ORGID=' . trim ( $ORGID ). '&CPYID=' . trim ( $CPYID ) . '&GRPNAM=' . urlencode ( trim ( $GRPNAM ) ) . '&PAGE=&LOADSEL1=&LOADSEL2=&LISTKEY=' . trim ( $LISTKEY );
	 // Process 'Selction Tool' web page
	elseif ($l_button == 'Reload' || $l_button == 'Clear') :
		$webpage = 'SelectionTool';
		$MACRO = 'itemgrouping.php?HTML=SelectionTool&l_button=' . trim ( $l_button ). '&ORGID=' . trim ( $ORGID ). '&CPYID=' . trim ( $CPYID ) . '&GRPID=' . trim ( $GRPID ) . '&GRPNAM=' . urlencode ( trim ( $GRPNAM ) ) . '&FILTER=' . urlencode ( trim ( $FILTER ) ) . '&SEL01=' . trim ( $SEL01 ) . '&LOADSEL1=' . trim ( $LOADSEL1 ) . '&LOADSEL2=' . urlencode ( trim ( $LOADSEL2 ) ) . '&PAGE=' . trim ( $PAGE ) . '&FITEM=' . urlencode ( trim ( $FITEM ) ) . '&LITEM=' . urlencode ( trim ( $LITEM ) ) . '&LISTKEY=' . trim ( $LISTKEY );
	 // Return to main web page after processing changes on 'Selection Tool' web page
	elseif ($l_button == 'ReturnW' || $l_button == 'ReturnWO') :
		Load2 (); // process selection tool web page
		

		$ACTION = "R"; // retrieve and load 1st screen parms
		$KEY = "PARMS";
		$ORGIN = "WEB";
		Store_Lists ();
		if (trim ( $LIST != '' )) :
			$ParmList = array ();
			$ParmList = explode ( '|', $LIST );
			$PAGE = trim ( $ParmList [0] );
			$FITEM = trim ( $ParmList [1] );
			$LITEM = trim ( $ParmList [2] );
			$FILTER = trim ( $ParmList [3] );
			$SEL = trim ( $ParmList [4] );
			$SEL5 = trim ( $ParmList [5] );
		
		endif;
		$webpage = 'Group';
		$MACRO = 'itemgrouping.php?HTML=Group&l_button=' . urlencode ( trim ( $l_button ) ). '&ORGID=' . trim ( $ORGID ). '&CPYID=' . trim ( $CPYID ) . '&GRPID=' . trim ( $GRPID ) . '&GRPNAM=' . urlencode ( trim ( $GRPNAM ) ) . '&LEVEL=' . urlencode ( trim ( $LEVEL ) ). '&SEL=' . trim ( $SEL ) . '&FILTER=' . urlencode ( trim ( $FILTER ) ) . '&SEL5=' . trim ( $SEL5 ) . '&FITEM=' . urlencode ( trim ( $FITEM ) ) . '&LITEM=' . urlencode ( trim ( $LITEM ) ) . '&PAGE=' . trim ( $PAGE ) . '&LISTKEY=' . trim ( $LISTKEY );
	 // Initial web page
	else :
		$webpage = 'Group';
		$MACRO = 'itemgrouping.php?HTML=Group&l_button=' . urlencode ( trim ( $l_button ) ). '&ORGID=' . trim ( $ORGID ). '&CPYID=' . trim ( $CPYID ) . '&GRPID=' . trim ( $GRPID ) . '&GRPNAM=' . urlencode ( trim ( $GRPNAM ) ) . '&LEVEL=' . urlencode ( trim ( $LEVEL ) ) . '&SEL=' . trim ( $SEL ) . '&FILTER=' . urlencode ( trim ( $FILTER ) ) . '&SEL5=' . trim ( $SEL5 ) . '&FITEM=' . urlencode ( trim ( $FITEM ) ) . '&LITEM=' . urlencode ( trim ( $LITEM ) ) . '&PAGE=' . trim ( $PAGE ) . '&LISTKEY=' . trim ( $LISTKEY );
		if( $l_button == '30' || $l_button == '31' || $l_button == '32' || $l_button == '33' || $l_button == '34' || $l_button == '35')
		 $MACRO .= '#SHARE';
	endif;
	
	//If the URL length is too long then reload page with error 
	if (strlen ( $MACRO ) > $MAXURL) //Set the variable MACRO equal to the macro that is supposed to be executed 
		$MACRO = 'itemgrouping.php?HTML=' . trim ( $webpage ) . 'Group&ERROR=' . urlencode ( "Too many selections have been made. Please make new selection." ) . '&SC=' . trim ( $SC );
	
		//display the appropriate web page
	//echo 'entity:'.$ENTITYU.'<br>';
	//echo $MACRO;
	include 'submit.inc';
	
	echo '
</body>
</html>';
}

?>