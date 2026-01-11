<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - My Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: #1e1b4b;
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar__brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 40px; color: #818cf8; }
        .sidebar__nav { list-style: none; }
        .sidebar__link {
            display: block;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .sidebar__link:hover, .sidebar__link--active { background-color: #312e81; color: white; }

        .main { flex: 1; padding: 40px; }
        
        .header { margin-bottom: 30px; }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            max-width: 600px;
        }

        .msg {
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid;
        }
        .msg--success { background-color: #f0fdf4; color: #166534; border-color: #bbf7d0; }
        .msg--error { background-color: #fff1f0; color: #d85140; border-color: #ffa39e; }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 8px; }

        input {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
        }

        input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .password-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #e2e8f0;
        }

        .btn-submit {
            background-color: #6366f1;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
            font-size: 1rem;
            margin-top: 10px;
        }
        .btn-submit:hover { background-color: #4f46e5; }

        .back-link { display: inline-block; margin-top: 20px; color: #6366f1; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=dashboard">Dashboard</a></li>
                <li><a class="sidebar__link" href="index.php?action=search_tasks">Search Tasks</a></li>
                <li><a class="sidebar__link sidebar__link--active" href="index.php?action=profile">My Profile</a></li>
                <li><a class="sidebar__link" style="color: #fda4af;" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <div class="header">
            <h1>Account Settings</h1>
            <p style="color: #64748b;">Update your personal information and password</p>
        </div>

        <div class="card">
            <?php if (isset($success)): ?>
                <div class="msg msg--success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="msg msg--error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=update_profile">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                
                <div class="password-section">
                    <div class="form-group">
                        <label>Current Password <span style="font-weight: normal; color: #94a3b8;">(Required to save changes)</span></label>
                        <input type="password" name="current_password">
                    </div>
                    
                    <div class="form-group">
                        <label>New Password <span style="font-weight: normal; color: #94a3b8;">(Leave blank to keep current)</span></label>
                        <input type="password" name="new_password">
                    </div>
                    
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password">
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>

        <a href="index.php?action=dashboard" class="back-link">← Back to Dashboard</a>
    </main>

</body>
</html>