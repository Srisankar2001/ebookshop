<div>
  <ul class="navbar-nav m-auto text-center">
    <li class="nav-item">
      <a href="#" class="nav-link"><h4>View Book</h4></a>
    </li>
    <?php
        $select_book = "SELECT * FROM book";
        $result_book = $con->query($select_book);
        if($result_book->num_rows == 0){
            echo '<h2 class="text-center">No Books added yet</h2>';
        }
        else{
            echo '<div class="container">
            <table class="table">
            <thead>
            <tr>
            <th>Book ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Price</th>
            <th>Genre</th>
            <th>Rating</th>
            <th>Quantity</th>
            </thead>
            <tbody>';
            while($row_book = $result_book->fetch_assoc()){
                $book_id = $row_book['book_id'];
                $title = $row_book['title'];
                $author = $row_book['author'];
                $description = $row_book['description'];
                $price = $row_book['price'];
                $genre = $row_book['genre'];
                $genre_array = explode(",",$genre);
                $rating = $row_book['rating'];
                $quantity = $row_book['quantity'];
                echo '<tr>
                <td>'.$book_id.'</td>
                <td>'.$title.'</td>
                <td>'.$author.'</td>
                <td>'.$description.'</td>
                <td>'.$price.'</td><td>';
                
                $select_genre = "SELECT * FROM genre";
                $result_genre = $con->query($select_genre);
                while($row_genre = $result_genre->fetch_assoc()){
                  if(in_array($row_genre['genre_id'],$genre_array)){
                    echo "{$row_genre['genre_name']}<br>";
                  }
                }
                echo '</td><td>'.$rating.'</td>
                <td>'.$quantity.'</td>
                </tr>';
            }
            echo '</tbody></table></div>';

        }
        
    ?>
  </ul>
</div>
