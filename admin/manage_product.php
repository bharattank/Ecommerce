<?php 
 require 'header.php';
 $categories_id = '';
 $name = '';
 $mrp = '';
 $price = '';
 $qty = '';
 $image = '';
 $short_desc = '';
 $description = '';
 $meta_title = '';
 $meta_desc = '';
 $meta_keyword = '';
 $best_seller = '';
 $sub_categories_id  = '';



 $msg = '';

 if(isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($conn,$_GET['id']);
    $res = mysqli_query($conn,"select * from product where id='$id'");
    $check = mysqli_num_rows($res);
    if($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories_id = $row['categories_id'];
        $sub_categories_id = $row['sub_categories_id'];
        $name = $row['name'];
        $mrp = $row['mrp'];
        $price = $row['price'];
        $qty = $row['qty'];
        $short_desc = $row['short_desc'];
        $description = $row['description'];
        $meta_title = $row['meta_title'];
        $meta_desc = $row['meta_desc'];
        $meta_keyword = $row['meta_keyword'];
        $best_seller = $row['best_seller'];
    }else{
        header('location:product.php');
        die();
    }
    
}


if(isset($_POST['submit'])) {
     $categories_id = get_safe_value($conn,$_POST['categories_id']);
     $sub_categories_id = get_safe_value($conn,$_POST['sub_categories_id']);
     $name = get_safe_value($conn,$_POST['name']);
     $mrp = get_safe_value($conn,$_POST['mrp']);
     $price = get_safe_value($conn,$_POST['price']);
     $qty = get_safe_value($conn,$_POST['qty']);
     $short_desc = get_safe_value($conn,$_POST['short_desc']);
     $description = get_safe_value($conn,$_POST['description']);
     $meta_title = get_safe_value($conn,$_POST['meta_title']);
     $meta_desc = get_safe_value($conn,$_POST['meta_desc']);
     $meta_keyword = get_safe_value($conn,$_POST['meta_keyword']);
     $best_seller = get_safe_value($conn,$_POST['best_seller']);

     $res = mysqli_query($conn,"select * from product where name='$name'");
     $check = mysqli_num_rows($res);
     if($check > 0){
        if(isset($_GET['id']) && $_GET['id'] != ''){
            $getData = mysqli_fetch_assoc($res);
            if($id == $getData['id']){

            }else{
                $msg = "Product Already Exists";
            }
        }else{
            $msg = "Product Already Exists";
        }
     }

     if($msg == ''){
        if(isset($_GET['id']) && $_GET['id'] !='') {
            if($_FILES['image']['name'] != ''){
                $image = rand(1111111,9999999).'_'.$_FILES['image'] ['name'];
                move_uploaded_file($_FILES['image'] ['tmp_name'],'../media/product/'.$image);
                $sql = "update product set categories_id = '$categories_id',name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',short_desc = '$short_desc',description = '$description',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword',image = '$image',best_seller = '$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            }else{
            $sql = "update product set categories_id = '$categories_id',name = '$name',mrp = '$mrp',price = '$price',qty = '$qty',short_desc = '$short_desc',description = '$description',meta_title = '$meta_title',meta_desc = '$meta_desc',meta_keyword = '$meta_keyword',best_seller = '$best_seller',sub_categories_id='$sub_categories_id' where id='$id'";
            }
            mysqli_query($conn,$sql);
        }else{
            $image = rand(1111111,9999999).'_'.$_FILES['image'] ['name'];
            move_uploaded_file($_FILES['image'] ['tmp_name'],'../media/product/'.$image);
            $sql = "insert into product (categories_id,name,mrp,price,qty,image,short_desc,description,meta_title,meta_desc,meta_keyword,status,best_seller,sub_categories_id) 
            values ('$categories_id','$name','$mrp','$price','$qty','$image','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','1',$best_seller,'$sub_categories_id')";
            mysqli_query($conn,$sql);
        }   

        header('location:product.php');
        die();
     }
}

?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Product</strong><small> Form</small></div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="card-body card-block">
                                <div class="form-group"><label for="categories" class=" form-control-label">Categories</label>
                                   <select class="form-control" name="categories_id" id="categories_id" onchange="get_sub_cat('')" required>
                                        <option>Select Categories</option>
                                        <?php 
                                        $res = mysqli_query($conn,"select id,categories from categories order by categories asc");
                                        while($row = mysqli_fetch_assoc($res)) {
                                            if($row['id'] ==$categories_id){
                                                echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                            }else{
                                                echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                            }
                                        }
                                        ?>
                                   </select>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Sub Categories</label>
                                   <select class="form-control" name="sub_categories_id" id="sub_categories_id" required>
                                        <option>Select sub Categories</option>
                                        
                                   </select>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Product Name</label>
                                    <input type="text" name="name" placeholder="Enter your Product name" class="form-control" required value="<?php echo $name ?>">
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Best Seller</label>
                                   <select class="form-control" name="best_seller" required>
                                       <option value="">Select</option>
                                       <?php
                                       if($best_seller == "1"){
                                           echo '<option value="1" selected>Yes</option>
                                           <option value="0">No</option>';
                                       }elseif($best_seller == "0"){
                                        echo '<option value="1">Yes</option>
                                            <option value="0" selected>No</option>';
                                        }else {
                                            echo '<option value="1">Yes</option>
                                            <option value="0">No</option>';
                                        }
                                        ?>
                                   </select>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">MRP</label>
                                    <input type="text" name="mrp" placeholder="Enter your Product MRP" class="form-control" required value="<?php echo $mrp ?>">
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Price</label>
                                    <input type="text" name="price" placeholder="Enter your Product Price" class="form-control" required value="<?php echo $price ?>">
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Qty</label>
                                    <input type="text" name="qty" placeholder="Enter your Product qty" class="form-control" required value="<?php echo $qty ?>">
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Image</label>
                                    <input type="file" name="image" placeholder="Enter your Product name" class="form-control">
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Short Desc</label>
                                    <textarea name="short_desc" placeholder="Enter your Product Short description" class="form-control" required><?php echo $short_desc ?></textarea>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Description</label>
                                    <textarea name="description" placeholder="Enter your Product description" class="form-control"><?php echo $description ?></textarea>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Meta Title</label>
                                    <textarea name="meta_title" placeholder="Enter your Product Meta title" class="form-control"><?php echo $meta_title ?></textarea>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Meta Description</label>
                                    <textarea name="meta_desc" placeholder="Enter your Product Meta Description" class="form-control"><?php echo $meta_desc ?></textarea>
                                </div>
                                <div class="form-group"><label for="categories" class=" form-control-label">Meta Keyword</label>
                                    <textarea name="meta_keyword" placeholder="Enter your Product Meta Keyword" class="form-control"><?php echo $meta_keyword ?></textarea>
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


        <script>
            function get_sub_cat(sub_cat_id) {
                var categories_id = jQuery('#categories_id').val();
                jQuery.ajax({
                    url:'get_sub_cat.php',
                    type:'post',
                    data:'categories_id='+categories_id+'&sub_cat_id='+sub_cat_id,
                    success:function(result) {
                        jQuery('#sub_categories_id').html(result);
                    }
                });
            }
        </script>
<?php 
 require 'footer.php';
?>
<script>
<?php
if(isset($_GET['id'])){
    ?>
    get_sub_cat('<?php echo $sub_categories_id ?>');
    <?php }?>
</script>