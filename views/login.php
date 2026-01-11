<!DOCTYPE html>
<html>
<head>
    <title>Athena - Login</title>
</head>
<body>

    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?action=login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="index.php?action=register">Register</a></p>
</body>
</html>