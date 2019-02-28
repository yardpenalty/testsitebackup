<?php 
/************************************************************************
* Description:	#upcutility modal GET: Informational
*				#upcutility modal POST: None	
* Author:				Brian V Streeter
* Date:					5/16/2016
*************************************************************************
* Modification Log:
* Date		Init	Description
* ------	----	-----------------------------------------------------
*  
*************************************************************************
* Code Summary:
*   N/A
*
*************************************************************************/
// print_r(phpinfo());
// define variables for this script

include 'globalvariablesv02.inc';

// Include standard PHP top script logic
include 'PHPTopv01.inc'; // Must always include

//print_r(globals());
echo '<div class="row">
    		<div class="hth_odd_tbl xs-small">
                 <p>
                <label>UPC Calculator</label><br>
                 The UPC calculator is simply a utility that has the ability to compute check-digits for UPC Type-E, UPC Type-A, and EAN-13s.
                 This tool will also convert UPCs Type-A to UPCs Type-E and vice-versa. <br><br>
                <i>*NOTE: The UPC Calculator does not do any actual calculations</i>
                </p>
                <p>
                <span class="h6">Bar Code Types</span>
                </p>
                <div class="set text-center"><!---css trick for inline-block keep offset ending tags for img! //-->
                <img border="0" src="/images/UPC-12.jpg" height="120" width="350"
                ><img border="0" src="/images/UPC-EAN-8.jpg" height="120" width="350"
                ><img border="0" src="/images/UPC-EAN-13.jpg" height="120" width="350"
                ><img border="0" src="/images/UPC-EAN-14.jpg" height="120" width="350"
                >
                </div>
                <br>
                <p>
                <span class="h6 stretch">UPC-E/EAN-8</span><br>
                While they are both 8-digits, the UPC-E has a 0 and 9 outside of the barcode boundary while the EAN-8 has 2 sets of 4-digits underneath the barcode. 
                The UPC-E barcode is actually a compresed version of the UPC-A barcode. <br>
                <br>Not all UPC-A barcodes will compress into a UPC-E barcodes, but all legal UPC-E barcodes will expand into UPC-A barcodes. 
                <br><br>Similarly, the EAN-8 is a shortened version of the EAN-13. The encoding methods for UPC-E and EAN-8 are not compatible, so identification is important.
                <br><br><i>*NOTE: The UPC Calculator requires all visible digits with the exception of the (optional) check digit. If present, it will be validated with the calculated value.</i>
                </p>
            </div> 
        </div>';?>