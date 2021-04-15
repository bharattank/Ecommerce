<?php 
require 'config.php';
require 'functions.php';
require 'add_to_cart.php';

$pid = get_safe_value($conn,$_POST['pid']);
$qty = get_safe_value($conn,$_POST['qty']);
$type = get_safe_value($conn,$_POST['type']);

$productSoldQtybyProductId = productSoldQtybyProductId($conn,$pid);
$productQty = productQty($conn,$pid);

$pendingQty = $productQty-$productSoldQtybyProductId;

if($qty > $pendingQty)  {
    echo "not_available";
    die();
}

$obj = new add_to_cart();

if($type == 'add') {
    $obj->addProduct($pid,$qty);
}

if($type == 'remove') {
    $obj->removeProduct($pid);
}

if($type == 'update') {
    $obj->updateProduct($pid,$qty);
}

echo $obj->totalProduct();

?>