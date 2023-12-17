<div>
  <ul class="navbar-nav m-auto text-center">
    <li class="nav-item">
      <a href="#" class="nav-link"><h4>View User Details</h4></a>
    </li>
    <?php
        $sql_user = "SELECT * FROM user";
        $result_user = $con->query($sql_user);
        if($result_user->num_rows == 0){
            echo '<h2 class="text-center">No Users registered yet</h2>';
        }
        else{
            echo '<div class="container">
            <table class="table">
            <thead>
            <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            </thead>
            <tbody>';
            while($row_user = $result_user->fetch_assoc()){
                $user_id = $row_user['user_id'];
                $fname = $row_user['fname'];
                $lname = $row_user['lname'];
                $phone = $row_user['phone'];
                $address = $row_user['address'];
                $email = $row_user['email'];
                echo '<tr>
                <td>'.$user_id.'</td>
                <td>'.$fname.'</td>
                <td>'.$lname.'</td>
                <td>'.$phone.'</td>
                <td>'.$address.'</td>
                <td>'.$email.'</td>
                </tr>';
            }
            echo '</tbody></table></div>';

        }
        
    ?>
  </ul>
</div>
