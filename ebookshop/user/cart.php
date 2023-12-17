<?php
  include('../connect.php');
  session_start();
  $referring_page = $_SESSION['referring_page'];
  if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    exit();
  }
  $user_id = $_SESSION['user_id'];
  $sql = "select * from user where user_id='$user_id'";
  $result = $con->query($sql);
  $row = $result->fetch_assoc();
  $fname = $row['fname'];
  $lname = $row['lname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Cart Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .logo{
             width: 10%;
            height: 10%;
        }
        .welcome{
          background-color:#f4f9f4;
          width:100%;
          padding-bottom:10px;
        }
        .welcome  a{
           text-decoration: none;
           color:blue;
        }
        .container a{
          text-decoration: none;
          color:white;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid p-0">
       <!-- nav bar -->
       <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
           <img src="../images/logo.jpg" alt="No image" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php?allorders">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="cart.php"><i class="bi bi-cart-fill"></i><sup id="cart">0</sup>Cart</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container-fluid welcome mx-5">
  <div class="d-flex">
    <h4 class="me-3">Welcome <?php echo "$lname"; ?></h4>
    <h4><a href="cart.php?logout"><i class="bi bi-box-arrow-left"></i>Logout</a></h4>
  </div>
</div>


<?php
  if(isset($_GET['logout'])){
    include('logout.php');
  }
?>

<!-- cart item count -->
<?php
   $select_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
   $select_result = $con->query($select_sql);
   $count = $select_result->num_rows;
   echo "<script> let cart = document.getElementById('cart')
          cart.innerText = '$count'</script>";
?>


<?php
  $select_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
  $select_result = $con->query($select_sql);
  if($select_result->num_rows != 0){
    $total = 0;
    echo '<div class="container"  style="margin-top:100px; padding-top:50px;"><table class="table">
    <thead>
      <tr>
        <th scope="col">Title</th>
        <th scope="col">Image</th>
        <th scope="col">Quantity</th>
        <th scope="col">Price</th>
        <th scope="col">Operation</th>
      </tr>
    </thead>
    <tbody>';
    while($row_result = $select_result->fetch_assoc()){
     $book_id = $row_result['book_id'];
     $quantity = $row_result['quantity'];
     $sql =  "SELECT * FROM book WHERE book_id='$book_id'";
     $result = $con->query($sql);
     $row = $result->fetch_assoc();
     $title = $row['title'];
     $image = $row['coverimageurl'];
     $price = $row['price'];
     $total += $price*$quantity;
     echo '<form action="cart.php" method="post"><tr>
     <td>'.$title.'</td>
     <td><img src="../images/'.$image.'" class="rounded" height="200px" alt="not image"></td>
     <td>
      <input  type="number" name="quantity" value="'.$quantity.'">
      <input  type="hidden" name="book_id" value="'.$book_id.'">
     </td>
     <td>'.$price * $quantity.'</td>
     <td><input class="btn bg-primary mx-2" style="color:white;"  type="submit" name="update" value="Update">
     <input class="btn bg-danger mx-2" style="color:white;" type="submit" name="remove" value="Remove"></td>
   </tr></form>';
    }
    echo '</tbody>
  </table></div>';
    echo '<div class="container d-flex"><h2>Subtotal:<strong>'.$total.'/=</strong></h2>
          <button class="btn btn-success mx-5 px-2"><a href="'.$referring_page.'">Continue Shopping</a></button>
          <button class="btn btn-success mx-5 px-2"><a href="checkout.php">Checkout</a></button></div>';
  }
  else{
    echo "<h2 class='text-center'>No items in the cart</h2>";
  }
?>

<?php
  if(isset($_POST['update'])){
    $book_id = $_POST['book_id'];
    $new_quantity = $_POST['quantity'];
    if($quantity != $new_quantity){
      if($new_quantity != 0){
        $sql = "UPDATE cart SET quantity='$new_quantity' WHERE book_id='$book_id' AND user_id='$user_id'";
        $result = $con->query($sql);
        if($result){
          echo "<script>alert('Cart updated successfully.')</script>";
          echo "<script>window.open('cart.php','_self')</script>";
        }
        else{
          echo "<script>alert('Sorry can't update cart.')</script>";
          echo "<script>window.open('cart.php','_self')</script>";
        }
      }
      else{
        $book_id = $_POST['book_id'];
        $sql = "DELETE FROM cart WHERE book_id='$book_id' AND user_id='$user_id'";
        $result = $con->query($sql);
        if($result){
          echo "<script>alert('Book removed from cart successfully.')</script>";
          echo "<script>window.open('cart.php','_self')</script>";
        }
        else{
          echo "<script>alert('Sorry can't remove from cart.')</script>";
          echo "<script>window.open('cart.php','_self')</script>";
        }
      }
    }
  }

  if(isset($_POST['remove'])){
    $book_id = $_POST['book_id'];
    $sql = "DELETE FROM cart WHERE book_id='$book_id' AND user_id='$user_id'";
    $result = $con->query($sql);
    if($result){
      echo "<script>alert('Book removed from cart successfully.')</script>";
      echo "<script>window.open('cart.php','_self')</script>";
    }
    else{
      echo "<script>alert('Sorry can't remove from cart.')</script>";
      echo "<script>window.open('cart.php','_self')</script>";
    }
  }

?>




</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>