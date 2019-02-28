<?php
$connection = db2_pconnect ( '', '', '' );
$statement = db2_prepare ( $connection, 'select * from HTHData.Wbplog' );
if (db2_execute ( $statement )) {
	echo "executing<br>";
	$counter = 0;
	while ( $row = db2_fetch_assoc ( $statement ) and $counter < 100 ) {
		$counter ++;
		?>
<table>
	<tr>
		<td><?=$row ['USERID']?></td>
		<td><?=$row ['MNUFNC']?></td>
	</tr>
</table>
<?php
	}
} 
?>