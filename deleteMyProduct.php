<?php
    include 'connect.php';
    //get id tren url
    $id = $_GET['id'];
        
    //Viết câu SQL lấy tất cả dữ liệu trong bảng players
    $sql = "DELETE FROM `product` WHERE `id`='".$id."'";
    // Chạy câu SQL
    if ($result = $con->query($sql)) {
        header("location: ./create-product.php");
    }
?>