<?php
        include 'connect.php';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['fname'])){
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $re_password = $_POST['re_password'];

                $hash = password_hash($password,PASSWORD_DEFAULT);
                if($fname == ''){
                    echo "<script>alert('First name field is empty')</script>";
                }
                elseif(!preg_match('/^[A-Za-z]{2,}$/',$fname)){
                    echo "<script>alert('First name field only contain letters')</script>";
                }
                elseif($lname == ''){
                    echo "<script>alert('Last name field is empty')</script>";
                }
                elseif(!preg_match('/^[A-Za-z]{2,}$/',$lname)){
                    echo "<script>alert('Last name field only contain letters')</script>";
                }
                elseif($phone == ''){
                    echo "<script>alert('Phone number field is empty')</script>";
                }
                elseif(!preg_match("/^\d{10}$/", $phone)){
                    echo "<script>alert('Phone number must have 10 digits')</script>";
                }
                elseif($address == ''){
                    echo "<script>alert('Address field is empty')</script>";
                }
                elseif($email == ''){
                    echo "<script>alert('Email field is empty')</script>";
                }
                elseif(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
                    echo "<script>alert('Phone number must have 10 digits')</script>";
                }
                elseif($password == ''){
                    echo "<script>alert('Password field is empty')</script>";
                }
                elseif($re_password == ''){
                    echo "<script>alert('Confirm Password field is empty')</script>";
                }
                elseif($re_password != $password){
                    echo "<script>alert('Password and Confirm password must be same')</script>";
                }
                else{
                    $check_sql = "select * from user where email='$email'";
                    $result_check = $con->query($check_sql);
                    if($result_check->num_rows == 0){
                        $sql = "insert into user (fname,lname,phone,address,email,password) values ('$fname','$lname','$phone','$address','$email','$hash')";
                        $result = $con->query($sql);
                        if ($result) {
                            echo "<script>alert('Account Created Successfully')</script>";
                            $user_id = $con->insert_id;
                            session_start();
                            $_SESSION["user_id"] = $user_id;
                            header("Location: user/user.php");
                            exit;
                        } else {
                            echo "<script>alert('Account didn't created')</script>";
                        }
                    }
                    else{
                        echo "<script>alert('Account already exist')</script>";
                    }
                
                }
                $con->close();
            }
           

        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
                <h3>Register Form</h3>
            </div>
        <div class="form">
            <form id="form"  method="post">
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter Your First Name" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" name="lname" id="lname" class="form-control" placeholder="Enter Your Last Name" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Your Phone Number" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Enter Your Address" autocomplete="off">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" autocomplete="off">
            </div>
           
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Your Password" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="re_password" class="form-label">Confirm Password</label>
                <input type="password" name="re_password" id="re_password" class="form-control" placeholder="Re-Enter Your Password" autocomplete="off">
            </div>

                   <div class="link form-outline mb-4 w-50 m-auto">
                    <a href="signin.php">Already have an account. Click Here to Sign in.</a>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Create Account">
                <input class="btn btn-secondary" type="reset" value="Clear">
                 </div>
                
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>