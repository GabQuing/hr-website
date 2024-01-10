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
<style>
body{
    background: url(img/contact_background.jpg);
    background-size: cover;
    background-repeat: no-repeat;
}
</style>

<body>
<div class="main">
    <div class="contact_main_frame">
        <div class="hr_first_column">
            <h2 id="deniedLabel">Contact Us:</h2>
            <hr>
            <br>
            <div class="first_contact">
            <div class="person_picture"><img src="{{ asset('img/Quing_Gabriel.jpg') }}" alt=""></div>
            <div class="first_person_information">
                <div>Name: Quing, Gabriel Camerone</div>
                <div>Contact Number: 09155094944</div>
                <div>Email: gabrielcameronequing@digits.ph</div>
            </div>
            </div>
            <br>
            <div class="second_contact">
                <div class="second_person_information">
                    <div>Name: Punzalan, Patrick Lester</div>
                    <div>Contact Number: 09123456787</div>
                    <div>Email: patrickpunzalan@digits.ph</div>
                </div>
                <div class="person_picture"><img src="{{ asset('img/my_photo.png') }}" alt=""></div>
            </div>
            <div class="homePanel">
                <a id="homeButton" href="login">Return Home Page</a>
            </div>
        </div>
    <div class="hr_second_column">
        <img src="{{ asset('/img/HR_picture.jpg') }}" alt="" id="imgLocked">
    </div>
    </div>
</div>


</body>
</html>

<script>   
window.addEventListener("load", function() {
    var contactMainFrame = document.querySelector(".contact_main_frame");
    contactMainFrame.classList.add("fade-in");
});

</script>