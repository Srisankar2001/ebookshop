<div>
  <ul class="navbar-nav m-auto text-center">
    <li class="nav-item">
      <a href="#" class="nav-link"><h4>View Admin Details</h4></a>
    </li>
    <?php
        $sql_admin = "SELECT * FROM `admin`";
        $result_admin = $con->query($sql_admin);
        if($result_admin->num_rows == 0){
            echo '<h2 class="text-center">No Admins added yet</h2>';
        }
        else{
            echo '<div class="container">
            <table class="table">
            <thead>
            <tr>
            <th>Admin ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            </thead>
            <tbody>';
            while($row_admin = $result_admin->fetch_assoc()){
                $admin_id = $row_admin['admin_id'];
                $fname = $row_admin['fname'];
                $lname = $row_admin['lname'];
                $phone = $row_admin['phone'];
                $address = $row_admin['address'];
                $email = $row_admin['email'];
                echo '<tr>
                <td>'.$admin_id.'</td>
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
