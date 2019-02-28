<?php
if (count ( $_POST ) > 0) {
	foreach ( $_POST as $var => $value ) {
		if (trim ( $var ) != 'l_button') {
			if (! in_array ( $var, $vars )) :
				if (is_array ( $_POST [$var] )) :
					$comma = '';
					$value = '';
					for($i = 0; $i < count ( $_POST [$var] ); $i ++) {
						$value = trim ( $value ) . trim ( $comma ) . $_POST [$var] [$i];
						$comma = ',';
					}
					echo '<INPUT TYPE=HIDDEN NAME=' . trim ( $var ) . ' VALUE=' . trim ( $value ) . '>';
				 else :
					echo '<INPUT TYPE=HIDDEN NAME=' . trim ( $var ) . ' VALUE=' . urlencode ( trim ( $value ) ) . '>';
				endif;
			
			endif;
		}
	}
}
if (count ( $_GET ) > 0) {
	foreach ( $_GET as $var => $value ) {
		if (trim ( $var ) != 'l_button') {
			if (! in_array ( $var, $vars ))
				echo '<INPUT TYPE=HIDDEN NAME=' . trim ( $var ) . ' VALUE=' . urlencode ( trim ( $value ) ) . '>';
		}
	}
}
?>
<INPUT TYPE=HIDDEN NAME=l_button VALUE="">
<INPUT TYPE=HIDDEN NAME=LIGHT VALUE=<?
echo $LIGHT?>>
<INPUT TYPE=HIDDEN NAME=LIGHTLETTER VALUE=<?
echo $LIGHTLETTER?>>
<INPUT TYPE=HIDDEN NAME=LIGHTLETTERALT VALUE=<?
echo $LIGHTLETTERALT?>>
<INPUT TYPE=HIDDEN NAME=DARK VALUE=<?
echo $DARK?>>
<INPUT TYPE=HIDDEN NAME=DARKLETTER VALUE=<?
echo $DARKLETTER?>>
<INPUT TYPE=HIDDEN NAME=DARKLETTERALT VALUE=<?
echo $DARKLETTERALT?>>
<INPUT TYPE=HIDDEN NAME=TODAY VALUE=<?
echo $CURDATE?>>
