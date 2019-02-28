<?php
// open connection
$connection = db2_connect ( '', '', '' ) or die ( "Connection Failed " . db2_conn_errormsg () );
// prepare the program call
$stmt = db2_prepare ( $connection, "CALL HTHOBJ.TABLE (?, ?)" ) or die ( "Prepare failed: " . db2_stmt_errormsg () );
// define all parmeters
db2_bind_param ( $stmt, 1, "A", DB2_PARAM_IN );
db2_bind_param ( $stmt, 2, "B", DB2_PARAM_OUT );
$A = 'A';
$B = ' ';
// Execute the call to the program
db2_execute ( $stmt ) or die ( "Execute failed: " . db2_stmt_errormsg () );
// detail processing
// ...
echo 'B= ' . $B . '<br>';
while ( $row = db2_fetch_array ( $stmt ) ) {
	echo $row [0] . $row [1] . '<br>';
}
// ...
// free resources
db2_free_result ( $stmt );
db2_free_stmt ( $stmt );
?>