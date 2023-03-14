   <?php
        include('connect.php');

        $search = $_GET['search'];
        $page = $_GET['page'];
        $sql = $conn->prepare("SELECT * FROM list_cau_hoi where question like '%".$search."%' limit 5 offset ".($page-1)*5);
        $sql->execute();
        $index = 1;
        $data = '';
        while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
            $data .= '<tr id=' . $result['ID'] . '>';
            $data .= '<th scope="row" class="text-center">' . ($index++) . '</th>';
            $data .= '<td class="text-primary">' . $result['question'] . '</td>';
            $data .= '<td>';
            $data .= '<button type="" class="btn btn-xs btn-info" name="view"><i class="fas fa-info-circle"></i></button>&nbsp';
            $data .= '<button type="" class="btn btn-xs btn-danger" name="update"><i class="fa fa-edit"></i></button>&nbsp';
            $data .= '<button type="" class="btn btn-xs btn-warning" name="delete"><i class="fas fa-trash-alt"></i></button>';
            $data .= '</td>';
            $data .= '</tr>';
        }
        echo $data;
        ?>