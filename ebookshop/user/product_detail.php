<?php
  include('../connect.php');
  session_start();
  if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    exit();
  }
  $referring_page = $_SESSION['referring_page'];
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
    <title>User Product Details Page</title>
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

    </style>
</head>
<body>
    <div class="container-fluid p-0">
       <!-- nav bar -->
       <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
          <a class="nav-link" href="#">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="bi bi-cart-fill"></i><sup id="cart">0</sup>Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Totalprice <span id="total"></span></a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="search.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_book">
        <!-- <button class="btn btn-outline-dark" type="submit">Search</button> -->
        <input type="submit" class="border-0 p-2 my-3" name="search" value="Search">
      </form>
    </div>
  </div>
</nav>

<div class="row">
  <div class="d-flex">
    <h4 class="me-3">Welcome <?php echo "$lname"; ?></h4>
    <h4><a href="products.php?logout">Logout</a></h4>
  </div>
</div> 

<?php
  if(isset($_GET['logout'])){
    include('logout.php');
  }
?>

<!-- cart function -->
<?php
  if(isset($_GET['cart'])){
    $book_id = $_GET['cart'];
    $select_sql = "SELECT * FROM cart WHERE user_id='$user_id' AND book_id='$book_id'";
    $select_result = $con->query($select_sql);
    if($select_result->num_rows == 0){
        $datetime = date("Y-m-d H:i:s");
        $insert_sql = "INSERT INTO cart VALUES('$book_id','$user_id',1,'$datetime')";
        $insert_result = $con->query($insert_sql);
        if($insert_result){
            echo "<script>alert('Book added to cart successfully.')</script>";
            echo "<script>window.open('$referring_page','_self')</script>";
            exit();
        }
        else{
            echo "<script>alert('Some thing wrong. Failed to add to cart.')</script>";
            echo "<script>window.open('$referring_page','_self')</script>";
            exit();
        }
    }
    else{
        echo "<script>alert('Book is already added to cart.')</script>";
        echo "<script>window.open('$referring_page','_self')</script>";
        exit();
    }
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

<!-- total price count -->
<?php
   $select_sql = "SELECT * FROM cart WHERE user_id='$user_id'";
   $select_result = $con->query($select_sql);
   if($select_result->num_rows != 0){
     $price = 0;
     while($row_result = $select_result->fetch_assoc()){
      $book_id = $row_result['book_id'];
      $sql =  "SELECT * FROM book WHERE book_id='$book_id'";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $price += $row['price'];
     }
     echo "<script> let total = document.getElementById('total')
     total.innerText = '$price'</script>";
   }
?>
         
          <?php
                $select_book = "SELECT * FROM book WHERE book_id='{$_GET['book_id']}'";
                $result_book = $con->query($select_book);
                $row_book = $result_book->fetch_assoc();
                $book_id = $row_book['book_id'];
                    echo ' <div class="row"><div class="col-md-4">
                    <img src="../images/'.$row_book['coverimageurl'].'" class="card-img-top" alt="not image">
                    </div>
                    <div class="col-md-8">
                              <h3 class="card-title">'.$row_book['title'].'</h3>
                              <h5 class="card-title">By:'.$row_book['author'].'</h5><br>
                              <p class="card-text">'.$row_book['description'].'</p>
                              <p class="card-text">Price:'.$row_book['price'].'</p>
                              <p class="card-text">In Stock:'.$row_book['price'].'</p>
                              <a href="product_detail.php?cart='.$book_id.'" class="btn btn-primary">Add to cart</a>
                              <a href="product_detail.php?exit" class="btn btn-secondary">View Less</a>
                  </div>  </div>';
            ?>
                
  <?php
    if(isset($_GET['exit'])){
      echo "<script>window.open('$referring_page','_self')</script>";
      exit();
    }
  ?>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>