<? // Add a lookup to a <SELECT> tag ?>

function lookup(pattern, list){
  /*
  if the dropdown list passed in hasn't
  already been backed up, we'll do that now
  */
  if (!list.bak){
    /*
    We're going to attach an array to the select object
    where we'll keep a backup of the original dropdown list
    */ 
    list.bak = new Array(); 
    
    for (n=0;n < list.length ; n++){  
      list.bak[list.bak.length] = new Array(list[n].value, list[n].text, list[n].id);
    }
  }

  /*
  We're going to iterate through the backed up dropdown
  list. If an item matches, it is added to the list of
  matches. If not, then it is added to the list of non matches.
  */
  match = new Array();
  nomatch = new Array();
  for (n=0; n < list.bak.length ; n++){
    if(list.bak[n][1].toLowerCase().indexOf(pattern.toLowerCase())!=-1){
      match[match.length] = new Array(list.bak[n][0], list.bak[n][1], list.bak[n][2]);
    }else{
      nomatch[nomatch.length] = new Array(list.bak[n][0], list.bak[n][1], list.bak[n][2]);
    }
  }

  /*
  Now we completely rewrite the dropdown list.
  First we write in the matches, then we write
  in the non matches
  */
  for (n=0; n < match.length; n++){
    list[n].value = match[n][0];
    list[n].text = match[n][1];
    list[n].id = match[n][2];
  }
  for (n=0; n < nomatch.length; n++){
    list[n+match.length].value = nomatch[n][0];
    list[n+match.length].text = nomatch[n][1];
    list[n+match.length].id = nomatch[n][2];
  }

  /*
  Finally, we make the 1st item selected - this
  makes sure that the matching options are
  immediately apparent
  */
  list.selectedIndex=0;
}

