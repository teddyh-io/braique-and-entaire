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
		<title>Heist Hunter - Braique & Entaire</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
		<link rel="stylesheet" href="/jobs/style.css">

	</head>

	<body>
		
	<div class="page-header">
      <a href="/jobs">
          <img class="logo" src="/jobs/jobs-logo.png"></img>
      </a>

      <div class="categories">
        <a href="#" class="create-listing">Add a new listing</a>
        <a href="/">Back to Store</a>
<form action="logout.php" method="post">
    <label for="logout-btn">Hello, <?php echo $name ?> </label>  <br/>
  <input type="submit" name="logout-btn" value="Logout"> 
</form> 
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
    <hr class="solid">
    <p>This business is currently online, answering questions for any potential applicants!</p>

	<div id="chat-container">
	<div id="chat-messages"></div>
	<div id="user-input">
		<input type="text" id="user-message" placeholder="Type your message...">
		<button onclick="sendMessage()">Send</button>
	</div>
	</div>
    <div class="action-buttons">
      <a href="/jobs/chat" class="button">Chat with Business</a>
      <a class="button btn-apply" href='applications.html'>Apply</a>
    </div>
  </div>

  <div class="form-container">
		Create a new listing:<br>
		<form action="add_job.php" method="post">
			Job Title: <input type="text" name="jobTitle">
			<br>
			Description: <input type="text" name="description">
			<br>
			Hourly pay: <input type="text" name="pay">
			<br>
			Location: <input type="text" name="location">
			<br>
			Qualifications: 
			<img id="generateTextBox" onclick="addBox()" src="/plusbutton.png">
			<br>
			<div id="quals">
				1:<input type="text" name="qual1">
			</div>
			<br>
			<input id="submit" type="submit" value="Add listing">
		</form>
	</div>

</div>

<script>
  $(document).ready(function() {
    $('.job-detail').hide();
	$('.form-container').hide(); // Initially hide the job detail section

    $('.job-item').click(function() {
      var jobID = $(this).data('job');
      $('.job-detail').show(); // Show the job detail section when a job is clicked
      $('.job-item').removeClass('active'); // Remove active class from all job items
	  $(".form-container").hide();
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
		$('.job-detail').hide();
		$('.job-item').removeClass('active');
		$('.form-container').show();
	});
  });

    var chatLog = "";
    function sendMessage() {
    var userMessage = $('#user-message').val();
    
    // Display user message
    displayMessage('You', userMessage);
    chatLog += userMessage + "\n";

    // Send user message to PHP script for processing
    $.ajax({
        type: 'POST',
        url: 'process_message.php',
        data: { message: chatLog, jobTitle: $(".detail-title").html(), jobDesc: $(".detail-description").html(),
				jobQual: $(".detail-qualifications").html(), jobLoc: $(".detail-location").html(), 
				jobPay: $(".detail-salary").html() },
        success: function(response) {
            // Display OpenAI's response
            displayMessage('Business', response);
            chatLog += response + "\n";
        }
    });

    // Clear input field
    $('#user-message').val('');
    }

    function displayMessage(sender, message) {
        $('#chat-messages').append('<p><strong>' + sender + ':</strong> ' + message + '</p>');
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
				var qualContainer = $("#quals");
				qualContainer.append("<br>" + count + ": ");
				qualContainer.append(inputElement);
				if (count == 10) 
				{
					var button = $("#generateTextBox");
					button.addClass("hidden");
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
				    echo "$('.job-listing').append('<div class=\"job-item\" data-job=\"" . $row["id"] . 
					 "\"><div class=\"job-title\">" . $row["job_title"] .
					 "</div><div class=\"job-location\">" . $row["location"] .
					 "</div><div class=\"job-salary\">$" . $row["pay"] .
					 "/hour</div><div class=\"job-desc\">" . substr($row["description"], 0, 30) . "...' +
					 '</div><p style=\"display:none;\" class=\"job-desc-full\">" . $row["description"] .
					 "</p><div style=\"display:none;\" class=\"job-qualifications\">" . $row["qualifications"] .
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