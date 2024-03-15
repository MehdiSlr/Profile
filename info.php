<!-- get user information such as first and last name and phone number -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://unicons.iconscout.com/release/v2.1.9/css/unicons.css'>
    <link rel="stylesheet" href="style.css">
    <title>Profile Information</title>
</head>
<?php
    session_start();
    include "./conf/serv_conf.php";

    if(!isset($_SESSION['register'])) // if user is not submitted email redirect to verify page
    {
        header('location: verify.php');
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
                <label>Phone Number</label>
                <input type="number" placeholder="ex. 123456789" name="phone"/>
                <i class="uil uil-phone"></i>
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
        $phone = $_POST['phone'];
        $id = $_SESSION['register'];

        $sql = "UPDATE pers SET fname = '$fname', lname = '$lname', phone = '$phone' WHERE id = '$id'"; // update user data in database (first name, last name, phone number)
        $result = mysqli_query($conn, $sql);

        unset($_SESSION['register']); // unset user id from registersession 
        $_SESSION['login'] = $id; // set user id in login session for profile page
        header("Location: profile.php");
    }
?>
</html>