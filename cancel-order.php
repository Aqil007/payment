<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    if(isset($_GET['oid'])) {
        $orderId = intval($_GET['oid']);
        $query = mysqli_query($con, "UPDATE orders SET orderStatus='Cancelled' WHERE id='$orderId' AND userId='".$_SESSION['id']."'");

        if($query) {
            $_SESSION['msg'] = "Order cancelled successfully.";
        } else {
            $_SESSION['msg'] = "Order cancellation failed.";
        }
    }
    header('location:order-history.php');
}
?>
