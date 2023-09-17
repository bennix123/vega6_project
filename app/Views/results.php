
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
        <label for="include_video">Show Videos</label>
    <input type="checkbox" id="show_video" name="include_video" value="1">
        <button type="submit">Search</button>
    </form>

    <?php if (isset($results)): ?>
    <?php if (!empty($results)): ?>
        <div id="imageGallery">
            <?php if (!array_key_exists('videos', $results['hits'][0])): ?>
                <?php foreach ($results['hits'] as $image): ?>
                    <div class="image-card">
                        <img src="<?= $image['previewURL'] ?>" alt="<?= $image['tags'] ?>">
                        <p>
                            Likes: <?= $image['likes'] ?><br>
                            Downloads: <?= $image['downloads'] ?><br>
                            Comments: <?= $image['comments'] ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($results['hits'] as $image): ?>
                    <div class="image-card">
    <a href="<?= $image['videos']['large']['url'] ?>" target="_blank">
        <img src="<?= $image['userImageURL'] ?>" alt="<?= $image['tags'] ?>">
    </a>
    <p>
        Likes: <?= $image['likes'] ?><br>
        Downloads: <?= $image['downloads'] ?><br>
        Comments: <?= $image['comments'] ?>
    </p>
</div>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
