<?php
   $sql = "select * from user where user_id='$user_id'";
   $result = $con->query($sql);
   $row = $result->fetch_assoc();
   $fname = $row['fname'];
   $lname = $row['lname'];
   $phone = $row['phone'];
   $address = $row['address'];
   $email = $row['email'];
?>

<div class="text-center">
    <h2>First Name : <?php echo $fname; ?><br>
    Last Name : <?php echo $lname; ?><br>
    Phone Number : <?php echo $phone; ?><br>
    Address : <?php echo $address; ?><br>
    Email : <?php echo $email; ?><br></h2>
</div>