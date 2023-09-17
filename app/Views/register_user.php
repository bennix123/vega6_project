<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background: url('assests/vega6.jpeg') no-repeat center center fixed;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="file"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .btn-register {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form id="registrationForm"  method="post" enctype="multipart/form-data">
        <input type='hidden' name="is_registeration_process" value='yes'>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="profilePhoto">Profile Photo (optional):</label>
                <input type="file" id="profilePhoto" name="profilePhoto">
                <span class="error" id="fileError" style="color: red;"></span>
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- JavaScript (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function () {
    $('#registrationForm').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const fileInput = document.getElementById("profilePhoto");
        const file = fileInput.files[0];
        // Doing validation to accept only jpg, jpeg, or png files
                if (file) {
            const fileName = file.name;
            const fileExtension = fileName.split(".").pop().toLowerCase();
            const maxSizeInBytes = 800 * 1024; // 800 KB
            //if the file size is more than 800 kb we will show file size error
            if (file.size > maxSizeInBytes) {
                $('#fileError').text("File size exceeds the maximum allowed (800 KB). Please select a smaller file.");
                return;
            }
        //else proceeding with validation of file type
            if (fileExtension !== "jpg" && fileExtension !== "jpeg" && fileExtension !== "png") {
                $('#fileError').text("Invalid file format. Please select a JPG, JPEG, or PNG file.");
                return;
            }
        }

        $('#fileError').text("");
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('public/registration'); ?>',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                //on response status as false we will show the alert message.
                if (!response.status) {
                    alert(response.message);
                } else {
                    //on success we will redirect the user to profile page.
                    window.location.href = '<?php echo base_url('public/login'); ?>';
                }
            },
            error: function (error) {
                //on error response will be shown on console.
                console.error(error);
            }
        });
    });
});
</script>
</body>
</html>
