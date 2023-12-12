<!doctype html>
<html>
   <head>
       <meta charset="utf-8">
       <title>Register</title>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       <link rel="stylesheet" href="/jobs/style.css">
       <meta name="viewport" content="width=device-width, initial-scale=1">


   </head>
<body>
   <div class="page-header">
     <a href="/jobs">
         <img class="logo" src="/jobs/jobs-logo.png"></img>
     </a>


     <div class="categories">
       <a href="/" class="create-listing button">Back to Store</a>
     </div>
   </div>


   <div class="login-container">
   <h1 class="login-header">Register</h1>
   <form onsubmit="return validate(event)" action="process_reg.php" method="get">
      
       <label for="firstName">Name</label> <br>
       <input type="text" placeholder="First" name="firstName" class="field-name" id="firstName">
       <input type="text" placeholder="Last" name="lastName" class="field-name" id="lastName"> <br><br>


       <label for="type">Account type</label> <br><br>
       <label for="standard">Standard</label><input type="radio" name="type" value="standard" id="standard">
       <p>Our base level account for anyone seeking work in this industry.</p><br>
       <label for="gold">Gold</label><input type="radio" name="type" value="gold" id="gold">
       <p>Prioritized customer service, early access to job listings, and keycard access to the lounge in our headquarters.</p><br>
       <label for="business">Business</label><input type="radio" name="type" value="business" id="business"> 
       <p>Register as a business to be able to post your own "job" listings! Our site will surely find you excellent hirees in no time.</p>
       
       
       <br>

  
       <label for="email">Email</label><br>
       <input type="text" placeholder="totally@legal.net" name="email" id="email"> <br> <br>


       <label for="username">Username</label><br>
       <input type="text" name="username" id="username"> <br>


       <label for="password">Password</label> <br>
       <input type="password" name="password" id="password"> <br><br>


       <input type="submit" class="btn-apply" value="Create Account">
   </form>
   <a class="login-registerLink" href="login.php">Already a member? Log in</a>


</div>




<script>
       // validate form data
       function validate(event) {
           // check that no field is blank
           if (($("#firstName").val() == "")
               || ($("#lastName").val() == "")
               || ($("#email").val() == "")
               || ($("#username").val() == "")
               || ($("#password").val() == "")
               || ($("#type").val() == "")
               ) {
               // replace the alert with something more elegant
               alert("Error: all fields must be completed to register.");
               return false;
           }


           return true;
       }


   </script>




</body>
