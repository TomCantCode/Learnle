
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


//Creates a grid using a word, number of attempts/rows and a hint
function create_grid(word, numatt, hint) {

  if(next = true) {
    //Set any nessacery variables
    globalThis.HINT = hint;
    ANSWER = word;
    MAXGUESSES = numatt;
    var grid = document.getElementById('grid-container');
    var total = word.length * numatt;

    //Resets the number of columns, then sets it to the word length
    grid.style.gridTemplateColumns = '';
    for (var b = 0; b < word.length; b++) {
      grid.style.gridTemplateColumns += ' auto';
    }

    //Creates the needed number of squares with default class
    for (var a = 0; a < total; a++) {
      var square = document.createElement('div');
      square.setAttribute('id', a)
      square.className = 'square';
      grid.appendChild(square);
    }
  }
  next = false;

}


//Add sets the inputted word to the current row
function grid_add_string(name, string, row) {

  for (var a = 0; a < string.length; a++) {
    //Adds the nth letter of the word to the xth square of the grid
    var newValue = (string.charAt(a)).toUpperCase()
    gridNum = document.getElementById(a + (string.length * (row)))
    gridNum.innerHTML = newValue;

    //If the nth letter of the guess is equal to the nth letter of the answer, then add to score and class 
    if (newValue == ANSWER.charAt(a)) {
      gridNum.className += ' correct';
      termScore += 10;
    }

    //If the nth letter of the guess is in the answer, then add to score and class
    else if (ANSWER.includes(newValue)) {
      gridNum.className += ' incorrect';
      termScore += 5;
    }

    //If the nth letter of the guess is not in the answer, then add to score and class
    else {
      gridNum.className += ' wrong';
      termScore += 0;
    }

  };

  //If the guess was the answer, then the keyboard is 'frozen' and the round is won
  if (GUESSES[GUESSNUM].replace(undefined, '') == ANSWER) {
    AllowKeyPress = false; 
    setTimeout(function(){round_over('W');},100)
  };

};


//Listens to keyboard inputs
window.addEventListener('keydown', function(event) {
  
  if(AllowKeyPress == true) {
    //If a baskpace is pressed (and not the first letter of the row), delete current square value, reset class and decrement current square number
    if ((event.key == 'Backspace') && squareNum > GUESSNUM * ANSWER.length) {
      squareNum -= 1;
      document.getElementById(squareNum).innerHTML = '';
      document.getElementById(squareNum).className = 'square';
    }

    //If an allowed letter is pressed (and not the last letter of the row) then the letter is added and class is updated
    if (legalInputs.includes(event.key) && ((squareNum - GUESSNUM * ANSWER.length) < ANSWER.length)) {
      document.getElementById(squareNum).innerHTML = `${event.key}`.toUpperCase();
      document.getElementById(squareNum).className += ' full';
      squareNum += 1;
    }

    //If enter is pressed
    if (event.code == 'Enter') {

      //Each value of row's squares are added together
      var trialGuess = '';
      for (var i = 0; i < ANSWER.length; i++) {
        var currentletter = (document.getElementById(i + (ANSWER.length * (GUESSNUM))).innerHTML);
        trialGuess += currentletter
      }

      if (((squareNum - (GUESSNUM * ANSWER.length)) == ANSWER.length) /*&& (dictionary.check(trialGuess.replace(undefined, '')))*/) {
      
        //If the grid row is full, add guess to array of guesses  
        GUESSES[GUESSNUM] = trialGuess.replace(undefined, '');
      
        //Add guess to grid and increment the current guess
        grid_add_string('grid-container', String(GUESSES[GUESSNUM]).replace(undefined, ''), GUESSNUM);
        GUESSNUM += 1;

        //If on the last guess, a hint is presented
        if(GUESSNUM == Math.round(MAXGUESSES - 1)) {
          var hint = document.getElementById('hint');
          hint.style.display = "block";
          hint.innerHTML += HINT; 
        }
      
        //If on the final guess and guess wasn't the answer, then round is lost
        if((GUESSNUM == MAXGUESSES) && (GUESSES[GUESSNUM] != ANSWER)) {
          round_over('L')
        }

      }

      //If the row isn't filled then an error is displayed
      else {
        alert('Invalid length of guess');
      }

    }
  }

}, false);


//Main loop that converts inputted variables into arrays and recurses the game 
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

  
  nextRound();
}


//Changes progress bar to input
function progress_update(progress) {

  var i = 0
  if (i == 0) {

    //Sets variables
    i = 1;
    var bar = document.getElementById("progress");
    var width = bar.innerHTML.replace("%","");
    width = parseInt(width)
    //Iterates next function every 10 ticks
    var id = setInterval(frame, 10);

    //If size of progress bar is the correct size the iteration is stopped, else the width is increased
    function frame() {
      if (width >= progress) {
        clearInterval(id);
        i = 0;
      }
      else {
        width++;
        bar.style.width = width + "%";
        bar.innerHTML = width + "%";
      }
    }
  }
}


//Function for one round of the game
function nextRound() {

  //Resets and saves variables and elements
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
    
  //Carries out creation and update functions
  create_grid(Terms[current], NumAtts[current], Hints[current])
  progress_update(Math.round((current / Terms.length) * 100))
  score_update()

  current += 1
    
}

//For when the current round is complete
function round_over(status) {

  //Outputs message to user depending on if round was won or lost
  if(status == 'W'){
    alert('Well Done!')
  }
  else{
    alert('Better luck next time!')
  }

  if(current < Terms.length) {
    //Recurses the round function
    nextRound()
  }
  else {
    //If the last round has been played then progress is updated one more time then the game over funciton is called
    progress_update(Math.round((current / Terms.length) * 100))
    gameEnd() 
  }
}


//Displays game over screen and score
function gameEnd() {

  //2D Array (array of array of guesses) updated and set to a cookie for php to read 
  ALLGUESSES[current] = '['+GUESSES+']';
  ALLGUESSES.shift()
  document.cookie=`all_guesses=`+ ALLGUESSES;

  //Game over screen pops up and displays score and links to home or library
  var gameover = document.getElementById('game-end')
  gameover.style.display = "block";
  gameover.innerHTML = `<div> Game Complete!<div><br> <div class = 'row'>You scored: `+SCORE+`</div> <div class = 'row'> <div class = "button">
  <input type = "button" onClick = "location.href = 'personal-library'" class = "roundbutton" name = "return-library" value = "Return to library"></div> <div class = "button">
  <input type = "button" onClick = "location.href = 'home'" class = "roundbutton" name = "return-home" value = "Return to homepage></div> </div>`;


  document.getElementById('all_guesses').innerHTML = ALLGUESSES;
}


//Updates main score
function score_update() {
  //Multiply score on current term by a penalty factored by number of attempts
  termScore *= 1.05 - (GUESSNUM * 0.05)

  //Added to total score and term score is reset
  SCORE += termScore;
  Math.round(SCORE)
  termScore = 0  
}


//Confirm leaving page function
window.onbeforeunload = function() {

  //If game isn't finished, confirm page prompt appears
  if(!(current == Terms.length)) {
    return("Are you sure you want to leave before finishing the game?")
  }
  //Cookie is deleted
  document.cookie = "all_guesses = ; expires = 01 Jan 1900 00:00:00 UTC";
  return undefined;

}

