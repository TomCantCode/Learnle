
//Global variables
var squareNum = 0;
var legalInputs = [
  'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
];
var ANSWER = 0;
var current = 0;
var next = false;
var AllowKeyPress = true;
var termScore = 0;

var Terms = []
var NumAtts = []
var Hints = []
var ALLGUESSES = [];
var GUESSES = [];
var SCORE = 0;

var GUESSNUM = 0;
var MAXGUESSES = 0;

function create_grid(word, numatt, hint) {

  if(next = true) {
    globalThis.HINT = hint;
    ANSWER = word;
    MAXGUESSES = numatt;
    var grid = document.getElementById('grid-container');
    grid.style.gridTemplateColumns = '';
    var total = word.length * numatt;

    for (var b = 0; b < word.length; b++) {
      grid.style.gridTemplateColumns += ' auto';
    }

    for (var a = 0; a < total; a++) {
      var square = document.createElement('div');
      square.setAttribute('id', a)
      square.className = 'square';
      grid.appendChild(square);
    }
  }
  next = false;

}

function grid_add_string(name, string, row) {


  for (var a = 0; a < string.length; a++) {
    var newValue = (string.charAt(a)).toUpperCase()
    gridNum = document.getElementById(a + (string.length * (row)))
    gridNum.innerHTML = newValue;


    if (newValue == ANSWER.charAt(a)) {
      gridNum.className += ' correct';
      termScore += 10;
    }

    else if (ANSWER.includes(newValue)) {
      gridNum.className += ' incorrect';
      termScore += 5;
    }

    else {
      gridNum.className += ' wrong';
      termScore += 0;
    }

  };

  if (GUESSES[GUESSNUM].replace(undefined, '') == ANSWER) {
    AllowKeyPress = false; 
    setTimeout(function(){round_over('W');},100)
  };

};


window.addEventListener('keydown', function(event) {
  
  if(AllowKeyPress == true) {
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

        if(GUESSNUM == Math.round(MAXGUESSES - 1)) {
          var hint = document.getElementById('hint');
          hint.style.display = "block";
          hint.innerHTML += HINT; 
        }
      
        if(GUESSNUM == MAXGUESSES) {
          round_over('L')
        }

      }

      else {
        alert('Invalid length of guess');
      }

    }
  }

}, false);


function main_loop(terms, attemptnums, hints) {

  Terms = []
  NumAtts = []
  Hints = []
  
  terms = terms.replace('[', '')
  terms = terms.replace(']', '')
  terms = terms.toUpperCase()
  attemptnums = attemptnums.toString()
  attemptnums = attemptnums.replace('[', '')
  attemptnums = attemptnums.replace(']', '')
  hints = hints.replace('[', '')
  hints = hints.replace(']', '')

  Terms = terms.split(",")
  NumAtts = attemptnums.split(",")
  Hints = hints.split(",")

  var total = 1;

  current = 0;
  next = true;

  
  nextgrid();
}

function progress_update(progress) {
  var i = 0
  if (i == 0) {
    i = 1;
    var bar = document.getElementById("progress");
    var width = bar.innerHTML.replace("%","");
    width = parseInt(width)
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= progress) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        bar.style.width = width + "%";
        bar.innerHTML = width + "%";
      }
    }
  }
}

function nextgrid() {

  squareNum = 0;
  GUESSNUM = 0;
  AllowKeyPress = true;
  ALLGUESSES[current] = '['+GUESSES+']';
  GUESSES = [];

  var hint = document.getElementById('hint');
  hint.style.display = "none";
  hint.innerHTML = " Hint: ";

  document.getElementById('grid-container').innerHTML = '';

  document.getElementById('allguesses').innerHTML = ALLGUESSES;
    
  create_grid(Terms[current], NumAtts[current], Hints[current])
  progress_update(Math.round((current / Terms.length) * 100))
  score_update()

  current += 1
    
}

function round_over(status) {
  if(status == 'W'){
    alert('Well Done!')
  }
  else{
    alert('Better luck next time!')
  }

  if(current < Terms.length) {
    nextgrid()
  }
  else {
    progress_update(Math.round((current / Terms.length) * 100))
    gameEnd() 
  }
}

function gameEnd() {
  document.getElementById('grid-container').innerHTML = '';
  ALLGUESSES[current] = '['+GUESSES+']';
  ALLGUESSES.shift()
  document.cookie=`all_guesses=`+ ALLGUESSES;

  document.getElementById('game-end').innerHTML = SCORE;


  document.getElementById('all_guesses').innerHTML = ALLGUESSES;
}

window.onbeforeunload = function() {
  document.cookie = "all_guesses = ; expires = 01 Jan 1900 00:00:00 UTC";

  if(!(current == Terms.length)) {
    return("Are you sure you want to leave before finishing the game?")
  }
  return undefined;
}

function score_update() {
  termScore *= 1.05 - (current * 0.05)
  SCORE += termScore;
  Math.round(SCORE)
  termScore = 0
  
}