<!DOCTYPE html>
<html>
<head>
    <title>Task Details</title>
    <style>
        .comment { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
        .comment-header { display: flex; justify-content: space-between; }
        .delete-link { color: red; }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($task['title']); ?></h1>
    
    <div>
        <p><strong>Status:</strong> <?php echo $task['status']; ?></p>
        <p><strong>Priority:</strong> <?php echo $task['priority']; ?></p>
        <p><strong>Assigned to:</strong> <?php echo $task['assignee_name'] ?? 'Unassigned'; ?></p>
        <p><strong>Description:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
    </div>

    <hr>
    
    <h2>Comments (<?php echo count($comments); ?>)</h2>
    
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="comment-header">
                    <strong><?php echo htmlspecialchars($comment->getUsername()); ?></strong>
                    <small><?php echo $comment->getCreatedAt(); ?></small>
                </div>
                
                <?php if ($comment->canDelete($_SESSION['user_id'], $_SESSION['user_role'])): ?>
                    <a href="index.php?action=delete_comment&id=<?php echo $comment->getId(); ?>&task_id=<?php echo $task['id']; ?>" 
                       class="delete-link"
                       onclick="return confirm('Delete this comment?')">
                        Delete
                    </a>
                <?php endif; ?>
                
                <p><?php echo nl2br(htmlspecialchars($comment->getContent())); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>

    <h3>Add a Comment</h3>
    <form method="POST" action="index.php?action=add_comment">
        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
        <textarea name="content" rows="4" style="width: 100%;" required 
                  placeholder="Write your comment here..."></textarea><br>
        <button type="submit">Post Comment</button>
    </form>

    <br>
    <a href="index.php?action=dashboard">← Back to Dashboard</a>
</body>
</html>