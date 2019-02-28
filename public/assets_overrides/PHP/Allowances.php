<?php
/**********************************************************************
* Description:	Display allowances
*							
* Author:				Bob Ek
* Date:					11/13/2008 converted to PHP on 5/19/2011
***********************************************************************
*
* I M P O R T A N T   N O T E
*							
* Any changes made to this Display section may also need to be made
* to program WBB153E!  This program will process email requests.
*
*
************************************************************************
* Modification Log:
* Date		Init	Description
* --------	----	-----------------------------------------------------
*  
*************************************************************************/

include 'PHPTop.inc'; // Must exist at top of all PHP documents!
 
/* Define PHP Specific Variables */
$table1 = array(); 

/********************************************************************************** 
* Execute the proper HTML section
**********************************************************************************/
if (strtolower($HTML) == 'custselect' || trim($HTML) == ''):
	CustSelect();
elseif (strtolower($HTML) == "itemdisplay"):
	ItemDisplay();
elseif (strtolower($HTML) == "submit1"):
	Submit1();	
endif;

/********************************************************************************* 
* Selection web page   
**********************************************************************************/
function CustSelect () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'ALLOWANCES'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'CUSTSELECT'; // Set equal to "*SKIP" if logging is not desired 
?>

<?//Do not allow Excel Download capability?>
<? header("Content-Type: text/html"); ?>

<html>
<head>
<title>The H.T. Hackney Co. - Allowances Selection</title>

<?php 
// Include standard Header code 
include 'standardheadv03.inc';
?>

 <?// Include pop-up calendar support code?>     
<script language="JavaScript" src="/scripts/calendar2.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="apple-touch-icon" sizes="152x152" href="http://web1.hthackney.com/images/apple-touch-icon-152x152.png" />
</head>
<body onload="check_frames();">
<?php 
//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
if ($AUTH != 'Y'):
	$MACRO = 'NotAuthorized.mac/Display';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=',str_replace("^holymacro", $MACRO, $FULLURLMAC),'">';
//Else, if all users are lock-out of this web page then display the Not-Available web page and DO NOT proceed further 
elseif (trim($LOCKOUT) != ''):
	$MACRO = 'NotAvailable.mac/Display?LOCKOUT='.urlencode($LOCKOUT).'&MNUTXT='.urlencode($MNUTXT);
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=',str_replace("^holymacro", $MACRO, $FULLURLMAC),'">';
//Else if the user's password has expired then force user to change it 
elseif ($EXPIRED == 'Y'):
	$MACRO = 'ChangePassword.mac/Password';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=',str_replace("^holymacro", $MACRO, $FULLURLMAC),'">';
else:
	// if LOCNSELECTION returned, set DCUST/DLOCN and clear other pulldowns
	directcustload();  
	
	// Load the three pull down tables with valid customers 
	$TYPEWHS = "1"; 
	$LOADTYPE = "P";	
	$LOADTBLS ="Y";
	$LOADSQL= "N";
	if ($AUTHCD == "S" || $AUTHCD == "H")
		$TYPELOC = "2";
	else
		$TYPELOC = "1";
 	Customer();
	if(trim($LOCN) == "" && trim($LOCTOT) == "1")
		$LOCN = $LOCFST;
	if(trim($WHSE) == "" && trim($WHSTOT) == "2")
		$WHSE = $WHSFST;
	
	// Retrieve previous month date range
	$REQ = "9";
	$FORMAT = "C";
	rtvdates(); 
	
	// Load the To Date is it is not passed in 
	if (trim($TODATE) == "") $TODATE = $ENDWB;
		
?>
	<?// Build the custom page header in the following section?>
	<h2 align="center" style="margin-top: 0; margin-bottom: 0">Allowances
Inquiry - Selection</h2>
		
	<?include "CustPulls.inc";?>
	
	<?// Display the selection form ?>
	<form method="POST" action="allowances.php?HTML=Submit1" name="form"
	onSubmit="return Edit();">	
<?php 
		$vars[] = 'SOURCE';   // Load all FORM elements to this array <-------------
		$vars[] = 'STYPE'; 
		$vars[] = 'TODATE'; 
		$vars[] = 'GRPBY'; 
		
		$vars[] = 'WHSE'; // included because pulldowns(); is included
		$vars[] = 'CUST';
		$vars[] = 'LOCN';
		$vars[] = 'SALES';
		$vars[] = 'SALESBREAK';
		$vars[] = 'VEND';
		$vars[] = 'DCUST';
		$vars[] = 'DLOCN';
		include 'hiddenfields.inc';
?>
		
		<INPUT TYPE=HIDDEN NAME=LOWDATE VALUE=<?echo $ENDWB?>> <INPUT
	TYPE=HIDDEN NAME=l_return VALUE="CustSelect">	
		
		<?//If enter key is pressed, then we do not want to issue the 1st submit button.  Instead we want to override?>
		<INPUT TYPE="image" SRC="/images/pixel.jpg" HEIGHT="1" WIDTH="1"
	BORDER="0" onclick="document.form.l_button.value='Run Inquiry'">

		<?// Load all selections into a table?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="100%" align="center">
					<?// Load and display the customer pull downs?>
					<?pulldowns();?> 
				</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="80%"
	align="center">
	<tr>
		<td align="center" valign="top">
		<table border="0" cellpadding="8" style="border-collapse: collapse">
			<tr>
				<td align="center" valign="center"
					style="border-style: none; border-width: medium;"><font
					color="<?echo $DARK?>"><br>
				<b>Select Items by</b></font><br>
				<br>
				<select size="8" name="SOURCE">
					<option VALUE="07"
						<?if ($SOURCE == "07" || trim($SOURCE) == "")echo ' selected ';?>>
					All Items</option>
					
					<option VALUE="00" <?if ($SOURCE == "00") echo ' selected ';?>>
					Individual Items</option>
					
					<option VALUE="01" <?if ($SOURCE == "01") echo ' selected ';?>>
					Standard Invoice Category</option>

					<option VALUE="03" <?if ($SOURCE == "03") echo ' selected ';?>>
					Major Product Category</option>

					<option VALUE="02" <?if ($SOURCE == "02") echo ' selected ';?>>
					Product Category</option>

					<option VALUE="05" <?if ($SOURCE == "05") echo ' selected ';?>>
					Manufacturer</option>

					<option VALUE="S7" <?if ($SOURCE == "S7") echo ' selected ';?>>
					Standard Order Book Header</option>

					<option VALUE="IG" <?if ($SOURCE == "IG") echo ' selected ';?>>
					Item Grouping</option>

					
				</select></td>
			</tr>
		</table>
		</td>
		<td align="center" valign="top"><font color="<? echo $DARK?>"><br>
		<b>Select Date </b></font>
		<table border="0" style="border-collapse: collapse">
			<tr>
				<td align="center"><font color="<? echo $DARK?>"><b>&nbsp;Thru</b></font>
				</td>
			</tr>
			<tr>
				<td align="right">&nbsp; <input type="text" name="TODATE" size="10"
					value="<?echo $TODATE?>" class="fill">
								<?//pop-up calendar support ?>	
								<a href="javascript:cal1.popup();"> <img src="/images/cal.gif"
					width="20" height="20" border="0" alt="Click Here to Retrieve date">
				</a></td>
			</tr>

		</table>
		</td>
		<td align="center" valign="top"><font color="<? echo $DARK?>"><br>
		<b>Include</b></font>
		<table border="0" style="border-collapse: collapse">
			<tr>
				<td align="left"><input type="checkbox" name="STYPE[]" Value="01"
					<?if ($STYPE == "01") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Authorized
				Items</b></td>
			</tr>
			<tr>
				<td align="left"><input type="checkbox" name="STYPE[]" Value="02"
					<?if ($STYPE == "02") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>In
				Book Items</b></td>
			</tr>
			<tr>
				<td align="left"><input type="checkbox" name="STYPE[]" Value="04"
					<?if ($STYPE == "04") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Purchased
				Items</b></td>
			</tr>
			<tr>
				<td align="left"><input type="checkbox" name="STYPE[]" Value="05"
					checked></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>New
				Changes Only</b></td>
			</tr>
		</table>
		</td>
		<td align="center" valign="top"><font color="<? echo $DARK?>"><br>
		<b>Group Items By</b></font>
		<table border="0" style="border-collapse: collapse">
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="01"
					<?if ($GRPBY == "01" || trim($GRPBY) == "") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>None</b>
				</td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="02"
					<?if ($GRPBY == "02") echo ' checked ';?>></td>
				<td align="left" valign="cmiddle" style="font-size: x-small"><b>Standard
				Invoice Category</b></td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="03"
					<?if ($GRPBY == "03") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Major
				Product Category</b></td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="04"
					<?if ($GRPBY == "04") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Product
				Category</b></td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="05"
					<?if ($GRPBY == "05") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Manufacturer</b>
				</td>
			</tr>
			<tr>
				<td align="left"><input type="radio" name="GRPBY" Value="S7"
					<?if ($GRPBY == "S7") echo ' checked ';?>></td>
				<td align="left" valign="middle" style="font-size: x-small"><b>Standard
				Order Book Header</b></td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table border="0">
	<tr>
		<td>&nbsp;</td>
		<td align="center" width="100%"><input type="submit"
			value="Run Inquiry" name="SUBMIT_BUTTON2"
			onclick="document.form.l_button.value='Run Inquiry'"> <input
			type="reset" value="Reset" size="20">&nbsp; <input type="submit"
			value="Email Request" name="SUBMIT_BUTTON2"
			onclick="document.form.l_button.value='Email Request'"></td>
	</tr>
</table>
<center><font color="red" size="-2">Cigarettes are not included</font></center>
</form> 
	
	<?// Include the standard page footer?>
	<?include 'footer.inc';?>

	<?// Load web page specific menu bar entries, such as DOWNLOAD ?>
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
 	If (trim($ERRORD) != "")
 		//echo $ERRORD;
		error($ERRORD);
	elseif (trim($ERROR) != "")
		error($ERROR);
	elseif (trim($ERROR1) != "")
		error($ERROR1);
?>

	<?//pop-up calendar support?>
	<script language="JavaScript"><!--
		<?/*specify form element as the only parameter (document.forms['formname'].elements['inputname']); 
		    You can have as many calendar objects as you need for your application */?>
		var cal1 = new calendar2(document.forms['form'].elements['TODATE']);
		cal1.year_scroll = true;
		cal1.time_comp = false;	
	//--></script>

<script language="JavaScript"><!--
		<?/*specify form element as the only parameter (document.forms['formname'].elements['inputname']); 
		     You can have as many calendar objects as you need for your application */?>
		var cal2 = new calendar2(document.forms['form'].elements['LOWDATE']);
	//--></script>
<?//Validate form?>	
<SCRIPT LANGUAGE="JavaScript"><!--

	function Edit() {
	
	if(document.form.l_button.value!='Customer Retrieval') {
	
<?php
	//Validate the Customer related fields
	if($NUMPULLS > "0" || $AUTHCD == "S" || $AUTHCD == "H")
		include "validationcustomer.inc";  	
	//Validate the dates and date range
		//Must be a valid date in mm/dd/(yy/yyyy) format - alert window is displayed by called function
?>
		var dt_date1 = cal1.prs_date(document.form.TODATE.value);
		if (!dt_date1)
			return false;
		else 
			document.form.TODATE.value = cal1.gen_date(dt_date1); 
		var dt_date2 = cal2.prs_date(document.form.LOWDATE.value);
		if (cal1.gen_iso(dt_date1) < cal2.gen_iso(dt_date2)) {
			alert("The 'To' date cannot be less than " + cal2.gen_date(dt_date2));
			return false;}
				
		if (document.form.l_button.value == "Email Request" && document.form.SOURCE.value != "07") {
			alert("Email Request only valid with All Items selection.");
			return false;}
					
		<?//can only select one warehouse if selecting Standard order book header?>
		if((document.form.GRPBY.value == "S7" || document.form.SOURCE.value == "S7") && document.form.WHSE) {
			cnt=0;
			for(i=0; i<document.form.WHSE.length; i++){
				   if(document.form.WHSE[i] && document.form.WHSE[i].selected){
				   	cnt++;
				   	if(cnt>1) i=document.form.WHSE.length
				   }
			}
			if(cnt>1 || document.form.WHSE[0].selected) {
	   			alert("Exactly one warehouse must be selected when grouping by Standard Order Book Header.");
				return false;
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

/********************************************************************************** 
* Display allowance detail   
**********************************************************************************/
function ItemDisplay () {

// Include ALL global variables 
eval(globals());	

//Load variables%}
$FUNCTIONCODE = "ALLOWANCES"; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = "ItemDisplay"; // Set equal to "*SKIP" if logging is not desired 
$ERROR = ""; 

// Allow Excel Download capability
if ($OFORMAT != "E"): 
	header("Content-Type: text/html");
	//Content-type: text/html$(CRLF)$(CRLF)    
else:
	header("Content-Type: application/msexcel-comma");
	header("Content-encoding: ebcdic");
	header("Content-Disposition: attachment; filename=Allowances.xls");
endif;

echo '
<html><head><title>The H.T. Hackney Co. - Allowances Inquiry</title>
';

// Include standard Header code 
 include "StandardHeadV03.inc";

// Setup Parameters that are specific for the web page being executed 

 echo '
</head>

<body onload="check_frames();"> 

';
 //print_r(phpinfo());
 //phpinfo();
//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
if ($AUTH != 'Y'):
	$MACRO = 'NotAuthorized.mac/Display';
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=',str_replace("^holymacro", $MACRO, $FULLURLMAC),'">';
//Else, if all users are lock-out of this web page then display the Not-Available web page and DO NOT proceed further 
elseif (trim($LOCKOUT) != ''):
	$MACRO = 'NotAvailable.mac/Display?LOCKOUT='.urlencode($LOCKOUT).'&MNUTXT='.urlencode($MNUTXT);
	echo '<META HTTP-EQUIV=REFRESH CONTENT="0;URL=',str_replace("^holymacro", $MACRO, $FULLURLMAC),'">';
else:		
	// Validate the customer selections, load the 'Prepared For' and the SQL Statement 
	$LOADTBLS = "Y";	
	$LOADSQL = "Y";
	if(trim($DCUST) != "")
		$PREP4FMT = "3";
	$LOADTYPE = "P";	
	Customer();
	
	if(trim($LOCN) == "" && trim($LOCTOT) == "1")
		$LOCN = $LOCFST;
	
	if (trim($QRYTYPE) == "D" || trim($QRYTYPE) == "M")
		$DESC = strtoupper($DESC);
	// Load the table 
	$l_load_type = "T";
	$l_reqst = "";
 	LoadTable1($l_load_type,$l_reqst);

	// Build the custom page header in the following section 
	
 	echo '
	<div align="CENTER">
		<h2 style="margin-top: 0; margin-bottom: 0">
			Allowances Inquiry
		</h2>
	';

		echo 
		'<h3>Date Range: '.$CURDATE.' - '.$TODATE.'</h3>';
		
		// Display the selections 
		if(trim($STYPE) != ""):
			$l_comma = "";
			echo '<h3>';
			if(strpos($STYPE,"01") !== false):
				echo 'Authorized';
				$l_comma = ",";
			endif;
			if(strpos($STYPE,"02") !== false):
				echo $l_comma.' In Book';
				$l_comma = ",";
			endif;
			if(strpos($STYPE,"04") !== false):
				echo $l_comma.' Purchased';
				$l_comma = ",";
			endif;
			if(strpos($STYPE,"05") !== false):
				echo $l_comma.' New Changes Only';
				$l_comma = ",";
			endif;
			echo '</h3>';
		endif;
		
		// Display the grouoping 
		if(trim($GRPBY) == "02")
			echo '<h3>Grouped By: Standard Invoice Category</h3>';
		elseif(trim($GRPBY) == "03")
			echo '<h3>Grouped By: Major Product Category</h3>';
		elseif(trim($GRPBY) == "04")
			echo '<h3>Grouped By: Product Category</h3>';
		elseif(trim($GRPBY) == "05")
			echo '<h3>Grouped By: Manufacturer</h3>';
		elseif(trim($GRPBY) == "S7")
			echo '<h3>Grouped By: Standard Order Book Header</h3>';
			
		if(trim($SOURCE) != "00" && trim($SOURCE) != "07"):
			DispSelections(" "," ","Y","P");
		endif;
		echo '<center><font color="red" size="-2">Cigarettes are not included</font></center>	
	</div>';
	if ($OFORMAT != "E")
		echo '<table width="100%"><tr><td>'; 

	// Display the list of customers that this web page was prepared for 

	echo $PREP4;

	if ($OFORMAT != "E"):
		//if authorized, display the email request button
		$FUNCTIONCODE = "EMAIL";
		$PAGEID = "*SKIP"; 
		Authority();
		if($AUTH == "Y" && $LOCKOUT == ""):
?>
<td align="right" valign="bottom">
<form method="POST" name="form" action="allowances.php?HTML=Submit1">		
					<?include 'hiddenfields.inc';?>	
					<INPUT type="submit" value="Email Request" name="SUBMIT_BUTTON"
	onClick="document.form.l_button.value='Email Request';"></form>
</td>
<? endif;?>

</tr>
</table>
<?php
	endif;
	if (trim($GLIST) == "")
		$GLIST = "*ALL";
	// Display the allowance table 
	DispTable1();
	
	// Include the standard page footer 
	include "footer.inc";
				
	//Only process menu bar when sending the web page to the screen 
	if ($OFORMAT != "E"):
		// Load web page specific menu bar entries, such as DOWNLOAD 
			echo '
			<script language="javascript">
			if(top.frames.length != "0"){
				parent.banner.AddTopMenu.length=0;'; //NEVER DELETE THIS LINE OF CODE 
				echo 'parent.banner.AddSubMenu.length=0;'; //NEVER DELETE THIS LINE OF CODE%}
				echo 'parent.banner.AddTopMenu[0] = new Array("Download","&nbsp;Download","'.$COMPLETE_URL.'&OFORMAT=E","_self","/images/downloadicon.gif^16^16","","-1","-1","95","","","");';
				//Set the variable MACRO equal to the macro that is supposed to be executed 
				$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN);
				echo 'parent.banner.AddTopMenu[1] = new Array("New Selection","&nbsp;New Selection","'.str_replace("^holymacro",$MACRO,$FULLURLPHP).'","_self","","","-1","-1","100","","","");
			}
		</script>';
	
		// Load the menu bar 
		include "MenuBar.inc";
		
	endif;
	
endif;

echo '</body></html>';
}

/********************************************************************************** 
* Submit  
***********************************************************************************/
function Submit1 () {

// Include ALL global variables 
eval(globals());	

//Load variables
$ORIG = "allowances.php";  // Do Not set to t.mac for testing 
$SUBMIT = "Allowance Inquiry";
$ERROR = "";

// Setup Parameters that are specific for the web page being executed 

echo '<html><head><title>The H.T. Hackney Co. - Allowances Submit</title>';

//Include the style sheet
include "style.inc";
echo '
</head>
<body>';

echo $PLEASEWAIT;

// More edits are needed if Hackney associate Entered a customer and/or location directly 
DirectCustEdit();
if (trim($ERRORD) != ""):
	$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&ERRORD='.urlencode(trim($ERRORD));	
else:	
	if($l_button != "Customer Retrieval") TestLoc();
	if (trim($ERROR) != ""):
		$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&ERROR='.urlencode(trim($ERROR));	
	else:	
		if ($SOURCE == "S7" || $GRPBY == "S7")
			CheckOrderBook();
		else
			$ERROR1 = "";
		
		// Add parms not used by Lookup or ItemInquiry 
		$EXECPARM = urlencode(trim('&AUTHWHSE='.trim($AUTHWHSE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&HTML=ItemDisplay'));
		$EXECURL =urlencode("allowances.php");
		
		if (trim($ERROR1) != ""):
			$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&ERROR1='.trim($ERROR1).'&EXECURL='.trim($EXECURL).'&EXECPARM='.trim($EXECPARM);	
		elseif (trim($SOURCE) == "07"):
			$MACRO = 'allowances.php?HTML=ItemDisplay&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&EXECPARM='.trim($EXECPARM);	
		elseif (trim($SOURCE) != "00"):
			$MACRO = 'lookupV03.mac/Select?LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&EXECURL='.trim($EXECURL).'&EXECPARM='.trim($EXECPARM);
		else:
			$MACRO = 'ItemInquiryV05.mac/Search?LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&EXECURL='.trim($EXECURL).'&EXECPARM='.trim($EXECPARM);
		endif;
	
		// email request button 
		if($l_button == "Email Request"):
			$MACRO = 'allowances.php?HTML=ItemDisplay&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&GLIST='.trim($GLIST).'&DESC='.trim($DESC).'&QRYTYPE='.trim($QRYTYPE).'&ORIG='.trim($ORIG);
			$l_macro_execute = $MACRO;					
			if(trim($l_return) != "")
				$MACRO = str_replace("ItemDisplay", $l_return, $MACRO);
			$l_macro_return = $MACRO;
			$MACRO = 'emailrequestv04.mac/request?RETURNURL='.urlencode(trim($l_macro_return)).'&REQUESTURL='.urlencode(trim($l_macro_execute)).'&ENDDAT='.trim($TODATE);
		// retrieve a customer 
		elseif($l_button == "Customer Retrieval"):
			$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&GLIST='.trim($GLIST).'&DESC='.trim($DESC).'&QRYTYPE='.trim($QRYTYPE).'&ORIG='.trim($ORIG); 
			if(trim($l_return) != "")
				$MACRO = str_replace("ItemDisplay",$l_return,$MACRO);
			$l_macro_execute = $MACRO;
			$MACRO = 'CustRetrieval.mac/CustSelection?ORIG='.urlencode(trim($ORIG)).'&RETURNURL='.urlencode(trim($l_macro_execute));
		endif;

		// Edit warehouse and location 
		if($l_button != "Customer Retrieval"):
			$l_checkitem = "N";
			TestItem ($l_checkitem);
			if(trim($ERROR) != "")
				$MACRO = 'allowances.php?HTML=CustSelect&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&AUTHWHSE='.trim($AUTHWHSE).'&SOURCE='.trim($SOURCE).'&STYPE='.trim($STYPE).'&TODATE='.trim($TODATE).'&GRPBY='.trim($GRPBY).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&ERROR1='.urlencode(trim(ERROR));
		endif;
	endif;
endif;
//If the URL length is too long then reload page with error 
if(strlen($MACRO) > $MAXURL) //Set the variable MACRO equal to the macro that is supposed to be executed 
	$MACRO = 'allowances.php?HTML=CustSelect&ERROR='.urlencode("Too many selections have been made. Please make new selection."); 

//display the appropriate web page
include 'submit.inc';

echo '
</body>
</html>';
}

/********************************************************************************* 
* Load Item Inquiry Reporting tables.
**********************************************************************************/	
function LoadTable1 (
$l_load_type,
$l_reqst
){
	
// Include ALL global variables 
eval(globals());
	
// open connection
$connection = db2_pconnect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB153 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_INOUT);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "WHSE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "AUTHWHSE", DB2_PARAM_IN);
db2_bind_param($stmt,  5, "LOCN", DB2_PARAM_IN);
db2_bind_param($stmt,  6, "GLIST", DB2_PARAM_IN);
db2_bind_param($stmt,  7, "SOURCE", DB2_PARAM_IN);
db2_bind_param($stmt,  8, "STYPE", DB2_PARAM_IN);
db2_bind_param($stmt,  9, "GRPBY", DB2_PARAM_IN);
db2_bind_param($stmt, 10, "DESC", DB2_PARAM_IN);
db2_bind_param($stmt, 11, "QRYTYPE", DB2_PARAM_IN);
db2_bind_param($stmt, 12, "TODATE", DB2_PARAM_IN);
db2_bind_param($stmt, 13, "l_load_type", DB2_PARAM_IN);
db2_bind_param($stmt, 14, "l_reqst", DB2_PARAM_IN);
db2_bind_param($stmt, 15, "OFORMAT", DB2_PARAM_IN);
db2_bind_param($stmt, 16, "LISTKEY", DB2_PARAM_IN);
db2_bind_param($stmt, 17, "ERROR", DB2_PARAM_OUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

// load the array for later processingm
$table1 = array();
$cnt1 = 0; 
while ($row = db2_fetch_array($stmt)){
	$cnt1 += 1;
	$table1[$cnt1]['itemno'] = $row[0]; 
	$table1[$cnt1]['descpt'] = $row[1]; 
	$table1[$cnt1]['upc'] = $row[2]; 
	$table1[$cnt1]['pack'] = $row[3]; 
	$table1[$cnt1]['size'] = $row[4]; 
	$table1[$cnt1]['whsno'] = $row[5]; 
	$table1[$cnt1]['begdate'] = $row[6]; 
	$table1[$cnt1]['enddate'] = $row[7]; 
	$table1[$cnt1]['allow'] = $row[8]; 
	$table1[$cnt1]['auth'] = $row[9]; 
	$table1[$cnt1]['inbook'] = $row[10]; 
	$table1[$cnt1]['whssts'] = $row[11]; 
	$table1[$cnt1]['value'] = $row[12]; 
	$table1[$cnt1]['desc'] = $row[13]; 
}

db2_free_result($stmt);
db2_free_stmt($stmt); 
}


/********************************************************************************* 
* Load Item Inquiry Reporting tables.
**********************************************************************************/
function DispTable1 () {
	
// Include ALL global variables 
eval(globals());	

echo '
<table width="100%" align="center">';
// Set the table headings %}
?>
<tr valign="center" align="middle" style="background-color:<?echo $DARK?>; color:<?echo $LIGHTLETTER?>" style="font-size:xx-small">
	<th><font size="1"> Item </font></th>
	<th><font size="1"> Description </font></th>
	<th><font size="1"> UPC </font></th>
	<th><font size="1"> Pack </font></th>
	<th><font size="1"> Size </font></th>
	<th><font size="1"> Whs </font></th>
	<th><font size="1"> Sts </font></th>
	<th><font size="1"> Begin Date </font></th>
	<th><font size="1"> End Date </font></th>
	<th><font size="1"> Allowance </font></th>
	<th><font size="1"> Auth </font></th>
	<th><font size="1"> In Book </font></th>
</tr>

<?php

if (count($table1) == 0):
	echo '
	<tr>
		<td colspan = "9")
		   align="left" class="dottedtop">
			<span title="No Records"><b>No records found based on selection</b></span>
		</td>
	</tr>';
else:

	// Process Item Loop %}
	$hld_value = "";
	foreach ($table1 as  $t1) {
		// Process Detail Loop 
		if(trim($t1['desc']) != "" &&
			trim($t1['desc']) != trim($hld_value)):
			echo '
			<tr style="background-color:'.$LIGHT.';font-size:x-small">
				<td colspan="12">
					<b>';
					if (trim($GRPBY) != "S7")
						echo $t1['value']. ' - ';
					echo $t1['desc'].'</b>
				</td>
			</tr>';
		endif;
		$hld_value =$t1['desc'];
		echo '
		<tr style="font-size:x-small">
			<td class="dottedtop">';
				if ($OFORMAT != "E"):
						$MACRO = 'ItemDisplay.mac/Display?ITEM='.$t1['itemno'].'&WHSE='.$t1['whsno'].'&LOCN='.trim($LOCN).'&ORIG=priceinquiry&RETURNURL='.urlencode(trim($PHPSCRIPT).'?'.trim($QUERY_STRING));
					echo '<a href='.str_replace("^holymacro",$MACRO,$FULLURLMAC).'>';
				endif;
				echo '
				<span title="Item">'.$t1['itemno'].'</span></a>
			</td>
			<td align="left" class="dottedtop">
				<span title="Description">'.$t1['descpt'].'</span>
			</td>
			<td  class="dottedtop" align="center">
				<span title="UPC">'.$t1['upc'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="Pack">'.$t1['pack'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="Size">'.$t1['size'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="Warehouse">'.$t1['whsno'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="Status">'.$t1['whssts'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="Begin Date">'.$t1['begdate'].'</span>
			</td>
			<td align="center" class="dottedtop">
				<span title="End Date">'.$t1['enddate'].'</span>
			</td>
			<td  class="dottedtop" align="right">
				<span title="Allowance">'.$t1['allow'].'</span>
			</td>
			<td  class="dottedtop" align="center">
				<span title="Authorized?">'.$t1['auth'].'</span>
			</td>
			<td  class="dottedtop" align="center">
				<span title="In Order Book?">'.$t1['inbook'].'</span>
			</td>
		</tr>';
	}

endif; 

echo '
</table>
<hr>';
}

?>
