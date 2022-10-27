var TERMNUM = 0;


function addTerm() {
    TERMNUM += 1;
    var term = document.createElement('div');
    term.setAttribute('id', TERMNUM);
    term.className += 'term';
    var CONTENTS = <></>

    document.getElementById(TERMNUM).innerHTML = CONTENTS;
    document.getElementById('termcount').innerHTML = TERMNUM;
    
    document.getElementById("Termlist").appendChild(term);

}

function removeTerm() {
    document.getElementById(TERMNUM).remove();
    TERMNUM -= 1;
    document.getElementById('termcount').innerHTML = TERMNUM;
}

document.getElementById("addterm").addEventListener("click", addTerm());

document.getElementById("removeterm").addEventListener("click", removeTerm());