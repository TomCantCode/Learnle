var TERMS = ['FIVER', 'CHEESE', 'SLICED', 'DOGS', 'GRIPPERS', 'CHILD', 'WARZONE', 'QWERTYUIOP', 'GRID'];
var GUESSES = [''];
var GUESSNUM = 0;
var FREEZE = false;
var start = false;

function create_grid(name, x, y) {

  var grid = document.getElementById(name);
  grid.style.gridTemplateColumns = '';
  var total = x * y;

  for (var b = 0; b < y; b++) {
    grid.style.gridTemplateColumns += ' auto';
  }

  for (var a = 0; a < total; a++) {
    var square = document.createElement('div');
    square.setAttribute('id', a)
    square.className = 'square';
    grid.appendChild(square);
  }

  //var newpos = (((703 - (50 * y) - (2 * (y - 1))) / 2) / 7.03) + '%'
  //var newpos = ((703  - (50 * y) - (2 * (y - 1)))/2)/0.703 + 'px'
  //alert(newpos)
  //var r = document.querySelector(':root');
  //r.style.setProperty('--centre-pos', newpos);

}

function reset_grid(name) {
  document.getElementById(name).innerHTML = '';
  l++;
  ANSWER = TERMS[l];
  squareNum = 0;
  GUESSNUM = -1;
  GUESSES = [''];
  MAXGUESSES = ANSWER.length + 1;   
  if (l >= TERMS.length) {
    end()
  }
  create_grid('grid-container', MAXGUESSES, ANSWER.length);
  
};

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
    FREEZE = true;
    reset_grid('grid-container');
    alert('yes');
  };

};

function end() {
  alert('Set complete!!')
};


var squareNum = 0;
const legalInputs =
  ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];


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
        trialGuess += (document.getElementById(i + (ANSWER.length * (GUESSNUM))).innerHTML);
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


//check out require.js to make this work
//var Typo = require('Typo.js-master/typo/typo-js');
//var dictionary = new Typo('en_US', false, false, { dictionaryPath: 'Typo.js-master/typo/dictionaries' });


var MAXGUESSES = 0;
var l = 0;

var ANSWER = TERMS[l];
MAXGUESSES = ANSWER.length + 1;   
create_grid('grid-container', MAXGUESSES, ANSWER.length);

  
  
//function check(){
//  alert('help me please kwgjlargjerko')
//  if (FREEZE == false) {
//    var ANSWER = TERMS[l];
 //   var MAXGUESSES = ANSWER.length + 1;                          
 //   create_grid('grid-container', MAXGUESSES, ANSWER.length);
//   break;
//
 // } else if (FREEZE == true) {
//   delete_grid('grid-container');
 //   FREEZE == false;
 //   check();
//   
 // }; 
// 
//};

  
//if (start == false) {
//  start == true;
//  check();
// }


//grid_add_string('grid-container', 'test.', GUESSNUM);

//create_grid('grid-container', 6, 5);
//devare_grid('grid-container');
