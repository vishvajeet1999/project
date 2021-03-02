// ajax call to update username

$("#updateusernameform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
     
    //send them to updateusernameform.php using AJAX
    //    $.post({}).done().fail();
   
    $.ajax({
        url:"updateusername.php",
        type:"POST",
        data:datatopost,
        success: function(data){
            if(data){
                $("#updateusernamemessage").html(data);  
            }else{
    location.reload(); 
               
            } 
        }
            ,
        error: function(){
            $("#udateusernamemessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    });
 
    
});


// ajax call to update passsword

$("#updatepasswordform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
     
    //send them to updateusernameform.php using AJAX
    //    $.post({}).done().fail();
   
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updatepasswordmessage").html(data); 
            }
        },
        error: function(){
            $("#updatepasswordmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    });
 
    
});



// ajax call to update email
$("#updateemailform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
     
    //send them to updateusernameform.php using AJAX
    //    $.post({}).done().fail();
   
    $.ajax({
        url:"updateemail.php",
        type:"POST",
        data:datatopost,
        success: function(data){
            if(data){
                $("#updateemailmessage").html(data); 
            }
        }
            ,
        error: function(){
            $("#updateemailmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    });
 
    
});


// ajax call to update email
$("#updateemailform").submit(function(event){
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
     
    //send them to updateusernameform.php using AJAX
    //    $.post({}).done().fail();
   
    $.ajax({
        url:"updateemail.php",
        type:"POST",
        data:datatopost,
        success: function(data){
            if(data){
                $("#updateemailmessage").html(data); 
            }
        }
            ,
        error: function(){
            $("#updateemailmessage").html("<div class='alert alert-danger'> There was an error with ajax call. Please try again later. </div>");
        }
    });
 
    
});

