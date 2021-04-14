<?php 
 require 'header.php';
 $categories = '';
 $msg = '';
 $sub_categories = '';
 if(isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($conn,$_GET['id']);
    $res = mysqli_query($conn,"select * from sub_categories where id='$id'");
    $check = mysqli_num_rows($res);
    if($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $sub_categories = $row['sub_categories'];
        $categories = $row['categories_id'];
    }else{
        header('location:sub_categories.php');
        die();
    }
    
}


if(isset($_POST['submit'])) {
     $categories = get_safe_value($conn,$_POST['categories_id']);
     $sub_categories = get_safe_value($conn,$_POST['sub_categories']);


     $res = mysqli_query($conn,"select * from sub_categories where categories_id='$categories' and sub_categories='$sub_categories'");
     $check = mysqli_num_rows($res);
     if($check > 0){
        if(isset($_GET['id']) && $_GET['id'] != ''){
            $getData = mysqli_fetch_assoc($res);
            if($id == $getData['id']){

            }else{
                $msg = "Sub Categories Already Exists";
            }
        }else{
            $msg = "Sub Categories Already Exists";
        }
     }

     if($msg == ''){
        if(isset($_GET['id']) && $_GET['id'] !='') {
            $sql = "update sub_categories set categories_id = '$categories',sub_categories = '$sub_categories' where id='$id'";
            mysqli_query($conn,$sql);
        }else{
            $sql = "insert into sub_categories (categories_id,sub_categories,status) values ('$categories','$sub_categories','1')";
            mysqli_query($conn,$sql);
        }   

        header('location:sub_categories.php');
        die();
     }
}

?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Sub Categories</strong><small> Form</small></div>
                        <form method="post">
                            <div class="card-body card-block">
                                <div class="form-group"><label for="categories" class=" form-control-label">Categories</label>
                                   <select class="form-control" name="categories_id" required>
                                    <option value="">Select Caategories</option>
                                    <?php 
                                    $res = mysqli_query($conn,"select * from categories where status='1'");
                                    while($row = mysqli_fetch_assoc($res)){
                                        if($row['id'] == $categories){
                                            echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
                                        }else{
                                            echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                        }
                                    }
                                    ?>
                                   </select>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Sub Categories</label>
                                    <input type="text" name="sub_categories" placeholder="Enter sub categories" class="form-control" required value="<?php echo $sub_categories ?>">
                                </div>
                                <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Submit</span>
                                </button>
                                <div class="field_error"><?php echo $msg?></div>
                            </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>

<?php 
 require 'footer.php';
?>