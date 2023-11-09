<script>
    $(document).ready(function () {
        function submitForm(action) {
            // Lấy questionId
            const questionId = $("#inputQuestionId").val();
            // Kiểm tra giá trị của type_of_question
            const typeOfQuestion = $("#inputTypeOfQuestion").val();

            if ($('.options').length === 0) {
                $('.option-error').text("Please add at least 1 options.")
                setTimeout(function () {
                    $('.option-error').text("")
                }, 3000)
            } else {
                let checkIsCorrect = false;
                let isCorrectCounter = 0;
                for (let i = 0; i < $(".is_correct").length; i++) {
                    const isCorrectInput = $(".is_correct:eq(" + i + ")");
                    if (isCorrectInput.prop('checked') === true) {
                        checkIsCorrect = true;
                        isCorrectCounter++;

                        if (!validateOptions(typeOfQuestion, isCorrectCounter)) {
                            return; // Ngăn chặn submit
                        }

                        const optionTextValue = isCorrectInput.closest('.options').find('input[name="option_text[]"]').val();
                        isCorrectInput.val(optionTextValue);
                    }
                }

                if (typeOfQuestion === "1" && isCorrectCounter < 2) {
                    $('.option-error').text(`Please add more than 1 option for Multiple choice type.`);
                    setTimeout(function () {
                        $('.option-error').text("");
                    }, 3000);
                    return;
                }

                if (checkIsCorrect) {
                    const formData = action === "add" ? $("#addQnAForm").serialize() : $("#editQnAForm").serialize();
                    const url = action === "add" ? "admin/question-add" : `admin/question-edit/${questionId}`;
                    const type = action === "add" ? "POST" : "PUT";

                    // Thêm mã CSRF vào tất cả các yêu cầu AJAX
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });

                    $.ajax({
                        url: url,
                        type: type,
                        data: formData,
                        success: function (data) {
                            if (data.success === true) {
                                window.location.href = "admin/admin-question";
                            } else {
                                alert(data.msg);
                            }
                        }
                    });
                } else {
                    $('.option-error').text("Please select at least 1 correct options.")
                    setTimeout(function () {
                        $('.option-error').text("")
                    }, 3000);
                }
            }
        }

        // Sự kiện submit cho thêm
        $("#addQnAForm").submit(function (e) {
            e.preventDefault();
            submitForm("add");
        });

        // Sự kiện submit cho sửa
        $("#editQnAForm").submit(function (e) {
            e.preventDefault();
            submitForm("edit");
        });


        // check validate options
        function validateOptions(typeOfQuestion, isCorrectCounter) {
            const maxCorrectOptions = typeOfQuestion === "2" || typeOfQuestion === "3" ? 1 : $(".is_correct").length - 1;
            const minOptions = typeOfQuestion === "3" ? 1 : 2;
            const maxOptions = typeOfQuestion === "3" ? 1 : $(".is_correct").length;

            if (isCorrectCounter > maxCorrectOptions) {
                const errorMsg = `You can select Maximum ${maxCorrectOptions} correct option for ${typeOfQuestion === "1" ? "Multiple choice" : "One choice"} type.`;
                $('.option-error').text(errorMsg);
                setTimeout(function () {
                    $('.option-error').text("");
                }, 3000);
                return false;
            }

            if ($(".is_correct").length > maxOptions) {
                const errorMsg = "You can add Maximum 1 option for Fill in blank type.";
                $('.option-error').text(errorMsg);
                setTimeout(function () {
                    $('.option-error').text("");
                }, 3000);
                return false;
            }

            if ($(".is_correct").length < minOptions) {
                $('.option-error').text(`Please add more than ${minOptions} option for ${typeOfQuestion === "3" ? "Fill in blank" : typeOfQuestion === "2" ? "One choice" : "Multiple choice"} type.`);
                setTimeout(function () {
                    $('.option-error').text("");
                }, 3000);
                return false;
            }

            return true;
        }

        // add an option
        let isCorrectCounter = 2;
        $("#addOption-btn").click(function () {
            // Kiểm tra giá trị của type_of_question
            const typeOfQuestion = $("#inputTypeOfQuestion").val();
            if (typeOfQuestion === "3") {
                // Nếu loại câu hỏi là "Fill in blank", không cho phép thêm option
                $('.option-error').text("Cannot add options for Fill in blank type.")
                setTimeout(function () {
                    $('.option-error').text("")
                }, 3000)
                return;
            }

            if (typeOfQuestion === null) {
                // Nếu loại câu hỏi là null, không cho phép thêm option
                $('.option-error').text("Please choose a Type Of Question before do this.")
                setTimeout(function () {
                    $('.option-error').text("")
                }, 3000)
                return;
            }

            // Tiếp tục thêm option nếu không phải là loại "Fill in blank"
            let html = `
                <li class="d-inline-flex options">
                    <span class="handle d-inline-flex mt-2">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary ml-2">
                        <input
                            id="is_correct${isCorrectCounter}"
                            type="checkbox"
                            name="is_correct[]"
                            class="is_correct"
                            value="">
                        <label for="is_correct${isCorrectCounter}"></label>
                    </div>
                    <input
                        required
                        name="option_text[]"
                        value="{{ old("option_text[]") }}"
                        type="text"
                        class="form-control"
                        id="inputOption"
                        style="min-width: 475px"
                        placeholder="Enter option text"
                    >
                    <label for="inputOption"></label>
                    <div class="tools removeOption-btn mt-1 ml-1">
                        <i class="fas fa-trash"></i>
                    </div>
                </li>
                `
            isCorrectCounter ++;

            // Kiểm tra số lượng options trước khi thêm mới
            if ($('.options').length >= 9) {
                $('.option-error').text("You can add Maximum 10 options.")
                setTimeout(function () {
                    $('.option-error').text("")
                }, 3000)
                if($('.options').length === 9) {
                    $(".right-col").append(html + `<br><span class="option-error text text-danger"></span>`)
                }
            }else {
                $(".right-col").append(html)
            }
        })

        // Sự kiện click cho ô input is_correct
        $(document).on('click', '.is_correct', function() {
            // Kiểm tra giá trị của type_of_question
            const typeOfQuestion = $("#inputTypeOfQuestion").val();

            // Chỉ cho phép chọn 1 ô input làm đáp án đúng nếu là loại "One Choice"
            if (typeOfQuestion === "2") {
                // Bỏ chọn tất cả các ô input khác nếu được chọn
                if ($(this).prop('checked')) {
                    $('.is_correct').not(this).prop('checked', false);
                }
            }
        });

        // remove an option
        $(document).on("click", ".removeOption-btn", function () {
            $(this).parent().remove()
        })
    })
</script>
