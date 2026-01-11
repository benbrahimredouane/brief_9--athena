<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Manage Users</title>
    <style>
        /* 1. Base Setup (Same as Dashboard for consistency) */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* 2. Sidebar Navigation */
        .sidebar {
            width: 260px;
            background-color: #1e1b4b;
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar__brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 40px;
            color: #818cf8;
        }

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
        .sidebar__link:hover, .sidebar__link--active {
            background-color: #312e81;
            color: white;
        }

        /* 3. Content Area */
        .main {
            flex: 1;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* 4. Table Styling */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 16px; font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; }

        /* 5. Status Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .badge--active { background: #dcfce7; color: #166534; }
        .badge--inactive { background: #fee2e2; color: #991b1b; }

        /* 6. Action Buttons */
        .btn-toggle {
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            transition: 0.2s;
        }
        .btn-toggle--deactivate { color: #dc2626; border: 1px solid #fca5a5; }
        .btn-toggle--deactivate:hover { background: #fef2f2; }
        
        .btn-toggle--activate { color: #2563eb; border: 1px solid #93c5fd; }
        .btn-toggle--activate:hover { background: #eff6ff; }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=admin_dashboard">Dashboard</a></li>
                <li><a class="sidebar__link sidebar__link--active" href="index.php?action=admin_users">Manage Users</a></li>
                <li><a class="sidebar__link" href="index.php?action=admin_projects">Manage Projects</a></li>
                <li><a class="sidebar__link" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <div class="header">
            <h1>Manage Users</h1>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Details</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td style="color: #94a3b8;">#<?php echo $user['id']; ?></td>
                        <td>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($user['username']); ?></div>
                            <div style="font-size: 0.8rem; color: #64748b;"><?php echo htmlspecialchars($user['email']); ?></div>
                        </td>
                        <td>
                            <span style="text-transform: capitalize;"><?php echo $user['role']; ?></span>
                        </td>
                        <td>
                            <?php if ($user['is_active']): ?>
                                <span class="badge badge--active">Active</span>
                            <?php else: ?>
                                <span class="badge badge--inactive">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?action=admin_toggle_user&user_id=<?php echo $user['id']; ?>" 
                               class="btn-toggle <?php echo $user['is_active'] ? 'btn-toggle--deactivate' : 'btn-toggle--activate'; ?>">
                                <?php echo $user['is_active'] ? 'Deactivate' : 'Activate'; ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?action=admin_dashboard" class="back-link">← Back to Dashboard</a>
    </main>

</body>
</html>