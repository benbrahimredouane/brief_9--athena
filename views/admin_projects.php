<!DOCTYPE html>
<html>
<head>
    <title>Manage Projects</title>
</head>
<body>
    <h1>Manage Projects</h1>
    
    <a href="index.php?action=create_project">Create New Project</a>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Leader</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($projects as $project): ?>
        <tr>
            <td><?php echo $project['id']; ?></td>
            <td><?php echo $project['name']; ?></td>
            <td><?php echo $project['leader_name']; ?></td>
            <td><?php echo $project['is_active'] ? 'Active' : 'Inactive'; ?></td>
            <td>
                <a href="index.php?action=edit_project&id=<?php echo $project['id']; ?>">Edit</a>
                <a href="index.php?action=toggle_project&id=<?php echo $project['id']; ?>">
                    <?php echo $project['is_active'] ? 'Deactivate' : 'Activate'; ?>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <a href="index.php?action=dashboard">Back to Dashboard</a>
</body>
</html>