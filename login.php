<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2 class="mb-4">User Login</h2>
                <div id="message-box"></div>

                <form id="login-form" enctype="multipart/form-data" method="post" class="card p-4 shadow" autocomplete="off">
                    <div class="mb-3">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" >
                    </div>

                    <button class="btn btn-primary" type="submit">Login</button>
                    <div class="text-end mt-2"><a href="register.php">Don't have an account? Register here</a></div>
                </form>
            </div>
        </div>

    </div>
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#login-form").validate({
                rules: {
                    email: { required: true, email: true },
                    password: { required: true, minlength: 4 },
                },
                messages: {
                    email: "Enter a valid email",
                    password: {
                        required: "Password is required",
                        minlength: "Minimum 4 characters"
                    },
                },
                submitHandler: function (form, event) {
                    event.preventDefault();

                    const formData = new FormData(form);
                    formData.append('action', 'login');

                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (response) {
                            $('#message-box').empty();
                            if (response.success) {
                                $("#message-box").html('<div class="alert alert-success" role="alert">Login Successfully.</div>');
                                $(form)[0].reset();
                                setTimeout(function(){ window.location.href='./dashboard.php'; }, 1000);
                            } else {
                                response.errors.forEach(error => {
                                    $("#message-box").append(`<div class="alert alert-danger " role="alert">${error}</div>`);
                                });
                                $('#password').val('');
                            }
                            $('html, body').animate({ scrollTop: 0 }, 'fast');
                        },
                        error: function () {
                            $("#message-box").html('<div class="alert alert-danger">Server error occurred</div>');
                        }
                    });

                    return false;
                }
            });
        });
    </script>
</body>
</html>
