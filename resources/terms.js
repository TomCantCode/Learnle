var TERMNUM = 1;
document.cookie=`term_count_uid=`+TERMNUM;   

function addTerm() {
    TERMNUM += 1;
    var term = document.createElement('div');
    term.setAttribute('id', TERMNUM);
    term.value = 'not null'
    term.className += 'term';

    var CONTENTS = `<div>Term `+TERMNUM+`:</div><br>
    <div class = "row">
      <div class = "row">Name:&nbsp&nbsp<input type= "text" id= "termname-`+TERMNUM+`" name= "termname-`+TERMNUM+`" required autocomplete="off">&nbsp&nbsp&nbsp&nbsp</div>
      <div class = "row">Number of attempts:&nbsp&nbsp<input type= "number" id= "attempts-`+TERMNUM+`" name= "attempts-`+TERMNUM+`" required><br></div>
    </div>
    <div class = "row"><br>Definition (Hint):&nbsp&nbsp<input type= "text" id= "def-`+TERMNUM+`" name= "def-`+TERMNUM+`" required autocomplete="off"></div>`;
    
    term.innerHTML = CONTENTS;
    document.getElementById('termcount').innerHTML = TERMNUM;
    document.cookie=`term_count_uid=`+TERMNUM;    

    document.getElementById("termlist").appendChild(term);

}

function removeTerm() {
    if (TERMNUM > 1) {
        document.getElementById(TERMNUM).remove();
        TERMNUM -= 1;
        document.getElementById('termcount').innerHTML = TERMNUM;
        document.cookie=`term_count_uid=`+TERMNUM;   
    }
    else {
        alert('You must have at least one term in your set!')
    }
    
}

document.getElementById("addterm").addEventListener("click", addTerm);

document.getElementById("removeterm").addEventListener("click", removeTerm);


window.onbeforeunload = function() {
    document.cookie = "term_count_uid = ; expires = 01 Jan 1900 00:00:00 UTC";
}