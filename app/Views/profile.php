<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        form {
            margin: 0 auto;
            max-width: 500px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profile</h1>
        
        <?php if (session()->has('validation')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> <?= session('validation')->listErrors() ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> <?= session('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
        
        <form method="post" action="<?php echo base_url('public/update-profile');?>" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <label for="new_password">New Password (optional):</label>
            <input type="password" name="new_password" id="new_password">

            <label for="confirm_password">Confirm New Password (optional):</label>
            <input type="password" name="confirm_password" id="confirm_password">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <script>
        const newPassword = document.getElementById('new_password');
        const confirmNewPassword = document.getElementById('confirm_password');
       //added the event listener to the new password field and do the validation
        newPassword.addEventListener('input', () => {
            if (newPassword.value !== '') {
                confirmNewPassword.setAttribute('required', 'true');
            } else {
                confirmNewPassword.removeAttribute('required');
            }
        });

        //added the event listener to the profile picture  field and do the validation
        const profilePicture = document.getElementById('profile_picture');

        profilePicture.addEventListener('change', () => {
            const allowedExtensions = ['.jpg', '.jpeg', '.png'];
            const maxSizeInBytes = 800 * 1024; // 800 KB

            const file = profilePicture.files[0];
            const fileName = file.name;
            const fileExtension = fileName.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes('.' + fileExtension)) {
            alert('Invalid file format. Please select a JPG, JPEG, or PNG file.');
            profilePicture.value = '';
            return;
        }

        if (file.size > maxSizeInBytes) {
            alert('File size exceeds the maximum allowed (800 KB). Please select a smaller file.');
            profilePicture.value = ''; 
        }
});

    <!-- JavaScript (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

        </script>
    </body>

    </html>
