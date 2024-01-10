<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Registration Details</title>
  <link rel="icon" href="/img/Digits.png" type="image/x-icon">
  <link rel="stylesheet" href="accessDeny.css" type="text/css">
</head>


<body>
<div class="main">
  <div class="main_frame">
    <div class="first_column">
      <h2 id="deniedLabel">ACCESS DENIED!</h2>
      <hr>
      <br>
      <p id="descriptionBox">The page you were trying to reach is restricted, your device has no record in our system.</p>
      <br>
      <label id="redirectBack"><em>Please Return Back To The Home Page.</em></label>
      <div class="returnPanel">
          <a id="homeButton" href="login">Return Home Page</a>
      </div>
    </div>
    <div class="second_column">
      <img src="{{ asset('/img/locked.jpg') }}" alt="" id="imgLocked">
    </div>

    



  </div>
</div>


</body>
</html>