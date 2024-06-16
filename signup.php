<?php
include("php/dbconnect.php");

$error = '';
$success = '';
if(isset($_POST['signup']))
{
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    if($username == '' || $password == '' || $confirm_password == '' || $name == '' || $email == '')
    {
        $error = 'All fields are required';
    }
    elseif($password != $confirm_password)
    {
        $error = 'Passwords do not match';
    }
    else
    {
        $password = md5($password); // Hash the password for security
        $sql = "INSERT INTO user (username, password, name, emailid, role) VALUES ('$username', '$password', '$name', '$email', 'admin')";

        if ($conn->query($sql) === TRUE) {
            $success = 'Admin account created successfully';
        } else {
            $error = 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Sign Up</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body {
            background-color: #3b903b;
        }
        .myhead {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        hr {
            border-color: black;
            margin-bottom: 10px;
        }
        h3 {
            text-align: left;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row ">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel-body" style="background-color: #E2E2E2; margin-top:50px; border:solid 3px #0e0e0e;">
                    <h2 class="myhead">PLSP Finance Management System</h2>
                    <hr>
                    <h3>Admin Sign Up</h3>
                    <form role="form" action="signup.php" method="post">
                        <hr class="hr" />
                        <?php
                        if ($error != '') {
                            echo '<h5 class="text-danger text-center">'.$error.'</h5>';
                        }
                        if ($success != '') {
                            echo '<h5 class="text-success text-center">'.$success.'</h5>';
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Your Name" name="name" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Your Email" name="email" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" class="form-control" placeholder="Your Username" name="username" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Your Password" name="password" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required />
                        </div>
                        <div class="button-group">
                          <button class="btn btn-primary" type="submit" name="signup">Sign Up Now</button>
                         <a href="index.php" class="btn btn-default">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
