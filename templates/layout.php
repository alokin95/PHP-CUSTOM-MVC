<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Title</title>
</head>
<body>
    <h1>Welcome</h1>
    <?php if (!session('user')) : ?>
        <form action="/login" method="POST">
            <input type="text" name="username">
            <input type="password" name="password">
            <input type="submit" value="Login">
        </form>
    <?php endif; ?>
</body>
</html>