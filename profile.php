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
    <!-- <?php
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

        if($row['job'] == "") // check if phone not set
        {
            $row['job'] = "Not set";
        }
        // display user data
        echo "Welcome, " . $row['fname'] . " " . $row['lname'] . "<br>";
        echo "Username: " . $row['user'] . "<br>"; 
        echo "Email: " . $row['email'] . "<br>";
        echo "Job Title: " . $row['job'] . "<br>";
    ?> -->
    <section>
        <form>
            <div>
                <div class="header">
                    <img src="./assets/pics/pro.jpg">
                    <div>
                        <h1> Negar Ebrahimi</h1>
                        <h3>UI/UX Designer</h3>
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
                                <h2>Negarebr</h2>
                            </div>
                            <div class="profile-body">
                                <h4>Job Title</h4>
                                <h2>UI/UX Designer</h2>
                            </div>
                            <div class="profile-body">
                                <h4>Birth Date</h4>
                                <h2>September 2, 2002</h2>
                            </div>
                        </div>
                        <div class="profile-row">
                            <div class="profile-body">
                                <h4>E-mail</h4>
                                <h2>Negarebhimi11@gmail.com</h2>
                            </div>

                            <div class="profile-body">
                                <h4>Biography</h4>
                                <h5>Hello. My name is negar and this ui that you can see now is my job</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btns">
                <input class="logout-btn" type="button" value="Logout" onclick="#">
                </div>
            </div>
        </form>
    </section>
</body>
</html>