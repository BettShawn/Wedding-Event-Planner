 <?php  
 if(isset($_POST["id"]))
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "dbwedding");  
      $query = "SELECT * FROM tbl_features WHERE category_id = {$_POST['id']}";
      $result = mysqli_query($connect, $query);  
      $output .= '  
      <div class="table-responsive">  
            <table class="table table-bordered">
            <tr>  
              <th width="30%"><label>Title</label></th>  
              <th width="70%">Description</th>  
            </tr>';  
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)) {  
                   $output .= '  
                        <tr>  
                             <td width="30%"><label>'.$row["title"].'</label></td>  
                             <td width="70%">'.$row["description"].'</td>  
                        </tr>';  
              }  
            } else {
                    $output .= '  
                        <tr>  
                             <td colspan="2" align="center">No Feature Yet!</td>  
                        </tr>';
            }
      $output .= '</table></div>';  
      echo $output;  
 }  
 ?>
 
