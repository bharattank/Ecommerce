<?php 
require 'config.php';
require 'functions.php';

$type = get_safe_value($conn,$_POST['type']);
$otp = get_safe_value($conn,$_POST['otp']);

if($type=='email') {
    if($otp==$_SESSION['EMAIL_OTP']){
        echo "done";
    }else{
        echo "no";
    }

}
if($type=='mobile') {
    if($otp==$_SESSION['MOBILE_OTP']){
        echo "done";
    }else{
        echo "no";
    }

}

?>