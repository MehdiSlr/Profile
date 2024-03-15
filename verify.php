<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style.css">
    <title>Profile Information</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(!isset($_SESSION['code'])) // check if user not registered and verification code is not sent
    {
        header('location: index.php'); // redirect to redirect page
    }
?>
<body>
    <section>
        <h1>Email Verification</h1>
        <form action="#" method="post">
            <label>Sent to "<?php echo $_SESSION['email']; ?>"</label> <!-- display user's email address -->
            <div class="input-control">
                <label>Verification Code</label>
                <input type="text" placeholder="Enter OTP" name="otp"/>
                <i class="uil uil-dialpad-alt"></i>
                <span id="resend"></span>
            </div>
            <input class="btn" type="submit" value="Submit" name="submit"/>
        </form>
    </section>
</body>
<?php
    if(isset($_POST['submit'])) // if submit button is clicked
    {
        $otp = $_POST['otp'];
        if($otp == $_SESSION['code']) // check if verification code is correct
        {
            $sql = "INSERT INTO pers (user, email, psw) VALUES ('$_SESSION[user]', '$_SESSION[email]', '$_SESSION[pass]')"; // insert user data into database
            $result = mysqli_query($conn, $sql);

            $ssql = "SELECT * FROM pers WHERE email = '$_SESSION[email]'"; // get user id from database - start
            $sresult = mysqli_query($conn, $ssql);
            $srow = mysqli_fetch_assoc($sresult); // get user id from database - end
            $_SESSION['register'] = $srow['id']; // set user id in session if user left the "info" page
            unset($_SESSION['code']); // unset verification code from session
            header("Location: info.php");
        }
        else
        {
            echo "<script>alert('Incorrect email verification code!')</script>";
        }
    }
?>
<script> // timer for resend email verification code
    var seconds=1;
    var timer;
    function myFunction() {
    if(seconds < 60) { // I want it to say 1:00, not 60
        document.getElementById("timer").innerHTML = seconds;
    }
    if (seconds >0 ) { // so it doesn't go to -1
        seconds--;
    } else {
        clearInterval(timer);
        document.getElementById("resend").innerHTML="<label> Click <a href='?resend=true'>Here</a> to resend verification code.</label>"; 
    }
    }

    if(!timer) {
        timer = window.setInterval(function() { 
        myFunction();
        }, 1000); // every second
    }

    document.getElementById("resend").innerHTML="<label> Wait for <span id='timer'></span> seconds to resend.</label>";
    document.getElementById("timer").innerHTML="60"; 
</script>
<?php // resend email verification code
    if(isset($_GET['resend'])) // if resend button is clicked
    {
        $code = rand(0,99999);
        $_SESSION['code'] = $code; // set the NEW verification code in session 
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        include "./conf/mail_conf.php"; //send verification code
    }
?>
</html>