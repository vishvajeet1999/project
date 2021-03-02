var playing=false;
var score;
var trialsleft;
var step;
var action;//set for interval
var fruits = ['apple', 'banana', 'cherries', 'grapes', 'mango', 'orange', 'peach', 'pear', 'watermelon'];


$(document).ready(function(){
// click on start reset button

$("#startreset").click(function(){

//we are playing
if(playing==true){
//reload page
location.reload();
}
else{

$("#gameover").hide();    
playing=true;
score=0;
$("#scorevalue").html(score);
    
$("#trialsleft").show();
trialsleft=3;
    
addhearts(); 
$("#startreset").html("reset game"); 

    startaction();
}
   });
    
    

$("#fruit1").mouseover(function(){
    score++;
   $("#scorevalue").html(score);
    
    //playsound 
   $("#slicesound")[0].play(); 
    
    
    //stop fruit 
    clearInterval(action);
    
        $("#fruit1").hide("explode", 500);
    
    
    //send a new fruit
    setTimeout(startaction,520);
//    setTimeout(startaction,50);
    
});


function startaction(){
    $("#fruit1").show(); 
    choosefruite();
    $("#fruit1").css({'left':Math.round(550*Math.random()),'top':-30}); 
   
    //generating a sstep 
    step=1+Math.round(5*Math.random());
    
    // move fruit down by one step every 10 ms
    
    action=setInterval(function(){
        $("#fruit1").css('top',$("#fruit1").position().top+step);
        
        //check if the fruit is too low
        if($("#fruit1").position().top>$("#fruitspace").height()){
            //check if we have any trials left
            if(trialsleft>1){
                $("#fruit1").show(); 
    choosefruite();
    $("#fruit1").css({'left':Math.round(550*Math.random()),'top':-30}); 
   
    //generating a sstep 
    step=1+Math.round(5*Math.random());
                
            //reduce trials number
                trialsleft--;
                //trials left
                addhearts();
                
            }
            else{
                //game over
                playing=false;
                //change start 
                $("#startreset").html("Start Game");
                $("#gameover").show();
                
                $("#gameover").html("<p>game over!</p> your score is " + score + "<p></p>");
                
                $("#trialsleft").hide();
                
                stopaction();
                
                
            }
        }
    },10);
    
    
}

function stopaction(){
    clearInterval(action);
    $("#fruit1").hide();
}

function choosefruite(){
     $("#fruit1").attr('src','images/'+fruits[Math.round(8*Math.random())]+'.png');
}

function addhearts(){
    $("#trialsleft").empty();
    for(i=0;i<trialsleft;i++){
    $("#trialsleft").append('<img src="images/heart.png" class="image">');
    }
    
}
    });
// 

//var playing=false;
//var score;
//var trialsleft;
//var step;
//var action;//set for interval
//var fruits = ['apple', 'banana', 'cherries', 'grapes',
//'mango', 'orange', 'peach', 'pear', 'watermelon'];
//
//
//$(document).ready(function(){
//// click on start reset button
//
//
//$("#startreset").click(function(){
//
////we are playing
//if(playing==true){
////reload page
//location.reload();
//}
//else{
//
//$("#gameover").hide();
//playing=true;
////game started
//score=0;
//$("#scorevalue").html(score);
//// trials left
//$("#trialsleft").show();
//trialsleft=3;
//
//
//// addings trials hearts
//addhearts();
//
//// change botton to reset game
//$("#startreset").html("Reset Game");
//
//
////start action
//startAction();
//     }
//  });
//
//$("#fruit1").mouseover(function(){
//
//    score++;
//    $("#scorevalue").html(score);
//
//    $("#slicesound")[0].play();//play sound
//    //getElementById("slicesound").play();
//
//   //stop fruit 
//   clearInterval(action);
//
//   //hide fruit
//
//  $("#fruit1").hide("explode",500);//slice fruit
//   
//
//   //send new fruit
//   setTimeout(startAction,500);
//   //startAction();
//
//});
//
//function addhearts(){
//
//$("#trialsleft").empty();
//for(i=0;i<trialsleft;i++){
//$("#trialsleft").append('<img src="images/heart.png" class="image">');
//    }
// }
//
////start sending fruits
//
//function startAction(){
//
////generate fruit
//$("#fruit1").show();
//
////choose a random fruit
//chooseFruit();
//
//$("#fruit1").css({'left':Math.round(550*Math.random()),'top':-20});//rando position
//
////random step
//step=1+Math.round(5*Math.random());
//
////move fruit down by on step every 10ms
//
//action=setInterval(function(){
//$("#fruit1").css('top',$("#fruit1").position().top+step);
//
////check if the fruit is too low
//if($("#fruit1").position().top > $("#fruitspace").height()){
//     
//    //check if we have trials left
//if(trialsleft>1){
////generate fruit
//$("#fruit1").show();
//
////choose a random fruit
//chooseFruit();
//$("#fruit1").css({'left':Math.round(550*Math.random()),'top':-20});//rando position
//
////random step
//step=1+Math.round(5*Math.random());
//
////reduce trials by 1
//trialsleft--;
//
////add hearts
//addhearts();
//
//$("#gameover").hide();//hide gameoverbox
//
//}
//
//else{
////game over
//
//playing=false;//not playing
//
//$("#startreset").html("start game");
//
//$("#gameover").show();
//
//$("#gameover").html('<p>Game over!</p><p>Your score is '+ score +'</p>');
//
//$("#trialsleft").hide();
//
//stopAction();
//
//}
//    
//
//}
//
//}, 10); 
//
//
//}
//
//function chooseFruit(){
//$("#fruit1").attr('src','images/'+fruits[Math.round(8*Math.random())]+'.png');
//
//}
//
////stop droppng fruits
//
//function stopAction(){
//clearInterval(action);
//$("#fruit1").hide();
//}
//
//});