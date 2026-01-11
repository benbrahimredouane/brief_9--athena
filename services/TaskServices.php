<?php
class TaskService {
    private $taskRepository;
    private $notificationService;

    public function __construct($taskRepository, $notificationService) {
        $this->taskRepository = $taskRepository;
        $this->notificationService = $notificationService;
    }

    public function createTask($sprintId, $title, $description, $priority, $assigneeId, $creatorId) {
        if ($this->taskRepository->existsInSprint($sprintId, $title)) {
            throw new TaskException("Task with this title already exists in the sprint");
        }

        $success = $this->taskRepository->create($sprintId, $title, $description, $priority, $assigneeId, $creatorId);
        
        if ($success && $assigneeId) {
            $this->notificationService->sendTaskAssignmentNotification($assigneeId, $title);
        }

        $this->logAction($creatorId, "Created task: $title");

        return $success;
    }

    public function updateTask($taskId, $data, $userId) {
        $task = $this->taskRepository->findById($taskId);
        
        if (!$task) {
            throw new TaskException("Task not found");
        }

        $oldAssignee = $task['assignee_id'];
        
        $success = $this->taskRepository->update(
            $taskId,
            $data['title'],
            $data['description'],
            $data['priority'],
            $data['status'],
            $data['assignee_id']
        );

        if ($success && $oldAssignee != $data['assignee_id'] && $data['assignee_id']) {
            $this->notificationService->sendTaskAssignmentNotification($data['assignee_id'], $data['title']);
        }

        if ($success && $task['status'] != $data['status']) {
            $this->notificationService->sendStatusChangeNotification($task['assignee_id'], $data['title'], $data['status']);
        }

        $this->logAction($userId, "Updated task: " . $data['title']);

        return $success;
    }

    public function deleteTask($taskId, $userId) {
        $task = $this->taskRepository->findById($taskId);
        
        if (!$task) {
            throw new TaskException("Task not found");
        }

        $success = $this->taskRepository->delete($taskId);
        
        if ($success) {
            $this->logAction($userId, "Deleted task: " . $task['title']);
        }

        return $success;
    }

    public function changeTaskStatus($taskId, $status, $userId) {
        $task = $this->taskRepository->findById($taskId);
        
        if (!$task) {
            throw new TaskException("Task not found");
        }

        $success = $this->taskRepository->updateStatus($taskId, $status);
        
        if ($success) {
            $this->notificationService->sendStatusChangeNotification($task['assignee_id'], $task['title'], $status);
            $this->logAction($userId, "Changed task status: " . $task['title'] . " to " . $status);
        }

        return $success;
    }

    private function logAction($userId, $action) {
        $db = $this->taskRepository->getConnection();
        $query = "INSERT INTO logs (user_id, action) VALUES (:user_id, :action)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    }
}

class TaskException extends Exception {}