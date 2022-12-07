//Global variables and cookie
var TERMNUM = 1;
document.cookie=`term_count_uid=`+TERMNUM;
var SAVED = false   


//Adding a term to the list
function addTerm() {

    //Increase term number, variables and classes for term
    TERMNUM += 1;
    var term = document.createElement('div');
    term.setAttribute('id', TERMNUM);
    term.value = 'not null'
    term.className += 'term';

    //Add the html for the term 
    var CONTENTS = `<div>Term `+TERMNUM+`:</div><br>
    <div class = "row">
      <div class = "row">Name:&nbsp&nbsp<input type= "text" id= "termname-`+TERMNUM+`" name= "termname-`+TERMNUM+`" required autocomplete="off">&nbsp&nbsp&nbsp&nbsp</div>
      <div class = "row">Number of attempts:&nbsp&nbsp<input type= "number" id= "attempts-`+TERMNUM+`" name= "attempts-`+TERMNUM+`" required><br></div>
    </div>
    <div class = "row"><br>Definition (Hint):&nbsp&nbsp<input type= "text" id= "def-`+TERMNUM+`" name= "def-`+TERMNUM+`" required autocomplete="off"></div>`;
    
    term.innerHTML = CONTENTS;
    document.getElementById("termlist").appendChild(term);

    //Update the term number counter and cookie
    document.getElementById('termcount').innerHTML = TERMNUM;
    document.cookie=`term_count_uid=`+TERMNUM;    

}


//Deleting the most recent term
function removeTerm() {

    //If the number of terms is over one, delete the most recent term and update the term counter and cookies
    if (TERMNUM > 1) {
        document.getElementById(TERMNUM).remove();
        TERMNUM -= 1;
        document.getElementById('termcount').innerHTML = TERMNUM;
        document.cookie=`term_count_uid=`+TERMNUM;   
    }
    //If the number of terms is one, a message is displayed to user
    else {
        alert('You must have at least one term in your set!')
    }
    
}


//Adds input listener if the 'Add term' button is pressed, to carry out the function
document.getElementById("addterm").addEventListener("click", addTerm);


//Adds input listener if the 'Remove term' button is pressed, to carry out the function
document.getElementById("removeterm").addEventListener("click", removeTerm);


//Adds input listener if the 'Save set' button is pressed, to set the save variable as true
document.getElementById("save").addEventListener("click", function(){SAVED = true})


//Confirm leaving page function
window.onbeforeunload = function() {
    
  //If not saved, confirm page prompt appears
  if(!SAVED) {
    return("Are you sure you want to leave before finishing the game?")
  }  
  return undefined;

}


