<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/prostyle.css">
</head>
<body>
    <?php
        session_start();
        include "./conf/serv_conf.php";

        if(!isset($_SESSION['login'])) // check if user not logged in redirect to index
        {
            header('location: index.php');
        }

        $id = $_SESSION['login']; // get user id from session
        setcookie("login", $id, time() + 365*24*60*60, "/"); // set user id in cookie for 30 days to no need to login again
        
        $sql = "SELECT * FROM pers WHERE id = '$id'"; // get user data from database from user id
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['fname'] == "" and $row['lname'] == "") // check if first and last name not set
        {
            header('location: info.php'); //redirect to info page to set first and last name
        }

        if($row['job'] == "") // check if job not set
        {
            $row['job'] = "Not set";
        }
        if($row['bio'] == "") // check if bio not set
        {
            $row['bio'] = "Not set";
        }
        if($row['pic_adrs'] == "") // check if profile picture not set
        {
            $row['pic_adrs'] = "https://s3.amazonaws.com/37assets/svn/765-default-avatar.png";
        }
        if($row['birth'] == "") // check if birth date not set
        {
            $row['birth'] = "Not set";
        }
        $fname = $row['fname'];
        $lname = $row['lname'];
        $user = $row['user'];
        $email = $row['email'];
        $job = $row['job'];
        $bio = $row['bio'];
        $pic_adrs = $row['pic_adrs'];
        $birth = $row['birth'];

        
    ?>
    <section>
        <form>
            <div>
                <div class="header">
                    <img src="<?php echo $pic_adrs; ?>">
                    <div>
                        <h1><?php echo $fname." ".$lname; ?></h1>
                        <h3><?php echo $job; ?></h3>
                    </div>
                    <a href="edit.php">
                        <i class="uil uil-pen"></i>
                    </a>
                </div> 
                <div class="line"></div>
                    <div class="profile-cl">

                        <div class="profile-row"> 
                            <div class="profile-body">
                                <h4>Username</h4>
                                <h2><?php echo $user; ?></h2>
                            </div>
                            <div class="profile-body">
                                <h4>Job Title</h4>
                                <h2><?php echo $job; ?></h2>
                            </div>
                            <div class="profile-body">
                                <h4>Birth Date</h4>
                                <h2><?php echo $birth; ?></h2>
                            </div>
                        </div>
                        <div class="profile-row">
                            <div class="profile-body">
                                <h4>E-mail</h4>
                                <h2><?php echo $email; ?></h2>
                            </div>

                            <div class="profile-body">
                                <h4>Biography</h4>
                                <h5><?php echo $bio; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btns">
                <input class="logout-btn" type="button" value="Logout" onclick="location.href='logout.php'">
                </div>
            </div>
        </form>
    </section>
</body>
</html>