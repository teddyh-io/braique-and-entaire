<?php
   session_start();


   // Check if the form is submitted
   if (isset($_POST['submit'])) {
       // login credentials
       $server = "localhost";
           $userid = "uscgzjcvbt0d7";
           $pw = "braiqueenter";
           $db= "db0cigaeahy23l";


       // Create connection
       $conn = mysqli_connect($server, $userid, $pw, $db);
       // Check connection
       if (!$conn) {
           die("Connection failed: " . mysqli_connect_error());
       }


       $sql = "SELECT * FROM users";
       $result = mysqli_query($conn, $sql);


       //echo "about to enter if statement <br>";


       if (mysqli_num_rows($result) > 0) {
           // use POST to get data
           $inputUsername = $_POST["username"];
           $inputPassword = $_POST["password"];
          
           // output data of each row
           while($row = mysqli_fetch_assoc($result)) {
               if ($row["username"] == $inputUsername && $row["password"] == $inputPassword) {
                   // set session info
                   $_SESSION["loggedin"] = true;
                   $_SESSION["firstName"] = $row["firstName"];
                   $_SESSION["lastName"] = $row["lastName"];
                   $_SESSION["username"] = $row["username"];
                   $_SESSION["email"] = $row["email"];
                   $_SESSION["password"] = $row["password"];
                   $_SESSION["type"] = $row["type"];
?>
                   <script type="text/javascript">
                       // go to listings page
                       window.location = "/jobs";
                   </script>
<?php   
               }
           }
          
           // if the user is not found in the DB


           echo "<script>alert('User not found, please try again');</script>";


       }
       else {
           echo "<div style='background-color:red'>No users in DB yet</div>";
       }


       mysqli_close($conn);


  
   }
?>


<!doctype html>
<html>
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">


       <title>Login</title>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
       <link rel="stylesheet" href="/jobs/style.css">
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
   <h1 class="login-header">Login</h1>
   <form onsubmit="return validate(event)" action="login.php" method="post">
       <label for="username">Username</label>
       <input type="text" name="username" id="username">


       <label for="password">Password</label>
       <input type="password" name="password" id="password">


       <input class="btn-apply" type="submit" name="submit">
   </form>
   <a class="login-registerLink" href="register.php">Not a member yet? Register</a>


</div>




   <script>
       // validate form data
       function validate(event) {
           // check that no field is blank
           if (($("#username").val() == "") || ($("#password").val() == "")) {
               // replace the alert with something more elegant
               alert("please enter a username and password!");
               return false;
           }


           return true;
       }


   </script>




</body>

