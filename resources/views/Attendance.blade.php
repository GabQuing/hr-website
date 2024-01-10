<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Face Biometric Attendance</title>
  <link rel="icon" href="/Img/Face.png" type="image/x-icon">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="{{asset('js/jquery.js')}}"></script>
  <script  src="{{asset('./js/sweetalert.js')}}"></script>
  <script defer src="{{asset('face-api.min.js')}}"></script>
  <script defer src="{{asset('script.js')}}"></script>



  <link rel="stylesheet" href="styleAttendance.css">
  

</head>
<!-- <body onload="getCurrentDateTime()"> -->
<body>
    <div class="main">

      <form id="register" method="POST" action="{{route('attendanceLogin')}}">
        @csrf
        <input type="text" id="image_url" name="image_url" style="display: none;">
        <input type="text" class="logTypeInput", name="logType" style="display: none;">
        <button class="submit-log" type="submit" style="display: none;">submit</button>
        <div class="register">
          <div class="second_column">
            <div class="popAccessPosition" id="popAccessPosition" style="display:none">
              <div class="popAccess" id="popAccess">
                <img src="img/Deny.jpg" width="100" height="100">
                <h2 id="in_label" style="color:#338384;">ACCESS DENIED!</h2>
                <h3>Your Current Location Has No Record To Our System.</h3>
                <br>
                <a> Current Location: </a><span id="location1"></span>
              </div>
            </div>
            <div id="upper_second">
              <h2>Face Biometric Attendance System</h2>
                <div class="cameraWrapper">
                  <video id="video" width="600" height="450" autoplay>
                </div>
            </div>
            <div class="popRetryPosition" style="display:none;">
              <div class ="popRetry" id="popRetry">
                <img src="img/Deny.jpg" width="175" height="175">
                <h2 id="in_label" style="color:#338384;">ACCESS DENIED!</h2>
                <div class="reminder_note" style="color: #276566">
                  <a>  Make Sure You Are Registered.</a>
                  <br>
                  <a>  Remove Facemask and Eye Glasses.</a>
                  <br>
                  <a>  Ensure That Only One Face Is Displayed.</a>
                </div>
              </div>
            </div>
            <div class="popLoginPosition" style="display: none;">
              <div class ="popLogin" id="popLogin">
                <img src="img/check.png" width="100" height="100">
                <h2 id="in_label">Confirm Login</h2>
                Name: <a id="loginName"></a>
                <br>
                <?php date_default_timezone_set('Asia/Manila');?> 
                Date: <a id="date_time_login_button">{{ date('Y-m-d') }}</a>
                <br>
                Time: <a id="24FormatTime_In"></a>
                <input style="display:none" value="" name="inTime" id="24FormatTimeIn"></input>
                <br>
                <input class="timeInName" type="text" value="" name="inName" style="display: none;">
                <input class="TimeInDate" type="text" value="{{ date('Y-m-d') }}" name="inDate" style="display: none;">
                <input class="TimeInDate" id="realTimeIn" type="text" style="display: none;" disabled>
                <input class="" type="text" value="" name="inLocation" style="display: none;" >
                <button type="button" id="cancel_login">Cancel</button>
                <input type="button" id="confirm_login" value="Confirm Login">
              </div>
            </div>
            <div class="popLogoutPosition" style="display: none;">
              <div class ="popLogout" id="popLogout">
                <img src="img/redcheck.png" width="100" height="100">
                <h2 id="in_label">Confirm Logout</h2>
                Name: <a id="logoutName"></a>
                <br>
                Date: <a id="date_time_logout_button">{{ date('Y-m-d') }}</a>
                <br>
                Time: <a id="24FormatTime_Out"></a>
                <input style="display:none" value="" name="outTime" id="24FormatTimeOut"></input>
                <br>
                <input class="timeOutName" type="text" value="" name="outName" style="display: none;">
                <input class="TimeOutDate" type="text" value="{{ date('Y-m-d') }}" name="outDate" style="display: none;">
                <input class="TimeOutDate" id="realTimeOut" type="text"  style="display: none;" disabled>
                <input id="timeInLocation" type="text" value="" name="inLocation" style="display: none;">
                <button type="button" id="cancel_logout">Cancel</button>
                <input type="button" id="confirm_logout" value="Confirm Logout">
              </div>
            </div>
            <br>
            <hr style="height:2px;border-width:0;background-color:#338384">
            <div class="control_system">
              <div class="control_buttons">
                  <button type="button" id="login_button" value="Confirm Login" disabled>TIME-IN</button>
                  <button type="button" id="logout_button" value="Confirm Logout" disabled>TIME-OUT</button>
              </div>
              <div class="panel">
                {{-- @if (in_array($macAddress,$approvedMacAddress) ) --}}
                <input name="location" id="location" value="{{ $dataLocation->store_location }}" style=" min-width: 500px; padding: 0 20px; display:none;" >
                <div id="currentLongitude" style="display: none"></div>
                <div id="currentLatitude" style="display: none"></div>
                {{-- @endif --}}
                <div class="name_date_time">
                  <div class="employee_panel">
                  <span class="info_label">Employee Name: <span id="employee_id"></span></span>
                  </div>
                  <div class="date_panel">
                  <span class="info_label">Date: <span id="currentDate"></span></span>
                  </div>
                  <div class="time_panel">
                  <span class="info_label">Time: <span id="currentTime"></span></span>
                  </div>
                </div>
                <div class="store_panel">
                  <span class="info_label" >Store Location:</span>
                  <span id="location_display">{{ $dataLocation->store_location }}</span>
                  <br>
                    <!-- <span class="info_label">Location Access:</span> <span id="status_location">Waiting for user's location...</span>' -->
                </div>
              </div>
            </div>
          </div>
          <div class="first_column">
            <img src="{{ asset('/img/recognition.jpg') }}" alt="" id="img_recog">
            <br>
            <div id="redirect_button">
              <a href="login" id="redirect_login">Return Home Page</a>
              <span class="info_label" style="color:white;"> Confidence: <span id="confidence" style="color: white;"></span></span>
            </div>
          </div>
        </form>
        </div>
        </div>
    </div>
  </div>

<script>

  // let confidenceLevel;

  // function geocodeLatLng(lat, lng) {
  //   var url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;
  //     fetch(url)
  //       .then(response => response.json())
  //       .then(data => {
  //         if (data && data.address) {
  //           var address = data.display_name;
  //           // document.getElementById("location").value = `${address}`;
  //           document.getElementById("location2").textContent = `${address}`;
  //           document.getElementById("location1").textContent = `${address}`;
  //           document.getElementById("latitude").textContent = `Latitude: ${lat}`;
  //           document.getElementById("longitude").textContent = `Longitude: ${lng}`;
  //         } else {
  //           // document.getElementById("location").textContent = 'No results found';
  //           document.getElementById("latitude").textContent = '';
  //           document.getElementById("longitude").textContent = '';
  //         }
  //       })
  //       .catch(error => {
  //         console.log('Geocoding failed due to:', error);
  //       });
  // }

  // function getCurrentLocation() {
  //   if (navigator.geolocation) {
  //     navigator.geolocation.getCurrentPosition(
  //       position => {
  //         var latitude = position.coords.latitude;
  //         var longitude = position.coords.longitude;
  //         geocodeLatLng(latitude, longitude);
  //         },
  //       error => {
  //         console.log('Geolocation error:', error);
  //         }
  //       );
  //     } else {
  //         console.log('Geolocation is not supported by this browser.');
  //         }
  // }
  //     getCurrentLocation(); 


  $(document).ready(function(){
    $("#login_button").on("click", function(){
      const numberConfidenceLevel = parseFloat(confidenceLevel);
      if (numberConfidenceLevel > 60) {
        $.ajax({
          url: "{{ route('getTime') }}",
          type: "GET",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response){
            console.log(response.time);
            $('#24FormatTime_In').text(response.time);
            $('#24FormatTimeIn').val(response.time);
          },
          error: function(response){
            console.log(response);
          }

        });

      const logType = $(this).val();
      $('#register .logTypeInput').val(logType);
      const video = document.getElementById('video');

      // Create a canvas element to draw the video frame
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const context = canvas.getContext('2d');

      // Draw the current video frame on the canvas
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to base64 data URL
      const imageDataUrl = canvas.toDataURL('image/png');

      $('#image_url').val(imageDataUrl);
      $(".popLoginPosition").show();
      const store = $("#location").val();
      $("#showLocation").text(store);
      $(".timeInLocation").val(store);
      $("#video").get(0).pause();
      sayWelcome();
      $('#confirm_login').on('click', function(){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Attendance Successfully Registered!',
            showConfirmButton: false,
            timer: 2500,
            background: '#FFFFFF',
            customClass: {
              popup: 'swal-border',
              title: 'swal-title'
            },
            imageUrl:imageDataUrl,
            imageWidth:400,
            imageHeight:300,
            imageAlt: 'Attendance Image',
          });
      });
    } else {
        sayRetry();
        $(".popRetryPosition").show();
        setTimeout(function() {
          $(".popRetryPosition").fadeOut();
        }, 1000);
    }  
  });

      $("#cancel_login").on("click", function(){
        $("#video").get(0).play();
        $(".popLoginPosition").hide();
      })

      $("#logout_button").on("click", function(){
        const numberConfidenceLevel = parseFloat(confidenceLevel);
        if(numberConfidenceLevel > 60) {
          $.ajax({
          url: "{{ route('getTime') }}",
          type: "GET",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response){
            console.log(response.time);
            $('#24FormatTime_Out').text(response.time);
            $('#24FormatTimeOut').val(response.time);
          },
          error: function(response){
            console.log(response);
          }

        });
          const logType = $(this).val();
          $('#register .logTypeInput').val(logType);
          const video = document.getElementById('video');

          // Create a canvas element to draw the video frame
          const canvas = document.createElement('canvas');
          canvas.width = video.videoWidth;
          canvas.height = video.videoHeight;
          const context = canvas.getContext('2d');

          // Draw the current video frame on the canvas
          context.drawImage(video, 0, 0, canvas.width, canvas.height);

          // Convert the canvas image to base64 data URL
          const imageDataUrl = canvas.toDataURL('image/png');

          $('#image_url').val(imageDataUrl);
          $(".popLogoutPosition").show(); 
          const store = $("#location").val();
          $("#showLocationOut").text(store);
          $(".timeInLocation").val(store);
          $("#video").get(0).pause();
          sayGoodbye();
          $('#confirm_logout').on('click', function(){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Attendance Successfully Registered!',
                showConfirmButton: false,
                timer: 2500,
                background: '#FFFFFF',
                customClass: {
                  popup: 'swal-border',
                  title: 'swal-title'
                },
                imageUrl:imageDataUrl,
                imageWidth:400,
                imageHeight:300,
                imageAlt: 'Attendance Image',
              });
          });
        } else{
            sayRetry();
            $(".popRetryPosition").show();
            setTimeout(function() {
              $(".popRetryPosition").fadeOut();
            }, 1000);
        }
        
      })

      $("#cancel_logout").on("click", function(){
        $("#video").get(0).play();
        $(".popLogoutPosition").hide();
      })
    })


  $('#confirm_login, #confirm_logout').on('click', function(event) {
    $('.submit-log').click();
});




  function sayWelcome() {
    const name = $('.timeInName').val() || $('.timeOutName').val();
    const message = new SpeechSynthesisUtterance(`Welcome, ${name.replace(/_/gi, ', ')}`);  
        window.speechSynthesis.speak(message);
  }

  function sayGoodbye() {
    const name = $('.timeInName').val() || $('.timeOutName').val();
    const message = new SpeechSynthesisUtterance(`Thank you and Goodbye, ${name.replace(/_/gi, ', ')}`);
        window.speechSynthesis.speak(message);
  }

  function sayRetry() {
    const message = new SpeechSynthesisUtterance(`Please Try Again`);
        window.speechSynthesis.speak(message);
  }

  //Get Current Date and Time
  const timeDiff = new Date().getTime() -  new Date("{{ $serverDateTime }}").getTime();
  
  function updateClock() {
    const now = new Date();
    const newDateTime = new Date(now.getTime() - timeDiff);
    const options = { hour12: false };
    const formattedDate = newDateTime.toLocaleDateString();
    const formattedTime = newDateTime.toLocaleTimeString();
    const registerTimeIn = newDateTime.toLocaleTimeString([], options);
    const registerTimeOut = newDateTime.toLocaleTimeString([], options);


    document.getElementById('currentTime').textContent = formattedTime;
    document.getElementById('currentDate').textContent = formattedDate;
    document.getElementById('realTimeIn').value = registerTimeIn;
    document.getElementById('realTimeOut').value = registerTimeOut;


  }
    // Update the clock every second (1000 milliseconds)
    setInterval(updateClock, 1000);



  document.addEventListener('DOMContentLoaded', function () {
      const login_button = document.getElementById('login_button');
      const logout_button = document.getElementById('logout_button');
      
  setTimeout(function () {
      login_button.removeAttribute('disabled');
      logout_button.removeAttribute('disabled');
    }, 3000);
  });


  
    

    //   // Obtain the user's location
    //   if (navigator.geolocation) {
    // navigator.geolocation.watchPosition(success, error);
    // } else {
    // document.getElementById('status_location').textContent = 'Geolocation is not supported by this browser.';
    // }

    // function success(position) {
    // const latitude = position.coords.latitude;
    // const longitude = position.coords.longitude;
    // document.getElementById('currentLongitude').textContent = 'Longitude: ' + longitude;
    // document.getElementById('currentLatitude').textContent = 'Latitude: ' + latitude;
    // checkGeofence(latitude, longitude);
    // }

    // function error() {
    // document.getElementById('status_location').textContent = 'Unable to retrieve the user\'s location.';
    // }

//     // Define geofence boundaries
//     const geofence = {
//     latitude: {!! $dataLocation->latitude !!},
//     longitude: {!! $dataLocation->longitude !!},
//     radius: 100 // in meters
//   };
  
//     // Check geofence crossing
//     function checkGeofence(latitude, longitude) {
//     const distance = getDistance(latitude, longitude, geofence.latitude, geofence.longitude);
//     if (distance <= geofence.radius) {
//         document.getElementById('status_location').textContent = 'Granted!';
//         // document.getElementById('popAccessPosition').style.display = 'none'

//         // Perform desired actions here
//     } else {
//         document.getElementById('status_location').textContent = 'Denied!';
//         // document.getElementById('popAccessPosition').style.display = ''
//     }
//     }

//         function getDistance(lat1, lon1, lat2, lon2) {
//   const earthRadius = 6371; // Earth's radius in kilometers

//   // Convert latitude and longitude values from degrees to radians
//     const lat1Rad = toRadians(lat1);
//     const lon1Rad = toRadians(lon1);
//     const lat2Rad = toRadians(lat2);
//     const lon2Rad = toRadians(lon2);

//     // Calculate the differences between the latitudes and longitudes
//     const latDiff = lat2Rad - lat1Rad;
//     const lonDiff = lon2Rad - lon1Rad;

//   // Apply the Haversine formula
//   const a = Math.sin(latDiff / 2) * Math.sin(latDiff / 2) +
//             Math.cos(lat1Rad) * Math.cos(lat2Rad) *
//             Math.sin(lonDiff / 2) * Math.sin(lonDiff / 2);
//   const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
//   const distance = earthRadius * c;

//   return distance * 1000; // Convert distance to meters
// }

// function toRadians(degrees) {
//   return degrees * (Math.PI / 180);
// }








</script>








{{-- 
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Face Biometric Attendance</title>
  <link rel="icon" href="/Img/Face.png" type="image/x-icon">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="{{asset('js/jquery.js')}}"></script>
  <script  src="{{asset('./js/sweetalert.js')}}"></script>
  <script defer src="{{asset('face-api.min.js')}}"></script>
  <script defer src="{{asset('script.js')}}"></script>



  <link rel="stylesheet" href="styleAttendance.css">
  

</head>
<body>
    <div class="main">
        <div class="first_column">
            <div class="instruction_panel">
            </div>
            <div class="redirect_button">
                <a href="login" id="redirect_login">Return Home Page</a>
            </div>
        </div>
        <div class="second_column">
            <div class="upper_title">
                <h2>Face Biometric Attendance System</h2>
            </div>
            <div class="cameraWrapper">
                <video id="video" width="700" height="550" autoplay></video>
            </div>
            <hr style="height:2px;border-width:0;background-color:#338384">
            <br>
            <br>
            <br>
            <div class="face_detect_bar">
                <span class="info_label" style="color:black;"> Confidence: <span id="confidence" style="color: black;"></span></span>
            </div>
            <div class="info_panel">
                <div class="date_panel">
                    Date: <span id="currentDate"></span>
                </div>
                <div class="time_panel">
                    Time: <span id="currentTime"></span></span>
                </div>
                <div class="store_panel">
                    <span class="info_label" >Store Location:</span>
                    <span id="location_display">{{ $dataLocation->store_location }}</span>
                </div>
            </div>
        </div>
        <div class="third_column">
            <div class="activity_log_panel">
                <form action="{{ route('attendanceLogin') }}" method="POST">
                @csrf
                </form>
            </div>
        </div>  
    </div>

<script>

  // let confidenceLevel;

  $(document).ready(function(){
    $("#login_button").on("click", function(){
      const numberConfidenceLevel = parseFloat(confidenceLevel);
      if (numberConfidenceLevel > 60) {
        $.ajax({
          url: "{{ route('getTime') }}",
          type: "GET",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response){
            console.log(response.time);
            $('#24FormatTime_In').text(response.time);
            $('#24FormatTimeIn').val(response.time);
          },
          error: function(response){
            console.log(response);
          }

        });

      const logType = $(this).val();
      $('#register .logTypeInput').val(logType);
      const video = document.getElementById('video');

      // Create a canvas element to draw the video frame
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const context = canvas.getContext('2d');

      // Draw the current video frame on the canvas
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to base64 data URL
      const imageDataUrl = canvas.toDataURL('image/png');

      $('#image_url').val(imageDataUrl);
      $(".popLoginPosition").show();
      const store = $("#location").val();
      $("#showLocation").text(store);
      $(".timeInLocation").val(store);
      $("#video").get(0).pause();
      sayWelcome();
      $('#confirm_login').on('click', function(){
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Attendance Successfully Registered!',
            showConfirmButton: false,
            timer: 2500,
            background: '#FFFFFF',
            customClass: {
              popup: 'swal-border',
              title: 'swal-title'
            },
            imageUrl:imageDataUrl,
            imageWidth:400,
            imageHeight:300,
            imageAlt: 'Attendance Image',
          });
      });
    } else {
        sayRetry();
        $(".popRetryPosition").show();
        setTimeout(function() {
          $(".popRetryPosition").fadeOut();
        }, 1000);
    }  
  });

      $("#cancel_login").on("click", function(){
        $("#video").get(0).play();
        $(".popLoginPosition").hide();
      })

      $("#logout_button").on("click", function(){
        const numberConfidenceLevel = parseFloat(confidenceLevel);
        if(numberConfidenceLevel > 60) {
          $.ajax({
          url: "{{ route('getTime') }}",
          type: "GET",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response){
            console.log(response.time);
            $('#24FormatTime_Out').text(response.time);
            $('#24FormatTimeOut').val(response.time);
          },
          error: function(response){
            console.log(response);
          }

        });
          const logType = $(this).val();
          $('#register .logTypeInput').val(logType);
          const video = document.getElementById('video');

          // Create a canvas element to draw the video frame
          const canvas = document.createElement('canvas');
          canvas.width = video.videoWidth;
          canvas.height = video.videoHeight;
          const context = canvas.getContext('2d');

          // Draw the current video frame on the canvas
          context.drawImage(video, 0, 0, canvas.width, canvas.height);

          // Convert the canvas image to base64 data URL
          const imageDataUrl = canvas.toDataURL('image/png');

          $('#image_url').val(imageDataUrl);
          $(".popLogoutPosition").show(); 
          const store = $("#location").val();
          $("#showLocationOut").text(store);
          $(".timeInLocation").val(store);
          $("#video").get(0).pause();
          sayGoodbye();
          $('#confirm_logout').on('click', function(){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Attendance Successfully Registered!',
                showConfirmButton: false,
                timer: 2500,
                background: '#FFFFFF',
                customClass: {
                  popup: 'swal-border',
                  title: 'swal-title'
                },
                imageUrl:imageDataUrl,
                imageWidth:400,
                imageHeight:300,
                imageAlt: 'Attendance Image',
              });
          });
        } else{
            sayRetry();
            $(".popRetryPosition").show();
            setTimeout(function() {
              $(".popRetryPosition").fadeOut();
            }, 1000);
        }
        
      })

      $("#cancel_logout").on("click", function(){
        $("#video").get(0).play();
        $(".popLogoutPosition").hide();
      })
    })


  $('#confirm_login, #confirm_logout').on('click', function(event) {
    $('.submit-log').click();
});




  function sayWelcome() {
    const name = $('.timeInName').val() || $('.timeOutName').val();
    const message = new SpeechSynthesisUtterance(`Welcome, ${name.replace(/_/gi, ', ')}`);  
        window.speechSynthesis.speak(message);
  }

  function sayGoodbye() {
    const name = $('.timeInName').val() || $('.timeOutName').val();
    const message = new SpeechSynthesisUtterance(`Thank you and Goodbye, ${name.replace(/_/gi, ', ')}`);
        window.speechSynthesis.speak(message);
  }

  function sayRetry() {
    const message = new SpeechSynthesisUtterance(`Please Try Again`);
        window.speechSynthesis.speak(message);
  }

  //Get Current Date and Time
  const timeDiff = new Date().getTime() -  new Date("{{ $serverDateTime }}").getTime();
  
  function updateClock() {
    const now = new Date();
    const newDateTime = new Date(now.getTime() - timeDiff);
    const options = { hour12: false };
    const formattedDate = newDateTime.toLocaleDateString();
    const formattedTime = newDateTime.toLocaleTimeString();
    const registerTimeIn = newDateTime.toLocaleTimeString([], options);
    const registerTimeOut = newDateTime.toLocaleTimeString([], options);


    document.getElementById('currentTime').textContent = formattedTime;
    document.getElementById('currentDate').textContent = formattedDate;
    document.getElementById('realTimeIn').value = registerTimeIn;
    document.getElementById('realTimeOut').value = registerTimeOut;


  }
    // Update the clock every second (1000 milliseconds)
    setInterval(updateClock, 1000);



  document.addEventListener('DOMContentLoaded', function () {
      const login_button = document.getElementById('login_button');
      const logout_button = document.getElementById('logout_button');
      
  setTimeout(function () {
      login_button.removeAttribute('disabled');
      logout_button.removeAttribute('disabled');
    }, 3000);
  });




</script>









</body>
</html> --}}