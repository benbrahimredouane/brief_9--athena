<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    
  
<form method="GET" action="index.php">
    <input type="hidden" name="action" value="search_tasks">
    
    <input type="text" name="q" placeholder="Search tasks..." value="<?php echo $_GET['q'] ?? ''; ?>">
    
    <select name="status">
        <option value="">All Status</option>
        <option value="todo" <?php echo ($_GET['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>To Do</option>
        <option value="in_progress" <?php echo ($_GET['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
        <option value="done" <?php echo ($_GET['status'] ?? '') == 'done' ? 'selected' : ''; ?>>Done</option>
    </select>
    
    <select name="priority">
        <option value="">All Priority</option>
        <option value="low" <?php echo ($_GET['priority'] ?? '') == 'low' ? 'selected' : ''; ?>>Low</option>
        <option value="medium" <?php echo ($_GET['priority'] ?? '') == 'medium' ? 'selected' : ''; ?>>Medium</option>
        <option value="high" <?php echo ($_GET['priority'] ?? '') == 'high' ? 'selected' : ''; ?>>High</option>
    </select>
    
    <select name="project_id">
        <option value="">All Projects</option>
        <?php 
        $projectRepository = new ProjectRepository($db);
        $projects = $projectRepository->getAllProjects();
        foreach ($projects as $project): 
        ?>
            <option value="<?php echo $project['id']; ?>" 
                <?php echo ($_GET['project_id'] ?? '') == $project['id'] ? 'selected' : ''; ?>>
                <?php echo $project['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit">Search</button>
</form>
    
    <?php if (!empty($tasks)): ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Assignee</th>
            </tr>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo $task['title']; ?></td>
                    <td><?php echo $task['description']; ?></td>
                    <td><?php echo $task['status']; ?></td>
                    <td><?php echo $task['priority']; ?></td>
                    <td><?php echo $task['assignee_name'] ?? 'Unassigned'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
    
    <a href="index.php?action=dashboard">Back to Dashboard</a>
</body>
</html>