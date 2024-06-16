<?php
include("php/dbconnect.php");

$error = '';
if(isset($_POST['login']))
{
    $username =  mysqli_real_escape_string($conn, trim($_POST['username']));
    $password =  mysqli_real_escape_string($conn, $_POST['password']);

    if($username == '' || $password == '')
    {
        $error = 'All fields are required';
    }

    $sql = "SELECT * FROM user WHERE username='".$username."' AND password = '".md5($password)."'";

    $q = $conn->query($sql);
    if($q->num_rows == 1)
    {
        $res = $q->fetch_assoc();
        $_SESSION['rainbow_username'] = $res['username'];
        $_SESSION['rainbow_uid'] = $res['id'];
        $_SESSION['rainbow_name'] = $res['name'];
        echo '<script type="text/javascript">window.location="index.php"; </script>';
    }
    else
    {
        $error = 'Invalid Username or Password';
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLSP Finance Management System</title>

    <!-- BOOTSTRAP STYLES-->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <style>
        body{
            background-color: #3b903b;
        }

        .myhead {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .create-acc {
            margin-top: 10px;
            margin-right: 100px;
        }

        .panel-body {
            background-color: #E2E2E2;
            margin-top: 50px;
            border: solid 3px #0e0e0e;
            opacity: 100;
        }
    .container{
        margin-top: 200px;
        

    }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel-body">
                    <h3 class="myhead">PLSP Finance Management System</h3>
                    <form role="form" action="login.php" method="post">
                        <hr />
                        <?php
                        if($error != '') {
                            echo '<h5 class="text-danger text-center">'.$error.'</h5>';
                        }
                        ?>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input type="text" class="form-control" placeholder="Your Username" name="username" required />
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Your Password" name="password" required />
                        </div>
                        <div class="form-group">
                            <span class="pull-right">
                                <a href="index.html">Forget password?</a>
                            </span>
                        </div>
                        <button class="btn btn-primary" type="submit" name="login">Login Now</button>
                        <div class="create-acc">
                            <span class="pull-left">
                                <a href="signup.php">Create New Account</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
