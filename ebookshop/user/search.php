<?php
  include('../connect.php');
  session_start();
  $_SESSION['referring_page'] = $_SERVER['REQUEST_URI'];
  if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php');
    exit();
  }
  if(!isset($_GET['search_book'])){
    $search = $_SESSION['search_book'];
  }
  else{
    $search = $_GET['search_book'];
    $_SESSION['search_book'] = $search;
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
    <title>User Search Page</title>
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
          <a class="nav-link" href="profile.php?allorders">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="bi bi-cart-fill"></i><sup id="cart">0</sup>Cart</a>
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
    <h4><a href="search.php?logout">Logout</a></h4>
  </div>
</div>

<?php
  if(isset($_GET['logout'])){
    include('logout.php');
  }
?>

<!-- genre option -->
<div class="row">
<div class="col-md-2 bg-secondary p-0">
  <ul class="navbar-nav m-auto text-center">
    <li class="nav-item">
      <a href="#" class="nav-link"><h4>Genre</h4></a>
    </li>
    <?php
        $select_genre = "SELECT * FROM genre";
        $result_genre = $con->query($select_genre);
        while($row_genre = $result_genre->fetch_assoc()){
          $genre_name = $row_genre['genre_name'];
          $genre_id = $row_genre['genre_id'];
          echo '<li class="nav-item">
          <a href="search.php?genre='.$genre_id.'" class="nav-link">'.$genre_name.'</a>
          </li>';
        }
    ?>
  </ul>
</div>

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
            echo "<script>window.open('products.php','_self')</script>";
        }
        else{
            echo "<script>alert('Some thing wrong. Failed to add to cart.')</script>";
            echo "<script>window.open('products.php','_self')</script>";
        }
    }
    else{
        echo "<script>alert('Book is already added to cart.')</script>";
        echo "<script>window.open('products.php','_self')</script>";
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




<!-- item display -->
    <div class="col-md-10 justify-content-end">
          <div class="row">
            <?php
            if(!isset($_GET['genre'])){
              $select_book = "SELECT * FROM book WHERE title LIKE '%$search%' order by rand()";
                $result_book = $con->query($select_book);
                if($result_book->num_rows != 0){
                    while($row_book = $result_book->fetch_assoc()){
                      $book_id = $row_book['book_id'];
                        echo '<div class="col-md-3 my-2">
                        <div class="card" style="width: 18rem;">
                          <img src="../images/'.$row_book['coverimageurl'].'" class="card-img-top" alt="not image">
                          <div class="card-body">
                                  <h5 class="card-title">'.$row_book['title'].'</h5>
                                  <p class="card-text">'.$row_book['description'].'</p>
                                  <p class="card-text">Price:'.$row_book['price'].'</p>
                                  <a href="search.php?cart='.$book_id.'" class="btn btn-primary">Add to cart</a>
                                  <a href="product_detail.php?book_id='.$book_id.'" class="btn btn-secondary">View More</a>
                          </div>
                        </div>
                      </div>';
                    }
                }
                else{
                    echo "<h2 class='text-center text-danger'>There is no result for \"$search\"</h2>";
                }
            }
            else{
              $select_book = "SELECT * FROM book WHERE FIND_IN_SET('{$_GET['genre']}', genre) AND title LIKE '%$search%' order by rand()";
                $result_book = $con->query($select_book);
                if($result_book->num_rows == 0){
                    echo '<h3>No books avalible in this genre.</h3>';
                }
                else{
                  while($row_book = $result_book->fetch_assoc()){
                    $book_id = $row_book['book_id'];
                    echo '<div class="col-md-3 my-2">
                    <div class="card" style="width: 18rem;">
                      <img src="../images/'.$row_book['coverimageurl'].'" class="card-img-top" alt="not image">
                      <div class="card-body">
                              <h5 class="card-title">'.$row_book['title'].'</h5>
                              <p class="card-text">'.$row_book['description'].'</p>
                              <p class="card-text">Price:'.$row_book['price'].'</p>
                              <a href="search.php?cart='.$book_id.'" class="btn btn-primary">Add to cart</a>
                              <a href="product_detail.php?book_id='.$book_id.'" class="btn btn-secondary">View More</a>
                      </div>
                    </div>
                  </div>';
                }
                }
            }
                
            ?>
                
            </div>
      </div>
     



    </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>