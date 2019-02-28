<? //Strip trailing and leading blanks from a character string ?>

function stp(fld) {
var res = "";
var c = 0;
for (i=0; i < fld.length ; i++) {
  if (fld.charAt(i) !=" " || c>0) { 
   res += fld.charAt(i); 
   if (fld.charAt(i) != " ") c = res.length; 
  } 
 }
return res.substr(0,c); 
}
