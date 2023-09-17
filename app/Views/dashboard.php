<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
        }

        .header h1 {
            font-size: 36px;
            margin: 0;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h2 {
            font-size: 24px;
            margin: 0;
        }

        .menu {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin-right: 20px;
        }

        .menu a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 20px;
    border: 4px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease-in-out;
}

.profile-image:hover {
    transform: scale(1.1);
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?= $user['name'] ?></h1>
        </div>
        <a href="<?= base_url('public/profile') ?>">
        <img src="data:image/jpeg;base64,<?= $user['profile_photo'] ?>" alt="<?= $user['name'] ?>'s Profile Image" class="profile-image">
    </a>
        <div class="profile">
        
    </div>
        </a>
            <div class="profile-info">
                <h2><?= $user['name'] ?></h2>
                <p><?= $user['email'] ?></p>
            </div>
        <ul class="menu">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="<?= base_url('public/search_result') ?>">Search</a></li>
        </ul>
    </div>
</body>
</html>
