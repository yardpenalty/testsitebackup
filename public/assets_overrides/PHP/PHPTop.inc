<?php
/* Define Standard Variables */
include 'globalvariables.inc';

/* Load all incoming parameters */
if (count ( $_POST ) > 0) {
	foreach ( $_POST as $var => $value ) {
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
		if (trim ( $value ) != "") {
			$value = str_replace ( '"', '\"', $value );
			eval ( " \$$var = \"$value\";" );
		}
	}
}
if (count ( $_GET ) > 0) {
	foreach ( $_GET as $var => $value ) {
		$_GET [$var] = urldecode ( $value );
		$value = urldecode ( trim ( $value ) );
		if (trim ( $value ) != "") {
			$value = str_replace ( '"', '\"', $value );
			eval ( " \$$var = \"$value\";" );
		}
	}
}

/* Define Global Functions */
include 'globalfunctions.inc';
?>