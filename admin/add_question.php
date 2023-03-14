<?php 
try{
    include('connect.php');
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $answer = $_POST['answer'];

    // echo $question,"<br>";
    // echo $option_a,"<br>";
    // echo $option_b,"<br>";
    // echo $option_c,"<br>";
    // echo $option_d,"<br>";
    // echo $answer;

    $sql = "insert into list_cau_hoi(question,option_a,option_b,option_c,option_d,answer)";
    $sql = $sql."values('".$question."','".$option_a."','".$option_b."','".$option_c."','".$option_d."','".$answer."')";
    if ($conn->query($sql) == TRUE) {
        echo "Thêm câu hỏi mới thành công";
      }else {
        echo "Không thêm được câu hỏi";
      }
}catch(Exception ){
    echo "Lỗi: ";
}
?>