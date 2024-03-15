<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style.css">
    <title>Profile Register</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login']))
    {
        header('location: profile.php');
    }
?>
<body>
    <section>
        <h1>Register Form</h1>

        <form action="#" method="post">
            <div class="input-control">
                <label>Username</label>
                <input type="text" placeholder="ex. john" name="username" required/>
                <i class="uil uil-at"></i>
            </div>
            <div class="input-control">
                <label>Email</label>
                <input type="email" placeholder="ex. john@example.com" name="email" required/>
                <i class="uil uil-envelope"></i>
            </div>
            <div class="input-control">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password"required/>
                <i class="uil uil-lock-alt"></i>
            </div>
            <div class="input-control">
                <label>Confirm Password</label>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required/>
                <i class="uil uil-lock-alt"></i>
            </div>
            <input class="btn" type="submit" value="Register" name="register"/>
            <label class="register">Already have an account? <a href="login.php">Login</a></label>
        </form>
    </section>
</body>
<?php
    if(isset($_POST['register'])){
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $pass_conf = $_POST['confirm_password'];

        $usql = "SELECT * FROM pers WHERE user = '$user'";
        $uresult = mysqli_query($conn, $usql);

        $esql = "SELECT * FROM pers WHERE email = '$email'";
        $eresult = mysqli_query($conn, $esql);

        if(mysqli_num_rows($uresult) > 0)
        {
            echo "<script>alert('Username already taken!')</script>";
        }
        else if(mysqli_num_rows($eresult) > 0)
        {
            echo "<script>alert('Email already taken!')</script>";
        }
        else if($pass != $pass_conf)
        {
            echo "<script>alert('Passwords do not match!')</script>";
        }
        else{
            $pass = md5($pass);
            $code = rand(0,99999);
            include "./conf/mail_conf.php"; //send email verification code
            $_SESSION['user'] = $user;
            $_SESSION['email'] = $email;
            $_SESSION['pass'] = $pass;
            $_SESSION['code'] = $code;
            header("Location: verify.php");
        }
        
    }
?>
</html>