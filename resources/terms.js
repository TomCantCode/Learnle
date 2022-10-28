var TERMNUM = 1;


function addTerm() {
    TERMNUM += 1;
    var term = document.createElement('div');
    term.setAttribute('id', TERMNUM);
    term.value = 'not null'
    term.className += 'term';

    var CONTENTS = document.getElementById(TERMNUM-1).innerHTML;
    
    term.innerHTML = CONTENTS;
    document.getElementById('termcount').innerHTML = TERMNUM;
    
    document.getElementById("termlist").appendChild(term);

}

function removeTerm() {
    if (TERMNUM > 1) {
        document.getElementById(TERMNUM).remove();
        TERMNUM -= 1;
        document.getElementById('termcount').innerHTML = TERMNUM;
    }
    else {
        alert('You must have at least one term in your set!')
    }
    
}

document.getElementById("addterm").addEventListener("click", addTerm);

document.getElementById("removeterm").addEventListener("click", removeTerm);