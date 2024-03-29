<!-- get user information such as first and last name and phone number -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style/style.css">
    <title>Profile Information</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(!isset($_SESSION['login'])) // if user is not submitted email redirect to index page
    {
        header('location: index.php');
    }

    $sql = "SELECT * FROM pers WHERE id = '$_SESSION[login]'"; //check user already set first and last name
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if(!empty($row['fname']) && !empty($row['lname']))
    {
        header("Location: profile.php"); //redirect to profile page
    }
?>
<body>
    <section>
        <h1>Information Form</h1>
        <form action="#" method="post">
            <div class="input-control">
                <label>First Name</label>
                <input type="text" placeholder="ex. John" name="fname" required/>
                <i class="uil uil-user"></i>
            </div>
            <div class="input-control">
                <label>Last Name</label>
                <input type="text" placeholder="ex. Smith" name="lname" required/>
                <i class="uil uil-user"></i>
            </div>
            <div class="input-control">
                <label>Job Title</label>
                <input type="text" placeholder="ex. Web Developer" name="job"/>
                <i class="uil uil-bag"></i>
            </div>
            <input class="btn" type="submit" value="Submit" name="submit"/>
        </form>
    </section>
</body>
<?php
    if(isset($_POST['submit'])) // if submit button is clicked
    {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $job = $_POST['job'];
        $id = $_SESSION['login'];

        $sql = "UPDATE pers SET fname = '$fname', lname = '$lname', phone = '$phone' WHERE id = '$id'"; // update user data in database (first name, last name, phone number)
        $result = mysqli_query($conn, $sql);
        header("Location: profile.php");
    }
?>
</html>