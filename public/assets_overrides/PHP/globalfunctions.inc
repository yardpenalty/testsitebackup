<?php
/************************************************************************************************************
 * Check for web page authority
 ***********************************************************************************************************/
function authority() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBR002V03 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "AUTHCD", DB2_PARAM_OUT);
	db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
	db2_bind_param($stmt,  4, "PAGEID", DB2_PARAM_IN);
	db2_bind_param($stmt,  5, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  6, "LOCKOUT", DB2_PARAM_OUT);
	db2_bind_param($stmt,  7, "MNUTXT", DB2_PARAM_OUT);
	db2_bind_param($stmt,  8, "PULLWHS", DB2_PARAM_OUT);
	db2_bind_param($stmt,  9, "PULLCST", DB2_PARAM_OUT);
	db2_bind_param($stmt, 10, "PULLLOC", DB2_PARAM_OUT);
	db2_bind_param($stmt, 11, "PULLSLS", DB2_PARAM_OUT);
	db2_bind_param($stmt, 12, "PULLVND", DB2_PARAM_OUT);
	db2_bind_param($stmt, 13, "SALESBREAK", DB2_PARAM_OUT);
	db2_bind_param($stmt, 14, "AUTH", DB2_PARAM_OUT);
	db2_bind_param($stmt, 15, "EXPIRED", DB2_PARAM_OUT);
	db2_bind_param($stmt, 16, "WHSCONTROL", DB2_PARAM_OUT);
	db2_bind_param($stmt, 17, "EXCDELETED", DB2_PARAM_INOUT);
	db2_bind_param($stmt, 18, "CHAINSORT", DB2_PARAM_INOUT);
	db2_bind_param($stmt, 19, "LOCATIONSORT", DB2_PARAM_INOUT);
	db2_bind_param($stmt, 20, "VENDORSORT", DB2_PARAM_INOUT);
	db2_bind_param($stmt, 21, "LIGHT", DB2_PARAM_OUT);
	db2_bind_param($stmt, 22, "LIGHTLETTER", DB2_PARAM_OUT);
	db2_bind_param($stmt, 23, "LIGHTLETTERALT", DB2_PARAM_OUT);
	db2_bind_param($stmt, 24, "DARK", DB2_PARAM_OUT);
	db2_bind_param($stmt, 25, "DARKLETTER", DB2_PARAM_OUT);
	db2_bind_param($stmt, 26, "DARKLETTERALT", DB2_PARAM_OUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt); 

}

/*********************************************************************
 * Load TBL_SELECTIONS - Selection list w/ descriptions.
 ********************************************************************/

function dispselections($l_temp1, $l_temp2, $l_temp3, $l_loadtype) {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_connect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB151V04 (?,?,?,?,?,?,?,?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 2, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 3, "SQLSTMT", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 4, "l_temp1", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 5, "SOURCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 6, "l_temp2", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 7, "WHSE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 8, "AUTHWHSE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 9, "GLIST", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 10, "l_temp3", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 11, "l_loadtype", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 12, "GTEXT", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 13, "ERROR", DB2_PARAM_OUT );
	$loadtype = 'P';
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	echo '<h3 style="margin-top: 0; margin-bottom: 0">';
	// Display the selection list 
	if ($SOURCE == "00") :
		echo 'Individual Item(s) selected:';
	 elseif ($SOURCE == "01") :
		echo 'Standard Invoice Category(s) selected:';
	 elseif ($SOURCE == "02") :
		echo 'Product Category(s) selected:';
	 elseif ($SOURCE == "03") :
		echo 'Major Product Category(s) selected:';
	 elseif ($SOURCE == "04") :
		echo 'Cigarette Brand(s) selected:';
	 elseif ($SOURCE == "05") :
		echo 'for Manufacturer(s):';
	 elseif ($SOURCE == "06") :
		echo 'Custom Invoice Category(s) selected:';
	 elseif ($SOURCE == "S7") :
		echo 'Standard Order Book Header(s) selected:';
	 elseif ($SOURCE == "IG") :
		echo 'Item Grouping(s) selected:';
	endif;
	
	echo '<br>';
	
	$count = 0;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		$count += 1;
		if (trim ( $row [0] ) == "*ALL") :
			echo trim ( $row [1] );
		 else :
			if ($SOURCE == "S7" || $SOURCE == "IG") :
				echo trim ( $row [1] );
			 else :
				echo trim ( $row [0] );
				if ($SOURCE != "04") :
					echo ' - ';
					if (trim ( $row [1] ) == "")
						echo '** Description not found **';
					else
						echo trim ( $row [1] );
				
			endif;
			endif;
		endif;
		echo '<br>';
	}
	// free resources
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );
	
	if ($count == 0) :
		echo '<strong>No ';
		if ($SOURCE == "01")
			echo 'Standard Invoice Categories';
		elseif ($SOURCE == "02")
			echo 'Product Categories';
		elseif ($SOURCE == "03")
			echo 'Major Product Categories';
		elseif ($SOURCE == "04")
			echo 'Cigarette Brands';
		elseif ($SOURCE == "05")
			echo 'Manufacturers';
		elseif ($SOURCE == "06")
			echo 'Custom Invoice Categories';
		elseif ($SOURCE == "S7")
			echo 'Standard Order Book Headers';
		elseif ($SOURCE == "IG")
			echo 'Item Groupings';
		echo ' exist. Please make new selection.</strong>';
	
endif;
	echo '<br></h3>';

}

/*******************************************************************
 * Retrieve the "From" and "To" dates for the display              *
 ********************************************************************/

function RtvDates() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	/// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB069V02 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "BEGDATE", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  3, "ENDDATE", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  4, "REQ", DB2_PARAM_IN);
	db2_bind_param($stmt,  5, "FORMAT", DB2_PARAM_IN);
	db2_bind_param($stmt,  6, "BEGWB", DB2_PARAM_OUT);
	db2_bind_param($stmt,  7, "BEGWE", DB2_PARAM_OUT);
	db2_bind_param($stmt,  8, "BEGYEAR", DB2_PARAM_OUT);
	db2_bind_param($stmt,  9, "BEGMONTH", DB2_PARAM_OUT);
	db2_bind_param($stmt, 10, "BEGWEEK", DB2_PARAM_OUT);
	db2_bind_param($stmt, 11, "BEGQTR", DB2_PARAM_OUT);
	db2_bind_param($stmt, 12, "ENDWB", DB2_PARAM_OUT);
	db2_bind_param($stmt, 13, "ENDWE", DB2_PARAM_OUT);
	db2_bind_param($stmt, 14, "ENDYEAR", DB2_PARAM_OUT);
	db2_bind_param($stmt, 15, "ENDMONTH", DB2_PARAM_OUT);
	db2_bind_param($stmt, 16, "ENDWEEK", DB2_PARAM_OUT);
	db2_bind_param($stmt, 17, "ENDQTR", DB2_PARAM_OUT);
	db2_bind_param($stmt, 18, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt, 19, "ERROR", DB2_PARAM_OUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt); 

}

/***********************************************************************************************************
 * Validate/Load warehouse, customer, and location fields. TESTED on 5/4/11
 ***********************************************************************************************************/
function Customer() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_connect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB014V03 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "WHSALL", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 2, "WHSTOT", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 3, "WHSST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 4, "WHSFST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 5, "CSTALL", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 6, "CSTTOT", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 7, "CSTST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 8, "CSTFST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 9, "LOCALL", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 10, "LOCTOT", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 11, "LOCST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 12, "LOCFST", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 13, "TYPEWHS", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 14, "TYPECST", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 15, "TYPELOC", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 16, "LOADTBLS", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 17, "LOADSQL", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 18, "PREP4", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 19, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 20, "WHSE", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 21, "CUST", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 22, "LOCN", DB2_PARAM_INOUT );
	db2_bind_param ( $stmt, 23, "PREP4FMT", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 24, "SQLSTMT", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 25, "AUTHWHSE", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 26, "WHSONLY", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 27, "FUNCTIONCODE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 28, "LOADTYPE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 29, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 30, "ERROR", DB2_PARAM_INOUT );
	
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	// Load the warehouse, customer, and location pull-down arrays
	//   1. warehouse array
	//   2. location array
	//   3. customer array 
	$cnt = 0;
	$wcnt = - 1;
	$ccnt = - 1;
	$lcnt = - 1;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		$cnt += 1;
		if ($cnt >= $WHSST && $cnt < $LOCST) :
			$wcnt += 1;
			$whse [$wcnt] ['Column1'] = $row [0];
			$whse [$wcnt] ['Column2'] = $row [1];
			$whse [$wcnt] ['Column3'] = $row [2];
			$whse [$wcnt] ['Column4'] = $row [3];
		 elseif ($cnt >= $LOCST && $cnt < $CSTST) :
			$lcnt += 1;
			$locn [$lcnt] ['Column1'] = $row [0];
			$locn [$lcnt] ['Column2'] = $row [1];
			$locn [$lcnt] ['Column3'] = $row [2];
			$locn [$lcnt] ['Column4'] = $row [3];
			$locn [$lcnt] ['Column5'] = $row [4];
		 else :
			$ccnt += 1;
			$cust [$ccnt] ['Column1'] = $row [0];
			$cust [$ccnt] ['Column2'] = $row [1];
			$cust [$ccnt] ['Column3'] = $row [2];
			$cust [$ccnt] ['Column4'] = $row [3];
		endif;
	}
	
	// free resources
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );

}

/*************************************************************************************************************
 * Load customer and salesman Pull Down selections.
 ************************************************************************************************************/
function pulldowns() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// How many Selections do we have? 
	include "custpulls.inc";
	echo '<br><center>';
	
	//Maintain authorization button
	if (($AUTHCD == "H" && $WHSCONTROL == "Y") || $AUTHCD == "S") :
		if (trim ( $QUERY_STRING ) != "") :
			$MACRO = 'Security.mac/Customer?USERLIST=' . $USER . '&l_submit=Authorize%20Customers%20for%20User&ORIG=' . urlencode ( trim ( $PHPSCRIPT ) ) . '?' . trim ( $QUERY_STRING ) . '&SECURE=Y';
			echo '<input type="button" name="l_submit" value="Maintain Authorizations" Style="font:7pt" onClick="location.href=\'' . str_replace ( "^holymacro", $MACRO, $FULLURLMAC ) . '\';">';
		 else :
			$MACRO = 'Security.mac/Customer?USERLIST=' . $USER . '&l_submit=Authorize%20Customers%20for%20User&ORIG=' . urlencode ( trim ( $PHPSCRIPT ) ) . '&SECURE=Y';
			echo '<input type="button" name="l_submit" value="Maintain Authorizations" Style="font:7pt" onClick="location.href=\'' . str_replace ( "^holymacro", $MACRO, $FULLURLMAC ) . '\';">';
		endif;
	
endif;
	//Clean out parms from COMPLETE_URL
	$l_pos = strpos ( $COMPLETE_URL, "EXCDELETED=Y" );
	if (trim ( $l_pos ) == "")
		$l_pos = strpos ( $COMPLETE_URL, "EXCDELETED=N" );
	if ($l_pos > 0) :
		$l_pos -= 2;
		$COMPLETE_URL = substr ( $COMPLETE_URL, 0, $l_pos + 1 ) . substr ( $COMPLETE_URL, $l_pos + 15 );
	
endif;
	
	$l_pos = strpos ( $COMPLETE_URL, "CHAINSORT=U" );
	if (trim ( $l_pos ) == "")
		$l_pos = strpos ( $COMPLETE_URL, "CHAINSORT=N" );
	if ($l_pos > 0) :
		$l_pos -= 2;
		$COMPLETE_URL = substr ( $COMPLETE_URL, 0, $l_pos + 1 ) . substr ( $COMPLETE_URL, $l_pos + 14 );
	
endif;
	
	$l_pos = strpos ( $COMPLETE_URL, "LOCATIONSORT=U" );
	if (trim ( $l_pos ) == "")
		$l_pos = strpos ( $COMPLETE_URL, "LOCATIONSORT=N" );
	if ($l_pos > 0) :
		$l_pos -= 2;
		$COMPLETE_URL = substr ( $COMPLETE_URL, 0, $l_pos + 1 ) . substr ( $COMPLETE_URL, $l_pos + 17 );
	
endif;
	
	$l_pos = strpos ( $COMPLETE_URL, "VENDORSORT=U" );
	if (! $l_pos)
		$l_pos = strpos ( $COMPLETE_URL, "VENDORSORT=N" );
	if ($l_pos > 0) :
		$l_pos -= 2;
		$COMPLETE_URL = substr ( $COMPLETE_URL, 0, $l_pos + 1 ) . substr ( $COMPLETE_URL, $l_pos + 15 );
	
endif;
	
	//Include/Exclude buttons
	$l_pos = strpos ( $COMPLETE_URL, "?" );
	if ($l_pos > 0) :
		if (trim ( substr ( $COMPLETE_URL, $l_pos + 1 ) ) == "")
			$l_parm = "EXCDELETED=";
		else
			$l_parm = "&EXCDELETED=";
	 else :
		$l_parm = "?EXCDELETED=";
	endif;
	if ($l_location == "Y" || $l_chain == "Y") :
		if (trim ( $EXCDELETED ) == "Y")
			echo '<input type="button" value="Include Deleted Locations" Style="font:7pt" onClick="location.href=\'' . trim ( $COMPLETE_URL ) . trim ( $l_parm ) . 'N\'; align="center">';
		else
			echo '<input type="button" value="Exclude Deleted Locations" Style="font:7pt" onClick="location.href=\'' . trim ( $COMPLETE_URL ) . trim ( $l_parm ) . 'Y\';" align="center">';
	
endif;
	
	echo '</center>';
	
	if ($l_warehouse == "Y" || ($WHSONLY == "Y" && $WHSCONTROL == "Y")) :
	 else :
		echo '<INPUT TYPE=HIDDEN NAME=WHSE VALUE=';
		if ($PULLWHS != "N") :
			if (trim ( $WHSE ) != "")
				echo $WHSE;
			elseif (trim ( $WHSFST ) != "")
				echo $WHSFST;
			else
				echo '""';
		 else :
			echo '""';
		endif;
		echo '>';
	endif;
	
	$skip_chain = "N";
	if ($l_location != "Y") :
		echo '<INPUT TYPE=HIDDEN NAME=LOCN VALUE=';
		if ($PULLLOC != "N") :
			if (trim ( $LOCN ) != "") :
				$skip_chain = "Y";
				echo $LOCN;
			 elseif (trim ( $LOCFST ) != "") :
				$skip_chain = "Y";
				echo $LOCFST;
			 else :
				echo '""';
			endif;
		 else :
			echo '""';
		endif;
		echo '>';
	
endif;
	
	if ($LOCTOT > "0"):
		$l_disploc = trim ( $locn [$LOCALL - $LOCTOT] ['Column2'] ) . '&nbsp;(';
		if (trim ( $locn [$LOCALL - $LOCTOT]  ['Column5'] ) != "") 
			$l_disploc .= substr ( trim ( $locn [$LOCALL - $LOCTOT]  ['Column5'] ), 0, 6 ) . '-' . trim ( substr ( $locn [$LOCALL - $LOCTOT]  ['Column5'], 6, 5 )). ')';
		else
			$l_disploc .+ substr ( trim ( $locn [$LOCALL - $LOCTOT]  ['Column1'] ), 0, 6 ) . '-' . substr ( trim ( $locn [$LOCALL - $LOCTOT]  ['Column1'] ), 6, 3 ). ')';
		 //echo substr ( trim ( $locn [$LOCALL - $LOCTOT] ['Column1'] ), 0, 6 ) . '-' . substr ( trim ( $locn [$LOCALL - $LOCTOT] ['Column1'] ), 6, 3 ) . ')';
	endif;
	if ($l_chain != "Y") :
		echo '<INPUT TYPE=HIDDEN NAME=CUST VALUE=';
		if ($PULLCST != "N" && $skip_chain == "N") :
			if (trim ( $CUST ) != "") :
				echo trim ( $CUST );
			 elseif (trim ( $CSTFST ) != "") :
				echo trim ( $CSTFST );
			 else :
				echo '""';
			endif;
		 else :
			echo '""';
		endif;
		echo '>';
	
endif;
	
	//If at least one pull-down is being used then create the pull-down table	
	if ($NUMPULLS > "0") :
		
		echo '<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">' . '<tr>' . '<td>' . '<table border="0" cellpadding="0" cellspacing="0" width="5%" align="center">' . '<tr>';
		
		/*-------------------------------------------------------------------------------------------------------			
 * Process the Warehouse Table 
 *---------------------------------------------------------------------------------------------------*/
		if ($l_warehouse == "Y" || ($WHSONLY == "Y" && $WHSCONTROL == "Y")) :
			echo '<td align="center" width="2%" valign="top">' . '<b><font color="' . $DARK . '">Warehouse</font></b><br>' . '<font size="-2" color="' . $DARK . '">(Sorted By Number)</font><br>' . '<select';
			if (trim ( $TYPEWHS ) != "1")
				echo ' multiple ';
			echo ' size="4" name="WHSE"';
			if ($NUMPULLS == "3")
				echo 'style="font-size:9pt"';
			echo '>';
			
			foreach ( $whse as $v1 ) {
				echo '<option VALUE="' . trim ( $v1 ['Column1'] ) . '"';
				if (trim ( $v1 ['Column4'] ) == "S")
					echo ' Selected ';
				echo '>' . trim ( $v1 ['Column3'] ) . '</option>';
			}
			echo '</select>' . '</td>';
		
					endif;
		
		/*-------------------------------------------------------------------------------------------------------			
 * Process the Chain Table 
--------------------------------------------------------------------------------------------------------*/
		if ($l_chain == "Y") :
			if ($NUMPULLS > "1") :
				echo '<td width="20px">' . '&nbsp;&nbsp;&nbsp;' . '</td>';
			
						endif;
			
			echo '<td align="center" width="2%" valign="top">' . '<b><font color="' . $DARK . '">Chain</font></b><br>' . '<font size="-2" color="' . $DARK . '">';
			
			if ($CHAINSORT != "U")
				echo '(Sorted By Name)';
			else
				echo '(Sorted By Number)';
			echo '</font>' . '<br>' . '<select multiple size="4" name="CUST"';
			if ($NUMPULLS == "3")
				echo 'style="font-size:9pt"';
			echo '>';
			foreach ( $cust as $v1 ) {
				echo '<option VALUE="' . trim ( $v1 ['Column1'] ) . '"';
				if (trim ( $v1 ['Column4'] ) == "S")
					echo ' Selected ';
				echo '>';
				if ($CHAINSORT != "U") :
					echo trim ( $v1 ['Column3'] );
					if (substr ( trim ( $v1 ['Column1'] ), 0, 1 ) != "*") :
						echo '&nbsp;(' . $v1 ['Column1'] . ')';
										
										endif;
				 else :
					if (substr ( trim ( $v1 ['Column1'] ), 0, 1 ) != "*") :
						echo trim ( $v1 ['Column1'] );
						echo '&nbsp;(' . trim ( $v1 ['Column3'] ) . ')';
					 else :
						echo trim ( $v1 ['Column3'] );
					endif;
				

				endif;
				
				echo '</option>';
			}
			echo '</select><br>';
			
			$l_pos = strpos ( $COMPLETE_URL, "?" );
			if ($l_pos > 0) :
				if (trim ( substr ( $COMPLETE_URL, $l_pos + 1 ) ) == "") :
					$l_parm = "CHAINSORT=";
				 else :
					$l_parm = "&CHAINSORT=";
				endif;
			 else :
				$l_parm = "?CHAINSORT=";
			endif;
			if (trim ( $CHAINSORT ) == "U") :
				echo '<input type="button" value="Sort By Name" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'N\';">';
			 else :
				echo '<input type="button" value="Sort By Number" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'U\';">';
			endif;
			echo '<br>    ' . '</td>';
		
					endif;
		
		/*------------------------------------------------------------------------------------------------------			
 * Process the Location Table 
-------------------------------------------------------------------------------------------------------*/
		
		if ($l_location == "Y") :
			if ($NUMPULLS > "1") :
				echo '<td width="20px">' . '&nbsp;&nbsp;&nbsp;' . '</td>';
			
						endif;
			echo '<td align="center" width="1%" valign="top">' . '<b><font color="' . $DARK . '">Location</font></b><br>' . '<font size="-2" color="' . $DARK . '">';
			if ($LOCATIONSORT != "U")
				echo '(Sorted By Name)';
			else
				echo '(Sorted By Number)';
			echo '</font><br>' . '<select';
			if (trim ( $TYPELOC ) == "")
				echo ' multiple ';
			echo ' size="4" name="LOCN"';
			if ($NUMPULLS == "3")
				echo 'style="font-size:9pt"';
			echo '>';
			$index = 0;
			foreach ( $locn as $v1 ) {
				$index += 1;
				if ($LOCTOT == "3" && trim ( $v1 ['Column1'] ) == "*ALL") :
				 else :
					if (trim ( $v1 ['Column1'] ) == "*NONE") :
						$l_none = "Y";
					
										endif;
					echo '<option VALUE="' . trim ( $v1 ['Column1'] ) . '"';
					if (trim ( $v1 ['Column4'] ) == "S" || trim ( $LOCN ) == "" && $index == 2 && trim ( $l_none ) == "" && (trim ( $TYPELOC ) != "1" && trim ( $TYPELOC ) != "2") || @trim ( $LOCN ) == "" && $index == 1 && (trim ( $TYPELOC ) == "1" || trim ( $TYPELOC ) == "2")) :
						echo ' Selected ';
					
										endif;
					echo '>';
					if ($LOCATIONSORT != "U") :
						echo trim ( $v1 ['Column2'] );
						if (substr ( trim ( $v1 ['Column1'] ), 0, 1 ) != "*") :
							if (trim ( $v1 ['Column5'] ) != "") 
								echo '&nbsp;('.substr ( trim ( $v1 ['Column5'] ), 0, 6 ) . '-' . trim ( substr ( $v1 ['Column5'], 6, 5 )). ')';
							else
								echo '&nbsp;('.substr ( trim ( $v1 ['Column1'] ), 0, 6 ) . '-' . substr ( trim ( $v1 ['Column1'] ), 6, 3 ). ')';
						endif;
					 else :
						if (substr ( trim ( $v1 ['Column1'] ), 0, 1 ) != "*") :
							if (trim ( $v1 ['Column5'] ) != "") 
								echo substr ( trim ( $v1 ['Column5'] ), 0, 6 ) . '-' . trim ( substr ( $v1 ['Column5'], 6, 5 ));
							else
								echo substr ( trim ( $v1 ['Column1'] ), 0, 6 ) . '-' . substr ( trim ( $v1 ['Column1'] ), 6, 3 );
							echo '&nbsp;(' . trim ( $v1 ['Column2'] ) . ')';
						 else :
							echo trim ( $v1 ['Column2'] );
						endif;
					

					endif;
					echo '</option>';
				endif;
			}
			echo '</select><br>';
			
			$l_pos = strpos ( $COMPLETE_URL, "?" );
			if ($l_pos > 0) :
				if (trim ( substr ( $COMPLETE_URL, $l_pos + 1 ) ) == "") :
					$l_parm = "LOCATIONSORT=";
				 else :
					$l_parm = "&LOCATIONSORT=";
				endif;
			 else :
				$l_parm = "?LOCATIONSORT=";
			endif;
			if (trim ( $LOCATIONSORT ) == "U") :
				echo '<input type="button" value="Sort By Name" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'N\';">';
			 else :
				echo '<input type="button" value="Sort By Number" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'U\';">';
			endif;
			echo '<br>' . '</td>';
		
					endif;
		/*-------------------------------------------------------------------------------------------------------			
 * Process the Vendor Table 
--------------------------------------------------------------------------------------------------------*/
		if ($l_vendor == "Y") :
			if ($NUMPULLS > "1") :
				echo '<td width="20px">' . '&nbsp;&nbsp;&nbsp;' . '</td>';
			
						endif;
			echo '<td align="center" width="2%" valign="top">' . '<b><font color="' . $DARK . '">Corporate Vendor</font></b><br>' . '<font size="-2" color="' . $DARK . '">';
			if ($VENDORSORT != "U") :
				echo '(Sorted By Name)';
			 else :
				echo '(Sorted By Number)';
			endif;
			echo '</font>' . '<select size="4" name="VEND"';
			if (trim ( $TYPEVEND ) == "")
				echo ' multiple ';
			if ($NUMPULLS == "3")
				echo 'style="font-size:9pt"' . '>';
			
			foreach ( $vend as $v1 ) {
				echo '<option VALUE="' . trim ( $v1 ['Column1'] ) . '"';
				if (trim ( $v1 ['Column4'] ) == "S")
					echo ' Selected ';
				echo '>' . trim ( $v1 ['Column3'] ) . '</option>';
			}
			echo '</select>' . 

			'<font size="-2">Underlines in vendor # represent blanks</font><br>';
			$l_pos = strpos ( $COMPLETE_URL, "?" );
			if ($l_pos > 0) :
				if (trim ( substr ( COMPLETE_URL, $l_pos + 1 ) ) == "") :
					$l_parm = "VENDORSORT=";
				 else :
					$l_parm = "&VENDORSORT=";
				endif;
			 else :
				$l_parm = "?VENDORSORT=";
			endif;
			if (trim ( $VENDORSORT ) == "U") :
				echo '<input type="button" value="Sort By Name" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'N\';">';
			 else :
				echo '<input type="button" value="Sort By Number" Style="font:7pt" onClick="location.href=\'' . $COMPLETE_URL . trim ( $l_parm ) . 'U\';">';
			endif;
			echo '<br>' . '</td>';
		
					endif;
		echo '</tr>' . '</table>' . '</td>' . '</tr>' . '</table>';
		
		if ($WHSCONTROL == "Y" && $WHSONLY == "Y" && $l_warehouse == "Y" && trim ( $TYPELOC ) != "1")
			echo '<font size ="1" color="' . $DARK . '"><b>Hackney Associates can select a Warehouse without a Chain or Location</b></font>';
	 
endif;
	
	// Display the location if web user only has one attached %}
	if ($l_location != "Y" && $l_chain != "Y" && $PULLLOC != "N" && trim ( $l_disploc ) != "")
		echo '<br><center><b><font color="' . $DARK . '">Customer:</font></b>&nbsp;' . $l_disploc . '</center><br><br>';
		/*-------------------------------------------------------------------------------------------------------			
 * Add Direct Customer and Salesman - Hackney Associate or Security Officer user
--------------------------------------------------------------------------------------------------------*/
	if (($AUTHCD == "H" || $AUTHCD == "S") && $WHSCONTROL == "Y") :
		?>
<br>
<table border="0" align="center">
	<tr>
		<th align="center"><font color="<?
		echo $DARK?>"> Direct Customer
		Entry </font></th>
			<?
		if ($SLSTOT != "0") :
			?>
				<th width="1">&nbsp;</th>
		<th align="center"><font color="<?
			echo $DARK?>"> Sales Associate </font>
		</th>
			
		<?endif?>
		</tr>
	<tr>
		<td>
				<? // Direct Customer Entry		?>
				<table border="0" align="center">
			<tr>
				<td align="center" valign="top"><font size="-1"
					color="<?
		echo $DARK?>"><b>Customer</b></font> <input type="Text"
					name="DCUST" size="6" maxlength="6" value="<?
		echo $DCUST?>"
					class="fill"> <font size="-1" color="<?
		echo $DARK?>"><b>Location</b></font>
				<input type="Text" name="DLOCN" size="3" maxlength="3"
					value="<?
		echo $DLOCN?>" class="fill"></td>
			</tr>

			<tr valign="top">
				<td align="center"><font size="-3" color="<?
		echo $DARK?>"><b>(Override
				above selections)</b></font></td>
			</tr>
			<tr>
				<td align="center" valign="top"><input type="submit"
					value="Customer Retrieval" name="SUBMIT_BUTTON" Style="font: 7pt"
					onClick="document.form.l_button.value='Customer Retrieval';"></td>
			</tr>

		</table>
		</td>
			<?
		if ($SLSTOT != "0") :
			?>
				<td>&nbsp;</td>
		<td align="center">
		<table border="0" align="center">
			<tr>
				<td align="center"><select multiple size="4" name="SALES">
<?php
			
			foreach ( $sls as $v1 ) {
				echo '<option VALUE="' . trim ( $v1 ['Column1'] ) . trim ( $v1 ['Column2'] ) . '"';
				if (trim ( $v1 ['Column4'] ) == "S")
					echo ' Selected ';
				echo '>' . trim ( $v1 ['Column3'] );
				if (trim ( $v1 ['Column2'] ) != "*NONE" && trim ( $v1 ['Column4'] ) != "*ALL")
					echo '&nbsp;(';
				echo trim ( $v1 ['Column1'] );
				if (trim ( $v1 ['Column2'] ) != "" && trim ( $v1 ['Column2'] ) != "*NONE" && trim ( $v1 ['Column2'] ) != "*ALL")
					echo '-&nbsp;' . trim ( $v1 ['Column2'] );
				if (trim ( $v1 ['Column2'] ) != "*NONE" && trim ( $v1 ['Column2'] ) != "*ALL")
					echo ')';
				echo '</option>';
			}
			echo '</select>' . 

			'</td>';
			if ($SALESBREAK == "Y") :
				echo '<tr><td align="center"><input type="checkbox" name="SBREAK" Value="Y"';
				if ($SBREAK == "Y")
					echo 'checked';
				echo '>' . '<font color="' . $DARK . '" size="-1"><b> Break by Sales Associate </b></font>' . '</td></tr>';
			
					endif;
			echo '</table>' . '</td>';
		
			endif;
		echo '</tr>' . '</table>';
	
endif;
}

/***********************************************************************************************************
 * Load the Direct Customer Entry with returned values if supplied
 *****************************************************************************************************t*****/
function directcustload() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	if (trim ( $LOCNSELECTION ) != "") :
		$DCUST = substr ( $LOCNSELECTION, 3, 6 );
		$DLOCN = substr ( $LOCNSELECTION, 9, 3 );
		$CUST = "";
		$LOCN = "";
		$SALES = "";
		$SBREAK = "";
	 elseif (trim ( $DCUST ) != "") :
		$CUST = "";
		$LOCN = "";
		$SALES = "";
		$SBREAK = "";
	endif;
}

/***********************************************************************************************************
 * Direct Customer edit.
 *****************************************************************************************************t*****/
function DCustEdit() {
	
	// Include ALL global variables 
	eval ( globals () );
	if (trim($DCUST) != ""):
		if (trim($DLOCN) != ""):
			$CUST = '*NONE';
				if (strlen(trim($DLOCN)) == 1):
					$DLOCN = '00'. trim($DLOCN);
				elseif (strlen(trim($DLOCN)) == 2):
					$DLOCN = '0'. trim($DLOCN);
				endif;
			$LOCN = $DCUST.$DLOCN;
		else:
			$CUST = $DCUST;
			$LOCN = '*NONE';
		endif;
	endif;
	if (trim($USER) == 'bobe') echo 'CUST'.$CUST.'LOCN'.$LOCN;
	// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB081 (?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "WHSE", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  3, "CUST", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  4, "LOCN", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  5, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  6, "ERRORD", DB2_PARAM_OUT);
	
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt); 
}

/***********************************************************************************************************
 * Edit SQL Statement for direct customer/location entry.
 *****************************************************************************************************t*****/
function DirectCustEdit() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	$ERRORD = "";
	
	if (trim ( $DCUST ) != "" && $l_button != "Customer Retrieval") :
		DCustEdit ();
		if (trim ( $ERRORD ) == "") :
			$LOADTBLS = "N";
			$LOADSQL = "Y";
			$PREP4FMT = "3";
			$hld_whse = $WHSE;
			$hld_cust = $CUST;
			$hld_locn = $LOCN;
			Customer ();
			$WHSE = $hld_whse;
			$CUST = $hld_cust;
			$LOCN = $hld_locn;
			if (trim ( $SQLSTMT ) == "") :
				$ERRORD = "Direct Customer Entry is invalid. Try again with a valid warehouse and/or customer and/or location";
			
			endif;
		 elseif (trim ( $ERRORD ) == "*") :
			$ERRORD = "Direct Customer Entry is invalid. Try again with a valid warehouse and/or customer and/or location";
		endif;
	
endif;
}

/***********************************************************************************************************
 * Check to see if warehouse allows Order Book Retrievals.
 *****************************************************************************************************t*****/
function CheckOrderBook() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	/// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB080 (?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "WHSE", DB2_PARAM_IN);
	db2_bind_param($stmt,  3, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  4, "ERROR1", DB2_PARAM_OUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt); 

}

/***********************************************************************************************************
 * Validate Item # and/or customer with warehouse
 *****************************************************************************************************t*****/
function TestItem($l_checkitem) {
	
	// Include ALL global variables 
	eval ( globals () );
	
	/// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB009V02 (?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "WHSE", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  3, "LOCN", DB2_PARAM_IN);
	db2_bind_param($stmt,  4, "GLIST", DB2_PARAM_IN);
	db2_bind_param($stmt,  5, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  6, "l_checkitem", DB2_PARAM_IN);
	db2_bind_param($stmt,  7, "ERROR", DB2_PARAM_INOUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt); 

}

/***********************************************************************************************************
 * Validate Item # and/or customer with warehouse
 *****************************************************************************************************t*****/
function TestLoc() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	/// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB043 (?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  3, "WHSE", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  4, "CUST", DB2_PARAM_IN);
	db2_bind_param($stmt,  5, "LOCN", DB2_PARAM_IN);
	db2_bind_param($stmt,  6, "DCUST", DB2_PARAM_IN);
	db2_bind_param($stmt,  7, "ERROR", DB2_PARAM_OUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt);

}

/********************************************************************
 * Store all lists on iSeries  
 *******************************************************************/

function Store_Lists() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	/// open connection
	$connection = db2_connect('','','') or die("Connection Failed ".db2_conn_errormsg());
	// prepare the program call
	$stmt = db2_prepare($connection, "CALL HTHOBJ.WBB018 (?,?,?,?,?,?,?,?)") or die("Prepare failed: ".db2_stmt_errormsg());
	// define all parmeters
	db2_bind_param($stmt,  1, "USER", DB2_PARAM_IN);
	db2_bind_param($stmt,  2, "PATH_INSTANCE", DB2_PARAM_IN);
	db2_bind_param($stmt,  3, "FUNCTIONCODE", DB2_PARAM_IN);
	db2_bind_param($stmt,  4, "KEY", DB2_PARAM_IN);
	db2_bind_param($stmt,  5, "LISTKEY", DB2_PARAM_INOUT);
	db2_bind_param($stmt,  6, "ACTION", DB2_PARAM_IN);
	db2_bind_param($stmt,  7, "ORGIN", DB2_PARAM_IN);
	db2_bind_param($stmt,  8, "LIST", DB2_PARAM_INOUT);
	
	// Execute the call to the program
	db2_execute($stmt) or die("Execute failed: ".db2_stmt_errormsg());
	
	db2_free_result($stmt);
	db2_free_stmt($stmt);

}


/********************************************************************************* 
 * Load table with locations based on SQL statement.
 **********************************************************************************/
function LoadLocsold() {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_connect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB084 (?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 2, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 3, "WHSE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 4, "LOCN", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 5, "WHSNAME", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 6, "ERROR", DB2_PARAM_OUT );
	// define output parms that are not defined 
	$OUTPUT = ' ';
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	// load the array for later processingm
	$loccnt = 0;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		$loccnt += 1;
		$loc_array [$loccnt] ['loc'] = $row [0];
		$loc_array [$loccnt] ['name'] = $row [1];
		$loc_array [$loccnt] ['trait'] = $row [2];
	}
	
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );
}
/********************************************************************************* 
 * Load table with locations based on SQL statement.
 **********************************************************************************/
function LoadLocs($l_GRPID) {
	
	// Include ALL global variables 
	eval ( globals () );
	
	// open connection
	$connection = db2_pconnect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
	// prepare the program call
	$stmt = db2_prepare ( $connection, "CALL HTHOBJ.WBB084 (?,?,?,?,?,?,?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
	// define all parmeters
	db2_bind_param ( $stmt, 1, "USER", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 2, "PATH_INSTANCE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 3, "WHSE", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 4, "LOCN", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 5, "WHSNAME", DB2_PARAM_OUT );
	db2_bind_param ( $stmt, 6, "l_GRPID", DB2_PARAM_IN );
	db2_bind_param ( $stmt, 7, "ERROR", DB2_PARAM_OUT );
	// define output parms that are not defined 
	$OUTPUT = ' ';
	// Execute the call to the program
	db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
	
	// load the array for later processingm
	$loccnt = 0;
	while ( $row = db2_fetch_array ( $stmt ) ) {
		$loccnt += 1;
		$loc_array [$loccnt] ['loc'] = $row [0];
		$loc_array [$loccnt] ['name'] = $row [1];
		$loc_array [$loccnt] ['trait'] = $row [2];
		$loc_array [$loccnt] ['dsploc'] = $row [3];
	}
	
	db2_free_result ( $stmt );
	db2_free_stmt ( $stmt );
}
/********************************************************************************* 
 * display the location selection window
 **********************************************************************************/
function DispLocsold() {
	
	// Include ALL global variables 
	eval ( globals () );
	if (count ( $loc_array ) == 0) :
		echo '<hr><center><span title="No Records"><b>NO LOCATINS COULD BE LOADED</b></span></center><hr>';
	 else :
		// Display the item selection table
		?>
	<h3 style="margin-top: 0; margin-bottom: 0">
					<center>Select Store Locations</center>
					</h3>
					<h5 style="margin-top: 0; margin-bottom: 0">
					<center><?
		echo trim ( $WHSNAME ) . ' - ' . trim ( $WHSE )?></center>
					</h5>
					<table border="0" cellpadding="0" cellspacing="0" width="100%"
						style="font-size: 10pt" style="margin-top: 0; margin-bottom: 10">
						<tr>
							<td align="left" colspan="4"><input type="checkbox" name="ADDALL"
								value="ALL"
								onclick="AuthAll(document.form.ADDALL,document.form.LOCSEL)">
							Select ALL Locations &nbsp;&nbsp; <input type="checkbox"
								name="RMVALL" value="NONE"
								onclick="AuthAll(document.form.RMVALL,document.form.LOCSEL)">
							Remove ALL location selections</td>
						</tr>
						<tr valign="top" style="background-color:<?
		echo $DARK?>; color:<?
		echo $LIGHTLETTER?>">
							<th>Select</th>
							<th>Loc</th>
							<th>&nbsp;</th>
							<th align="left">Name</th>
						</tr>
<?php
		foreach ( $loc_array as $t2 ) {
			echo '<tr>';
			echo '<td class="dottedtop" align= "center"> <input type="checkbox" id="LOCSEL" name="LOCSEL[]" value="' . trim ( $t2 ['loc'] ) . '"';
			if ((trim ( $LOCSEL ) !== "" && strpos ( $LOCSEL, trim ( $t2 ['loc'] ) ) !== false) || (trim ( $LOCSEL ) == "" && trim ( $t2 ['loc'] ) == substr ( $LOCN, 6, 3 )))
				echo ' checked';
			echo '></td>';
			echo '<td class="dottedtop" align= "center">' . trim ( $t2 ['loc'] ) . '</td>';
			echo '<td class="dottedtop">&nbsp;</td>';
			echo '<td class="dottedtop" align= "left">' . trim ( $t2 ['name'] ) . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	endif;
	
	echo '
<SCRIPT LANGUAGE="JavaScript"><!--
	
function AuthAll(frmobj1,frmobj2) {
	if(frmobj1.value == "ALL"){
		for (var i=0;i<frmobj2.length;i++) {
			frmobj2[i].checked = true;
		}
	}
	else{
		for (var i=0;i<frmobj2.length;i++) {
			frmobj2[i].checked = false;	
		}
	}
	frmobj1.checked = false;	
}

//--></script>
';

}


/********************************************************************************* 
 * display the location selection window
 **********************************************************************************/
function DispLocs() {
	
	// Include ALL global variables 
	eval ( globals () );
	if (count ( $loc_array ) == 0) :
		echo '<hr><center><span title="No Records"><b>NO LOCATINS COULD BE LOADED</b></span></center><hr>';
	 else :
		// Display the item selection table
		?>
	<h3 style="margin-top: 0; margin-bottom: 0">
					<center>Select Store Locations</center>
					</h3>
					<h5 style="margin-top: 0; margin-bottom: 0">
					<center><?
		echo trim ( $WHSNAME ) . ' - ' . trim ( $WHSE )?></center>
					</h5>
					<table border="0" cellpadding="0" cellspacing="0" width="100%"
						style="font-size: 10pt" style="margin-top: 0; margin-bottom: 10">
						<tr>
							<td align="left" colspan="4"><input type="checkbox" name="ADDALL"
								value="ALL"
								onclick="AuthAll(document.form.ADDALL,document.form.LOCSEL);AuthAll(document.form.RMVALL,document.form.TRTSEL)">
							Select ALL Locations &nbsp;&nbsp; <input type="checkbox"
								name="RMVALL" value="NONE"
								onclick="AuthAll(document.form.RMVALL,document.form.LOCSEL);AuthAll(document.form.RMVALL,document.form.TRTSEL)">
							Remove ALL Selections</td>
						</tr>
						<tr valign="top" style="background-color:<?
		echo $DARK?>; color:<?
		echo $LIGHTLETTER?>">
							<th>Select</th>
							<th>Loc</th>
							<th>&nbsp;</th>
							<th align="left">Name</th>
						</tr>
<?php
		foreach ( $loc_array as $t2 ) {
			echo '<tr>';
			if (trim ( $t2 ['loc'] ) == "") :
				echo '<td class="dottedtop" align= "center"> <input type="checkbox" id="TRTSEL" name="TRTSEL[]" value="' . trim ( $t2 ['trait'] ) . '"';
				if ((trim ( $TRTSEL ) !== "" && strpos ( $TRTSEL, trim ( $t2 ['trait'] ) ) !== false))
					echo ' checked';
				echo '></td>';
			else:
				echo '<td class="dottedtop" align= "center"> <input type="checkbox" id="LOCSEL" name="LOCSEL[]" value="' . trim ( $t2 ['loc'] ) . '"';
				if ((trim ( $LOCSEL ) !== "" && strpos ( $LOCSEL, trim ( $t2 ['loc'] ) ) !== false) || (trim ( $LOCSEL ) == "" && trim ( $t2 ['loc'] ) == substr ( $LOCN, 6, 3 )))
					echo ' checked';
				echo '></td>';
			endif;
			echo '<td class="dottedtop" align= "center">';
			if (trim ( $t2 ['dsploc'] ) != "") echo trim ( $t2 ['dsploc'] ); 
			else echo '&nbsp;';
			 echo '</td>';
			echo '<td class="dottedtop">&nbsp;</td>';
			if (trim ( $t2 ['loc'] ) != "")
				if (trim ( $t2 ['trait'] ) != "")
					echo '<td class="dottedtop" align= "left">' . trim ( $t2 ['name']).' <b>('. trim ( $t2 ['trait'] ) . ')</b></td>';
				else 
					echo '<td class="dottedtop" align= "left">' . trim ( $t2 ['name']). '</td>';
			else
				echo '<td class="dottedtop" align= "left">All <b>'. trim ( $t2 ['trait'] ) . '</b> locations</td>';
				
			echo '</tr>';
		}
		echo '</table>';
	endif;
	
	echo '
<SCRIPT LANGUAGE="JavaScript"><!--
	
function AuthAll(frmobj1,frmobj2) {
	if(frmobj1.value == "ALL"){
		for (var i=0;i<frmobj2.length;i++) {
			frmobj2[i].checked = true;
		}
	}
	else{
		for (var i=0;i<frmobj2.length;i++) {
			frmobj2[i].checked = false;	
		}
	}
	frmobj1.checked = false;	
}

//--></script>
';

}
/********************************************************************************* 
 * display the location selection window
 **********************************************************************************/
function DispLocst() {
	
	// Include ALL global variables 
	eval ( globals () );
	if (count ( $loc_array ) == 0) :
		echo '<hr><center><span title="No Records"><b>NO LOCATINS COULD BE LOADED</b></span></center><hr>';
	 else :
		// Display the item selection table
		?>
	<h3 style="margin-top: 0; margin-bottom: 0">
					<center>Select Store Locations</center>
					</h3>
					<h5 style="margin-top: 0; margin-bottom: 0">
					<center><?
		echo trim ( $WHSNAME ) . ' - ' . trim ( $WHSE )?></center>
					</h5>
					<table border="0" cellpadding="0" cellspacing="0" width="100%"
						style="font-size: 10pt" style="margin-top: 0; margin-bottom: 10">
						<tr>
							<td align="left" colspan="4"><input type="checkbox" name="ADDALL"
								value="ALL"
								onclick="AuthAll(document.form.ADDALL,document.form.LOCSEL);AuthAll(document.form.RMVALL,document.form.TRTSEL)">
							Select ALL Locations &nbsp;&nbsp; <input type="checkbox"
								name="RMVALL" value="NONE"
								onclick="AuthAll(document.form.RMVALL,document.form.LOCSEL);AuthAll(document.form.RMVALL,document.form.TRTSEL)">
							Remove ALL Selections</td>
						</tr>
						<tr valign="top" style="background-color:<?
		echo $DARK?>; color:<?
		echo $LIGHTLETTER?>">
							<th>Select</th>
							<th>Loc</th>
							<th>&nbsp;</th>
							<th align="left">Name</th>
						</tr>
<?php
		foreach ( $loc_array as $t2 ) {
			echo '<tr>';
			if (trim ( $t2 ['loc'] ) == "") :
				echo '<td class="dottedtop" align= "center"> <input type="checkbox" id="TRTSEL" name="TRTSEL[]" value="' . trim ( $t2 ['trait'] ) . '"';
				if ((trim ( $TRTSEL ) !== "" && strpos ( $TRTSEL, trim ( $t2 ['trait'] ) ) !== false))
					echo ' checked';
				echo '></td>';
			else:
				echo '<td class="dottedtop" align= "center"> <input type="checkbox" id="LOCSEL" name="LOCSEL[]" value="' . trim ( $t2 ['loc'] ) . '"';
				if ((trim ( $LOCSEL ) !== "" && strpos ( $LOCSEL, trim ( $t2 ['loc'] ) ) !== false) || (trim ( $LOCSEL ) == "" && trim ( $t2 ['loc'] ) == substr ( $LOCN, 6, 3 )))
					echo ' checked';
				echo '></td>';
			endif;
			echo '<td class="dottedtop" align= "center">';
			if (trim ( $t2 ['dsploc'] ) != "") echo trim ( $t2 ['dsploc'] ); 
			else echo '&nbsp;';
			 echo '</td>';
			echo '<td class="dottedtop">&nbsp;</td>';
			if (trim ( $t2 ['loc'] ) != "")
				if (trim ( $t2 ['trait'] ) != "")
					echo '<td class="dottedtop" align= "left">' . trim ( $t2 ['name']).' <b>('. trim ( $t2 ['trait'] ) . ')</b></td>';
				else 
					echo '<td class="dottedtop" align= "left">' . trim ( $t2 ['name']). '</td>';
			else
				echo '<td class="dottedtop" align= "left">All <b>'. trim ( $t2 ['trait'] ) . '</b> locations</td>';
				
			echo '</tr>';
		}
		echo '</table>';
	endif;
	
	echo '
<SCRIPT LANGUAGE="JavaScript"><!--
	
function AuthAll(frmobj1,frmobj2) {
	
	if(frmobj1.value == "ALL"){
		if (!frmobj2.length) {
			frmobj2.checked = true;
		}
		else {
			for (var i=0;i<frmobj2.length;i++) {
				frmobj2[i].checked = true;
			}
		}
	}
	else{
		if (!frmobj2.length) {
			frmobj2.checked = false;
		}
		else {
			for (var i=0;i<frmobj2.length;i++) {
				frmobj2[i].checked = false;	
			}
		}
	}
	frmobj1.checked = false;	
}

//--></script>
';

}

/***********************************************************************************************************
 * Used to include all global variables in a function
 * e.g...  function foo(){
 * eval(globals()); // just insert this line at the begining of each function
 * $a = 5;  // if $a is global then this line wil change the value of the global $a
 * }
 *****************************************************************************************************t*****/
function globals() {
	
	$vars = array ();
	foreach ( $GLOBALS as $k => $v ) {
		$vars [] = "$" . $k;
	}
	return "global " . join ( ",", $vars ) . ";";
}

/*********************************************************************
 * Display error via an alert window.
 *******************************************************************/
function error($error) {
	
	echo ' <script Language="JavaScript"> ' . ' alert("' . trim ( $error ) . '");' . ' </script>';
}

?>