<?php
    if (isset($_SESSION['login']))
    {
        header("Location: profile.php");
    }
    else if (isset($_SESSION['register']))
    {
        header("Location: info.php");
    }
    else if (isset($_COOKIE['login']))
    {
        header("Location: profile.php");
    }
    else
    {
        header("Location: register.php");
    }
?>