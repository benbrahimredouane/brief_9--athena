<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
</head>
<body>
    <h1>Edit Project</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=update_project">
        <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
        
        <div>
            <label>Project Name:</label>
            <input type="text" name="name" value="<?php echo $project['name']; ?>" required>
        </div>
        
        <div>
            <label>Description:</label>
            <textarea name="description"><?php echo $project['description']; ?></textarea>
        </div>
        
        <div>
            <label>Project Leader:</label>
            <select name="leader_id" required>
                <?php foreach ($allUsers as $user): ?>
                    <option value="<?php echo $user['id']; ?>" 
                        <?php echo ($user['id'] == $project['leader_id']) ? 'selected' : ''; ?>>
                        <?php echo $user['username']; ?> (<?php echo $user['email']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label>Status:</label>
            <select name="is_active">
                <option value="1" <?php echo ($project['is_active']) ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo (!$project['is_active']) ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        
        <button type="submit">Update Project</button>
    </form>
    
    <h3>Project Members</h3>
    <?php if (!empty($project['members'])): ?>
        <ul>
            <?php foreach ($project['members'] as $member): ?>
                <li>
                    <?php echo $member['username']; ?> (<?php echo $member['email']; ?>)
                    <?php if ($member['id'] != $project['leader_id']): ?>
                        <a href="index.php?action=remove_member&project_id=<?php echo $project['id']; ?>&user_id=<?php echo $member['id']; ?>">
                            Remove
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No members yet.</p>
    <?php endif; ?>
    
    <br>
    <a href="index.php?action=admin_projects">Back to Projects</a>
</body>
</html>