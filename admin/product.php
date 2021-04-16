<?php 
 require 'header.php';

if(isset($_GET['type']) && $_GET['type'] != '') {
     $type = get_safe_value($conn,$_GET['type']);
    if($type == 'status'){
         $operation = get_safe_value($conn,$_GET['operation']);
         $id = get_safe_value($conn,$_GET['id']);
         if($operation == 'active') {
             $status = '1';
         }else{
            $status = '0';
        }
        $update_status_sql = "update product set status = '$status' where id='$id'";
        mysqli_query($conn,$update_status_sql);
    }

    if($type=='delete'){
        $id = get_safe_value($conn,$_GET['id']);
       $delete_sql ="delete from product where id='$id'";
       mysqli_query($conn,$delete_sql);
    }
}
$sql = "select product.*,categories.categories from product,categories where product.categories_id=categories.id order by product.id desc";

$res = mysqli_query($conn,$sql);
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Products</h4>
                       <a href="manage_product.php" class="ct-anc btn btn-info ct-btn">Add product</a>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Categories</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>MRP</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)){?>
                                    <tr>
                                        <td class="serial"><?php echo $i?></td>
                                        <td><?php echo $row['id']?></td>
                                        <td><?php echo $row['categories']?></td>
                                        <td><?php echo $row['name']?></td>
                                        <td><img src="../media/product/<?php echo $row['image']?>"/></td>
                                        <td><?php echo $row['mrp']?></td>
                                        <td><?php echo $row['price']?></td>
                                        <td><?php echo $row['qty']?>
                                        </br>
                                        <?php
                                        $productSoldQtybyProductId = productSoldQtybyProductId($conn,$row['id']);
                                        $pending_qty =  $row['qty'] - $productSoldQtybyProductId;
                                        ?>
                                        Pending Qty :  <?php echo $pending_qty ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($row['status'] == 1) {
                                                echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'>Active</a></span>&nbsp;";
                                            }else{
                                                echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'>Deactive</a></span>&nbsp;";
                                            }
                                            echo "<span class='badge badge-edit'><a href='manage_product.php?type=edit&id=".$row['id']."'>Edit</a></span>&nbsp;";
                                            echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>&nbsp;";

                                            ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
 require 'footer.php';
?>