<?php
 $sql = "SELECT * FROM orders WHERE user_id='$user_id'";
 $result = $con->query($sql);
 if($result->num_rows == 0){
    echo '<h2 class="text-center">You didn\'t order anything yet.</h2>';
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
     <th>Status</th>
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
        <td>';
        if($status == 0){
            echo 'Not received
            <div class="d-flex"><form action="" method="post">
            <input type="hidden" name="order_id" value="'.$order_id.'">
            <input type="submit" class="btn bg-primary" style="color:white;" name="confirm" value="Confirm">
            </form></div>';
        }else{
            echo 'Received';
        }
        echo '</td>
        </tr>';
     }
     echo '</tbody></table></div>';
 }
?>

<?php
    if(isset($_POST['confirm'])){
        $order_id = $_POST['order_id'];
        $sql = "UPDATE orders SET confirmed=1 WHERE order_id='$order_id'";
        $result = $con->query($sql);
        if($result){
            echo "<script>alert('Order received updated')</script>";
            echo "<script>window.open('profile.php?allorders','_self')</script>";
        }
        else{
            echo "<script>alert('Sorry. Can't update.')</script>";
            echo "<script>window.open('profile.php?allorders','_self')</script>";
        }
    }

?>