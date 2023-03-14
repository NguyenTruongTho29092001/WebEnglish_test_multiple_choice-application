<div class="modal" tabindex="-1" role="dialog" id="modalQuestion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Câu Hỏi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="txtQuestionId" hidden value="">
                <div class="form-group">
                    <textarea class="form-control" id="txaQuestion" rows="1" placeholder="Câu Hỏi"></textarea>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="txaOptionA" rows="1" placeholder="Đáp Án A"></textarea>
                </div>

                <div class="form-group">
                    <textarea class="form-control" id="txaOptionB" rows="1" placeholder="Đáp Án B"></textarea>
                </div>

                <div class="form-group">
                    <textarea class="form-control" id="txaOptionC" rows="1" placeholder="Đáp Án C"></textarea>
                </div>

                <div class="form-group">
                    <textarea class="form-control" id="txaOptionD" rows="1" placeholder="Đáp Án D"></textarea>
                </div>

                <div class="row">

                    <div class="radio col-sm-5">
                        <label><input type="radio" name="optradio" id="rdOptionA"> Đáp Án A</label>
                    </div>
                    <div class="radio col-sm-5">
                        <label><input type="radio" name="optradio" id="rdOptionB"> Đáp Án B</label>
                    </div>
                    <div class="radio col-sm-5">
                        <label><input type="radio" name="optradio" id="rdOptionC"> Đáp Án C</label>
                    </div>
                    <div class="radio col-sm-5">
                        <label><input type="radio" name="optradio" id="rdOptionD"> Đáp Án D</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSubmit">Xác Nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#btnSubmit').click(function() {
        let question = $('#txaQuestion').val().trim();
        let option_a = $('#txaOptionA').val().trim();
        let option_b = $('#txaOptionB').val().trim();
        let option_c = $('#txaOptionC').val().trim();
        let option_d = $('#txaOptionD').val().trim();
        let answer = $('#rdOptionA').is(':checked') ? 'A' : $('#rdOptionB').is(':checked') ? 'B' : $('#rdOptionC').is(':checked') ? 'C' : $('#rdOptionD').is(':checked') ? 'D' : '';


        if (question.length == 0 || option_a.length == 0 || option_b.length == 0 || option_c.length == 0 || option_d.length == 0) {
            alert('Vui lòng nhập đầy đủ dữ liệu');
            return;
        }

        if (answer == 0) {
            alert('Vui lòng chọn đáp án');
            return;
        }

        let questionId = $('#txtQuestionId').val();
        if (questionId.length == 0) {
            $.ajax({
                url: 'add_question.php',
                type: 'post',
                data: {
                    question: question, // left = name, right = value
                    option_a: option_a,
                    option_b: option_b,
                    option_c: option_c,
                    option_d: option_d,
                    answer: answer
                },
                success: function(data) {
                    alert(data);
                    $('#modalQuestion').show();
                    $('#txaQuestion').val('');
                    $('#txaOptionA').val('');
                    $('#txaOptionB').val('');
                    $('#txaOptionC').val('');
                    $('#txaOptionD').val('');

                    $('#rdOptionA').prop('checked', false);
                    $('#rdOptionB').prop('checked', false);
                    $('#rdOptionC').prop('checked', false);
                    $('#rdOptionD').prop('checked', false);

                    $('#btnSearch').click();
                }
            });
        } else {
            $.ajax({
                url: 'update.php',
                type: 'post',
                data: {
                    id: questionId,
                    question: question, // left = name, right = value
                    option_a: option_a,
                    option_b: option_b,
                    option_c: option_c,
                    option_d: option_d,
                    answer: answer
                },
                success: function(data) {
                    alert(data);
                    $('#modalQuestion').modal('hide');
                    $('#btnSearch').click();
                }
            });
        }
    });
</script>