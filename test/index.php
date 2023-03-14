<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn English</title>
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
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">Bài Kiểm Tra</div>
                <div class="panel-body">
                    <div class="row">
                    <div class="col-sm-12 text-left">
                           <a href="http://localhost/tracnghiem/trangchu/"> <button type="button" name="button" class="btn btn-success" id="btnReatuenHome">Trang Chủ</button></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" name="button" class="btn btn-success" id="btnStart">Bắt Đầu</button>
                        </div>
                    </div>
                    <div id="questions"> </div>
                    <div class="row">
                        <div class="col-sm-12 text-right text-center">
                            <button type="button" name="button" class="btn btn-warning" id="btnFinish">Nộp Bài</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right text-center">
                            <h4 id="mark" class="btn btn-info"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function() {
        $('#btnFinish').hide();
    });

    var questions;
    $('#mark').text(function() {
        $(this).hide();
    })
    $('#btnStart').click(function() {
        GetQuestions();
        $('#btnFinish').show();
        $('#mark').hide();
        $(this).hide();
    });
    $('#btnFinish').click(function() {
        $(this).hide();
        $('#btnStart').show();
        $('#mark').show();

        CheckResult();
    });

    function CheckResult() {
        let mark = 0;
        $('#questions div.row').each(function(k, v) { // lấy thông tin của thẻ h5
            let id = $(v).find('h5').attr('id'); // lấy id 
            let question = questions.find(x => x.ID == id); // lấy câu hỏi dựa trên id 
            let answer = question['answer']; // lấy đáp án đúng dựa trên câu hỏi
            console.log(answer);

            let choice = $(v).find('fieldset input[type = "radio"]:checked').attr('class'); // lấy câu trả được chọn      
            if (choice == answer) {
                console.log('Câu có ID= ' + id + 'Đúng');
                mark += 1;
            } else {
                console.log('Câu có ID= ' + id + 'Sai');
            }


            $('#question_' + id + ' > fieldset > div > label.' + answer).css("background-color", "yellow");
        });
        $('#mark').text('Điểm của bạn là: ' + mark);

    }

    function GetQuestions() {
        $.ajax({
            url: 'questions.php',
            type: 'GET',
            success: function(data) {
                questions = jQuery.parseJSON(data);
                let index = 1;
                let d = '';
                $.each(questions, function(k, v) { // lặp question
                    d += '<div class="row" style="margin-left: 10px;" id="question_' + v['ID'] + '">';
                    d += '<h5 style=" font-weight: bold;" id="' + v['ID'] + '"><span class="text-success">Câu ' + index + ':  </span>' + v['question'] + '</h5>';
                    d += '<fieldset>';
                    d += '<div class="radio col-md-12">';
                    d += '<label class="A"><input type="radio" id="rdOptionA" class="A" name="' + v['ID'] + '"><span class="text-danger">A. </span>' + v['option_a'] + '</label>';
                    d += '</div>';

                    d += '<div class="radio col-md-12">';
                    d += '<label class="B"><input type="radio"  id="rdOptionB" class="B" name="' + v['ID'] + '"><span class="text-danger">B. </span>' + v['option_b'] + '</label>';
                    d += '</div>';

                    d += '<div class="radio col-md-12">';
                    d += '<label class="C"><input type="radio"  id="rdOptionC" class ="C" name="' + v['ID'] + '"><span class="text-danger">C. </span>' + v['option_c'] + '</label>';
                    d += '</div>';

                    d += '<div class="radio col-md-12">';
                    d += '<label class="D"><input type="radio" id="rdOptionD" class ="D" name="' + v['ID'] + '"<span class="text-danger">D. </span>' + v['option_d'] + '</label>';
                    d += '</div>';

                    d += '</div>';
                    d += '</fieldset>';
                    index++;
                });
                $('#questions').html(d);
            }
        });
    }
</script>