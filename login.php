<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Profile Login</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login'])) //check if user is already logged in
    {
        header("Location: profile.php");
    }

    if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])) //check if user credentials are saved
    {
        $sql = "SELECT * FROM pers WHERE user = '$_COOKIE[user]' AND psw = '$_COOKIE[pass]'"; //check user credentials from cookies
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) //if credentials are correct
            {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['login'] = $row['id'];
                header("Location: profile.php");
            }
    }

    if(isset($_POST['login'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $pass = md5($pass);
        $sql = "SELECT * FROM pers WHERE user = '$user' OR email = '$user'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) //check username and password
        {
            $row = mysqli_fetch_assoc($result);
            if($row['psw'] == $pass)
            {
                $_SESSION['login'] = $row['id'];
                if(isset($_POST['remember'])){
                    setcookie("user", $user, time() + (14 * 24 * 60 * 60), "/");
                    setcookie("pass", $pass, time() + (14 * 24 * 60 * 60), "/");
                }
                header("Location: profile.php");
            }
            else
            {
                $error = "<script>Swal.fire({icon: 'error', title: 'Incorrect username or password!'});</script>";
            }
        }
        else
        {
            echo "<script>Swal.fire({icon: 'error', title: 'Incorrect username or password!'});</script>";
        }
    }
?>
<body>
    <section>
        <h1>Login Form</h1>

        <form action="#" method="post">
            <div class="input-control">
                <label>Email or Username</label>
                <input type="text" placeholder="Email or Username" name="username" required autofocus/>
                <i class="uil uil-at"></i>
            </div>
            <div class="input-control">
                <label>Password</label>
                <input type="password" placeholder="Password" name="password" required/>
                <i class="uil uil-lock-alt"></i>
                <?php if(isset($error)){ echo $error; } ?>
                <label><a href="forgot.php">Forgot Password?</a></label>
            </div>
            <div class="remember">
                <label class="forgot">Save your credentials?</label>
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="remember">
                    <svg viewBox="0 0 35.6 35.6">
                        <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                        <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                        <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                    </svg>
                </div>
            </div>
            <input class="btn" type="submit" value="Login" name="login"/>
            <label class="register">Don't have an account? <a href="register.php">Register</a></label>
        </form>
    </section>
</body>
</html>