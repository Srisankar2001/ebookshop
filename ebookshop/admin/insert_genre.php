<?php
    include('../connect.php');
    if(isset($_POST['insert_genre'])){
        $genre = $_POST['genre'];
        $select_sql = "SELECT * FROM genre WHERE genre_name='$genre'";
        $select_result = $con->query($select_sql);
        if($select_result->num_rows == 0){
            $insert_sql = "INSERT INTO genre(genre_name) VALUES('$genre')";
            $insert_result = $con->query($insert_sql);
            if($insert_result){
                echo "<script>alert('Genre has been added successfully')</script>";
            }
        }else{
            echo "<script>alert('Genre is already exist')</script>";
        }
        
    }
?>
<h2 class="text-center">Insert Genre</h2>
<form action="" method="post" class="mb-2">
<div class="input-group w-50 mb-2 mx-auto">
  <span class="input-group-text" id="basic-addon1"><i class="bi bi-receipt"></i></span>
  <input type="text" class="form-control" name="genre" placeholder="Enter Genre Here" aria-label="Username" aria-describedby="basic-addon1">
</div>
<div class="input-group w-50 mb-2 mx-auto">
    <input type="submit" class="btn btn-success mb-3 px-3" name="insert_genre" value="Insert Genre">
</div>
</form>