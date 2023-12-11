<?php
        
        // DB connection code
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        
        //select the database
        $conn->select_db($db);

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        // $email = $_POST 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $type = $_POST['type'];

        $sql = "INSERT INTO users (firstName, lastName, username, password, type) VALUES ('$firstName','$lastName','$username','$password','$type')";
        // echo $sql;

        $sent = mysqli_query($conn,$sql);

        if(!$sent) {
            echo 'Data not inserted' . mysqli_error($conn) . ' ' . mysqli_errno($conn);
        } else {
            // echo 'Data inserted' . $sql;
            ?>
            <script>
                window.location = "login.php";
            </script>
            <?php
        }
        }

    ?>

<!DOCTYPE html>
<head>
    <title>Register</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>

</head>
<body>
    <h1>Register</h1><br>

    <a href="login.php">go back to login</a><br><br>

    <form onsubmit="return validate(event)" action="register.php" method="post">
        
        <label for="firstName">Name</label> <br>
        <input type="text" placeholder="First" name="firstName" id="firstName">
        <input type="text" placeholder="Last" name="lastName" id="lastName"> <br><br>

        <label for="type">Account type</label> <br>
        <label for="standard">Standard</label><input type="radio" name="type" value="standard" id="standard"> <br>
        <label for="gold">Gold</label><input type="radio" name="type" value="gold" id="gold"> <br>
        <label for="business">Business</label><input type="radio" name="type" value="business" id="business"> <br><br>
    
        <label for="email">Email</label><br>
        <input type="text" placeholder="totally@legal.net" name="email" id="email"> <br> <br>

        <label for="username">Username</label><br>
        <input type="text" name="username" id="username"> <br>

        <label for="password">Password</label> <br>
        <input type="password" name="password" id="password"> <br><br>

        <input type="submit" value="Create Account">
    </form>

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
                alert("Invalid: all fields must be completed to register!");
                return false;
            }

            return true;
        }

    </script>


</body>