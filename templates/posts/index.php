<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Posts page</title>
</head>
<body>
<h1>Posts</h1>
<?php foreach($posts as $post) : ?>
    <h4><?= $post->title ?></h4>
    <p><?= $post->body ?></p>
    <a href="<?=$post->id?>"><?=$post->title ?></a>
<?php endforeach; ?>
</body>
</html>