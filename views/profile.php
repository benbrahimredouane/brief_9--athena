<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>
    <h1>My Profile</h1>
    
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=update_profile">
        <div>
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        
        <div>
            <label>Current Password (to confirm changes):</label>
            <input type="password" name="current_password">
        </div>
        
        <div>
            <label>New Password (leave empty to keep current):</label>
            <input type="password" name="new_password">
        </div>
        
        <div>
            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password">
        </div>
        
        <button type="submit">Update Profile</button>
    </form>
    
    <br>
    <a href="index.php?action=dashboard">Back to Dashboard</a>
</body>
</html>