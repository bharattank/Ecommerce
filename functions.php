<?php

    function pr($arr) {
        echo '<pre>';
        print_r($arr);
    }

    function prx($arr) {
        echo '<pre>';
        print_r($arr);
        die();
    }

    function get_safe_value($conn,$str) {
        if(($str!='')){
            $str = trim($str);
            return mysqli_real_escape_string($conn,$str);
        }
    }

    function get_product($conn,$limit = '',$cat_id = '',$product_id= '',$search_str = '',$sort_order='',$is_best_seller = '',$sub_categories = '') {
        $sql = "select product.*,categories.categories from product,categories where product.status=1";
        if($cat_id != ''){
            $sql.=" and product.categories_id=$cat_id ";
        }

        if($product_id != ''){
            $sql.=" and product.id=$product_id ";
        }

        if($sub_categories != ''){
            $sql.=" and product.sub_categories_id=$sub_categories ";
        }

        if($is_best_seller != ''){
            $sql.=" and product.best_seller=1 ";
        }

        $sql.=" and product.categories_id=categories.id ";
        if($search_str != ''){
            $sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%')";
        }

        if($sort_order != ''){
            $sql.=$sort_order;
        }else {
            $sql.=" order by product.id desc";
        }

        if($limit!==''){
            $sql.=" limit $limit";
        }
        
        $res = mysqli_query($conn,$sql);
        $data = array();
        while($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }

    function wishlist_add($conn,$uid,$pid) {
        $added_on = date('Y-m-d h:i:s');
        $sql_wishlist = "insert into `wishlist`(user_id,product_id,added_on) values ('$uid','$pid','$added_on')";
        mysqli_query($conn,$sql_wishlist);
    }

    function productSoldQtybyProductId($conn,$pid) {
        $sql = "select sum(order_detail.qty) as qty from order_detail,`order` where `order`.id=order_detail.order_id and order_detail.product_id=$pid and `order`.order_status!=4 and ((`order`.payment_type='PayU' and `order`.payment_status='success') or (`order`.payment_type='cod' and `order`.payment_status!=''))";
        $res = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_assoc($res);
        return $row['qty'];
    }

    function productQty($conn,$pid) {
        $sql = "select qty from product where id='$pid'";
        $res = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_assoc($res);
        return $row['qty'];
    }
?>