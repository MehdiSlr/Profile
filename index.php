<!-- this page just redirect user to the right place -->
<?php
    session_start();
    if (isset($_SESSION['login'])) // check if user is already logged in redirect to profile
    {
        header("Location: profile.php");
    }
    else if (isset($_SESSION['register'])) // check if user is already submitted email redirect to set info
    {
        header("Location: info.php");
    }
    else if (isset($_COOKIE['login'])) // check if user is already logged in redirect to profile
    {
        header("Location: login.php");
    }
    else // redirect to register
    {
        header("Location: register.php");
    }
?>