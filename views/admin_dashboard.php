<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?> (Admin)</p>
    <li><a href="index.php?action=profile">My Profile</a></li>

    <h3>Statistics</h3>
    <ul>
        <li>Total Users: <?php echo $stats['users']; ?></li>
        <li>Total Projects: <?php echo $stats['projects']; ?></li>
        <li>Active Projects: <?php echo $stats['active_projects']; ?></li>
        <li>Total Sprints: <?php echo $stats['sprints']; ?></li>
        <li>Total Tasks: <?php echo $stats['tasks']; ?></li>
    </ul>

    <h3>Recent Logs</h3>
    <?php if (!empty($logs)): ?>
        <table border="1">
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['username'] ?? 'System'; ?></td>
                    <td><?php echo $log['action']; ?></td>
                    <td><?php echo $log['created_at']; ?></td>
                  
                    <td>
                        <a href="index.php?action=view_task&id=<?php echo $task['id']; ?>">View</a>
                     
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>Admin Actions</h3>
    <ul>
        <li><a href="index.php?action=admin_users">Manage Users</a></li>
        <li><a href="index.php?action=admin_projects">Manage Projects</a></li>
        <li><a href="index.php?action=logout">Logout</a></li>
    </ul>
</body>

</html>