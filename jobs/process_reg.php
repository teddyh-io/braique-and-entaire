<?php

            // echo "INSIDE IF STATEMENT";
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

        $firstName = $_GET['firstName'];
        $lastName = $_GET['lastName'];
        // $email = $_GET 
        $username = $_GET['username'];
        $password = $_GET['password'];
        $type = $_GET['type'];

        $sql = "INSERT INTO users (firstName, lastName, username, password, type) VALUES ('$firstName','$lastName','$username','$password','$type')";
        // echo $sql;

        $sent = mysqli_query($conn,$sql);

        if(!$sent) {
            echo 'Data not inserted' . mysqli_error($conn) . ' ' . mysqli_errno($conn);
        } else {
            // echo 'Data inserted' . $sql;
            // echo "HERE!";
            $queryString = "product=" . ucfirst($type) . " Account&price=" . "99.99&image=incognito.png"; 
            $destination = "../checkout.html?" . $queryString;
            ?>
            <p>Test</p>
            <script>
                console.log("redirecting");
                var queryString = "<?php echo $queryString ?>";
                window.location = "../checkout.html?" + queryString;
            </script>
            <?php
        }

    ?>