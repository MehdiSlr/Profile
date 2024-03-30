<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Reset Password</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(isset($_SESSION['login'])) // check if user is already logged in
    {
        header('location: profile.php');
    }

    if(!isset($_SESSION['reset'])) // check if user is not resetting password
    {
        header('location: verify.php');
    }
    else
    {
        if(isset($_POST['reset'])) // if reset button is clicked
        {
            $pass = $_POST['password'];
            $pass_conf = $_POST['confirm_password'];

            if($password == $confirm_password) // if passwords match
            {
                $pass = md5($pass); // encrypt password
                $sql = "UPDATE pers SET psw = '$pass' WHERE email = '$_SESSION[email]'";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    unset($_SESSION['reset']); // unset reset session
                    header('location: login.php');
                }
                else
                {
                    echo "<script>Swal.fire({icon: 'error', title: 'Error".$conn->error."'});</script>";
                }
            }
            else
            {
                $pass_error = '<label style="color: #a42d5c; font-weight: bold;">'.'Passwords do not match!'.'</label>';
            }
        }
    }
?>
<body>
    <section>
        <h1>Reset Password</h1>
        <form action="#" method="post">
            <div class="input-control">
                <label>New Password</label>
                <input type="password" placeholder="Password" name="password" required autofocus/>
                <i class="uil uil-lock-alt"></i>
            </div>
            <div class="input-control">
                <label>Confirm New Password</label>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required/>
                <i class="uil uil-lock-alt"></i>
                <?php if(isset($pass_error)) echo $pass_error; ?>
            </div>
            <input class="btn" type="submit" value="Reset" name="reset"/>
        </form>
    </section>
</body>

</html>