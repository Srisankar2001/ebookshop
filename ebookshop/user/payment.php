<?php
  include('../connect.php');
  session_start();
  if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    exit();
  }
  $db_array = $_SESSION['db_array'];
  $total = $_SESSION['total'];
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
    <title>User Payment Page</title>
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
        input{
            box-shadow: 0 0 10px rgba(128, 128, 128, 0.3);;
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
    <h4><a href="payment.php?logout"><i class="bi bi-box-arrow-left"></i>Logout</a></h4>
  </div>
</div>


<?php
  if(isset($_GET['logout'])){
    include('logout.php');
  }
?>

<div class="container" style="margin-top:100px; padding-top:50px;">
    <form action="payment.php" method="post">
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="card" class="form-label">Card Number</label>
        <input type="number" name="card"  class="form-control" placeholder="Enter Your Card Number" autocomplete="off">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="name" class="form-label">Cardholder Name</label>
        <input type="text" name="name"  class="form-control" placeholder="Enter Cardholder's Name" autocomplete="off">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="month" class="form-label">Expire Month and Year</label>
        <input type="month" name="month"  class="form-control" placeholder="Month" autocomplete="off">
    </div>
    <div class="form-outline mb-4 w-50 m-auto">
        <label for="cnn" class="form-label">Card CNN number</label>
        <input type="number" name="cnn"  class="form-control" placeholder="Enter Your Card's CNN Number" autocomplete="off">
    </div>
    <div class="container mb-4 w-50 m-auto d-flex">
        <input type="submit" class="btn btn-success mx-5 px-3" name="submit" value="Pay <?php echo number_format($total,2); ?> LKR">
        <input type="submit" class="btn btn-danger  px-3" name="cancel" value="Cancel">
     </div>
    </form>
</div>

<?php
    if(isset($_POST['submit'])){
        $card = $_POST['card'];
        $name = $_POST['name'];
        $cnn = $_POST['cnn'];
        $month = $_POST['month'];
        if(!preg_match('/^\d{16}$/',$card)){
          if($card != ''){
            echo "<script>alert('Invalid Credit Card Number')</script>";
          }
          else{
            echo "<script>alert('Credit Card Number can\'t be empty')</script>";
          }
          
        }
        elseif(!preg_match('/^\d{3}$/',$cnn)){
          if($cnn != ''){
            echo "<script>alert('Invalid CNN Number')</script>";
          }
          else{
            echo "<script>alert('CNN Number can\'t be empty')</script>";
          }
         
        }
        elseif(!preg_match('/^[A-Za-z]{2,}$/',$name)){
          if($name != ''){
            echo "<script>alert('Invalid Cardholder\'s Name')</script>";
          }
          else{
            echo "<script>alert('Cardholder\'s Name can\'t be empty')</script>";
          }
        }
        elseif(date('Y-m') > $month ){
          if($month!= ''){
            echo "<script>alert('Your Card is Expired')</script>";
          }
          else{
            echo "<script>alert('Expiry Date can\'t be empty')</script>";
          }
        }
        else{
            $count = 0;
            foreach($db_array as $book_id => $quantity){
              $sql_quantity = "SELECT * FROM book WHERE book_id='$book_id'";
              $result_quantity = $con->query($sql_quantity);
              $row_quantity = $result_quantity->fetch_assoc();
              $book_quantity = $row_quantity['quantity'];
              $book_price = $row_quantity['price'];
              
              $new_quantity = $book_quantity-$quantity;
              $sql_update_quantity = "UPDATE book SET quantity='$new_quantity' WHERE book_id='$book_id'";
              $con->query($sql_update_quantity);
              
              $detail = "Name: ".$name." Card Number: ".$card." CNN: ".$cnn." Expiry date: ".$month;
              $date = new DateTime();
              $stringDate = $date->format('Y-m-d H:i:s');
              $sql_order = "INSERT INTO orders(book_id,user_id,order_date,quantity,price,detail) VALUES('$book_id','$user_id','$stringDate','$quantity','$book_price','$detail')";
              $result_order = $con->query($sql_order);

              $sql_delete_cart = "DELETE FROM cart WHERE user_id='$user_id' AND book_id='$book_id'";
              $con->query($sql_delete_cart);
              $count++;
            }
            if($count == count($db_array)){
              echo "<script>alert('Order placed successfully')</script>";
            }
            else{
              echo "<script>alert('Can\'t place your order')</script>";
            }
            header('location: index.php');
            exit();
        }
    }
    elseif(isset($_POST['cancel'])){
      header('location: checkout.php',);
      exit();
    }

?>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>