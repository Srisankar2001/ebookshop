<?php
  include('connect.php');
  session_start();
  $referring_page = $_SESSION['referring_page'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Product Detail Page</title>
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
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid p-0">
       <!-- nav bar -->
       <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
           <img src="images/logo.jpg" alt="No image" class="logo">
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
          <a class="nav-link" href="signup.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid welcome">
  <div class="d-flex">
    <h4 class="me-3">Welcome Guest</h4>
    <h4><a href="signin.php"><i class="bi bi-box-arrow-in-right px-2"></i>Login</a></h4>
  </div>
</div> 





         
<?php
      $select_book = "SELECT * FROM book WHERE book_id='{$_GET['book_id']}'";
      $result_book = $con->query($select_book);
      $row_book = $result_book->fetch_assoc();
      $book_id = $row_book['book_id'];
          echo ' <div class="row" style="padding-top:100px;"><div class="col-md-4" style="padding-left:50px;">
          <img src="images/'.$row_book['coverimageurl'].'" class="card-img-top" alt="not image" style="width:300px; height:500px;">
          </div>
          <div class="col-md-8">
                    <h3 class="card-title">'.$row_book['title'].'</h3>
                    <h5 class="card-title">By:'.$row_book['author'].'</h5><br>
                    <p class="card-text">'.$row_book['description'].'</p>
                    <p class="card-text">Price:'.$row_book['price'].'</p>
                    <p class="card-text">In Stock:'.$row_book['price'].'</p>
                    <a href="signin.php" class="btn btn-primary">Add to cart</a>
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