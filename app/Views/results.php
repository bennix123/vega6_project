\<!-- app/Views/search_view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
</head>
<body>
    <h1>Search Page</h1>
    <form action="<?= base_url('public/search_result') ?>" method="post">
        <label for="search">Search:</label>
        <input type="text" id="search" name="query" required>
        <button type="submit">Search</button>
    </form>

    <?php if (isset($results)): ?>
        <h2>Search Results for: <?= $query ?></h2>
        <?php if (!empty($results)): ?>
            <ul>
                <?php foreach ($results as $result): ?>
                    <li><?= $result ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
