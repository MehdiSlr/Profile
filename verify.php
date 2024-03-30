<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Verify Email</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(!isset($_SESSION['code'])) // check if user not registered and verification code is not sent
    {
        header('location: index.php'); // redirect to index page
    }

    if(isset($_POST['submit'])) // if submit button is clicked
    {
        $otp = $_POST['otp'];
        if($otp == $_SESSION['code']) // check if verification code is correct
        {
            if(isset($_SESSION['reset'])) // check if user is resetting password
            {
                unset($_SESSION['code']); // unset verification code from session
                header("Location: reset.php");
            }
            else
            {
                $sql = "INSERT INTO pers (user, email, psw) VALUES ('$_SESSION[user]', '$_SESSION[email]', '$_SESSION[pass]')"; // insert user data into database
                $result = mysqli_query($conn, $sql);

                $ssql = "SELECT * FROM pers WHERE email = '$_SESSION[email]'"; // get user id from database - start
                $sresult = mysqli_query($conn, $ssql);
                $srow = mysqli_fetch_assoc($sresult); // get user id from database - end
                $_SESSION['login'] = $srow['id']; // set user id in session if user left the "info" page
                unset($_SESSION['code']); // unset verification code from session
                header("Location: info.php");
            }
        }
        else
        {
            $error = '<label style="color: #a42d5c; font-weight: bold;">'.'Wrong verification code!'.'</label>';
        }
    }

    if($i = "resend") // if resend is clicked
    {
        $code = rand(0,99999);
        $_SESSION['code'] = $code; // set the NEW verification code in session 
        $user = $_SESSION['user'];
        $email = $_SESSION['email'];
        include "./conf/mail_conf.php"; //send verification code
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
                <?php if(isset($error)) echo $error; ?>
                <span id="resend"></span>
            </div>
            <input class="btn" type="submit" value="Submit" name="submit"/>
        </form>
    </section>
</body>
<script src="script/script.js"></script>
</html>