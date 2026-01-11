<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Create Task</title>
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
        .sidebar__link:hover { background-color: #312e81; color: white; }

        .main { flex: 1; padding: 40px; display: flex; flex-direction: column; align-items: flex-start; }
        
        .header { margin-bottom: 30px; }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            width: 100%;
            max-width: 600px;
        }

        .error-msg {
            background-color: #fff1f0;
            color: #d85140;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid #ffa39e;
        }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 8px; }

        input[type="text"], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        textarea { resize: vertical; min-height: 120px; }

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
        }
        .btn-submit:hover { background-color: #4f46e5; }

        .back-link {
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .back-link:hover { color: #6366f1; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=dashboard">Dashboard</a></li>
                <li><a class="sidebar__link" href="index.php?action=search_tasks">Search Tasks</a></li>
                <li><a class="sidebar__link" href="index.php?action=profile">My Profile</a></li>
                <li><a class="sidebar__link" style="color: #fda4af;" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <div class="header">
            <h1>Create New Task</h1>
            <p style="color: #64748b;">Add a new piece of work to your sprint</p>
        </div>

        <div class="card">
            <?php if (isset($error)): ?>
                <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?action=create_task">
                <div class="form-group">
                    <label>Select Sprint</label>
                    <select name="sprint_id" required>
                        <option value="">Choose a sprint...</option>
                        <?php 
                        $sprintRepository = new SprintRepository($db);
                        $sprints = $sprintRepository->getAllSprintsForUser($_SESSION['user_id'], $_SESSION['user_role']);
                        foreach ($sprints as $sprint): 
                        ?>
                            <option value="<?php echo $sprint['id']; ?>">
                                <?php echo htmlspecialchars($sprint['name']); ?> — (<?php echo htmlspecialchars($sprint['project_name']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Task Title</label>
                    <input type="text" name="title" placeholder="e.g., Design Login Interface" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the requirements or steps..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">Create Task</button>
            </form>
        </div>

        <a href="index.php?action=dashboard" class="back-link">← Back to Dashboard</a>
    </main>

</body>
</html>