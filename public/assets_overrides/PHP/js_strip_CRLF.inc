 function StripCRLF(Stg) { 
 var filteredValues = "\r\n "; 
 // Charactersstripped out 
 var i; 
 var frmValue = new String(Stg); 
 var returnString = ""; 
 for (i = 0; i < frmValue.length; i++) { 
	 // Search through string and append to unfiltered values to returnString. 
	 var c = frmValue.charAt(i);
	if (filteredValues.indexOf(c) == -1) returnString += c; 
	} 
return returnString; 
}
