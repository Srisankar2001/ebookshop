<?php
    $sql = "SELECT * FROM orders WHERE user_id='$user_id' AND confirmed=0";
    $result = $con->query($sql);
    if($result->num_rows == 0){
        echo '<h2 class="text-center">You want to delete your account</h2>
        <div class="text-center mx-auto"><form action="" method="post"><input type="submit" class="btn btn-danger" name="delete" value="Delete Account"></form></div>';
    }
    else{
        echo '<h2 class="text-center">You have <span class="text-danger">'.$result->num_rows.'</span> orders pending. So you can\'t delete your account.</h2>';
    }
?>

<?php
    if(isset($_POST['delete'])){
        $sql = "DELETE FROM user WHERE user_id='$user_id'";
        $result = $con->query($sql);
        if($result){
            header('Location: ../index.php');
            exit();
        }
        else{
            echo "<script>alert('Unable to delete your account')</script>";
        }
    }

?>