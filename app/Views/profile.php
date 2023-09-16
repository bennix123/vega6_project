<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
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
        <form method="post" action="<?php echo base_url('public/update-profile');?>" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture">

            <label for="new_password">New Password (optional):</label>
            <input type="password" name="new_password" id="new_password">

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password">

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
