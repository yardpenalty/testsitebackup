
<?php 
/**********************************************************************
* Description:	modal to display Customer's Rounding Method.
*							
* Author:				Bob Ek
* Date:					12/21/2015
***********************************************************************
* Modification Log:
* Date		Init	Description
* ------	----	-----------------------------------------------------
*  
*************************************************************************/
// define variables for this script
$table1 = array ();  // loaded with results from RPG program
$DCUST = '';
$PATH_INSTANCE = '';


// Include standard PHP top script logic

include 'PHPTopv01.inc'; // Must always include

// Load the table 
LoadTable1($table1);

echo '
<table class="table table-condensed table-hover">
	<thead>
		<tr>
			<th>Retail Ends With Character</th>
			<th>0</th>
			<th>1</th>
			<th>2</th>
			<th>3</th>
			<th>4</th>
			<th>5</th>
			<th>6</th>
			<th>7</th>
			<th>8</th>
			<th>9</th>
		</tr>
	</thead>
	<tbody>';
	$counter = 0;
	foreach ($table1 as  $t1) {
		$counter += 1;
		echo'
		<tr>';
			if (trim($t1['rec']) == '0')	echo '<td>Replace With</td>';
			else echo '<td>Add/Subtract</td>';
			echo '
			<td>'.trim($t1['a0']).'</td>
			<td>'.trim($t1['a1']).'</td>
			<td>'.trim($t1['a2']).'</td>
			<td>'.trim($t1['a3']).'</td>
			<td>'.trim($t1['a4']).'</td>
			<td>'.trim($t1['a5']).'</td>
			<td>'.trim($t1['a6']).'</td>
			<td>'.trim($t1['a7']).'</td>
			<td>'.trim($t1['a8']).'</td>
			<td>'.trim($t1['a9']).'</td>		
		</tr>';
	}
	echo'
	</tbody>
</table>';
if ($counter == 0) echo '<b>Unable to load Rounding Methods...</b>';

/********************************************************************************* 
* Load Item Inquiry Reporting tables.
**********************************************************************************/	
function LoadTable1 (&$table1,$DCUST,$DLOCN){
	// Include ALL global variables 
eval(globals());
// Set the web user to the session variable
//if(isset($_SESSION['userid'])) $USER = $_SESSION['userid'];
//else $USER = '';
// open connection
$connection = db2_pconnect('','','') or die("Connection Failed ".db2_conn_errormsg());
// prepare the program call
$stmt = db2_prepare($connection, "CALL HTHOBJ.WEB044L5 (?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());

// define all parmeters
db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
db2_bind_param($stmt,  3, "WHSE", DB2_PARAM_IN);
db2_bind_param($stmt,  4, "LOCN", DB2_PARAM_IN);

// Execute the call to the program
db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());

// load the array for later processingm
//$table1 = array();
$cnt1 = 0;
 
while ($row = db2_fetch_array($stmt)){
	$cnt1 += 1;
	$table1[$cnt1]['rec'] = $row[0]; 
	$table1[$cnt1]['a0'] = $row[1]; 
	$table1[$cnt1]['a1'] = $row[2];
	$table1[$cnt1]['a2'] = $row[3]; 
	$table1[$cnt1]['a3'] = $row[4];
	$table1[$cnt1]['a4'] = $row[5]; 
	$table1[$cnt1]['a5'] = $row[6];
	$table1[$cnt1]['a6'] = $row[7]; 
	$table1[$cnt1]['a7'] = $row[8]; 
	$table1[$cnt1]['a8'] = $row[9]; 	
	$table1[$cnt1]['a9'] = $row[10]; 		
}

db2_free_result($stmt);
db2_free_stmt($stmt); 
//print_r($table1);
}

?>