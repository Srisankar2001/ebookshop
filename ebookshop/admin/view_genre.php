<div>
  <ul class="navbar-nav m-auto text-center">
    <li class="nav-item">
      <a href="#" class="nav-link"><h4>View Genre</h4></a>
    </li>
    <?php
        $select_genre = "SELECT * FROM genre";
        $result_genre = $con->query($select_genre);
        if($result_genre->num_rows == 0){
            echo '<h2 class="text-center">No Genres added yet</h2>';
        }
        else{
            echo '<div class="container">
            <table class="table">
            <thead>
            <tr>
            <th>Genre ID</th>
            <th>Genre Name</th>
            </thead>
            <tbody>';
            while($row_genre = $result_genre->fetch_assoc()){
                $genre_name = $row_genre['genre_name'];
                $genre_id = $row_genre['genre_id'];
                echo '<tr>
                <td>'.$genre_id.'</td>
                <td>'.$genre_name.'</td>
                </tr>';
            }
            echo '</tbody></table></div>';

        }
        
    ?>
  </ul>
</div>
