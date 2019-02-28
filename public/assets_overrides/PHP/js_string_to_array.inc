<? // Split out delimited string into an array 
//example---> tempArray=StringToArray(document.form.EMAIL.value,","); ?>

function StringToArray(TextArea,delimiter) {
	tempArray=new Array(1);
	var Count=0;
	var tempString=new String(TextArea);
	while (tempString.indexOf(delimiter)>0) {
		tempArray[Count]=tempString.substr(0,tempString.indexOf(delimiter));
		tempString=tempString.substr(tempString.indexOf(delimiter)+1,tempString.length-tempString.indexOf(delimiter)+1);
		Count=Count+1
	}
	tempArray[Count]=tempString;
	return tempArray;
}