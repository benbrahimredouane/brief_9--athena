<?php
class User {
    private $id;
    private $username;
    private $email;
    private $role;
    private $isActive;

    public function __construct($id, $username, $email, $role, $isActive) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->isActive = $isActive;
    }

    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function isActive() { return $this->isActive; }

    public function canEditTask($task) {
        if ($this->role === 'admin') return true;
        if ($this->role === 'project_leader') return true;
        return $task->getAssigneeId() === $this->id || $task->getCreatorId() === $this->id;
    }

    public function canDeleteTask($task) {
        if ($this->role === 'admin') return true;
        if ($this->role === 'project_leader') return true;
        return $task->getCreatorId() === $this->id;
    }
}