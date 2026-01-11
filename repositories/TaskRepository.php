<?php
class TaskRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
   public function getConnection() {
        return $this->db;
    }
   public function create($sprintId, $title, $description, $priority, $assigneeId, $creatorId) {
    
    if ($this->existsInSprint($sprintId, $title)) {
        throw new Exception("A task with this title already exists in the selected sprint.");
    }
    
    $query = "INSERT INTO tasks (sprint_id, title, description, priority, assignee_id, creator_id) 
              VALUES (:sprint_id, :title, :description, :priority, :assignee_id, :creator_id)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':sprint_id', $sprintId);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':priority', $priority);
    $stmt->bindParam(':assignee_id', $assigneeId);
    $stmt->bindParam(':creator_id', $creatorId);
    return $stmt->execute();
}

    public function findById($taskId) {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($taskId, $title, $description, $priority, $status, $assigneeId) {
        $query = "UPDATE tasks SET title = :title, description = :description, priority = :priority, 
                  status = :status, assignee_id = :assignee_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':assignee_id', $assigneeId);
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    public function delete($taskId) {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

 public function searchTasks($filters, $page = 1, $limit = 10) {
    // Ensure integers
    $page = (int)$page;
    $limit = (int)$limit;
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT t.*, u.username as assignee_name, p.name as project_name 
              FROM tasks t
              LEFT JOIN users u ON t.assignee_id = u.id
              LEFT JOIN sprints s ON t.sprint_id = s.id
              LEFT JOIN projects p ON s.project_id = p.id
              WHERE 1=1";
    
    $params = [];
    
    if (!empty($filters['q'])) {
        $query .= " AND (t.title LIKE :q OR t.description LIKE :q)";
        $params[':q'] = "%{$filters['q']}%";
    }
    
    if (!empty($filters['status'])) {
        $query .= " AND t.status = :status";
        $params[':status'] = $filters['status'];
    }
    
    if (!empty($filters['priority'])) {
        $query .= " AND t.priority = :priority";
        $params[':priority'] = $filters['priority'];
    }
    
    if (!empty($filters['project_id'])) {
        $query .= " AND s.project_id = :project_id";
        $params[':project_id'] = (int)$filters['project_id'];
    }
    
    if (!empty($filters['assignee_id'])) {
        $query .= " AND t.assignee_id = :assignee_id";
        $params[':assignee_id'] = (int)$filters['assignee_id'];
    }
    
    $query .= " LIMIT :limit OFFSET :offset";
    
    $stmt = $this->db->prepare($query);
    
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function getTasksBySprint($sprintId) {
        $query = "SELECT t.*, u.username as assignee_name FROM tasks t 
                  LEFT JOIN users u ON t.assignee_id = u.id 
                  WHERE t.sprint_id = :sprint_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sprint_id', $sprintId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($taskId, $status) {
        $query = "UPDATE tasks SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $taskId);
        return $stmt->execute();
    }

    public function existsInSprint($sprintId, $title) {
        $query = "SELECT COUNT(*) as count FROM tasks WHERE sprint_id = :sprint_id AND title = :title";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sprint_id', $sprintId);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
