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

        if(!isset($_SESSION['login']))
        {
            header('location: index.php');
        }

        $id = $_SESSION['login'];
        setcookie("login", $id, time() + 60*60*24*30, "/");
        
        $sql = "SELECT * FROM pers WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['phone'] == "")
        {
            $row['phone'] = "Not set";
        }

        echo "Welcome, " . $row['fname'] . " " . $row['lname'] . "<br>";
        echo "Username: " . $row['user'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Phone: " . $row['phone'] . "<br>";
    ?>
    <a href="logout.php">Logout</a>
</body>
</html>