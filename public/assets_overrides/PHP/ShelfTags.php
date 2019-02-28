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
$KEY		= " ";
$l_button	= " ";
$MATRIX		= " ";
$SETNAME	= " ";
$REMOVE		= " ";
$LBLSEL	 	= " ";
$ITMBAR		= " ";
$ROW		= " ";
$OFFTOP		= " ";
$OFFLFT		= " ";
$OFFVER		= " ";
$OFFHOR		= " ";
$PRICEDATE	= " ";
$UNSTAMP	= " ";
$OUTQ		= " ";
$GLIST		= " ";
$TRAY		= " ";
$COPIES		= " ";
$SELECT		= " ";
$FSLOT	 	= " ";
$TSLOT		= " ";
$FRSEQ	 	= " ";
$TOSEQ		= " ";
$NEWDATE	= " ";
$TAGDATE	= " ";
$CHANGES	= " ";
$WEEKS	= " ";
$TAGS	= " ";
$TAGSET		= " ";
$VERIFY	= " ";
$SORT1	= " ";
$SORT2	= " ";
$SORT3	= " ";
$SORT4	= " ";
$SORT5	= " ";
$TASK	= " ";
$SHPNAM	= " ";
$cnt3 		= 	0;

include 'PHPTop.inc'; // Must exist at top of all PHP documents!

$beta= ",bobe,grubvs,merchje,grujww,gruglm,grumld,grumtc,leonardr,grudsv,jmorrison,dianes,rcaulder,arlenek,francess,joec,davidf,nwudwb,lbukbz,"; // Beta Testers
if (strpos($beta,(trim($USER).',')) !== false)
	$l_beta = "Y";
else
 	$l_beta = "N";
 
/* Define PHP Specific Variables */
$table1 = array(); 
$table2 = array();
$table3 = array();
$table4 = array();
$table5 = array();
$table6 = array();

/********************************************************************************** 
* Execute the proper HTML section
**********************************************************************************/
if ($MULTIFACE == 'Y'):
	Multiface();
elseif (strtolower($HTML) == 'selection' || trim($HTML) == ''):
	Selection();
elseif (strtolower($HTML) == "submit1"):
	Submit1();
elseif (strtolower($HTML) == "submit2"):
	Submit2();
elseif (strtolower($HTML) == "help"):
	Help();
endif;

/********************************************************************************* 
* Selection web page   
**********************************************************************************/
function Multiface () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'SHELFTAGS'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'MULTIFACE'; // Set equal to "*SKIP" if logging is not desired 
?>

<?//Do not allow Excel Download capability?>
<? header("Content-Type: text/html"); ?>

<html>
<head>
<title>The H.T. Hackney Co. - Shelf Tag Request - Request Multiple Facings</title>
 
<?php 
// Include standard Header code 
include 'standardheadv03.inc'; 
?>
</head>
<body onload="check_frames();">
<?php 
//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
//$AUTH = $l_beta;
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

	// Build the custom page header in the following section
	echo '
	<h2 align="center" style="margin-top: 0; margin-bottom: -10">Shelf Tag Request - Select Multiple Facings</h2>
	';
	
	// Display the selection form 
	echo '
	<form method="POST" action="shelftags.php?HTML=Submit2" name="form"
	id="form" onSubmit="return Edit();">
	';	
		
		$TASK = "LOAD";
		LoadTable2();
		echo '<INPUT TYPE=HIDDEN NAME=ENTRIES VALUE='.count($table6).'>';		
	
		$vars[] = 'MATRIX';   // Load all FORM elements to this array <-------------
		$vars[] = 'CONTAINS';
		$vars[] = 'SETNAME';
?>
		<INPUT TYPE=HIDDEN NAME=l_return VALUE="Selection"> 
		
		<INPUT TYPE=HIDDEN NAME=LOCN VALUE="<? echo trim($LOCN)?>"> 
		<INPUT TYPE=HIDDEN NAME=WHSE VALUE="<? echo trim($WHSE)?>"> 
		<INPUT TYPE=HIDDEN NAME=DCUST VALUE="<? echo trim($DCUST)?>"> 
		<INPUT TYPE=HIDDEN NAME=DLOCN VALUE="<? echo trim($DLOCN)?>">
		<INPUT TYPE=HIDDEN NAME=MATRIX VALUE="<? echo trim($MATRIX)?>"> 
		<INPUT TYPE=HIDDEN NAME=SETNAME VALUE="<? echo trim($SETNAME)?>">
		<INPUT TYPE=HIDDEN NAME=REMOVE VALUE="<? echo trim($REMOVE)?>">
		<INPUT TYPE=HIDDEN NAME=REMOVE VALUE="<? echo trim($REMOVE)?>">
		<INPUT TYPE=HIDDEN NAME=LBLSEL VALUE="<? echo trim($LBLSEL)?>">  
		<INPUT TYPE=HIDDEN NAME=SORT1 VALUE="<? echo trim($SORT1)?>"> 
		<INPUT TYPE=HIDDEN NAME=SORT2 VALUE="<? echo trim($SORT2)?>">
		<INPUT TYPE=HIDDEN NAME=SORT3 VALUE="<? echo trim($SORT3)?>">
		<INPUT TYPE=HIDDEN NAME=SORT4 VALUE="<? echo trim($SORT4)?>">
		<INPUT TYPE=HIDDEN NAME=SORT5 VALUE="<? echo trim($SORT5)?>">  
		<INPUT TYPE=HIDDEN NAME=ITMBAR VALUE="<? echo trim($ITMBAR)?>">
		<INPUT TYPE=HIDDEN NAME=ROW VALUE="<? echo trim($ROW)?>">
		<INPUT TYPE=HIDDEN NAME=OFFTOP VALUE="<? echo trim($OFFTOP)?>">
		<INPUT TYPE=HIDDEN NAME=OFFLFT VALUE="<? echo trim($OFFLFT)?>">
		<INPUT TYPE=HIDDEN NAME=OFFVER VALUE="<? echo trim($OFFVER)?>">
		<INPUT TYPE=HIDDEN NAME=OFFHOR VALUE="<? echo trim($OFFHOR)?>">
		<INPUT TYPE=HIDDEN NAME=PRICEDATE VALUE="<? echo trim($PRICEDATE)?>">
		<INPUT TYPE=HIDDEN NAME=UNSTAMP VALUE="<? echo trim($UNSTAMP)?>">
		<INPUT TYPE=HIDDEN NAME=OFFLFT VALUE="<? echo trim($OFFLFT)?>">
		<INPUT TYPE=HIDDEN NAME=UPDATE VALUE="<? echo trim($UPDATE)?>">
		<INPUT TYPE=HIDDEN NAME=EMAIL VALUE="<? echo trim($EMAIL)?>">
		<INPUT TYPE=HIDDEN NAME=OUTQ VALUE="<? echo trim($OUTQ)?>">
		<INPUT TYPE=HIDDEN NAME=TRAY VALUE="<? echo trim($TRAY)?>">
		<INPUT TYPE=HIDDEN NAME=COPIES VALUE="<? echo trim($COPIES)?>">
		<INPUT TYPE=HIDDEN NAME=SELECT VALUE="<? echo trim($SELECT)?>">
		<INPUT TYPE=HIDDEN NAME=FSLOT VALUE="<? echo trim($FSLOT)?>">
		<INPUT TYPE=HIDDEN NAME=TSLOT VALUE="<? echo trim($TSLOT)?>">
		<INPUT TYPE=HIDDEN NAME=NEWDATE VALUE="<? echo trim($NEWDATE)?>">
		<INPUT TYPE=HIDDEN NAME=TAGDATE VALUE="<? echo trim($TAGDATE)?>">
		<INPUT TYPE=HIDDEN NAME=WEEKS VALUE="<? echo trim($WEEKS)?>">
		<INPUT TYPE=HIDDEN NAME=TAGS VALUE="<? echo trim($TAGS)?>">
		<INPUT TYPE=HIDDEN NAME=TAGSET VALUE="<? echo trim($TAGSET)?>">
		<INPUT TYPE=HIDDEN NAME=CHANGES VALUE="<? echo trim($CHANGES)?>">
		
		<?//If enter key is pressed, then we do not want to issue the 1st submit button.  Instead we want to override?>
		<INPUT TYPE="image" SRC="/images/pixel.jpg" HEIGHT="1" WIDTH="1" BORDER="0" onclick="document.form.l_button.value='Continue'">
<?php	
	echo '
	<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
		<tr>
			<td>
				<h3 style="margin-top: 0; margin-bottom: 0">Custom Order Book: '.$SHPNAM.'</h3>
			</td>
			<td align="right">
				<input type="submit" value="Continue" onclick="document.form.l_button.value=\'Continue\'"> 
			</td>
		</tr>
	</table>
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 0; margin-bottom: 0">
		<tr valign="center" align="middle" style="background-color:'.$DARK.'; color:'.$LIGHTLETTER.'" style="font-size:x-small">
			<th>
				# Of<br>Facings
			</th>
			<th>
				Item #
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
		if(!count($table6)):
 			echo '<tr><td colspan="7"><h3>No Items meet selection criteria</h3></td></tr>';
 		else:
 		$cnt = 0;
			foreach ($table6 as  $t6) {
				$cnt += 1;
				echo'
				<INPUT TYPE=HIDDEN NAME=I'.$cnt.' VALUE="'.trim($t6['itemno']).'">
				<tr style="font-size:x-small">
					<td align="center" class="dottedtop">
						<input type="text" name="Q'.trim($cnt).'" 
		 						value="1" size=2 maxlength=2>
					</td>
					<td align="center" class="dottedtop">
						<span title="Item Number"> '.$t6['itemno'].'</span>	
		       		</td>
		       		<td align="center" class="dottedtop">
						<span title="Pack"> '.$t6['pack'].'</span>	
		       		</td>
		       		<td align="center" class="dottedtop">
						<span title="Size"> '.$t6['size'].'</span>	
		       		</td>
		       		<td  class="dottedtop">
						<span title="Item Description"> '.$t6['descpt'].'</span>	
		       		</td>
	       		</tr>';
			}
		endif;	
	echo'	
	</table>
	</form>
	'; 
	// Include the standard page footer
	include 'footer.inc';

	// Load web page specific menu bar entries, such as DOWNLOAD 
?>
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
	<SCRIPT LANGUAGE="JavaScript"><!--
	<?include "validation_iszero.inc";?>
	<?include 'js_strip_blanks.inc';?>
	function Edit() {
<?php
	
	$cnt = 1;
	while ($cnt < count($table6)){
	 	echo '
		document.form.Q'.trim($cnt).'.value = stp(document.form.Q'.trim($cnt).'.value);
		if(isZero(document.form.Q'.trim($cnt).'))
			document.form.Q'.trim($cnt).'.value = "";';
		//Must be a valid number - if supplied
		echo '
 		if(document.form.Q'.trim($cnt).'.value != ""){
			if (isNaN(document.form.Q'.trim($cnt).'.value) ||
					document.form.Q'.trim($cnt).'.value.indexOf(\'.\') != -1 ||
					document.form.Q'.trim($cnt).'.value.indexOf(\'-\') != -1) {
				alert("# of Facings is not a valid positive number.");
				document.form.Q'.trim($cnt).'.focus();
				return false;
			}
		}';
		$cnt += 1;
	}
?>	
	return true;
	}
	
	//--></script>

<?endif;?>

</body>
</html>

<?php 	
}	

/********************************************************************************* 
* Selection web page   
**********************************************************************************/
function Selection () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'SHELFTAGS'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'SELECTION'; // Set equal to "*SKIP" if logging is not desired 
?>

<?//Do not allow Excel Download capability?>
<? header("Content-Type: text/html"); ?>

<html>
<head>
<title>The H.T. Hackney Co. - Shelf Tag Request</title>
 
<?php 
// Include standard Header code 
include 'standardheadv03.inc'; 
?>

 <?// Include pop-up calendar support code?>     
<script language="JavaScript" src="/scripts/calendar2.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<SCRIPT LANGUAGE="JavaScript"><!--

var rows = 1;
<?if (trim($LBLSEL) != ""):?>
var lower = "<?echo trim($LBLSEL)?>";
lower = lower.toLowerCase(); 
rowcalc(lower);
<?endif;?>

function pad(number, length) {  
	
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
    
}

function RadioClicked(radioid,radiosetname,formid) {
	
	var formm = document.getElementById(formid);
	
	for( var i = 0; i < formm.length; i++ ) {
		a =  formm[i].id;
	   	if(formm[i].name == radiosetname && a != "") {
		  b =  formm[i].id + 'i';
	      document.getElementById(a).checked = false;
	      document.getElementById(b).style.border = '1px solid #000000';
	    }
	}
	document.getElementById(radioid).checked = true;
	a =  radioid + 'i';
	document.getElementById(a).style.border = '5px solid #ff0000';
	rowcalc(radioid);
	return false;
	
}

function rowcalc(radioid) {
	
if 		(radioid == 'tag001') rows = 9;
else if (radioid == 'tag002') rows = 9;
else if (radioid == 'tag003') rows = 10;
else if (radioid == 'tag004') rows = 10;
else if (radioid == 'tag005') rows = 9;
else if (radioid == 'tag006') rows = 9;
else if (radioid == 'tag007') rows = 9;
else if (radioid == 'tag008') rows = 9;
else if (radioid == 'tag009') rows = 9;
else if (radioid == 'tag010') rows = 1;
else if (radioid == 'tag011') rows = 1;
else if (radioid == 'tag012') rows = 1;
else if (radioid == 'tag013') rows = 1;
else if (radioid == 'tag014') rows = 9;
else if (radioid == 'tag015') rows = 9;
else if (radioid == 'tag016') rows = 9;
else if (radioid == 'tag017') rows = 9;
else if (radioid == 'tag018') rows = 9;
else if (radioid == 'tag019') rows = 5;
else if (radioid == 'tag020') rows = 9;
else rows = 1;

}

function filtery(pattern, list){
  /*
  if the dropdown list passed in hasn't
  already been backed up, we'll do that now
  */
  if (!list.bak){
    /*
    We're going to attach an array to the select object
    where we'll keep a backup of the original dropdown list
    */
    list.bak = new Array();
    for (n=0;n<list.length;n++){
      list.bak[list.bak.length] = new Array(list[n].value, list[n].text, list[n].id);
    }
  }

  /*
  We're going to iterate through the backed up dropdown
  list. If an item matches, it is added to the list of
  matches. If not, then it is added to the list of non matches.
  */
  match = new Array();
  nomatch = new Array();
  for (n=0;n<list.bak.length;n++){
    if(list.bak[n][1].toLowerCase().indexOf(pattern.toLowerCase())!=-1){
      match[match.length] = new Array(list.bak[n][0], list.bak[n][1], list.bak[n][2]);
    }else{
      nomatch[nomatch.length] = new Array(list.bak[n][0], list.bak[n][1], list.bak[n][2]);
    }
  }

  /*
  Now we completely rewrite the dropdown list.
  First we write in the matches, then we write
  in the non matches
  */
  for (n=0;n<match.length;n++){
    list[n].value = match[n][0];
    list[n].text = match[n][1];
    list[n].id = match[n][2];
  }
  for (n=0;n<nomatch.length;n++){
    list[n+match.length].value = nomatch[n][0];
    list[n+match.length].text = nomatch[n][1];
    list[n+match.length].id = nomatch[n][2];
  }

  /*
  Finally, we make the 1st item selected - this
  makes sure that the matching options are
  immediately apparent
  */
  list.selectedIndex=0;
}

function LoadCust(str){
	if (document.form.DLOCN && (str.search("/POW ") != -1 || str.search("/HOS ") != -1)) {
		document.form.DCUST.value = str.substr(4,6);
		document.form.DLOCN.value = str.substr(11,3);
	}
}

//--></script>

</head>
<body onload="check_frames();">
<?php 
//If the user is not authorized then display the Not-Authorized web page and DO NOT proceed further
//$AUTH = $l_beta;
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
	// Load the table 
	if ($VERIFY == 'Y'):
		$ERRORD = "You have not established a reference point.  By selecting 'Continue' again, a job will run that will create this reference point.  As a result of this, no shelf tags will be produced.";
		$BUTTON = "SAVE";
	elseif (trim($ERROR) !=  ''):
		$ERRORD = $ERROR;	
	endif;
	if ($RETURNED == 'Y') $BUTTON = "";	
 	LoadTable1(); 
 	$elm2 = count($table2); 

	// if LOCNSELECTION returned, set DCUST/DLOCN and clear other pulldowns
	directcustload();  
	
	// Load the customer pull-downs 
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
	if(trim($WHSE) == "" && trim($WHSTOT) == "1")
		$WHSE = $WHSFST;
?>	
	<SCRIPT LANGUAGE="JavaScript"><!--
	 	
	function RadioChecked(field, elm) {
		str = field.name;
		for( var i = 1; i < 6; i++ ) {
			if(i != str.substring(4,5)){
				fld = 'document.form.'+str.substring(0,4)+i+'['+elm+'].checked = false';
				eval(fld);
			}	
		}
		found1 = 'N';
		found2 = 'N';
		found3 = 'N';
		found4 = 'N';
		found5 = 'N';
		for( var i = 1; i <= <?echo count($table3)?>; i++ ) {
			if (document.form.SORT1[i].checked == true) {
				found1 = 'Y';
			}
			if (document.form.SORT2[i].checked == true) {
				found2 = 'Y';
			}
			if (document.form.SORT3[i].checked == true) {
				found3 = 'Y';
			}
			if (document.form.SORT4[i].checked == true) {
				found4 = 'Y';
			}
			if (document.form.SORT5[i].checked == true) {
				found5 = 'Y';
			}
		}
		if (found1 != 'Y') {
			document.form.SORT1[0].checked = true;
		}
		if (found2 != 'Y') {
			document.form.SORT2[0].checked = true;
		}
		if (found3 != 'Y') {
			document.form.SORT3[0].checked = true;
		}
		if (found4 != 'Y') {
			document.form.SORT4[0].checked = true;
		}
		if (found5 != 'Y') {
			document.form.SORT5[0].checked = true;
		}
	}
	
	//--></script>

	<?// Build the custom page header in the following section?>
	<h2 align="center" style="margin-top: 0; margin-bottom: 0">Shelf Tag
Request</h2>
		
	<?include "CustPulls.inc";?>
	
	<?// Display the selection form ?>
	<form method="POST" action="shelftags.php?HTML=Submit1" name="form"
	id="form" onSubmit="return Edit();">	
<?php 
		$vars[] = 'MATRIX';   // Load all FORM elements to this array <-------------
		$vars[] = 'CONTAINS';
		$vars[] = 'SETNAME';
		$vars[] = 'REMOVE';
		$vars[] = 'ITMBAR';
		$vars[] = 'ROW';
		$vars[] = 'OFFTOP';
		$vars[] = 'OFFLFT';
		$vars[] = 'OFFVER';
		$vars[] = 'OFFHOR';
		$vars[] = 'PRICEDATE';
		$vars[] = 'UNSTAMP';
		$vars[] = 'UPDATE';
		$vars[] = 'EMAIL';
		$vars[] = 'OUTQ';
		$vars[] = 'TRAY';
		$vars[] = 'COPIES';
		$vars[] = 'SOURCE';
		$vars[] = 'SELECT';
		$vars[] = 'FSLOT';
		$vars[] = 'TSLOT';
		$vars[] = 'FRSEQ';
		$vars[] = 'TOSEQ';
		$vars[] = 'NEWDATE';
		$vars[] = 'TAGDATE';
		$vars[] = 'CHANGES';
		$vars[] = 'VERIFY';
		$vars[] = 'WEEKS';
		$vars[] = 'TAGS';
		$vars[] = 'TAGSET';
		$vars[] = 'SORT1';
		$vars[] = 'SORT2';
		$vars[] = 'SORT3';
		$vars[] = 'SORT4';
		$vars[] = 'SORT5';
		
		$vars[] = 'WHSE'; // included because pulldowns(); is included
		$vars[] = 'CUST';
		$vars[] = 'LOCN';
		$vars[] = 'SALES';
		$vars[] = 'SALESBREAK';
		$vars[] = 'VEND';
		$vars[] = 'DCUST';
		$vars[] = 'DLOCN';
		include 'hiddenfields.inc';
		//$AUTHCD = 'U';
?>
		<INPUT TYPE=HIDDEN NAME=l_return VALUE="Selection"> 
		<INPUT TYPE=HIDDEN NAME=ENTRIES VALUE="<? echo trim($cnt3)?>"> 
		<INPUT TYPE=HIDDEN NAME=VERIFY VALUE="<? echo trim($VERIFY)?>">	
		
		<?//If enter key is pressed, then we do not want to issue the 1st submit button.  Instead we want to override?>
		<INPUT TYPE="image" SRC="/images/pixel.jpg" HEIGHT="1" WIDTH="1" BORDER="0" onclick="document.form.l_button.value='Continue'">

<hr>
<h3 style="margin-top: 0; margin-bottom: 10">
<?php 	
		echo 'Step 1: Select a Location';
		if ($AUTHCD == "S" || $AUTHCD == "H"):
			echo ' or a Price Matrix';
		endif;
?>
		</h3>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
	style="margin-top: 0; margin-bottom: 0">
	<tr>
		<td colspan="2">
					<?// Customer Selection?>
					<table border="0" cellpadding="0" cellspacing="0" width="100%"
			align="center">
			<tr>
				<td align="center"><font color="<? echo $DARK?>"><br>
				<b>Location Selection</b></font></td>
							<?if ($AUTHCD == "S" || $AUTHCD == "H"):?>
								<td align="left"><font color="<? echo $DARK?>"><b>Price Matrix
				Selection</b></font><br>
				</td>
							<?endif;?>
						</tr>
			<tr>
				<td valign="top">
								<?pulldowns();?> 
							</td>
							<?// Price Matrix - used to supply customer number?>
							<?if ($AUTHCD == "S" || $AUTHCD == "H"):?>
								<td valign="top" align="left">
				<table border="0" cellpadding="0" cellspacing="0" align="left"
					style="margin-top: 0; margin-bottom: 0">
					<tr>
						<td align="center"><font size="1pt"> Contains:<br>
						<input type="text" name="CONTAINS1" size="25" maxlength="25"
							onkeyup="filtery(this.value,this.form.MATRIX)"
							onchange="filtery(this.value,this.form.MATRIX)"> </font></td>
					</tr>
					<tr>
						<td align="center"><select name="MATRIX" size="5">
							<option value="*NONE" selected>-None-</option> 
<?php
													foreach ($table1 as  $t1) {
														echo '<option value="';
														if (strlen(trim($t1['whsno'])) < 3):
															echo '0'.trim($t1['whsno']);
														else:
															echo trim($t1['whsno']);
														endif;
														$matrix = trim($t1['matrix']);
														while (strlen(trim($matrix)) < 6) {
															$matrix = trim($matrix).'_';
														}
														echo $matrix.trim($t1['matseq']).'">'.trim($t1['whsno']).'-'.trim($t1['matrix']).'/'.trim($t1['matseq']).'</option>';
													}
?> 
												</select></td>
					</tr>
				</table>
				</td>
							<?endif;?>
						</tr>
		</table>
		</td>
	</tr>

</table> 
		
		<?// Shelf Tag Selections?> 
		<hr>
<h3 style="margin-top: 0; margin-bottom: 10">Step 2: Select Shelf Tag Format</h3> <br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
<?php	
				// add labels to array in the order that they should be displayed
				// array(tag name,label width, label height,optional if statement,line1,line2,line3,line4,line5)
				$order = array(
								array('TAG001',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG001','',''),
								array('TAG014',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG014','',''),
								array('TAG017',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG017','',''),
								array('TAG010',210,110,'','Printed on DYMO LabelWriter','DYMO 30336 Compatible Label','Format: TAG010&nbsp;&nbsp;<a href="http://sites.dymo.com/Solutions/Pages/Seg_cat_lndg.aspx?cat=LabelWriterPrinters(DYMO)" target="_blank">www.dymo.com</a>','',''),
								array('TAG003',255,95,'','Printed on Avery 5160 Compatible Label','Format: TAG003','',''),
								array('TAG009',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG009','',''),
								array('TAG012',210,110,'','Printed on DYMO LabelWriter','DYMO 30336 Compatible Label','Format: TAG012&nbsp;&nbsp;<a href="http://sites.dymo.com/Solutions/Pages/Seg_cat_lndg.aspx?cat=LabelWriterPrinters(DYMO)" target="_blank">www.dymo.com</a>','',''),
								array('TAG018',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG018','',''),
								array('TAG002',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG002','',''),
								array('TAG015',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG015','',''),
								array('TAG005',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG005','',''),
								array('TAG016',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG016','',''),
								array('TAG011',210,110,'','Printed on DYMO LabelWriter','DYMO 30336 Compatible Label','Format: TAG011&nbsp;&nbsp;<a href="http://sites.dymo.com/Solutions/Pages/Seg_cat_lndg.aspx?cat=LabelWriterPrinters(DYMO)" target="_blank">www.dymo.com</a>','',''),
								array('TAG004',255,95,'','Printed on Avery 5160 Compatible Label','Format: TAG004','',''),
								array('TAG020',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG020','',''),
								array('TAG008',210,110,'','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG008','',''),
								array('TAG013',210,110,'','Printed on DYMO LabelWriter','DYMO 30336 Compatible Label','Format: TAG013&nbsp;&nbsp;<a href="http://sites.dymo.com/Solutions/Pages/Seg_cat_lndg.aspx?cat=LabelWriterPrinters(DYMO)" target="_blank">www.dymo.com</a>','',''),
								array('TAG006',210,110,'$AUTHCD == "S" || $AUTHCD == "H"','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG006','<b>Not Visible to Customers</b>',''),
								array('TAG007',210,110,'$AUTHCD == "S" || $AUTHCD == "H"','Printed on Hackney Label','Order Item # 9972001 (Laser printer)','Format: TAG007','<b>Not Visible to Customers</b>',''),
								array('TAG019',212,108,'','Printed on Avery 5163 Compatible Label','<b>Actual size is 2" x 4"</b>','Format: TAG019','<b>Not Visible to Customers</b>',''),								
								array('FILE002',210,110,'$AUTHCD == "S" || $AUTHCD == "H"','Printed using <b>Gladson</b> software','<a href="http://gladson.com/our-services/image-merchandising-solutions" target="_blank">www.gladson.com</a>','Format: FILE002','<b>Not Visible to Customers</b>','')
								);
				$cnt = 0;
				foreach ($order as  $tag) {
					$cnt += 1;
					if ($cnt == 5){
						$cnt = 1;
						echo '</tr><tr>';
					}
					
					$continue = true;
					if (trim($tag[3]) != ''){
						$continue = false;
						$if = 'if ('.trim($tag[3]).') $continue = true;';
						eval($if);
					}
					if (!$continue) {
						$cnt -= 1;
					}
					else {
						
						echo '
						<td width ="25%" align="center" valign="top">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
								<tr>
									<td align="right" valign="center">
										<span style="display:none;">
											<input type="radio" name="LBLSEL" Value="'.trim($tag[0]).'"';
												if ($LBLSEL == trim($tag[0])) echo 'checked '; 
												echo 'id="'.strtolower(trim($tag[0])).'">
										</span>
									</td>
									<td align="left" valign="center">
										<img src="/Images/'.strtolower(trim($tag[0])).'.png" width="'.$tag[1].'" height="'.$tag[2].'" border="1" 
			  							id="'.strtolower(trim($tag[0])).'i" 
			  							onclick="RadioClicked(\''.strtolower(trim($tag[0])).'\',\'LBLSEL\',\'form\')" 
			   							style="cursor:pointer;';
										if ($LBLSEL == "'.trim($tag[0]).'") echo 'border:5px solid #ff0000;'; 
										echo '">
									</td>
								</tr>
								<tr>
									<td>
										&nbsp;
									</td>
									<td>
										<font size="1pt">';
											for ($i=4; $i<=8; $i++){
												if (trim($tag[$i]) != '') {
											   		echo trim($tag[$i]).'<br>';
												}
											}
											echo'<br>
										</font>
									</td>
								</tr>
							</table>
						</td>';
					}
				}
?>

<SCRIPT LANGUAGE="JavaScript"><!--
	<?//selct the default label?>
	var lower = "<?echo trim($LBLSEL)?>";
	lower = lower.toLowerCase(); 
	RadioClicked(lower,'LBLSEL','form');	
	//--></script>
<?//Validate form?>		
				<td width="25%" align="center" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4"><font size="-2">NOTE: Dymo labels should not be
		exposed to direct sunlight or they will fade.</font></td>
	</tr>
</table>

<hr>
<h3 style="margin-top: 0; margin-bottom: 0">Step 3: Select Output
Choices</h3>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="50%" valign="top">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td valign="top"> 
								<?// Display the Sort Selections?>
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="6"><font color="<? echo $DARK?>"><br>
						<b>Sort Sequence</b> </font><font size="1pt">(Up to five)</font> <br>
						<br>
						</td>
					</tr>
<?php
									echo'
									<tr>
										<td align="center">5</td>
										<td align="center">4</td>
										<td align="center">3</td>
										<td align="center">2</td>
										<td align="center">1</td>
										<td align="center">&nbsp;</td>
									</tr>
									<tr>
										<td align="center"><input type="radio" name="SORT5" value="*IGNORE"'; If (trim($SORT5) == "") echo " checked"; echo '></td>
										<td align="center"><input type="radio" name="SORT4" value="*IGNORE"'; If (trim($SORT4) == "") echo " checked"; echo '></td>
										<td align="center"><input type="radio" name="SORT3" value="*IGNORE"'; If (trim($SORT3) == "") echo " checked"; echo '></td>
										<td align="center"><input type="radio" name="SORT2" value="*IGNORE"'; If (trim($SORT2) == "") echo " checked"; echo '></td>
										<td align="center"><input type="radio" name="SORT1" value="*IGNORE"'; If (trim($SORT1) == "") echo " checked"; echo '></td>
										<td>**IGNORE**</td>
									</tr>
									';
									$el = 0;
									foreach ($table3 as  $t1) {
										$el += 1;
										echo '
										<tr>
											<td align="center"><input type="radio" name="SORT5" value="'.trim($t1['cdcode']).'"'; If (trim($SORT5) == trim($t1['cdcode'])) echo " checked"; echo ' onclick="RadioChecked(this,'; echo $el; echo')"></td>
											<td align="center"><input type="radio" name="SORT4" value="'.trim($t1['cdcode']).'"'; If (trim($SORT4) == trim($t1['cdcode'])) echo " checked"; echo ' onclick="RadioChecked(this,'; echo $el; echo')"></td>
											<td align="center"><input type="radio" name="SORT3" value="'.trim($t1['cdcode']).'"'; If (trim($SORT3) == trim($t1['cdcode'])) echo " checked"; echo ' onclick="RadioChecked(this,'; echo $el; echo')"></td>
											<td align="center"><input type="radio" name="SORT2" value="'.trim($t1['cdcode']).'"'; If (trim($SORT2) == trim($t1['cdcode'])) echo " checked"; echo ' onclick="RadioChecked(this,'; echo $el; echo')"></td>
											<td align="center"><input type="radio" name="SORT1" value="'.trim($t1['cdcode']).'"'; If (trim($SORT1) == trim($t1['cdcode'])) echo " checked"; echo ' onclick="RadioChecked(this,'; echo $el; echo')"></td>
											<td>'.
												trim($t1['cddesc']).
											'</td>
										</tr>
										';	
									}
?>
								</table>
				</td>
							<?/*?><td valign="top">
								<?// Item Bar Code Format?>
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td colspan="2">
											<font color="<? echo $DARK?>"><br><b>Item Bar Code Format</b></font>
										</td>
									</tr>
<?php
									$cnt = 0;
									foreach ($table4 as  $t1) {
										$cnt += 1;
										echo '
										<tr>
											<td >
												<input type="radio" name="ITMBAR" Value="'.trim($t1['cdcode']).'"';
										 		if (trim($ITMBAR) == trim($t1['cdcode']) || (trim($ITMBAR) == "" && $cnt == 1)) echo ' checked ';
										 		echo '
										 		>
											</td>
											<td>'.
												trim($t1['cdcode']).
											'</td>
										</tr>
										';
									}
?>		
								</table>
							</td><?*/?>
						</tr>
		</table>
		</td>
		<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
								<?// Start Printing On Row?>
								<font color="<? echo $DARK?>"><br>
				<b>Start Printing On Row</b></font> <input type="text" size="2"
					maxlength="2" name="ROW"
					value="<?if (trim($ROW) == "") echo '1'; else echo $ROW?>"> <br>
				<br>
				</td>
			</tr>
			<tr>
				<td>
								<?// Pricing Date?>
								<font color="<? echo $DARK?>"><b>Pricing Date</b></font> <input
					type="text" name="PRICEDATE" size="10" maxlength="10"
					value=<?php
								if (trim($PRICEDATE) == "")
									echo '"'.trim($CURDATE).'"';
								else
									echo '"'.trim($PRICEDATE).'"';
?>
					class="fill"> <a href="javascript:cal1.popup();"><img
					src="/images/cal.gif" width="20" height="20" border="0"
					alt="Click Here to Pick Date"></a> <br>
				<br>
				</td>
			</tr>
			<tr>
				<td>
								<?// Print Unstamped Cigarette Item?>
						  		<input type="checkbox" name="UNSTAMP"  size="2" maxlength="2" Value="01"
					<?if (trim($UNSTAMP) == "01") echo ' checked ';?>> <font
					color="<? echo $DARK?>"><b>Print Unstamped Cigarette Item Number</b></font>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0"> 
						<tr>
							<td colspan=2>
								<font color="<? echo $DARK?>"><br><b>Printer Offsets</b></font> <font size="-1">(-9.999 to 9.999 in milimeters)</font>
								<br>
							</td>
						</tr>
						<tr>
							<td>
								<INPUT TYPE="image" SRC="/images/label.png" HEIGHT="137" WIDTH="208">
							</td>
							<td>
								<table border="0" cellpadding="2" cellspacing="4" valign="top">
									<tr>
										<td bgcolor="#22b14c">
											Left Edge: 
										<td>
										<td><input type="text" size="6"
											maxlength="6" name="OFFLFT"
											value="<?echo trim($OFFLFT)?>">
											
										</td>
									</tr>
									<tr>
										<td bgcolor="#fff200">
											Top Edge:
										<td>
										<td>
											<input type="text" size="6"
											maxlength="6" name="OFFTOP"
											value="<?echo trim($OFFTOP)?>">
										</td>
									</tr>
									<tr>
										<td bgcolor="#ed1c24">
											Vertical Gap:
										<td>
										<td>
											<input type="text" size="6"
											maxlength="6" name="OFFVER"
											value="<?echo trim($OFFVER)?>">
										</td>
									</tr>
									<tr>
										<td bgcolor="#00a2e8">
											Horizontal Gap:
										<td>
										<td>
											<input type="text" size="6"
											maxlength="6" name="OFFHOR"
											value="<?echo trim($OFFHOR)?>">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
				<br>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="2"><br>
		<br>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td valign="top"
					<?php
							$elm5 = count($table5); 
							if(($AUTHCD != "S" && $AUTHCD != "H") || $elm5 == 0)
								echo " colspan='2' align='center'"; 
?>>
								<?//Email Address?>
								<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="top"><font color="<? echo $DARK?>"><b>Email
						Address</b></font><br>
						<font size="1pt"> <input type="checkbox" name="UPDATE" Value="Y">
						Check to attach this address to your web profile </font></td>
					</tr>
					<tr>
						<td align="center" valign="top"><textarea name="EMAIL" rows=2
							cols=50 maxlength=100 wrap><?echo trim($EMAIL)?></textarea></td>
					</tr>
					<tr>
						<td valign="top"> 
											<?$MACRO = "shelftags.php?HTML=Help&CODE=01";?>		
											&nbsp;<a href="javascript:(void);"
							" onClick="window.open('<?echo str_replace("^holymacro", $MACRO, $FULLURLPHP)?>','_blank','width=600,height=450,status=yes,scrollbars=no,left=200,top=200,screenX=10,screenY=10');"><font
							size="1">Important Adobe Printing Instructions</font></a></td>
					</tr>
				</table>
				</td>
<?php 							
							
							if(($AUTHCD == "S" || $AUTHCD == "H") && $elm5 != 0):
?> 
							<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top">
											<?// Select Output Queue?>
											<table border="0" cellpadding="0" cellspacing="0"
							width="100%">
							<tr>
								<td><font color="<? echo $DARK?>"><b>Output Queue</b></font></td>
							</tr>
							<tr>
								<td><select name="OUTQ"
									<?php
														if (($elm5+1) < 5) echo ' size="'.(trim($elm5)+1).'"';
														else echo ' size="5"';
?>>

									<option value="*NONE" selected>-None-</option> 
<?php
															foreach ($table5 as  $t1) {
																echo'
																<option value="'.trim($t1['outq']).'"';
																if (trim($OUTQ) == trim($t1['outq']))
																	echo ' selected';
																echo
																'>'.trim($t1['whsno']).'-'.trim($t1['outq']).' ('.trim($t1['desc']).')</option> 
																';
															}
?> 
														</select> &nbsp;&nbsp;&nbsp;</td>
							</tr>
						</table>
						</td>
						<td valign="top">
											<?// Tray?>
											<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><font color="<? echo $DARK?>"><b>Tray</b></font></td>
							</tr>
							<tr>
								<td><select name="TRAY" size="1">
									<option value="0"
										<?php 
															if (trim($TRAY) == "0" || trim($TRAY) == "")
															 echo ' selected';
?>>Default</option>
									<option value="1"
										<?php 
															if (trim($TRAY) == "1")
															 echo ' selected';
?>>1</option>
									<option value="2"
										<?php 
															if (trim($TRAY) == "2")
															 echo ' selected';
?>>2</option>
									<option value="3"
										<?php 
															if (trim($TRAY) == "3")
															 echo ' selected';
?>>3</option>
								</select> &nbsp;&nbsp;&nbsp;</td>
							</tr>
						</table>
						</td>
						<td valign="top">
											<?// Copies?>
											<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><font color="<? echo $DARK?>"><b>Copies</b></font></td>
							</tr>
							<tr>
								<td><input type="text" size="3" maxlength="3" name="COPIES"
									value="<?if (trim($COPIES) != "") echo $COPIES; else echo "1";?>">
								</td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
				</td>
							<?endif;?>
						</tr>
		</table>
		</td>
	</tr>
</table>


<hr>
<h3 style="margin-top: 0; margin-bottom: 0">Step 4: Select Items</h3>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td valign="top" align="center">
					<?//Item selection?>
					<font color="<?echo $DARK?>"><br>
		<b>Select Items by</b></font><br>
		<select size="3" name="SOURCE">

			<option VALUE="99"
				<?if ($SOURCE == "99" || trim($SOURCE) == "") echo ' selected ';?>>
			-None-</option>
			
			<option VALUE="00" <?if ($SOURCE == "00") echo ' selected ';?>>
			Individual Items</option>
			
			<option VALUE="01" <?if ($SOURCE == "01") echo ' selected ';?>>
			Standard Invoice Category</option>

			<option VALUE="03" <?if ($SOURCE == "03") echo ' selected ';?>>Major
			Product Category</option>

			<option VALUE="02" <?if ($SOURCE == "02") echo ' selected ';?>>
			Product Category</option>
						
						option VALUE="04"
						<?if ($SOURCE == "04") echo ' selected ';?>>
						Cigarette Brand</option>

			<option VALUE="05" <?if ($SOURCE == "05") echo ' selected ';?>>
			Manufacturer</option>

			<option VALUE="S7" <?if ($SOURCE == "S7") echo ' selected ';?>>
			Standard Order Book Header</option>
<?php 
			if ($AUTHCD == "S" || $AUTHCD == "H"):
				echo '
				<option VALUE="C7"';
				if ($SOURCE == "C7") echo ' selected ';
				echo'>
				Custom Order Book</option>
				';
			endif;
?>

			<option VALUE="IG" <?if ($SOURCE == "IG") echo ' selected ';?>>Item
			Grouping</option>

		</select></td>
		<td valign="top">
					<?// Items Included?>
					<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan="2"><font color="<? echo $DARK?>"><br>
				<b>Additional Selections</b></font></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="SELECT[]" Value="03"
					<?if (strpos($SELECT,"03") !== false) echo ' checked ';?>></td>
				<td>In Book Items</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="SELECT[]" Value="04"
					<?if (strpos($SELECT,"04") !== false) echo ' checked ';?>></td>
				<td>Inactive Items</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="SELECT[]" Value="06"
					<?if (strpos($SELECT,"06") !== false) echo ' checked ';?>></td>
				<td>Deactivated Items</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="SELECT[]" Value="05"
					<?if (strpos($SELECT,"05") !== false) echo ' checked ';?>></td>
				<td>Zero Retail Items</td>
			</tr>
		</table>
		</td>
		<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
								<?// # of tag sets?>
								<font color="<? echo $DARK?>"><br>
				<b>Number of Tags Sets</b></font> <input
					type="text" name="TAGSET" size="3" maxlength="3"
					value="<?echo trim($TAGSET)?>" class="fill"></td>
			</tr>
			<tr>
				<td>
								<?// # of labels for each item selcted?>
								<font color="<? echo $DARK?>">
				<b>Number of Tags for Each Item Selected</b></font> <input
					type="text" name="TAGS" size="3" maxlength="3"
					value="<?echo trim($TAGS)?>" class="fill"></td>
			</tr>
			<tr>
				<td>
								<?// Items added to warehouse since this date?>
								<font color="<? echo $DARK?>"><b>Items Added to Warehouse Since</b></font>
				<input type="text" name="NEWDATE" size="10" maxlength="10"
					value="<?echo trim($NEWDATE)?>" class="fill"> <a
					href="javascript:cal2.popup();"><img src="/images/cal.gif"
					width="20" height="20" border="0" alt="Click Here to Pick Date"></a>
				</td>
			</tr>
			<tr>
				<td>
								<?// Items purchased in the last X months?>
								<font color="<? echo $DARK?>"><b>Items purchased in the last</b></font>
				<input type="text" name="WEEKS" size="2" maxlength="2"
					value="<?echo trim($WEEKS)?>" class="fill"> <font
					color="<? echo $DARK?>"><b>months.</b></font></td>
			</tr>
						<?if($AUTHCD == "S" || $AUTHCD == "H"):?> 
							<tr>
				<td>
									<?// warehouse slot range?>
									<font color="<? echo $DARK?>"><b>Warehouse Slot Range</b></font>
				<input type="text" name="FSLOT" size="6" maxlength="6"
					value="<?echo trim($FSLOT)?>" class="fill"> <font
					color="<? echo $DARK?>"><b>to</b></font> <input type="text"
					name="TSLOT" size="6" maxlength="6" value="<?echo trim($TSLOT)?>"
					class="fill"></td>
			</tr>
						<?endif;?>
					</table>
		</td>
	</tr>
	<tr>
				<?if ($elm2 != 0):?>
					<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0" align="center"
			style="margin-top: 0; margin-bottom: 0">
			<tr>
				<td align="center"><font color="<? echo $DARK?>"><b>OR<br>
				<br>
				Select a Tag Set</b></font><br>
				<font size="1pt"> Contains:<br>
				<input type="text" name="CONTAINS2" size="50" maxlength="50"
					onkeyup="filtery(this.value,this.form.SETNAME);LoadCust(document.form.SETNAME[0].id)"
					onchange="filtery(this.value,this.form.SETNAME);LoadCust(document.form.SETNAME[0].id)">
				</font></td>
			</tr>
			<tr>
				<td align="center"><select name="SETNAME" size="5"
					onChange="LoadCust(options[selectedIndex].id)">
					<option id="*NONE" value="*NONE" selected>-None-</option>
<?php
										foreach ($table2 as  $t1) {
											if(trim($t1['whsno']) != "") {
												$desc = trim($t1['whsno']).'-';
												if (trim($t1['custno']) != "000000") 
													$desc = trim($desc).trim($t1['custno']).'/';
												if (trim($t1['cusloc']) != "000") 
													$desc = trim($desc).trim($t1['cusloc']).'/';
												$desc = trim($desc).trim($t1['hdrdsc']);
												echo '<option id="'.trim($desc).'" value="'.trim($t1['whsno']).trim($t1['matrix']).'">'.trim($desc).'</option>';
											}
										}
?> 
									</select></td>
			</tr>
			<tr>
				<td align="center">
					<input type="checkbox" name="REMOVE" Value="Y" checked> Remove Tag Set
				</td>
			</tr>
		</table>
		</td>
				<?endif;?>
				<td <?if ($elm2 == 0):?> colspan="2" <?endif;?>>&nbsp;</td>
		<td valign="top"><br>
		<br>
					<?// Changes Only??>
					<font color="<? echo $DARK?>"><b>Print Tags for Changes Only</b></font>
		<input type="checkbox" name="CHANGES" Value="Y"
			<?if ($CHANGES == "Y") echo ' checked ';?>> <font size="1pt">(system
		will track all changes)</font>
					<?//<br><br><INPUT type="submit" value="Email Request"  name="SUBMIT_BUTTON" onClick="document.form.l_button.value='Email Request';">?>
				</td>
	</tr>
</table>

<hr>

<table border="0" cellpadding="0" cellspacing="0" align="center"
	width="100%">
	<tr>
		<td><br>
		<br>
		&nbsp;</td>
		<td align="center"><input type="submit" value="Continue"
			name="SUBMIT_BUTTON2"
			onclick="document.form.l_button.value='Continue'"> <input
			type="reset" value="Reset" size="20">&nbsp;</td>
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
			var cal1 = new calendar2(document.forms['form'].elements['PRICEDATE']);
			cal1.year_scroll = true;
			cal1.time_comp = false;	
		<?/*specify form element as the only parameter (document.forms['formname'].elements['inputname']); 
			You can have as many calendar objects as you need for your application */?>
			var cal2 = new calendar2(document.forms['form'].elements['NEWDATE']);
			cal2.year_scroll = true;
			cal2.time_comp = false;	
	//--></script>
<SCRIPT LANGUAGE="JavaScript"><!--

	<?//selct the default label?>
	var lower = "<?echo trim($LBLSEL)?>";
	lower = lower.toLowerCase(); 
	RadioClicked(lower,'LBLSEL','form');
	
	<?include 'js_strip_blanks.inc'?>
	<?include "validation_iszero.inc";?>
	<?include "js_trim.inc";?>
	<? include 'validation_email_address.inc';?>
    
	function Edit() {	
	if(document.form.l_button.value!='Customer Retrieval') {
	<?/* Validate Location/matrix/tag set
		  - Exactly one must be supplied, no more, no less
	*/?>
	<?if($AUTHCD == "S" || $AUTHCD == "H"):?> 
		assoc = "Y";
	<?else:?>
		assoc = "N";
	<?endif;?>
	validatecust = "N"; 
	
	if (document.form.LOCN) locn = document.form.LOCN.value; else locn = "*NONE";
	if (document.form.DCUST) dcust = document.form.DCUST.value; else dcust = "*NONE";
	if (document.form.MATRIX) matrix = document.form.MATRIX.value; else matrix = "*NONE";
	if (document.form.SETNAME) setname = document.form.SETNAME.value; else setname = "*NONE";

	if (stp(dcust) == "") dcust = "*NONE";
	if (stp(locn) == "") locn = "*NONE";

	if (document.form.LOCN.type == "hidden" && matrix != "*NONE" && stp(matrix) != "") {
		document.form.LOCN.value = "*NONE"
		locn = "*NONE"
	}
	
	tot = 0;
	if (dcust != "*NONE" || locn != "*NONE") 
		tot += 1;
	if (matrix != "*NONE") tot += 1;

	if(dcust == "*NONE" && locn == "*NONE" && matrix == "*NONE" && assoc == "Y") {
		alert("Must supply a Location or Matrix.");
		return false;
	}
	else if (assoc == "Y"){
		if (tot > 1) {
			alert("Can supply a Location or Matrix, but not both.");
			return false;
		}
		else if (dcust != "*NONE" || locn != "*NONE") validatecust = "Y"; 
	}
	if (assoc != "Y" || validatecust == "Y"){
		<?include "validationcustomer.inc";?> 
	}
	<?/* Validate Shelf Tag Format
	      - One must be selected
	*/?>
	radio_choice = false;
	for (counter = 0; counter < document.form.LBLSEL.length; counter++){
		if (document.form.LBLSEL[counter].checked) radio_choice = true; 
	}
	if (!radio_choice){
		alert("Must select a label by clicking on one of the choices.");
		return false;
	}
	
	<?/* Validate Sort Sequence
		      - None
	*/?>

	
	<?/* Validate Row
		      - Must be supplied
		      - Must be a number
		      - Test for upper limit based on label selected
	*/?>
	document.form.ROW.value = stp(document.form.ROW.value);
	if(is_Zero(document.form.ROW.value)) document.form.ROW.value = "";
	if (isNaN(document.form.ROW.value)  ||
			trim(document.form.ROW.value) == "" ||
			document.form.ROW.value.indexOf('.') != -1 ||
			document.form.ROW.value.indexOf('-') != -1) {
		alert("The Row is not a valid positive number.");
		document.form.ROW.focus();
		return false;
	}
	if (document.form.ROW.value > rows) {
		alert("The label selected only supports "+rows+" rows.");
		document.form.ROW.focus();
		return false;
	}
	<?/* Validate offsets
		      - Must be supplied
		      - Must be a number
	*/?>
	
	if(is_Zero(document.form.OFFLFT.value)) document.form.OFFLFT.value = "";
	neg = document.form.OFFLFT.value.indexOf('-');
	if (neg != -1){
		var a = new String(document.form.OFFLFT.value);
		document.form.OFFLFT.value = a.replace("-"," ");
	}
	document.form.OFFLFT.value = stp(document.form.OFFLFT.value);
	if(is_Zero(document.form.OFFLFT.value)) document.form.OFFLFT.value = "";
	if (document.form.OFFLFT.value != "") {
		if (isNaN(document.form.OFFLFT.value)  ||
				trim(document.form.OFFLFT.value) == "")  {
			alert("The Left Edge Offset is not a valid number.");
			if (neg != -1 ){
				document.form.OFFLFT.value = '-' + document.form.OFFLFT.value
			}
			document.form.OFFLFT.focus();
			return false;
		}
		if (document.form.OFFLFT.value > 9.999) {
			alert("The Left Edge Offset must be in range -9.999 to 9.999.");
			document.form.OFFLFT.focus();
			return false;
		}
		if (neg != -1 && document.form.OFFLFT.value != ""){
			document.form.OFFLFT.value = '-' + document.form.OFFLFT.value
		}
	}
	
	if(is_Zero(document.form.OFFTOP.value)) document.form.OFFTOP.value = "";
	neg = document.form.OFFTOP.value.indexOf('-');
	if (neg != -1){
		var a = new String(document.form.OFFTOP.value);
		document.form.OFFTOP.value = a.replace("-"," ");
	}
	document.form.OFFTOP.value = stp(document.form.OFFTOP.value);
	if(is_Zero(document.form.OFFTOP.value)) document.form.OFFTOP.value = "";
	if (document.form.OFFTOP.value != "") {
		if (isNaN(document.form.OFFTOP.value)  ||
				trim(document.form.OFFTOP.value) == "")  {
			alert("The Top Edge Offset is not a valid number.");
			if (neg != -1 ){
				document.form.OFFTOP.value = '-' + document.form.OFFTOP.value
			}
			document.form.OFFTOP.focus();
			return false;
		}
		if (document.form.OFFTOP.value > 9.999) {
			alert("The Top Edge Offset must be in range -9.999 to 9.999.");
			document.form.OFFTOP.focus();
			return false;
		}
		if (neg != -1 && document.form.OFFTOP.value != ""){
			document.form.OFFTOP.value = '-' + document.form.OFFTOP.value
		}
	}
	
	if(is_Zero(document.form.OFFVER.value)) document.form.OFFVER.value = "";
	neg = document.form.OFFVER.value.indexOf('-');
	if (neg != -1){
		var a = new String(document.form.OFFVER.value);
		document.form.OFFVER.value = a.replace("-"," ");
	}
	document.form.OFFVER.value = stp(document.form.OFFVER.value);
	if(is_Zero(document.form.OFFVER.value)) document.form.OFFVER.value = "";
	if (document.form.OFFVER.value != "") {
		if (isNaN(document.form.OFFVER.value)  ||
				trim(document.form.OFFVER.value) == "")  {
			alert("The Vertical Offset is not a valid number.");
			if (neg != -1 ){
				document.form.OFFVER.value = '-' + document.form.OFFVER.value
			}
			document.form.OFFVER.focus();
			return false;
		}
		if (document.form.OFFVER.value > 9.999) {
			alert("The Vertical Offset must be in range -9.999 to 9.999.");
			document.form.OFFVER.focus();
			return false;
		}
		if (neg != -1 && document.form.OFFVER.value != ""){
			document.form.OFFVER.value = '-' + document.form.OFFVER.value
		}
	}

	if(is_Zero(document.form.OFFHOR.value)) document.form.OFFHOR.value = "";
	neg = document.form.OFFHOR.value.indexOf('-');
	if (neg != -1){
		var a = new String(document.form.OFFHOR.value);
		document.form.OFFHOR.value = a.replace("-"," ");
	}
	document.form.OFFHOR.value = stp(document.form.OFFHOR.value);
	if(is_Zero(document.form.OFFHOR.value)) document.form.OFFHOR.value = "";
	if (document.form.OFFHOR.value != "") {
		if (isNaN(document.form.OFFHOR.value)  ||
				trim(document.form.OFFHOR.value) == "")  {
			alert("The Horizontal Offset is not a valid number.");
			if (neg != -1 ){
				document.form.OFFHOR.value = '-' + document.form.OFFHOR.value
			}
			document.form.OFFHOR.focus();
			return false;
		}
		if (document.form.OFFHOR.value > 9.999) {
			alert("The Horizontal Offset must be in range -9.999 to 9.999.");
			document.form.OFFHOR.focus();
			return false;
		}
		if (neg != -1 && document.form.OFFHOR.value != ""){
			document.form.OFFHOR.value = '-' + document.form.OFFHOR.value
		}
	}
	<?/* Validate Pricing Date
		      - Must be a valid date
		      - Cannot be less than today
	*/?>
	var dt_date1 = cal1.prs_date(document.form.PRICEDATE.value);
	if (!dt_date1) {
		document.form.PRICEDATE.focus();
		return false;
	}
	else document.form.PRICEDATE.value = cal1.gen_date(dt_date1); 
	if (cal1.gen_iso(dt_date1) < <?echo "'".substr($CURDATE,6,4)."/".substr($CURDATE,0,2)."/".substr($CURDATE,3,2)."'" ?>) {
		alert("The Pricing Date cannot be less than the current date.");
		document.form.PRICEDATE.focus();
		return false;
	}
	
	<?/* Validate email address/output queue 
		      - Either the Email or outq must be supplied (not both)
		      - If email address is supplied then it must be valid
		      - Output Queue cannot be supplied for certain labels
	*/?>
	if (document.form.OUTQ) outq = document.form.OUTQ.value;
	else outq = "*NONE";
	if ((trim(document.form.EMAIL.value) == "" && trim(outq) == "*NONE") ||
		(trim(document.form.EMAIL.value) != "" && trim(outq) != "*NONE")
		) {
		alert("Must supply either an Email Address or an Output Queue, but not both.");
		document.form.EMAIL.focus();
		return false;
	}
	if (trim(document.form.EMAIL.value) != "" && !ValidEmail(document.form.EMAIL.value)) {
		alert("Invalid email address entered.");
		document.form.EMAIL.focus();
		return false;
	}
	if (document.getElementById('file002')) {
		if (document.getElementById('file002').checked == true && outq != '*NONE') {
			alert("The label selected can not be printed to an output queue.");
			document.form.OUTQ.focus();
			return false;
		}
	}
	<?/* Validate copies 
		      - if output queue is not selected then set to 1
		      - If output queue is selected
		          - must be a valid positive integer
	*/?>
	if (document.form.COPIES) {
		if (outq == '*NONE') {
			document.form.COPIES.value = 1;
		}
		else {
			document.form.COPIES.value = stp(document.form.COPIES.value);
			if(is_Zero(document.form.COPIES.value)) document.form.COPIES.value = "";
			if (isNaN(document.form.COPIES.value)  ||
					trim(document.form.COPIES.value) == "" ||
					document.form.COPIES.value.indexOf('.') != -1 ||
					document.form.COPIES.value.indexOf('-') != -1) {
				alert("The Copies is not a valid positive number.");
				document.form.COPIES.focus();
				return false;
			}
		}
	}
	<?/* Validate Tag Set & Select Items By
		      - Must select one or the other
	*/?>
	if ((setname == "*NONE" && document.form.SOURCE.value == "99") || (setname != "*NONE" && document.form.SOURCE.value != "99")){
		if (document.form.SETNAME)
			alert("Must select a Tag Set or make a selection for 'Select Item by', but not both.");
		else
			alert("Must select make a selection for 'Select Item by'.");
		document.form.SOURCE.focus();
		return false;
	}
	
	<?/* Validate Print Tag Changes
		      - A location must be selected if this is checked
	*/?>
	if (document.form.CHANGES.checked && document.form.LOCN.value == "*NONE"){
		alert("A location must be selected when printing tags for changes only.");
		return false;
	}
	<?/* Validate # of Tag Sets
		      - Must be supplied
		      - Must be a number
	*/?>
	document.form.TAGSET.value = stp(document.form.TAGSET.value);
	if(is_Zero(document.form.TAGSET.value)) document.form.TAGSET.value = "1";
	if (isNaN(document.form.TAGSET.value)  ||
			trim(document.form.TAGSET.value) == "" ||
			document.form.TAGSET.value.indexOf('.') != -1 ||
			document.form.TAGSET.value.indexOf('-') != -1) {
		alert("The Number of Tags Sets is not a valid positive number.");
		document.form.TAGSET.focus();
		return false;
	}
	<?/* Validate # of Tags
		      - Must be supplied
		      - Must be a number
	*/?>
	document.form.TAGS.value = stp(document.form.TAGS.value);
	if(is_Zero(document.form.TAGS.value)) document.form.TAGS.value = "1";
	if (isNaN(document.form.TAGS.value)  ||
			trim(document.form.TAGS.value) == "" ||
			document.form.TAGS.value.indexOf('.') != -1 ||
			document.form.TAGS.value.indexOf('-') != -1) {
		alert("The Number of Tags is not a valid positive number.");
		document.form.TAGS.focus();
		return false;
	}
	<?/* Validate # of Months, if supplied
		      - Must be a number
		      - must be with 2 years
	*/?>
	document.form.WEEKS.value = stp(document.form.WEEKS.value);
	if(is_Zero(document.form.WEEKS.value)) document.form.WEEKS.value = "";
		if (document.form.WEEKS.value != "") {
			if (isNaN(document.form.WEEKS.value)  ||
					trim(document.form.WEEKS.value) == "" ||
					document.form.WEEKS.value.indexOf('.') != -1 ||
					document.form.WEEKS.value.indexOf('-') != -1) {
				alert("The Number of Months is not a valid positive number.");
				document.form.WEEKS.focus();
				return false;
			}
			if (document.form.WEEKS.value > 24) {
				alert("The Number of Months cannot be greater than 24.");
				document.form.WEEKS.focus();
				return false;
			}
		}
	<?/* Validate warehouse slot range
		      - cannot be supplied if tag set is selected
		      - If to slot is not supplied than set to from slot
		      - To slot cannot be less than from slot
	*/?>
	if (document.form.FSLOT) {
		document.form.FSLOT.value = stp(document.form.FSLOT.value);
		document.form.TSLOT.value = stp(document.form.TSLOT.value);
		if(is_Zero(document.form.FSLOT.value)) document.form.FSLOT.value = "";
		if(is_Zero(document.form.TSLOT.value)) document.form.TSLOT.value = "";
		if (document.form.TSLOT.value == "" ) document.form.TSLOT.value = document.form.FSLOT.value;
		if (setname != "*NONE" && (document.form.FSLOT.value != "" || document.form.TSLOT.value != "")) {
			alert("Slot Range cannot be supplied if a Tag  Set has been selected.");
			document.form.FSLOT.focus();
			return false;
		}
		if (document.form.TSLOT.value < document.form.FSLOT.value) {
			alert("The To Slot cannot be less than the From Slot.");
			document.form.TSLOT.focus();
			return false;
		}
	}
	<?/* Validate New Date
		      - If supplied;
		         - Must be a valid date
		         - Cannot be greatert than today
	*/?>
	document.form.NEWDATE.value = stp(document.form.NEWDATE.value);
	if (document.form.NEWDATE.value != "") {
		var dt_date2 = cal2.prs_date(document.form.NEWDATE.value);
		if (!dt_date2) {
			document.form.NEWDATE.focus();
			return false;
		}
		else document.form.NEWDATE.value = cal1.gen_date(dt_date2); 
		if (cal2.gen_iso(dt_date2) > <?echo "'".substr($CURDATE,6,4)."/".substr($CURDATE,0,2)."/".substr($CURDATE,3,2)."'" ?>) {
			alert("The Items Added to Warehouse Since Date cannot be greater than the current date.");
			document.form.NEWDATE.focus();
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

/********************************************************************************* 
* Help Window   
**********************************************************************************/
function Help () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'SHELFTAGS'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = 'HELP'; // Set equal to "*SKIP" if logging is not desired 
?>

<?//Do not allow Excel Download capability?>
<? header("Content-Type: text/html"); ?>

<html>
<head>
<title>The H.T. Hackney Co. - Shelf Tag Request - Help</title>
 
<?php 
// Include standard Header code 
include 'standardheadv03.inc'; 
?>

</head>
<body>
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
else:
	if(trim($CODE) == "01"):
		echo '
		<h5 align="center" style="margin-top: 0; margin-bottom: 0">Topic: Adobe Printing Instructions</h5>
		<p>
		By default Adobe will <b>scale</b> your output so that it fits on 
		the page.  If the defaults are not changed, the labels will not print 
		properly. 
		</p>
		<p>
		This section will appear when printing the labels:
		</p>
		<br>
		<table align="center"><tr><td>
		<img src="/Images/pagehandling.png" width="287" height="151" border="1">
		<br><br>
		<ul>
		<li>Change <b>Page Scaling</b> to <b>None</b>
		<li>Uncheck <b>Auto-Rotate and Center</b>
		</td></tr></table>
		';
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

//Load local variables
$FUNCTIONCODE = 'SHELFTAGS'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = '*SKIP'; // Set equal to "*SKIP" if logging is not desired
$ERRORD = '';

$MATRIX = str_replace('&', '~', $MATRIX);  // replace special characters
$MATRIX = str_replace('?', '^', $MATRIX); 
$SETNAME = str_replace('&', '~', $SETNAME); 
$SETNAME = str_replace('?', '^', $SETNAME);

//Load variables
$ORIG = "shelftags.php";  // Do Not set to t.mac for testing 
$SUBMIT = "Shelf Tag Request";

// Setup Parameters that are specific for the web page being executed 

echo '<html><head><title>The H.T. Hackney Co. - Shelf Tag Request Submit1</title>';

//Include the style sheet
include "style.inc";
echo '
</head>
<body>';

echo $PLEASEWAIT;

if ($CHANGES == "Y" && $VERIFY == "Y"):
	$l_button = "Base";
endif;	
$PARMS2 = '&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.urlencode(trim($REMOVE)).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&WEEKS='.trim($WEEKS).'&TAGS='.trim($TAGS).'&TAGSET='.trim($TAGSET).'&BUTTON='.urlencode(trim($l_button)).'&CHANGES='.trim($CHANGES);

// More edits are needed if Hackney associate Entered a customer and/or location directly 
DirectCustEdit();
if (trim($ERRORD) != ""):
	$l_button = "";
	$PARMS1 = '&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&SOURCE='.trim($SOURCE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN);
	$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&ERRORD='.urlencode(trim($ERRORD));	
else:
	if (trim($MATRIX) == '*NONE' && $l_button != "Customer Retrieval"):
		TestLoc();
	else:
		$ERROR = "";	
	endif;
	if (trim($ERROR) != ""):
		$l_button = "";
		$PARMS1 = '&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&SOURCE='.trim($SOURCE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN);
		$PARMS2 = '&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.urlencode(trim($REMOVE)).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&WEEKS='.trim($WEEKS).'&TAGS='.trim($TAGS).'&TAGSET='.trim($TAGSET).'&BUTTON='.urlencode(trim($l_button)).'&CHANGES='.trim($CHANGES);
		$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&ERROR='.urlencode(trim($ERROR));	
	else:
		// Edit warehouse and location 
		if($l_button != "Customer Retrieval"):
			if (trim($MATRIX) == '*NONE'):
				$l_checkitem = "N";
				TestItem ($l_checkitem);
			else:
				$ERROR = "";	
			endif;	
			if(trim($ERROR) != ""):
				$l_button = "";
				$PARMS1 = '&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&SOURCE='.trim($SOURCE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN);
				$PARMS2 = '&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.urlencode(trim($REMOVE)).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&WEEKS='.trim($WEEKS).'&TAGS='.trim($TAGS).'&TAGSET='.trim($TAGSET).'&BUTTON='.urlencode(trim($l_button)).'&CHANGES='.trim($CHANGES);
				$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&ERROR='.urlencode(trim($ERROR));
			else:
				$PARMS1 = '&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&SOURCE='.trim($SOURCE).'&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN);
				if ($CHANGES == "Y"):
					if ($VERIFY == "Y"):
						$CHANGES = '';
						$PARMS2 = '&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.trim($REMOVE).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&BUTTON='.urlencode(trim($l_button)).'&CHANGES='.trim($CHANGES);
						$ERROR = 'A job will be run that will establish a reference point for this store location.  This process should be completed within the hour.';
						$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&ERROR='.urlencode(trim($ERROR));
					else:
						testchanges();
						if (trim($ERROR) == "Y"):
							$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&VERIFY=Y';
						endif;
					endif;
				endif;
			endif;		
		endif;
		if (trim($MACRO) == ""):
			if ($SOURCE == "S7")
				CheckOrderBook();
			else
				$ERROR1 = "";
	
			// Add parms not used by Lookup or ItemInquiry 
			$EXECPARM = str_replace('&','%26',$PARMS2);
			$EXECURL =urlencode("shelftags.php");
			
			if (trim($ERROR1) != ""):
				$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2).'&ERROR1='.urlencode(trim($ERROR1));		
			elseif (trim($SOURCE) != "00" && (trim($SETNAME) == '*NONE' || trim($SETNAME) == '')):
				$MACRO = 'lookupV04.mac/Select?ignore='.trim($PARMS1).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&EXECURL='.trim($EXECURL).'&EXECPARM='.trim($EXECPARM);
			elseif (trim($SOURCE) == "00"):
				$SETNAME = '*NONE';
				$PARMS2 = '&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.urlencode(trim($REMOVE)).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&BUTTON='.urlencode(trim($l_button)).'&CHANGES='.trim($CHANGES);
				$MACRO = 'ItemInquiryV05.mac/Search?ignore='.trim($PARMS1).'&ORIG='.trim($ORIG).'&SUBMIT='.urlencode($SUBMIT).'&EXECURL='.trim($EXECURL).'&EXECPARM='.trim($EXECPARM);
			else:
				$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2);
			endif;
		
			// email request button 
			if($l_button == "Email Request"):
				$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2);
				$l_macro_execute = $MACRO;					
				if(trim($l_return) != "")
					$MACRO = str_replace("Selection", $l_return, $MACRO);
				$l_macro_return = $MACRO;
				$MACRO = 'emailrequestv04.mac/request?RETURNURL='.urlencode(trim($l_macro_return)).'&REQUESTURL='.urlencode(trim($l_macro_execute)).'&ENDDAT='.trim($TODATE);
			// retrieve a customer 
			elseif($l_button == "Customer Retrieval"):
				$MACRO = 'shelftags.php?HTML=Selection'.trim($PARMS1).trim($PARMS2); 
				if(trim($l_return) != "")
					$MACRO = str_replace("Selection",$l_return,$MACRO);
				$l_macro_execute = $MACRO;
				$MACRO = 'CustRetrieval.mac/CustSelection?ORIG='.urlencode(trim($ORIG)).'&RETURNURL='.urlencode(trim($l_macro_execute));
			endif;
		endif;
	endif;
endif;
//If the URL length is too long then reload page with error 
if(strlen($MACRO) > $MAXURL) //Set the variable MACRO equal to the macro that is supposed to be executed 
	$MACRO = 'shelftags.php?HTML=Selection&ERROR='.urlencode("Too many selections have been made. Please make new selection."); 
//display the appropriate web page
include 'submit.inc';
//echo $MACRO;
echo '
</body>
</html>';
}

/********************************************************************************** 
* Submit  
***********************************************************************************/
function Submit2 () {

// Include ALL global variables 
eval(globals());	

//Load local variables
$FUNCTIONCODE = 'SHELFTAGS'; // ***MUST EXIST IN WBPFUNC IF DRIVEN FROM MENU BAR 
$PAGEID = '*SKIP'; // Set equal to "*SKIP" if logging is not desired

//Load variables

// Setup Parameters that are specific for the web page being executed 

echo '<html><head><title>The H.T. Hackney Co. - Shelf Tag Request Submit2</title>';

//Include the style sheet
include "style.inc";
echo '
</head>
<body>';

echo $PLEASEWAIT;

$cnt = 1;
$comma = "";
while ($cnt <= $ENTRIES){
	$qty = 'Q'.$cnt;
	$itm = 'I'.$cnt; 
	$Q = $Q.trim($comma).$$qty;
	$I = $I.trim($comma).$$itm; 
	$comma = ",";
	$cnt += 1;
}

$ACTION = "U";
$KEY = "ITEM";
$ORGIN = "WEB";
$LIST = trim($I);
Store_Lists ();
$ACTION = "U";
$KEY = "QTY";
$ORGIN = "WEB";
$LIST = trim($Q);
Store_Lists ();

$TASK = "SUBMIT";
LoadTable2();

$MACRO = 'shelftags.php?HTML=Selection&LOCN='.trim($LOCN).'&WHSE='.trim($WHSE).'&SOURCE=00&DCUST='.trim($DCUST).'&DLOCN='.trim($DLOCN).'&MATRIX='.urlencode(trim($MATRIX)).'&SETNAME='.urlencode(trim($SETNAME)).'&REMOVE='.urlencode(trim($REMOVE)).'&LBLSEL='.urlencode(trim($LBLSEL)).'&SORT1='.urlencode(trim($SORT1)).'&SORT2='.urlencode(trim($SORT2)).'&SORT3='.urlencode(trim($SORT3)).'&SORT4='.urlencode(trim($SORT4)).'&SORT5='.urlencode(trim($SORT5)).'&ITMBAR='.urlencode(trim($ITMBAR)).'&ROW='.trim($ROW).'&OFFTOP='.trim($OFFTOP).'&OFFLFT='.trim($OFFLFT).'&OFFVER='.trim($OFFVER).'&OFFHOR='.trim($OFFHOR).'&PRICEDATE='.urlencode(trim($PRICEDATE)).'&UNSTAMP='.urlencode(trim($UNSTAMP)).'&UPDATE='.urlencode(trim($UPDATE)).'&EMAIL='.urlencode(trim($EMAIL)).'&OUTQ='.urlencode(trim($OUTQ)).'&TRAY='.urlencode(trim($TRAY)).'&COPIES='.urlencode(trim($COPIES)).'&SELECT='.urlencode(trim($SELECT)).'&FSLOT='.urlencode(trim($FSLOT)).'&TSLOT='.urlencode(trim($TSLOT)).'&NEWDATE='.urlencode(trim($NEWDATE)).'&TAGDATE='.urlencode(trim($TAGDATE)).'&WEEKS='.trim($WEEKS).'&TAGS='.trim($TAGS).'&TAGSET='.trim($TAGSET).'&BUTTON=Continue&CHANGES='.trim($CHANGES).'&KEY='.trim($KEY);

//If the URL length is too long then reload page with error 
if(strlen($MACRO) > $MAXURL) //Set the variable MACRO equal to the macro that is supposed to be executed 
	$MACRO = 'shelftags.php?HTML=Selection&ERROR='.urlencode("Too many selections have been made. Please make new selection."); 
//display the appropriate web page
include 'submit.inc';
echo '
</body>
</html>';
}

/********************************************************************************* 
* Load Item Inquiry Reporting tables.
**********************************************************************************/	
function LoadTable1 (){
	
// Include ALL global variables 
eval(globals());
	
// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB245 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "PAGEID", DB2_PARAM_IN);
db2_bind_param($stmt,  5, "BUTTON", DB2_PARAM_IN);
db2_bind_param($stmt,  6, "WHSE", DB2_PARAM_IN);
db2_bind_param($stmt,  7, "LOCN", DB2_PARAM_IN);
db2_bind_param($stmt,  8, "MATRIX", DB2_PARAM_IN);
db2_bind_param($stmt,  9, "SETNAME", DB2_PARAM_IN);
db2_bind_param($stmt,  10, "REMOVE", DB2_PARAM_IN);
db2_bind_param($stmt,  11, "LBLSEL", DB2_PARAM_INOUT);
db2_bind_param($stmt,  12, "SORT1", DB2_PARAM_INOUT);
db2_bind_param($stmt,  13, "SORT2", DB2_PARAM_INOUT);
db2_bind_param($stmt,  14, "SORT3", DB2_PARAM_INOUT);
db2_bind_param($stmt,  15, "SORT4", DB2_PARAM_INOUT);
db2_bind_param($stmt,  16, "SORT5", DB2_PARAM_INOUT);
db2_bind_param($stmt,  17, "ITMBAR", DB2_PARAM_INOUT);
db2_bind_param($stmt,  18, "ROW", DB2_PARAM_INOUT);
db2_bind_param($stmt,  19, "OFFTOP", DB2_PARAM_INOUT);
db2_bind_param($stmt,  20, "OFFLFT", DB2_PARAM_INOUT);
db2_bind_param($stmt,  21, "OFFVER", DB2_PARAM_INOUT);
db2_bind_param($stmt,  22, "OFFHOR", DB2_PARAM_INOUT);
db2_bind_param($stmt,  23, "PRICEDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  24, "UNSTAMP", DB2_PARAM_INOUT);
db2_bind_param($stmt,  25, "UPDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  26, "EMAIL", DB2_PARAM_INOUT);
db2_bind_param($stmt,  27, "OUTQ", DB2_PARAM_INOUT);
db2_bind_param($stmt,  28, "TRAY", DB2_PARAM_INOUT);
db2_bind_param($stmt,  29, "COPIES", DB2_PARAM_INOUT);
db2_bind_param($stmt,  30, "SOURCE", DB2_PARAM_IN);
db2_bind_param($stmt,  31, "SELECT", DB2_PARAM_INOUT);
db2_bind_param($stmt,  32, "FSLOT", DB2_PARAM_IN);
db2_bind_param($stmt,  33, "TSLOT", DB2_PARAM_IN);
db2_bind_param($stmt,  34, "NEWDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  35, "TAGDATE", DB2_PARAM_IN);
db2_bind_param($stmt,  36, "WEEKS", DB2_PARAM_IN);
db2_bind_param($stmt,  37, "TAGS", DB2_PARAM_INOUT);
db2_bind_param($stmt,  38, "TAGSET", DB2_PARAM_INOUT);
db2_bind_param($stmt,  39, "CHANGES", DB2_PARAM_INOUT);
db2_bind_param($stmt,  40, "KEY", DB2_PARAM_INOUT);
db2_bind_param($stmt,  41, "GLIST", DB2_PARAM_INOUT);
db2_bind_param($stmt,  42, "FRSEQ", DB2_PARAM_INOUT);
db2_bind_param($stmt,  43, "TOSEQ", DB2_PARAM_INOUT);
db2_bind_param($stmt,  44, "ERROR", DB2_PARAM_INOUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

// load the array for later processing
$table1 = array();  // Price Matrix
$table2 = array();  // Tag Set Name
$table3 = array();  // Sort Sequence
$table4 = array();  // Bar Code Format
$table5 = array();  // Output Queues
$cnt1 = 0; 
$cnt2 = 0;
$cnt3 = 0;
$cnt4 = 0;
$cnt5 = 0;
while ($row = db2_fetch_array($stmt)){
	if(trim($row[0]) == 'a'):
		$cnt1 += 1;
		$table1[$cnt1]['whsno'] = $row[1]; 
		$table1[$cnt1]['matrix'] = $row[2]; 
		$table1[$cnt1]['matseq'] = $row[3]; 
		$table1[$cnt1]['custno'] = $row[4];
		$table1[$cnt1]['cusloc'] = $row[5];
		$table1[$cnt1]['prccod'] = $row[6];  
		$table1[$cnt1]['srpcod'] = $row[7]; 
		$table1[$cnt1]['shpst'] = $row[8]; 
	elseif(trim($row[0]) == 'b'): 
		$cnt2 += 1;
		$table2[$cnt2]['whsno'] = $row[1]; 
		$table2[$cnt2]['matrix'] = $row[2]; 
		$table2[$cnt2]['custno'] = $row[4];
		$table2[$cnt2]['cusloc'] = $row[5];
		$table2[$cnt2]['hdrdsc'] = $row[9];  
		$table2[$cnt2]['utjob'] = $row[10]; 
	elseif(trim($row[0]) == 'c'): 
		$cnt3 += 1;
		$table3[$cnt3]['cdcode'] = $row[11];  
		$table3[$cnt3]['cddesc'] = $row[12];  
	elseif(trim($row[0]) == 'd'): 
		$cnt4 += 1;
		$table4[$cnt4]['cdcode'] = $row[11];  
		$table4[$cnt4]['cddesc'] = $row[12];  
	elseif(trim($row[0]) == 'e'): 
		$cnt5 += 1;
		$table5[$cnt5]['whsno'] = $row[1];  
		$table5[$cnt5]['outq'] = $row[13];  
		$table5[$cnt5]['desc'] = $row[14]; 
	endif;
}

db2_free_result($stmt);
db2_free_stmt($stmt); 

//print_r($table1);

}
/********************************************************************************* 
* Load/Process Multiple Facing web page
**********************************************************************************/	
function LoadTable2 (){
	
// Include ALL global variables 
eval(globals());
	
// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB247 (?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "GLIST", DB2_PARAM_IN);
db2_bind_param($stmt,  5, "FRSEQ", DB2_PARAM_IN);
db2_bind_param($stmt,  6, "TOSEQ", DB2_PARAM_IN);
db2_bind_param($stmt,  7, "TASK", DB2_PARAM_IN);
db2_bind_param($stmt,  8, "SHPNAM", DB2_PARAM_OUT);
db2_bind_param($stmt,  9, "LISTKEY", DB2_PARAM_IN);
db2_bind_param($stmt, 10, "KEY", DB2_PARAM_OUT);
db2_bind_param($stmt, 11, "SOURCE", DB2_PARAM_IN);


// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

// load the array for later processing
$table6 = array();  
$cnt6 = 0; 

while ($row = db2_fetch_array($stmt)){
	if(trim($row[0]) == 'a'):
		$cnt6 += 1;
		$table6[$cnt6]['itemno'] = $row[1]; 
		$table6[$cnt6]['pack'] = $row[2]; 
		$table6[$cnt6]['size'] = $row[3]; 
		$table6[$cnt6]['descpt'] = $row[4];
	endif;
}

db2_free_result($stmt);
db2_free_stmt($stmt); 

//print_r($table6);
//echo 'count:'.$cnt6;

}

/********************************************************************************* 
* Load Item Inquiry Reporting tables.
**********************************************************************************/	
function testchanges (){
	
// Include ALL global variables  
eval(globals());

// open connection
$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB246 (?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "WHSE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "LOCN", DB2_PARAM_IN);
db2_bind_param($stmt,  5, "ERROR", DB2_PARAM_OUT);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

db2_free_result($stmt);
db2_free_stmt($stmt); 

}

?>