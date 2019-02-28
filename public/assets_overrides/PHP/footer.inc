<? // Standard Footer?>
<table cellpadding="6" cellspacing="0"
	<?php
	if ($OFORMAT == "S") :
		echo "bgcolor=\"$DARK\"";
	
	endif;
	?>
	width="100%">
	<tr>
		<td><font size="1"
			<?php
			if ($OFORMAT == "S") :
				echo "color=\"$LIGHTLETTER\"";
			
			endif;
			?>>
<?php
if ($OFORMAT == "S") :
	if ($NOEMAIL == '') :
		echo "<a href=\"mailto:$WEBMSTRMAIL?subject=Web Site comment\" STYLE=\"color:$LIGHTLETTER;\" onmouseover=\"this.style.color='$LIGHTLETTERALT';\" onmouseout=\"this.style.color='$LIGHTLETTER';\">";
		?>	
					E-Mail Us	
					</a>
					&nbsp;|&nbsp;
				
	<?endif;
	?>
				<?
	echo "<a href=\"db2www.pgm/requirements.mac/display\" STYLE=\"color:$LIGHTLETTER;\" onmouseover=\"this.style.color='$LIGHTLETTERALT';\" onmouseout=\"this.style.color='$LIGHTLETTER';\">"?>
					System Requirements
				</a>
				&nbsp;|&nbsp; 
				<?
	echo "<a href=\"db2www.pgm/privacy.mac/display\" STYLE=\"color:$LIGHTLETTER;\" onmouseover=\"this.style.color='$LIGHTLETTERALT';\" onmouseout=\"this.style.color='$LIGHTLETTER';\">"?>
					Privacy Statement
				</a>
				&nbsp;&nbsp;
			
<?endif;
?>					
			©2004-2015 The H.T. Hackney Co.  All rights reserved.
			</font></td>
		<td align="right"><a href="http://www.facebook.com/hthackney"
			target="_BLANK"><img src="/Images/facebook.png" width="24"
			height="24" border="0"></a> &nbsp; <a
			href="http://twitter.com/#!/HTHackney" target="_BLANK"><img
			src="/Images/twitter.png" width="24" height="24" border="0"></a>
		&nbsp;&nbsp; <font size="1"
			<?php
			if ($OFORMAT == "S") :
				echo "color=\"$LIGHTLETTER\"";
			
			endif;
			?>>
			<?
			echo $CURDATE;
			?> 
			</font></td>
	</tr>
</table>