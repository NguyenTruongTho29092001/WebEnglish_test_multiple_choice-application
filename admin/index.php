<?php 
  session_start();
  if( !isset($_SESSION['username'])) {
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <!--jquery cdn-->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <!--font awesome cdn-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">

    <div class="row">
      <!-- tìm kiếm -->
      <div class="col-sm-4">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tìm Kiếm" id="txtSearch" />
          <div class="input-group-btn">
            <button class="btn btn-primary" type="submit" id="btnSearch">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-10">
    </div>
    <div class="col-sm-2 text-right">
    <a href="http://localhost/tracnghiem/trangchu"><button id="btnLogOut" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Log Out</button></a>
    </div>
    <div class="col-sm-1 text-right">
       <button id="btnAdd" class="btn btn-sm btn-success"><i class="fa fa-plus"></i>Thêm Câu Hỏi </button>
    </div>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col" class="col-xs-1 text-center">Số Thứ Tự</th>
        <th scope="col">Câu Hỏi</th>
      </tr>
    </thead>
    <tbody id="questions">
    </tbody>
  </table>
  <div class="col-sm-12 text-center">
  <nav aria-label="Page navigation example">
        <ul class="pagination" id="pagenination">
        </ul>
      </nav>
  </div>
  </div>
</body>

</html>
<?php include('mdlQuestion.php') ?>
<script type="text/javascript">
  var page = 1;
  $(document).ready(function() {
    $('#btnSearch').click();
  });

  $('#btnSearch').click(function() {
    let search = $('#txtSearch').val().trim();
    ReadData(search);
    Pagenination(search);
    ReadData($('#txtSearch').val());
  });

  $('#btnAdd').click(function() {
    $('#txtQuestionId').val('');

    $('#modalQuestion').val('');
    $('#txaQuestion').val('');
    $('#txaOptionA').val('');
    $('#txaOptionB').val('');
    $('#txaOptionC').val('');
    $('#txaOptionD').val('');

    $('#rdOptionA').prop('checked', false);
    $('#rdOptionB').prop('checked', false);
    $('#rdOptionC').prop('checked', false);
    $('#rdOptionD').prop('checked', false);

    $('#modalQuestion').modal();
  });
  $(document).on('click', "button[name=view]", function() {
    var bid = this.ID;
    var trid = $(this).closest('tr').attr('id');
    GetDetail(trid);
    $('#txaQuestion').attr('readonly', 'readonly');
    $('#txaOptionA').attr('readonly', 'readonly');
    $('#txaOptionB').attr('readonly', 'readonly');
    $('#txaOptionC').attr('readonly', 'readonly');
    $('#txaOptionD').attr('readonly', 'readonly');

    $('#rdOptionA').attr('disabled', true);
    $('#rdOptionB').attr('disabled', true);
    $('#rdOptionC').attr('disabled', true);
    $('#rdOptionD').attr('disabled', true);

    $('#btnSubmit').hide();
  })
  $(document).on('click', "button[name=update]", function() {
    var bid = this.ID;
    var trid = $(this).closest('tr').attr('id');
    GetDetail(trid);
    $('#txaQuestion').attr('readonly', false);
    $('#txaOptionA').attr('readonly', false);
    $('#txaOptionB').attr('readonly', false);
    $('#txaOptionC').attr('readonly', false);
    $('#txaOptionD').attr('readonly', false);

    $('#rdOptionA').attr('disabled', false);
    $('#rdOptionB').attr('disabled', false);
    $('#rdOptionC').attr('disabled', false);
    $('#rdOptionD').attr('disabled', false);
    $('#btnSubmit').show();

    $('#txtQuestionId').val(trid);
  })
  $(document).on('click', "button[name=delete]", function() {
    var trid = $(this).closest('tr').attr('id');
    if (confirm("Bạn Muốn Xóa Câu Hỏi Này Chứ ?") == true) {
      $.ajax({
        url: 'delete.php',
        type: 'post',
        data: {
          id: trid
        },
        success: function(data) {
          alert(data);
          ReadData(search);
        }
      });
    }
  })

  function GetDetail(id) {
    $.ajax({
      url: 'detail.php',
      type: 'Get',
      data: {
        id: id
      },
      success: function(data) {
        var obj = jQuery.parseJSON(data);
        console.log(obj['question']);
        $('#txaQuestion').val(obj['question']);
        $('#txaOptionA').val(obj['option_a']);
        $('#txaOptionB').val(obj['option_b']);
        $('#txaOptionC').val(obj['option_c']);
        $('#txaOptionD').val(obj['option_d']);
        $('#modalQuestion').modal();
        switch (obj['answer']) {
          case 'A':
            $('#rdOptionA').prop('checked', true);
            break;
          case 'B':
            $('#rdOptionB').prop('checked', true);
            break;
          case 'C':
            $('#rdOptionC').prop('checked', true);
            break;
          case 'D':
            $('#rdOptionD').prop('checked', true);
            break;
        }
      }
    });
  }

  function ReadData(search) {
    $.ajax({
      url: 'view.php',
      type: 'get',
      data: {
        search: search,
        page: page
      },
      success: function(data) {
        $('#questions').empty();
        $('#questions').append(data);
      }
    });
  }
  $('#txtSearch').on('keypress', function(dem) {
    if (dem.which === 13) {
      $('#btnSearch').click();
    }
  });

  $("#pagenination").on("click","li a",function(event){
    event.preventDefault();
    page = $(this).text();
    ReadData($('#txtSearch').val());
  })
 
  function Pagenination(search){
    $.ajax({
      url: 'pagenination.php',
      type: 'get',
      data: {
        search: search
      },
      success: function(data) {
        console.log(data);
        if(data <= 1){
          $('#pagenination').hide();
        }else{
          $('#pagenination').show();
          let page = '';
          for( i = 1; i<=data;i++){
            page += '<li class="page-item"><a class="page-link" href="">'+i+'</a></li>';
          }
          $('#pagenination').empty(page);
          $('#pagenination').append(page);
        }
      }
    });
  }
</script>