<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(!isset($_SESSION['code']))
    {
        header('location: index.php');
    }

?>
<body>
    <form action="#" method="POST">
        Enter email verification code:<input type="text" name="otp" placeholder="Enter OTP">
        <input type="submit" value="Submit" name="submit">
        <!-- <a href="register.php">Register</a> -->
        <button onclick="myFunction()">Resend</button>
        <div id="resend">
            Wait for <span id="timer"></span> seconds to resend.
        </div>
    </form>
</body>
<?php
    if(isset($_POST['submit']))
    {
        $otp = $_POST['otp'];
        if($otp == $_SESSION['code'])
        {
            // header('location: login.php');
            echo "Correct email verification code";

            $sql = "INSERT INTO pers (user, email, psw) VALUES ('$_SESSION[user]', '$_SESSION[email]', '$_SESSION[pass]')";
            $result = mysqli_query($conn, $sql);

            $ssql = "SELECT * FROM pers WHERE email = '$_SESSION[email]'";
            $sresult = mysqli_query($conn, $ssql);
            $srow = mysqli_fetch_assoc($sresult);
            $_SESSION['login'] = $srow['id'];
            
            header("Location: info.php");
        }
        else
        {
            echo "<script>alert('Incorrect email verification code!')</script>";
        }
    }
?>
<script>
    var seconds=59;
    var timer;
    function myFunction() {
    if(seconds < 60) { // I want it to say 1:00, not 60
        document.getElementById("timer").innerHTML = seconds;
    }
    if (seconds >0 ) { // so it doesn't go to -1
        seconds--;
    } else {
        clearInterval(timer);
        //  alert("You type X WPM");
        // document.getElementById("timer").innerHTML="<button name='resend'>Resend</button>";
        document.getElementById("resend").innerHTML="Click <a href='?resend=true'>Here</a> to resend verification code."; 
    }
    }

    if(!timer) {
        timer = window.setInterval(function() { 
        myFunction();
        }, 1000); // every second
    }

    document.getElementById("resend").innerHTML="Wait for <span id='timer'></span> seconds to resend.";
    document.getElementById("timer").innerHTML="60"; 
</script>
<?php
    if(isset($_GET['resend']))
    {
        // echo "Resend";
        $code = rand(0,99999);
        $_SESSION['code'] = $code;
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];

        // require_once __DIR__.'/mail/vendor/autoload.php';
        // require_once __DIR__.'/mail/config.php';

        // $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        //     try {
        //         // Server settings
        //         $mail->setLanguage(CONTACTFORM_LANGUAGE);
        //         $mail->SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
        //         $mail->isSMTP();
        //         $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
        //         $mail->SMTPAuth = true;
        //         $mail->Username = CONTACTFORM_SMTP_USERNAME;
        //         $mail->Password = CONTACTFORM_SMTP_PASSWORD;
        //         $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
        //         $mail->Port = CONTACTFORM_SMTP_PORT;
        //         $mail->CharSet = CONTACTFORM_MAIL_CHARSET;
        //         $mail->Encoding = CONTACTFORM_MAIL_ENCODING;
            
        //         // Recipients
        //         $mail->setFrom(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);
        //         $mail->addAddress($email, $user);
        //         $mail->addReplyTo($email, $user);
            
        //         // Content
        //         $mail->Subject = "Your verification code";
        //         $mail->Body    = <<<EOT
        //     Hi {$user}
        //     Email: {$email}
            
        //     -------------------------------
        //     Your verification code is: $code
        //     EOT;
            
        //         $mail->send();
        //         echo '<script>alert("Email verification code has been sent")</script>'; // Message has been sent';
        //     } 
        //     catch (Exception $e) {
        //         echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>"; // Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        //     }
        include "./conf/mail_conf.php";
    }
?>

</html>