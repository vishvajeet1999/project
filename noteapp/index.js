//ajax call for the signup form
//once the form is submitted
$("#signupform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
     
    //send them to signup.php using AJAX
    //    $.post({}).done().fail();
   
    $.ajax({
        url:"signup.php",
        type:"POST",
        data:datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);  
            }
        }
            ,
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    });
 
    
});

//ajax call for the loogin form
//once the form is submitted

$("#loginform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
     
    //send them to signup.php using AJAX
    //    $.post({}).done().fail();
    
    $.ajax({  
        url:"login.php",
        type:"POST",
        data: datatopost,
        success: function(data){
                if(data){ 
                window.location = "mainpageloggedin.php";    
            }else{ 
                $('#loginmessage').html(data); 
            }   
            
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    }); 

    
});   


//ajax call for the forgot password form
//once the form is submitted

$("#forgotpasswordform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
     
    //send them to signup.php using AJAX
    //    $.post({}).done().fail();
    
    $.ajax({  
        url:"forgot-password.php",
        type:"POST",
        data: datatopost,
        success: function(data){
           $('#forgotpasswordmessage').html(data); 
                
            
        },
        error: function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    }); 

    
});






