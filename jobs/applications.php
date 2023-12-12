<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="utf-8">
       <title>Job Search - Braique & Entaire</title>
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
       <a href="/" class="button">Back to Store</a>
     </div>
   </div>
   <div style="text-align: center; padding: 10px; border-radius: 5px; font-size: 24px; font-weight: bold;" class="application">Job Application Form</div>
   <?php
       if ($_SERVER["REQUEST_METHOD"] === "POST") {
       $jobTitle = $_POST['jobTitle'];
       echo '<div style="text-align: center;" class="jobname">The Job You Are Applying For: ' . htmlspecialchars($jobTitle) . '</div>';
}
?>
   <div class="container" style="margin-top: 1em;">
       <form id="applicationForm" action="/submit" method="post" enctype="multipart/form-data">
           <div class="form-group">
               <label for="fullName">Name:</label>
               <input type="text" id="fullName" name="fullName" required>
           </div>


           <div class="form-group">
               <label for="email">Email:</label><br>
               <input type="email" id="email" name="email" required>
           </div>


           <div class="form-group">
               <label for="phone">Phone:</label><br>
               <input type="tel" id="phone" name="phone" required>
           </div>


           <div class="form-group">
               <label for="address">Address:</label><br>
               <textarea id="address" name="address" rows="3" required></textarea>
           </div>


           <div class="form-group">
               <label>How did you hear about Braique&Entaire?</label>
               <div>
                   <input type="radio" id="online" name="findOut" value="online" required>
                   <label for="online">Search on Google</label><br>


                   <input type="radio" id="friend" name="findOut" value="friend" required>
                   <label for="friend">Recommend By Friends</label><br>


                   <input type="radio" id="enemy" name="findOut" value="enemy" required>
                   <label for="enemy">DeRecommend By Enemy</label><br>


                   <input type="radio" id="other" name="findOut" value="other" required onclick="toggleOtherText()">
                   <label for="other">Other</label><br>


                   <textarea id="otherText" name="otherText" style="display: none;"></textarea>
               </div>
           </div>


           <div class="form-group">
               <label for="resume">Resume (PDF only):</label>
               <input type="file" id="resume" name="resume" accept=".pdf" required>
           </div>


           <div class="form-group">
               <label for="additionalInfo">Additional Information:</label>
               <textarea id="additionalInfo" name="additionalInfo" rows="5"></textarea>
           </div>
           <button type="button" onclick="redirect()" class="button">Submit Application</button>
       </form>
   </div>
</body>
<script>
   function toggleOtherText() {
       var otherText = document.getElementById('otherText');
       otherText.style.display = otherText.style.display === 'none' ? 'block' : 'none';
   }
   function redirect() {
           window.location.href = '/contact.html';
   }
</script>
</html>


<style>

#applicationForm {
   max-width: 600px;
   margin: auto;
   padding: 1em;
}


.form-group {
   margin-bottom: 20px;
}


label {
   font-weight: bold;
   padding: 10px;
}


input[type="text"],
input[type="email"],
input[type="tel"],
textarea,
select {
   width: 100%;
   padding: 10px;
   border: 1px solid #ccc;
   border-radius: 5px;
   box-sizing: border-box;
}


input[type="file"] {
   width: 100%;
   padding: 10px;
   box-sizing: border-box;
}


input[type="radio"] {
   margin-right: 5px;
}


button[type="submit"] {
   background-color: #630308;
   border-radius: 20px;
   border: none;
   padding: 10px 20px;
   text-decoration: none;
   color: white;
   cursor: pointer;
}


button[type="submit"]:hover {
   background-color: #410205;
}


</style>
