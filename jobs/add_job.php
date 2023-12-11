<?php
               if ($_SERVER["REQUEST_METHOD"] == "POST") {
                       $server = "localhost";
                       $userid = "uscgzjcvbt0d7";
                       $pw = "braiqueenter";
                       $db= "db0cigaeahy23l";
                              
                       // Create connection
                       $conn = new mysqli($server, $userid, $pw);


                       // Check connection
                       if ($conn->connect_error) {
                               die("Connection failed: " . $conn->connect_error);
                       }
                      
                       //select the database
                       $conn->select_db($db);


                       $Title = $_POST['jobTitle'];
                       $Descr = $_POST['description'];
                       $Pay = $_POST['pay'];
                       $Location = $_POST['location'];
                       $Qual = '';
                      
                       //smush together all of the POST data from the qualifications boxes
                       for ($i = 1; $i < 11; $i++) {
                               if ($_POST['qual' . $i] != '') {
                                       $Qual = $Qual . "<li>" . $_POST['qual' . $i] . "</li>";
                               }
                       }

                               // Prepare and bind
                               $stmt = $conn->prepare("INSERT INTO Listings (job_title, description, pay, qualifications, location) VALUES (?, ?, ?, ?, ?)");
                               $stmt->bind_param("sssss", $Title, $Descr, $Pay, $Qual, $Location);


                               // Execute the prepared statement
                               if ($stmt->execute()) {
                                       echo "Data inserted";
                                       ?>
                                       <script>
                                       window.location = "/jobs";
                                       </script>
                                       <?php
                               } else {
                                       echo "Error: " . $stmt->error;
                               }
                               // Close statement
                               $stmt->close();


                       // Close connection
                       $conn->close();
               }
?>
