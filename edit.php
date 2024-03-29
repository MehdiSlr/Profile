<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
        
        $sql = "SELECT * FROM pers WHERE id = '$id'"; // get user data from database from user id
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row['fname'] == "" and $row['lname'] == "") // check if first and last name not set
        {
            header('location: info.php'); //redirect to info page to set first and last name
        }

        
        if($row['pic_adrs'] == "") // check if profile picture not set
        {
            $row['pic_adrs'] = "https://s3.amazonaws.com/37assets/svn/765-default-avatar.png";
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
        <form method="post" enctype="multipart/form-data" action="#">
            <div>
                <div style="align-items: center;" class="header">
                    <img src="<?php echo $pic_adrs; ?>">
                    <div>
                        <h1 style="font-size: 15px;">
                        <strong style="margin-right: 25px;">Select your profile picture</strong><input style="width: 200px; margin-bottom: 10px; " type="file" accept="image/*" name="pic" id="pic"><br>
                        <input style="width: 200px;" type="text" placeholder="ex. John" name="fname" value="<?php echo $fname; ?>" required/>
                        <input style="width: 200px;" type="text" placeholder="ex. Smith" name="lname" value="<?php echo $lname; ?>" required/>
                        </h1>
                    </div>
                </div> 
                <div class="line"></div>
                    <div style="margin-top: 0; margin-bottom: 0;" class="profile-cl">
                        <div style="margin-top: 0;" class="profile-row"> 
                            <div class="profile-body">
                                <h4>Username</h4>
                                <div class="input-control">
                                    <h2><input type="text" placeholder="ex. john" name="user" value="<?php echo $user; ?>" required/></h2>
                                </div>
                            </div>
                            <div class="profile-body">
                                <h4>Job Title</h4>
                                <div class="input-control">
                                    <h2><input type="text" placeholder="ex. Web Developer" name="job" value="<?php echo $job; ?>"/></h2>
                                </div>
                            </div>
                            <div class="profile-body">
                                <h4>Birth Date</h4>
                                <div class="input-control">
                                    <h2><input type="date" name="birth" value="<?php echo $birth; ?>"/></h2>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 0;" class="profile-row">
                            <div class="profile-body">
                                <h4>E-mail</h4>
                                <div class="input-control">
                                    <h2><input type="email" placeholder="ex. john@example.com" name="email" value="<?php echo $email; ?>" readonly/></h2>
                                </div>
                            </div>

                            <div class="profile-body">
                                <h4>Biography</h4>
                                <div class="input-control">
                                    <h2><textarea name="bio" placeholder="Write something about yourself"><?php echo $bio; ?></textarea></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btns">
                    <input class="logout-btn" type="submit" name="save" value="Save"/>
                </div>
            </div>
        </form>
    </section>
    <?php
        if(isset($_POST['save']))
        {
            $id = $row['id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $user = $_POST['user'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $bio = $_POST['bio'];
            $birth = $_POST['birth'];


            // upload profile picture

                // check if file uploaded
            if($_FILES['pic']['error'] != 4)
            {
                // get file name
                $filename = $_FILES['pic']['name'];

                // get file extension
                $extension = explode('.', $filename);
                
                //change file name to user id
                $filename = $id.'.'.$extension[1];
                
                // get file path
                $path = $_FILES['pic']['tmp_name'];

                //get file size
                $size = $_FILES['pic']['size'];

                //if file size under 5mb
                if($size < 5000000)
                {                    
                    // upload file
                    $pic_adrs = './assets/pics/'.$filename;
                    move_uploaded_file($path, $pic_adrs);
                }
                else
                {
                    // if file size over 5mb
                    echo "<script>Swal.fire({icon: 'error', title: 'File size over 5mb!'});</script>";
                }
            }
            else
            {
                $pic_adrs = $row['pic_adrs'];
            }
            // update user data
            $sql = "UPDATE pers SET fname = '$fname', lname = '$lname', user = '$user', email = '$email', job = '$job', bio = '$bio', birth = '$birth', pic_adrs = '$pic_adrs' WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                echo "<script>Swal.fire({icon: 'error', title: 'Error".$conn->error."'});</script>";
            }
            header('location: profile.php');
        }
    ?>
</body>
</html>