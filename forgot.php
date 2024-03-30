<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <title>Forgot Password</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login'])) // check if user is already logged in
    {
        header('location: profile.php');
    }

    // if(isset($_SESSION['code'])) // check if verification code is already sent
    // {
    //     $email_property = 'value="'.$_SESSION['email'].'" disabled'; // disable email input
    //     $otp_property = "required autofocus"; // enable otp input
    //     $btn_property = 'value="Submit" name="submit"';
    //     $script = '<script src="script.js"></script>';
    // }
    // else
    // {
    //     $email_property = "autofocus"; // focus email input
    //     $otp_property = "disabled"; // disable otp input
    //     $btn_property = 'value="Send" name="send"';
    // }
    
    if(isset($_POST['submit'])) // if send button is clicked
    {
        $email = $_POST['email']; // get email from form
        $sql = "SELECT * FROM pers WHERE email = '$email'"; // check if email exist in database
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) // if email exist
        {
            $row = mysqli_fetch_assoc($result);
            $user = $row['user']; // save user in variable
            $code = rand(0,99999); //generate verification code
            include "./conf/mail_conf.php"; //send email verification code
            $_SESSION['user'] = $user; // save user in session
            $_SESSION['email'] = $email; // save email in session
            $_SESSION['code'] = $code; // set verification code in session
            $_SESSION['reset'] = $row['id']; // set user id in session
            header("Location: verify.php");
        }
        else
        {
            $email_error = '<label style="color: #a42d5c; font-weight: bold;">'.'Email does not exist!'.'</label>';
        }
    }
?>
<body>
    <section>
        <h1>Forgot Password</h1>
        <form action="" method="post">
            <div class="input-control">
                <label>Email</label>
                <input type="text" placeholder="ex. john@example.com" name="email" required autofocus />
                <i class="uil uil-envelope"></i>
                <?php if(isset($email_error)) echo $email_error; ?>
            </div>
            <!-- <div class="input-control">
                <label>Verification Code</label>
                <input type="text" placeholder="Enter OTP" name="otp" <?php echo $otp_property; ?>/>
                <i class="uil uil-dialpad-alt"></i>
                <?php if(isset($otp_error)) echo $otp_error; ?>
                <span id="resend"></span>
            </div> -->
            <input class="btn" type="submit" value="Submit" name="submit"/>
        </form>
    </section>
</body>
<!-- <?php 
    if(isset($script)) echo $script; 
    if(isset($_GET['resend'])) // if resend is clicked
    {
        $code = rand(0,99999);
        $_SESSION['code'] = $code; // set the NEW verification code in session 
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        include "./conf/mail_conf.php"; //send verification code
    }
?> -->
</html>