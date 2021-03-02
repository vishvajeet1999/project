var playing = false;
var score;
var action;
var timeremaining;
var correctAnswer;
//if we click on the start/reset
document.getElementById("startreset").onclick =
function(){

 //if we are playing

 if(playing == true){

 location.reload(); //reload page

 }else{//if we are not playing

 //change mode to playing

 playing = true;

 //set score to 0

 score = 0;
document.getElementById("scorevalue").innerHTML =score;

show("timeremaining");  //show countdown box 

    timeremaining = 60;

document.getElementById("timeremainingvalue").innerHTML =
timeremaining;

//hide game over box
hide("gameOver");

 document.getElementById("startreset").innerHTML ="Reset Game";

//start countdown

     startCountdown();

//Generate a new Q&A

    generateQA();
 

 //change button to reset
 
 
       }
   }

//clicking on answers
for(i=1;i<5;i++){
document.getElementById("box"+i).onclick=function(){
    //check if we are playing
    if(playing==true){//yes
     if(this.innerHTML==correctAnswer){
       score++;
       document.getElementById("scorevalue").innerHTML=score;

         //hide the wrong box
          hide("wrong");
          show("correct");

          setTimeout(function(){
           hide("correct")
         },1000);

      generateQA();
    }
    else{
          //wrong answer
           hide("correct");
          show("wrong");
 
          setTimeout(function(){
           hide("wrong")
         },1000);

          }
       } 
    }
}


//functions

//start counter

function startCountdown(){

   action=setInterval(function(){
         timeremaining-=1;
   document.getElementById("timeremainingvalue").innerHTML =
timeremaining;

if(timeremaining==0){//gane over

     stopCountdown();
show("gameOver");

document.getElementById("gameOver").innerHTML="<p>Game Over!</p><p>Your score is "+ score +"</p>";

hide("timeremaining");

hide("correct");
hide("wrong");
playing=false;

document.getElementById("startreset").innerHTML="start Game"


}


},1000);
}

//stop counter

function stopCountdown(){
   clearInterval(action);
}

//hide an element

function hide(id){
  document.getElementById(id).style.display="none";
}

//show an element

function show(id){
  document.getElementById(id).style.display="block";
}

//generate Q&A

function generateQA(){
    var x=1+Math.round(9*Math.random());
    var y=1+Math.round(9*Math.random());
    correctAnswer=x*y;
    document.getElementById("question").innerHTML=x+"*"+y;
    var correctPosition=1+Math.round(3*Math.random());

    document.getElementById("box"+correctPosition).innerHTML=correctAnswer;
//fill one box with the correct answer.

var answers=[correctAnswer];

for(i=1;i<5;i++){

if(i!==correctPosition){
   var wrongAnswer;
do{
wrongAnswer=(1+Math.round(9*Math.random()))*(1+Math.round(9*Math.random()));}while(answers.indexOf(wrongAnswer)>-1)



document.getElementById("box"+i).innerHTML=wrongAnswer;

answers.push(wrongAnswer);

}

}

}
