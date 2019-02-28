<?php

/* Allow storage of session variables $_SESSION['xxxxxxxxxxx']

		breadcrumb: array containing the URL for a visited web page
		bc_pageid: array containing the page id for web page in the above URL
		bc_title: array containing the title for web page in the above URL
		bc: counter used for above two arrays
		userid: user profile for user that is logged in.  This variable will be destroyed when 'Logout' is requested
*/
 session_start();
 $_SESSION['count'] = 0; //load notification session variable
 
// Set the web user to the session variable
if(isset($_SESSION['userid'])) $USER = $_SESSION['userid'];
//else $data->USERID = $USER;
/* Load all incoming parameters into PHP variables with the same name*/
if (count ( $_POST ) > 0) {
	foreach ( $_POST as $var => $value ) {
		If (trim($value) == 'UNDEFINED' || trim($value) == 'undefined'):
		   $value = '';
		endif;
		if (is_array ( $_POST [$var] )) :
			$comma = '';
			$value = '';
			for($i = 0; $i < count ( $_POST [$var] ); $i ++) {
				$_POST [$var] [$i] = urldecode ( $_POST [$var] [$i] );
				$value = trim ( $value ) . trim ( $comma ) . $_POST [$var] [$i];
				$comma = ',';
			}
		 else :
			$_POST [$var] = urldecode ( $value );
		endif;
		$value = urldecode ( trim ( $value ) );
		if (trim ( $value ) != "" && trim ( $value ) != "undefined" && trim ( $value ) != "UNDEFINED") {
			$value = str_replace ( '"', '\"', $value );
			eval ( " \$$var = \"$value\";" );
			if ($var == 'WHSE' || $var == 'CUST' || $var == 'LOCN' || $var == 'SALES' || $var == 'VEND'){
				eval ( '$'.$var.'_sv = "'.$value.'";' );
			}
		}
	}
}
if (count ( $_GET ) > 0) {
	foreach ( $_GET as $var => $value ) {
		If (trim($value) == 'UNDEFINED' || trim($value) == 'undefined'):
		   $value = '';
		endif;
		$_GET [$var] = urldecode ( $value );
		$value = urldecode ( trim ( $value ) );
		if (trim ( $value ) != "" && trim ( $value ) != "undefined" && trim ( $value ) != "UNDEFINED") {
			$value = str_replace ( '"', '\"', $value );
			eval ( " \$$var = \"$value\";" );
			if ($var == 'WHSE' || $var == 'CUST' || $var == 'LOCN' || $var == 'SALES' || $var == 'VEND'){
				eval ( '$'.$var.'_sv = "'.$value.'";' );
			}
		}
	}
}
if (trim($DCUST) != '') {
	if (trim($DLOCN) != '') {
		$LOCN= $DCUST.$DLOCN;
		$LOCN_sv = $LOCN;
	}
	else {
		$CUST = $DCUST;
		$CUST_sv = $CUST;
	}
}

/* Define Global Functions */
include 'globalfunctionsv02ek.inc';
?>