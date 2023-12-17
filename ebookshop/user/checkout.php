<?php
  include('../connect.php');
  session_start();
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
    <title>User Checkout Page</title>
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
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid welcome mx-5">
  <div class="d-flex">
    <h4 class="me-3">Welcome <?php echo "$lname"; ?></h4>
    <h4><a href="checkout.php?logout"><i class="bi bi-box-arrow-left"></i>Logout</a></h4>
  </div>
</div>


<?php
  if(isset($_GET['logout'])){
    include('logout.php');
  }
?>
<!-- check if the stock isn't enough for all -->
<?php
    $select_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
    $select_result = $con->query($select_sql);
    $flag = 0;
    while($select_row = $select_result->fetch_assoc()){
        $book_id = $select_row['book_id'];
        $quantity = $select_row['quantity'];
        $sql = "SELECT * FROM book WHERE book_id='$book_id'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        if($row['quantity'] >= $quantity){
            $flag = 1;
        }
    }
?>

<!-- bill  -->
<?php
    if($flag == 1){
    $select_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
    $select_result = $con->query($select_sql);
    $total = 0;
    $db_array = array();
    echo '<div class="container"  style="margin-top:100px; padding-top:50px;"><table class="table">
    <thead>
    <tr>
    <th>Title</th>
    <th>Price</th>
    <th>Quantity</th>
     <th>Total</th>
     </tr>
     </thead>
     <tbody>';
    while($select_row = $select_result->fetch_assoc()){
        $book_id = $select_row['book_id'];
        $quantity = $select_row['quantity'];
        $sql = "SELECT * FROM book WHERE book_id='$book_id'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        if($row['quantity'] >= $quantity){
            $db_array[$book_id] = $quantity;
            $total += $row['price']*$quantity;
            echo '<tr>
                  <td>'.$row['title'].'</td>
                  <td>'.$row['price'].'</td>
                  <td>'.$quantity.'</td>
                  <td>'.$row['price']*$quantity.'</td>
                  </tr>';
        }
        else
        {
            echo "<script>alert('We don't have enough stock in '.{$row['title']}.'Try again later.)</script>";
        }
    }
    $_SESSION['db_array'] = $db_array;
    $_SESSION['total'] = $total;
    echo '</tbody></table></div>';
    echo '<div class="container d-flex"><h2>Subtotal:<strong>'.$total.' LKR</strong></h2>
          <button class="btn btn-primary mx-5 px-3"><a href="cart.php">Go to cart</a></button>
          <button class="btn btn-success mx-5 px-5"><a href="payment.php">Pay</a></button></div>';
    }
    else{
        echo "<h2 class='text-center'>No items in stock.</h2>";
    }
?>


</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>