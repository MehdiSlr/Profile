<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        setcookie("login", $id, time() + 60*60*24*30, "/"); // set user id in cookie for 30 days to no need to login again
        
        $sql = "SELECT * FROM pers WHERE id = '$id'"; // get user data from database from user id
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['phone'] == "") // check if phone not set
        {
            $row['phone'] = "Not set";
        }
        // display user data
        echo "Welcome, " . $row['fname'] . " " . $row['lname'] . "<br>";
        echo "Username: " . $row['user'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Phone: " . $row['phone'] . "<br>";
    ?>
    <a href="logout.php">Logout</a> <!-- logout link -->
</body>
</html>