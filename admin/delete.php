<?php 
include('connect.php');
try{
    $id = $_POST['id'];
    $sql = "delete  from list_cau_hoi where id ='".$id."'";
    if($conn -> query($sql) == true){
        echo("Xóa Thành Công");
    }else{
        echo("Xóa Thất Bại");
    }
}catch(Exception $e){
    echo "Lỗi: ".$e;
}
?>
