<?php
/**********************************************************************
* Description:	Process Bank Deposit
*							
* Author:				Bob Ek
* Date:					06/10/2011
***********************************************************************
* Modification Log:
* Date		Init	Description
* --------	----	-----------------------------------------------------
*  
*************************************************************************/
include 'PHPTop.inc'; // Must exist at top of all PHP documents!
 
/* Define PHP Specific Variables */
$table1 = array(); 
$table2 = array(); 
$table3 = array();

$PAY_LIST = '';
$INV_LIST = '';
$l_partial = '';

if (trim($DEPOSITDATE) == '')
	$DEPOSITDATE = $CURDATE;

/********************************************************************************** 
* Execute the proper HTML section
**********************************************************************************/
if (strtolower($HTML) == 'deposit' || trim($HTML) == ''):
	Deposit();
elseif (strtolower($HTML) == "submit1"):
	Submit1();	
endif;

/********************************************************************************* 
* Process Bank Deposit
**********************************************************************************/
function Deposit () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'ARPAYMENT'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'DEPOSIT'; // Set equal to "*SKIP" if logging is not desired 
?>

<?//Do not allow Excel Download capability?>
<? header("Content-Type: text/html"); ?>

<html>
<head>
<title>The H.T. Hackney Co. - Process Bank Deposit</title>

<?php 
// Include standard Header code 
include 'standardheadv03.inc'; 
?>

 <?// Include pop-up calendar support code?>     
<script language="JavaScript" src="/scripts/calendar2.js"></script>

<style>
fieldset {
	border: 3px solid <? echo $DARK ?>;
	padding: 5px;
	margin: 5px 5px 5px 5px;
	background-color: transparent;
	text-align: center;
}

legend {
	font-weight: bold;
	margin: 0px;
	padding: 5px;
	color: <? echo $DARK ?>;
}
</style>

<SCRIPT LANGUAGE="JavaScript"><!--
 
	<?include 'js_strip_blanks.inc'?>
	<?include 'validation_isZero.inc'?>
	<?include 'js_isdollar.inc'?>
	<?include 'js_isalphanumeric.inc'?>
	
	function ClearPartial(partial){
		if(partial) {
			partial.value = stp(partial.value);
			if(partial.value != "") {
				partial.value = "";
			}
		}
	}
	
//--></script>

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
	// Load the customer selections 
	$TYPELOC = "2"; 
	$LOADTYPE = "P";	
	$LOADTBLS ="Y";
	$LOADSQL= "Y";
 	Customer();	
 	if (trim($LOCN) == '' && trim($DCUST) == '' && trim($locn[1]['Column1']) != ''):
 		$LOCN = $locn[1]['Column1'];
	 	Customer();	
	elseif(trim($DCUST) != ""): 
	 	//$hld_locn = $LOCN;
	 	$LOCN = trim($DCUST).trim($DLOCN);
	 	Customer();
	 	//$LOCN = $hld_locn;
	 endif;
 	
	 // Load the web page
	Process(); 
	
	// Calculate the unapplied deposit amount
	if(trim($MASTERKEY) != ''): 
		Calc_Unapplied();
	endif;
	//if (trim($DEPOSIT) == '' || $DEPOSIT == 0) $DEPOSIT = '0.00';
	if (trim($UNAPPLIED) == '' || $UNAPPLIED == 0) $UNAPPLIED = '0.00'; 
	
?>
	<?// Build the custom page header in the following section?>
	<h2 align="center" style="margin-top: 0; margin-bottom: 0">Process Bank
Deposit</h2>

	<?include "CustPulls.inc";?>
	
	<?// Display the selection form ?>
	<form method="POST" action="arpayment.php?HTML=Submit1" name="form"
	onSubmit="return Edit();">	
<?php 
		$vars[] = 'DEPOSIT';   // Load all form elements to this array <-------------
		$vars[] = 'DEPOSITDATE'; 
		$vars[] = 'BANK'; 
		$vars[] = 'UPDATE'; 
		$vars[] = 'EMAIL'; 
		$vars[] = 'REF';
		$vars[] = 'PAY';
		$vars[] = 'OVERPAY';
		$vars[] = 'REASON';
		$vars[] = 'QAPPLY';
		$vars[] = 'APPLY';
		include 'hiddenfields.inc';
?>				

		<?// Load all selections into a table?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="center" valign="top" width="30%"><a name="top"> </a>
		<fieldset style="border:<?echo $DARK?> 3px solid;padding:10px 10px;"><legend>Enter Bank Deposit</legend>
		<table>
			<tr>
				<td align="right"><b>Amount of Deposit:</b></td>
				<td><input type="text" name="DEPOSIT" size="10"
					value="<?echo $DEPOSIT?>" class="fill"></td>
			</tr>
			<tr>
				<td align="right"><b>Date of Deposit:</b></td>
				<td><input type="text" name="DEPOSITDATE" size="10"
					value="<?echo $DEPOSITDATE?>" class="fill">
									<?//pop-up calendar support ?>	
									<a href="javascript:cal1.popup();"> <img src="/images/cal.gif"
					width="20" height="20" border="0"
					alt="Click Here to Pick up FROM date"> </a></td>
			</tr>
		</table>
		</fieldset>
		<br>
		</td>
		<td align="center" valign="top" rowspan="2">
		<fieldset style="border:<?echo $DARK?> 3px solid;padding:10px 10px;"><legend>Customer Selection</legend>
						<?pulldowns();?>  <br>
		<input type="submit" value="Select Customer"
			onClick="document.form.l_button.value='Select Customer';"></fieldset>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top">
		<fieldset style="border:<?echo $DARK?> 3px solid;padding:10px 10px;"><legend>Submit Bank Deposit</legend> <br>
		<b>	Unapplied Deposit Amount:  
<?php
						if(strpos($UNAPPLIED,"-") !== false) echo '<font color="red">';
		 				elseif ($UNAPPLIED > 0) echo '<font color="green">';
						echo '$'.$UNAPPLIED;
						if ($UNAPPLIED != 0) echo '</font>';
?>
						</b><br>
		<br>
		<table border="0" cellspacing="1" width="75%" align="center"
			style="font-size: 10pt">
			<tr>
				<td align="center"><br>
				<h5 style="margin-top: -15; margin-bottom: 0">Email Address for
				Confirmation</h5>
				<font size="1pt"> <input type="checkbox" name="UPDATE" Value="Y"
					<?if ($UPDATE == 'Y') echo 'checked';?>> Check to attach this
				address to your web profile </font></td>
			</tr>
			<tr>
				<td align="center"><textarea name="EMAIL" rows=2 cols=50
					maxlength=100 wrap><?echo $EMAIL?></textarea></td>
			</tr>
		</table>
		<br>

		Bank Name: <input type="text" name="BANK" value="<? echo $BANK?>"
			size=50 maxlength=50> <br>



		<input type="submit" value="Submit Deposit"
			onClick="document.form.l_button.value='Submit Deposit';"></fieldset>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" valign="top"><a name="middle"> </a>
		<fieldset style="border:<?echo $DARK?> 3px solid;padding:10px 10px;"><legend>Apply Payment</legend>
<?php           	
						if ($OFORMAT != "E")
							echo '<table width="100%"><tr><td>'; 
						// Display the list of customers that this web page was prepared for 
						echo $PREP4;
						if ($OFORMAT != "E") 
							echo '</td>';
						// Allow the user to request an email of the full report 
						if ($OFORMAT != "E" && count($table1) != "0"):
							echo '<td align="right" valign="bottom">				
								 <INPUT type="submit" value="Apply Payment"  name="SUBMIT_BUTTON" onClick="document.form.l_button.value=\'Submit Payment for Entry\';">
							      </td>';
						endif;
						echo '</tr>';	
						if ($OFORMAT != "E") 
							echo '</table>';
						if (count($table1) != "0") echo '<hr>'; 
	
						// Retrieve information from lists 
						if(trim($LISTKEY) != ""):
							$ACTION = "R";
							$KEY = "INV";
							$ORGIN = "WEB";
							Store_Lists ();
							$INV_LIST = $LIST;
							
							$ACTION = "R";
							$KEY = "PAY";
							$ORGIN = "WEB";
							Store_Lists ();
							$PAY_LIST = $LIST;
						endif;
	
						// Display the tables for display or MSExcel 
						DispTables1and2();
					 	echo '<INPUT TYPE=HIDDEN NAME=ENTRIES VALUE='.count($table1).'>';
?>
					</fieldset>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" valign="top"><a name="bottom"> </a>
		<fieldset style="border:<?echo $DARK?> 3px solid;padding:10px 10px;"><legend>Deposit Details</legend>
						<?DispTable3();?>
					</fieldset>
		</td>
	</tr>
</table>
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
		var cal1 = new calendar2(document.forms['form'].elements['DEPOSITDATE']);
		cal1.year_scroll = true;
		cal1.time_comp = false;	
	//--></script>
	
<?//Validate form?>	
<SCRIPT LANGUAGE="JavaScript"><!--

<? include 'validation_email_address.inc';?>

function Edit() {
	if(document.form.l_button.value != 'Customer Retrieval') {

		<?//Validate the Deposit Amount?>
		document.form.DEPOSIT.value = stp(document.form.DEPOSIT.value);
		var Pass = IsDollar(document.form.DEPOSIT.value);
		if (isNaN(document.form.DEPOSIT.value)  || Pass == false) {
			alert("Deposit Amount must be valid positive number with no more than two (2) decimal positions.");
			document.form.DEPOSIT.focus();
			return false;
		}
		
<?////////////////////////////////////////////////////////////////////////////////?>
		if(document.form.l_button.value == "Select Customer") {	
<?php       //Validate the Customer related fields
			if($NUMPULLS > "0" || $AUTHCD == "S" || $AUTHCD == "H"):
				include "validationcustomer.inc";  
			endif; 
?>
		}

<?////////////////////////////////////////////////////////////////////////////////?>		
		if(document.form.l_button.value == 'Submit Deposit') {
			
			<?//Validate the Deposit Date?>
			var dt_date1 = cal1.prs_date(document.form.DEPOSITDATE.value);
			if (!dt_date1) {
				document.form.DEPOSITDATE.focus();
				return false;
			}
			else 
				document.form.DEPOSITDATE.value = cal1.gen_date(dt_date1); 
			<?//Validate the Email Address?>
			if (!ValidEmail(document.form.EMAIL.value)) {
				document.form.EMAIL.focus();
				alert("Invalid email address entered.");
				return false;
			}

			<?//Validate the Bank Name?>
			document.form.BANK.value = stp(document.form.BANK.value);
			if(document.form.BANK.value == "") {
				alert("The Bank Name must be supplied.");
				document.form.BANK.focus();
				return false;
			}
		}
<?////////////////////////////////////////////////////////////////////////////////?>		
		if(document.form.l_button.value =='Submit Payment for Entry' ||
				document.form.l_button.value =='Calculate') {
			
			document.form.PAY.value = stp(document.form.PAY.value);
			
			if(document.form.l_button.value=='Submit Payment for Entry') {
		
				<?//Validate the Reference?>
					<?//Must be supplied?>
					document.form.REF.value = stp(document.form.REF.value);
					if(document.form.REF.value == "") {
						alert("The Reference must be supplied.");
						document.form.REF.focus();
						return false;
					}
					var Pass = IsAlphaNumeric(document.form.REF.value);
					if (Pass == false) {
						alert("Reference can contain only letters, numbers or spaces.");
						document.form.REF.focus();
						return false;
					}
			}
			
			<?//Validate the Payment?>
			
			<?//Must be supplied?>
			if(document.form.PAY.value == "" && document.form.QAPPLY.checked == true) {
				alert("The Payment Amount must be supplied.");
				document.form.PAY.focus();
				return false;
			}
			<?//Must be a valid dollar amount - if supplied?>
			if(document.form.PAY.value != "") {
				var Pass = IsDollar(document.form.PAY.value);
				if (isNaN(document.form.PAY.value)  || Pass == false) {
					alert("Payment must be valid positive number with no more than two (2) decimal positions.");
					document.form.PAY.focus();
					return false;
				}
			}

			<?//Validate the Overpayment Amount?>
			
			<?//Must be a valid dollar amount - if supplied?>
			document.form.OVERPAY.value = stp(document.form.OVERPAY.value);
			if(document.form.OVERPAY.value != "") {
				var Pass = IsDollar(document.form.OVERPAY.value);
				if (isNaN(document.form.OVERPAY.value)  || Pass == false) {
					alert("Overpayment must be valid positive number with no more than two (2) decimal positions.");
					document.form.OVERPAY.focus();
					return false;
				}
			}

			<?//Validate the Overpayment Explanation?>
					
			<?//Must be supplied if amount is applied?>
			if(document.form.l_button.value=='Submit Payment for Entry') {
				document.form.REASON.value = stp(document.form.REASON.value);
				if(document.form.OVERPAY.value != "") {
					if(document.form.REASON.value == "") {
						alert("The Overpayment Explanation must be supplied if the Overpayment Amount is supplied.");
						document.form.REASON.focus();
						return false;
					}
				}
			}
	
			<?//Validate the Partial Payment?>
			applycnt = true;
			if(document.form.QAPPLY.checked == false) {
				applycnt = false;
				
<?php 
				$cnt = 1;
				while ($cnt < count($table1)){
				 	
				 	echo 'if(document.form.APPLY['.($cnt-1).'].checked == true)
				 		applycnt = true;';
				 	echo '
				 	if(document.form.A'.trim($cnt).') {
						document.form.A'.trim($cnt).'.value = stp(document.form.A'.trim($cnt).'.value);
						if(isZero(document.form.A'.trim($cnt).'))
							document.form.A'.trim($cnt).'.value = "";';
						//Must be a valid dollar amount - if supplied
						echo '
				 		if(document.form.A'.trim($cnt).'.value != ""){
							var Pass = IsDollar(document.form.A'.trim($cnt).'.value);
							if (isNaN(document.form.A'.trim($cnt).'.value)  || Pass == false) {
								alert("Partial Payment is not valid.");
								document.form.A'.trim($cnt).'.focus();
								return false;
							}
						}
					}';
				$cnt += 1;
				}
?>
			}
			<?//must select at least one table entry when submitting the payment?>
			if(document.form.l_button.value=='Submit Payment for Entry' && document.form.QAPPLY.checked == true) {
				alert("Must click the 'Calculate' button in order to process 'Quick Apply'.");
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
* Submit  
***********************************************************************************/
function Submit1 () {   

// Include ALL global variables 
eval(globals());	

//Load variables
$FUNCTIONCODE = 'ARPAYMENT';
$ERROR = ' ';
$ERROR1 = ' ';
$ERRORD = ' ';
$ORIG = "arpayment.php";  // Do Not set to t.mac for testing 

// Setup Parameters that are specific for the web page being executed 

echo '<html><head><title>The H.T. Hackney Co. - Process Bank Deposit Submit</title>';

//Include the style sheet
include "style.inc";
echo '
</head>
<body>';

if($QAPPLY == "Y") 								echo '<br><br><br><center><h1>Please wait for \'Quick Apply\' to be processed....</h1></center>';
elseif ($l_button == "Calculate") 				echo '<br><br><br><center><h1>Please wait while \'Difference\' is calculated....</h1></center>';
elseif($l_button == "Submit Payment for Entry") echo '<br><br><br><center><h1>Please wait while Payment is applied....</h1></center>';
elseif($l_button == "Remove Payment")			echo '<br><br><br><center><h1>Please wait while Payments are removed....</h1></center>';
elseif($l_button == "Submit Deposit")			echo '<br><br><br><center><h1>Please wait while Deposit is processed....</h1></center>';
else 											echo $PLEASEWAIT;

$MACRO = 'arpayment.php?CUST='.trim($CUST).'&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&DEPOSIT='.urlencode(trim($DEPOSIT)).'&DEPOSITDATE='.trim($DEPOSITDATE).'&EMAIL='.trim($EMAIL).'&UPDATE='.trim($UPDATE).'&BANK='.trim($BANK).'&UNAPPLIED='.trim($UNAPPLIED).'&BUTTON='.urlencode(trim($l_button));
if($l_button == "Calculate" || $l_button == "Submit Payment for Entry"):
	$cnt = 1;
	$comma = "";
	while ($cnt <= $ENTRIES){
		$qty = 'A'.$cnt;
		$itm = 'I'.$cnt; 
		$whs = 'W'.$cnt;
		$bal = 'B'.$cnt;
		$Q = $Q.trim($comma).$$qty;
		$I = $I.trim($comma).$$itm; 
		$W = $W.trim($comma).$$whs; 
		$B = $B.trim($comma).str_replace(',',' ',$$bal);  
		$comma = ",";
		$cnt += 1;
	}
	
	$ACTION = "U";
	$KEY = "INV";
	$ORGIN = "WEB";
	$LIST = trim($I);
	Store_Lists ();
	$ACTION = "U";
	$KEY = "ARWHSE";
	$ORGIN = "WEB";
	$LIST = trim($W);
	Store_Lists ();
	$ACTION = "U";
	$KEY = "BAL";
	$ORGIN = "WEB";
	$LIST = trim($B);
	Store_Lists ();
	$ACTION = "U";
	$KEY = "PAY";
	$ORGIN = "WEB";
	$LIST = trim($Q);
	Store_Lists ();
	ApplyPayment();
	if (trim($ERROR1) != ""): 
		$MACRO = $MACRO.'&ERROR1='.urlencode(trim($ERROR1)); 
	endif;
	
elseif($l_button == "Select Customer"):
	DirectCustEdit();
	if (trim($ERRORD) != ""):
		$MACRO = $MACRO.'&ERRORD='.urlencode(trim($ERRORD)); 
	endif;
	
elseif($l_button == "Submit Deposit"):
	Calc_Unapplied();
	if($UNAPPLIED != 0):
		$MACRO = $MACRO.'&MASTERKEY='.trim($MASTERKEY).'&ERROR1='.urlencode("Unapplied Amount must be equal to zero in order to submit deposit.");
	else:
		SubmitDeposit();
		if (trim($ERROR1) != ""): 
			$MACRO = $MACRO.'&ERROR1='.urlencode(trim($ERROR1)); 
		else:
			$MACRO = 'arpayment.php?ERROR1='.urlencode("Your Deposit has been submitted.");
		endif;
	endif;
	
elseif($l_button == "Remove Payment"):
	$MACRO = $MACRO.'&REMOVE='.trim($REMOVE);
elseif($l_button == "Customer Retrieval"):
	$l_macro_execute = $MACRO;
	$MACRO = 'CustRetrieval.mac/CustSelection?ORIG='.urlencode(trim($ORIG)).'&RETURNURL='.urlencode(trim($l_macro_execute));
endif;
if($l_button == "Calculate" || ($l_button == "Submit Payment for Entry" && trim($ERROR1) != ''))	
	$MACRO = $MACRO.'&PAY='.trim($PAY).'&REF='.urlencode(trim($REF)).'&DIFF='.trim($DIFF).'&APPLY='.trim($APPLY).'&OVERPAY='.trim($OVERPAY).'&REASON='.urlencode(trim($REASON)).'&LISTKEY='.trim($LISTKEY); 
if($l_button != "Submit Deposit") 
	$MACRO = $MACRO.'&MASTERKEY='.trim($MASTERKEY);
	
// position web page in the middle
if($l_button == "Calculate" || ($l_button == "Submit Payment for Entry" && trim($ERROR1) != '') || $l_button == "Select Customer") 
	$MACRO = $MACRO.'#middle';

//If the URL length is too long then reload page with error 
if(strlen($MACRO) > $MAXURL) //Set the variable MACRO equal to the macro that is supposed to be executed 
	$MACRO = $MACRO.'&ERROR='.urlencode("Too many selections have been made. Please make new selection."); 
//display the appropriate web page
include 'submit.inc';

echo '
</body>
</html>';
}

/********************************************************************************* 
* Process web page.
**********************************************************************************/	
function Process (){
	
// Include ALL global variables 
eval(globals());


// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB113 (?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "MASTERKEY", DB2_PARAM_IN);		//26
db2_bind_param($stmt,  2, "TOTAL", DB2_PARAM_OUT);			//17
db2_bind_param($stmt,  3, "PATH_INSTANCE", DB2_PARAM_IN);	//20
db2_bind_param($stmt,  4, "USER", DB2_PARAM_INOUT);			//10
db2_bind_param($stmt,  5, "SQLSTMT", DB2_PARAM_IN);			//32740
db2_bind_param($stmt,  6, "UPDATE", DB2_PARAM_INOUT);		//1
db2_bind_param($stmt,  7, "EMAIL", DB2_PARAM_INOUT);		//100
db2_bind_param($stmt,  8, "REMOVE", DB2_PARAM_INOUT);		//32740
db2_bind_param($stmt,  9, "ERROR", DB2_PARAM_OUT);			//1000

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

// load the array for later processing
$cnt1 = 0; 
$cnt2 = 0;
$cnt3 = 0;
while ($row = db2_fetch_array($stmt)){
	// table 1
	if($row[0] == '1'):
		$cnt1 += 1;
		$table1[$cnt1]['twhse'] = $row[1]; 
		$table1[$cnt1]['tcust'] = $row[2]; 
		$table1[$cnt1]['tloc'] = $row[3]; 
		$table1[$cnt1]['tinvno'] = $row[4]; 
		$table1[$cnt1]['titype'] = $row[5]; 
		$table1[$cnt1]['tidate'] = $row[6]; 
		$table1[$cnt1]['tiamt'] = $row[7]; 
		$table1[$cnt1]['tibal'] = $row[8]; 
		$table1[$cnt1]['arwhse'] = $row[9];  
		$table1[$cnt1]['lock'] = $row[10];  
	// table 2
	elseif($row[0] == '2'):
		$cnt2 += 1;
		$table2[$cnt2]['age1'] = $row[11]; 
		$table2[$cnt2]['age2'] = $row[12]; 
		$table2[$cnt2]['age3'] = $row[13]; 
		$table2[$cnt2]['age4'] = $row[14]; 
		$table2[$cnt2]['age5'] = $row[15];
	// table 3
	elseif($row[0] == '3'):
		$cnt3 += 1;
		$table3[$cnt3]['listkey'] = $row[16]; 
		$table3[$cnt3]['whsno'] = $row[17];
		$table3[$cnt3]['custno'] = $row[18]; 
		$table3[$cnt3]['cusloc'] = $row[19]; 
		$table3[$cnt3]['shpnam'] = $row[20]; 
		$table3[$cnt3]['overpay'] = $row[21]; 
		$table3[$cnt3]['reason'] = $row[22]; 
		$table3[$cnt3]['ref'] = $row[23]; 
		$table3[$cnt3]['invno'] = $row[24]; 
		$table3[$cnt3]['invtyp'] = $row[25];  
		$table3[$cnt3]['invdate'] = $row[26]; 
		$table3[$cnt3]['whsar'] = $row[27]; 
		$table3[$cnt3]['orig'] = $row[28]; 
		$table3[$cnt3]['bal'] = $row[29]; 
		$table3[$cnt3]['pay'] = $row[30]; 
		$table3[$cnt3]['totpay'] = $row[31];   
	endif;
}
db2_free_result($stmt);
db2_free_stmt($stmt); 
 //print_r($table1);
 //print_r($table2);
 //print_r($table3);
}

/********************************************************************************* 
* Process the 'Apply Payment' section
**********************************************************************************/	
function SubmitDeposit (){	
		
// Include ALL global variables 
eval(globals());

$FUNCTIONCODE = 'ARPAYMENT';
	
// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB114 (?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "UPDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  5, "EMAIL", DB2_PARAM_IN);
db2_bind_param($stmt,  6, "MASTERKEY", DB2_PARAM_IN);
db2_bind_param($stmt,  7, "DEPOSIT", DB2_PARAM_IN);
db2_bind_param($stmt,  8, "DEPOSITDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  9, "BANK", DB2_PARAM_IN);
db2_bind_param($stmt,  10, "ERROR1", DB2_PARAM_OUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

db2_free_result($stmt);
db2_free_stmt($stmt); 
}

/********************************************************************************* 
* Process the 'Apply Payment' section
**********************************************************************************/	
function Calc_Unapplied (){	
		
// Include ALL global variables 
eval(globals());
	
// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB115 (?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "MASTERKEY", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "DEPOSIT", DB2_PARAM_INOUT);
db2_bind_param($stmt,  5, "UNAPPLIED", DB2_PARAM_INOUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

db2_free_result($stmt);
db2_free_stmt($stmt); 
}

/********************************************************************************* 
* Process the 'Apply Payment' section
**********************************************************************************/	
function ApplyPayment (){	
		
// Include ALL global variables 
eval(globals());
	
// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB111 (?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "MASTERKEY", DB2_PARAM_INOUT);
db2_bind_param($stmt,  5, "LISTKEY", DB2_PARAM_INOUT);
db2_bind_param($stmt,  6, "QAPPLY", DB2_PARAM_IN);
db2_bind_param($stmt,  7, "REF", DB2_PARAM_IN);
db2_bind_param($stmt,  8, "PAY", DB2_PARAM_INOUT);
db2_bind_param($stmt,  9, "OVERPAY", DB2_PARAM_INOUT);
db2_bind_param($stmt, 10, "REASON", DB2_PARAM_INOUT);
db2_bind_param($stmt, 11, "DIFF", DB2_PARAM_INOUT);
db2_bind_param($stmt, 12, "APPLY", DB2_PARAM_INOUT);
db2_bind_param($stmt, 13, "l_button", DB2_PARAM_IN);
db2_bind_param($stmt, 14, "ERROR1", DB2_PARAM_OUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

db2_free_result($stmt);
db2_free_stmt($stmt); 
}

/********************************************************************************* 
* Load Apply payment tables.
**********************************************************************************/
function DispTables1and2 () {
			
// Include ALL global variables 
eval(globals());
	$pointer = 0;
	// Display Total line 	
	echo '
	<table width="99%">
 	 	<tr >
 	 		<td align="right" width="60%">';
 	 			if(count($table2) != 0):
	 	 			echo '
 	 				<b>Reference:</b> <input type="text" name="REF" Value="'.$REF.'" size=10 maxlength=10>
	 				&nbsp;&nbsp;&nbsp;<b>Payment:</b> <input type="text" name="PAY" Value="'.$PAY.'" size=15 maxlength=15> 
	 				&nbsp;&nbsp;&nbsp;<b>Quick Apply:</b> <input type="checkbox" name="QAPPLY" Value="Y" onclick="document.form.l_button.value=\'Calculate\';return Edits();document.form.submit();">
	 				&nbsp;&nbsp;&nbsp;<b>Difference:</b>&nbsp;&nbsp;
	 				<b>';
	 				if(strpos($DIFF,"-") !== false):
	 					echo '<font color="red" size="+2">';
	 				elseif(trim($DIFF) == ""):
	 					$DIFF = "0.00";
	 					echo '<font size="+2">';
	 				else:
	 					echo '<font color="green" size="+2">';
	 				endif;
	 				echo 
	 				$DIFF.'</font></b>
	 				&nbsp;&nbsp;<INPUT type="submit" value="Calculate"  name="SUBMIT_BUTTON" onClick="document.form.l_button.value=\'Calculate\';">';
	 			endif;
			echo '
	 		</td>
 		</tr>
 		<tr >
 	 		<td>';
 	 			if(count($table2) != 0):
	 	 			echo '
 	 				<b>Overpayment Amount:</b> <input type="text" name="OVERPAY" Value="'.$OVERPAY.'" size=10 maxlength=10>
 	 				&nbsp;&nbsp;
 	 				<b>Explanation:</b> <input type="text" name="REASON" Value="'.$REASON.'" size=100 maxlength=100>
 	 				';
	 				
 	 				
	 			endif;
			echo '
	 		</td>
 		</tr>
	</table> 
	<br>';
		
	// Display the Aging Table at end 			
	echo '<table width="99%" align="center">';
	
			//Set the detail rows from the table 
			$cnt = 0;
			foreach ($table2 as  $t2) {
				$cnt += 1;
				echo '<tr>';
				if($cnt == 1):
					echo '
					<td align="right"> <font size=2>'.
	 					$t2['age5'].
	 				'</td>
	 				<td align="right"> <font size=2>'.
	 					$t2['age4'].
	 				'</td>
	 				<td align="right"> <font size=2>'.
	 					$t2['age3'].
	 				'</td>
	 				<td align="right"> <font size=2>'.
	 					$t2['age2'].
	 				'</td>
	 				<td align="right"> <font size=2>'.
	 					$t2['age1'].
	 				'</td>	
	 				<td align="right"> <font size=2> 
	 					BALANCE 
	 				</td>';		
				else:
					echo '
					<td align="right"> <font size=2>
						<span';
							If (strpos($t2['age5'],"-")!== false) echo ' class="negative"';
		 					echo' ><strong>$'.$t2['age5'].'</strong>
		 				</span>
					</td>	       		          		
	 				<td align="right"><font size="2">
	 					<span';
	 						If (strpos($t2['age4'],"-") !== false) echo ' class="negative"';
	 					echo '><strong>$'.$t2['age4'].'</strong>
	 					</span>
	 				</td>
					<td align="right"> <font size="2">
						<span';
	 						If (strpos($t2['age3'],"-") !== false) echo ' class="negative"';
	 					echo '><strong>$'.$t2['age3'].'</strong>
	 					</span>	 					
	 				</td>
	 				<td align="right"> <font size="2">
	 					<span';
	 						If (strpos($t2['age2'],"-") !== false) echo ' class="negative"';
	 					echo '><strong>$'.$t2['age2'].'</strong>
	 					</span>
	 				</td>
	 				<td align="right"><font size="2">
	 					<span';
	 						If (strpos($t2['age1'],"-")!== false) echo ' class="negative"';
	 					echo '><strong>$'.$t2['age1'].'</strong>
	 					</span>
	 				</td>			
		 			<td align="right"><font size="2">
		 				<span'; 
	 						If (strpos($TOTAL,"-") !== false) echo ' class="negative"'; 
  							echo '><strong>
 							$'.$TOTAL.'</strong>
 						</span></font>
		 			</td>';		
				endif;	
			}	
	echo '
	</table>';
	if (count($table1) != "0") echo '<hr>';

	echo '<table width="100%" align="center" border="0">';
	
			// Set the table headings 			
			echo '
			<tr valign="top" style="background-color:'.$DARK.'; color:'.$LIGHTLETTER.'" style="font-size:x-small">	
				<th>
					Invoice<br> Number
				</th>
				<th>
					Inv.<br> Type
				</th>
				<th>
					Invoice<br> Date			
				</th>					
				<th>
					Ship<br>Whse
				</th>
				<th>
					A/R<br>Whse
				</th>
				<th valign="bottom">
					Customer Name
				</th>
				<th>
					Original<br> Invoice 
				</th>
				<th>
					Invoice<br> Balance
				</th>	
				<th valign="bottom">
					Apply
				</th>	
				<th>
					Partial<br>Payment
				</th>
			</tr>';
			
		// Set the detail rows from the table %}
 		if(!count($table1)):
 			echo '<tr><td colspan="7"><h3>No open A/R for Selection</h3></td></tr>';
 		else:
 			$inv_list = $INV_LIST;
 			while (strpos($inv_list, ',,') !== false) {
 				$inv_list = str_replace(",,",",           ,",$inv_list);;
 			}
 			$offset = -9;
 			$st = 0;
 			$cnt = 0;
			foreach ($table1 as  $t1) {
				$cnt += 1;

 				//Has any of the data chnaged?
 				if(trim($LISTKEY) != ""):
	 				$offset += 12;
	 				if(trim($t1['tinvno']) != trim(substr($inv_list, $offset,6))):
	 					
	 				    $ERROR1 = "Screen was reloaded...Data has changed.";
	 					$MACRO = 'arpayment.php?CUST='.trim($CUST).'&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&DEPOSIT='.trim($DEPOSIT).'&DEPOSITDATE='.trim($DEPOSITDATE).'&EMAIL='.trim($EMAIL).'&UPDATE='.trim($UPDATE).'&BANK='.trim($BANK).'&UNAPPLIED='.trim($UNAPPLIED).'&ERROR1='.urlencode(trim($ERROR1));
						//include 'submit.inc';
	 				endif;
	 				if($st > (strlen(trim($PAY_LIST))-1)) $st = strlen(trim($PAY_LIST)-1); 
	 					if(substr($PAY_LIST,$st,1) == ","):
	 					$l_partial = "";
	 					$st += 1;
	 				else:
	 					$comma = strpos($PAY_LIST,",",$st);
	 					if($comma === false):
	 						$comma = strlen($PAY_LIST)-1;
	 						$comma += 1;
	 					endif;	
	 					$l_partial = trim(substr($PAY_LIST,$st,$comma - $st));
	 					$st = $comma;
	 				endif;
	 			endif;
	 			if(trim($t1['tinvno']) == "") $con = " ";
	 			else $con = $t1['arwhse'].$t1['tinvno'].$t1['titype'];
	 			echo '
	 			<INPUT TYPE=HIDDEN NAME=I'.$cnt.' VALUE="'.$con.'">
 				<INPUT TYPE=HIDDEN NAME=W'.$cnt.' VALUE="'.trim($t1['twhse']).'">
 				<INPUT TYPE=HIDDEN NAME=B'.$cnt.'  VALUE="'.trim($t1['tibal']).'">
 				<tr style="font-size:x-small">';
	 			$l_tinvno = $t1['tinvno'];
	 			echo'
	 			<td align="center" ';
	 				if (trim($l_tinvno) != "") echo'class="dottedtop" ';
	 				echo'>
					<span title="Invoice Number"> '.$t1['tinvno'].'</span>	
	       		</td>';
	       		// Handle the ADJUSTMENT REQUEST LINE 
	       		 if(substr($t1['titype'],"1","1") == "*"):
	      			if(trim($t1['titype']) == "*C") $l_memotype = "CREDIT";
	      			else $l_memotype = "DEBIT";
	      			echo'<td align="center"'; 
	      			if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	      			echo '><span title="Invoice Type">AJ</span>
	 					</td>
	      			<td colspan="8"'; 
	      			if (trim($l_tinvno) != "") echo 'class="dottedtop"';  
	      			echo '> '. trim($l_memotype).' MEMO BELOW IS FOR THIS ADJUSTMENT REQUEST
		 				</td>';
		 		 // handle the normal line 
	       		 else:   
	       		 		echo '<td align="center"';
	       		 		 if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	       		 		 echo '> <span title="Invoice Type">'.$t1['titype'].'</span>
		 				</td>
		 				
						<td  align="right"';
	       		 		if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	       		 		 echo '> <span title="Invoice Date">'.$t1['tidate'].'</span>
		 				</td>
		 				<td align="center"';
	       		 		if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	       		 		echo '> <span title="Ship Warehouse">'.$t1['twhse'].'</span>
		 				</td>
		 				<td align="center"';
	       		 		if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	       		 		echo '> <span title="A/R Warehouse">'.$t1['arwhse'].'</span>
		 				</td>
	       				<td   align="left"';
	 					if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
	 					echo '> <span title="Customer Name">'.$t1['tcust'].'</span>
	 					</td>
		 				<td  align="right"';
		 				if (trim($l_tinvno) != "") echo 'class="dottedtop"'; 
		 				echo '> <span title="Original Invoice Amount"';
		 						$l_tiamt = $t1['tiamt'];
		 						If (strpos($l_tiamt,"-") !== false) echo 'class="negative"';
		 						echo '> $'.trim($l_tiamt).
		 					'</span>
		 				</td>
		 				<td  align="right"'; 
		 					if (trim($l_tinvno) != "") echo 'class="dottedtop"';
		 					echo '> <span title="Invoice Balance"';
		 						$l_tibal = $t1['tibal'];
		 						If (strpos($l_tibal,"-") !== false) echo 'class="negative"';
		 						echo '>';
		 						If (trim($l_tibal) != "") echo '$'.trim($l_tibal);
		 						else echo '&nbsp;';
		 					echo'</span>
		 				</td>';
		 				
		 				if ($t1['lock'] == 'Y'):
		 					echo '
		 					<td colspan="2" align="center" class="dottedtop">
		 						<font color="red"><b>Invoice being processed for payment</b></font>
		 					</td>';
		 				else:
		 				
			 				echo '<td '; 
			 				if(trim($l_tinvno) != "") echo 'class="dottedtop"'; 
			 				echo ' align="center">';
		 					If (trim($l_tibal) != ""):
		 						$pointer += 1;
		 						echo '<input type="checkbox" name="APPLY[]" Value="X'.trim($cnt).'X"';
		 						if(strpos($APPLY,'X'.trim($cnt).'X') !== false) echo 'checked';
								echo ' onclick="if(!document.form.APPLY['.trim($pointer-1).'].checked && document.form.A'.trim($cnt).'){ClearPartial('."A".trim($cnt).')}"';
		 						echo '>';
		 					else:
		 						echo '&nbsp;';
		 					endif;	
			 				echo '</td>
			 				<td '; 
			 				if(trim($l_tinvno) != "") echo 'class="dottedtop"'; 
			 				echo 'align="center">';
		 					If (trim($l_tibal) != "" && strpos($l_tibal,"-") === false):
		 						echo '<input type="text" name="A'.trim($cnt).'" 
		 						value="'.$l_partial.'" size=15 maxlength=15 
		 						onchange="if(stp(document.form.A'.trim($cnt).'.value) ==\'\'){document.form.APPLY['.($pointer-1).'].checked = false;}else{document.form.APPLY['.($pointer-1).'].checked = true;}">';
		 					else:
		 						echo '&nbsp;';
		 					endif;
			 				echo '</td>';
		 				endif;
		 				
		 				
		 			endif;	
			}
	  	endif;
	echo'</table>';		
}


/********************************************************************************* 
* Load Apply payment tables.
**********************************************************************************/
function DispTable3 () {
			
// Include ALL global variables 
eval(globals());
	$pointer = 0;
	
	if (count($table3) != "0") 
		echo '
			<br>
			<INPUT type="submit" value="Remove Selected Payment(s)" name="SUBMIT_BUTTON" onClick="document.form.l_button.value=\'Remove Payment\';"><br>
			<br>
		';

	echo '<table width="100%" align="center" border="0">';
	
			// Set the table headings 			
			echo '
			<tr valign="top" style="background-color:'.$DARK.'; color:'.$LIGHTLETTER.'" style="font-size:x-small">
				<th>
					Remove<br>Payment
				</th>
				<th>
					Invoice<br> Number
				</th>
				<th>
					Inv.<br> Type
				</th>
				<th>
					Invoice<br> Date
				</th>
				<th>
					Ship<br>Whse
				</th>
				<th>
					A/R<br>Whse
				</th>
				<th>
					Original<br> Invoice
				</th>
				<th>
					Invoice<br> Balance
				</th>
				<th valign="bottom">
					Payment<br>Amount
				</th>
			</tr>';
			
		// Set the detail rows from the table %}
 		if(!count($table3)):
 			echo '<tr><td colspan="7"><h3>No payments have been entered.</h3></td></tr>';
 		else:
 			$hld_key = '';
 			$cnt = 0;
			foreach ($table3 as  $t3) {
				$cnt += 1;
				
				//Store Header
				if(trim($t3['listkey']) != trim($hld_key)):
					echo '
					<tr style="background-color:#330000;color:#fde8c4;;font-size:x-small">
						<td  align="center" class="dottedtop">
							<input type="checkbox" name="REMOVE[]" Value="'.trim($t3['listkey']).'"  >
						</td>
						<td colspan="7" align="left">'.
							trim($t3['shpnam']).' ('.$t3['custno'].'-'.$t3['cusloc'].')'.
							'&nbsp;&nbsp;&nbsp;&nbsp;Reference: '.trim($t3['ref']).
						'</td>
						<td align="right" class="dottedtop">'.
							$t3['totpay'].
						'</td>
					</tr>';	
					if(trim($t3['overpay']) != ''):
						echo'
						<tr style="font-size:x-small">
							<td class="dottedtop">&nbsp;</td>
							<td class="dottedtop" colspan="7">';
							echo 'Overpayment --> '.trim($t3['reason']);
							echo '</td>
							<td class="dottedtop" align="right">$'.trim($t3['overpay']).'</td>
						</tr>';
					endif;
				endif;
				
				$hld_key = $t3['listkey'];
				
				//Detail Line
				if(trim($t3['invno']) != ''):
					echo '
					<tr style="font-size:x-small">
						<td class="dottedtop">&nbsp;</td>
						<td align="center"class="dottedtop">
							<span title="Invoice Number">'.$t3['invno'].'</span>
						</td>
						<td align="center"class="dottedtop">
							<span title="Invoice Type">'.$t3['invtyp'].'</span>
						</td>
						<td align="right"class="dottedtop">
							<span title="Invoice Date">'.$t3['invdate'].'</span>
						</td>
						<td align="center"class="dottedtop">
							<span title="Ship Warehouse">'.$t3['whsno'].'</span>
						</td>
						<td align="center"class="dottedtop">
							<span title="A/R Warehouse">'.$t3['whsar'].'</span>
						</td>
						<td align="right"class="dottedtop">
							<span title="Original Invoice Amount">$'.$t3['orig'].'</span>
						</td>
						<td align="right"class="dottedtop">
							<span title="Invoice Balance">$'.$t3['bal'].'</span>
						</td>
						<td align="right"class="dottedtop">
							<span title="Invoice Balance">$'.$t3['pay'].'</span>
						</td>
					</tr>';
				endif;
			}
	  	endif;
	echo'</table>';		
}

?>
