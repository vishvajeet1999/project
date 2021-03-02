<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');
$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";

$result = mysqli_query($link, $sql);
$count= mysqli_num_rows($result);

if($count==1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username=$row['username'];
    $email= $row['email'];
}else{
    echo "there was an error retrieving the email and username form the database";
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Notes</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <link href='https://fonts.googleeapis.com/css?family=Arvo' rel="stylesheet" type="text/css">
      
      <link href="style.css" rel="stylesheet">
  </head> 
    
    <style>
    
        #container{
              margin-top: 120px;
          }
          #notePad,#allNotes,#done, .delete {
              display: none;
          }
          .buttons{
              margin-bottom: 20px;
          }
          textarea{
              width: 100%;
              max-width: 100%;
              font-size: 16px;
              line-height: 1.5em;
              border-left-width: 20px;
              border-color: CA3DD9; 
              background-color: #fbefff;
          }
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#ffffff,#eceae7);
        }
        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .timetext{
/*            font-size: 20px;*/
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            
        }
    
    </style>
    
  <body>
    
<!--      navigation bar-->
      
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
              
              <div class="navbar-header">
              
                  <a class="navbar-brand">Online Notes</a>
                  
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                  
                      <span class="sr-only">Toggle navigation bar</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span> 
    
                  
                  </button>
              </div>
              
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                  
                  <li ><a href="profile.php">Profile</a></li>
                  <li ><a href="#">Home</a></li>
                  <li><a href="#">Help</a></li>
                  <li><a href="#" class="active">My Notes</a></li>
                      
                  </ul>
                  
                  
                   <ul class="nav navbar-nav navbar-right">
                  
                      <li ><a href="#">Logged in as <b><?php echo $username; ?></b></a></li>
                  <li ><a href="index.php?logout=1">Log out</a></li>
             </ul>
              
              </div>
          </div>
      </nav>
      
<!--      Container  -->
  <div class="container" id="container">
<!--      alert messages-->
      
      <div id="alert" class="alert alert-danger collapse">
      <a class="close" data-dismiss ="alert"> &times;</a>
      
          <p id="alertContent"></p>
      </div>
      
      
      <div class="row">
         <div class="col-md-offset-3 col-md-6">
          
      <div class="buttons">
             
          <button id="addNote" type="button" class="btn btn-info btn-lg">Add Note</button>
                  
                  <button id="edit" type="button" class="btn btn-info btn-lg pull-right">Edit</button>
                  
                  <button id="done" type="button" class="btn green btn-lg pull-right">Done</button>
                  
                  <button id="allNotes" type="button" class="btn btn-info btn-lg">All Notes</button>
             
              </div>   
             <div id="notePad">
                 <textarea rows="10">
                 
                 </textarea>
             </div>
              <div id="notes" class="notes">
<!-- ajax call to php files -->
          </div>
          
      </div>
       
      </div>
      
      </div>      
     
      
<!--      login form-->
      
      <form method="post" id="loginform">
          
          <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    
    <button class="close" data-dismiss="modal">
        
        &times;
        </button>
        <h4 id="myModalLabel">
        Login: </h4>
    </div>
    <div class="modal-body">
        
<!--        login message from php file-->
        <div id="loginmessage"></div>
        
        
        
        <div class="form-group">
        <label for="loginemail" class="sr-only">Email:</label>
        <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
        </div>
        
        <div class="form-group">
        <label for="loginpassword" class="sr-only">Password</label>
        <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="30">
        </div>
        
        <div class="checkbox">
        
        <label>
            <input type="checkbox" name="rememberme" id="rememberme">Remember Me
        </label>
<!--            forgot password-->
            <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">Forgot Password?</a>
            
        </div>
        
    
    </div>
    
    <div class="modal-footer">
    
        <input class="btn green" name="login" type="submit" value="Login">
    
        <button type="button" class="btn btn-default" data-dismiss="modal">
        Cancel</button>
        
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">
        Register</button>
        
     </div>
    
    
    </div>
  </div>
</div>
          
      </form>
      
      
      
      
<!--      signup form-->
      
      <form method="post" id="signupform">
          
          <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    
    <button class="close" data-dismiss="modal">
        
        &times;
        </button>
        <h4 id="myModalLabel">
        Sign up today and Start using our Online Notes App </h4>
    </div>
    <div class="modal-body">
        
<!--        sign up message from php file-->
        <div id="signupmessage"></div>
        
        <div class="form-group">
        <label for="username" class="sr-only">Username:</label>
        <input class="form-control" type="text" name="username" id="username" placeholder="Usernamae" maxlength="30">
        </div>
        
        <div class="form-group">
        <label for="email" class="sr-only">Email:</label>
        <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
        </div>
        
        <div class="form-group">
        <label for="password" class="sr-only">Password:</label>
        <input class="form-control" type="password" name="password" id="password" placeholder="Choose a Password" maxlength="30">
        </div>
        
        <div class="form-group">
        <label for="password2" class="sr-only">Password:</label>
        <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm Password" maxlength="30">
        </div>
    
    </div>
    
    <div class="modal-footer">
    
        <input class="btn green" name="signup" type="submit" value="Sign up">
    
        <button type="button" class="btn btn-default" data-dismiss="modal">
        Cancel</button>
        
     </div>
    
    
    </div>
  </div>
</div>
          
      </form>
      
<!--      forgot password form-->
      
      <form method="post" id="forgotpasswordform">
          
          <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    
    <button class="close" data-dismiss="modal">
        
        &times;
        </button>
        <h4 id="myModalLabel">
        Forgot password? Enter your email address:</h4>
    </div>
    <div class="modal-body">
        
<!--        login message from php file-->
        <div id="forgotpasswordmessage"></div>
        
        
        
        <div class="form-group">
        <label for="forgotemail" class="sr-only">Email:</label>
        <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50">
        </div>
    
    </div>
    
    <div class="modal-footer">
    
        <input class="btn green" name="login" type="submit" value="Submit">
    
        <button type="button" class="btn btn-default" data-dismiss="modal">
        Cancel</button>
        
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="signupModal" data-toggle="modal">
        Register</button>
        
     </div>
    
    
    </div>
  </div>
</div>
          
      </form>
      
      
      
      
      
      
<!--      footer-->
      
       <div class="footer">
      <div class="container">
        <p>Development.com Copyright @copy; 2019-<?php
            $today=date("Y");
            echo $today;
            ?></p>
        
        </div>  
      </div>
      
      

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script> 
    <!-- Include all compiled plugins (below), or include individual files as needed --> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
      
      <script src="mynotes.js"></script>    
  </body> 
</html>