function trim(inputStr) {
 var begin = -1; 
 var end = -1; // Examine thefront of the string. 
 // Remove leading blanks or $ signs. 
 for (var i =0; i < inputStr.length ; i++){
	  var oneChar=inputStr.charAt(i);
	if (oneChar==
	" "){
              continue;
          } else {
	      begin=i;
	break;
	  } 
     }
     // Scanning from the end of the string, remove blanks 
for (var j=inputStr.length-1; j>= 0; j--){ 
	var lastChar = inputStr.charAt(j); 
	if (lastChar == " "){continue; }
	 else { end = j; break; } 
} 
if (begin < "0" && end < "0") return ""; 
else return inputStr.substring(begin,end+1); 
}
