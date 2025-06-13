<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h2 class="mb-4">User Registration</h2>
            <div id="message-box"></div>

            <form id="register-form" enctype="multipart/form-data" method="post" class="card p-4 shadow" autocomplete="off">
                <div class="mb-3">
                    <label>Name <span class="text-danger">*</span> </label>
                    <input type="text" name="name" class="form-control" >
                </div>
                <div class="mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" >
                </div>
                <div class="mb-3">
                    <label>Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" >
                </div>
                <div class="mb-3">
                    <label>Profile Image</label>
                    <input type="file" name="profile_image" accept="image/*" class="form-control" onchange="previewImage(event)">
                </div>
                <div class="mb-3">
                    <img id="preview" src="#" alt="Preview" style="max-width: 150px; display: none;">
                </div>
                <button class="btn btn-primary" type="submit">Register</button>
                <div class="text-end mt-2"><a href="login.php">Already have an account? Login here</a></div>
            </form>
        </div>
    </div>
</div>
<script src="./assets/js/jquery-3.6.0.min.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $("#register-form").validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                password: { required: true, minlength: 4 },
            },
            messages: {
                name: "Enter a name",
                email: "Enter a valid email",
                password: {
                    required: "Password is required",
                    minlength: "Minimum 4 characters"
                },
            },
            submitHandler: function (form, event) {
                event.preventDefault();

                const formData = new FormData(form);
                formData.append('action','register');

                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#message-box").empty();
                        if (response.success) {
                            $("#message-box").html('<div class="alert alert-success" role="alert">User Register Successfully.</div>');
                            $(form)[0].reset();
                            $('#preview').attr('src', '#').hide();
                        } else {
                            response.errors.forEach(error => {
                                $("#message-box").append(`<div class="alert alert-danger " role="alert">${error}</div>`);
                            });
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

    function previewImage(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>

</body>
</html>
