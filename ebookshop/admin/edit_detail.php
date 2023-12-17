<?php
    $sql = "select * from admin where admin_id='$admin_id'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $fname = $row['fname'];
    $lname = $row['lname'];
    $phone = $row['phone'];
    $address = $row['address'];
    $email = $row['email'];
    $password = $row['password'];
?>
<html>
    <body>
        <div class="container w-50">
            <h5><form class="form m-2" method="post" action="">
            First Name<input type="text" class="form-outline mx-3 w-50" name="fname" value="<?php echo $fname;?>">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_fname" value="Edit">
            </form>
            <form class="form m-2" method="post" action="">
            Last Name<input type="text" class="form-outline mx-3 w-50" name="lname" value="<?php echo $lname;?>">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_lname" value="Edit">
            </form>
            <form class="form m-2" method="post" action="">
            Phone<input type="text" class="form-outline mx-3 w-50" name="phone" value="<?php echo $phone;?>">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_phone" value="Edit">
            </form>
            <form class="form m-2" method="post" action="">
            Address<input type="text" class="form-outline mx-3 w-50" name="address" value="<?php echo $address;?>">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_address" value="Edit">
            </form>
            <form class="form m-2" method="post" action="">
            Email<input type="email" class="form-outline mx-3 w-50" name="email" value="<?php echo $email;?>">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_email" value="Edit">
            </form>
            <form class="form m-2" method="post" action="">
            Password<input type="password" class="form-outline mx-3 w-50" name="password" placeholder="Enter your new password">
            <input type="submit" class="btn bg-primary" style="color:white;" name="submit_password" value="Edit">
            </form></h5>
        </div>
    </body>
</html>

<?php
    if(isset($_POST['submit_fname'])){
        $new_fname = $_POST['fname'];
        if($new_fname != $fname){
            if($new_fname != '' && preg_match('/^[A-Za-z]{2,}$/',$new_fname)){
                $sql = "UPDATE `admin` SET fname='$new_fname' WHERE admin_id='$admin_id'";
                $result = $con->query($sql);
                if($result){
                    echo "<script>alert('Details updated successfully')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
                else{
                    echo "<script>alert('Unable to update details.')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
    }
    if(isset($_POST['submit_lname'])){
        $new_lname = $_POST['lname'];
        if($new_lname != $lname){
            if($new_lname != '' && preg_match('/^[A-Za-z]{2,}$/',$new_lname)){
                $sql = "UPDATE `admin` SET lname='$new_lname' WHERE admin_id='$admin_id'";
                $result = $con->query($sql);
                if($result){
                    echo "<script>alert('Details updated successfully')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
                else{
                    echo "<script>alert('Unable to update details.')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
    }
    if(isset($_POST['submit_phone'])){
        $new_phone = $_POST['phone'];
        if($new_phone != $phone){
            if($new_phone != '' && preg_match("/^\d{10}$/", $new_phone)){
                $sql = "UPDATE `admin` SET phone='$new_phone' WHERE admin_id='$admin_id'";
                $result = $con->query($sql);
                if($result){
                    echo "<script>alert('Details updated successfully')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
                else{
                    echo "<script>alert('Unable to update details.')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
    }
    if(isset($_POST['submit_address'])){
        $new_address = $_POST['address'];
        if($new_address != $address){
            if($new_address != ''){
                $sql = "UPDATE `admin` SET `address`='$new_address' WHERE admin_id='$admin_id'";
                $result = $con->query($sql);
                if($result){
                    echo "<script>alert('Details updated successfully')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
                else{
                    echo "<script>alert('Unable to update details.')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
    }
    if(isset($_POST['submit_email'])){
        $new_email = $_POST['email'];
        if($new_email != $email){
            if($new_email!= '' && preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $new_email)){
                $sql_check ="SELECT * FROM `admin` WHERE email='$new_email'";
                $result_check = $con->query($sql_check);
                if($result_check->num_rows == 0){
                    $sql = "UPDATE `admin` SET email='$new_email' WHERE admin_id='$admin_id'";
                    $result = $con->query($sql);
                    if($result){
                        echo "<script>alert('Details updated successfully')</script>";
                        echo "<script>window.open('index.php?edit_detail','_self')</script>";
                    }
                    else{
                        echo "<script>alert('Unable to update details.')</script>";
                        echo "<script>window.open('index.php?edit_detail','_self')</script>";
                    }
                }
                else{
                    echo "<script>alert('Given Email already exist.')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
    }
    if(isset($_POST['submit_password'])){
        $new_password = $_POST['password'];
        if(!password_verify($new_password,$password)){
            if($new_password != ''){
                $hash = password_hash($new_password,PASSWORD_DEFAULT);
                $sql = "UPDATE `admin` SET `password`='$hash' WHERE admin_id='$admin_id'";
                $result = $con->query($sql);
                if($result){
                    echo "<script>alert('Password updated successfully')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
                else{
                    echo "<script>alert('Unable to update password')</script>";
                    echo "<script>window.open('index.php?edit_detail','_self')</script>";
                }
            }
            else{
                echo "<script>alert('Invalid input')</script>";
                echo "<script>window.open('index.php?edit_detail','_self')</script>";
            }
        }
        else{
            echo "<script>alert('This is the Same password')</script>";
            echo "<script>window.open('index.php?edit_detail','_self')</script>";
        }
    }

?>