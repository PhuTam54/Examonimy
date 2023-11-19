{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        // Xử lý sự kiện khi click vào "Show more"--}}
{{--        $('#show-more-checkbox').change(function() {--}}
{{--            if ($(this).prop('checked')) {--}}
{{--                // Nếu checkbox được chọn, hiển thị tất cả câu hỏi--}}
{{--                $('.question-container:hidden').fadeIn();--}}
{{--            } else {--}}
{{--                // Nếu checkbox không được chọn, ẩn tất cả câu hỏi sau câu thứ 16--}}
{{--                $('.question-container:gt(20)').fadeOut();--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

<script>
    $(document).ready(function() {
        {{-- Count down--}}
        // Khởi tạo thời gian từ Local Storage hoặc mặc định nếu không có
        const examIdInput = $('input[type=hidden][name="examId"]').val()
        let time = localStorage.getItem(`examTime${examIdInput}`) || {{ $examination->ExamQuestion->duration }};

        const countdownEl = document.getElementById('countdown');
        const durationEl = document.getElementById('duration');
        const examForm = document.getElementById('exam-form');

        // Cập nhật thời gian từ Local Storage
        updateCountdown();

        const intervalId = setInterval(updateCountdown, 1000);

        function updateCountdown() {
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor((time % 3600) / 60);
            let seconds = time % 60;

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            countdownEl.innerHTML = hours < 1 ? `${minutes}:${seconds} time left` : `${hours}:${minutes}:${seconds} time left`;
            durationEl.value = time;

            // Lưu thời gian vào Local Storage
            // localStorage.setItem(`examTime${examIdInput}`, time);

            if (time === 300) {
                alert("You only have 5 minutes left.");
            }

            if (time === 0) {
                alert("Your exam has been auto submitted.");
                clearInterval(intervalId);
                examForm.submit();
            }

            // Giảm thời gian
            time--;
        }

        // // Xử lý sự kiện trước khi người dùng rời khỏi trang
        // window.addEventListener('beforeunload', function() {
        //     // Xóa thời gian từ Local Storage khi người dùng rời khỏi trang
        //     localStorage.removeItem('examTime');
        // });

        function showSubmitBtn(selectedQuestion) {
            if (selectedQuestion == $('.question').length - 1) {
                // Hiển thị btn submit
                $(`.submit-btn`).removeClass('d-none').addClass('d-block');
                // Ẩn btn next
                $(`.next-btn`).removeClass('d-block').addClass('d-none');
                // Hiện btn prev
                $(`.prev-btn`).removeClass('d-none').addClass('d-block');
            } else if (selectedQuestion == 0) {
                // Ẩn btn submit
                $(`.submit-btn`).removeClass('d-block').addClass('d-none');
                // Hiện btn next
                $(`.next-btn`).removeClass('d-none').addClass('d-block');
                // Ẩn btn prev
                $(`.prev-btn`).removeClass('d-block').addClass('d-none');
            } else if (selectedQuestion < $('.question').length - 1) {
                // Ẩn btn submit
                $(`.submit-btn`).removeClass('d-block').addClass('d-none');
                // Hiện btn next
                $(`.next-btn`).removeClass('d-none').addClass('d-block');
                // Hiện btn prev
                $(`.prev-btn`).removeClass('d-none').addClass('d-block');
            }
        }

        // Xử lý sự kiện khi click vào radio button câu hỏi
        $('input[type=radio].question-checkbox').click(function () {
            // Lấy giá trị của câu hỏi đã chọn
            const questionInput = $(this).attr('name');
            const selectedQuestion = $(this).val();

            showSubmitBtn(selectedQuestion)

            // Kiểm tra xem đã có câu hỏi này hay chưa
            const existingQuestion = localStorage.getItem(questionInput);
            // Nếu chưa có câu hỏi hoặc câu hỏi khác với câu hỏi trước đó, thì lưu mới
            if (!existingQuestion || existingQuestion !== selectedQuestion) {
                // localStorage.setItem(questionInput, selectedQuestion);
            }

            // xóa thuộc tính checked từ tất cả các ô input radio
            $('input[type=radio].question-checkbox').prop('checked', false);

            // Hiển thị thuộc tính checked cho ô input cụ thể được chọn
            $(this).prop("checked", true);

            // Ẩn tất cả các câu hỏi
            $('.question').addClass('d-none');

            // Hiển thị câu hỏi đã chọn
            $(`.question[data-question="${selectedQuestion}"]`).removeClass('d-none').addClass('d-flex');
        });

        // Xử lý sự kiện khi click vào next câu hỏi
        $('.next-btn').click(function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Lấy giá trị của radio button đã chọn
            const selectedQuestion = $('input[type=radio].question-checkbox:checked').val();

            // Nếu có radio button được chọn
            if (selectedQuestion !== undefined) {
                // Tăng giá trị lên 1 để lấy câu hỏi tiếp theo
                const nextQuestion = parseInt(selectedQuestion) + 1;

                // Kiểm tra không vượt quá số lượng câu hỏi
                if (nextQuestion <= $('.question').length - 1) {
                    // Ẩn tất cả các câu hỏi và xóa thuộc tính checked
                    $('.question').addClass('d-none');
                    $('input[type=radio].question-checkbox').prop('checked', false);

                    // Hiển thị câu hỏi tiếp theo
                    $(`.question[data-question="${nextQuestion}"]`).removeClass('d-none').addClass('d-flex');
                    $(`input[type=radio].question-checkbox[data-question="${nextQuestion}"]`).prop("checked", true);

                    showSubmitBtn(nextQuestion)
                } else {
                    console.log("You are already at the last question.");
                }
            } else {
                // Hiển thị thông báo hoặc xử lý khi không có radio button được chọn
                console.log("Please select a question before proceeding to the next one.");
            }
        });

        // Xử lý sự kiện khi click vào prev câu hỏi
        $('.prev-btn').click(function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Lấy giá trị của radio button đã chọn
            const selectedQuestion = $('input[type=radio].question-checkbox:checked').val();

            // Nếu có radio button được chọn
            if (selectedQuestion !== undefined) {
                // Giảm giá trị đi 1 để lấy câu hỏi trước đó
                const prevQuestion = parseInt(selectedQuestion) - 1;

                // Kiểm tra không lùi quá câu hỏi đầu tiên
                if (prevQuestion >= 0) {
                    // Ẩn tất cả các câu hỏi và xóa thuộc tính checked
                    $('.question').addClass('d-none');
                    $('input[type=radio].question-checkbox').prop('checked', false);

                    // Hiển thị câu hỏi trước đó
                    $(`.question[data-question="${prevQuestion}"]`).removeClass('d-none').addClass('d-flex');
                    $(`input[type=radio].question-checkbox[data-question="${prevQuestion}"]`).prop("checked", true);

                    showSubmitBtn(prevQuestion)
                } else {
                    console.log("You are already at the first question.");
                }
            } else {
                // Hiển thị thông báo hoặc xử lý khi không có radio button được chọn
                console.log("Please select a question before proceeding to the prev one.");
            }
        });

        // Sự kiện change cho option checkbox và radio
        $('.option-checkbox, .option-radio').change(function() {
            // Lấy giá trị của ô input
            const selectedOption = $(this).data('option');
            // Chọn thẻ <p> tương ứng
            const questionNumber = $(`.question-container[data-index="${selectedOption}"] p.number`);
            questionNumber.css('color', 'green');
        });
        // Sự kiện change cho option text
        $('.option-text').on('input', function() {
            // Lấy giá trị của ô input
            const selectedOption = $(this).data('option');
            // Chọn thẻ <p> tương ứng
            const questionNumber = $(`.question-container[data-index="${selectedOption}"] p.number`);
            questionNumber.css('color', 'green');
        });

        // Hiển câu hỏi từ Local Storage sau khi load lại trang --}}
        $('input[type=checkbox].question-checkbox').each(function() {
            // Lấy giá trị của câu hỏi đã chọn
            const questionInput = $(this).attr('name');
            const selectedQuestion = $(this).val();

            // Kiểm tra giá trị của từng input và hiển thị từ Local Storage
            if (selectedQuestion === localStorage.getItem(questionInput)) {
                $(this).prop('checked', true);
                console.log("set question")
            }
        });

        // Lưu các câu trả lời vào local storage
        function handleInputChange(inputType) {
            $(`input[type=${inputType}].option-${inputType}`).change(function() {
                const questionName = $(this).attr('name');
                const answerId = $(this).val();

                // Kiểm tra xem đã có câu trả lời cho câu hỏi này hay chưa
                const existingAnswer = localStorage.getItem(questionName);

                // Nếu chưa có câu trả lời hoặc câu trả lời khác với câu trả lời trước đó, thì lưu mới
                if (!existingAnswer || existingAnswer !== answerId) {
                    localStorage.setItem(questionName, answerId);
                }
            });
        }

        // Gọi hàm cho mỗi loại input
        // handleInputChange('radio');
        // handleInputChange('checkbox');
        // handleInputChange('text');

        // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // Hiển thị các câu trả lời từ Local Storage sau khi load lại trang --}}
        $('.question').each(function() {
            const radioInput = $(this).find('input[type=radio].option-radio');
            const checkboxInput = $(this).find('input[type=checkbox].option-checkbox');
            const textInput = $(this).find('input[type=text].option-text');

            const radioName = radioInput.attr('name');
            const checkboxName = checkboxInput.attr('name');
            const textName = textInput.attr('name');

            // Kiểm tra và hiển thị từ Local Storage
            const storedRadioValue = localStorage.getItem(radioName);
            if (storedRadioValue !== null && radioInput.val() === storedRadioValue) {
                radioInput.prop('checked', true);
                console.log("Set radioInput");
            }

            const storedCheckboxValue = localStorage.getItem(checkboxName);
            if (storedCheckboxValue !== null && storedCheckboxValue === 'true') {
                checkboxInput.prop('checked', true);
                console.log("Set checkboxInput");
            }

            const storedTextValue = localStorage.getItem(textName);
            if (storedTextValue !== null) {
                textInput.val(storedTextValue);
                console.log("Set textInput");
            }
        });

        // Xử lý khi nhấn nút submit
        $(examForm).submit(function(event) {
            // event.preventDefault();
            //
            // // Log dữ liệu trước khi gửi đi
            // console.log("Answers before sending:", localStorage);
            //
            // Xóa thời gian từ Local Storage khi bài thi đã kết thúc
            clearInterval(intervalId);
            localStorage.removeItem(`examTime${examIdInput}`);

            // Xóa câu hỏi từ Local Storage sau khi submit --}}
            $('input[type=checkbox].question-checkbox').each(function() {
                // Lấy giá trị của câu hỏi đã chọn
                const questionInput = $(this).attr('name');
                const selectedQuestion = $(this).val();

                // Kiểm tra giá trị của từng input và hiển thị từ Local Storage
                if (selectedQuestion === localStorage.getItem(questionInput)) {
                    localStorage.removeItem(questionInput)
                }
            });

            // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // NOT DONE YET !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // Xóa các câu trả lời từ Local Storage sau khi gửi thành công--}}
            $('.question').each(function() {
                const radioInput = $(this).find('input[type=radio].option-radio');
                const checkboxInput = $(this).find('input[type=checkbox].option-checkbox');
                const textInput = $(this).find('input[type=text].option-text');

                const radioName = radioInput.attr('name');
                const checkboxName = checkboxInput.attr('name');
                const textName = textInput.attr('name');

                // Kiểm tra và xóa từ Local Storage nếu giá trị trong Local Storage trùng với giá trị hiện tại
                if (radioInput.length > 0) {
                    localStorage.removeItem(radioName);
                    console.log("Deleted radioInput");
                }

                if (checkboxInput.length > 0) {
                    localStorage.removeItem(checkboxName);
                    console.log("Deleted checkboxInput");
                }

                if (textInput.val() === localStorage.getItem(textName)) {
                    localStorage.removeItem(textName);
                    console.log("Deleted textInput");
                }
            });

        {{--    // Tạo một đối tượng để lưu các câu trả lời--}}
            {{--    let answers = {};--}}

            {{--    // Lặp qua các câu hỏi và lấy câu trả lời tương ứng từ local storage--}}
            {{--    $('.question').each(function() {--}}
            {{--        const questionName = $(this).find('input[type=radio]').attr('name');--}}
            {{--        const answer = localStorage.getItem(questionName);--}}

            {{--        // Log để kiểm tra xem sự kiện đã được kích hoạt--}}
            {{--        console.log(`Question: ${questionName}, Answer: ${answer}`);--}}

            {{--        if (answer) {--}}
            {{--            answers[questionName] = answer;--}}
            {{--        }--}}
            {{--    });--}}

            {{--    // Kiểm tra xem có câu trả lời nào không--}}
            {{--    if (Object.keys(answers).length === 0) {--}}
            {{--        alert("Vui lòng chọn ít nhất một câu trả lời trước khi gửi.");--}}
            {{--        return;--}}
            {{--    }--}}

            {{--    // Log dữ liệu trước khi gửi đi--}}
            {{--    console.log("Answers to be sent:", answers);--}}

            {{--    let formData = new FormData();--}}
            {{--    formData.append('answers', JSON.stringify(answers));--}}

            {{--    // Log dữ liệu trước khi gửi đi--}}
            {{--    console.log("formData to be sent:", formData);--}}

            {{--    // Thêm mã CSRF vào tất cả các yêu cầu AJAX--}}
            {{--    $.ajaxSetup({--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': "{{ csrf_token() }}"--}}
            {{--        }--}}
            {{--    });--}}

            {{--    const data = --}}
            {{--    // Gửi câu trả lời từ local storage đến máy chủ Laravel--}}
            {{--    $.ajax({--}}
            {{--        url: "/exam-taking",--}}
            {{--        type: 'POST',--}}
            {{--        data: data,--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}

            {{--        success: function(data) {--}}
            {{--            console.log(data)--}}
            {{--            // Xử lý kết quả từ máy chủ Laravel--}}
            {{--            if (data.success === true) {--}}
            {{--                // Xóa các câu trả lời từ Local Storage sau khi gửi thành công--}}
            {{--                $('.question').each(function() {--}}
            {{--                    const questionName = $(this).find('input[type=radio]').attr('name');--}}
            {{--                    localStorage.removeItem(questionName);--}}
            {{--                });--}}

            {{--                alert("Bài thi đã được gửi thành công!");--}}
            {{--            } else {--}}
            {{--                alert("Có lỗi xảy ra: " + data.msg);--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function(error) {--}}
            {{--            console.error(error);--}}
            {{--            alert("Có lỗi xảy ra khi gửi yêu cầu.");--}}
            {{--        }--}}
            {{--    });--}}
        });
    });
</script>
