<?php

$vars [] = 'WHSE';
$vars [] = 'CUST';
$vars [] = 'LOCN';
$vars [] = 'SALES';
$vars [] = 'SBREAK';
$vars [] = 'VEND';
$vars [] = 'DCUST';
$vars [] = 'DLOCN';
$vars [] = 'GRP';

// How many Customer pull-down selections do we have 
$NUMPULLS = "0";

// Warehouse pull-down? 
$l_warehouse = "N";
if ($WHSTOT > "0" && $PULLWHS != "N") :
	if ($WHSTOT >= "2" || ($WHSONLY == "Y" && $WHSTOT > "0" && $WHSCONTROL == "Y")) :
		$l_warehouse = "Y";
		$NUMPULLS += 1;
	endif;
endif;

// Customer pull-down? 
$l_chain = "N";
if ($CSTTOT >= "2" && $PULLCST != "N") :
	$l_chain = "Y";
	$NUMPULLS += 1;
endif;

// Location pull-down?
$l_location = "N"; 
if ($LOCTOT > "0" && $PULLLOC != "N") :
	if 	($LOCTOT >= "2" || ($WHSONLY == "Y" && $WHSCONTROL == "Y") || (($AUTHCD == "H" || $AUTHCD == "S") && $WHSCONTROL == "Y")):
		$l_location = "Y";
		$NUMPULLS += 1;
	endif;
endif;

// Location Grouping pull-down? - not if only a single location can be selected!!
$l_group = "N";
if ($GRPTOT > "0" &&  trim ( $TYPELOC ) != "1" && trim ( $TYPELOC ) != "2" && $l_location == "Y") :
	$l_group = "Y";
	$NUMPULLS += 1;
endif;

// Sales Person pull-down?
$l_sales = "N"; 
if (count($sls) > 0 && $PULLSLS != "N"):
	$NUMPULLS += 1;
	$l_sales = "Y";	
endif;

// Vendor pull-down? 
$l_vendor = "N";		
if ($VNDTOT > "0" && $PULLVND != "N") :
	$l_vendor = "Y";
	$NUMPULLS += 1;
endif;
?>