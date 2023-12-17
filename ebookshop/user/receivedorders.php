<?php
 $sql = "SELECT * FROM orders WHERE user_id='$user_id' AND confirmed=1";
 $result = $con->query($sql);
 if($result->num_rows == 0){
    echo '<h2 class="text-center">There is no received orders avalible</h2>';
 }
 else{
    echo '<div class="container">
    <table class="table">
    <thead>
    <tr>
    <th>Date</th>
    <th>Title</th>
    <th>Quantity</th>
     <th>Total Price</th>
     </tr>
     </thead>
     <tbody>';
     while($row = $result->fetch_assoc()){
        $date = $row['order_date'];
        $order_id = $row['order_id'];
        $book_id = $row['book_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $status = $row['confirmed'];

        $book_sql = "SELECT * FROM book WHERE book_id='$book_id'";
        $book_result = $con->query($book_sql);
        $book_row = $book_result->fetch_assoc();
        $title = $book_row['title'];

        echo '<tr>
        <td>'.$date.'</td>
        <td>'.$title.'</td>
        <td>'.$quantity.'</td>
        <td>'.$price*$quantity.'</td>
        </tr>';
     }
     echo '</tbody></table></div>';
 }
?>
