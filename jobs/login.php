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
            $invalidAlert = "<div class='error'>";
            $invalidAlert .= "<p>User not found, please try again</p>";
            $invalidAlert .= "</div>";
            echo $invalidAlert;

        } 
        else {
            echo "<div style='background-color:red'>No users in DB yet</div>";
        }

        mysqli_close($conn);

    
    }
?>

<!DOCTYPE html>
<head>
    <title>Login</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>

    <style>
        form {
            text-align: center;
        }

        a {
            border: 1px solid black;
            padding: 8px;
            background-color: lightgray;
            text-decoration: none;
        }
        a:hover{
            background-color: gray;
        }

        .error {
            background-color: red;
            padding: 10px;
            margin: 30px;
            margin: auto;
        }

    </style>

</head>
<body>
    <h1>Login</h1>

    <form onsubmit="return validate(event)" action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <input type="submit" name="submit">
    </form>

    <a href="register.php">Register</a>

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