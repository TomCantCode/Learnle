
var squareNum = 0;
var legalInputs = [
  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
];


function create_grid(word, numatt, hint) {

  var HINT = hint;
  var GUESSNUM = numatt;
  var grid = document.getElementById('grid-container');
  grid.style.gridTemplateColumns = '';
  var total = word.length * numatt;

  for (var b = 0; b < numatt; b++) {
    grid.style.gridTemplateColumns += ' auto';
  }

  for (var a = 0; a < total; a++) {
    var square = document.createElement('div');
    square.setAttribute('id', a)
    square.className = 'square';
    grid.appendChild(square);
  }
  
}

function grid_add_string(name, string, row) {


  for (var a = 0; a < string.length; a++) {
    var newValue = (string.charAt(a)).toUpperCase()
    gridNum = document.getElementById(a + (string.length * (row)))
    gridNum.innerHTML = newValue;


    if (newValue == ANSWER.charAt(a)) {
      gridNum.className += ' correct';
    }

    else if (ANSWER.includes(newValue)) {
      gridNum.className += ' incorrect';
    }

    else {
      gridNum.className += ' wrong';
    }

  };

  if (GUESSES[GUESSNUM].replace(undefined, '') == ANSWER || GUESSNUM == (MAXGUESSES - 1)) {
    setTimeout(function(){next = true},3000)
  };

};


window.addEventListener('keydown', function(event) {
  
  if ((event.key == 'Backspace') && squareNum > GUESSNUM * ANSWER.length) {
    squareNum -= 1;
    document.getElementById(squareNum).innerHTML = '';
    document.getElementById(squareNum).className = 'square';
  }

  if (legalInputs.includes(event.key) && ((squareNum - GUESSNUM * ANSWER.length) < ANSWER.length)) {
    document.getElementById(squareNum).innerHTML = `${event.key}`.toUpperCase();
    document.getElementById(squareNum).className += ' full';
    squareNum += 1;
  }

  if (event.code == 'Enter') {

    var trialGuess = '';
    for (var i = 0; i < ANSWER.length; i++) {
        var currentletter = (document.getElementById(i + (ANSWER.length * (GUESSNUM))).innerHTML);
        trialGuess += currentletter
      }

    
    if (((squareNum - (GUESSNUM * ANSWER.length)) == ANSWER.length) /*&& (dictionary.check(trialGuess.replace(undefined, '')))*/) {

      GUESSES[GUESSNUM] = trialGuess.replace(undefined, '');
      

      grid_add_string('grid-container', String(GUESSES[GUESSNUM]).replace(undefined, ''), GUESSNUM);
      GUESSNUM += 1;
    }

    else {
      alert('Invalid length of guess');
    }
  }

}, false);


/*function main_loop(terms, attemptnums, hints) {

  var Terms = []
  var NumAtts = []
  var Hints = []

  Terms = terms
  NumAtts = attemptnums
  Hints = hints

  for(current = 0; current < terms.length; current++) {
    next = false

    create_grid(Terms[current], NumAtts[current], Hints[current])

    while(next = false) {
      null
    }

    squareNum = 0
    document.getElementById('grid-container').innerHTML = '';

  }
}*/
