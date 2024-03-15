<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style.css">
    <title>Profile Login</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login']))
    {
        header("Location: profile.php");
    }
?>
<body>
    <section>
        <h1>Login Form</h1>

        <form action="#" method="post">
            <div class="input-control">
                <label>Username</label>
                <input type="text" placeholder="Email or Username" name="username"/>
                <i class="uil uil-at"></i>
            </div>
            <div class="input-control">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password"/>
                <i class="uil uil-lock-alt"></i>
            </div>
            <input class="btn" type="submit" value="Login" name="login"/>
            <label class="register">Don't have an account? <a href="register.php">Register</a></label>
        </form>
    </section>
</body>
<?php
    if(isset($_POST['login'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $pass = md5($pass);
        $sql = "SELECT * FROM pers WHERE user = '$user' AND psw = '$pass'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['login'] = $row['id'];
            header("Location: profile.php");
        }
        else
        {
            echo "<script>alert('Incorrect username or password!')</script>";
        }
    }
?>
</html>