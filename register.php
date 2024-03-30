<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <title>Profile Register</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login'])) // check if user is already logged in
    {
        header('location: profile.php');
    }

    if(isset($_POST['register'])) // if register button is clicked
    {
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $pass_conf = $_POST['confirm_password'];

        $usql = "SELECT * FROM pers WHERE user = '$user'";
        $uresult = mysqli_query($conn, $usql);

        $esql = "SELECT * FROM pers WHERE email = '$email'";
        $eresult = mysqli_query($conn, $esql);

        if(mysqli_num_rows($uresult) > 0) // check if username is already taken
        {
            $user_error = '<label style="color: #a42d5c; font-weight: bold;">'.'Username already taken!'.'</label>';
        }
        else if(mysqli_num_rows($eresult) > 0) // check if email is already taken
        {
            $email_error = '<label style="color: #a42d5c; font-weight: bold;">'.'Email already taken!'.'</label>';
        }
        else if($pass != $pass_conf) // check if passwords not match
        {
            $pass_error = '<label style="color: #a42d5c; font-weight: bold;">'.'Passwords do not match!'.'</label>';
        }
        else{
            $pass = md5($pass); //encrypt password
            $code = rand(0,99999); //generate verification code
            include "./conf/mail_conf.php"; //send email verification code
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $email;
            $_SESSION['pass'] = $pass;
            $_SESSION['code'] = $code; // set verification code in session
            header("Location: verify.php");
        }
    }
?>
<body>
    <section>
        <h1>Register Form</h1>
        <form action="#" method="post">
            <div class="input-control">
                <label>Username</label>
                <input type="text" placeholder="ex. john" name="username" required autofocus/>
                <i class="uil uil-at"></i>
                <?php if(isset($user_error)) echo $user_error; ?>
            </div>
            <div class="input-control">
                <label>Email</label>
                <input type="email" placeholder="ex. john@example.com" name="email" required/>
                <i class="uil uil-envelope"></i>
                <?php if(isset($email_error)) echo $email_error; ?>
            </div>
            <div class="input-control">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password" required/>
                <i class="uil uil-lock-alt"></i>
            </div>
            <div class="input-control">
                <label>Confirm Password</label>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required/>
                <i class="uil uil-lock-alt"></i>
                <?php if(isset($pass_error)) echo $pass_error; ?>
            </div>
            <input class="btn" type="submit" value="Register" name="register"/>
            <label class="register">Already have an account? <a href="login.php">Login</a></label>
        </form>
    </section>
</body>

</html>