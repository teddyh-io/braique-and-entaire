<?php
       session_start();


   if(!$_SESSION["loggedin"]){
       header("Location: login.php");
       }


       $name = $_SESSION["firstName"];
   // can initialize other session variables here as needed
?>


<!doctype html>
<html>
       <head>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <title>Job Search - Braique & Entaire</title>
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
               <link rel="stylesheet" href="/jobs/style.css">
       </head>


       <body>
              
<div class="page-header">
     <a href="/jobs">
         <img class="logo" src="/jobs/jobs-logo.png"></img>
     </a>


     <div class="categories">
       <a href="#" class="create-listing button">New Job</a>
               <a href="/" class="button">Back to Store</a>
               <p style="font-style: italic;">Welcome, <?php echo $name; ?>!<br>
                       <a href="logout.php">Log Out →</a>
               </p>
     </div>
         <div class="popup">
                       You must have a Business account to create a new listing!<br><br>
                       <a href="register.php" class="button">Create a Business Account →</a><br><br>
                       or<br><br>
                       <a href="login.php" class="button">Login with a different Account →</a><br><br>
                       <div class="close">Close</div>
         </div>
   </div>


<div class="container">
 <div class="job-listing">
 </div>
 <div class="job-detail">
   <div class="detail-title"></div>
   <div class="detail-location"></div>
   <div class="detail-salary"></div>
   <div class="detail-description"></div>
   <div class="detail-qualifications"></div>
   <br><hr class="solid">
   <p>This business is currently online, answering questions for any potential applicants!</p>


       <div id="chat-container">
       <div id="chat-messages"></div>
       <div id="user-input">
               <input type="text" id="user-message" placeholder="Type your message...">
               <button class="chat-send" onclick="sendMessage()">Send</button>
       </div>
       </div>
   <div class="action-buttons">
      
     <a class="button btn-apply" href="#" >Apply Directly</a>
   </div>
 </div>


 <div class="form-container">
               <strong>Create a new listing:</strong><br>
               <form action="add_job.php" method="post">
                       <div class="form-element">
                               Job Title: <input type="text" name="jobTitle" class="jobTitle">
                       </div>
                       <div class="form-element">
                               Description: <textarea rows="3" name="description" class="description"></textarea>
                       </div>
                       <div class="form-element">
                               Hourly pay: <input type="text" name="pay" class="pay">
                       </div>
                       <div class="form-element">
                               Location: <input type="text" name="location" class="location">
                       </div>
                       <div class="form-element">
                               Qualifications:
                               <img id="generateTextBox" onclick="addBox()" src="/jobs/plusbutton.png">
                               <div id="quals-container">
                                       <div id="qual">1:<nobrsp><input type="text" name="qual1"></div>
                               </div>
                       </div>
                       <br>
                       <input id="submit" type="submit" value="Add listing" class="button">
               </form>
       </div>
</div>


<script>
 $(document).ready(function() {
   $('.job-detail').hide(); // Initially hide the job detail section
       $('.form-container').hide(); //and the add listing form
       $('.page-header>.popup').hide(); //and the popup


   $('.job-item').click(function() {
     var jobID = $(this).data('job');
     $('.job-detail').show(); // Show the job detail section when a job is clicked
     $('.job-item').removeClass('active'); // Remove active class from all job items
         $(".form-container").hide();
         $("#chat-messages").html("");//delete all chat messages
     $(this).addClass('active'); // Add active class to the clicked job item
     $(".detail-title").html($(this).find('.job-title').html());
     $(".detail-location").html($(this).find('.job-location').html());
     $(".detail-salary").html($(this).find('.job-salary').html());
     $(".detail-description").html($(this).find('.job-desc-full').html());
     $(".detail-qualifications").html($(this).find('.job-qualifications').html());
     // You can add more functionality here to display the correct job details based on the jobID
   });


       //show add listing form when button is clicked
       $('.create-listing').click(function() {
               if("<?php echo $_SESSION["type"]; ?>" == "business") {
                       $('.job-detail').hide();
                       $('.job-item').removeClass('active');
                       $('.form-container').show();
               }
               else {//show popup if no business account
                       $('.page-header>.popup').show();
               }              
       });


       $('.close').click(function() {
               $('.page-header>.popup').hide();
       });


      
       $('.btn-apply').click(function(e) {
       e.preventDefault(); // Prevent default action of the button


                       // Create a form element
                       var form = $('<form>', {
                               'action': 'applications.php',
                               'method': 'POST'
                       });


                       // Create a hidden input element with the job title
                       var jobTitle = $('.detail-title').html();
                       $('<input>').attr({
                               type: 'hidden',
                               name: 'jobTitle',
                               value: jobTitle
                       }).appendTo(form);


                       // Append the form to the body and submit
                       form.appendTo('body').submit();
   });
 });


   var chatLog = "";
   function sendMessage() {
   var userMessage = $('#user-message').val();
  
   // Display user message
   displayMessage("user", userMessage);
   chatLog += "User: " + userMessage + "\n";


   // Send user message to PHP script for processing
   $.ajax({
       type: 'POST',
       url: 'process_message.php',
       data: { message: chatLog, jobTitle: $(".detail-title").html(), jobDesc: $(".detail-description").html(),
                               jobQual: $(".detail-qualifications").html(), jobLoc: $(".detail-location").html(),
                               jobPay: $(".detail-salary").html() },
       success: function(response) {
           // Display OpenAI's response
           displayMessage("bot",response);
           chatLog += response + "\n";
       }
   });


       // Clear input field
       $('#user-message').val('');
   }


   function displayMessage(sender,message) {
       if (sender == "bot") {
               $('#chat-messages').append('<p class="chat chat-reply">' + message.split("Business: ")[1] + '</p>');
       } else if (sender == "user") {
               $('#chat-messages').append('<p class="chat chat-message">' + message + '</p>');
       }
   }


</script>


       <script>
               //add more qualification input boxes
               var count = 1;
               function addBox() {
                       if (count < 10)
                       {
                               count ++;
                               // Create a new input element
                               var inputElement = $("<input>").attr("type", "text").attr("name", ("qual" + count));
                               // Append the input element to the form
                               var qualContainer = $("#quals-container");
                               qualContainer.append("<div id='qual'>" + count + ": ");
                               qualContainer.append(inputElement);
                               qualContainer.append("</div>");
                               if (count == 10)
                               {
                                       var button = $("#generateTextBox");
                                       button.addClass("inactive");
                               }
                       }
               }
       </script>


               <?php
                       //establish connection info
                       $server = "localhost";
                       $userid = "uscgzjcvbt0d7";
                       $pw = "braiqueenter";
                       $db= "db0cigaeahy23l";
                              
                       // Create connection
                       $conn = new mysqli($server, $userid, $pw );


                       // Check connection
                       if ($conn->connect_error) {
                       die("Connection failed: " . $conn->connect_error);
                       }
                      
                       //select the database
                       $conn->select_db($db);


                       //run a query
                       $sql = "SELECT * FROM Listings";
                       $result = $conn->query($sql);


                       //populate listings
                       if ($result->num_rows > 0) {
                               echo "<script>";
                               while ($row = $result->fetch_assoc()) {
                                   // Properly concatenating and escaping the strings.
                                   echo "$('.job-listing').append('<div class=\"job-item\" data-job=\"" . addslashes($row["id"]) .
                                       "\"><div class=\"job-title\">" . addslashes($row["job_title"]) .
                                       "</div><div class=\"job-location\">" . addslashes($row["location"]) .
                                       "</div><div class=\"job-salary\">$" . addslashes($row["pay"]) .
                                       "/hour</div><div class=\"job-desc\">" . addslashes(substr($row["description"], 0, 40)) . "...' +
                                       '</div><p style=\"display:none;\" class=\"job-desc-full\">" . addslashes($row["description"]) .
                                       "</p><div style=\"display:none;\" class=\"job-qualifications\">" . addslashes($row["qualifications"]) .
                                       "</div></div>');";
                               }
                               echo "</script>";
                           }
                       else
                       echo "Error accessing listings";


                       //close the connection 
                       $conn->close();
               ?>
   </body>
</html>
