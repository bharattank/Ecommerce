<?php 
require 'config.php';
require 'functions.php';

$email = get_safe_value($conn,$_POST['email']);
$password = get_safe_value($conn,$_POST['password']);

$res = (mysqli_query($conn,"select * from users where email = '$email' and password = '$password'"));
$check_user = mysqli_num_rows($res);
if($check_user > 0) {
    $row = mysqli_fetch_assoc($res);
    $_SESSION['USER_LOGIN'] = 'yes';
    $_SESSION['USER_ID'] = $row['id'];
    $_SESSION['USER_NAME'] = $row['name'];
    echo "valid";
}else{
    echo "wrong";
}

?>