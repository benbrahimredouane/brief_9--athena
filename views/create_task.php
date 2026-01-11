<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>
    <h1>Create New Task</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=create_task">
        <div>
            <label>Select Sprint:</label>
            <select name="sprint_id" required>
                <option value="">Select a sprint</option>
                <?php 
              
                $sprintRepository = new SprintRepository($db);
                $sprints = $sprintRepository->getAllSprintsForUser($_SESSION['user_id'], $_SESSION['user_role']);
                
                foreach ($sprints as $sprint): 
                ?>
                    <option value="<?php echo $sprint['id']; ?>">
                        <?php echo $sprint['name']; ?> (Project: <?php echo $sprint['project_name']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label>Task Title:</label>
            <input type="text" name="title" required>
        </div>
        
        <div>
            <label>Description:</label>
            <textarea name="description" rows="4"></textarea>
        </div>
        
        <div>
            <label>Priority:</label>
            <select name="priority">
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        
        <button type="submit">Create Task</button>
    </form>
    
    <br>
    <a href="index.php?action=dashboard">← Back to Dashboard</a>
</body>
</html>