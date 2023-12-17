<?php
    include 'connect.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            if($_POST['role'] == "user"){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sql = "select user_id, password from user where email=?;";
                $ps = $con->prepare($sql);
                $ps->bind_param("s", $email);
                $ps->execute();
                $ps->bind_result($user_id,$hashDB);
                if ($ps->fetch() && password_verify($password,$hashDB)) {
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    header("Location: user/index.php");
                    exit;
                } else {
                    echo "<script>alert('Please enter correct email and password')</script>";
                }
                $ps->close();
                $con->close();
            }else if($_POST['role'] == "admin"){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sql = "select admin_id,password from admin where email=?;";
                $ps = $con->prepare($sql);
                $ps->bind_param("s", $email);
                $ps->execute();
                $ps->bind_result($admin_id,$hashDB);
                if ($ps->fetch() && password_verify($password,$hashDB)) {
                    session_start();
                    $_SESSION['admin_id'] = $admin_id;
                    header("Location: admin/index.php");
                    exit;
                } else {
                    echo "<script>alert('Please enter correct email and password')</script>";
                }
                $ps->close();
                $con->close();
            }else if($_POST['role'] == "superadmin"){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sql = "select sadmin_id,password from superadmin where email=?;";
                $ps = $con->prepare($sql);
                $ps->bind_param("s", $email);
                $ps->execute();
                $ps->bind_result($sadmin_id,$hashDB);
                if ($ps->fetch() && password_verify($password,$hashDB)) {
                    session_start();
                    $_SESSION['sadmin_id'] = $sadmin_id;
                    header("Location: superadmin/index.php");
                    exit;
                } else {
                    echo "<script>alert('Please enter correct email and password')</script>";
                }
                $ps->close();
                $con->close();
            }
        }
       
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body{
        background-color: #f4f9f4;
        margin-top: 100px;
        position: relative;
        }
        input{
            box-shadow: 0 0 10px rgba(128, 128, 128, 0.3);;
        }
        h3{
            color:#333;
        }
    </style>
</head>
<body>
    <div class="content">
    <div class="form-outline mb-4 w-50 m-auto">
                <h3>Login Form</h3>
            </div>
        <div class="form">
            <form method="post" action="signin.php">
                <select class="form-select mb-4 w-50 m-auto" aria-label="Default select example" name="role" id="role">
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                 </select>
                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email">
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="link form-outline mb-4 w-50 m-auto">
                    <a href="signup.php">Don't have an account. Click Here to Sign up.</a>
                </div>
                <div class="link form-outline mb-4 w-50 m-auto">
                <input type="submit" class="btn btn-primary" name="submit" value="Login">
                <input type="reset" class="btn btn-secondary" value="Clear">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>