<?php
class Comment {
    private $id;
    private $taskId;
    private $userId;
    private $content;
    private $createdAt;
    private $username; 

    public function __construct($id, $taskId, $userId, $content, $createdAt, $username = null) {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->username = $username;
    }

    public function getId() { return $this->id; }
    public function getTaskId() { return $this->taskId; }
    public function getUserId() { return $this->userId; }
    public function getContent() { return $this->content; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUsername() { return $this->username; }

    public function canDelete($currentUserId, $currentUserRole) {
        return $currentUserId == $this->userId || 
               $currentUserRole == 'admin' || 
               $currentUserRole == 'project_leader';
    }
}
?>