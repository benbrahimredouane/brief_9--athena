<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Admin Dashboard</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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
        }

        .sidebar__brand {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 40px;
            color: #818cf8;
        }

        .sidebar__nav {
            list-style: none;
        }

        .sidebar__link {
            display: block;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }

        .sidebar__link:hover {
            background-color: #312e81;
            color: white;
        }

        .sidebar__link--logout {
            margin-top: auto;
            color: #fda4af;
        }


        .main {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }


        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .stat-card__label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
        }

        .stat-card__value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e1b4b;
        }


        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .table-title {
            padding: 20px;
            font-weight: 700;
            border-bottom: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            padding: 15px;
            font-size: 0.85rem;
            color: #475569;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        tr:last-child td {
            border: 0;
        }

        .action-btn {
            padding: 6px 12px;
            background: #eef2ff;
            color: #4f46e5;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=admin_dashboard">Dashboard</a></li>
                <li><a class="sidebar__link" href="index.php?action=admin_users">Manage Users</a></li>
                <li><a class="sidebar__link" href="index.php?action=admin_projects">Manage Projects</a></li>
                <li><a class="sidebar__link" href="index.php?action=profile">My Profile</a></li>
                <li><a class="sidebar__link sidebar__link--logout" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <header class="header">
            <div>
                <h1>Admin Dashboard</h1>
                <p style="color: #64748b;">Welcome back, <strong><?php echo $_SESSION['username']; ?></strong></p>
            </div>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card__label">Total Users</div>
                <div class="stat-card__value"><?php echo $stats['users']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card__label">Total Projects</div>
                <div class="stat-card__value"><?php echo $stats['projects']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card__label">Active Projects</div>
                <div class="stat-card__value"><?php echo $stats['active_projects']; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-card__label">Total Tasks</div>
                <div class="stat-card__value"><?php echo $stats['tasks']; ?></div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-title">Recent Activity Logs</div>
            <?php if (!empty($logs)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><strong><?php echo $log['username'] ?? 'System'; ?></strong></td>
                                <td><?php echo $log['action']; ?></td>
                                <td><?php echo date('M j, Y', strtotime($log['created_at'])); ?></td>
                                <td>
                                    <a class="action-btn" href="index.php?action=view_task&id=<?php echo $log['id']; ?>">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="padding: 20px; color: #64748b;">No recent activity found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>