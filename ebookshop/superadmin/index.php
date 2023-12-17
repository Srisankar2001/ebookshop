<?php
  include('../connect.php');
  session_start();
  if(!isset($_SESSION['sadmin_id'])){
    header('Location: ../index.php');
    exit();
  }
  $sadmin_id = $_SESSION['sadmin_id'];
  $sql = "select * from superadmin where sadmin_id='$sadmin_id'";
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
    <title>Super Admin Page</title>
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
        body{
            background-color: #f4f9f4;
        }
        nav{
            background-color: #5c8d89;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container-fluid">
                <img src="../images/logo.jpg" alt="No image" class="logo">
                <div class="ms-auto">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <h4><a href="" class="nav-link">Welcome <?php echo $lname; ?></a></h4>
                        </li>
                    </ul>
                </nav>
            </div>
            </div>
        </nav>

        <div style="margin-top:80px; padding-top:5px; background-color: #f4f9f4;">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>

<div class="row">
    <div class="col-md-2 bg-secondary p-0">
        <ul class="navbar-nav m-auto text-center">
            <li class="nav-item">
            <a href="#" class="nav-link"><h4>Dash Board</h4></a>
            </li>
            <li class="nav-item">
            <a href="index.php?my_info" class="nav-link">My Info</a>
            </li>
            <li class="nav-item">
            <a href="index.php?edit_detail" class="nav-link">Edit Details</a>
            </li>
            <li class="nav-item">
            <a href="index.php?insert_genre" class="nav-link">Add Genre</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_genre" class="nav-link">View Genre</a>
            </li>
            <li class="nav-item">
            <a href="index.php?insert_book" class="nav-link">Add Book</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_book" class="nav-link">View Book</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_allorders" class="nav-link">View All Orders</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_confirmorders" class="nav-link">View Confirmed Orders</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_pendingorders" class="nav-link">View Pending Orders</a>
            </li>
            <li class="nav-item">
            <a href="index.php?add_admin" class="nav-link">Add Admin</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_admin" class="nav-link">View Admin</a>
            </li>
            <li class="nav-item">
            <a href="index.php?view_user" class="nav-link">View User</a>
            </li>
            <li class="nav-item">
            <a href="index.php?logout" class="nav-link">Logout</a>
            </li>
    </ul>
    </div>
    <div class="col-md-10 mx-auto">
        <?php
            if(isset($_GET['my_info'])){
                include('my_info.php');
            }
            elseif(isset($_GET['insert_genre'])){
                include('insert_genre.php');
            }
            elseif(isset($_GET['view_genre'])){
                include('view_genre.php');
            }
            elseif(isset($_GET['insert_book'])){
                include('insert_book.php');
            }
            elseif(isset($_GET['view_book'])){
                include('view_book.php');
            }
            elseif(isset($_GET['add_admin'])){
                include('add_admin.php');
            }
            elseif(isset($_GET['view_admin'])){
                include('view_admin.php');
            }
            elseif(isset($_GET['view_user'])){
                include('view_user.php');
            }
            elseif(isset($_GET['edit_detail'])){
                include('edit_detail.php');
            }
            elseif(isset($_GET['view_allorders'])){
                include('view_allorders.php');
            } 
            elseif(isset($_GET['view_confirmorders'])){
                include('view_confirmorders.php');
            } 
            elseif(isset($_GET['view_pendingorders'])){
                include('view_pendingorders.php');
            }
            elseif(isset($_GET['logout'])){
                include('logout.php');
            }
        ?>
    </div>
</div>

        
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>