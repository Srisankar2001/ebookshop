<?php
    include('../connect.php');
    if(isset($_POST['insert_book'])){
        $title = $_POST['title'];
        $author = $_POST['author'];
        $description = $_POST['description'];

        if (isset($_POST['genre']) && is_array($_POST['genre'])) {
            $genre = implode(',', $_POST['genre']);
        } else {
            // Handle the case when 'genre' is not set or is not an array
            echo "<script>alert('Please select at least one genre')</script>";
        }
        

        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];

        $date = $_POST['date'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $rating = $_POST['rating'];

        if($title == ''){
            echo "<script>alert('Enter the title')</script>";
        }
        elseif($author == ''){
            echo "<script>alert('Enter the author')</script>";
        }
        elseif(!preg_match('/^[A-Za-z.]{2,}$/',$author)){
            echo "<script>alert('Author name should only contain letters')</script>";
        }
        elseif($description == ''){
            echo "<script>alert('Enter the description')</script>";
        }
        elseif($genre == ''){
            echo "<script>alert('Select the genre')</script>";
        }
        elseif($image == ''){
            echo "<script>alert('Select the image')</script>";
        }
        elseif($date == ''){
            echo "<script>alert('Enter the date')</script>";
        }
        elseif($price == ''){
            echo "<script>alert('Enter the price')</script>";
        }
        elseif (!preg_match('/^\d+(\.\d+)?$/', $price)) {
            echo "<script>alert('Book price should only contain numeric values')</script>";
        }
        elseif($quantity == ''){
            echo "<script>alert('Enter the quantity')</script>";
        }
        elseif($rating == ''){
            echo "<script>alert('Enter the rating')</script>";
        }
        elseif (!preg_match('/^\d+(\.\d+)?$/', $rating)) {
            echo "<script>alert('Book rating should only contain numeric values')</script>";
        }
        elseif($rating<0 || $rating>5){
            echo "<script>alert('Invalid rating. Please enter a value between 0 and 5.')</script>";
        }
        else{
            $sql = "INSERT INTO book(title,author,`description`,coverimageurl,genre,publicationdate,price,quantity,rating) VALUES('$title','$author','$description','$image','$genre','$date','$price','$quantity','$rating')";
            $result = $con->query($sql);
            if($result){
                move_uploaded_file($image_temp,"../images/$image");
                echo "<script>alert('Book successfully inserted')</script>";
            }
            else{
                echo "<script>alert('Book is not inserted')</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center">Insert Books</h1>
        
        <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline mb-4 w-50 m-auto">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter Book Name" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Enter Author Name" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter Book Description" autocomplete="off">
            </div>

            <div class="form-outline mb-4 w-50 m-auto">
                <?php
                        $sql = "SELECT * FROM genre";
                        $result = $con->query($sql);
                        while($row = $result->fetch_assoc()){
                            echo '<label for="'.$row['genre_name'].'" class="form-label col-3">
                            <input type="checkbox" id="'.$row['genre_name'].'" name="genre[]" value="'.$row['genre_id'].'">
                            '.$row['genre_name'].'
                            </label>';
                        }
                    ?>
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" placeholder="Select Image" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="price" class="form-label">Price</label>
                <input type="text" name="price" id="price" class="form-control" placeholder="Enter Book Price" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Book Quantity" autocomplete="off"  min="0">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="date" class="form-label">Publish Date</label>
                <input type="date" name="date" id="date" class="form-control" placeholder="Enter Publish Date" autocomplete="off">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="rating" class="form-label">Rating</label>
                <input type="text" name="rating" id="rating" class="form-control" placeholder="Enter Book Rating" autocomplete="off" min="0" max="5">
            </div>
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_book" class="btn btn-success mb-3 px-3" value="Insert Book">
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>