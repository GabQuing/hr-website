<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Face Biometric Registration</title>
  <link rel="icon" href="/img/Digits.png" type="image/x-icon">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
  <link rel="stylesheet" href={{ asset("css/regFace.css") }} type="text/css">

</head>

<body>
<div class="main">
  <form id="register" method="POST" action="{{ route('get-image') }}">
    @csrf
    <div class="register">
        <div class="first_column">
          <img src="{{ asset('/img/face_scan.jpg') }}" alt="" id="img_biometric">
          <br>
          <div id="redirect_button">
            <a href="/change_password/{{ $id }}" id="redirect_login">Return Back</a>
          </div>
        </div>
        {{-- <br><br> --}}
        <div class="second_column">
          <h2>Face Biometric Registration</h2>
          <label id="instructions">FACE AND LOOK AT THE CAMERA:</Label>
          <label id ="pose" style=" display: none;"><em>Smile At the Camera!</em></label>
          <div id="my_camera"></div>
          {{-- <br><br><br><br><br><br><br> --}}
          <div id="btn_ctrl">
            <div class="capture_btn">
              <input type=button value="Reset Image" id="reset" onClick="resetImage()" disabled>
              <button type=button value="SNAP!" id="first_capture" onClick="captureImage()" >
                <span class="material-symbols-outlined" style="font-size: 50px;color:rgb(255, 255, 255);" >photo_camera</span>
              </button>
              <button class="btn btn-success" id ="submit" disabled>Submit</button>
            </div>
            {{-- <br> --}}
            <label id="instructions_2"> <em> Important! : Take <strong>2</strong> Pictures to Submit </em></label>
          </div>
        </div>
        <div class="third_column" >
          <input type="hidden" name="image" id="image" class="image-tag">
          <input type="hidden" name="image1" id="image1" class="image-tag1">
          <input type="hidden" name="id" value={{ $id }}>
          <div id="results"></div>
          <div id="results1"></div>
        </div>

      </div>
    </form>
  </div>


<script>

  $(document).ready(function(){
    $('#my_camera').find('video').css({'height' : 400, 'width' : 525})
  })

  Webcam.set({
    width: 525,
    height: 400,
    image_format: 'jpeg',
    jpeg_quality: 90,
    position: 'absolute'
  });

  Webcam.attach( '#my_camera' );


  let pic1HasTaken = false;

  function captureImage() {
    let elem;
    let imageTag;
    if (pic1HasTaken) {
      elem = '#results1';
      imageTag = '.image-tag1'
      $('#first_capture').attr('disabled', true);
      $('#first_capture').find("span").css('color', "Grey");
      $('#submit').attr('disabled', false);
    } else {
      elem = '#results';
      imageTag = '.image-tag';
      $("#reset").attr('disabled', false);
      $('#pose').show()
    }
    Webcam.snap( function(data_uri) {
      $(imageTag).val(data_uri);
      // document.getElementById(elem).innerHTML = '<img src="'+data_uri+'"/>';
      $(elem).fadeOut(0).html('<img src="'+data_uri+'"/>').fadeIn(300);

    });
    pic1HasTaken = true;
  }

  function resetImage(){
    $("#results, #results1").html("")
    $('#first_capture').attr('disabled', false);
    pic1HasTaken = false;
    $('#reset').attr('disabled', true);
    $('#submit').attr('disabled', true);
    $('#first_capture').find("span").css('color', "rgb(255, 255, 255)");
    $('#pose').hide()
  }

  console.log(document.getElementById('image').value)

</script>






</body>
</html>