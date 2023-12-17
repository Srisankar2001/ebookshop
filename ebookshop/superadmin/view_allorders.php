<?php
 $sql = "SELECT * FROM orders";
 $result = $con->query($sql);
 if($result->num_rows == 0){
    echo '<h2 class="text-center">No orders received yet.</h2>';
 }
 else{
    echo '<div class="container">
    <table class="table">
    <thead>
    <tr>
    <th>Date</th>
    <th>Order ID</th>
    <th>User ID</th>
    <th>User Name</th>
    <th>Book ID</th>
    <th>Book Name</th>
    <th>Quantity</th>
     <th>Total Price</th>
     <th>Status</th>
     </tr>
     </thead>
     <tbody>';
     while($row = $result->fetch_assoc()){
        $date = $row['order_date'];
        $order_id = $row['order_id'];
        $book_id = $row['book_id'];
        $user_id = $row['user_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $status = $row['confirmed'];

        $book_sql = "SELECT * FROM book WHERE book_id='$book_id'";
        $book_result = $con->query($book_sql);
        $book_row = $book_result->fetch_assoc();
        $title = $book_row['title'];

        $user_sql = "SELECT * FROM user WHERE user_id='$user_id'";
        $user_result = $con->query($user_sql);
        $user_row = $user_result->fetch_assoc();
        if(isset($user_row['lname'])){
            $name = $user_row['lname'];
        }
        else{
            $name = 'NULL';
        }
        
       
        
        echo '<tr>
        <td>'.$date.'</td>
        <td>'.$order_id.'</td>
        <td>'.$user_id.'</td>
        <td>'.$name.'</td>
        <td>'.$book_id.'</td>
        <td>'.$title.'</td>
        <td>'.$quantity.'</td>
        <td>'.$price*$quantity.'</td>
        <td>';
        if($status == 0){
            echo 'Not confirmed';
        }else{
            echo 'Confirmed';
        }
        echo '</td>
        </tr>';
     }
     echo '</tbody></table></div>';
 }
?>