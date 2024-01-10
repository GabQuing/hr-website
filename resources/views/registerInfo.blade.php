<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Registration Details</title>
  <link rel="icon" href="/img/Digits.png" type="image/x-icon">
  <link rel="stylesheet" href="regInfo.css" type="text/css">
</head>


<body>
<div class="main">
  <div class="register">
    <h2>Registration Details</h2>
    <hr>
    <form id="register" method="POST" action="{{route('registerUser')}}">
      @csrf
      <label>First Name:</label>
      <br>
      <input class="register_inputs" type="text" name="fname" id="first_name" placeholder="Enter Your First Name" required>
      <br>
      <p><em>Required:</em></p>
      <br>
      <label>Middle Name:</label>
      <br>
      <input class="register_inputs" type="text" name="mname" id="middle_name" placeholder="Enter Your Middle Name" required>
      <br>
      <p><em>Required:</em></p>
      <br>
      <label>Last Name:</label>
      <br>
      <input class="register_inputs" type="text" name="lname" id="last_name" placeholder="Enter Your Last Name" required>
      <br>
      <p><em>Required:</em></p>
      <br>
      {{-- <label>Employee ID:</label>
      <br>
      <input class="register_inputs" type="text" name="empId" id="eployee_id" placeholder="Enter Your Employee ID" required>
      <br><br> --}}
      <label>Email Address:</label>
      <br>
      <input class="register_inputs" type="text" name="email" id="email" placeholder="Name@Company.ph" >
      <br>
      <p><em>Optional:</em></p>
      <br>
      <label>Mobile Number:</label>
      <br>
      <input class="register_inputs" type="tel" name="mobile" id="contact_number" placeholder="09*********"  pattern="[0-9]{4}[0-9]{3}[0-9]{4}" required>
      <br>
      <p><em>Required: 09*********</em></p>
      <br>
      {{-- <label>Gender:</label>
      <br>
      &nbsp;&nbsp;&nbsp;
      <label>
        <input class="radio_btn" type="radio" name="gender" id="male" value="male">
        <span id="male">Male</span>
      </label>
      &nbsp;&nbsp;&nbsp;
      <label>
        <input class="radio_btn" type="radio" name="gender" id="female" value="female">
        <span id="female">Female</span>
      </label>
      <br><br> --}}
      <div class="submit_btn">
        <input type="submit" value="Continue" name="submit" id="submit" >
      </div>
    </form>



  </div>
</div>


</body>
</html>